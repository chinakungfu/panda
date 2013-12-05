<?php
error_reporting(1);
include "taobao/TopSdk.php";



function getTaobaoProductInfo($productId)
{
		//实例化TopClient类
		$c = new TopClient;
		$c->appkey = $GLOBALS['taobao']['appkey'];
		$c->secretKey = $GLOBALS['taobao']['secretKey'];

		//实例化具体API对应的Request类
		$req = new ItemGetRequest;
		$req->setNumIid($productId);
		$req->setFields("detail_url, num_iid, title, nick, type, desc, skus, props_name, created, promoted_service, is_lightning_consignment, is_fenxiao, auction_point, property_alias, volume, template_id, after_sale_id, is_xinpin, sub_stock, inner_shop_auction_template_id, outer_shop_auction_template_id, food_security, features, global_stock_type, locality_life, desc_module_info, cid, seller_cids, props, input_pids, input_str, pic_url, num, valid_thru, list_time, delist_time, stuff_status, location, price, post_fee, express_fee, ems_fee, has_discount, freight_payer, has_invoice, has_warranty, has_showcase, modified, increment, approve_status, postage_id, product_id, item_imgs,item_img, prop_imgs, outer_id, is_virtual, is_taobao, is_ex, is_timing, videos, is_3D, score, one_station, second_kill, auto_fill, violation, is_prepay, ww_status, wap_desc, wap_detail_url, cod_postage_id, sell_promise");
		//执行API请求并打印结果
		$resp = $c->execute($req);
		return $resp;
		//return simpleXMLElementtoArray($resp);
}

function getTaobaoProductShopInfo($nick)
{
		//实例化TopClient类
		$c = new TopClient;
		$c->appkey = $GLOBALS['taobao']['appkey'];
		$c->secretKey = $GLOBALS['taobao']['secretKey'];

		//实例化具体API对应的Request类
		$req = new ShopGetRequest;
		$req->setNick($nick);
		$req->setFields("sid,cid,title,nick,desc,bulletin,pic_path,created,modified");
		//执行API请求并打印结果
		$resp = $c->execute($req);
		return $resp;
		//return simpleXMLElementtoArray($resp);
}


/**
 * 处理query字符串，例如$string = "a=b&c=d";
 *
 * @param  string $string     处理源字符串
 * @return array $resultArray       结果数组
 */

function handleQueryString($string) {
	$urlParams = explode("&",$string);
	if($urlParams)
	{
		foreach ($urlParams as $key => $val)
		{
			$urlParam = explode("=",$val);
			$returnArray[$urlParam[0]] = $urlParam[1];
		}
	}
	return $returnArray;
}

function simpleXMLElementtoArray(SimpleXMLElement $xml) {
	$array = (array)$xml;
	foreach ( array_slice($array, 0) as $key => $value ) {
		if ( $value instanceof SimpleXMLElement ) {
			$array[$key] = empty($value) ? NULL : simpleXMLElementtoArray($value);
		}
	}
	return $array;
}

function simpleXMLElementtoArrayPrice(SimpleXMLElement $xml) {
	$array = (array)$xml;
	foreach ( $array as $key => $value ) {
		if ( $value instanceof SimpleXMLElement ) {
			$array[$key] = empty($value) ? NULL : simpleXMLElementtoArray($value);
		}
	}
	return $array;
}

function getPropsList($props){

	$props = explode(";", $props);
	$props_array = array();
	foreach($props as $prop){
		if(strpos($prop,"尺码")>-1 or strpos($prop,"尺寸")>-1 or strpos($prop, "颜色")>-1){

			continue;
		}

		$p = explode(":", $prop);
		$props_array[] = $p[2].":".$p[3];
	}

	return $props_array;

}

function getItemPropsStr($props,$prop_alias){

	$props = explode(";", $props);
	$prop_alias = explode(";", $prop_alias);

foreach($props as $prop) {
		if(strpos($prop, "颜色")>-1){
			$p =explode(":", $prop);
			$color_val = $p[3];
			if(count($prop_alias)>0){
				foreach($prop_alias as $pa){
					$pa_array = explode(":", $pa);
					if($p[0].":".$p[1] == $pa_array[0].":".$pa_array[1]){
						$color_val = $pa_array[2];
					}
				}
				$color[] = runFunc('translate',array($color_val));
			}else{
				$color[] =  runFunc('translate',array($p[3]));
			}
		}
		if(strpos($prop,"尺码")>-1 or strpos($prop,"尺寸")>-1){
			$p =explode(":", $prop);
			$size_val = $p[3];
			if(count($prop_alias)>0){
				foreach($prop_alias as $pa){
					$pa_array = explode(":", $pa);
					if($p[0].":".$p[1] == $pa_array[0].":".$pa_array[1]){
						$size_val = $pa_array[2];
					}
				}
				if(is_numeric("") or strlen($size_val)<3){
					$size[] = $size_val;
				}else{
					$size[] = $size_val;
				}

			}else{
					$size[] = $p[3];
			}
		}
	}

	$props_array = array();

	if(count($color)>0){
		$props_array_color = array(
			"color" => $color,
		);

		$props_array[] = $props_array_color;
	}
	if(count($size)>0){
		$props_array_size = array(
			"size" => $size,
		);
		$props_array[] = $props_array_size;
	}


	return json_encode($props_array);
}

function getTaobaokeItemLink($id){

	$c = new TopClient;
	$c->appkey = $GLOBALS['taobao']['appkey'];
	$c->secretKey = $GLOBALS['taobao']['secretKey'];

	$req = new TaobaokeItemsConvertRequest();

	$req->setFields("click_url");

	$req->setNumIids($id);

	$resp = $c->execute($req);

	$result =  simpleXMLElementtoArray($resp);


	return $result["taobaoke_items"]["taobaoke_item"]["click_url"];
}

function getTaobaokeItemDetail($productId){
	$c = new TopClient;
	$c->appkey = $GLOBALS['taobao']['appkey'];
	$c->secretKey = $GLOBALS['taobao']['secretKey'];
	$req = new TaobaokeItemsDetailGetRequest;
	$req->setNumIids($productId);
	$req->setFields("click_url");
	$resp = $c->execute($req);
	$result =  simpleXMLElementtoArray($resp);
	return $result["taobaoke_item_details"]["taobaoke_item_detail"]["click_url"];
}
function getItemSkus($productId){
	$c = new TopClient;
	$c->appkey = $GLOBALS['taobao']['appkey'];
	$c->secretKey = $GLOBALS['taobao']['secretKey'];
	$req = new ItemSkusGetRequest;
	$req->setFields("price");
	$req->setNumIids($productId);
	$resp = $c->execute($req);
	$result =  simpleXMLElementtoArray($resp);
	return $result["skus"]["sku"];
}
function GetGoodsInfo($url)
{
	try {
		$startTime = time();
		$urlArray = explode("?",trim($url));
		if($urlArray[1])
		{
			$urlParams = handleQueryString($urlArray[1]);
			$goodInfo = getTaobaoProductInfo($urlParams['id']);

			if($urlParams['id']||$urlParams['mallstItemId'])
			{
				$goodInfo = getTaobaoProductInfo($urlParams['id']);

				if($goodInfo->code)
				{
					$goodInfo = getTaobaoProductInfo($urlParams['mallstItemId']);
				}
				$goodInfo = simpleXMLElementtoArray($goodInfo);

				if($goodInfo)
				{
					if(!isset($goodInfo["item"])){
						$result['status'] = '-3';
						return $result;
					}
					$details = getPropsList($goodInfo["item"]["props_name"]);

				 	$details_str = implode(";", $details);

					$details_str =  runFunc('translate',array($details_str));

					$details_str = str_replace(";", "<br>", $details_str);

					$result['goodsDetail'] = $details_str;

					$props = getItemPropsStr($goodInfo["item"]["props_name"],$goodInfo["item"]["property_alias"]);
					if($props !=""){
						$result['props'] = $props;
					}
					//$result["click_url"] = getTaobaokeItemLink($goodInfo['item']["num_iid"]);
					$result["click_url"] = getTaobaokeItemDetail($urlParams['id']);
					$result['title'] = $goodInfo['item']['title'];

					$shopInfo = getTaobaoProductShopInfo($goodInfo['item']['nick']);
					$shopInfo = simpleXMLElementtoArray($shopInfo);
					$result['goodsShopId'] = $shopInfo['shop']['sid'];
					$result['goodsShopName'] = $shopInfo['shop']['nick'];
					$result['goodsShopUrl'] = "http://shop".$shopInfo['shop']['sid'].".taobao.com";

					//hutu max price
					$goodSkusInfo = getItemSkus($urlParams['id']);
					if(is_array($goodSkusInfo)){
						foreach ($goodSkusInfo as $key => $val)
						{
							if(is_object($val)){
								$result3[$key] = simpleXMLElementtoArray($val);
							}else{
								$result3[$key] = $val;
							}
						}
						foreach ($result3 as $key => $val ) {
							if(is_array($val)){
								foreach ($val as $j => $h ) {
									$tempPrice[$key] = $h;
								}
							}else{
								$tempPrice[$key] = $val;
							}

						}
						$maxPrice = max($tempPrice);
						if($maxPrice){
							$result['price'] = $maxPrice;
						}else{
							$result['price'] = $goodInfo['item']['price'];
						}
					}else{
						$result['price'] = $goodInfo['item']['price'];
					}

					if($goodInfo['item']['freight_payer']=='seller')//卖家承担
					{
						$result['postage'] = 0;
					}elseif ($goodInfo['item']['freight_payer']=='buyer')//买家承担
					{
						$result['postage'] = $goodInfo['item']['express_fee'];
					}
					$imgCount = count($goodInfo['item']['item_imgs']['item_img']);

					foreach ($goodInfo['item']['item_imgs']['item_img'] as $key => $val)

					{
						if(!is_array($val)&&!$val instanceof SimpleXMLElement )
						{
							$result['img'][$key] = $goodInfo['item']['item_imgs']['item_img'];
							break;
						}else
						{
							if($key<4)
							{
								if($val instanceof SimpleXMLElement)
								{
									$result['img'][$key] = simpleXMLElementtoArray($val);
								}else
								{
									$result['img'][$key] = $val;
								}
							}else
							{
								break;
							}
						}
					}
					$endTime = time();
					$result['status'] = '1';
					$result['from']="taobao";
					$result['size']="_310x310.jpg";
					//print_r($goodInfo);
					//print_r($result2);
					//print $endTime - $startTime;exit;
					return $result;

				}else
				{
					$result['status'] = '-3';
					return $result;
				}
			}else
			{
				$result['status'] = -1;//url地址不正确
				return $result;
			}
		}else
		{
			$result['status'] = -1;//url地址不正确
			return $result;
		}

	}catch (Exception $e)
	{
		throw $e;
	}
}
?>
