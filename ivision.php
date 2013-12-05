<?php import('core.util.RunFunc'); ?>
<?php
/*
 * Created on 2013-3-18
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
header("Content-type: text/html; charset=utf-8");
//$orderinfo = $_GET['iviorder'];
/*foreach($orderinfo as $k => $v){
	echo $k."<br>";
}*/

/*	$json_string = $_GET['iviorder'];
	//echo $json_string;
	if(ini_get("magic_quotes_gpc")=="1")
	{
		$json_string=stripslashes($json_string);
	}
	//echo $json_string."<br>";
	$user = json_decode($json_string);
	//echo $user;
	echo var_dump($user);
	print_r($user);

	echo '<br /><br /><br /><br />';

	echo $user[1363576373764].'<br />';
	echo $user->price.'<br />';*/


//$arr = $_POST; //若以$.get()方式发送数据，则要改成$_GET.或者干脆:$_REQUEST

//print_r($arr);

//$orderinfo=stripslashes($orderinfo);
/*$res = json_decode($_REQUEST['iviorder'], true);
$res["php_message"] = "I am PHP";
$result =  stripslashes(json_encode($res));
print_r($result->jsorder_1363578717438->count."</ br>");
echo $result;*/

/*$json = '{"1363578115559":{"count":1,"name":"cup","price":"50","imgHtml":""},
		 }';
$json ='{
  		"ivi_1363578115559":{"count":2,"name":"cup","price":"50"},
  		"item2":"sdfdfdfdfdfdf"
	}';
	*/
/*$json = $_REQUEST['iviorder'];
$J=json_decode($json);
echo "通过下面的信息就可以获取里面的信息了</br>";
print_r($J);
print_r("</br>");
echo "测试访问对象内元素</br>";
print_r($J[0]."</br>");
print_r($J->jsorder_1363578717438->name."</br>");
$arr = (array)$J;
print_r($arr);
*/
//注意不是标准的json
//print_r($J->item2."</br>");



/*$orderinfo =  stripslashes(htmlentities($orderinfo));
$orderinfo = json_encode($orderinfo);
echo json_decode($orderinfo);
//echo $orderinfo;
$a = array(1, 2, array("a", "b", "c"));
//var_export($orderinfo);

$str='<a href="test.html">测试</a>';
$transstr = htmlspecialchars($str) ;
echo $transstr . "<br />";
echo htmlspecialchars_decode($transstr);*/

?>
<?php
	$orderinfo = $_GET['iviorder'];

	//$link = "index.php".runFunc('encrypt_url',array('action=shop&method=ivision_order'));
	//$link = encrypt_url(array('action=shop&method=ivision_order'));
	echo "sdfdsf";

/*$arr = array(
    'name' => '陈毅鑫',
    'nick' => '深空',
    'contact' => array(
        'email' => 'shenkong at qq dot com',
        'website' => 'http://www.chinaz.com',
    )
);*/
//$json_string = json_encode($arr);
//$orderinfo = $_GET['iviorder'];
//$obj = json_decode($orderinfo, true);
//$arr = (array) $obj;


//方法一
//$json= '[{"id":"1","name":"\u5f20\u96ea\u6885","age":"27","subject":"\u8ba1\u7b97\u673a\u79d1\u5b66\u4e0e\u6280\u672f"},{"id":"2","name":"\u5f20\u6c9b\u9716","age":"21","subject":"\u8f6f\u4ef6\u5de5\u7a0b"}]';
/*$json = $orderinfo;

$students= json_decode($json);//得到的是 object
print_r($students);
foreach($students as $obj){
	print_R($obj);
    echo "物品：".$obj["name"]."&nbsp;&nbsp;&nbsp;数量：".$obj->count."&nbsp;&nbsp;&nbsp;单价：".$obj->price."<br />";
}
$students = get_object_vars($students);
print_R($students);*/
/*echo objtoarr($students);
function objtoarr($obj){
	$ret = array();
	foreach($obj as $key =>$value){
		if(gettype($value) == 'array' || gettype($value) == 'object'){
			$ret[$key] = objtoarr($value);
		}
		else{
			$ret[$key] = $value;
		}
	}
	return $ret;
}*/


//方法二
/*$json= '[{"id":"1","name":"\u5f20\u96ea\u6885","age":"27","subject":"\u8ba1\u7b97\u673a\u79d1\u5b66\u4e0e\u6280\u672f"},{"id":"2","name":"\u5f20\u6c9b\u9716","age":"21","subject":"\u8f6f\u4ef6\u5de5\u7a0b"}]';
//$json = $orderinfo;
$students= json_decode($json, true);//得到的是 array
for($i=0;$i<count($students);$i++){
	if(is_array($students[$i])){
		for($k=0;$k<count($students[$i]);$k++){
			echo $students[$i][$k];
		}
	}
    echo "姓名：".$students[$i]['name']."&nbsp;&nbsp;&nbsp;年 龄：".$students[$i]['age']."&nbsp;&nbsp;&nbsp;专 业：".$students[$i]['subject']."<br />";
}
*/

?>
