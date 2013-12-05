<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='addNewGoods'){?>
<?php
	$appName ="publish";
	$this->_tpl_vars["backUrl"]='action=shop&method=linkTest&grapRst=alert';
	$sessId = $_COOKIE['sesCoo'];
	$dbSession = new dbSession();
	$userId= $dbSession->read($sessId);
	if(empty($userId)){
		$this->_tpl_vars["jumpUrl"]='action=shop&method=messages_help&grapRst=alert';
	}
	else{
		 $this->_tpl_vars["jumpUrl"]='action=shop&method=messages_help&grapRst=alert';
	}
	$isdomain = runFunc("isTaobao",array($this->_tpl_vars["IN"]["GoodsURL"]));
	if($isdomain){
		$result = runFunc("checkItemUrl",array($this->_tpl_vars["IN"]["GoodsURL"]));
		if(count($result)>0){
			header("Location: ".runFunc('encrypt_url',array('action=surprise&method=item_hotShow&id='.$result[0]["goodsid"].'&show_type=normal&from=search_url')));
			exit;
		}
		$fullcontent = @file_get_contents($this->_tpl_vars["IN"]["GoodsURL"]);
		$pos = strpos($fullcontent,'</head>');
		$headcontent = substr($fullcontent,0,$pos);
		$headcontent = mb_convert_encoding($headcontent, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
		$content = substr($fullcontent,$pos + 7);
		$content = preg_replace("/[\r\n]/",'',$content);
		$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
		if(preg_match("/(此商品已下架|此宝贝已下架)/i",$content,$isxiajia) == 1){
			header("Location: ".runFunc('encrypt_url',array('action=surprise&method=item_outofstock')));
			exit;
		}
		if($isdomain === "taobao"){
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
		@preg_match("/<ul.*?\"(颜色分类|颜色)\".*?>(.*?)<\/ul>/i",$content,$colorList);
		if($colorList[2]){
			@preg_match_all("/<span>(.*?)<\/span>/i",$colorList[2],$colorSpan);
		}
		if($colorSpan[1]){
			$props['color'] = '';
			for($i = 0;$i<count($colorSpan[1]);$i++){
				$color = runFunc(translate,array($colorSpan[1][$i]));
				$props['color'][$i] = trim($color);
			}
		}
		@preg_match("/<ul.*?\"(尺码分类|尺码|尺寸|运动服尺寸|鞋尺码|帽围尺码|雨刷尺寸|戒指手寸|规格)\".*?>(.*?)<\/ul>/i",$content,$sizeList);
		if($sizeList[2]){
			@preg_match_all("/<span>(.*?)<\/span>/i",$sizeList[2],$sizeSpan);
		}
		if($sizeSpan[1]){
			$props['size'] = '';
			for($i = 0;$i<count($sizeSpan[1]);$i++){
				$props['size'][$i] = trim($sizeSpan[1][$i]);
			}
		}
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
				$props[$otherVal][$i] = trim($other);
			}
		}
		$this->_tpl_vars["para"]["props"] = '['.json_encode($props).']';
		$this->_tpl_vars["para"]["click_url"] = '';
		$this->_tpl_vars["para"]["goodsDetail"] = '';
		$imgUrl = preg_replace("/_310x310\.jpg/",'',$img[1]);
		$this->_tpl_vars["para"]["goodsImgURL"]	= $imgUrl;
		$this->_tpl_vars["para"]["goodsTitleCn"] = $title[1];
		$this->_tpl_vars["para"]["goodsTitleEn"] = runFunc('translate',array($title[1]));
		$this->_tpl_vars["para"]["goodsURL"]=$this->_tpl_vars["IN"]["GoodsURL"];
		$this->_tpl_vars["para"]["goodsUnitPrice"]= (int)$price[1];
		$this->_tpl_vars["para"]["goodsFrom"]=$isdomain;
		$this->_tpl_vars["para"]["goodsFreight"]= (float)15;
		$this->_tpl_vars["para"]["goodsStatus"]='Open';
	    $this->_tpl_vars["para"]["goodsType"]='outside';
	    $this->_tpl_vars["para"]["created"] = time();
	    $this->_tpl_vars["para"]["goodsShopId"] = $shopid[1];
	    $this->_tpl_vars["para"]["goodsShopName"] = urldecode($nickName[1]);
	    $this->_tpl_vars["para"]["goodsShopRank"] = $shopRank[1];
		$this->_tpl_vars["para"]["goodsShopUrl"] = $shopUrl[1];
		if($this->_tpl_vars["para"]["goodsUnitPrice"] && $this->_tpl_vars["para"]["goodsShopId"]){
		    $this->_tpl_vars["nodeId"]=runFunc('getGlobalModelVar',array('outsideGoodsNode'));
		    $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"]));
		    $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"];
		    $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["node"]["0"]["nodeGuid"];

			$this->_tpl_vars["name"]=runFunc('readSession',array());
			if ($this->_tpl_vars["name"]){
			 	$this->_tpl_vars["para"]["goodsAddUser"]=$this->_tpl_vars["name"];
			}else{
			 	$this->_tpl_vars["para"]["goodsAddUser"]=runFunc('readCookie',array());
			}

			$this->_tpl_vars["addGoodsTable"]=runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["para"]));

			if ($this->_tpl_vars["addGoodsTable"]){
				header("Location: ".runFunc('encrypt_url',array('action=surprise&method=item_hotShow&id='.$this->_tpl_vars["addGoodsTable"].'&show_type=normal&from=search_url')));
			}else{
 ?>
				<script>alert("An error has occurred, the items you choosed is possibly sold out .");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
<?php
			}
		}else{
			header("Location: ".runFunc('encrypt_url',array('action=surprise&method=item_error')));
		}
	}else{
		header("Location: ".runFunc('encrypt_url',array($this->_tpl_vars["jumpUrl"] . '&alertContent=Please Input the right Link at first!')));
	}
}
?>
