<?php
Class FormGenerate {
	public $formStart 	= "";
	public $formEnd 	= "</form>";

	public function __construct ($formAction = '', $formMethod = 'post', $formCssClass = 'default_form', $formId = 'default_form', $jsEvent = '', $jsCode = '') {
		$jsEvent = ($jsEvent == '') ? $jsEvent : $jsEvent.'='.$jsCode;
		$this->formStart = "<form action='$formAction' method='$formMethod' class='$formCssClass' id='$formId' $jsEvent>";
	}
	
	/**
	*Формирует input для формы
	*@param string $label
	*@param string $type
	*@param string $name
	*@param string $css
	*@param string $id
	*@param string $value
	*@return string
	*/
	public function getInput ($label = 'Default input:', $type = 'text', $name = 'input[]', $css = 'default_input', $id = 'default_input', $value = '') {
		$label = ($label == '') ? $label : "<label for='$id'>$label</label>";
		return "$label<input type='$type' name='$name' class='$css' id='$id' value='$value'>";
	}
	
	/**
	*Формирует textarea для формы
	*@param string $label
	*@param string $name
	*@param string $css
	*@param string $id
	*@param string $rows
	*@param string $cols
	*@param string $value
	*@return string
	*/
	public function getTextarea ($label = 'Default input:', $name = 'text[]', $css = 'default_textarea', $id = 'default_textarea', $rows = '', $cols = '', $value = '') {
		return "<label for='$id'>$label</label><textarea name='$name' id='$id' class='$css' rows='$rows' cols='$cols'>$value</textarea>";
	}
	
	/**
	*Формирует каптчу для формы
	*@param string $name
	*@param string $css
	*@param string $id
	*@return string
	*/
	public function getCaptcha ($name = 'default_captcha[]', $css = 'default_captcha', $id = 'default_captcha') {
		$num1 = rand(1, 20);
		$num2 = rand(1, 20);
		$rand = rand(1,2);
		if ($num1 > $num2) {
			$oper = '-';
			$answer = $num1 - $num2;
		} else {
			$oper = '+';
			$answer = $num1 + $num2;
		}
		$_SESSION['answer'] = $answer;
		$captcha = '<div>'.$num1.' '.$oper.' '.$num2." = <input type='text' name='$name' css='$css' id='$id' value=''></div>";
		return $captcha;
	}
}

