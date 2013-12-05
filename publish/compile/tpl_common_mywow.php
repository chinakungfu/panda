<?php import('core.util.RunFunc'); ?><div id="mywow" class="wow-module">
	<h3 class="wow-module-title">
		MY WOW
	</h3>
	<a href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php?LCMSPID=BDUBawJ0UGpVPAdpUWsPZlU7VXlUcAYiA2oGbF5zVm1Rblc6AD9XaQZ5URJWMAF5UilWLldpA24DYwVvABAFMgRpAU8CV1BAVRQHS1EeD2RVLlU6" class="mywow-links">
		<span class="left">Cart</span>					
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "CartNum",
	'query' => "SELECT count(*) as cnum FROM a0222211743.cms_publish_cart WHERE UserName ='{$this->_tpl_vars["name"]}' and ItemStatus='New'",
 ); 

$this->_tpl_vars['CartNum'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php if(!empty($this->_tpl_vars["CartNum"]["data"])){ 
 foreach ($this->_tpl_vars["CartNum"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var_CartNum']){ ?>
	<?php  }
} ?>
		<span class="right">(<?php echo $this->_tpl_vars["var_CartNum"]["cnum"];?>)</span>
	</a>
	<a href="" class="mywow-links">
		<span class="left">Order</span>
		<span class="right">(01)</span>
	</a>
	<a href="" class="mywow-links">
		<span class="left">Package</span>
		<span class="right">(01)</span>
	</a>
	<a href="" class="mywow-links">
		<span class="left">Status</span>
	</a>
	<a href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php?LCMSPID=UGEJY1UjBz0GbwZoVW8BaANtU38HI1F1CmMFbw4jVW5XaAdqAzxXUwRrB3RQP14YUDZWe1VxBCADaVU1XGEEMlBJCWRVagcTBlcGRVUVAUcDRFNsByNRYg%3D%3D" class="mywow-links">
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "WishNum",
	'query' => "SELECT count(*) as cnum FROM a0222211743.cms_publish_cart WHERE UserName ='{$this->_tpl_vars["name"]}' and ItemStatus='Wish'",
 ); 

$this->_tpl_vars['WishNum'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php if(!empty($this->_tpl_vars["WishNum"]["data"])){ 
 foreach ($this->_tpl_vars["WishNum"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var_WishNum']){ ?>
	<?php  }
} ?>
		<span class="left">My Wish List</span>
		<span class="right">(<?php echo $this->_tpl_vars["var_WishNum"]["cnum"];?>)</span>
	</a>
	<a href="" class="mywow-links">
		<span class="left">My Profile</span>
	</a>
</div>