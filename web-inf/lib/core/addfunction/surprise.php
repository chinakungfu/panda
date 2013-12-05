<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');

function saveProductSkus($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_product_sku (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function checkCollectionGroupBuy($id){

	$sql = "select * from cms_share_group_buy where start_time is not null and end_time > CURRENT_DATE and published = 1 and goods_id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function pageBrandListNavi($result_count,$rowsPerPage,$action,$method,$page=1,$brand_id=null,$simple=false){


	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}


if($page_count<2){return false;}
	$minpage = get_surprise_minpage($page,$page_count);
	$maxpage = get_surprise_maxpage($page,$page_count);
	$navi = "<div class='main_page_nav'>";
	if($page > 1)$navi.= "<a class='main_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&brand_id=".$brand_id."&page=".($page-1)))."'></a>";
				for($minpage;$minpage<=$maxpage;$minpage++):
				if($minpage<=0){continue;}
				$navi.= "<a";
				if($page == $minpage){
					$navi .= " class='active_page'";
				}
				$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&brand_id=".$brand_id."&page=".($minpage)))."'>".$minpage."</a>";
				endfor;
				if($page < $page_count)$navi.= "<a class='main_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&brand_id=".$brand_id."&page=".($page+1)))."'></a>";
				$navi .="<a class='page_counter'>".$page_count."</a>";
			$navi .="</div>";


	if($simple==true){

		$navi = "<div class='list_nav brand_list_nav fr'>";
		if($page > 1){
			$navi.= "<a class='prev fl' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&brand_id=".$brand_id."&page=".($page-1)))."'>prev</a>";
		}else{

			$navi.= "<a class='prev fl' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&brand_id=".$brand_id."&page=".$page_count))."'>prev</a>";
		}
		if($page < $page_count){
		$navi.= "<a class='next fr' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&brand_id=".$brand_id."&page=".($page+1)))."'>next</a>";
		}else{

			$navi.= "<a class='next fr' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&brand_id=".$brand_id."&page=1"))."'>next</a>";
		}
		$navi .="</div>";
	}

	return $navi;
}

function pageSurpriseNavi($result_count,$rowsPerPage,$action,$method,$page=1,$cat_id=null,$tag_id=null,$simple=false){


	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}


if($page_count<2){return false;}
	$minpage = get_surprise_minpage($page,$page_count);
	$maxpage = get_surprise_maxpage($page,$page_count);
	$navi = "<div class='main_page_nav'>";
	if($page > 1)$navi.= "<a class='main_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&cat_id=".$cat_id."&tag_id=".$tag_id."&page=".($page-1)))."'></a>";
				for($minpage;$minpage<=$maxpage;$minpage++):
				if($minpage<=0){continue;}
				$navi.= "<a";
				if($page == $minpage){
					$navi .= " class='active_page'";
				}
				$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&cat_id=".$cat_id."&tag_id=".$tag_id."&page=".($minpage)))."'>".$minpage."</a>";
				endfor;
				if($page < $page_count)$navi.= "<a class='main_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&cat_id=".$cat_id."&tag_id=".$tag_id."&page=".($page+1)))."'></a>";
				$navi .="<a class='page_counter'>".$page_count."</a>";
			$navi .="</div>";

	if($simple==true){

		$navi = "<div class='list_nav brand_list_nav fr'>";
		if($page > 1){
			$navi.= "<a class='prev fl' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&cat_id=".$cat_id."&tag_id=".$tag_id."&page=".($page-1)))."'>prev</a>";
		}else{

			$navi.= "<a class='prev fl' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&cat_id=".$cat_id."&tag_id=".$tag_id."&page=".$page_count))."'>prev</a>";
		}
		if($page < $page_count){
		$navi.= "<a class='next fr' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&cat_id=".$cat_id."&tag_id=".$tag_id."&page=".($page+1)))."'>next</a>";
		}else{

			$navi.= "<a class='next fr' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&cat_id=".$cat_id."&tag_id=".$tag_id."&page=1"))."'>next</a>";
		}
		$navi .="</div>";
	}

	return $navi;
}

function get_surprise_minpage($page,$countpage)
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
function get_surprise_maxpage($page,$countpage)
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



function getItemDetail($id,$type){



	if($type == "normal"){
		$sql = "select c.user_id,b.goodsid,d.staffName, a.title as change_title,a.description as change_description,b.* from cms_share_list_item as a left join cms_publish_goods as b on a.good_id = b.goodsid left join cms_share_list as c on c.id = a.list_id left join cms_member_staff as d on c.user_id = d.staffId";
		$sql .=" where a.id = {$id}";
	}

	if($type == "collections"){

		$sql = "select * from cms_publish_goods where goodsid = {$id}";
	}


	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}



function getItemNavGroup($id){
	$sql = " select * from cms_share_list_item where id < {$id} order by id desc limit 0,1";
	$prev = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$sql = " select * from cms_share_list_item where id > {$id} order by id asc limit 0,1";
	$next = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	$nav = array(
		"prev" => $prev[0]["id"],
		"next" => $next[0]["id"],
	);

	return $nav;
}

function getGoodsNavGroup($id){
	$sql = " select * from cms_publish_goods where goodsid < {$id} and goodsType = 'inside' and  published= 1 order by goodsid desc limit 0,1";
	$prev = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$sql = " select * from cms_publish_goods where goodsid > {$id} and goodsType = 'inside' and  published= 1 order by goodsid asc limit 0,1";
	$next = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	$nav = array(
		"prev" => $prev[0]["goodsid"],
		"next" => $next[0]["goodsid"],
	);

	return $nav;

}

function checkItemUrl($url){

	$url = trim($url);
	$sql = "select * from cms_publish_goods where goodsURL = '{$url}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function isTaobao($url){
	$urls= parse_url($url);
	if(empty($urls['scheme']) || empty($urls['host'])){
		$tran = runFunc("translate",array($url));
		header("Location: http://s.taobao.com/search?q=$tran");
		exit;
	}
    $host = explode('.',$urls['host']);
    array_shift($host);
    $sub_domain = implode('.',$host);
    if($sub_domain == 'taobao.com'){
    	return 'taobao';
    }else if($sub_domain == 'tmall.com'){
    	return 'tmall';
    }else{
    	return false;
    }
}
function getAllBrands(){

	$sql = "select * from cms_product_brand where publish_type = 2 order by id DESC";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}


function getAllInsideGoods($page=1,$size,$count=false,$cat_id=null,$tag_id=null){
	if($page <=0){
		$page = 1;
	}
	$page = $page * $size - $size;
	if($count == true){

		if($tag_id != null){
			$sql = "select count(*) as count from cms_publish_goods as a left join cms_product_tag_xref as b on a.goodsid = b.goods_id where a.goodsType = 'inside' and a.published = 1";
		}else{

			$sql = "select count(*) as count from cms_publish_goods as a where a.goodsType = 'inside' and a.published = 1";
		}

		if($cat_id != null){

			$sql .= " and a.cat_id = '{$cat_id}'";
		}

		if($tag_id != null){

			$sql .= " and b.tag_id = '{$tag_id}'";

		}
	}else{
		if($tag_id != null){
		$sql = "select * from cms_publish_goods as a left join cms_product_tag_xref as b on a.goodsid = b.goods_id";
		}else{
			$sql = "select * from cms_publish_goods as a";
		}
		$sql .=" where a.goodsType = 'inside' and a.published = 1";

		if($cat_id != null){

			$sql .= " and a.cat_id = '{$cat_id}'";
		}

		if($tag_id != null){

			$sql .= " and b.tag_id = '{$tag_id}'";
		}


		$sql .=" order by goodsid DESC limit {$page},{$size}";


	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}


function getGoodsByBrand($page=1,$size,$count=false,$brand_id){

	if($page <=0){
		$page = 1;
	}
	$page = $page * $size - $size;

	if($count == true){
		$sql = "select count(*) as count from cms_publish_goods as a where a.goodsType = 'inside' and a.published = 1 and brand_id = {$brand_id}";
	}else{
		$sql = "select * from cms_publish_goods as a where a.goodsType = 'inside' and a.published = 1 and brand_id = {$brand_id} order by goodsid DESC limit {$page},{$size}";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getAllGoodsCat(){

	$sql = "select * from cms_product_category";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;


}

function getGoodsCatById($id){

	$sql = "select * from cms_product_category where id = {$id}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];

}

function getGoodsCatFront(){

	$sql = "select * from cms_product_tag_category where published =1 and front_show =1";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getGoodsTagByCat($cat_id){

	$sql = "select * from cms_product_tag where published =1 and cat_id = {$cat_id}";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getGoodsBrandById($id){
	$sql = "select * from cms_product_brand where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];

}

function countWishList($user_id,$goodsid){

	$sql = "select count(*) as count from cms_publish_cart where UserName = '{$user_id}' and ItemGoodsID = {$goodsid} and ItemStatus = 'Wish'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0]["count"];
}

function getGoodsTagsById($id){

	$sql = "select b.*,a.tag_id from cms_product_tag_xref as a left join cms_product_tag as b on a.tag_id = b.id where goods_id = ($id)";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getTagGoods($id){

	$sql = "select b.* from cms_product_tag_xref as a left join cms_publish_goods as b on a.goods_id = b.goodsid where a.tag_id in ($id) and b.goodsid != '' and b.published =1 group by b.goodsid ORDER BY RAND()";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getProductColor($name){

	$sql = "select * from cms_product_color where name = '{$name}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}


?>