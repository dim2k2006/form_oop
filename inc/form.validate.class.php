<?php
Class FormValidate {
	public $outPut = array ();
	public $error = array ();
	
	/**
	*Проверяет поле по шаблону
	*@param string $name
	*@param string $rule
	*@param string $errorMsg
	*/
	public function validField ($name, $rule = '', $errorMsg = 'Ошибка') {
		if ($rule != '') {
			$nameRegExp = preg_match($rule, $name);
		} else {
			$nameRegExp = true;
		}
		$this->outPut[] = ($name == null || $name == " " || !$nameRegExp) ? $errorMsg : '';
		$this->error[] = $name;
	}
	
	/**
	*Проверяет поле по шаблону
	*@param string $captcha
	*@param string $sessionAddress
	*@param string $errorMsg
	*/
	public function validCaptcha ($captcha, $sessionAddress = 'captcha', $errorMsg = 'Неверный ответ') {
		$answer = $_SESSION[$sessionAddress];
		$this->outPut[] = ($captcha == $answer) ? '' : $errorMsg;
	}
}

