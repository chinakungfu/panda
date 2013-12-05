<?php

include_once("public_res.ini.php");
$params = base64_decode($_REQUEST['PID']);
$params = explode('|',$params);
$imagePath = $GLOBALS['currentApp']['resconfig']['url'].$params["1"]."/".$params['2'];

echo $imagePath;
//Header( "HTTP/1.1 301 Moved Permanently" );
//header("Location: $imagePath");
exit;
?>

|/upfiles/taobao/2/2012-05-19/|18b369fc2ff2f79d92ee6a05d015dc2d.jpg|

