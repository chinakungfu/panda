<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='addGoods'){?>

<?php
$appName ="publish";

$urls= parse_url($this->_tpl_vars["IN"]["GoodsURL"]);
if(empty($urls['scheme']) || empty($urls['host'])){
	runFunc(webJump,array($this->_tpl_vars["IN"]["where"],$this->_tpl_vars["IN"]["GoodsURL"]));
	exit();
}else{
	$result = runFunc("checkItemUrl",array($this->_tpl_vars["IN"]["GoodsURL"]));
	if(count($result)>0){
		header("Location: ".runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$result[0]["goodsid"].'&show_type=normal&from=search_url')));
		exit;
	}
}

//URl where from
$this->_tpl_vars["result"]=runFunc('urlComeFrom',array($this->_tpl_vars["IN"]["GoodsURL"]));
?>

<?php //print_r($this->_tpl_vars["result"]);exit();?>

<?php $this->_tpl_vars["backUrl"]='action=shop&method=linkTest&grapRst=alert';
$sessId = $_COOKIE['sesCoo'];
$dbSession = new dbSession();
$userId= $dbSession->read($sessId);
if(empty($userId)){
	$this->_tpl_vars["jumpUrl"]='action=shop&method=messages_help&grapRst=alert';
}
else{
	 $this->_tpl_vars["jumpUrl"]='action=shop&method=messages_help&grapRst=alert';
}

?>
<?php if ($this->_tpl_vars["result"]=='-1'){
		header("Location: ".runFunc('encrypt_url',array("action=shop&method=searchFailed")));
	?>

<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["jumpUrl"] . '&alertContent=Please check the link you input!'));?>"</script>
<?php } elseif (!is_array($this->_tpl_vars["result"])){ ?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["jumpUrl"] . '&alertContent=Please Input the right Link at first!'));?>"</script>
<?php }elseif ($this->_tpl_vars["result"]["stockout"]==1){?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["jumpUrl"] . '&alertContent=The shortage of goods!'));?>"</script>
<?php }elseif ($this->_tpl_vars["result"]["price"]==""){?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["jumpUrl"] . '&alertContent=Can not get the price!'));?>"</script>
<?php } else{ ?>
<?php if(!is_array($this->_tpl_vars["result"]["img"])){?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["jumpUrl"] . '&alertContent=Can not get the image!'));?>"</script>
<?php }else{ ?>
<?php if ($this->_tpl_vars["result"]["title"]<0){?>
<?php $this->_tpl_vars["titleCN"]='0'; ?>
<?php }else{ ?>
<?php $this->_tpl_vars["titleCN"]=$this->_tpl_vars["result"]["title"]; ?>
<?php } ?>
<?php if ($this->_tpl_vars["result"]["price"]<0){?>
<?php $this->_tpl_vars["price"]='0'; ?>
<?php }else{ ?>
<?php

 $this->_tpl_vars["price"]=$this->_tpl_vars["result"]["price"];

?>
<?php } ?>
<?php
$this->_tpl_vars["para"]["props"] = $this->_tpl_vars["result"]["props"];
$this->_tpl_vars["para"]["click_url"] = $this->_tpl_vars["result"]["click_url"];
$this->_tpl_vars["para"]["goodsDetail"] = $this->_tpl_vars["result"]["goodsDetail"];
?>

<?php //print_r($this->_tpl_vars["result"]);exit;?>
<?php if ($this->_tpl_vars["result"]["postage"]<15){?>
<?php $this->_tpl_vars["postage"]='15'; ?>
<?php }else{ ?>
<?php $this->_tpl_vars["postage"]=$this->_tpl_vars["result"]["postage"]; ?>
<?php } ?>
<?php if(!empty($this->_tpl_vars["result"]["img"])){
	foreach ($this->_tpl_vars["result"]["img"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){?>
	<?php if ($this->_tpl_vars["key"]==0){?>
	<?php if ($this->_tpl_vars["key"]<$this->_tpl_vars["IN"]["imgQty"]){?>
	<?php $this->_tpl_vars["para"]["goodsImgURL"]=runFunc('addImageToResource',array($this->_tpl_vars["var"]['url'] . $this->_tpl_vars["result"]["size"],$this->_tpl_vars["result"]["from"])); ?>
	<?php }else{ ?>
	<?php $this->_tpl_vars["para"]["goodsImgURL"]=$this->_tpl_vars["var"]['url']; ?>
	<?php } ?>
	<?php }elseif ($this->_tpl_vars["key"]==1){ ?>
	<?php if ($this->_tpl_vars["key"]<$this->_tpl_vars["IN"]["imgQty"]){?>
	<?php $this->_tpl_vars["para"]["goodsImgURL1"]=runFunc('addImageToResource',array($this->_tpl_vars["var"]['url'] . $this->_tpl_vars["result"]["size"],$this->_tpl_vars["result"]["from"])); ?>
	<?php }else{ ?>
	<?php $this->_tpl_vars["para"]["goodsImgURL1"]=$this->_tpl_vars["var"]['url']; ?>
	<?php } ?>
	<?php } elseif ($this->_tpl_vars["key"]==2){ ?>
	<?php if ($this->_tpl_vars["key"]<$this->_tpl_vars["IN"]["imgQty"]){?>
	<?php $this->_tpl_vars["para"]["goodsImgURL2"]=runFunc('addImageToResource',array($this->_tpl_vars["var"]['url'] . $this->_tpl_vars["result"]["size"],$this->_tpl_vars["result"]["from"])); ?>
	<?php }else{ ?>
	<?php $this->_tpl_vars["para"]["goodsImgURL2"]=$this->_tpl_vars["var"]['url']; ?>
	<?php } ?>
	<?php } elseif ($this->_tpl_vars["key"]==3){ ?>
	<?php if ($this->_tpl_vars["key"]<$this->_tpl_vars["IN"]["imgQty"]){?>
	<?php $this->_tpl_vars["para"]["goodsImgURL3"]=runFunc('addImageToResource',array($this->_tpl_vars["var"]['url'] . $this->_tpl_vars["result"]["size"],$this->_tpl_vars["result"]["from"])); ?>
	<?php }else{ ?>
	<?php $this->_tpl_vars["para"]["goodsImgURL3"]=$this->_tpl_vars["var"]['url']; ?>
	<?php } ?>
	<?php } ?>
	<?php }
}
?>
<?php $this->_tpl_vars["nodeId"]=runFunc('getGlobalModelVar',array('outsideGoodsNode')); ?>
<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>

<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["node"]["0"]["nodeGuid"]; ?>

<?php $this->_tpl_vars["para"]["goodsStatus"]='Open'; ?>
<?php $this->_tpl_vars["para"]["goodsType"]='outside'; ?>

<?php $this->_tpl_vars["para"]["goodsUnitPrice"]=$this->_tpl_vars["price"];
	  $this->_tpl_vars["para"]["goodsFrom"]=$this->_tpl_vars["result"]["from"];
	  $this->_tpl_vars["para"]["created"] = time();
?>
<?php $this->_tpl_vars["para"]["goodsFreight"]=$this->_tpl_vars["postage"]; ?>
<?php $this->_tpl_vars["para"]["goodsTitleCn"]=$this->_tpl_vars["titleCN"]; ?>
<?php $this->_tpl_vars["para"]["goodsURL"]=$this->_tpl_vars["IN"]["GoodsURL"]; ?>

<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<?php if ($this->_tpl_vars["name"]){?>
<?php $this->_tpl_vars["para"]["goodsAddUser"]=$this->_tpl_vars["name"]; ?>
<?php }else{ ?>
<?php $this->_tpl_vars["para"]["goodsAddUser"]=runFunc('readCookie',array()); ?>
<?php } ?>
<?php $this->_tpl_vars["addGoodsTable"]=runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["para"]));?>
<?php if ($this->_tpl_vars["addGoodsTable"]){
	header("Location: ".runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$this->_tpl_vars["addGoodsTable"].'&show_type=normal&from=search_url')));

 }else{ ?>
<script>alert("An error has occurred, the items you choosed is possibly sold out .");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
<?php } ?>
<?php } ?>

<?php } ?>
<?php } ?>
