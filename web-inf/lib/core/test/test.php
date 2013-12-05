<?php

function test($id,$e){

	$html = file_get_html('http://www.360buy.com/product/665293.html');
	foreach($html->find('div#name h1') as $a)
	echo  iconv("GB2312","UTF-8//IGNORE",$a->outertext)."<br>";
	foreach($html->find('ul.list-h li img') as $e)
	echo $e->outertext."<br>";
	foreach($html->find('script') as $e)
	if(strpos($e->innertext,"jdPshowRecommend")){
		$str = iconv("GB2312","UTF-8//IGNORE",$e->innertext);
		preg_match_all("/.*￥(\d+(\.\d+)?).*/", $str, $out);
		echo $out[1][0]."<br>";
	}
}
