<?
import('core.incfunc');
include_once('./appfunc/taobao_interface.php');
include_once($GLOBALS['currentApp']['domainpath']."/web-inf/lib/coreconfig/public_res.ini.php");

include_once(dirname(__FILE__)."/../../db.inc.php");

function getItemsByCid($cid, $c) {
		$resp = getCategory($cid);
		if(!getCategory($cid)) {
			$c = new TopClient;
			$c->appkey = "12666932";
			$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
			$req = new TmallSelectedItemsSearchRequest();
			$req->setCid($cid);
			$resp = $c->execute($req);
			saveCategory($cid, $resp);
			$arr = simpleXMLElementtoArray($resp);
		}
		else {
			$arr = simpleXMLElementtoArray($resp);
		}
		return $arr["item_list"]["selected_item"];
}

function getShopListInfo($word,$cid=0,$getAjaxGoodsIndex,$getAjaxGoodsSize)
{
	$c = new TopClient;
	$c->appkey = "12666932";
	$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
	
	if($word){
		$w = runFunc('translate',array($word) );
		if($w)
			$word = $w;

		$c = new TopClient;
		$c->appkey = "12666932";
		$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
		$req = new TaobaokeItemsGetRequest();
		$req->setPid("668155");
		$req->setKeyword($word);
		$req->setPageNo(mt_rand(1,9));
		$req->setPageSize("40");
		$req->setFields("num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume");
		$req->setNick("ivisionstudio");
		$resp = $c->execute($req);
		$arr = simpleXMLElementtoArray($resp);
		
		$start = mt_rand(1,3) * 10;
		$items = $arr["taobaoke_items"]["taobaoke_item"];
		
		for($i = $start; $i < $start + 9; $i++) {
			$item = simpleXMLElementtoArray($items[$i]);
			$item["exist"] = "yes";

			$json[] = $item;
		}

	}else{
		$req = new TmallSelectedItemsSearchRequest();
		if($cid == 0) {
			$cid = 1801; // 美容护肤/美体/精油
			$i1 = getItemsByCid($cid, $c);

			$cid = 215206; // 酒壶/酒杯/酒具
			$i2 = getItemsByCid($cid, $c);

			$cid = 50013888; // 户外服装
			$i3 = getItemsByCid($cid, $c);

			$cid = 50011397; // 珠宝/钻石/翡翠/黄金
			$i4 = getItemsByCid($cid, $c);

			$items = array_merge($i1, $i2, $i3, $i4);
			shuffle($items);
		}
		else {

			$items = getItemsByCid($cid);
		}
		
		$count = count($items);
		$getAjaxGoodsIndex = mt_rand(0,ceil($count/10));
		$start = $getAjaxGoodsSize * ($getAjaxGoodsIndex - 1);

		$end = ($getAjaxGoodsSize * $getAjaxGoodsIndex) - 1;
		
		$json = array();
	
		if($end - $getAjaxGoodsSize +1 >= $count){
			$item_array = array();
			$item_array["exist"] = "no";
			$json[] = (object)$item_array;
			
			return json_encode( $json );
		}
		$tids = array();
		for($start;$start<=$end;$start++){
			$tids []= $items[$start]->track_iid;
		}
		$items = getTmallImformation(implode(',',$tids));
		foreach($items as $info){
			
			$item_array = array();
			$item_array["exist"] = "yes";
			$item_array["price"] = (string)$info->item->price;
			$item_array["pic_url"] = (string)$info->item->pic_url;
			$item_array["num_iid"] = (string)$info->item->num_iid;
			$item_array["click_url"] = (string)$info->click_url;
			$item_array["title"] = (string)$info->item->title;
			$json[] = (object)$item_array;
		}
	}
	
	return json_encode( $json );

}

function getTmallImformation($track_iid){

	//	$word=runFunc('translate',array($searchword));
	$c = new TopClient;
	$c->appkey = "12666932";
	$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
	$req = new TaobaokeItemsDetailGetRequest;
	$req->setTrackIids($track_iid);
	$req->setFields("pic_url,click_url,title,num_iid,price");
	//$req->setNick("ivisionstudio");
	$resp = $c->execute($req);
	$list=$resp->taobaoke_item_details->taobaoke_item_detail;

	if($list){
		return $list;
	}
}

