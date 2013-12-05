<?php
/*********************************************
* Cewer 4 (CMSware)
* Copyright by Lonmo Inc. All right reserved
* 2004-2012
* www.lonmo.com
**********************************************/

include_once("public_res.ini.php");

$imagePath = "publish/avatar/37_thumb.jpg";
Header( "HTTP/1.1 301 Moved Permanently" );
header("Location: $imagePath");
exit;
?>
