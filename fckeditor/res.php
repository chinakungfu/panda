<?php
include_once("res.ini.php");
$params = base64_decode($_REQUEST['PID']);
$params = explode('|',$params);
//http://localhost/phpwork/yellowpages/res.php?PID=Mjc3fHVwZmlsZS9hZG1pbi95ZWxsb3dQYWdlcy9pbWFnZS9waG90b3xjb21wYW55LmpwZ3xtZW1iZXI=
$imagePath = $resAccessConfig['url'].$params["1"]."/".$params['2'];
//print $imagePath;
Header( "HTTP/1.1 301 Moved Permanently" ) ;
header("Location: $imagePath"); 
exit;
?>