<?php
include "TopSdk.php";


function simpleXMLElementtoArray(SimpleXMLElement $xml) {
	$array = (array)$xml;

	foreach ( array_slice($array, 0) as $key => $value ) {
		if ( $value instanceof SimpleXMLElement ) {
			$array[$key] = empty($value) ? NULL : simpleXMLElementtoArray($value);
		}
	}
	return $array;
}


/*
 // 分类目录
 $c = new TopClient;
 $c->appkey = "12666932";
 $c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
 $req = new TmallTemaiItemsSearchRequest;
 $req->setCat(50101034);
 $req->setStart(0);
 $req->setSort("s");
 $resp = $c->execute($req);
 print_r($resp);
 exit;
 */

$i=1;
function getFirstItem(){
	$c = new TopClient;
	$c->appkey = "12666932";
	$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
	$req = new ItemcatsGetRequest;
	$req->setFields("cid,parent_cid,name,is_parent");
	$req->setParentCid(0);
	$resp = $c->execute($req);
	$list ='<ul>';
//<a href="abc&cid='. $item->cid .'">'.$i.$item->name.'</a>'
	foreach ($resp->item_cats->item_cat as $item){
		$list .='<li>'.$i;
		$list .='<a href="abc&cid='. $item->cid.'">'.$item->name.'</a>';
		$list .=getItemList($item->cid);
		$list .='</li>';
		$i++;
	}
	return $list .="</ul>";

}
function getItemList($cat){
	$c = new TopClient;
	$c->appkey = "12666932";
	$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
	$req = new ItemcatsGetRequest;
	$req->setFields("cid,parent_cid,name,is_parent");
	$req->setParentCid($cat);
	$resp = $c->execute($req);
	$list ='<ul>';
	foreach ($resp->item_cats->item_cat as $item){
		$list .='<li><a href="abc&cid='. $item->cid .'">'.$i.$item->name.'</a>';
		$list .='</li>';
	}
	return $list .="</ul>";

}


echo getFirstItem();
exit;
$c = new TopClient;
$c->appkey = "12666932";
$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
//实例化具体API对应的Request类
$req = new TmallSelectedItemsSearchRequest();

$req->setCid("50010850");
 
//$req = new ProductsSearchRequest;
//执行API请求并打印结果

//$req->setFields("cid,parent_cid,name,is_parent");

//$req->setPageNo(1);
//$req->setPageSize(2);

$resp = $c->execute($req);

$arr = simpleXMLElementtoArray($resp);

$items = $arr["item_list"]["selected_item"];


$result_count = count($items);



$rowsPerPage = 18;

$page =1;

$start = $rowsPerPage * ($page - 1);

$end = $start + $rowsPerPage - 1;

if($result_count%$rowsPerPage!=0){
	$page_count = floor($result_count/$rowsPerPage)+1;
}else{
	$page_count = $result_count/$rowsPerPage;
}

echo $page_count."<br>";



function getimformation($track_iid){
	$c = new TopClient;
	$c->appkey = "12666932";
	$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
	$req = new TaobaokeItemsConvertRequest;
	$req->setTrackIids($track_iid);
	$req->setFields("pic_url,click_url,title,iid,price");
	$req->setNick("ivisionstudio");
	$resp = $c->execute($req);
	if($resp->taobaoke_items->taobaoke_item){
	foreach ($resp->taobaoke_items->taobaoke_item as $items){
		echo $list =$items->title."价格：".$items->price.'<a href="'.$items->click_url.'"><img width="100px" src="'.$items->pic_url.'" /></a><br>';
	}

	}
}

for($start;$start<=$end;$start++){
	if(isset($items[$start])){
		//echo $start."--".$items[$start]->track_iid."<br>";
		getimformation($items[$start]->track_iid);
	}
}


?>