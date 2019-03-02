<?php
if( $Module == "reg" ){
	
	if( $_POST['email'] and $_POST['pass'] and $_POST['passEq'] and $_POST['name'] and $_POST['captcha'] ){
		$_POST = FormChars($_POST, 1);
		$code = md5($_POST['captcha']);
		if( $code === $_SESSION['captcha'] ){
			if( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
				if( validPass($_POST['pass']) ){
					if( $_POST['pass'] === $_POST['passEq'] ){
						$email = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `users` WHERE `email` = '$_POST[email]'"));
						if( $email['id'] ){
							echo returnMsg("Такой E-mail уже существует", "error", 1);
						}
						else{
							$pass = md5($_POST['pass']);
							mysqli_query($CONNECT, "INSERT INTO `users` VALUES('', '$_POST[email]', '$pass', '$_POST[name]', NOW())");
							echo returnMsg("Регистрация прошла успешно", "ok", 2, 2);
						}
					}
					else{
						echo returnMsg("Повторите пароль еще раз", "error", 1);
					}
				}
				else{
					echo returnMsg("Пароль должен соответствоать правилам", "error", 1);
				}
			}
			else{
				echo returnMsg("E-mail не корректный", "error", 1);
			}
		}
		else{
			echo returnMsg("Капча введена не верно", "error", 2, 1);
		}
	}
	else{
		echo returnMsg("Заполните все поля", "error", 1);
	}
}
elseif( $Module == 'inp' ){
	if( $_POST['email'] and $_POST['pass'] and $_POST['captcha'] ){
		$_POST = FormChars($_POST, 1);
		$code = md5($_POST['captcha']);
		$pass = md5($_POST['pass']);
		if( $code == $_SESSION['captcha'] ){
			if( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
				$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `email` = '$_POST[email]'"));
				if( $row['id'] ){
					if( $pass == $row['pass'] ){
						$_SESSION['user_in'] = 1;
						$_SESSION['user_id'] = $row['id'];
						$_SESSION['user_name'] = $row['name'];
						$_SESSION['user_email'] = $row['email'];
						$_SESSION['user_date'] = $row['date'];
						
						echo returnMsg("", "", 2, 3);
					}
					else{
						echo returnMsg("Пароль не верный", "error", 2, 1);
					}
				}
				else{
					echo returnMsg("Пользователь с таким E-mail не зарегистрирован", "error", 1);
				}
			}
			else{
				echo returnMsg("E-mail не корректен", "error", 1);
			}
		}
		else{
			echo returnMsg("Капча введена не верно", "error", 2, 1);
		}
	}
	else{
		echo returnMsg("Заполните все поля", "error", 1);
	}
}

?>