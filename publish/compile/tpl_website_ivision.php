<?php header("Content-type: text/html; charset=utf-8");?>
<?php import('core.util.RunFunc'); ?>
<?php $site_title = runFunc('getGlobalModelVar',array('Site_Name'));
$seo_settings = runFunc("getSeoSettings");
?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>
	<?php if ($this->_tpl_vars["CookieUser"]){?>
		<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["CookieUser"]; ?>
	<?php }else{ ?>
		<?php $this->_tpl_vars["tmpUser"]=runFunc('getSessionID',array()); ?>
		<?php runFunc('writeCookie',array($this->_tpl_vars["tmpUser"]))?>
	<?php } ?>
<?php }else{ ?>
	<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["name"]; ?>
<?php } ?>
<?php $this->_tpl_vars["cartNodeId"]=runFunc('getGlobalModelVar',array('cartNode')); ?>
<?php $this->_tpl_vars["cartNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["cartNodeId"])); ?>
<?php $this->_tpl_vars["cartContentModel"]=$this->_tpl_vars["cartNode"]["0"]["appTableName"]; ?>
<?php //组织数据 ?>
<?php $this->_tpl_vars["cartPara"]["nodeId"]=$this->_tpl_vars["cartNode"]["0"]["nodeGuid"]; ?>
<?php $this->_tpl_vars["cartPara"]["ItemStatus"]='New'; ?>
<?php $this->_tpl_vars["cartPara"]["UserName"]=$this->_tpl_vars["tmpUser"]; ?>
<?php $this->_tpl_vars["cartPara"]["cart_type"] = 1 ?>

<?php
/*$cup = 4852;
$gallery = 4853;*/
$goodsitem = "";
$a = explode('&',$_SERVER["QUERY_STRING"]);
$result =  substr($a[1],strpos($a[1], '=')+1);
$Temp = base64_decode($result);
$orderinfo = json_decode($Temp,true);
foreach($orderinfo as $k => $v){
	foreach($v as $j => $h){
		if($j == "imgHtml"){		//商品图片
			$imgHtml = htmlspecialchars($h);
		}else if($j == "price"){	//商品单价
			$price = $h;
		}else if($j == "name"){		//根据名字来定商品ID
			$goodsName = trim($h);
/*			if($h == "cup"){
				$goodsID = $cup;
			}else if($h == "gallery"){
				$goodsID = $gallery;
			}*/
		}else if($j == "count"){		//商品数量
			$itemQTY = $h;
		}
	}
/*	if(!$goodsID){
		$goodsID = $cup;
	}*/
	if(!$itemQTY){
		$itemQTY = 1;
	}
	//获取商品信息
	//$item = runFunc("getCartGoodsItem",array($this->_tpl_vars["cartPara"]["ItemGoodsID"]));
	$item = runFunc("getGoodsItem",array($goodsName));
	if($item){
		$this->_tpl_vars["cartPara"]["itemNotes"] = $imgHtml;
		$this->_tpl_vars["cartPara"]["ItemType"] = "ivi";
		$this->_tpl_vars["cartPara"]["ItemQTY"] = $itemQTY;
		$this->_tpl_vars["cartPara"]["ItemGoodsID"] = $item[0]['goodsid'];
		//获取商品价格
		$this->_tpl_vars["cartPara"]["itemPrice"]=$item[0]["goodsUnitPrice"];
		$this->_tpl_vars["cartPara"]["itemFreight"] = 0;
		$this->_tpl_vars["addCartTable"]=runFunc('addData',array($this->_tpl_vars["cartNodeId"],$this->_tpl_vars["cartContentModel"],$this->_tpl_vars["cartPara"]));
		if($this->_tpl_vars["addCartTable"]){
			if(!$goodsitem || $goodsitem == ""){
				$goodsitem = $this->_tpl_vars["addCartTable"];
			}else{
				$goodsitem .= ",".$this->_tpl_vars["addCartTable"];
			}
		}
	}
}
?>
<?php
//echo $goodsitem."|||<br>";
if($goodsitem):?>
<?php
	$link = "index.php".runFunc('encrypt_url',array('action=shop&method=WOWd2d&cartIdStr='.$goodsitem));
?>
<script>location.href="<?php echo $link;?>"</script>
<?php else:?>
<?php $link = "http://www.ivisionphoto.net/index.php/en/school/ssis";?>
<script>
var goUrl = confirm("此商品没有发布,点击确认返回ivisionphoto.");
if(goUrl){
	history.go(-1);
}else{
	location.href="<?php echo $link;?>";
}
</script>
<?php endif;?>
<?php
exit();
/*
 * <?php //$link = "http://www.ivisionphoto.net/index.php/en/school/ssis";?>
 * echo "用户名:".$this->_tpl_vars["tmpUser"]."<br>cartNodeId节点ID：".$this->_tpl_vars["cartNodeId"]."<br>cartContentModel:".$this->_tpl_vars["cartContentModel"]."<br>";
//print_R($this->_tpl_vars["cartNode"]);


$a = explode('&',$_SERVER["QUERY_STRING"]);
$result =  substr($a[1],strpos($a[1], '=')+1);
$Temp = base64_decode($result);

//$kkk = htmlspecialchars($Temp);
//$ccc = stripslashes($kkk);

$orderinfo = json_decode($Temp,true);
foreach($orderinfo as $k => $v){
	echo "订单名称:".$k."==>以下是此项订单内容</br>";
	foreach($v as $j => $k){

		if($j == "imgHtml"){
			echo $j.":".htmlspecialchars($k)."<br>";
		}else{
			echo $j.":".$k."<br>";
		}
	}
}
*/
?>
