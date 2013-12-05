<?php import('core.util.RunFunc'); ?>
<!--获取用户信息-->
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){
		$this->_tpl_vars["paraArr"]["backAction"] = "surprise";
		$this->_tpl_vars["paraArr"]["backMethod"] = "item_hotShow";
		$this->_tpl_vars["paraArr"]["show_type"] = "normal";
		$this->_tpl_vars["paraArr"]["from"] = "search_url";
		$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["goodsID"];
		$this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]);
		header("Location: ".runFunc('encrypt_url',array('action=website&method=login&loginType=addNewCart&paraStr=' . $this->_tpl_vars["paraStr"])));
		exit;
	 }else{
		$this->_tpl_vars["tmpUser"]=$this->_tpl_vars["name"];
 	}
 ?>
<?Php //print_r($this->_tpl_vars["IN"]);exit();?>
<!--获取节点信息-->
<?php $this->_tpl_vars["cartNodeId"]=runFunc('getGlobalModelVar',array('cartNode')); ?>
<?php $this->_tpl_vars["cartNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["cartNodeId"])); ?>
<?php $this->_tpl_vars["cartContentModel"]=$this->_tpl_vars["cartNode"]["0"]["appTableName"]; ?>

<?php $this->_tpl_vars["cartPara"]["nodeId"]=$this->_tpl_vars["cartNode"]["0"]["nodeGuid"]; ?>
<?php $this->_tpl_vars["cartPara"]["ItemStatus"]='New'; ?><!--状态-->
<?php $this->_tpl_vars["cartPara"]["ItemQTY"]=$this->_tpl_vars["IN"]["ItemQTY"]; ?><!--数量-->
<?php $this->_tpl_vars["cartPara"]["UserName"]=$this->_tpl_vars["tmpUser"]; ?>
<?php $this->_tpl_vars["cartPara"]["ItemGoodsID"]=$this->_tpl_vars["IN"]["goodsID"]; ?>
<?php $this->_tpl_vars["cartPara"]["cart_type"] = $this->_tpl_vars["IN"]["cart_type"];?>
<?php $this->_tpl_vars["cartPara"]["itemNotes"] = trim($this->_tpl_vars["IN"]["request"]);?>
<?php  if($this->_tpl_vars["cartPara"]["cart_type"]==1){
		$item = runFunc("getCartGoodsItem",array($this->_tpl_vars["IN"]["goodsID"]));
		$this->_tpl_vars["cartPara"]["itemPrice"]=$item[0]["goodsUnitPrice"];
   }elseif($this->_tpl_vars["cartPara"]["cart_type"]==2){
	   	$item = runFunc("getSiteGroupBuyItem",array($this->_tpl_vars["IN"]["goodsID"]));
	   	if($this->_tpl_vars["IN"]["eventID"]!=""){
			 $this->_tpl_vars["cartPara"]["event_id"] = $this->_tpl_vars["IN"]["eventID"];
		 }
	   	if($item[0]["sell_way"]==1){
	   			$this->_tpl_vars["cartPara"]["itemPrice"]=$item[0]["goodsUnitPrice"];
	   	}else{
	   			$this->_tpl_vars["cartPara"]["itemPrice"]=$item[0]["goodsUnitPrice"] * $item[0]["price_rate"];
	   	}
   }?>
<?php $this->_tpl_vars["cartPara"]["itemTotal"] = (float)($this->_tpl_vars["cartPara"]["itemPrice"] * $this->_tpl_vars["cartPara"]["ItemQTY"]);?>
<!--运费-->
<?php $this->_tpl_vars["cartPara"]["itemFreight"]=$this->_tpl_vars["IN"]["itemFreight"]; ?>

<?php if(isset($this->_tpl_vars["IN"]["props"])){
		$propsStr = '';
		foreach($this->_tpl_vars["IN"]["props"] as $name => $prop){
			if($propsStr == ''){
				//$propsStr =  $name.":".urldecode($prop);
				$propsStr =  $name.":".$prop;
			}else{
				//$propsStr .= "|".$name.":".urldecode($prop);
				$propsStr .= "|".$name.":".$prop;
			}
		}
}?>
<!--商品属性-->
<?php $this->_tpl_vars["cartPara"]["props"] = $propsStr;?>
<!--是否申请改价-->
<?php $this->_tpl_vars["cartPara"]["modifyPriceStatus"] = $this->_tpl_vars["IN"]["modifyPrice"];?>

<?Php //print_r($this->_tpl_vars["cartPara"]);exit;?>

<!--添加购物车数据-->
<?php $this->_tpl_vars["addCartTable"]=runFunc('addData',array($this->_tpl_vars["cartNodeId"],$this->_tpl_vars["cartContentModel"],$this->_tpl_vars["cartPara"])); ?>
<?php if($this->_tpl_vars["addCartTable"]){
	//echo "添加购物车成功!";
	header("Location: ".runFunc('encrypt_url',array('action=shop&method=myCart')));
}else{?>
	<script>alert("添加购物车失败!");location.href='index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$this->_tpl_vars["IN"]["goodsID"].'&show_type=normal&from=search_url'));?>'</script>
<?php
}
?>

