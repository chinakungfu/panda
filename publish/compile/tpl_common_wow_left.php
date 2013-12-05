<?php import('core.util.RunFunc'); ?><div class="line1 left">
	<div id="wow-profile">
		<img class="wow-avatar left" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/images/avatar.gif" alt=""/>
		<div id="wow-detail" class="left">
			Welcome!<br/>			
			<?php if ($this->_tpl_vars["name"]){?>
			<?php echo $this->_tpl_vars["name"];?>
			<?php $this->_tpl_vars["name1"]=$this->_tpl_vars["name"]; ?>
			<?php }else{ ?>
			Not Login User
			<?php $this->_tpl_vars["name1"]=runFunc('readCookie',array()); ?>
			<?php } ?>
		</div>
	</div>
	<div id="mywow" class="wow-module">
		<h3 class="wow-module-title">
			MY WOW
		</h3>
		<a href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php?LCMSPID=BzYDaVIkV20Gb1U7BjwBfARkXncAdgBvUTBRKgAxAj4HMwE1VzgFLwZDAGEBdAl3DyYENFdoA2UCYwJECTRVOwcQA11SE1dDBkxVHQZgAX8EOg%3D%3D" class="mywow-links">
			<span class="left">Cart</span>					
		<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "CartNum",
	'query' => "SELECT count(*) as cnum FROM a0222211743.cms_publish_cart WHERE UserName ='{$this->_tpl_vars["name1"]}' and ItemStatus='New'",
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
		<a href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php?LCMSPID=AzIEblMlBT9XPlwyBz0IdQFhX3ZSJABvVTQPdFxtBTkGMlRgUwZaYAF0A2sBSg1uDnJSeAdxUDwKYQFqDTEFHwM3BDBTFgUBVxJcGwdMCEoBb191UjM%3D" class="mywow-links">
		<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "WishNum",
	'query' => "SELECT count(*) as cnum FROM a0222211743.cms_publish_cart WHERE UserName ='{$this->_tpl_vars["name1"]}' and ItemStatus='Wish'",
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
	<div class="wow-module">
		<h3 class="wow-module-title">
			Member Account
		</h3>
		<div class="wow-ma-contian">
			<span class="left">Balance</span>
			<span class="right">RMB 100.00</span>
			<div class="ov">
				<a class="right button-link" id="rec" href="">Recharge</a>
			</div>
		</div>
		<div class="wow-ma-contian">
			<span class="left">Credits</span>
			<span class="right">1000</span>
		</div>
		<div id="join-member" class="ov">
			<a href="">join member</a>
		</div>
	</div>
	<a class="right button-link" id="rec" href="">Buy More</a>
</div>