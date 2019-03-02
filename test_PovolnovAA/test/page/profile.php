<?php
if( $_SESSION['user_in'] !== 1 ){
	exit(header('Location: /'));
}

$MAIN =
'
<div class="wrp">
	<h1>'.$_SESSION['user_name'].'</h1>
	<p>Дата регистрации - '.$_SESSION['user_date'].'</p>
	<p>Личный E-mail - '.$_SESSION['user_email'].'</p>
	<a href="/exit">Выход</a>
	<a href="/exit/del">Удалить аккаунт</a>
</div>
';

echo headAndBody_html($_SESSION['user_name'], $MAIN, "profile");

?>