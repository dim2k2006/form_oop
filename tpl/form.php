<?php
$fv = new FormValidate();
//$fdp = new FileDataProcessing('data/db.txt');//класс для работы с файлом
$sdp = new SqlDataProcessing('gb', 'db', 'root', '', 'localhost', 'utf8');//класс для работы с sql


if(count($_POST)>0){
	foreach($_POST as $key => $value){
		$$key=$value;
	}
	
	$fv->validField($name, '/^(\w{3,}) ?+/u','<span>Данное поле обязательно к заполнению</span>');
	$fv->validField($email, '/^([A-Za-z0-9_\.-]+)@([A-Za-z0-9_\.-]+)\.([a-z\.]{2,6})$/','<span>Данное поле обязательно к заполнению</span>');
	$fv->validField($text_message, '','<span>Данное поле обязательно к заполнению</span>');
	$fv->validCaptcha($captcha,'answer','<span class="captcha_error">Неверный ответ</span>');

	
	$canSave = true;
	foreach($fv->outPut as $value) {
		if ($value != '') {
			$canSave = false;
		} 
	}
	
	if ($canSave) {
		$date = date("F");
		$date .= ' '.date("j");
		$date .= ', '.date("Y");
		$date .= ' в '.date("G");
		$date .= ':'.date("i");
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$browser = $_SERVER['HTTP_USER_AGENT'];
		
		//$fdp->saveData($name, $email, $text_message, $date, $ip, $browser);//метод для работы с файлом
		$sdp->saveData($name, $email, $text_message, $date, $ip, $browser);//метод для работы с sql
	}
} else {
	if (isset($_COOKIE['GuestBookName']) && isset($_COOKIE['GuestBookEmail'])) {
		$fv->error[] = $_COOKIE['GuestBookName'];
		$fv->error[] = $_COOKIE['GuestBookEmail'];
	} 
}



$fg = new FormGenerate (
	//action формы
	'',
	//method формы
	'post',
	//css class формы
	'message_form',
	//id формы
	'message_form',
	//js событие формы
	'',
	//js код события
	''
);



$html .= '<h1>Отвечаю.ru</h1>';
$html .= $fg->formStart;
$html .= $fg->getInput('Имя: *'.$fv->outPut[0], 'text', 'name', 'inp', 'name', $fv->error[0]);
$html .= $fg->getInput('E-mail: *'.$fv->outPut[1], 'text', 'email', 'inp', 'email', $fv->error[1]);
$html .= $fg->getTextarea('Сообщение: *'.$fv->outPut[2], 'text_message', 'inp', 'text_message', '10', '30', $fv->error[2]);
$html .= $fg->getCaptcha('captcha', 'captcha', 'captcha');
$html .= $fv->outPut[3];
$html .= '<br><br>';
$html .= $fg->getInput('', 'reset', 'reset_button', 'form-input-button', 'reset-button', 'Очистить');
$html .= $fg->getInput('', 'submit', 'submit_button', 'form-input-button send-button', 'send-button', 'Отправить');
$html .= $fg->formEnd;
?>

