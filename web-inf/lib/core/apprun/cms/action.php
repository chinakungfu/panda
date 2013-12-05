<?

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.spell_class');

function getBrandTags($id){
	$sql = "select b.* from cms_product_brand_tag_xref as a left join cms_product_brand_tag as b on a.tag_id = b.id where a.brand_id = '{$id}' order by a.id ASC";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function saveBrandTags($brand_id,$tag_id){

	$sql = "insert into cms_product_brand_tag_xref (tag_id,brand_id) values ('{$tag_id}','{$brand_id}')";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
}

function deleteBrandTags($brand_id){

	$sql = "delete from cms_product_brand_tag_xref where brand_id in ({$brand_id})";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function deleteBrandTag($id){

	$sql = "delete from cms_product_brand_tag where id IN ($id) ";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function deleteBrandCategory($id){

	$sql = "delete from cms_product_brand_category where id IN ($id) ";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getAdminBrandTag($id){

	$sql = "select * from cms_product_brand_tag where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getAdminBrandtags($page,$size,$count=false,$sort=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count==true){


		$sql = "select count(*) as count from cms_product_brand_tag order by id desc";
	}
	else{
		if($sort!=null){
			$sql = "select * from cms_product_brand_tag order by id asc";
		}else{

			$sql = "select * from cms_product_brand_tag order by id desc";
		}

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getAdminBrandCategory($id){

	$sql = "select * from cms_product_brand_category where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getAdminBrandCategories($page,$size,$count=false,$status=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and published=1";
				break;
			case 2:
				$filter_sql = " and published=0";
				break;
			case 3:
				$filter_sql = " and special=1";
				break;
			case 4:
				$filter_sql = " and special=0";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($count==true){

		$sql = "select count(*) as count from cms_product_brand_category where id >0";
		$order_sql = " order by id desc";
		$sql .= $filter_sql.$order_sql;
	}
	else{

		$sql = "select * from cms_product_brand_category where id >0";
		$order_sql = " order by id desc";
		$sql .= $filter_sql.$order_sql;
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function saveBrandCategory(){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_product_brand_category (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function adminGetRechargeOrder($page,$size,$count=false,$search_word=null){
	if($page <=0){
		$page = 1;
	}
	$page = $page * $size - $size;
	$order = " order by id desc ";
	if($search_word!=null){
		$search_sql = " and (m.staffNo LIKE '%{$search_word}%' or m.staffName LIKE '%{$search_word}%' or m.email LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}
	if($key!=null){
		$order = " order by {$key} {$sort}";
	}else{
		$order = " order by id desc";
	}
	if($count == true){
		$sql = "select count(*) as count from cms_publish_recharge_order as o left join cms_member_staff as m on o.user_id = m.staffId  where o.status =2";
		$sql.= $search_sql.$filter_sql;
	}else{
		$sql = "select * from cms_publish_recharge_order as o left join cms_member_staff as m on o.user_id = m.staffId where o.status =2";
		$limit = " limit {$page},{$size}";
		$sql.= $search_sql.$order.$limit;
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminSaveTags($dataArray){


	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_product_tag (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function getAllLogs($page,$size,$count=false,$start=null,$end=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by id desc";
	}

	if($start!=null){

		$start_sql = " and e.created >= '{$start}'";
	}else{

		$start_sql = "";
	}

	if($end!=null){

		$end_sql = " and e.created <= '{$end}'";
	}else{

		$end_sql = "";
	}


	if($count == true){

			$sql = "select count(*) as count from cms_manger_logs as e where e.id > 0";
			$sql .= $start_sql.$end_sql;

	}else{

			$sql = "select * from cms_manger_logs as e left join cms_member_staff as m on e.user_id = m.staffId where id > 0";


		$limit = " limit {$page},{$size}";

		$sql.= $start_sql.$end_sql.$order.$limit;


	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function makeAdminLog($word,$user_id){

	$dataArray = array("word"=>$word,"created"=>date("Y-m-d H:i:s"),"user_id"=>$user_id);

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_manger_logs (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function makeGoodTags($dataArray){


	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into  cms_product_tag (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function deleteManagerPermission($id){

	$sql = "delete from cms_manager_permission where id IN ($id) ";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getManagerPermissionById($id){

	$sql = "select * from cms_manager_permission where id = '{$id}' ";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getManagerPermission($page,$size,$count=false,$sort=null,$key=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by id desc";
	}


	if($count == true){

			$sql = "select count(*) as count from cms_manager_permission";


	}else{

			$sql = "select * from cms_manager_permission";

		$limit = " limit {$page},{$size}";

		$sql.= $order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function saveManagerPermission($dataArray){


	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_manager_permission (".$str_field.") values (".$str_value.")";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function updateManagerPermission($dataArray,$id){


		$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	echo $sql = "update cms_manager_permission set $sql where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function getSellsTotal($year=null,$month=null,$day=null,$type){


	$sql = "select cartIDstr from cms_publish_order where orderStatus > 4";

	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(payTime) = '{$year}'";
	}else{

		$year_sql = " and YEAR(payTime) = '{$year}'";
	}

	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(payTime) = '{$month}'";
	}else{

		$month_sql = " and MONTH(payTime) = '{$month}'";
	}

	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(payTime) = '{$day}'";
	}

	$sql .= $year_sql.$month_sql.$day_sql;

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	foreach ($result as $order){


		$cartArray[] = $order["cartIDstr"];
	}

	if(count($cartArray)>0){
		$cartStr = implode(",", $cartArray);
	}else{

		$cartStr = "";
	}

	$count = getAllOrderCartStrByOrder($cartStr,$type);

	return $count;

}


function getAllOrderCartStrByOrder($cartStr,$type){

	if($cartStr == ""){

		$result["count"] = 0;
	}else{
	$sql = "select count(*) as count from cms_publish_cart as c left join cms_publish_goods as g on c.ItemGoodsID = g.goodsid where cartID IN({$cartStr}) and g.goodsType = '{$type}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	}
	return $result;
}

function getSocialPollTotal($year=null,$month=null,$day=null){



	$sql = "select count(*) as count from cms_share_polls where id >0";

	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(created) = '{$year}'";
	}else{

		$year_sql = " and YEAR(created) = '{$year}'";
	}

	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(created) = '{$month}'";
	}else{

		$month_sql = " and MONTH(created) = '{$month}'";
	}

	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(created) = '{$day}'";
	}

$sql .= $year_sql.$month_sql.$day_sql;

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getSocialEventTotal($year=null,$month=null,$day=null){



	$sql = "select count(*) as count from cms_share_event where id >0";

	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(created) = '{$year}'";
	}else{

		$year_sql = " and YEAR(created) = '{$year}'";
	}

	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(created) = '{$month}'";
	}else{

		$month_sql = " and MONTH(created) = '{$month}'";
	}

	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(created) = '{$day}'";
	}

$sql .= $year_sql.$month_sql.$day_sql;

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getSocialCirclePostTotal($year=null,$month=null,$day=null){



	$sql = "select count(*) as count from cms_share_circle_post where id >0";

	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(created) = '{$year}'";
	}else{

		$year_sql = " and YEAR(created) = '{$year}'";
	}

	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(created) = '{$month}'";
	}else{

		$month_sql = " and MONTH(created) = '{$month}'";
	}

	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(created) = '{$day}'";
	}

$sql .= $year_sql.$month_sql.$day_sql;

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getSocialCircleTotal($year=null,$month=null,$day=null){



	$sql = "select count(*) as count from cms_share_circle where id >0";

	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(created) = '{$year}'";
	}else{

		$year_sql = " and YEAR(created) = '{$year}'";
	}

	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(created) = '{$month}'";
	}else{

		$month_sql = " and MONTH(created) = '{$month}'";
	}

	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(created) = '{$day}'";
	}

$sql .= $year_sql.$month_sql.$day_sql;

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getSocialListTotal($year=null,$month=null,$day=null){



	$sql = "select count(*) as count from cms_share_list where id >0";

	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(created) = '{$year}'";
	}else{

		$year_sql = " and YEAR(created) = '{$year}'";
	}

	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(created) = '{$month}'";
	}else{

		$month_sql = " and MONTH(created) = '{$month}'";
	}

	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(created) = '{$day}'";
	}

$sql .= $year_sql.$month_sql.$day_sql;

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getUserTotal($year=null,$month=null,$day=null){
	$sql = "select count(*) as count from cms_member_staff where groupName = 'Verified Member'";
	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(registerDate) = '{$year}'";
	}else{

		$year_sql = " and YEAR(registerDate) = '{$year}'";
	}
	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(registerDate) = '{$month}'";
	}else{

		$month_sql = " and MONTH(registerDate) = '{$month}'";
	}
	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(registerDate) = '{$day}'";
	}
	$sql .= $year_sql.$month_sql.$day_sql;
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getRechargePayTotal($amount=1,$year=null,$month=null,$day=null){
	if($amount==1){
		$sql = "select count(*) as count from cms_publish_recharge_order where status > 1";
	}else{

		$sql = "select SUM(recharge) as count from cms_publish_recharge_order where status > 1";
	}
	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(created) = '{$year}'";
	}else{

		$year_sql = " and YEAR(created) = '{$year}'";
	}

	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(created) = '{$month}'";
	}else{

		$month_sql = " and MONTH(created) = '{$month}'";
	}

	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(created) = '{$day}'";
	}

$sql .= $year_sql.$month_sql.$day_sql;

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getOrderSuccessPayTotal($amount=1,$year=null,$month=null,$day=null){


	if($amount==1){
		$sql = "select count(*) as count from cms_publish_order where orderStatus > 4";
	}else{

		$sql = "select SUM(totalAmount) as count from cms_publish_order where orderStatus > 4";
	}
	if($year ==null){
		$year = date("Y");
		$year_sql = " and YEAR(payTime) = '{$year}'";
	}else{

		$year_sql = " and YEAR(payTime) = '{$year}'";
	}

	if($month ==null){
		$month = date("m");
		$month_sql = " and MONTH(payTime) = '{$month}'";
	}else{

		$month_sql = " and MONTH(payTime) = '{$month}'";
	}

	if($day ==null){

		$day_sql = "";
	}else{

		$day_sql = " and DAY(payTime) = '{$day}'";
	}

$sql .= $year_sql.$month_sql.$day_sql;

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function deleteCustomPage($id){

	$sql = "delete from cms_custom_page where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function updateCustomPage($dataArray,$id){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_custom_page set $sql where id = {$id}";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function getCustomPage($id){

	$sql = "select * from cms_custom_page where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getCustomPageList($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$position=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by id desc ";

	if($position!=null){

		$position_sql = " and position = '{$position}'";

	}else{

		$position_sql = "";
	}


	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and publish=1";
				break;
			case 2:
				$filter_sql = " and publish=0";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (title LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by id desc";
	}


	if($count == true){



		$sql = "select count(*) as count from  cms_custom_page where id >0";


		$sql.= $search_sql.$position_sql.$type_sql.$filter_sql;

	}else{


		$sql = "select * from cms_custom_page where id >0";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$position_sql.$type_sql.$filter_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function saveCustomPage($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_custom_page (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

	return $result;

}

function deleteAdvertising($id){

	$sql = "delete from cms_advertising where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function deleteAdvertisingBanner($id){

	$sql = "delete from cms_advertising_banner where id = {$id}";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function advertisingUpdate($dataArray,$id){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_advertising set $sql where id = {$id}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function updateAdvertisingBanner($dataArray,$id){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_advertising_banner set $sql where id = {$id}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function getAdvertisingBannerById($id){

	$sql = "select * from  cms_advertising_banner where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getAdvertisingBanner($id){

	$sql = "select * from  cms_advertising_banner where adv_id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getAdvertisingById($id){

	$sql = "select * from  cms_advertising where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getAdvertising($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$position=null,$type=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by id desc ";

	if($position!=null){

		$position_sql = " and position = '{$position}'";

	}else{

		$position_sql = "";
	}

if($type!=null){

		$type_sql = " and type = '{$type}'";

	}else{

		$type_sql = "";
	}

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and publish=1";
				break;
			case 2:
				$filter_sql = " and publish=0";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (title LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by id desc";
	}


	if($count == true){



		$sql = "select count(*) as count from  cms_advertising where id >0";


		$sql.= $search_sql.$position_sql.$type_sql.$filter_sql;

	}else{


		$sql = "select * from cms_advertising where id >0";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$position_sql.$type_sql.$filter_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function advertisingBannerSave($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_advertising_banner (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function advertisingSave($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_advertising (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;

}

function adminUserVerify($id){

	$sql = "update cms_member_staff set groupName = 'Verified Member',verifyDate = '".date("Y-m-d H:i:s")."' where staffId IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function memberMessageBlockMail($type,$about_id){


	switch ($type){

		case "Style List":

			$item = runFunc("adminGetStyleListById",array($about_id));
			if($item[0]["block"]!=1){
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("恢复 Style List 发布 ".$item[0]["title"],$uid));
				return false;
			}
			$mailArray = array(
			"WARNING_CONTENT" =>$item[0]["title"],
			"WARNING_TYPE" =>$type,
			"userId"=>$item[0]["user_id"]
			);

			$uid=runFunc('readSession',array());
			runFunc("makeAdminLog",array("阻止 Style List 发布 ".$item[0]["title"],$uid));
			break;


		case "Circle":

			$item = runFunc("adminGetCircle",array($about_id));
			if($item[0]["block"]!=1){
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("恢复 圈子 发布 ".$item[0]["name"],$uid));
				return false;
			}
			$mailArray = array(
			"WARNING_CONTENT" =>$item[0]["name"],
			"WARNING_TYPE" =>$type,
			"userId"=>$item[0]["user_id"]
			);

			$uid=runFunc('readSession',array());
			runFunc("makeAdminLog",array("阻止 圈子 发布 ".$item[0]["name"],$uid));
			break;

		case "Circle Post":

			$item = runFunc("adminGetCirclePost",array($about_id));
			if($item[0]["block"]!=1){
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("恢复 圈子Post 发布 ".$item[0]["title"],$uid));

				return false;
			}
			$mailArray = array(
			"WARNING_CONTENT" =>$item[0]["title"],
			"WARNING_TYPE" =>$type,
			"userId"=>$item[0]["user_id"]
			);

			$uid=runFunc('readSession',array());
			runFunc("makeAdminLog",array("阻止 圈子Post 发布 ".$item[0]["title"],$uid));

			break;

		case "Event":

			$item = runFunc("adminGetMemberEvent",array($about_id));
			if($item[0]["event_block"]!=1){
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("恢复 活动 发布 ".$item[0]["name"],$uid));
				return false;
			}
			$mailArray = array(
			"WARNING_CONTENT" =>$item[0]["name"],
			"WARNING_TYPE" =>$type,
			"userId"=>$item[0]["user_id"]
			);

			$uid=runFunc('readSession',array());
			runFunc("makeAdminLog",array("阻止 活动 发布 ".$item[0]["name"],$uid));
			break;

		case "Poll":

			$item = runFunc("adminGetPollById",array($about_id));
			if($item[0]["block"]!=1){
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("恢复 投票 发布 ".$item[0]["name"],$uid));
				return false;
			}
			$mailArray = array(
			"WARNING_CONTENT" =>$item[0]["name"],
			"WARNING_TYPE" =>$type,
			"userId"=>$item[0]["user_id"]
			);

			$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("阻止 投票 发布 ".$item[0]["name"],$uid));
			break;

		case "Comment":

			$item = runFunc("adminGetComment",array($about_id));
			if($item[0]["comment_block"]!=1){
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("恢复 评论 发布 ".$item[0]["comment"],$uid));
				return false;
			}
			$mailArray = array(
			"WARNING_CONTENT" =>$item[0]["comment"],
			"WARNING_TYPE" =>$type,
			"userId"=>$item[0]["user_id"]
			);
			$uid=runFunc('readSession',array());
			runFunc("makeAdminLog",array("阻止 评论 发布 ".$item[0]["comment"],$uid));
			break;

		case "Poll Vote Comment":

			$item = runFunc("getAdminVoteComment",array($about_id));
			if($item[0]["block"]!=1){
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("恢复 投票评论 发布 ".$item[0]["comment"],$uid));
				return false;
			}
			$mailArray = array(
			"WARNING_CONTENT" =>$item[0]["comment"],
			"WARNING_TYPE" =>$type,
			"userId"=>$item[0]["user_id"]
			);

				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("阻止 投票评论 发布 ".$item[0]["comment"],$uid));
			break;


	}

	runFunc('sendMail',array($mailArray,"block_warning"));
}

function getAdminVoteComment($id){

	$sql = "select * from cms_share_poll_item_vote where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function memberEventBackToList($id){


	$sql = "update cms_share_event set status = 1 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function memberEventFinal($id){

	$sql = "delete from cms_share_event where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function memberEventDelete($id){

	$sql = "update cms_share_event set status = 0 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function memberEventBlock($id){

	$sql = "update cms_share_event set block = !block where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminGetEventMember($id){

	$sql = "select * from cms_share_event_member as e left join cms_member_staff as m on e.user_id = m.staffId where e.event_id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function adminGetEventTime($id){

	$sql = "select * from cms_share_event_time where event_id = '{$id}' order by start_date ASC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function adminGetMemberEvent($id){

	$sql = "select c.*,c.block as event_block,circle.name as circle_name,circle.id as circle_id,(select count(*) from cms_share_event_member where event_id = c.id) as member_count,m.staffName from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId left join cms_share_circle as circle on c.circle_id = circle.id where c.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminGetMemberEventList($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$recycle=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and c.block=0";
				break;
			case 2:
				$filter_sql = " and c.block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (m.staffName LIKE '%{$search_word}%' or m.staffNo LIKE '%{$search_word}%' or c.name LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by c.id desc";
	}


	if($count == true){

		if($recycle==true){


			$sql = "select count(*) as count from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0 and c.official = 0";
		}else{

			$sql = "select count(*) as count from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0 and c.official = 0";
		}

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql;

	}else{
		if($recycle==true){

			$sql = "select c.*,m.staffName from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0 and c.official = 0";
		}else{

			$sql = "select c.*,m.staffName from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0 and c.official = 0";
		}




		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminUpdateSpamStatus($status,$id){

	$sql = "update cms_sparm set status = '{$status}' where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminGetVoteComment($about_id){

	$sql = "select *,p.name as poll_name,p.id as poll_id from cms_share_poll_item_vote as v left join cms_share_poll_item as vi on v.item_id = vi.id left join cms_share_polls as p on p.id = vi.poll_id left join cms_member_staff as m on v.user_id = m.staffId where v.id = '{$about_id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminGetSpam($id){


	$sql = "select c.*,c.status as spam_status,m.staffName from cms_sparm as c left join cms_member_staff as m on c.user_id = m.staffId  where c.id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function adminGetSpamContent($type,$about_id){

	switch ($type){

		case "COMMENT":

			$sql = "select * from cms_member_comment where id = '{$about_id}'";

			break;

		case "VOTE COMMENT":

			$sql = "select * from cms_share_poll_item_vote where id = '{$about_id}'";

			break;


	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminGetSpams($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and c.status=1";
				break;
			case 2:
				$filter_sql = " and c.status=0";
				break;
			case 3:
				$filter_sql = " and c.status=2";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (m.staffName LIKE '%{$search_word}%' or m.staffNo LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by c.id desc";
	}


	if($count == true){



		$sql = "select count(*) as count from cms_sparm as c left join cms_member_staff as m on c.user_id = m.staffId  where c.id >0";

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql;

	}else{


		$sql = "select c.*,m.staffName from cms_sparm as c left join cms_member_staff as m on c.user_id = m.staffId  where c.id >0";





		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function pollBackToList($id){


	$sql = "update cms_share_polls set status = 1 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function pollDeleteFinal($id){

	$sql = "delete from cms_share_polls where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminPollDelete($id){

	$sql = "update cms_share_polls set status = 0 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function pollBlock($id){

	$sql = "update cms_share_polls set block = !block where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function voteCommentBlock($id){

	$sql = "update cms_share_poll_item_vote set block = !block where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminGetPollItemVote($id){
	$sql = "select *,c.block as vote_block from cms_share_poll_item_vote as c left join cms_member_staff as m on c.user_id = m.staffId where item_id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminGetPollItem($id){

	$sql = "select *,i.id as poll_item_id from cms_share_poll_item as i left join cms_publish_goods as g on i.goods_id = g.goodsid left join cms_share_polls as p on i.poll_id = p.id where i.poll_id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminGetPollById($id){

	$sql = "select c.*,m.staffName from cms_share_polls as c left join cms_member_staff as m on c.user_id = m.staffId where c.id = '{$id}' ";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function adminGetPolls($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$recycle=false){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and c.block=0";
				break;
			case 2:
				$filter_sql = " and c.block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (m.staffName LIKE '%{$search_word}%' or c.title LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by c.id desc";
	}


	if($count == true){

		if($recycle==true){


			$sql = "select count(*) as count from cms_share_polls as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0";
		}else{

			$sql = "select count(*) as count from cms_share_polls as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0";
		}

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql;

	}else{
		if($recycle==true){

			$sql = "select c.*,m.staffName from cms_share_polls as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0";
		}else{

			$sql = "select c.*,m.staffName from cms_share_polls as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0";
		}




		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminCommentBlock($id){

	$sql = "update cms_member_comment set block = !block where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function adminGetCommentByAboutId($about_id,$type){

	$sql = "select a.*,b.staffName,b.headImageUrl from cms_member_comment as a left join cms_member_staff as b on a.user_id = b.staffId where a.about_id = {$about_id} and a.type = '{$type}' order by created DESC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function styleListBackToList($id){


	$sql = "update cms_share_list set status = 1 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function styleListDeleteFinal($id){

	$sql = "delete from cms_share_list where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminstyleListDelete($id){

	$sql = "update cms_share_list set status = 0 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function styleListBlock($id){

	$sql = "update cms_share_list set block = !block where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminGetStyleItem($id){

	$sql = "select a.id as list_item_id, a.title as list_item_title,a.description as list_item_desc ,b.*,(select count(*) from cms_member_comment where about_id = a.id and type='LIST GOODS') as comment_count from cms_share_list_item as a left join cms_publish_goods as b on a.good_id  = b.goodsid where a.list_id = {$id} order by id asc";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function adminGetStyleListById($id){

	$sql = "select c.*,m.staffName from cms_share_list as c left join cms_member_staff as m on c.user_id = m.staffId  where c.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminGetStyleList($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$recycle=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";

	if($circle_id!=null){

		$circle_id_sql = " and c.circle_id = '{$circle_id}'";

	}else{

		$circle_id_sql = "";
	}

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and c.block=0";
				break;
			case 2:
				$filter_sql = " and c.block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (m.staffName LIKE '%{$search_word}%' or c.title LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by c.id desc";
	}


	if($count == true){

		if($recycle==true){


			$sql = "select count(*) as count from cms_share_list as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0";
		}else{

			$sql = "select count(*) as count from cms_share_list as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0";
		}

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql;

	}else{
		if($recycle==true){

			$sql = "select c.*,m.staffName from cms_share_list as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0";
		}else{

			$sql = "select c.*,m.staffName from cms_share_list as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0";
		}




		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function circleCategoryDelete($id){

	$sql = "delete from cms_share_circle_tag where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getCircleCategory($id){

	$sql = "select * from cms_share_circle_tag where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function circleCategoryUpdate($dataArray){


	$sql ="";
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_share_circle_tag set $sql where id=:id";


	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function circleCategoryAdd($dataArray){


	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_circle_tag (".$str_field.") values (".$str_value.")";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function adminGetCircleCategories($page,$size,$count=false,$status=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by id desc ";

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and published=1";
				break;
			case 2:
				$filter_sql = " and published=0";
				break;
		}
	}else{

		$filter_sql = "";
	}


	if($count==true){

		$sql = "select count(*) as count from cms_share_circle_tag where id >0";
		$sql .=$filter_sql;
	}
	else{

		$sql = "select * from cms_share_circle_tag where id >0";

		$limit = " limit {$page},{$size}";

		$sql .= $filter_sql.$order.$limit;
	}


	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function circlePostBackToList($id){


	$sql = "update cms_share_circle_post set status = 1 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function circlePostDeleteFinal($id){

	$sql = "delete from cms_share_circle_post where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminCirclePostDelete($id){

	$sql = "update cms_share_circle_post set status = 0 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function circlePostBlock($id){

	$sql = "update cms_share_circle_post set block = !block where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminGetCirclePostImg($id){

	$sql ="select * from cms_share_circle_post_img where post_id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function adminGetCirclePost($id){

	$sql = "select circle.name as c_name,circle.id as c_id,c.*,m.staffName,(select count(*) from cms_member_comment where about_id = c.id and type='CIRCLE POST') as comment_count from cms_share_circle_post as c left join cms_member_staff as m on c.user_id = m.staffId left join cms_share_circle as circle on c.circle_id = circle.id  where c.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminGetCirclePosts($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$about=null,$recycle=false,$circle_id=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";

	if($circle_id!=null){

		$circle_id_sql = " and c.circle_id = '{$circle_id}'";

	}else{

		$circle_id_sql = "";
	}

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and c.block=0";
				break;
			case 2:
				$filter_sql = " and c.block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}





	if($search_word!=null){
		$search_sql = " and (m.staffName LIKE '%{$search_word}%' or c.title LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by c.id desc";
	}


	if($count == true){

		if($recycle==true){


			$sql = "select count(*) as count from cms_share_circle_post as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0";
		}else{

			$sql = "select count(*) as count from cms_share_circle_post as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0";
		}

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql;

	}else{
		if($recycle==true){

			$sql = "select c.*,m.staffName,(select count(*) from cms_member_comment where about_id = c.id and type='CIRCLE POST') as comment_count from cms_share_circle_post as c left join cms_member_staff as m on c.user_id = m.staffId left join cms_share_circle as circle on c.circle_id = circle.id  where c.status =0";
		}else{

			$sql = "select c.*,m.staffName,(select count(*) from cms_member_comment where about_id = c.id and type='CIRCLE POST') as comment_count from cms_share_circle_post as c left join cms_member_staff as m on c.user_id = m.staffId left join cms_share_circle as circle on c.circle_id = circle.id  where c.status >0";
		}




		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function circleBackToList($id){


	$sql = "update cms_share_circle set status = 1 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function circleDeleteFinal($id){

	$sql = "delete from cms_share_circle where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminCircleDelete($id){

	$sql = "update cms_share_circle set status = 0 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminGetCircleMembers($id){

	$sql = "select * from cms_share_circle_member as a left join cms_member_staff as b on a.user_id = b.staffId  where a.circle_id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function circleBlock($id){

	$sql = "update cms_share_circle set block = !block where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function adminGetCircle($id){

	$sql ="select c.*,m.staffName,t.title,(select count(*) from cms_share_circle_member where circle_id = c.id) as member_count,(select count(*) from cms_share_circle_post where circle_id = c.id) as post_count from cms_share_circle as c left join cms_member_staff as m on c.user_id = m.staffId left join cms_share_circle_tag as t on t.id = c.about where c.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getAllCircleTags(){

	$sql = "select * from cms_share_circle_tag where published = 1";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function adminGetCircles($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$about=null,$recycle=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";


	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and c.block=0";
				break;
			case 2:
				$filter_sql = " and c.block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}


	if($about!=null){

		$about_sql = " and about = '{$about}'";


	}else{

		$about_sql = "";
	}




	if($search_word!=null){
		$search_sql = " and (m.staffName LIKE '%{$search_word}%' or c.name LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by c.id desc";
	}


	if($count == true){

		if($recycle==true){


			$sql = "select count(*) as count from cms_share_circle as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0";
		}else{

			$sql = "select count(*) as count from cms_share_circle as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0";
		}

		$sql.= $search_sql.$about_sql.$filter_sql.$obj_sql;

	}else{
		if($recycle==true){

			$sql = "select c.*,m.staffName,t.title,(select count(*) from cms_share_circle_member where circle_id = c.id) as member_count from cms_share_circle as c left join cms_member_staff as m on c.user_id = m.staffId left join cms_share_circle_tag as t on t.id = c.about where c.status =0";
		}else{

			$sql = "select c.*,m.staffName,t.title,(select count(*) from cms_share_circle_member where circle_id = c.id) as member_count from cms_share_circle as c left join cms_member_staff as m on c.user_id = m.staffId left join cms_share_circle_tag as t on t.id = c.about where c.status >0";
		}




		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$about_sql.$filter_sql.$obj_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function commentBackToList($id){

	$sql = "update cms_member_comment set status = 1 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function commentDeleteFinal($id){

	$sql = "delete from cms_member_comment where id IN ({$id})";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminCommentDelete($id){

	$sql = "update cms_member_comment set status = 0 where id IN ({$id})";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function commentBlock($id){

	$sql = "update cms_member_comment set comment_block = !comment_block where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function getSpamCommentObj($type,$id){


	switch ($type){

		case "GOODS":

			$sql = "select * from cms_publish_goods where goodsid = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = "/publish/index.php".runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$id."&show_type=collections&from=collections_page"));

			$name = $result[0]["goodsTitleCN"];

			break;

		case "GROUP BUY GOODS":

			$sql = "select * from cms_share_group_buy where id = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = "/publish/index.php".runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$id));

			$name = $result[0]["item_name"];

			break;

		case "EVENT":

			$sql = "select * from cms_share_event where id = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = "/publish/index.php".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$id));

			$name = $result[0]["name"];

			break;

		case "CIRCLE POST":

			$sql = "select * from cms_share_circle_post as p left join cms_share_circle as c on p.circle_id = c.id where p.id = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = "/publish/index.php".runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$id.'&circle_id='.$result[0]["circle_id"]));

			$name = $result[0]["name"];

			break;

		case "LIST GOODS":

			$sql = "select * from cms_publish_goods where goodsid = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = "/publish/index.php".runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$id."&show_type=normal&from=style_list"));

			$name = $result[0]["goodsTitleCN"];

			break;

	}

	$comment_about = array("title"=>$name,"link"=>$link);

	return $comment_about;
}

function getCommentObj($type,$id){

	switch ($type){

		case "GOODS":

			$sql = "select * from cms_publish_goods where goodsid = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = runFunc('encrypt_url',array('action=cms&method=product_edit&type=products&id='.$id));

			$name = $result[0]["goodsTitleCN"];

			break;

		case "GROUP BUY GOODS":

			$sql = "select * from cms_share_group_buy where id = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			if($result[0]["offcial"]==1){

				$link = runFunc('encrypt_url',array('action=cms&method=adminGroupBuyEdit&id='.$id.'&type=share'));
			}else{

				$link = runFunc('encrypt_url',array('action=cms&method=memeberGroupBuyShow&id='.$id.'&type=share'));
			}

			$name = $result[0]["item_name"];

			break;

		case "EVENT":

			$sql = "select * from cms_share_event where id = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = runFunc('encrypt_url',array('action=cms&method=event_show&type=share&id='.$id));

			$name = $result[0]["name"];

			break;

		case "CIRCLE POST":

			$sql = "select * from cms_share_circle_post as p left join cms_share_circle as c on p.circle_id = c.id where p.id = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = runFunc('encrypt_url',array('action=cms&method=circle_post_show&type=share&id='.$id));

			$name = $result[0]["name"];

			break;

		case "LIST GOODS":

			$sql = "select * from cms_share_list_item where goodsid = '{$id}'";

			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$link = runFunc('encrypt_url',array('action=cms&method=product_edit&type=products&id='.$id));

			$name = $result[0]["goodsTitleCN"];

			break;

	}

	$comment_about = array("title"=>$name,"link"=>$link);

	return $comment_about;
}

function adminGetComment($id){

	$sql = "select *,c.block as comment_block  from cms_member_comment as c left join cms_member_staff as m on c.user_id = m.staffId where c.id ='{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAllComments($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$obj=null,$recycle=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";

	if($obj!=null){

		switch ($obj){
			case 1:
				$obj_sql = " and type='CIRCLE POST'";
				break;
			case 2:
				$obj_sql = " and type='EVENT'";
				break;
			case 3:
				$obj_sql = " and type='GROUP BUY GOODS'";
				break;
			case 4:
				$obj_sql = " and type='LIST GOODS'";
				break;
			case 5:
				$obj_sql = " and type='GOODS'";
				break;
		}
	}else{

		$obj_sql = "";
	}

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and block=0";
				break;
			case 2:
				$filter_sql = " and block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and m.staffName LIKE '%{$search_word}%'";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by c.id desc";
	}


	if($count == true){

		if($recycle==true){

			$sql = "select count(*) as count from cms_member_comment as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0";
		}else{

			$sql = "select count(*) as count from cms_member_comment as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0";
		}


		$sql.= $search_sql.$filter_sql.$obj_sql;

	}else{

		if($recycle==true){

			$sql = "select * from cms_member_comment as c left join cms_member_staff as m on c.user_id = m.staffId where c.status=0";

		}else{
			$sql = "select c.*,m.staffName from cms_member_comment as c left join cms_member_staff as m on c.user_id = m.staffId where c.status >0";
		}

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$filter_sql.$obj_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getUserShippingAddresses($id){

	$sql = "select * from  cms_publish_address where userId = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getOrderMonthCount($month){

	$sql = "select count(*) as count from cms_publish_order where orderStatus >4 and payTime is not null and MONTH(payTime) = '{$month}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0]["count"];

}
function getOrderYearCount($year,$month){

	if($month){
		$sql = "select count(*) as count from cms_publish_order where orderStatus >4 and payTime is not null and MONTH(payTime) = '{$month}' and YEAR(payTime) = '{$year}'";
	}else{
		$sql = "select count(*) as count from cms_publish_order where orderStatus >4 and payTime is not null and YEAR(payTime) = '{$year}'";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0]["count"];

}
function getMainCount($type){

	switch ($type){

		case "Help Message":

			$sql = "select count(*) as count from cms_publish_messages where reply_time is null and ignored = 0";

			break;


		case "Spam":

			$sql = "select count(*) as count from cms_sparm where status = 0 ";

			break;

		case "Register Member":

			$sql = "select count(*) as count from cms_member_staff where DATE(registerDate) = CURRENT_DATE";

			break;

		case "Birth Day Member":
			$month = date("M");
			$day = date("j");
			$sql = "select count(*) as count from cms_profile where DateOfBirth_Month = '{$month}' and  DateOfBirth_Day = '{$day}'";
			break;

		case "Recharge Today":
			$sql = "select count(*) as count from  cms_publish_recharge_order where DATE(created) = CURRENT_DATE and status = 2";
			break;

		case "Order Type 1":

			$sql = "select count(*) as count from cms_publish_order where orderStatus =4 and group_buy =0";
			break;
		case "Order Type 2":

			$sql = "select count(*) as count from cms_publish_order where orderStatus =5 and group_buy =0";
			break;
		case "Order Type 3":

			$sql = "select count(*) as count from cms_publish_order where orderStatus =6 and group_buy =0";
			break;
		case "Order Type 4":

			$sql = "select count(*) as count from cms_publish_order where orderStatus =7 and group_buy =0";
			break;

		case "Order Type 5":

			$sql = "select count(*) as count from cms_publish_order where order_return >0 and orderStatus < 9";
			break;

		case "Group Buy Type 1":

			$sql = "select count(*) as count from cms_share_group_buy where start_time is null";
			break;

		case "Group Buy Type 2":

			$sql = "select count(*) as count from cms_share_group_buy where start_time >= CURRENT_DATE and end_time <= CURRENT_DATE";
			break;

		case "Comment Type 1":

			$sql = "select count(*) as count from cms_member_comment where type = 'LIST GOODS' and DATE(created) = CURRENT_DATE";
			break;

		case "Comment Type 2":

			$sql = "select count(*) as count from cms_member_comment where type = 'EVENT' and DATE(created) = CURRENT_DATE";
			break;

		case "Comment Type 3":

			$sql = "select count(*) as count from cms_member_comment where type = 'CIRCLE POST' and DATE(created) = CURRENT_DATE";
			break;

		case "Comment Type 4":

			$sql = "select count(*) as count from cms_member_comment where type = 'GOODS' and DATE(created) = CURRENT_DATE";
			break;

	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0]["count"];

}

function getOrderStatusCount($type){
	switch ($type){
		case "pending":
			$sql = "select count(*) as count from cms_publish_order where pending = 1 and orderStatus = 4";
			break;
		case "paid":
			$sql = "select count(*) as count from cms_publish_order where orderStatus = 5";
			break;
		case "purchase":
			$sql = "select count(*) as count from cms_publish_order where orderStatus = 6";
			break;
		case "return":
			$sql = "select count(*) as count from cms_publish_order where orderStatus < 19 and (Returned = 1 or replacement = 1)";
			break;
		case "itemRequest":
			$sql = "select count(*) as count from cms_publish_order where isRequest = 1 and orderStatus < 7";
			break;
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0]["count"];
}

function makeManagerProfile($user_id){

	$dataArray = array("user_id"=>$user_id);

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_profile (".$str_field.") values (".$str_value.")";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function getSeoSettings(){

	$sql = "select * from cms_cms_tpl_seo";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function updateSeoSettings($dataArray){

	$sql ="";
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_cms_tpl_seo set $sql";


	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function getGlobalSettingsVar($tplVar){

	$sql = "select * from cms_cms_tpl_vars where varName='".$tplVar."'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];
}

function updateGlobalSettingsVar($dataArray){

	$sql ="";
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_cms_tpl_vars set $sql where varId=:varId";


	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function updateMainSettings($dataArray){

	$sql ="";
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_website_global_setting set $sql";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function adminDeleteUser($ids){

	$sql = "delete from cms_member_staff where staffId in ({$ids})";

	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);


	return $result;

}

function getMangers($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by staffId asc ";

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and block=0";
				break;
			case 2:
				$filter_sql = " and block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and staffNo LIKE '%{$search_word}%'";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by staffId ASC";
	}


	if($count == true){

		$sql = "select count(*) as count from cms_member_staff where groupName ='Site Manager'";
		$sql.= $search_sql.$filter_sql;

	}else{

		$sql = "select *  from cms_member_staff where groupName ='Site Manager'";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$filter_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function adminAddUser($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_member_staff (".$str_field.") values (".$str_value.")";
	$result =  TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

	return $result;
}

function getMemberRechargeRecord($id){

	$sql = "select *  from cms_publish_recharge_order where user_id = '{$id}' and status = 2 order by created DESC";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getMemberSocialCount($user_id){

	$count = array();
	$comment_count = "select count(*) as count from cms_member_comment where user_id = '{$user_id}'";
	$list_count = "select count(*) as count from cms_share_list where user_id = '{$user_id}'";
	$circle_count = "select count(*) as count from cms_share_circle where user_id = '{$user_id}'";
	$circle_join_count = "select count(*) as count from cms_share_circle_member where user_id = '{$user_id}'";
	$event_count = "select count(*) as count from cms_share_event where user_id = '{$user_id}'";
	$event_join_count = "select count(*) as count from cms_share_event_member where user_id = '{$user_id}'";
	$group_buy_count = "select count(*) as count from cms_share_group_buy where user_id = '{$user_id}'";
	$poll_count = "select count(*) as count from cms_share_polls where user_id = '{$user_id}'";
	$poll_vote_count = "select count(*) as count from cms_share_poll_item_vote where user_id = '{$user_id}'";
	$friend_count = "select count(*)  as count from cms_member_friendship where member_one = '{$user_id}' or member_two = '{$user_id}'";


	$count["comment_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$comment_count);
	$count["list_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$list_count);
	$count["circle_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$circle_count);
	$count["circle_join_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$circle_join_count);
	$count["event_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$event_count);
	$count["event_join_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$event_join_count);
	$count["group_buy_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$group_buy_count);
	$count["poll_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$poll_count);
	$count["poll_vote_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$poll_vote_count);
	$count["friend_count"] = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$friend_count);


	return $count;
}

function adminUpdateUser($memberArray){

	$sql ="";
	foreach ($memberArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_member_staff set $sql where staffId=:staffId";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
	return $result;
}



function getUser($id){


	$sql = "select * from cms_member_staff where staffId = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getUsers($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$main_message_link=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by m.staffId desc ";

	switch($main_message_link){

		case "Register":

			$main_sql = " and DATE(m.registerDate) = CURRENT_DATE";
		break;

		case "Birth":

			$main_sql = " and p.DateOfBirth_Month = '{$month}' and  p.DateOfBirth_Day = '{$day}'";
		break;




		default:

			$main_sql = "";


	}

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and m.groupName = 'Verified Member'";
				break;
			case 2:
				$filter_sql = " and m.groupName = 'NoValidation'";
				break;
			case 3:
				$filter_sql = " and m.block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (m.staffNo LIKE '%{$search_word}%' or m.staffName LIKE '%{$search_word}%' or m.email LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by m.staffId desc";
	}


	if($count == true){

		$sql = "select count(*) as count from cms_member_staff as m left join cms_profile as p on m.staffId = p.user_id where m.groupName != 'administrator' and m.groupName !='官方管理员'";
		$sql.= $main_sql.$search_sql.$filter_sql;

	}else{

		$sql = "select *  from cms_member_staff as m left join cms_profile as p on m.staffId = p.user_id where m.groupName != 'administrator' and m.groupName !='官方管理员'";

		$limit = " limit {$page},{$size}";

		$sql.= $main_sql.$search_sql.$filter_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function deleteCoupons($id){

	$sql = "delete from cms_member_coupons where id in ({$id})";

	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getCoupons($page,$size,$count=false,$sort=null,$key=null,$coupon_status=null,$search_word=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by created DESC ";

	if($coupon_status!=null){

		switch ($coupon_status){

			case 1:
				$filter_sql = " and a.type = 1 and user_id is not null";
				break;
			case 2:
				$filter_sql = " and a.type = 1 and user_id is null";
				break;
			case 3:
				$filter_sql = " and a.type = 2 and user_id is not null";
				break;
			case 4:
				$filter_sql = " and a.type = 2 and user_id is null";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " where b.staffName LIKE '%{$search_word}%' or a.code = '".trim($search_word)."'";
	}
	else{$search_sql = " where code is not null";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by id DESC";
	}

	if($count == true){

		$sql = "select count(*) as count from cms_member_coupons as a left join cms_member_staff as b on a.user_id =b.staffId";
		$sql.= $search_sql.$filter_sql;
	}else{

		$sql = "select *  from cms_member_coupons as a left join cms_member_staff as b on a.user_id =b.staffId";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$filter_sql.$order.$limit;
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function makeCoupons($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_member_coupons (".$str_field.") values (".$str_value.")";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function getHelpMessageReplyItem($message_id){

	$sql = "select * from cms_request_answer_item as i left join cms_publish_goods as g on i.goods_id = g.goodsid where i.message_id = '{$message_id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getNewsletterItem($message_id){

	$sql = "select * from cms_newsletters_item as i left join cms_publish_goods as g on i.goods_id = g.goodsid where i.letter_id = '{$message_id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAdminHelpMailItem($message_id){

	$sql = "select * from cms_admin_request_mail_item as i left join cms_publish_goods as g on i.goods_id = g.goodsid where i.mail_id = '{$message_id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function updateHelpMessageReply($reply,$id){

	$dataArray["reply"] = $reply;
	$dataArray["reply_time"] = date("Y-m-d H:i:s");
	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_messages set $sql where id = '{$id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function saveHelpMessageItem($goods_id,$title,$message_id){

	$dataArray["goods_id"] = $goods_id;
	$dataArray["title"] = $title;
	$dataArray["message_id"] = $message_id;
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_request_answer_item (".$str_field.") values (".$str_value.")";
	$message_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function getMemberHelpMessage($id){

	$sql = "select * from  cms_publish_messages as a left join cms_member_staff as b on a.staff_id =b.staffId where a.id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getNewletter($id){

	$sql = "select * from  cms_newsletters where id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getAdminHelpMail($id){

	$sql = "select * from  cms_admin_request_mail where id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getNewletters($page,$size,$count=false,$sort=null,$key=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by created DESC ";


	if($count == true){

		$sql = "select count(*) as count from cms_newsletters";

		$sql.= $search_sql.$filter_sql;
	}else{
		$sql = "select * from cms_newsletters";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$filter_sql.$order.$limit;
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function ignoreMemberHelpMessage($id){

	echo $sql = "update cms_publish_messages set ignored = !ignored where id = '{$id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getMemberHelpMessagesIgnored($page,$size,$count=false,$sort=null,$key=null,$reply_time=null,$search_word=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by created DESC ";

	if($reply_time!=null){
		if($reply_time==1){
			$filter_sql = " and reply_time is null";
		}else{
			$filter_sql = " and reply_time is not null";
		}
	}else{

		$filter_sql = "";
	}

	$search_sql = " where b.staffName LIKE '%{$search_word}%'";


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by id DESC";
	}

	if($count == true){

		$sql = "select count(*) as count from cms_publish_messages as a left join cms_member_staff as b on a.staff_id =b.staffId and a.ignored = 1";

		$sql.= $search_sql.$filter_sql;
	}else{
		$sql = "select * from  cms_publish_messages as a left join cms_member_staff as b on a.staff_id =b.staffId and a.ignored = 1";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$filter_sql.$order.$limit;
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getMemberHelpMessages($page,$size,$count=false,$sort=null,$key=null,$reply_time=null,$search_word=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by created DESC ";

	if($reply_time!=null){
		if($reply_time==1){
			$filter_sql = " and reply_time is null";
		}else{
			$filter_sql = " and reply_time is not null";
		}
	}else{

		$filter_sql = "";
	}

	$search_sql = " where b.staffName LIKE '%{$search_word}%'";


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by id DESC";
	}

	if($count == true){

		$sql = "select count(*) as count from cms_publish_messages as a left join cms_member_staff as b on a.staff_id =b.staffId and a.ignored = 0";

		$sql.= $search_sql.$filter_sql;
	}else{
		$sql = "select * from  cms_publish_messages as a left join cms_member_staff as b on a.staff_id =b.staffId and a.ignored = 0";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$filter_sql.$order.$limit;
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAdminHelpMails($page,$size,$count=false,$search_word=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by created DESC ";



	$search_sql = " where email LIKE '%{$search_word}%'";


	if($count == true){

		$sql = "select count(*) as count from cms_admin_request_mail";

		$sql.= $search_sql.$filter_sql;
	}else{
		$sql = "select * from  cms_admin_request_mail";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$order.$limit;
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAdminMemberInfoAllInOne($staffId){

	$sql = "select * from  cms_member_staff as a left join cms_profile as b on a.staffId =b.user_id where a.staffId = {$staffId}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function AdminGetAllFriend($user_id){


	$sql = "select * from cms_member_friendship where member_one = '{$user_id}' or member_two = '{$user_id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function adminSendFriendNotice($from,$type,$about_id){

	$friends = AdminGetAllFriend($from);
	if(count($friends)>0){
		foreach($friends as $friend){
			if($friend["member_one"] == $user_id){

				$friend_id = $friend["member_two"];
			}else{

				$friend_id = $friend["member_one"];
			}



			adminSendSiteMessage($friend_id,$from,$type,$about_id);
		}
	}

}

function adminSendSiteMessage($to,$from,$type,$about_id,$content=null){
	if($to != $from){
		$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
		switch ($type){



			case "GROUP BUY CREATE":

				$mailArray['userId'] = $to;

				$user_info = getAdminMemberInfoAllInOne($from);
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$group_buy = getMemberGroupBuyItem($about_id);

				if(strlen($group_buy[0]["item_name"])> 30){
					$title =  mb_substr($group_buy[0]["item_name"],0,20,'utf-8')."...";
				}else{
					$title = $group_buy[0]["item_name"];
				}

				$mailArray["sub"] = " create a new group buy:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
				$mailArray["comment_content"] = "";
				runFunc('sendMail',array($mailArray,"comment_notice"));


				break;

				$dataArray["message_to"] = $to;
				$dataArray["message_from"] = $from;
				$dataArray["message_type"] = $type;
				$dataArray["about_id"] = $about_id;
				$dataArray["content"] = $content;
				$dataArray["created"] = date("Y-m-d H:i:s");
				foreach ($dataArray as $key => $val)
				{
					$str_field .= $key.",";
					$str_value .= ":".$key.",";
				}
				$str_field = substr($str_field,0,-1);
				$str_value = substr($str_value,0,-1);
				$sql = "insert into cms_member_message (".$str_field.") values (".$str_value.")";
				$message_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

				return $message_id;
		}

	}

}


function groupBuyRefuse($group_id){


	$sql = "update cms_share_group_buy set refuse = !refuse where id = '{$group_id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);


}

function payBackMoney($money,$user_id){


	$sql = "update cms_member_staff set balance = balance + {$money} where staffId = '{$user_id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);


}

function updateCartPayStatus($cart_id){

	$date = date("Y-m-d H:i:s");
	$sql = "update cms_publish_cart set pay_back = 1,pay_back_time = '{$date}' where cartID = '{$cart_id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function normalCartPayback($cart_id,$pay_back_money,$pay_back_info,$pay_back_message){

	$dataArray["pay_back_time"] = date("Y-m-d H:i:s");
	$dataArray["pay_back"] = 1;
	$dataArray["pay_back_money"] = $pay_back_money;
	$dataArray["pay_back_info"] = $pay_back_info;
	$dataArray["pay_back_message"] = $pay_back_message;

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_cart set $sql where cartID = '{$cart_id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);


}



function getCartPayMoney($cart_id){

	$sql = "select * from cms_publish_cart as c left join cms_share_group_buy as g on c.ItemGoodsID = g.id where c.cartID = '{$cart_id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getGroupBuyCartByGid($gid){


	$sql = "select * from cms_publish_cart where ItemGoodsID = '{$gid}' and order_item_status > 0";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getFailedGroupBuy($page,$size,$count=false,$gid=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count==true){
		$sql = 'select count(*) from cms_share_group_buy as g join (select count(*) as count, g.id from cms_share_group_buy as g join cms_publish_cart as c on c.ItemGoodsID = g.id where c.order_item_status>0 group by g.id ) as t on g.id = t.id  where t.count < g.group_size';
	}else{

		if($gid !=""){

			$sql = "select * from cms_share_group_buy as g join (select count(*) as count, g.id from cms_share_group_buy as g join cms_publish_cart as c on c.ItemGoodsID = g.id where c.order_item_status>0 group by g.id ) as t on g.id = t.id  where t.count < g.group_size and g.id = '{$gid}' order by g.id DESC";
		}else{
			$sql = 'select * from cms_share_group_buy as g join (select count(*) as count, g.id from cms_share_group_buy as g join cms_publish_cart as c on c.ItemGoodsID = g.id where c.order_item_status>0 group by g.id ) as t on g.id = t.id  where t.count < g.group_size order by g.id DESC';
		}

	}


	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getAllAdminGroupBuy(){

	$sql = "select * from cms_share_group_buy where offcial = 1 and end_time >= CURRENT_DATE()";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getAdminGroupPurchasedCount($group_id){

	$sql = "select count(*) as count from cms_publish_cart where ItemGoodsID = '{$group_id}' and order_item_status > 0 and cart_type = 2";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function adminGroupItemUpdate($cart_id,$status){

	$dataArray["order_item_status"] = $status;
	if($status == 2){

		$dataArray["order_item_buy_time"] = date("Y-m-d H:i:s");
	}
	if($status == 3){

		$dataArray["order_item_shipping_time"] = date("Y-m-d H:i:s");
	}

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_cart set $sql where cartID = '{$cart_id}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function adminGetGroupBuyOrderItems($cartIDstr){

	$sql = "select a.order_item_status,a.cartID,a.pay_back_time,a.itemPrice,a.group_buy_off,b.* from cms_publish_cart as a left join cms_share_group_buy as b on a.ItemGoodsID = b.id where a.cartID in ({$cartIDstr})";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function adminGetGroupBuyOrders($page,$size,$count=false){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from  cms_publish_order where group_buy = 1";
	}
	else{

		$sql = "select * from  cms_publish_order where group_buy = 1 and orderStatus<9 order by orderTime DESC";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function deleteAdminHotBrand($id){

	$sql = "delete from cms_hot_brand where id = '{$id}'";

	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function newsletterDelete($id){

	$sql = "delete from cms_newsletters where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getAdminHotBrand($id){

	$sql = "select * from cms_hot_brand where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}


function getAdminHotBrands($page,$size,$count=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from cms_hot_brand ";
	}
	else{

		$sql = "select * from cms_hot_brand limit {$page},{$size}";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function deleteAdminHotBrandCategory($id){

	$sql = "delete from cms_hot_brand_category where id = '{$id}'";

	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getAdminHotBrandCategory($id){

	$sql = "select * from cms_hot_brand_category where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getAdminHotBrandCategories($page,$size,$count=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from cms_hot_brand_category ";
	}
	else{

		$sql = "select * from cms_hot_brand_category";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getMemberGroupBuyItem($id){

	$sql = "select b.*,g.goodsIntro,g.goodsUnitPrice,g.goodsImgURL,g.goodsFreight,g.goodsTitleCN,g.goodsURL,g.click_url from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getAdminGroupBuyItems($page,$size,$count=false,$status=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from cms_share_group_buy ";
	}
	else{
		$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as count,b.*,g.goodsUnitPrice from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid ";


		$where = array();
		switch ($status){

			case 1:
				$where[] = " start_time is null";
				break;
			case 2:
				$where[] = " end_time >= CURRENT_DATE()";
				break;
			case 3:
				$where[] = " end_time < CURRENT_DATE";
				break;
		}

		$order = " order by b.created DESC";
		$limit = " limit {$page},{$size}";
		$where_str = " where b.offcial = 1";
		if(count($where)){

			$where_str .= " and ".implode(" and ", $where);
		}
		if($where_str!=""){

			$sql .= " ".$where_str;
		}
		$sql .= $order.$limit;
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;


}

function getMemberGroupBuyItems($page,$size,$count=false,$status=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from cms_share_group_buy ";
	}
	else{
		$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as count,b.*,g.goodsUnitPrice from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid ";


		$where = array();
		switch ($status){

			case 1:
				$where[] = " start_time is null";
				break;
			case 2:
				$where[] = " end_time >= CURRENT_DATE()";
				break;
			case 3:
				$where[] = " end_time < CURRENT_DATE";
				break;
		}

		$order = " order by b.created DESC";
		$limit = " limit {$page},{$size}";
		$where_str = " where b.offcial = 0";
		if(count($where)){

			$where_str .= " and ".implode(" and ", $where);
		}
		if($where_str!=""){

			$sql .= " ".$where_str;
		}
		$sql .= $order.$limit;
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;


}

function getAdminEventTime($id){

	$sql = "select * from cms_share_event_time where event_id = '{$id}' order by start_date ASC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function saveAdminEventTime($event_id,$start_date,$end_date,$start_time,$end_time,$week_day){

	$dataArray["start_date"] = $start_date;
	$dataArray["end_date"] = $end_date;
	$dataArray["start_time"] = $start_time;
	$dataArray["end_time"] = $end_time;
	$dataArray["week_day"] = $week_day;
	$dataArray["event_id"] = $event_id;
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_event_time (".$str_field.") values (".$str_value.")";
	$event_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function deleteAdminEventTime($id){

	$sql = "delete from cms_share_event_time where event_id = '{$id}'";

	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function eventDeleteAdmin($id){

	$sql = "delete from cms_share_event where id = {$id}";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	$sql = "delete from cms_share_event_member where event_id = {$id}";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	$sql = "delete from cms_member_love where love_id = {$id} and type = 'EVENT'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getAdminEvent($id){

	$sql = "select a.*,b.headImageUrl from cms_share_event as a left join cms_member_staff as b on a.user_id = b.staffId where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getAdminCircleById($id){

	$sql = "select * from cms_share_circle where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getAllCirclesAdmin(){

	$sql = "select * from cms_share_circle";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}


function getAdminEvents($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$recycle=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by c.id desc ";

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and c.block=0";
				break;
			case 2:
				$filter_sql = " and c.block=1";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (m.staffName LIKE '%{$search_word}%' or m.staffNo LIKE '%{$search_word}%' or c.name LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by c.id desc";
	}


	if($count == true){

		if($recycle==true){


			$sql = "select count(*) as count from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0 and c.official = 1";
		}else{

			$sql = "select count(*) as count from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0 and c.official = 1";
		}

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql;

	}else{
		if($recycle==true){

			$sql = "select c.*,m.staffName from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status =0 and official = 1";
		}else{

			$sql = "select c.*,m.staffName from cms_share_event as c left join cms_member_staff as m on c.user_id = m.staffId  where c.status >0 and official = 1";
		}




		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$circle_id_sql.$about_sql.$filter_sql.$obj_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getOrderPayment($orderId,$en=false){

	$order = getOrder($orderId);

	switch($order["payment"]){


		case 1:

			$payment = "PAYPAL";

			break;

		case 2:
			if($en = true){

				$payment = "RECHARGE ACCOUNT";
			}else{

				$payment = "账户余额支付";
			}

			break;

		case 3:
			if($en = true){

				$payment = "CARD";
			}else{

				$payment = "银行在线支付";
			}

			break;
		default:
			$payment = "错误";

	}

	return $payment;

}

function adminGetGlobalSetting(){

	$sql = "select * from cms_website_global_setting";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function makeOrderAmoutAgain($orderID,$amount,$freight){

	$sql = "update cms_publish_order set order_freight = '{$freight}',order_amount = '{$amount}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);

	updateOrderTotal($orderID);

}

function markOrderReturns($order_id){

	$sql = "UPDATE cms_publish_order SET order_return = IF(order_return=1, 0, 1) WHERE orderID = '{$order_id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function orderProblemSave($text,$orderID){

	$text = addslashes(nl2br($text));

	$sql = "update {$GLOBALS['table']['publish']['order']} set problem = '{$text}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function confirmShipping($orderID){

	$date = date("Y-m-d H:i:s");
	$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = 7,shippingTime = '{$date}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function confirmArrived($orderID){

	$date = date("Y-m-d H:i:s");
	$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = 7.1,shippingTime = '{$date}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function orderPurchase($orderID){

	$date = date("Y-m-d H:i:s");
	$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = 6,purchaseTime = '{$date}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function adminGroupBuyPageNavi($result_count,$rowsPerPage,$action,$method,$type,$page=1,$status=null,$search_word=null,$search_type=null){

	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}

	if($page_count<2){
		return false;
	}

	$minpage = get_admin_minpage($page,$page_count);
	$maxpage = get_admin_maxpage($page,$page_count);
	$navi = "<div class='main_page_nav'>";
	if($page > 1)$navi.= "<a class='main_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&status=".$status."&search_word=".$search_word."&search_type=".$search_type."&page=".($page-1)))."'><</a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&status=".$status."&search_word=".$search_word."&search_type=".$search_type."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='main_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&status=".$status."&search_word=".$search_word."&search_type=".$search_type."&page=".($page+1)))."'>></a>";
	$navi .="<a class='page_counter'>共".$page_count."页</a>";
	$navi .="</div>";

	return $navi;
}


function adminPageNavi($result_count,$rowsPerPage,$action,$method,$type,$page=1,$order_status=null,$search_word=null,$search_type=null){

	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}

	if($page_count<2){
		return false;
	}

	$minpage = get_admin_minpage($page,$page_count);
	$maxpage = get_admin_maxpage($page,$page_count);
	$navi = "<div class='main_page_nav'>";
	if($page > 1)$navi.= "<a class='main_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&order_status=".$order_status."&search_word=".$search_word."&search_type=".$search_type."&page=".($page-1)))."'><</a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&order_status=".$order_status."&search_word=".$search_word."&search_type=".$search_type."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='main_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&order_status=".$order_status."&search_word=".$search_word."&search_type=".$search_type."&page=".($page+1)))."'>></a>";
	$navi .="<a class='page_counter'>共".$page_count."页</a>";
	$navi .="</div>";

	return $navi;
}

function get_admin_minpage($page,$countpage)
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
function get_admin_maxpage($page,$countpage)
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
function adminPageNavi2($result_count,$rowsPerPage,$action,$method,$type,$page=1,$order_status=null,$search_word=null,$search_type=null){

	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}

	if($page_count<2){
		return false;
	}

	$minpage = get_admin_minpage2($page,$page_count);
	$maxpage = get_admin_maxpage2($page,$page_count);
	$navi = "<div class='main_page_nav'>";
	if($page > 1)$navi.= "<a class='main_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&order_status=".$order_status."&search_word=".$search_word."&search_type=".$search_type."&page=".($page-1)))."'><</a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&order_status=".$order_status."&search_word=".$search_word."&search_type=".$search_type."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='main_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&type=".$type."&order_status=".$order_status."&search_word=".$search_word."&search_type=".$search_type."&page=".($page+1)))."'>></a>";
	$navi .="<a class='page_counter'>共".$page_count."页</a>";
	$navi .="</div>";

	return $navi;
}
function get_admin_minpage2($page,$countpage)
{
	$minpage = $page-14;
	if($page+14 >= $countpage)
	{
		$minpage = $minpage-(14-($countpage-$page));
	}else{
		if($minpage <=1){
			$minpage = 1;
		}
	}
	return $minpage;
}
//取最大页
function get_admin_maxpage2($page,$countpage)
{
	$maxpage = $page+14;
	if($page-14 <= 1)
	{
		$maxpage = $maxpage-($page-15);
	}
	if($maxpage >= $countpage)
	{
		$maxpage = $countpage;
	}
	return $maxpage;
}

function adminOrderPageNavi($action,$method,$result_count,$rowsPerPage,$page=1,$searchType = 'normal',$searchMode = 1,$fromTime=null,$endTime=null,$submitFromTime=null,$submitEndTime=null,$searchOrderNo=null,$searchOrderLocation=null,$searchOrderOperator=null,$searchOrderStatus=0,$searchServiceStatus=0,$fastOrderStatus=100,$searchOrderPayment=0){

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
	if($page > 1)$navi.= "<a class='account_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMode=".$searchMode."&fromTime=".$fromTime."&endTime=".$endTime."&submitFromTime=".$submitFromTime."&submitEndTime=".$submitEndTime."&searchOrderNo=".$searchOrderNo."&searchOrderLocation=".$searchOrderLocation."&searchOrderOperator=".$searchOrderOperator."&searchOrderStatus=".$searchOrderStatus."&searchServiceStatus=".$searchServiceStatus."&fastOrderStatus=".$fastOrderStatus."&searchOrderPayment=".$searchOrderPayment."&page=".($page-1)))."'><</a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMode=".$searchMode."&fromTime=".$fromTime."&endTime=".$endTime."&submitFromTime=".$submitFromTime."&submitEndTime=".$submitEndTime."&searchOrderNo=".$searchOrderNo."&searchOrderLocation=".$searchOrderLocation."&searchOrderOperator=".$searchOrderOperator."&searchOrderStatus=".$searchOrderStatus."&searchServiceStatus=".$searchServiceStatus."&fastOrderStatus=".$fastOrderStatus."&searchOrderPayment=".$searchOrderPayment."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='account_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&searchType=".$searchType."&searchMode=".$searchMode."&fromTime=".$fromTime."&endTime=".$endTime."&submitFromTime=".$submitFromTime."&submitEndTime=".$submitEndTime."&searchOrderNo=".$searchOrderNo."&searchOrderLocation=".$searchOrderLocation."&searchOrderOperator=".$searchOrderOperator."&searchOrderStatus=".$searchOrderStatus."&searchServiceStatus=".$searchServiceStatus."&fastOrderStatus=".$fastOrderStatus."&searchOrderPayment=".$searchOrderPayment."&page=".($page+1)))."'>></a>";
	$navi .="<span class='account_page_counter'>共".$page_count."页</span>";
	$navi .="</div>";
	//$navi = '<a>'.$action.$method.$result_count.$rowsPerPage.$page.$searchType.$searchMonth.'</a>';
	return $navi;
}

function getCmsOrderShopItem($goodsShopId,$cart_str,$status='Order'){

	$sql = "SELECT *,a.props as cart_props FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.ItemStatus = '{$status}' and b.goodsShopId = '{$goodsShopId}' and a.cartID in ({$cart_str}) and a.cart_type = 1 Order By a.cartID DESC";

	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $results;
}




function listActionInfo()
{
	try
	{
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$fieldsArray['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else
		{
			$fieldsArray['currentPage'] = 1;
		}
		$fieldsArray['pageSize'] = 10;
		$sql = "select * from {$GLOBALS['table']['cms']['app_actionconfig']} order by actionId desc";
		$actionsArray['contentPlanId'] = $contentPlanId;
		//$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到动作的基本信息
 **/
function getActionInfoById($actionsId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['app_actionconfig']} where actionId =:actionId";
		$actionsArray['actionId'] = $actionsId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据动作惟一标识得到动作的基本信息
 **/
function getActionInfoByGuid($actionGuid)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['app_actionconfig']} where actionGuid =:actionGuid";
		$actionsArray['actionGuid'] = $actionGuid;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到动作的基本信息
 **/
function editActionInfo($actionsId,$actionsArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($actionsArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['app_actionconfig']} set $sql where actionId=:actionId";
		$actionsArray['actionId'] = $actionsId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加动作的基本信息
 **/
function addActionInfo($actionsArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($actionsArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['app_actionconfig']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除动作的基本信息
 **/
function delActionInfo($actionsId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['app_actionconfig']} where actionId=:actionId";
		$actionsArray['actionId'] = $actionsId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *从管理器生成的数组中取得动作名
 * **/
function getActionInfo()
{
	try
	{
		$actionArray = $GLOBALS['currentApp']['mvcconfig'];
		foreach ($actionArray as $key => $val)
		{
			$str .= "<option value='".$key."'>".$key."</option>";
		}
		return $str;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *从管理器生成的数组中取得方法名
 * **/
function getMethodInfo()
{
	try
	{
		$actionArray = $GLOBALS['currentApp']['mvcconfig'];
		foreach ($actionArray as $key1 => $val1)
		{
			$methodArray = $val1['action'];
			foreach ($methodArray as $key2 => $val2)
			{
				$str .= "<option value='".$key2."'>(".$key1.")".$key2."</option>";
			}
		}
		return $str;
	} catch (Exception $e)
	{
		throw $e;
	}
}
function fullActionFlag($actionTitle)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($actionTitle);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}

function orderList($page=1,$size,$status = null,$search=null,$search_type=null,$count=false,$month=null,$year=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	try
	{

		if($count==true){

			$sql = "select count(*) as count from {$GLOBALS['table']['publish']['order']} as a left join {$GLOBALS['table']['member']['staff']} as b on a.orderUser = b.staffId ";
		}
		else{
			$sql = "select a.* from {$GLOBALS['table']['publish']['order']} as a left join {$GLOBALS['table']['member']['staff']} as b on a.orderUser = b.staffId ";
		}
		$where = array();

		if($month != null){

			$where[] = "MONTH(a.orderTime_n) = {$month}";
		}

		if($year != null){

			$where[] = "YEAR(a.orderTime_n) = {$year}";
		}

		if($search !=null){
			$search = trim($search);
			if($search_type == 1){
				$where[] = "b.staffName Like '%{$search}%' or b.staffNo Like '%{$search}%'";
			}
			elseif($search_type == 2){
				$where[] ="a.OrderNo Like '%{$search}%'";
			}
		}

		if($status != null){
			if($status=="99"){

				$where[] = "a.order_return >0";
			}else{
			$where[] = "a.orderStatus = {$status}";
			}
			}

		$order =" order by orderID  DESC";

		if(count($where)>0){
			$where_str = "where orderStatus <9 and group_buy = 0 AND ".implode(" AND ",$where);
		}else{
			$where_str="where orderStatus <9 and group_buy = 0";
		}

		$limit = " limit {$page},{$size}";

		$query = $sql.$where_str.$order.$limit;

		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$query);

		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/*
 * 获取不包括ivision的订单
 */
 function wowOrderList($page=1,$size,$status = null,$search=null,$search_type=null,$count=false,$month=null,$year=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	try
	{
		if($count==true){

			$sql = "select count(*) as count from {$GLOBALS['table']['publish']['order']} as a left join {$GLOBALS['table']['member']['staff']} as b on a.orderUser = b.staffId ";
		}
		else{
			$sql = "select a.* from {$GLOBALS['table']['publish']['order']} as a left join {$GLOBALS['table']['member']['staff']} as b on a.orderUser = b.staffId ";
		}
		$where = array();

		if($month != null){

			$where[] = "MONTH(a.orderTime_n) = {$month}";
		}

		if($year != null){

			$where[] = "YEAR(a.orderTime_n) = {$year}";
		}

		if($search !=null){
			$search = trim($search);
			if($search_type == 1){
				$where[] = "b.staffName Like '%{$search}%' or b.staffNo Like '%{$search}%'";
			}
			elseif($search_type == 2){
				$where[] ="a.OrderNo Like '%{$search}%'";
			}
		}

		if($status != null){
			if($status=="99"){

				$where[] = "a.order_return >0";
			}else{
			$where[] = "a.orderStatus = {$status}";
			}
			}

		$order =" order by orderID  DESC";

		if(count($where)>0){
			$where_str = "where a.isivision = 0 and orderStatus <9 and group_buy = 0 AND ".implode(" AND ",$where);
		}else{
			$where_str="where a.isivision = 0 and orderStatus <9 and group_buy = 0";
		}

		$limit = " limit {$page},{$size}";

		$query = $sql.$where_str.$order.$limit;

		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$query);

		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/*
 * 获取ivision订单
 */
 function ivisionOrderList($page=1,$size,$status = null,$search=null,$search_type=null,$count=false,$month=null,$year=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	try
	{

		if($count==true){

			$sql = "select count(*) as count from {$GLOBALS['table']['publish']['order']} as a left join {$GLOBALS['table']['member']['staff']} as b on a.orderUser = b.staffId ";
		}
		else{
			$sql = "select a.* from {$GLOBALS['table']['publish']['order']} as a left join {$GLOBALS['table']['member']['staff']} as b on a.orderUser = b.staffId ";
		}
		$where = array();

		if($month != null){

			$where[] = "MONTH(a.orderTime_n) = {$month}";
		}

		if($year != null){

			$where[] = "YEAR(a.orderTime_n) = {$year}";
		}

		if($search !=null){
			$search = trim($search);
			if($search_type == 1){
				$where[] = "b.staffName Like '%{$search}%' or b.staffNo Like '%{$search}%'";
			}
			elseif($search_type == 2){
				$where[] ="a.OrderNo Like '%{$search}%'";
			}
		}

		if($status != null){
			if($status=="99"){

				$where[] = "a.order_return >0";
			}else{
			$where[] = "a.orderStatus = {$status}";
			}
			}

		$order =" order by orderID  DESC";

		if(count($where)>0){
			$where_str = "where a.isivision = 1 and orderStatus <9 and group_buy = 0 AND ".implode(" AND ",$where);
		}else{
			$where_str="where a.isivision = 1 and orderStatus <9 and group_buy = 0";
		}

		$limit = " limit {$page},{$size}";

		$query = $sql.$where_str.$order.$limit;

		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$query);

		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}

function getOrderAmount($cart_str){

	$sql = "select sum(itemPrice*ItemQTY+itemFreight) as totalPrice from {$GLOBALS['table']['publish']['cart']} where cartID in ({$cart_str})";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0]["totalPrice"];

}

function getOrderStatusAdmin($statusCode){
	if (count($statusCode)!= ''){
		switch($statusCode){
			case -1:
				$orderStatus='已取消';
				break;
			case 0:
				$orderStatus='进行中';
				break;
			case 1:
				$orderStatus='服务选择';
				break;
			case 2:
				$orderStatus='填写信息';
				break;
			case 3:
				$orderStatus='待审核';
				break;
			case 4:
				$orderStatus='待付款';
				break;
			case 5:
				$orderStatus='已付款，待采购';
				break;
			case 6:
				$orderStatus='已采购，等待发货';
				break;
			case 7:
				$orderStatus='已发货';
				break;
			case 7.1:
				$orderStatus='已送达，等待确认';
				break;
			case 8:
				$orderStatus='已确认收货';
				break;
			case 9:
				$orderStatus='已删除';
				break;
			default:
				$orderStatus='错误状态';
		}
		return $orderStatus;
	}else{
		return false;
	}
}
/**
 *更新订单商品信息
 **/
function updateItemInfo($cartID,$dataArray)
{
	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_cart set $sql where cartID = {$cartID}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}
/**
 *更新中文地址
 **/
function updateAddressCN($addressId,$dataArray)
{
	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_address set $sql where addressId = {$addressId}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function getOrderService($service){
	if (count($service)!= ''){
		switch($service){
			case 1:
				$serviceName='普通代购';
				break;
			case 2:
				$serviceName="导购";
				break;
			case 3:
				$serviceName="团购";
			default:
				$serviceName='错误状态';
		}
		return $serviceName;
	}else{
		return false;
	}
}

function getOrder($id){
	$sql = "select * from {$GLOBALS['table']['publish']['order']} where orderID = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}
function getPhoneOrder($id){
	$sql = "select * from cms_publish_phone_order where id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}
function getBankTransfer($id){
	$sql = "select * from cms_publish_bank_transfer where id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}
function getOrderCarts($cart_str){
	$sql = "select * from {$GLOBALS['table']['publish']['cart']} where cartID in ({$cart_str})";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getCatrGoods($good_id){
	$sql = "select * from {$GLOBALS['table']['publish']['goods']} where goodsid = ({$good_id})";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}

function getItemsAmount($cart_str){

	$sql = "select sum(itemPrice*ItemQTY) as totalPrice from {$GLOBALS['table']['publish']['cart']} where cartID in ({$cart_str})";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0]["totalPrice"];

}

function getShippingAmount($cart_str){
	$sql = "select sum(itemFreight) as totalPrice from {$GLOBALS['table']['publish']['cart']} where cartID in ({$cart_str})";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0]["totalPrice"];
}

function getOrderAddress($addressId){
	try
	{
		if($addressId==""){
			$addressId = 0;
		}
		$sql = "select * from {$GLOBALS['table']['publish']['address']} where addressId = ({$addressId})";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		return $result[0];
	} catch (Exception $e)
	{
		throw $e;
	}
}

/*function updateCart($cartID,$ItemQTY,$itemFreight,$itemPrice){
	$sql = "update {$GLOBALS['table']['publish']['cart']} set ItemQTY = '{$ItemQTY}', itemFreight='{$itemFreight}', itemPrice='{$itemPrice}' where cartID = '{$cartID}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}*/

function deleteCart($cartID,$cartIDstr,$orderID,$group_buy=false){

	$cart_array = explode(",",$cartIDstr);
	if(count($cart_array)>1){
		for($i=0;$i<=count($cart_array);$i++){
			echo $cart_array[$i];
			if($cart_array[$i] == $cartID){

				unset($cart_array[$i]);
				break;
			}
		}

		$cartIDstr = implode(",",$cart_array);
		$sql = "update {$GLOBALS['table']['publish']['order']} set cartIDstr  = '{$cartIDstr}' where orderID = '{$orderID}'";
		TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	}else{

		if($group_buy==false){

			$link = runFunc('encrypt_url',array("action=cms&method=order&id=".$orderID."&type=orders"));
		}else{
			$link = runFunc('encrypt_url',array("action=cms&method=groupBuyOrderItem&order_id=".$orderID."&type=orders"));
		}
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
				<html lang="en">
				<head>
				<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
				<title>操作成功</title>
				</head>
				<body>
				<script type="text/javascript">alert("如要删除订单中唯一的商品，请直接删除订单即可！");
				location.href="'.$link.'"</script>
						</body>
						</html>';
		exit;
	}
}

function makeOrderByAdmin($orderID){

	$sql = "update {$GLOBALS['table']['publish']['order']} set changed_by_admin = 1 where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function deleteOrder($orderID){

	$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = '9' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	echo '<script type="text/javascript">alert("删除成功！")</script>';
}

/*function updateOrderStatus($status,$orderID,$userID=null,$orderNo=null,$service_fee=null){
	if($service_fee==null){
		$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = '{$status}' where orderID = '{$orderID}'";
	}else{
		$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = '{$status}', service_fee = {$service_fee} where orderID = '{$orderID}'";
	}
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	switch($status){
		case 4:
			runFunc('sendMail',array(array("userId"=>$userID,"orderNo"=>$orderNo),"confirmOrder"));
			echo '<script type="text/javascript">alert("订单审核确认成功！")</script>';
			break;
	}

}*/

function updateCartInfo($orderID,$service_fee){
	if($service_fee==""){
		return false;
	}
	$sql = "update {$GLOBALS['table']['publish']['order']} set changed_service_fee = '{$service_fee}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	updateOrderTotal($orderID);
}

function refundToCustomer($orderID,$cartIDstr,$userID){

	$amount = makeOrderAmout($cartIDstr);	//小总价
	$refundAmount = $amount["refundAmount"]; //总退款金额
	$settings = adminGetGlobalSetting();

	$credit = floor($refundAmount / $settings[0]["credit_consumption"]);
	$user = getUser($userID);

	if(($user[0]["credits"] - $credit)<=0){
		$credit = $user[0]["credits"];
	}
	//更新订单
	$orderArray["refundTime"] = time();
	$orderArray["order_return"] = 2;
	$orderArray["refundAmount"] = $refundAmount;
	$orderArray["orderStatus"] = 17;
	$sql = '';
	foreach ($orderArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_order set $sql where orderID = {$orderID}";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$orderArray);
	//加钱
	addUserBalanceByAdmin($refundAmount,$userID);
	//减积分
	takeUserCredit($credit,$userID);
	//日志记录
	$order = getOrder($orderID);
	makeAdminLog("订单退款 订单号：".$order["OrderNo"].",金额：".$refundAmount,$userID);
	$mailArray = array();
	//原来金额
	$mailArray["previousBalance"] = $user[0]["balance"];
	//获取现有金额
	$user2 = getUser($userID);
	$mailArray["currentBalance"] = $user2[0]["balance"];
	//增加邮件模版参数

	$mailArray["userId"] = $order["orderUser"];

	$mailArray["orderNo"] = $order["OrderNo"];
	if(!$user2["staffName"]){
		$mailArray["order_user"] = $user2["staffNo"];
	}else{
		$mailArray["order_user"] = $user2["staffName"];
	}


	//增加退款记录(hutu,2013.01.27)
	adminMakeRechargeOrder(7,$mailArray["userId"],$refundAmount);
	//发送邮件
	$result = sendMail($mailArray,"normal_order_cart_pay_back");
	return $result;
}
function refundPhoneToCustomer($orderID,$userID,$userName,$adminUserID){
	$settings = adminGetGlobalSetting();
	$order = getPhoneOrder($orderID);
	$user = getUser($userID);
	//更新订单
	$orderArray["refundTime"] = time();
	$orderArray["order_return"] = 1;
	$orderArray["refundTotal"] = $order['rechargeTotal'];
	$orderArray["orderStatus"] = 17;
	$orderArray["operator"] = $userName;
	$sql = '';
	foreach ($orderArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_phone_order set $sql where id = {$orderID}";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$orderArray);
	//加钱
	addUserBalanceByAdmin($order['rechargeTotal'],$userID);
	//减积分
	//takeUserCredit($credit,$userID);
	//日志记录
	makeAdminLog("电话充值订单退款 订单号：".$order["orderNo"].",金额：".$order['rechargeTotal'],$adminUserID);
	$mailArray = array();
	//原来金额
	$mailArray["previousBalance"] = $user[0]["balance"];
	//获取现有金额
	$user2 = getUser($userID);
	$mailArray["currentBalance"] = $user2[0]["balance"];
	//增加邮件模版参数
	$mailArray["userId"] = $order["userID"];
	$mailArray["orderNo"] = $order["orderNo"];
	if(!$user2["staffName"]){
		$mailArray["order_user"] = $user2["staffNo"];
	}else{
		$mailArray["order_user"] = $user2["staffName"];
	}
	//增加退款记录(hutu,2013.01.27)
	//adminMakeRechargeOrder(13,$mailArray["userId"],$order['rechargeTotal']);
	$makeuserid = $order["userID"];
	$makeMoney = $order['rechargeTotal'];
	$created = date("Y-m-d H:i:s");
	$sql2 = "insert into cms_publish_recharge_order (payment,user_id, recharge,created,status) values('13','{$makeuserid}','{$makeMoney}','{$created}',2) ";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql2);
	//发送邮件
	runFunc('sendMail',array($mailArray,"phone_order_refund"));
	//return $result;
}
function updateOrderTotal($orderID){
	$order = getOrder($orderID);
	$settings = adminGetGlobalSetting();
	$amount = adminMakeOrderAmout($order["cartIDstr"]);	//小总价
	$shopNum = adminMakeOrderFreight($order["cartIDstr"]);
	$freight = $shopNum*$settings[0]["freight"];//总运费

	//服务费
	if($order["group_buy"]==1){
		$service_fee = 0;
		$items = adminGetGroupBuyOrderItems($order["cartIDstr"]);
		foreach($items as $item){
			if($item["sell_way"]==1){
				$service_fee += $item["itemPrice"] * $settings[0]['service_fee'] * $item["price_rate"];
			}else{
				$service_fee += $item["itemPrice"] * $settings[0]['service_fee'] ;
			}
		}
	}else{
		$service_fee = $settings[0]["service_fee"]*$amount["amount"];//所有商品服务费
	}
	if($order["invoice"] == 1){
		$tax = ($service_fee + $amount["amount"] + $freight) * $settings[0]["tax_rate"];
	}else{
		$tax = 0;
	}
	$totalAmount = $amount["amount"] + $freight + $service_fee + $tax - $order["coupon_word"] + $order["special_service_fee"] + $order["additional"] + $order["order_international_freight"];	//总总价钱
	$dataArray["service_fee"] = $service_fee;		//总服务费
	$dataArray["order_amount"] = $amount["amount"];	//商品总价
	$dataArray["order_freight"] = $freight;			//总运费
	$dataArray["totalAmount"] = $totalAmount;
	/*$dataArray["refundAmount"] = $amount["refundAmount"];*/ //总退款
	$dataArray["purchaseAmount"] = $amount["purchaseAmount"]; //总采购价

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_order set $sql where orderID = {$orderID}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}
function updateOrderStatus($orderID,$orderArray){
	$sql = '';
	foreach ($orderArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_order set $sql where orderID = {$orderID}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$orderArray);
	return $result;
}
function adminMakeOrderAmout($cartStr){

	$sql = "select sum(itemTotal) as amount,sum(pay_back_money) as refundAmount,sum(purchaseTotal) as purchaseAmount from cms_publish_cart where cartID in ({$cartStr}) and group_buy_off = 0";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];

}
function adminMakeOrderFreight($cartStr){

	$sql = "SELECT b.goodsShopId FROM cms_publish_cart a,cms_publish_goods b WHERE a.ItemGoodsID=b.goodsid  and cartID in ({$cartStr}) Group By b.goodsShopId";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$shopNum = count($result);//商店数目
	return $shopNum;

}
function checkItemService($checktype,$cartIDstr){
	switch($checktype){
		case 'purchased':
			$sql ="SELECT purchaseTotal FROM cms_publish_cart where ItemStatus = 'Order' and cartID in ({$cartIDstr})";
			$checkResult = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			if($checkResult){
				$result = true;
				foreach($checkResult as $value){
					if(!$value['purchaseTotal']){
						$result = false;
						break;
					}
				}
			}else{
				$result = false;
			}
		break;
		case 'onTheWay':
			$sql ="SELECT expressNum FROM cms_publish_cart where ItemStatus = 'Order' and cartID in ({$cartIDstr})";
			$checkResult = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			if($checkResult){
				$result = false;
				foreach($checkResult as $value){
					if($value['expressNum'] && $value['expressNum'] != 0){
						$result = true;
						break;
					}
				}
			}else{
				$result = false;
			}
		break;
	}
	return $result;
}
function getBrandList($page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$category=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by id desc ";

	if($category!=null){
		$category_sql = " and b.category_id = '{$category}'";

	}else{

		$category_sql = "";
	}

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and b.published=1";
				break;
			case 2:
				$filter_sql = " and b.published=0";
				break;
			case 3:
				$filter_sql = " and b.special=1";
				break;
			case 4:
				$filter_sql = " and b.special=0";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and (b.title LIKE '%{$search_word}%')";
	}
	else{$search_sql = "";
	}


	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by b.id desc";
	}


	if($count == true){



		$sql = "select count(*) as count from cms_product_brand as b left join cms_product_brand_category as c on b.category_id = c.id where b.id >0";


		$sql.= $search_sql.$category_sql.$type_sql.$filter_sql;

	}else{


		$sql = "select b.*,c.name as cname from cms_product_brand as b left join cms_product_brand_category as c on b.category_id = c.id  where b.id >0";

		$limit = " limit {$page},{$size}";

		$sql.= $search_sql.$category_sql.$type_sql.$filter_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getBrandById($id){


	$sql = "select * from cms_product_brand where id = {$id}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];

}

function deleteBrand($id){
	$sql = "delete from cms_product_brand where id = {$id}";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function deleteBrandBatch($ids){

	$sql = "delete from cms_product_brand where id in ({$ids})";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

}


function getBrandListForSelect(){

	$sql = "select * from cms_product_brand order by title";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getItemList($table,$page,$size,$count=false,$filter=null){

	$page = $page * $size - $size;
	if($count == true){
		if($filter!=""){

			$filter = explode(":", $filter);
			$filter_name = $filter[0];
			$filter_value = $filter[1];
			$sql = "select count(*) as count from {$table} where {$filter_name} = '{$filter_value}'";
		}else{
			$sql = "select count(*) as count from {$table}";
		}

	}else{

		if($filter!=""){

			$filter = explode(":", $filter);
			$filter_name = $filter[0];
			$filter_value = $filter[1];
			$sql = "select * from {$table} where {$filter_name} = '{$filter_value}'  limit {$page},{$size}";
		}else{
			$sql = "select * from {$table} limit {$page},{$size}";
		}
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getItemById($table,$id){


	$sql = "select * from {$table} where id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];

}

function deleteItem($table,$id){

	$sql = "delete from {$table} where id in ({$id})";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function deleteGoods($id){

	$sql = "delete from cms_publish_goods where goodsid in ({$id})";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getPropValues($id){

	$sql = "select * from cms_product_prop_attr where prop_id = {$id}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function deletePropValues($id){

	$sql = "delete from cms_product_prop_attr where prop_id in ({$id})";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getTagsByCatId($cat_id=0){

	$sql = "select * from cms_product_tag ";
	if($cat_id!=0){

		$sql .="where cat_id = {$cat_id}";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;


}
function saveGoodsTags($good_id,$tag_id){

	$sql = "insert into cms_product_tag_xref (tag_id,goods_id) values ('{$tag_id}','{$good_id}')";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$actionsArray);
}

function deleteGoodsTags($good_id){

	$sql = "delete from cms_product_tag_xref where goods_id in ({$good_id})";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}
function deleteNotice($id){
	$sql = "delete from cms_publish_notice where id = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}
function updateGoodsImg($img,$url,$id){

	$sql = "update cms_publish_goods set {$img} = '{$url}' where goodsid = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function updateGoodsOtherImg($img,$url,$id){
	$sql = "update cms_publish_goods set {$img} = '{$url}' where goodsid = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getGoodsList($goodType,$page,$size,$count=false,$sort=null,$key=null,$status=null,$search_word=null,$cat=null,$brand_id=null,$search_goodID=null){


	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$order = " order by staffId asc ";

	if($cat==-1){
		$cat_sql = " and cat_id is NULL";

	}elseif($cat!=null){

		$cat_sql = " and cat_id = '{$cat}'";
	}else{



		$cat_sql = "";
	}
	if($brand_id!=null){

		$brand_sql = " and brand_id = '{$brand_id}'";
	}else{

		$brand_sql ="";
	}

	if($status!=null){

		switch ($status){

			case 1:
				$filter_sql = " and published = 1";
				break;
			case 2:
				$filter_sql = " and published = 0";
				break;
		}
	}else{

		$filter_sql = "";
	}

	if($search_word!=null){
		$search_sql = " and goodsTitleCN LIKE '%{$search_word}%'";
	}
	else{$search_sql = "";
	}
	if($search_goodID!=null){
		$search_sql .= " and goodsid = '{$search_goodID}'";
	}

	if($key!=null){

		$order = " order by {$key} {$sort}";
	}else{

		$order = " order by goodsid DESC";
	}


	if($count == true){

		$sql = "select count(*) as count from cms_publish_goods where goodsType = '{$goodType}' and other_get != 1 ";
		$sql.= $search_sql.$brand_sql.$filter_sql.$cat_sql;

	}else{

		$sql = "select *  from cms_publish_goods where goodsType = '{$goodType}' and other_get != 1 ";

		$limit = " limit {$page},{$size}";

		$sql.= $cat_sql.$search_sql.$brand_sql.$filter_sql.$order.$limit;

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAdminGoodsById($id){

	$sql = "select * from cms_publish_goods where goodsid = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}
function updateAdminGoodsById($id,$dataArray){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_goods set $sql where goodsid = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}
function getAdminNoticeById($id){

	$sql = "select * from cms_publish_notice where id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}
function getGoodsTags($id){
	$sql = "select b.* from cms_product_tag_xref as a left join cms_product_tag as b on a.tag_id = b.id where a.goods_id = '{$id}' order by a.id ASC";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function deleteGoodsImg($img_name,$id){
	$sql = "update cms_publish_goods set {$img_name} = '' where goodsid = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getGoodsAdminImg($img_name,$id){

	$sql = "select {$img_name} from cms_publish_goods where goodsid = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];

}

function addUserBalanceByAdmin($balance,$user_id){

	$sql = "update cms_member_staff set balance = balance + {$balance} where staffId = '{$user_id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}


function getOrderCartsPayBackAmount($cart_str){
	$sql = "select sum(pay_back_money) as amount from {$GLOBALS['table']['publish']['cart']} where cartID in ({$cart_str})";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function takeUserCredit($credit,$user_id){

	$sql = "update cms_member_staff set credits = credits - {$credit} where staffId = '{$user_id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}
function showMsg($msg, $gourl, $onlymsg=0, $limittime=0)
{
    $htmlhead  = "<html>\r\n<head>\r\n<title>wowshopping note</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
    $htmlhead .= "<link rel='stylesheet' type='text/css' href='skin/cssfiles/base.css' />";
    $htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>\r\n<center>\r\n<script>\r\n";
    $htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

    $litime = ($limittime==0 ? 1000 : $limittime);
    $func = '';

    if($gourl=='-1')
    {
        if($limittime==0) $litime = 1000;
        $gourl = "javascript:history.go(-1);";
    }

    if($gourl=='' || $onlymsg==1)
    {
        $msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
    }
    else
    {
        //当网址为:close::objname 时, 关闭父框架的id=objname元素
        if(preg_match('/close::/',$gourl))
        {
            $tgobj = trim(preg_replace('/close::/', '', $gourl));
            $gourl = 'javascript:;';
            $func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
        }

        $func .= "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
        $rmsg = $func;
        $rmsg .= "document.write(\"<br /><div class='showMsg'>";
        $rmsg .= "<div class='showMstTitle'><b>wowshopping note！</b></div>\");\r\n";
        $rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
        $rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
        $rmsg .= "document.write(\"";

        if($onlymsg==0)
        {
            if( $gourl != 'javascript:;' && $gourl != '')
            {
                $rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
                $rmsg .= "<br/></div>\");\r\n";
                $rmsg .= "setTimeout('JumpUrl()',$litime);";
            }
            else
            {
                $rmsg .= "<br/></div>\");\r\n";
            }
        }
        else
        {
            $rmsg .= "<br/><br/></div>\");\r\n";
        }
        $msg  = $htmlhead.$rmsg.$htmlfoot;
    }
    echo $msg;
}
?>
