<?php
Class Form {
	public function form_handler () {
		$error = array();
	
		if (isset($_POST['name']) &&
			isset($_POST['email']) &&
			isset($_POST['text_message']) &&
			isset($_SESSION['answer']) &&
			isset($_POST['captcha'])) 
		{
			$name = $_POST['name'];
			$email = $_POST['email'];
			$text_message = $_POST['text_message'];
			$answer = $_SESSION['answer'];
			$captcha = $_POST['captcha'];
		
			$errorString = '<span class="error"> Данное поле обязательно к заполнению</span>';
			//name regexp check
			$nameRegExp = preg_match('/^(\w{3,}) ?+/u', $name);
		
			//email regexp check
			$emailRegExp = preg_match('/^([A-Za-z0-9_\.-]+)@([A-Za-z0-9_\.-]+)\.([a-z\.]{2,6})$/', $email);
		
			$error[] = ($name == null || $name == " " || !$nameRegExp) ? $errorString : '';
			$error[] = ($email == null || $email == " " || !$emailRegExp) ? $errorString : '';
			$error[] = ($text_message == null && strlen($text_message) < 50) ? $errorString : '';
			$error[] = ($captcha == $answer) ? '' : '<span class="error"> Ответ неверный!</span>';
			$error[] = $name;
			$error[] = $email;
			$error[] = $text_message;
			$error[] = '';
		
		
			if ($error[0] == '' && $error[1] == '' && $error[2] == '' && $error[3] == '') {
				$path = "./data/db.txt";
				$date = date("F");
				$date .= ' '.date("j");
				$date .= ', '.date("Y");
				$date .= ' в '.date("G");
				$date .= ':'.date("i");
			
				$ip = $_SERVER['REMOTE_ADDR'];
				$browser = $_SERVER['HTTP_USER_AGENT'];
			
				$divederCheck = array();
				$divederCheck[] = $name;
				$divederCheck[] = $email;
				$divederCheck[] = $text_message;
			
				$count = count($divederCheck);
				$dividerError = 1;
				while ($dividerError > 0) {
					$divider = 0;
					for ($i = 0; $i < $count; $i++) {
						$arrayString = str_split($divederCheck[$i]);
						if ($arrayString[count($arrayString)-1] == ";") {
							$divider = $divider + 1;
							unset($arrayString[count($arrayString)-1]);
							$divederCheck[$i] = implode("",$arrayString);
						}
					}
					if ($divider != 0) {
						$dividerError = 1;
					} else {
						$dividerError = 0;
					}
				}
			
				$name = $divederCheck[0];
				$email = $divederCheck[1];
				$text_message = $divederCheck[2];
			
				$content = "\n$name;$email;$text_message;$date;$ip;$browser;";
				$file = fopen($path, 'a+');
				fwrite($file, $content);
				fclose($file);
			
				$error[4] = '';
				$error[5] = '';
				$error[6] = '';
				$error[7] = '<span class="send">Ваще сообщение отправлено!</span>';
			
				setcookie("GuestBookName", $name, mktime(0, 0, 0, date("n"), date("j"), date("Y")+1));
				setcookie("GuestBookEmail", $email, mktime(0, 0, 0, date("n"), date("j"), date("Y")+1));
			
				$url = $_SERVER['PHP_SELF'].'#text';
				echo "<meta http-equiv='refresh' content='0;$url'>";
				exit;
			}
		} else {
			$error[] = '';
			$error[] = '';
			$error[] = '';
			$error[] = '';
			$error[] = '';
			$error[] = '';
			$error[] = '';
			$error[] = '';
		
			if (isset($_COOKIE['GuestBookName']) &&
				isset($_COOKIE['GuestBookEmail'])) {
				$error[4] = $_COOKIE['GuestBookName'];
				$error[5] = $_COOKIE['GuestBookEmail'];
			}
		}
		return $error;
	}
	
	public function generate_captcha () {
		$captcha = array();
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
		$captcha[] = $num1;
		$captcha[] = $num2;
		$captcha[] = $oper;
		$_SESSION['answer'] = $answer;
		return $captcha;
	}
}

$form = new Form ();