<?php
session_start();
include_once 'setting.php';
$CONNECT = mysqli_connect(HOST, USER, PASS, DB);
mysqli_query($CONNECT, "SET NAMES utf8");



if ($_SERVER['REQUEST_URI'] == '/') {
$Page = 'index';
$Module = 'index';
} else {
$URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$URL_Parts = explode('/', trim($URL_Path, ' /'));
$Page = array_shift($URL_Parts);
$Module = array_shift($URL_Parts);


if (!empty($Module)) {
$Param = array();
for ($i = 0; $i < count($URL_Parts); $i++) {
$Param[$URL_Parts[$i]] = $URL_Parts[++$i];
}
}
}




if( $Page == "index" ){ include("page/index.php"); }
elseif( $Page == "profile" ){ include("page/profile.php"); }
elseif( $Page == "auth" ){ include("form/auth.php"); }
elseif( $Page == "exit" ){ include("form/exit.php"); }
else{ echo "ERROR"; }


function headAndBody_html($title, $main, $scriptAndStyle){
	$ECHO = 
	'
	<!doctype html>
	<html lang="ru">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>'.$title.'</title>
		<link rel="stylesheet" href="resource/css/style.css">
		<link rel="stylesheet" href="resource/css/'.$scriptAndStyle.'.css">
		<script type="text/javascript" src="resource/js/vue.js"></script>
		<script type="text/javascript" src="resource/js/axios.min.js"></script>
		<script type="text/javascript" src="resource/js/'.$scriptAndStyle.'.js"></script>
		</head>
		<body>
			<main id="app">
				'.$main.'
			</main>
		</body>
	</html>
	';
	
	return $ECHO;
}

function returnMsg($msg, $typeMsg, $type, $add=''){
	if ( $type == 1 ){
		return json_encode(array("msg"=>$msg, "type"=>$typeMsg));
	}
	elseif ( $type == 2 ){
		return json_encode(array("msg" => $msg, "type" => $typeMsg, "add" => $add));
	}
}

function FormChars ($str, $type = 0) {
	if( $type === 0 ){ return stripslashes(strip_tags(nl2br(htmlspecialchars(trim($str), ENT_QUOTES), false))); }
	elseif( $type === 1 ) { 
		foreach ($str as $key => $val){
			$str[$key] = FormChars($val);
		}
		return $str;
	}
}

function validPass($pass){
	return preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z-_]{5,40}$/", $pass);
}

?>