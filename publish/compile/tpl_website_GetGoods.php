<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>WOW TAOBAO</title>
	<link rel="stylesheet" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/css/style.css"/>
	
</head>

<body>
  <?php $this->_tpl_vars["result"]=runFunc('GetGoodsInfo',array($this->_tpl_vars["IN"]["GoodsURL"])); ?>

<?php if ($this->_tpl_vars["result"]=='-1'){?>
<?php echo $this->_tpl_vars["result"];?>
<?php } elseif (!is_array($this->_tpl_vars["result"])){ ?>
<?php echo $this->_tpl_vars["result"];?>
<?php }else{ ?>

<?php $this->_tpl_vars["nodeId"]=runFunc('getGlobalModelVar',array('goodsNodle')); ?>
<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>

<form name="form" id="home-login" class="right" action="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php" method="post">
<input type="hidden" name="action" value="wow">
<input type="hidden" name="method" value="addCart">
<input type="hidden" name="nodeId" value="<?php echo $this->_tpl_vars["node"]["0"]["nodeId"];?>">
<input type="hidden" name="para[nodeId]" value="<?php echo $this->_tpl_vars["node"]["0"]["nodeGuid"];?>">
<input type="hidden" name="contentModel" value="<?php echo $this->_tpl_vars["node"]["0"]["appTableName"];?>">
<input type="hidden" name="para[goodsImgURL]" value="<?php echo $this->_tpl_vars["result"]["img"];?>">
<input type="hidden" name="para[goodsStatus]" value="Open">
<input type="hidden" name="para[goodsType]" value="outside">
<input type="hidden" name="para[goodsURL]" value="<?php echo $this->_tpl_vars["IN"]["GoodsURL"];?>">

<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
	<?php if ($this->_tpl_vars["name"]){?>
		<input type="hidden" name="para[goodsAddUser]" value="<?php echo $this->_tpl_vars["name"];?>">	
		<input type="hidden" name="isLogin" value="1">	
	<?php }else{ ?>	
		<input type="hidden" name="isLogin" value="0">
		<input type="hidden" name="para[goodsAddUser]" value="<?php echo runFunc('getSessionID',array());?>">
	<?php } ?>
<table>
<tr>
	<td>Goods Name:</td>
	<td><input name="para[goodsTitleCN]" type="text" class="home-login-input" id="username" Value="<?php echo $this->_tpl_vars["result"]["title"];?>"/></td>
</tr>
<tr>
	<td>Engilsih Description:</td>
	<td><input name="para[goodsTitleEn]" type="text" class="home-login-input" id="username" Value="<?php echo $this->_tpl_vars["result"]["title"];?>"/></td>
</tr>
<tr>
	<td>Price:</td>
	<td><input name="para[goodsUnitPrice]" type="text" class="home-login-input" id="username" Value="<?php echo $this->_tpl_vars["result"]["price"];?>"/></td>
</tr>
<tr>
	<td>Freight:</td>
	<td><input name="para[goodsFreight]" type="text" class="home-login-input" id="username" Value="<?php echo $this->_tpl_vars["result"]["postage"];?>"/></td>
</tr>
<tr>
	<td>QTY:</td>
	<td><input name="ItemQTY" type="text" class="home-login-input" id="username" /></td>
</tr>
<tr>
	<td>Note:</td>
	<td><textarea name="para[goodsNotes]" rows="4" class="home-login-input" id="username"></textarea></td>
</tr>
<tr>
	<td>Img:</td>
	<td><img id="logo" src="<?php echo $this->_tpl_vars["result"]["img"];?>" width="200" height="200"/></td>
</tr>
</table>

<br>
<br>
<br>

<br>
<input type="submit" value="Add Cart"/>
<input type="button" value="Back" class="button" onClick="window.history.back();">
</form>
<?php } ?>
 </body>
</html>