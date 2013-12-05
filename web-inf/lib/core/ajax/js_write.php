<?php
/*
调用方法：
js.php?id=hot&nodeid=1&tplname=js.html
index.php&action=member&method=test;
*/

function JsOutputFormat($str)
{
	$str = trim($str);
	$str = str_replace("\s\s", "\s", $str);
	$str = str_replace("\r", '', $str);
	$str = str_replace("\n", '', $str);
	$str = str_replace("\t", '', $str);
	$str = str_replace("\\", "\\\\", $str);  //反斜杠处理
	$str = str_replace("\"", "\\\"", $str);  //双引号处理
	//$str = addslashes($str);
	$str = str_replace("\'", "\\\'", $str);  //单引号处理
	return $str;
}
echo "document.write(\"";
echo echoContent($tplname);
echo "\");";

?>