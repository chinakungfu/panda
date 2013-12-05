<?php
//引用有道翻译  key 是引用别人的后期自己申请
function translate($content){

	$url = "http://fanyi.youdao.com/openapi.do?keyfrom=WOWSHOPPING&key=2042774247&type=data&doctype=json&version=1.1&q=".urlencode($content);
	$list = file_get_contents($url);
	$js_de = json_decode($list,true);
	
	return  $js_de['translation'][0];
	

}

function webJump($where,$text){
	$tran=translate($text);
	/*switch ($where){
		case jingdong:
			header("Location: http://search.360buy.com/Search?keyword=".$tran."&enc=utf-8");
			break;
		case yihaodian:
			header("Location: http://search.yihaodian.com/s2/c0-0/k".$tran."/5/");
			break;
		case taobao:*/
			header("Location: http://s.taobao.com/search?q=$tran");
		//	break;
	//}
}
?>