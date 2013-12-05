<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array());
if ($this->_tpl_vars["name"]==''){?>
echo $this->_tpl_vars["tmpUser"]=runFunc('readCookie',array()); }else{
?>
<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["name"]; ?>
<?php } ?>
<?php $this->_tpl_vars["orderNodeId"]=runFunc('getGlobalModelVar',array('orderNode')); ?>
<?php $this->_tpl_vars["orderNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["orderNodeId"])); ?>
<?php $this->_tpl_vars["tempUrl"]='action=wow&method=myCart&nodeId=GWCGLHat1'; ?>
<?php
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
		'action' => "content",
		'return' => "listOrder",
		'nodeid' => "{$this->_tpl_vars["orderNode"]["0"]["nodeGuid"]}",
		'contentid' => "{$this->_tpl_vars["IN"]["para"]["orderID"]}",
);
$this->_tpl_vars['listOrder'] = CMS::CMS_content($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;
?>

<?php if ($this->_tpl_vars["listOrder"]["orderStatus"]==1){?>
<?php if ($this->_tpl_vars["method"]=='updateAddress' and $this->_tpl_vars["listOrder"]["orderUser"]==$this->_tpl_vars["tmpUser"]){?>
<?php $this->_tpl_vars["orderContentModel"]=$this->_tpl_vars["orderNode"]["0"]["appTableName"]; ?>
<?php $this->_tpl_vars["orderappTableKeyName"]=$this->_tpl_vars["orderNode"]["0"]["appTableKeyName"]; ?>
<?php $this->_tpl_vars["orderappTableKeyValue"]=$this->_tpl_vars["IN"]["para"]["orderID"]; ?>
<?php if ($this->_tpl_vars["IN"]["para"]["orderAddress"]){?>
<?php
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
				'action' => "sql",
				'return' => "editOrderTable",
				'query' => "update form a0222211743.cms_publish_order SET orderAddress = '{$this->_tpl_vars["IN"]["para"]["orderAddress"]}',orderStatus='2' WHERE orderID = '{$this->_tpl_vars["IN"]["para"]["orderID"]}'",
);
$this->_tpl_vars['editOrderTable'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
<?php if ($this->_tpl_vars["editOrderTable"]){?>
<?php $this->_tpl_vars["tempUrl"]='action=shop&method=orderConfirm&orderID=' . $this->_tpl_vars["IN"]["para"]["orderID"]; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?> '</script>
<?php } ?>
<?php }else{ ?>
<?php $this->_tpl_vars["checkData"]=runFunc('checkAddressData',array($this->_tpl_vars["IN"]["addressPara"])); ?>
<?php if ($this->_tpl_vars["checkData"]==1){?>
<?php $this->_tpl_vars["AddressNodeId"]=runFunc('getGlobalModelVar',array('AddressNode')); ?>
<?php $this->_tpl_vars["AddressNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["AddressNodeId"])); ?>
<?php $this->_tpl_vars["AddressContentModel"]=$this->_tpl_vars["AddressNode"]["0"]["appTableName"]; ?>

<?php $this->_tpl_vars["addressPara"]["nodeId"]=$this->_tpl_vars["AddressNode"]["0"]["nodeGuid"]; ?>
<?php $this->_tpl_vars["addressPara"]["userId"]=$this->_tpl_vars["tmpUser"]; ?>
<?php $this->_tpl_vars["addressPara"]["status"]=1; ?>
<?php $this->_tpl_vars["addressPara"]["type"]=user; ?>

<?php $this->_tpl_vars["addAddress"]=runFunc('addData',array($this->_tpl_vars["AddressNodeId"],$this->_tpl_vars["AddressContentModel"],$this->_tpl_vars["addressPara"])); ?>
<?php if ($this->_tpl_vars["addAddress"]){?>
<?php $this->_tpl_vars["publishAddress"]=runFunc('publish',array($this->_tpl_vars["AddressNodeId"],$this->_tpl_vars["AddressContentModel"],$this->_tpl_vars["AddressNode"]["0"]["appTableKeyName"],$this->_tpl_vars["addAddress"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"])); ?>
<?php if ($this->_tpl_vars["publishAddress"]){?>
<?php
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
						'action' => "sql",
						'return' => "editOrderTable",
						'query' => "UPDATE a0222211743.cms_publish_order SET orderAddress = '{$this->_tpl_vars["addAddress"]}',orderStatus='2' WHERE orderID = '{$this->_tpl_vars["IN"]["para"]["orderID"]}' ",
);
$this->_tpl_vars['editOrderTable'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
<?php if ($this->_tpl_vars["editOrderTable"]){?>
<?php $this->_tpl_vars["Url"]='action=shop&method=orderConfirm&orderID=' . $this->_tpl_vars["IN"]["para"]["orderID"];?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Url"]));?>"</script>
<?php } ?>
<?php }else{ ?>
1
<?php } ?>

<?php }else{ ?>
2
<?php } ?>
<?php }else{ ?>
<?php $this->_tpl_vars["backData"]=runFunc('backAddressData',array($this->_tpl_vars["IN"]["addressPara"],$this->_tpl_vars["checkData"])); ?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . $this->_tpl_vars["backData"] ));?>"</script>
<?php } ?>
<?php } ?>
<?php }else{ ?>
<script>alert("Failed to release order due to pass due temporary account!");location.href='index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>'</script>
<?php } ?>
<?php }else{ ?>
<script>alert("This order has been fixed.");location.href='index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>'</script>
<?php }?>
