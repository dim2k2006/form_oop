<?php
$error = $form -> form_handler ();
$captcha = $form -> generate_captcha ();

$html .= "<h1>Отвечаю.ru</h1>
<form  action='' method='POST'>
	<span>Имя: *</span>$error[0]
	<input type='text' name='name' id='name' class='inp' value='$error[4]'>
	<span>E-mail: *</span>$error[1]
	<input type='text' name='email' id='email' class='inp' value='$error[5]'>
	<span>Сообщение: *</span>$error[2]
	<textarea name='text_message' id='text_message' class='inp' rows='10' cols='30'>$error[6]</textarea>
	<div>$captcha[0] $captcha[2] $captcha[1] = <input type='text' name='captcha' id='captcha' value=''>$error[3]</div>
	<input class='form-input-button' type='reset' value='Очистить'>
	<input class='form-input-button send-button' type='submit' value='Отправить'>
	$error[7]
	</form>
";
?>

