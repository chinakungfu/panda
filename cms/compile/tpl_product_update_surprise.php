<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
$dataType = $this->_tpl_vars["IN"]["dataType"];
$backType = $this->_tpl_vars["IN"]["backType"];
if($dataType == 'one'){
	$id = $this->_tpl_vars["IN"]["id"];
	$goodsInfo = runFunc("getAdminGoodsById",array($id));
	if($backType == 'outside'){
		$link = runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products&page='.$this->_tpl_vars["IN"]["page"]));
	}else if($backType == 'inside'){
		$link = runFunc('encrypt_url',array('action=cms&method=product_list&type=products&page='.$this->_tpl_vars["IN"]["page"]));
	}


	//验证URL
	$isdomain = runFunc("isTaobao",array($goodsInfo['goodsURL']));
	if($isdomain){

		//检查是否已经获取过了
/*		$result = runFunc("checkItemUrl",array($goodsInfo['goodsURL']));
		if(count($result)>0){
			runFunc('showMsg',array('更新失败,URL不正确',$link,'',3000));
			exit;
		}*/
		$fullcontent = @file_get_contents($goodsInfo['goodsURL']);
		$pos = strpos($fullcontent,'</head>');
		$headcontent = substr($fullcontent,0,$pos);
		$headcontent = mb_convert_encoding($headcontent, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
		$content = substr($fullcontent,$pos + 7);
		$content = preg_replace("/[\r\n]/",'',$content);
		$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
		if(preg_match("/(此商品已下架|此宝贝已下架)/i",$content,$isxiajia) == 1){
			runFunc('showMsg',array('更新失败,此商品已下架',$link,'',3000));
			exit;
		}
		if($isdomain === "taobao"){
			//价格
			@preg_match("/id=\"J_StrPrice\".*?class=\"tb-rmb-num\">(.*)<\/em><\/strong>/i",$content,$price);
			if(empty($price)){
				@preg_match("/\"skuMap\":.*?\"price\".*?\"(.*?)\"/i",$content,$price);
			}else if(strpos($price[1],'-')){
				$price = explode('-',$price[1]);
			}
			@preg_match("/<h3><span*.?class=\"tb-double-tag\"><\/span>(.*?)<\/h3>/i",$content,$title);
			if(empty($title)){
				@preg_match("/\"title\":\"(.*?)\"/i",$content,$title);
				if(empty($title)){
					@preg_match("/<title>(.*)<\/title>/i",$headcontent,$title);
				}
			}
			@preg_match("/id=\"J_ImgBooth\".*?src=\"(.*?)\".*?\/>/i",$content,$img);
			@preg_match("/rstShopId:(.*?),/i",$content,$shopid);
			@preg_match("/nickName:.*?'(.*?)'/i",$content,$nickName);
			@preg_match("/id=\"shop-rank\".*?<img.*?src=\"(.*?)\"/i",$content,$shopRank);
			@preg_match("/class=\"tb-enter-shop\".*?href=\"(.*?)\".*?进入店铺/i",$content,$shopUrl);
		}else if($isdomain === "tmall"){
			@preg_match("/'defaultItemPrice'.*?'(.*?)',/i",$content,$price);
			if(empty($price)){
				@preg_match("/\"skuMap\":.*?\"price\".*?\"(.*?)\"/i",$content,$price);
				if(empty($price)){
					@preg_match("/'reservePrice'.*?'(.*?)',/i",$content,$price);
					if(empty($price)){
						@preg_match("/<span>价.*?格.*?<\/span>.*?<del>(.*)<\/del><strong.*?id=\"J_StrPrice\"/i",$content,$price);
					}
				}
			}else if(strpos($price[1],'-')){
				$price = explode('-',$price[1]);
			}

			@preg_match("/<h3.*?data-spm=\"1000983\"><a.*?>(.*?)<\/a>.*?<\/h3>/i",$content,$title);
			if(empty($title)){
				@preg_match("/class=\"tb-detail-hd\">.*?<h3>.*?<a.*?>(.*?)<\/a>/i",$content,$title);
				if(empty($title)){
					@preg_match("/<title>(.*)<\/title>/i",$headcontent,$title);
				}
			}
			@preg_match("/id=\"J_ZoomHook\".*?src=\"(.*?)\"><\/span>/i",$content,$img);
			if(empty($img)){
				@preg_match("/id=\"J_ImgBooth\".*?src=\"(.*?)\"/i",$content,$img);
			}
			@preg_match("/\"sellerNickName\".*?'(.*?)',/i",$content,$nickName);
			@preg_match("/shopid=\"(.*?)\"/i",$content,$shopid);
			@preg_match("/class=\"enter-shop\".*?href=\"(.*?)\".*?进入店铺/i",$content,$shopUrl);
		}
		//$props[] = '';
		//颜色分类
		@preg_match("/<ul.*?\"(颜色分类|颜色)\".*?>(.*?)<\/ul>/i",$content,$colorList);
		if($colorList[2]){
			@preg_match_all("/<span>(.*?)<\/span>/i",$colorList[2],$colorSpan);
		}
		if($colorSpan[1]){
			$props['color'] = '';
			for($i = 0;$i<count($colorSpan[1]);$i++){
				$color = runFunc(translate,array($colorSpan[1][$i]));
				//$props['color'][$i] = urlencode(trim($color));
				$props['color'][$i] = trim($color);
			}
		}
		//尺寸分类
		@preg_match("/<ul.*?\"(尺码分类|尺码|尺寸|运动服尺寸|鞋尺码|帽围尺码|雨刷尺寸|戒指手寸|规格)\".*?>(.*?)<\/ul>/i",$content,$sizeList);
		if($sizeList[2]){
			@preg_match_all("/<span>(.*?)<\/span>/i",$sizeList[2],$sizeSpan);
		}
		if($sizeSpan[1]){
			$props['size'] = '';
			for($i = 0;$i<count($sizeSpan[1]);$i++){
				//$props['size'][$i] = urlencode(trim($sizeSpan[1][$i]));
				$props['size'][$i] = trim($sizeSpan[1][$i]);
			}
		}
		//其它分类
		@preg_match("/<ul.*?\"(口味|套餐|套餐类型|容量|金重|食品品类)\".*?>(.*?)<\/ul>/i",$content,$attribList);
		if($attribList[2]){
			@preg_match_all("/<span>(.*?)<\/span>/i",$attribList[2],$attribSpan);
		}
		if($attribSpan[1]){
			$taobao['other'] = explode('|',$GLOBALS['taobao']['other']);
			$otherCh = explode(',',$taobao['other'][0]);
			$otherEn = explode(',',$taobao['other'][1]);
			$otherVal = 'other';
			foreach($otherCh as $k => $v){
				if($v == $attribList[1]){
					$otherVal =  $otherEn[$k];
				}
			}
			$props[$otherVal] = '';
			for($i = 0;$i<count($attribSpan[1]);$i++){
				$other = runFunc(translate,array($attribSpan[1][$i]));
				//$props['other'][$i] = urlencode(trim($other));
				$props[$otherVal][$i] = trim($other);
			}
		}
		//组织数据
	$goods = array(
		//"goodsDetail"=>$result["goodsDetail"],
		"goodsTitleCN"=>$title[1],
		"goodsUnitPrice"=>(int)$price[1],
		"click_url" =>'',
		"props"=>	'['.json_encode($props).']',
		"goodsShopId"=>$shopid[1],
		"goodsShopName"=>urldecode($nickName[1]),
		"goodsShopUrl"=>$shopUrl[1],
	);

		if($goods["goodsUnitPrice"] && $goods["goodsShopId"]){

			$resultid = runFunc('updateAdminGoodsById',array($id ,$goods));
			if($resultid){
				runFunc('showMsg',array('更新成功',$link,'',3000));
			}else{
				runFunc('showMsg',array('更新失败',$link,'',3000));
			}

		}else{
			//未抓到价格
			runFunc('showMsg',array('更新失败,未抓到价格',$link,'',3000));
		}
	}else{
		//链接不是正确的淘宝和天猫链接
		runFunc('showMsg',array('链接不是正确的淘宝和天猫链接',$link,'',3000));
	}

}else if($dataType == 'batch'){
/*	$goodsID = explode(',',$this->_tpl_vars["IN"]["id"]);
	for($i = 0; $i < count($goodsID);$i++){
		$goodsInfo = runFunc("getAdminGoodsById",array($goodsID[$i]));
		$result = GetGoodsInfo($goodsInfo['goodsURL']);
		$goods = array(
			"goodsDetail"=>$result["goodsDetail"],
			"goodsUnitPrice"=>$result["price"],
			"click_url" =>$result["click_url"],
			"props"=>$result["props"],
			"goodsShopId"=>$result['goodsShopId'],
			"goodsShopName"=>$result['goodsShopName'],
			"goodsShopUrl"=>$result['goodsShopUrl']
		);

		$resultid = runFunc('updateAdminGoodsById',array($goodsID[$i] ,$goods));
		if($resultid){
			$result2['status'] = 1;
		}else{
			$result2['status'] = 0;
			break;
		}
	}
	echo json_encode($result2);*/
}