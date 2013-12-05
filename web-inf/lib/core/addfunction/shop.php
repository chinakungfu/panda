<?php
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');

function getShopBrandTagById($id){

	$sql = "select * from  cms_product_brand_tag where id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}


function getAllShopsBrandByTagId($id){

	$sql = "select b.* from cms_product_brand_tag_xref as x left join cms_product_brand as b on b.id = x.brand_id where publish_type = 2 and x.tag_id = '{$id}' order by b.special DESC,b.title ASC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAllShopBrandTags(){

	$sql = "select * from  cms_product_brand_tag where published = 1 order by name asc";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getAllShopsBrandCategoryById($id){

	$sql = "select * from  cms_product_brand_category where id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAllShopsBrandCategory(){

	$sql = "select * from  cms_product_brand_category where published = 1 order by special DESC,name ASC";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAllShopsBrandByCategoryId($id,$limit=false){

	if($limit==true){

		$sql = "select * from cms_product_brand where publish_type = 2 and category_id = '{$id}' order by special DESC,title ASC limit 0,8";
	}else{

		$sql = "select * from cms_product_brand where publish_type = 2 and category_id = '{$id}' order by special DESC,title ASC";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}
function getAllShopsBrandByRecommended($id,$limit=false){
	if($id == 'all'){
		if($limit==true){
			$sql = "select * from cms_product_brand where published = 1 and special = 1 order by id DESC limit 0,".$limit;
		}else{
			$sql = "select * from cms_product_brand where published = 1 and special = 1 order by id DESC";
		}
	}else{
		if($limit==true){
			$sql = "select * from cms_product_brand where published = 1 and special = 1 and category_id = '{$id}' order by id DESC limit 0,".$limit;
		}else{
			$sql = "select * from cms_product_brand where published = 1 and special = 1 and category_id = '{$id}' order by id DESC";
		}
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}
function getIndexBrandByRecommended($id,$limit=false){
	if($id == 'all'){
		if($limit==true){
			$sql = "select * from cms_product_brand where published = 1 and special = 2 order by id DESC limit 0,".$limit;
		}else{
			$sql = "select * from cms_product_brand where published = 1 and special = 2 order by id DESC";
		}
	}else{
		if($limit==true){
			$sql = "select * from cms_product_brand where published = 1 and special = 2 and category_id = '{$id}' order by id DESC limit 0,".$limit;
		}else{
			$sql = "select * from cms_product_brand where published = 1 and special = 2 and category_id = '{$id}' order by id DESC";
		}
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}
function getCustomPageFromAdminById($id){

	$sql = "select * from  cms_custom_page where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getCustomPageFromAdmin($position){

	$sql = "select * from  cms_custom_page where position = '$position' and publish = 1";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getSiteAdv($position,$class=null){

	$sql = "select * from  cms_advertising where position = '$position' and publish = 1";

	$advs = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$html = "";
	if(count($advs)>0){
	foreach($advs as $key=>$adv){
		if($key>0){

			$second_adv = "second_adv";
		}
		if($adv["type"]==1){
			$imgs = runFunc("getAdvertisingBanner",array($adv["id"]));
			if(count($imgs)>0){
			list($width, $height, $type, $attr) = getimagesize('../adv_banners/'.$imgs[0]["img"]);
			$html .= '<div class="banner_box '.$second_adv.' '.$class.'" style="width:'.$width.'px;height:'.$height.'px">';
			foreach($imgs as $key=>$img){
				$html .= '<a target="_blank" href='.$img["link"].'><img ';
				if($key !=0){
					$html .= 'class="hide"';
				}
				$html.= ' src="../adv_banners/'.$img["img"].'" alt="" />';
			}
			$html .= '</a></div>';
			if(count($imgs)>1){

				$html .='<script type="text/javascript">
					$(function(){


							var active_adv_img_num = 1;
							var img_count = $(".banner_box img").length;
							var adv_timer = 1;

							function adv_img_roll(){

									$(".banner_box img").fadeOut(900);
									$(".banner_box img").eq(active_adv_img_num).fadeIn(900);

									active_adv_img_num = Number(active_adv_img_num) + 1;
									if(Number(active_adv_img_num) == img_count){
										active_adv_img_num =0;
									}
								}
							function setadvtime(){
								clearInterval(adv_timer);
								adv_timer = setInterval(adv_img_roll,8000);
							}
							setadvtime();

						});
				</script>';
			}
			}

		}elseif($adv["type"]==2){


			$html .= '<div class="adv_content '.$second_adv.'  '.$class.'">'.$adv["content"].'</div>';
		}

	}
	}

	return $html;

}

function updateCartOrderId($order_id,$cartStr){

	$sql = "update cms_publish_cart set order_id = '{$order_id}' where cartID in ({$cartStr})";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function addUserCredit($credit,$user_id){


	$sql = "update cms_member_staff set credits = credits + {$credit} where staffId = '{$user_id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function getMemberCoupons($code){

	$sql = "select * from cms_member_coupons where code = '{$code}' and end_time >= CURRENT_DATE";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function updateOrderAmount($id,$dataArray){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_order set $sql where orderID = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);


}

function useMemberCoupons($id,$dataArray){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_member_coupons set $sql where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function updateCartTax($cartStr,$tax=0){

	$sql = "update cms_publish_cart set tax = '{$tax}' where cartID in ({$cartStr})";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getGroupPurchasedCount($group_id){

	$sql = "select count(*) as count from cms_publish_cart where ItemGoodsID = '{$group_id}' and order_item_status > 0 and cart_type = 2";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function updateBlanceCartPay($cart_str){

	$sql = "update cms_publish_cart set order_item_status = 5 where cartID in ({$cart_str})";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function updateOrderCartStr($cart_str,$order_id){

	$sql = "update cms_publish_order set cartIDstr = '{$cart_str}' where orderID ='{$order_id}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function countMemberGroupBuyOrderPay($user_id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = '{$user_id}' and group_buy = 1 and orderStatus < 5 and totalAmount >0";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function countMemberGroupBuyCartConirm($user_id){

	$sql = "select count(*) as count from cms_publish_cart where UserName = '{$user_id}' and cart_type = 2 and order_item_status =3";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getCartById($id){

	$sql = "select * from cms_publish_cart where cartID = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}


function getGroupCartPriceTypeTotal($user_id,$cartIdStr){
	if($cartIdStr==false){

		$sql ="SELECT sum(ItemQTY) as ItemQTY,sum(ItemQTY*itemPrice) as totalPrice FROM cms_publish_cart  where cart_type = 2 and ItemStatus = 'NEW' and UserName = '{$user_id}'";
	}else{

		$sql ="SELECT sum(ItemQTY) as ItemQTY,sum(ItemQTY*itemPrice) as totalPrice,sum(itemFreight) as itemFreight FROM cms_publish_cart  where cart_type = 2 and ItemStatus = 'NEW' and UserName = '{$user_id}' and cartID in ({$cartIdStr})";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getCartGoodsItem($id){
	$sql = "select * from cms_publish_goods where goodsid =  '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getGoodsItem($name){
	$sql = "select * from cms_publish_goods where goodsTitleCN = '{$name}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getCartItemsById($id,$type=false){

	if($type==false){
		$sql = "select * from cms_publish_cart where UserName =  '{$id}' and ItemStatus = 'NEW' order by cartID DESC";
	}else{

		$sql = "select * from cms_publish_cart where UserName =  '{$id}' and ItemStatus = 'NEW' and cart_type = '{$type}' order by cartID DESC";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}
function getOrderItemsById($cartID,$type='Order'){

	$sql = "select * from cms_publish_cart where cartID =  '{$cartID}' and ItemStatus = '{$type}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];
}
function getTaobaoHotBrands($cat_id){


	$sql = "select * from cms_hot_brand where published = 1 and cat_id = '{$cat_id}'";


	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getTaobaoHotBrandCategories(){


	$sql = "select * from cms_hot_brand_category where published = 1 order by name";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getGiftCardByUserId($user_id,$unUsed = false){


	if($unUsed){
		$sql = "select * from cms_member_gift_card where user_id = '{$user_id}' and status =1  order by created DESC";

	}else{
		$sql = "select * from cms_member_gift_card where user_id = '{$user_id}' and status >0 order by created DESC";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function usingGiftCard($user_id,$card_id){


	$used_time = date("Y-m-d H:i:s");
	$sql = "update cms_member_gift_card set status = '2',used_by = '{$user_id}'	,used_time = '{$used_time}' where id = '{$card_id}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function giftCardCheck($card_password){

	$sql = "select * from cms_member_gift_card where password = '{$card_password}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function setUnionCheck($check,$order_id){

	$sql = "update cms_publish_order set union_pay_check = '{$check}' where orderID = '{$order_id}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function makeFacebookProfile($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_profile (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function addFacebookStaff($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_member_staff (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function checkFaceBookUser($facebook_id){


	$sql = "select staffId from cms_member_staff where facebook_id = '{$facebook_id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0]["staffId"];

}

function updateRechargeOrderStatus($id){

	$sql = "update cms_publish_recharge_order set status = 2 where id = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function userCredits($user_id,$credits){

	$sql = "update cms_member_staff set credits = credits - {$credits} where staffId = '{$user_id}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function addUserBalance($user_id,$balance){

	$sql = "update cms_member_staff set balance = balance + {$balance} where staffId = '{$user_id}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getRechargeOrder($id){

	$sql = "select * from cms_publish_recharge_order where id = {$id}";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function successOrderByOrderNo($orderNo){

	$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = 5 where OrderNo = '{$orderNo}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function markOrderPayment($payment,$orderID){

	$sql = "update {$GLOBALS['table']['publish']['order']} set payment = '{$payment}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getMyOrderByStatus($user_id,$status){

	$sql = "select * from cms_publish_order where orderUser = {$user_id} and orderStatus = '{$status}' and group_buy = 0 order by orderTime DESC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getMyOrderCountByStatus($user_id,$status){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$user_id} and orderStatus = '{$status}' and group_buy = 0 and totalAmount>0";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function accountPageNavi($action,$method,$result_count,$rowsPerPage,$page=1,$searchType = 'normal',$searchMonth = 1,$fromTime=null,$endTime=null,$searchOrderNo=null,$searchByInfo=null){

	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}

	if($page_count<2){
		return false;
	}

	$minpage = get_account_minpage($page,$page_count);
	$maxpage = get_account_maxpage($page,$page_count);
	$navi = "<div class='account_page_nav'>";
	if($page > 1)$navi.= "<a class='account_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMonth=".$searchMonth."&fromTime=".$fromTime."&endTime=".$endTime."&searchOrderNo=".$searchOrderNo."&searchByInfo=".$searchByInfo."&page=".($page-1)))."'><</a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMonth=".$searchMonth."&fromTime=".$fromTime."&endTime=".$endTime."&searchOrderNo=".$searchOrderNo."&searchByInfo=".$searchByInfo."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='account_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMonth=".$searchMonth."&fromTime=".$fromTime."&endTime=".$endTime."&searchOrderNo=".$searchOrderNo."&searchByInfo=".$searchByInfo."&page=".($page+1)))."'>></a>";
	$navi .="<span class='account_page_counter'>共".$page_count."页</span>";
	$navi .="</div>";
	//$navi = '<a>'.$action.$method.$result_count.$rowsPerPage.$page.$searchType.$searchMonth.'</a>';
	return $navi;
}
function orderPageNavi($action,$method,$result_count,$rowsPerPage,$page=1,$searchType = 'normal',$searchMode = 1,$fromTime=null,$endTime=null,$searchOrderNo=null,$searchOrderStatus=0,$searchServiceStatus=0,$fastOrderStatus=100){

	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}

	if($page_count<2){
		return false;
	}

	$minpage = get_account_minpage($page,$page_count);
	$maxpage = get_account_maxpage($page,$page_count);
	$navi = "<div class='account_page_nav'>";
	if($page > 1)$navi.= "<a class='account_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMode=".$searchMode."&fromTime=".$fromTime."&endTime=".$endTime."&searchOrderNo=".$searchOrderNo."&searchOrderStatus=".$searchOrderStatus."&searchServiceStatus=".$searchServiceStatus."&fastOrderStatus=".$fastOrderStatus."&page=".($page-1)))."'><</a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMode=".$searchMode."&fromTime=".$fromTime."&endTime=".$endTime."&searchOrderNo=".$searchOrderNo."&searchOrderStatus=".$searchOrderStatus."&searchServiceStatus=".$searchServiceStatus."&fastOrderStatus=".$fastOrderStatus."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='account_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMode=".$searchMode."&fromTime=".$fromTime."&endTime=".$endTime."&searchOrderNo=".$searchOrderNo."&searchOrderStatus=".$searchOrderStatus."&searchServiceStatus=".$searchServiceStatus."&fastOrderStatus=".$fastOrderStatus."&page=".($page+1)))."'>></a>";
	$navi .="<span class='account_page_counter'>共".$page_count."页</span>";
	$navi .="</div>";
	//$navi = '<a>'.$action.$method.$result_count.$rowsPerPage.$page.$searchType.$searchMonth.'</a>';
	return $navi;
}
function phoneOrderPageNavi($action,$method,$result_count,$rowsPerPage,$page=1,$searchOrderStatus=0,$searchOrderPayment=0){

	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}

	if($page_count<2){
		return false;
	}

	$minpage = get_account_minpage($page,$page_count);
	$maxpage = get_account_maxpage($page,$page_count);
	$navi = "<div class='account_page_nav'>";
	if($page > 1)$navi.= "<a class='account_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchOrderStatus=".$searchOrderStatus."&searchOrderPayment=".$searchOrderPayment."&page=".($page-1)))."'><</a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchOrderStatus=".$searchOrderStatus."&searchOrderPayment=".$searchOrderPayment."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='account_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchOrderStatus=".$searchOrderStatus."&searchOrderPayment=".$searchOrderPayment."&page=".($page+1)))."'>></a>";
	$navi .="<span class='account_page_counter'>共".$page_count."页</span>";
	$navi .="</div>";
	//$navi = '<a>'.$action.$method.$result_count.$rowsPerPage.$page.$searchType.$searchMonth.'</a>';
	return $navi;
}
function get_account_minpage($page,$countpage)
{
	$minpage = $page-5;
	if($page+5 >= $countpage)
	{
		$minpage = $minpage-(5-($countpage-$page));
	}else{
		if($minpage <=1){
			$minpage = 1;
		}
	}
	return $minpage;
}
//取最大页
function get_account_maxpage($page,$countpage)
{
	$maxpage = $page+5;
	if($page-5 <= 1)
	{
		$maxpage = $maxpage-($page-6);
	}
	if($maxpage >= $countpage)
	{
		$maxpage = $countpage;
	}
	return $maxpage;
}






function final_order_confirm($orderID){

	$date = date("Y-m-d H:i:s");
	$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = 8,confirmTime = '{$date}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function deleteAddressById($id,$user_id){

	$sql = "delete from cms_publish_address where addressId = '{$id}' and userId = '{$user_id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getUserAddressByUserId($user_id){

	$sql = "select addressId,Mr,firstName,lastName,address1,address2,city,province,country,zipcode,telephone,cellphone,email,set_default,addressCN1,addressCN2,cityCN,provinceCN,countryCN from cms_publish_address where userId = '{$user_id}' order by set_default DESC,addressId DESC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}
function getUserAddressByAddressId($user_id,$address_id){

	$sql = "select addressId,Mr,firstName,lastName,address1,address2,city,province,country,zipcode,telephone,cellphone,email,set_default,addressCN1,addressCN2,cityCN,provinceCN,countryCN from cms_publish_address where userId = '{$user_id}' and addressId = '{$address_id}' order by addressId DESC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function checkMailExist($email){

	$sql = "select count(*) as count from cms_member_staff where email = '{$email}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];

}

function getUserAddressByUserIdDefault($user_id){

	$sql = "select * from cms_publish_address where userId = '{$user_id}' and  set_default  = 1";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];
}

function updateShippingAddress($id,$user_id,$dataArray){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_address set $sql where userId = '{$user_id}' and addressId = '{$id}'";

	$addressid = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

	return $addressid;
}

function createShippingAddress($dataArray){
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_publish_address (".$str_field.") values (".$str_value.")";
	$addressid = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $addressid;
}
function addItemErrorData($dataArray){
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_publish_errorgoods (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}
function setDefauleAddress($id,$user_id){

	unsetDefaultAddress($user_id);

	$sql = "update cms_publish_address set set_default = 1 where addressId = '{$id}' and userId = '{$user_id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function unsetDefaultAddress($user_id){

	$sql = "update cms_publish_address set set_default = 0 where userId = '{$user_id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getShippingCountries(){

	$sql = "SELECT * FROM cms_country";

	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $results;
}

function getShopItemList($user_id,$goodsShopId,$status='New'){

	$sql = "SELECT *,a.props as cart_props FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$user_id}' and a.ItemStatus = '{$status}' and b.goodsShopId = '{$goodsShopId}' and cart_type = 1 Order By a.cartID DESC";
	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $results;
}

function getOrderInfoById($id){

	$sql = "select * from cms_publish_order as a LEFT JOIN cms_publish_address as b ON a.orderAddress = b.addressId where orderID = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];

}

function getOrderCartStrByOrderId($id){

	$sql = "select * from cms_publish_order where orderID = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];
}
function getOrderShopItemByCartStr($user_id,$goodsShopId,$cart_str,$status='Order'){

	$sql = "SELECT *,a.props as cart_props FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$user_id}' and a.ItemStatus = '{$status}' and b.goodsShopId = '{$goodsShopId}' and a.cartID in ({$cart_str}) and a.cart_type = 1 Order By a.cartID DESC";

	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $results;
}
function getOrderItemByCartStr($cart_str,$count_qty=false){

	if($count_qty==true){
		$sql = "select sum(c.ItemQTY) as qty_count from cms_publish_cart as c left join cms_publish_goods as g on c.ItemGoodsID = g.goodsid where c.cartID in ({$cart_str})";
	}
	else
	{
		$sql = "select * from cms_publish_goods as g left join cms_publish_cart as c on g.goodsid = c.ItemGoodsID where c.cartID in ({$cart_str})";
	}
	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $results;
}

function remakeOrderAmount($cartStr,$order_id,$invoice){

	$amount = makeOrderAmout($cartStr);
	$settings = getGlobalSetting();
	$shopNum = makeOrderFreight($cartStr);
	$freight = $shopNum*$settings[0]["freight"];//总运费
	$service_fee = 0;
	$items = runFunc("getGroupBuyByCart",array($cartStr));

	foreach($items as $item){

		if($item["group_buy_off"]==1)continue;


		if($item["sell_way"] == 1){

			$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $item["price_rate"]* $settings[0]["service_fee"];
		}else{

			$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $settings[0]["service_fee"];
		}
	}

	if($invoice == 1){

		$tax = ($service_fee + $amount["amount"] + $freight["amount"]) * $settings[0]["tax_rate"];
	}else{

		$tax = 0;
	}


	$dataArray["order_amount"] = $amount["amount"];
	$dataArray["order_freight"] = $freight;
	$dataArray["tax"] = $tax;
	$dataArray["service_fee"] = $service_fee;
	$dataArray["totalAmount"] = $amount["amount"]+$freight + $dataArray["service_fee"] + $dataArray["tax"];

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_order set $sql where orderID = {$order_id}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function updateCartQty($qty,$cart_id){

	$sql = "update cms_publish_cart set ItemQTY = '{$qty}' where cartID = '{$cart_id}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function updateCartDetail($qty,$info,$cart_id){

	$dataArray["itemNotes"] = $info;
	$dataArray["ItemQTY"] = $qty;

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_cart set $sql where cartID = {$cart_id}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function updateUserOrderModify($cartStr,$order_id,$invoice,$group_buy,$dataArray){

	$amount = makeOrderAmout($cartStr);

	$settings = getGlobalSetting();
	$shopNum = makeOrderFreight($cartStr);
	$freight = $shopNum*$settings[0]["freight"];//总运费

	$service_fee = 0;
	$items = runFunc("getOrderItemByCartStr",array($cartStr));
	if($group_buy==1){

		foreach($items as $item){
			if($item["group_buy_off"]==1)continue;
			$group_buy_item = runFunc("getSiteGroupBuyItem",array($item["goodsid"]));
			if($group_buy_item[0]["sell_way"] == 1){
				$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $group_buy_item[0]["price_rate"]* $settings[0]["service_fee"];

			}else{
				$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $settings[0]["service_fee"];
			}
		}
	}else{
		foreach($items as $item){
			if($item["ItemType"] == "ivi"){
				$service_fee += 0;
			}else{
				$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $settings[0]["service_fee"];
			}
		}
		//$service_fee = $amount["amount"] * $settings[0]["service_fee"];
/*		if($service_fee<20 && $service_fee > 0){
			$service_fee = 20;
		}*/
	}

	if($invoice == 1){
		$tax = ($service_fee + $amount["amount"] + $freight["amount"]) * $settings[0]["tax_rate"];
	}else{
		$tax = 0;
	}

	$dataArray["order_amount"] = $amount["amount"];
	$dataArray["order_freight"] = $freight["amount"];
	$dataArray["tax"] = $tax;
	$dataArray["service_fee"] = $service_fee;
	$dataArray["totalAmount"] = $amount["amount"]+$freight["amount"] + $dataArray["service_fee"] + $dataArray["tax"];

	$sql = '';

	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_order set $sql where orderID = {$order_id}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function addCartToOrder($user_id,$orderAddressId,$cartStr,$invoice,$invoiceTitle,$invoiceNum,$group_buy=false,$pending,$isRequest){
	$settings = getGlobalSetting();
	$amount = makeOrderAmout($cartStr);
	$shopNum = makeOrderFreight($cartStr);
	$freight = $shopNum*$settings[0]["freight"];//总运费
	$address = getUserAddressById($orderAddressId);
	$service_fee = 0;
	$isivision = false;
	if($group_buy==true){

		$items = runFunc("getUserCart",array($user_id,false,2));
		foreach($items as $item){
			if($item["group_buy_off"]==1)continue;
			$group_buy_item = runFunc("getSiteGroupBuyItem",array($item["goodsid"]));
			if($group_buy_item[0]["sell_way"] == 1){

				$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $group_buy_item[0]["price_rate"]* $settings[0]["service_fee"];

			}else{

				$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $settings[0]["service_fee"];

			}
		}

	}else{
		$service_fee = $settings[0]["service_fee"]*$amount["amount"];//所有商品服务费
	}

	if($invoice == 1){
		$tax = ($service_fee + $amount["amount"] + $freight) * $settings[0]["tax_rate"];
		$dataArray["invoiceTitle"] = $invoiceTitle;
		$dataArray["invoiceNum"] = $invoiceNum;
	}else{
		$tax = 0;
	}

	$dataArray["nodeId"] = "OrderQJHD";

	//生成订单号
	//$dataArray["OrderNo"] = strtotime(date("Y-m-d H:i:s",time())) . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
	$dataArray["OrderNo"] = getOrderNo();

	$dataArray["cartIDstr"] = $cartStr;
	$dataArray["orderUser"] = $user_id;
	$dataArray["orderTime"] = time();
	$dataArray["orderTime_n"] = date("Y-m-d H:i:s");
	$dataArray["orderStatus"] = 4;
	$dataArray["service_fee"] = $service_fee;		//总服务费
	$dataArray["order_amount"] = $amount["amount"];	//商品总价
	$dataArray["order_freight"] = $freight;			//总运费
	$dataArray["invoice"] = $invoice;
	$dataArray["tax"] = $tax;						//税价
	$dataArray["orderAddress"] = $orderAddressId;
	$dataArray["pending"] = $pending;
	$dataArray["isRequest"] = $isRequest;


	$dataArray["totalAmount"] = $amount["amount"]+$freight + $dataArray["service_fee"] + $dataArray["tax"];	//总总价钱
	if($group_buy==true){
		$dataArray["group_buy"] = 1;
	}
	if($isivision){
		$dataArray["isivision"] = 1;
	}

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);

	//生成订单
	$sql = "insert into cms_publish_order (".$str_field.") values (".$str_value.")";
	$order_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	//处理购物车
	$sql2 = "update cms_publish_cart set ItemStatus = 'Order',order_item_status = '{$dataArray["orderStatus"]}' where cartID in ({$cartStr})";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql2);
	return $order_id;
}
function insertOrderItem($order_id,$cartStr,$orderItemTable){
	$cartArr = explode(',',$cartStr);
	foreach($cartArr as $k => $v){
		$sql = "SELECT * from cms_publish_cart where cartID = {$v}";
		$cartInfo = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		$insertsql = "insert into {$orderItemTable} (orderID,cartID,goodsid,goodsModifyPrice,goodsStatus,goodsNotes,goodsProps,goodsBuyTime,goodsIsModifyPrice) values ('{$order_id}','{$cartInfo[0]['cartID']}','{$cartInfo[0]['ItemGoodsID']}','{$cartInfo[0]['itemPrice']}','4','{$cartInfo[0]['itemNotes']}','{$cartInfo[0]['props']}','{$OrderItemTime}','{$cartInfo[0]['modifyPrice']}')";
		$orderItemID = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$insertsql);
	}
}
function getOrderNo(){
	$sql = "SELECT OrderNo from cms_publish_order order by orderID desc";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$lastOrderNo = $result[0]['OrderNo'];
	$lastOrderNoPrev  = substr($lastOrderNo,0,6);
	$lastOrderNoNext  = substr($lastOrderNo,6);

	$date = date('y').date('m').date('d');
	if($lastOrderNoPrev == $date){
		$orderNoNext = str_pad(((int)$lastOrderNoNext + 1), 5, '0', STR_PAD_LEFT);
		$returnOrderNo = $date.$orderNoNext;
	}else{
		$returnOrderNo = $date.'00001';
	}
	return $returnOrderNo;
}
function makeOrderFreight($cartStr){

	$sql = "SELECT b.goodsShopId FROM cms_publish_cart a,cms_publish_goods b WHERE a.ItemGoodsID=b.goodsid  and cartID in ({$cartStr}) Group By b.goodsShopId";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$shopNum = count($result);//商店数目
	return $shopNum;

}
function getPhoneOrderNo(){
	$sql = "SELECT orderNo from cms_publish_phone_order order by id desc";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$lastOrderNo = $result[0]['orderNo'];
	$lastOrderNoPrev  = substr($lastOrderNo,1,6);
	$lastOrderNoNext  = substr($lastOrderNo,7);

	$date = date('y').date('m').date('d');
	if($lastOrderNoPrev == $date){
		$orderNoNext = str_pad(((int)$lastOrderNoNext + 1), 5, '0', STR_PAD_LEFT);
		$returnOrderNo = "M".$date.$orderNoNext;
	}else{
		$returnOrderNo = "M".$date.'00001';
	}
	return $returnOrderNo;
}
/**
 *更新订单商品信息
 **/
function updateItemInfoByCartstr($userID,$cartStr,$dataArray)
{
	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_cart set $sql where UserName = {$userID} and cartID in ({$cartStr})";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}
function makeOrderAmout($cartStr){

	$sql = "select sum(itemTotal) as amount,sum(pay_back_money) as refundAmount,sum(purchaseTotal) as purchaseAmount from cms_publish_cart where cartID in ({$cartStr}) and group_buy_off = 0";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];

}

function getUserAddressById($id){

	$sql = "select * from cms_publish_address where addressId = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];
}

function getUserCartStr($user_id,$cart_type=1){

	$carts = getUserCart($user_id,false,$cart_type);

	$carts_array=array();

	foreach($carts as $cart){
		$carts_array[] = $cart[cartID];
	}

	$carts_str = implode(",", $carts_array);

	return $carts_str;
}

function getGlobalSetting(){

	$sql = "select * from cms_website_global_setting";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getUserCart($user_id,$count_qty=false,$cart_type=1,$cartStr){

	if($count_qty==true){
		if($cartStr){
			$sql = "select sum(c.ItemQTY) as qty_count from cms_publish_cart as c left join cms_publish_goods as g on c.ItemGoodsID = g.goodsid where UserName = '{$user_id}' and ItemStatus ='NEW' and cart_type = '{$cart_type}' and cartID in ({$cartStr})";
		}else{
			$sql = "select sum(c.ItemQTY) as qty_count from cms_publish_cart as c left join cms_publish_goods as g on c.ItemGoodsID = g.goodsid where UserName = '{$user_id}' and ItemStatus ='NEW' and cart_type = '{$cart_type}'";
		}


	}else{
		if($cartStr){
			$sql = "select c.cartID,c.props as cart_props,c.itemFreight,c.ItemQTY,c.itemPrice,c.group_buy_off,c.itemNotes,c.ItemType,g.* from cms_publish_cart as c left join cms_publish_goods as g on c.ItemGoodsID = g.goodsid where UserName = '{$user_id}' and ItemStatus ='NEW' and cart_type = '{$cart_type}' and cartID in ({$cartStr}) order by cartID DESC";
		}else{
			$sql = "select c.cartID,c.props as cart_props,c.itemFreight,c.ItemQTY,c.itemPrice,c.group_buy_off,c.itemNotes,c.ItemType,g.* from cms_publish_cart as c left join cms_publish_goods as g on c.ItemGoodsID = g.goodsid where UserName = '{$user_id}' and ItemStatus ='NEW' and cart_type = '{$cart_type}' order by cartID DESC";
		}

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function notice_page($title,$alert_title,$alert_content,$link_action,$link_method){

	$ul=array('action=website&method=notice&title='.$title.'&alert_title='.$alert_title.'&alert_content='.$alert_content.'&link_action='.$link_action.'&link_method='.$link_method);
	$url = runFunc('encrypt_url',$ul);
	header("location:index.php" . $url);


}
function notice_newpage($title_h1,$title_h2,$alert_content,$link_action,$link_method){

	$ul=array('action=website&method=newNotice&title_h1='.$title_h1.'&title_h2='.$title_h2.'&alert_content='.$alert_content.'&link_action='.$link_action.'&link_method='.$link_method);
	$url = runFunc('encrypt_url',$ul);
	header("location:index.php" . $url);
}
function saveMessages($get,$staffId){

	if($get["send_wow"]==on){
		$type=1;//站内回复
	}
	if ($get["send_mail"]==on){
		$type=2;//邮件回复
	}
	else{
		$type=3;//both
	}


	$dataArray["staff_id"] = $staffId;
	$dataArray["created"] = date("Y-m-d H:i:s");
	$dataArray["type"] = $type;
	$dataArray["content"] = $get["content"];


	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into {$GLOBALS['table']['publish']['messages']} (".$str_field.") values (".$str_value.")";
	$post_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);




}
//****************字符串截取*************************
function g_substr($str, $len = 12, $dot = true) {
	$i = 0;
	$l = 0;
	$c = 0;
	$a = array();
	while ($l < $len) {
		$t = substr($str, $i, 1);
		if (ord($t) >= 224) {
			$c = 3;
			$t = substr($str, $i, $c);
			$l += 2;
		} elseif (ord($t) >= 192) {
			$c = 2;
			$t = substr($str, $i, $c);
			$l += 2;
		} else {
			$c = 1;
			$l++;
		}
		// $t = substr($str, $i, $c);
		$i += $c;
		if ($l > $len) break;
		$a[] = $t;
	}
	$re = implode('', $a);
	if (substr($str, $i, 1) !== false) {
		array_pop($a);
		($c == 1) and array_pop($a);
		$re = implode('', $a);
		$dot and $re .= '...';
	}
	return $re;
}
function checkInviteEmail($inviteEmail){

	if (!preg_match('/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i',$inviteEmail)) {
	    $result['status'] = -1;
	}else{
		$sql1 = "select staffId from cms_member_staff where email = '{$inviteEmail}'";
		$query1 = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql1);

		$sql2 = "select id from cms_member_invite where inviteEmail = '{$inviteEmail}'";
		$query2 = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql2);
		if($query1[0]['staffId']){
			$result['status'] = -2;
		}else if($query2[0]['id']){
			$result['status'] = -3;
		}else{
			$result['status'] = 1;
		}
	}
	return $result;
}
function addInviteEmail($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_member_invite (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}
function updateInviteStatus($type,$inviteEmail,$userID){
	$updateTime = time();
	if($type == 'reg'){
		$sql = "update cms_member_invite set status = '2',regTime = '{$updateTime}' where inviteEmail = '{$inviteEmail}' and userID = '{$userID}'";
	}else if($type == 'pay'){
		$sql = "update cms_member_invite set status = '3',payTime = '{$updateTime}' where inviteEmail = '{$inviteEmail}' and userID = '{$userID}'";
	}
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}
function getNotice(){
	$sql = "select * from cms_publish_notice where published = 1 and content != '' order by updated desc limit 1";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}
?>
