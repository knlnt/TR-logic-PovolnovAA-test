<?php

if( $Module == 'del' ){
	if( ($_SESSION['user_in'] == 1) and $_SESSION['user_id'] ){
		mysqli_query($CONNECT, "DELETE FROM `users` WHERE `id` = $_SESSION[user_id]");
		exit(header('Location: /exit'));
		//echo $_SESSION['user_id'];
	}
	else{
		exit(header('Location: /'));
		//echo 'sd';
	}
}
else{
	$_SESSION['user_in'] = 0;
	$_SESSION['user_id'] = 0;
	$_SESSION['user_name'] = '';
	$_SESSION['user_email'] = '';
	$_SESSION['user_date'] = '';
	exit(header('Location: /'));
}

?>