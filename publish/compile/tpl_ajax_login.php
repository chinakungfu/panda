<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["result"]=runFunc('checkLogin',array($this->_tpl_vars["staffNo"],$this->_tpl_vars["password"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
	<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>
	<?php if ($this->_tpl_vars["CookieUser"]){?>
		<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "update cms_publish_cart SET UserName= '{$this->_tpl_vars["result"]["0"]["staffId"]}' WHERE `UserName`= '{$this->_tpl_vars["CookieUser"]}'",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
		<?php if ($this->_tpl_vars["updateCart"]){?>
			<?php $this->_tpl_vars["clearCookie"]=runFunc('deleteCookie',array()); ?>
		<?php } ?>
	<?php } ?>
	<?php runFunc('writeSession',array($this->_tpl_vars["result"]["0"]["staffId"]))?>
	<?php return $this->_tpl_vars["result"]["0"]["staffId"] . '|' . $this->_tpl_vars["result"]["0"]["staffName"] ?>

<?php }else{ ?>
	<?php return '0' ?>

<?php } ?>
