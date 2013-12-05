<?php
/**
 * add to 20090811 zxq
 * **/
function keyED($txt,$encrypt_key)
{
	$encrypt_key = md5($encrypt_key);
	$ctr=0;
	$tmp = "";
	for($i=0;$i<strlen($txt);$i++)
	{
		if ($ctr==strlen($encrypt_key))
		$ctr=0;
		$tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1);
		$ctr++;
	}
	return $tmp;
}
function encrypt($txt,$key="lonmozxqer")
{
	$encrypt_key = md5(mt_rand(0,100));
	$ctr=0;
	$tmp = "";
	for ($i=0;$i<strlen($txt);$i++)
	{
		if ($ctr==strlen($encrypt_key))
		$ctr=0;
		$tmp.=substr($encrypt_key,$ctr,1) . (substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1));
		$ctr++;
	}
	return keyED($tmp,$key);
}
function decrypt($txt,$key="lonmozxqer")
{
	$txt = keyED($txt,$key);
	$tmp = "";
	for($i=0;$i<strlen($txt);$i++)
	{
		$md5 = substr($txt,$i,1);
		$i++;
		$tmp.= (substr($txt,$i,1) ^ $md5);
	}
	return $tmp;
}
/*
function encrypt_url($url,$key="lonmozxqer")
{
	return "LCMSPID=".rawurlencode(base64_encode(encrypt($url,$key)));
}
*/



function encrypt_url($url,$key="lonmozxqer",$pathinfoMode=false)
{
	if($GLOBALS['currentApp']['urlParamType']=='pathinfo' || $pathinfoMode){
		$params=$GLOBALS['currentApp']['urlParams'];
		if(empty($params)){
			$params=array(
				'a'=>'action',
				'm'=>'method',
				'n'=>'nodeId',
				'p'=>'page'
			);
		}
		$n=preg_match_all('/([\w\d]+)\=([\w\d]*)/',$url,$matches);
		//print_r($matches);exit;
		if($n){
			for($i=0;$i<$n;$i++){
				if(in_array($matches[1][$i],$params)){
					$url=str_replace($matches[0][$i],array_search($matches[1][$i],$params).'-'.$matches[2][$i],$url);
				}else{
					$url=str_replace($matches[0][$i],$matches[1][$i].'-'.$matches[2][$i],$url);
				}
			}
		}
		$url=str_replace('&','--',$url);
		//$url=rawurlencode($url);
		//$url=preg_replace('/&[\w\d]+\=/','-',$url);
		//$url=preg_replace('/^\/?[\w\d]+=/','',$url);
		return '/'.$url;
	}else{
		return "?LCMSPID=".rawurlencode(base64_encode(encrypt($url,$key)));
	}
}
function decrypt_url($url,$key="lonmozxqer")
{
	return decrypt(base64_decode(rawurldecode($url)),$key);
}
function geturl($str,$key="lonmozxqer")
{
	$str = decrypt_url($str,$key);
	$url_array = explode('&',$str);
	if (is_array($url_array))
	{
		foreach ($url_array as $var)
		{
			$var_array = explode("=",$var);
			$vars[$var_array[0]]=$var_array[1];
		}
	}
	return $vars;
}
function arr2str($arr)
{
		foreach ($arr as $key => $val)
		{
			$str .= "'".$key."'"."<<"."'".$val."'".",";
		}
	$str = substr($str,0,-1);
	return $str;
}
function str2arr($str)
{
	$str = "array(".$str;
	$str    .=    ")";
	eval("\$arr = ".$str.'; ');
	return $arr;
}
function url2str($arr)
{
		foreach ($arr as $key => $val)
		{
			$str .= $key."=".$val."&";
		}
	$str = substr($str,0,-1);
	return $str;
}
function str2url($str)
{
	$str = "array(".$str;
	$str    .=    ")";
	eval("\$arr = ".$str.'; ');
	return $arr;
}
function mb_unserialize($serial_str) {
     $serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
     $serial_str= str_replace("\r", "", $serial_str);
    return unserialize($serial_str);
 }
 // This function deletes a element in an array, by giving it the name of a key.
function delArrayElementByKey1($array_with_elements, $key_name) {
   $key_index = array_keys(array_keys($array_with_elements), $key_name);
   if (count($key_index) != '') {
       // Es gibt dieses Element (mindestens einmal) in diesem Array, wir loeschen es:
       array_splice($array_with_elements, $key_index[0], 1);
   }
   return $key_name;
}
function delSpecialWord($str_with_elements, $key_name) {
   if (count($str_with_elements) != ''){
		$myArr=explode(',',$str_with_elements);
		unset($myArr[array_search("key_name",$myArr)]);
		foreach ($myArr as $key => $val)
		{
			$str_value .= $val.",";
		}
		$str_value = substr($str_value,0,-1);
		return $str_value;
   }else{
		return false;
   }
}
function getOrderStatus($statusCode){
	if (count($statusCode)!= ''){
		switch($statusCode){
			case -1:
				$orderStatus='Order Canceled';
				break;
			case 0:
				$orderStatus='Order Released';
				break;
			case 1:
				$orderStatus='Service Choosed';
				break;
			case 2:
				$orderStatus='Address Choosed';
				break;
			case 3:
				$orderStatus='Waiting to Service Confirm';
				break;
			case 4:
				$orderStatus='Waiting for Payment';
				break;
			case 5:
				$orderStatus='Finish Payment';
				break;
			case 6:
				$orderStatus='Order in Process';
			break;
			case 7:
				$orderStatus='On the Way';
				break;
			case 7.1:
				$orderStatus='Arrived';
				break;
			case 8:
				$orderStatus='Finished';
				break;
			default:
				$orderStatus='Wrong Status';
		}
		return $orderStatus;
	}else{
		return false;
	}
}

?>
