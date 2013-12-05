<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>			
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login'));?>'</script>	
<?php }else{ ?>
	<?php $this->_tpl_vars["userInfo"]=runFunc('getStaffInfoById',array($this->_tpl_vars["name"])); ?>
	<?php if ($this->_tpl_vars["userInfo"]["0"]["groupName"]!='administrator'){?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login'));?>'</script>	
	<?php } ?>
<?php } ?>

<?php $this->_tpl_vars["tempUrl"]='action=admin&method=orderDetail&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>
<?php $this->_tpl_vars["Urltemp"]='action=admin&method=orderDetail&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>
<?php if ($this->_tpl_vars["method"]=='updateOrder'){?>	
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemQTY = '{$this->_tpl_vars["IN"]["para"]["ItemQTY"]}',itemPrice='{$this->_tpl_vars["IN"]["para"]["goodsUnitPrice"]}', itemFreight='{$this->_tpl_vars["IN"]["para"]["Freight"]}' WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 ); 

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	
	<?php if ($this->_tpl_vars["updateCart"]){?>
		<script>alert('Edit Successfully. If you finished order edit, please click the confirm button!');location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>		
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='confirmOrder'){ ?>
	<?php $this->_tpl_vars["Url"]='action=admin&method=orderDetail&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "getCartIDstr",
	'query' => "select * from  cms_publish_order where  orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 ); 

$this->_tpl_vars['getCartIDstr'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php if ($this->_tpl_vars["getCartIDstr"]["data"]["0"]["orderStatus"]==3){?>
		<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "UPDATE cms_publish_order SET orderStatus = '4' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 ); 

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>		
		<?php if (updateOrder){?>
			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "addressInfo",
	'query' => "SELECT * FROM cms_publish_address WHERE addressID='{$this->_tpl_vars["getCartIDstr"]["data"]["0"]["orderAddress"]}' limit 1",
 ); 

$this->_tpl_vars['addressInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
			<?php $this->_tpl_vars["mailArr"]["email"]=$this->_tpl_vars["addressInfo"]["data"]["0"]["email"]; ?>
			<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["addressInfo"]["data"]["0"]["userId"]; ?>
			<?php $this->_tpl_vars["mailArr"]["orderNo"]=$this->_tpl_vars["getCartIDstr"]["data"]["0"]["OrderNo"]; ?>
			<?php $this->_tpl_vars["Mailresult"]=runFunc('sendMail',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"])); ?>
			<?php if (resultMail){?>
				<script>alert('Update Successfully');location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Url"]));?>'</script>
			<?php }else{ ?>
				<script>alert('Mail Fail');location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"]));?>"</script>
			<?php } ?>					
		<?php } ?>		
	<?php }else{ ?>
		<script>alert("This order has been fixed.");location.href='index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>'</script>
	<?php } ?>
<?php } ?>