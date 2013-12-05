<?php
include('../publish/appfunc/simple_html_dom.php');
include_once('./appfunc/taobao_interface.php');
include_once(dirname(__FILE__)."/../../../../../db.inc.php");

function getItemsByCid($cid, $c) {
		$resp = getCategory($cid);
		if(!$resp) {
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

function urlComeFrom($url){
		return GetGoodsInfo($url);
}
//get Jingdong Data
function getJingdong($url){

	$html = file_get_html($url);
	$result = array();
	$result["from"]="jingdong";
	$result["size"]="";
	foreach($html->find('div#name h1') as $a)
	$result['title'] =iconv("GB2312","UTF-8//IGNORE",$a->plaintext);
	$img_num = 0;
	foreach($html->find('ul.list-h li img') as $e){
		$result['img'][$img_num]["url"]=str_replace("n5","n1",$e->src);
		$result['img'][$img_num]["url"];

		$img_num++;
	}
	foreach($html->find('script') as $e){
		if(strpos($e->innertext,"jdPshowRecommend")){
			$str = iconv("GB2312","UTF-8//IGNORE",$e->innertext);
			preg_match_all("/.*￥(\d+(\.\d+)?).*/", $str, $out);
			$result['price'] = $out[1][0];
		}
	}
	
	

	return $result;
}

//get Yihaodian Data
function getYihaodian($url){
	$result['from']="Yihaodian";
	$result['size']="";
	$html = file_get_html($url);
	//Yhd's type 1=>缺货
	foreach($html->find('input#doPurchaseBtn') as $a){
		if($a->class=="add_shopping_cart"){
			$result["stockout"]=1;
		}else{
			$result["stockout"]=0;
		}
	}

	foreach($html->find('font#productMainName') as $a)
	$result['title']=$a->plaintext;

	//保留两位小数
	foreach($html->find('span#nonMemberPrice') as $a){
	$str = $a->innertext;
	 $result['price']=floor($str);
	
	}
	
	
	$i=0;
	foreach($html->find('ul#detailPictureSlider li img') as $a){
		$result['img'][$i]["url"]=str_replace("60x60","380x380",$a->src);
		if($i>2){
			break;
		}
		$i++;
	}
	print_r($result);
	exit;
	return $result;
}
//search taobaoke
function searchTaobaoke($items){
	$list ='<div class="tmall_product">
							<div class="tmall_img" style="overflow:hidden">
								<div class="tmall_box_price">￥ '.$items->price.'</div>
								<img class="tmall_product_img" width="214px;" height="211px" src="'.$items->pic_url.'_460x460.jpg"/>
								<div class="quick_look hide"></div>
							</div>
							<div class="tmall_product_imformation">
								<span class="tmall_from">www.taobao.com</span>
								<div class="tmall_view fr">
								<form name="formAddress" id="formAddress" class="ov search_box" action="/publish/index.php" method="post">
								<input type="hidden" name="action" value="shop"> <input type="hidden" name="type" value="tmall"><input type="hidden" name="method" value="addGoods">	
								<input name="GoodsURL"  type="hidden" value="http://item.taobao.com/item.htm?id='.$items->num_iid.'">
								<input class="submit_view" type="submit" value="View"/>
								</form>
								</div>
							</div>
						</div>					
						<div class="quick_look_out hide">
						<div class="quick_look_bar">
							<span class="quick_look_cl">x</span>
						</div>
						<table class="quick_look_table">
							<tr>
								<td>
									<img class="tmall_product_img" width="275px;" src="'.$items->pic_url.'_460x460.jpg"/>
								</td>
								<td>
									<table class="quick_look_detail_table">
									<tr>
										<td colspan=2>The link of item <br/><input type="text" value="'.$items->click_url.'"/></td>
									</tr>
									<tr>
										<td colspan=2>Name&Description <br/><input style="margin-bottom:20px;" type="text" value="'.$items->title.'"/></td>
									</tr>
									<tr>
										<td width="77px"><span>Price (single)</td><td><sup style="vertical-align: top; font-size: 19px;color:#F89606">￥</sup><span class="quick_look_price">'.$items->price.'</span></td>
									</tr>
									<tr>
										<td><span>Seller Freight</span></td><td> <span class="quick_freight">￥15.00</span></td>
									</tr>
									<tr>
										<td colspan=2>
										<a class="quick_more" href="'.$items->click_url.'"></a>
										<form name="formAddress" id="formAddress" class="ov search_box" action="/publish/index.php" method="post">
										<input type="hidden" name="action" value="shop"> <input type="hidden" name="type" value="tmall"><input type="hidden" name="method" value="addGoods">	
										<input name="GoodsURL"  type="hidden" value="http://item.taobao.com/item.htm?id='.$items->num_iid.'">
										<input class="quick_buy" type="submit" value=""/>
										</form></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						</div>';
	return $list;
}

//tmall Api get and post

function getTmallImformation($track_iid){

	//	$word=runFunc('translate',array($searchword));
	$c = new TopClient;
	$c->appkey = "12666932";
	$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
	$req = new TaobaokeItemsDetailGetRequest();
	$req->setTrackIids($track_iid);
	$req->setFields("pic_url,click_url,title,num_iid,price");
//	$req->setNick("ivisionstudio");
	
	$resp = $c->execute($req);
	
	$list=$resp->taobaoke_item_details->taobaoke_item_detail;

	if($list){
		$result = "";
		foreach ($list as $items){
//print_r($items);
			$result .='<li><div class="tmall_product">
							<div class="tmall_img" style="overflow:hidden">
								<div class="tmall_box_price">￥ '.$items->item->price.'</div>
								<img class="tmall_product_img" width="214px;" height="211px" src="'.$items->item->pic_url.'_460x460.jpg"/>
								<div class="quick_look hide"></div>
							</div>
							<div class="tmall_product_imformation">
								<span class="tmall_from">www.taobao.com</span>
								<div class="tmall_view fr">
								<form name="formAddress" id="formAddress" class="ov search_box" action="/publish/index.php" method="post">
								<input type="hidden" name="action" value="shop"> 
								<input type="hidden" name="type" value="tmall">
								<input type="hidden" name="method" value="addGoods">	
								<input name="GoodsURL"  type="hidden" value="http://item.taobao.com/item.htm?id='.$items->item->num_iid.'">
								<input class="submit_view" type="submit" value="View"/>
								</form>
								</div>
							</div>
						</div>					
						<div class="quick_look_out hide">
						<div class="quick_look_bar">
							<span class="quick_look_cl">x</span>
						</div>
						<table class="quick_look_table">
							<tr>
								<td>
									<img class="tmall_product_img" width="275px;" src="'.$items->item->pic_url.'_460x460.jpg"/>
								</td>
								<td>
									<table class="quick_look_detail_table">
									<tr>
										<td colspan=2>The link of item <br/><input type="text" value="'.$items->click_url.'"/></td>
									</tr>
									<tr>
										<td colspan=2>Name&Description <br/><input style="margin-bottom:20px;" type="text" value="'.$items->item->title.'"/></td>
									</tr>
									<tr>
										<td width="77px"><span>Price (single)</td><td><sup style="vertical-align: top; font-size: 19px;color:#F89606">￥</sup><span class="quick_look_price">'.$items->item->price.'</span></td>
									</tr>
									<tr>
										<td><span>Seller Freight</span></td><td> <span class="quick_freight">￥15.00</span></td>
									</tr>
									<tr>
										<td colspan=2>
										<a target="_blank" class="quick_more" href="'.$items->click_url.'"></a>
										<form name="formAddress" id="formAddress" class="ov search_box" action="/publish/index.php" method="post">
										<input type="hidden" name="action" value="shop"> <input type="hidden" name="type" value="tmall"><input type="hidden" name="method" value="addGoods">	
										<input name="GoodsURL"  type="hidden" value="http://item.taobao.com/item.htm?id='.$items->item->num_iid.'">
										<input class="quick_buy" type="submit" value=""/>
										</form></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						</div></li>';
		}
		return $result;

	}
	else{
		return false;
	}

}
function tmallUrl($cid,$page=1,$word){
	return "index.php".runFunc('encrypt_url',array('action=shop&method=tmall&content='.$word.'&cid='.$cid.'&page='.$page));
}

function tmallLists($cid,$page=1,$word){
	if($page<1){
	 $page = 1;
	}
	if ($word){
		$page = 1;
		$w = runFunc('translate',array($word) );
		if($w)
			$word=$w;

		$c = new TopClient;
		$c->appkey = "12666932";
		$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
		$req = new TaobaokeItemsGetRequest();
		$req->setPid("668155");
		$req->setKeyword($word);
		$req->setFields("cid,num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume");
		$req->setNick("ivisionstudio");
		$resp = $c->execute($req);
		$items=$resp->taobaoke_items->taobaoke_item;
	}

	else {
		//进入页面默认分类
		$c = new TopClient;
		$c->appkey = "12666932";
		$c->secretKey = "52ed26db2c1dcc3b06523748b59eeb18";
		$req = new TmallSelectedItemsSearchRequest();
		if($cid=="" || $cid == 0){
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
			$items = getItemsByCid($cid, $c);
		}
	}
 	$result_count = count($items);

	$rowsPerPage = 9;

	$start = $rowsPerPage * ($page - 1);

	$end = $start + $rowsPerPage - 1;

	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}

	$page_down=$page+1;
	$page_up=$page-1;
	if($page_up <= 0){
		$page_up=1;
	}
	if($page_down >= $page_count){
		$page_down=$page_count;
	}

	if($word) {
		for($start;$start<=$end;$start++){
			if(isset($items[$start])){
				$item =searchTaobaoke($items[$start]);
				
				if($item){
						echo "<li>".$item."</li>";
				}
			}
		}
	}
	else {
		$tids = array();
		for($start;$start<=$end;$start++){
			if(isset($items[$start])){
				$tids []= $items[$start]->track_iid;
			}
		}
		echo getTmallImformation(implode(',',$tids));
	}
}
