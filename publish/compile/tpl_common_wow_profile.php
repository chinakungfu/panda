<?php import('core.util.RunFunc'); ?><div id="wow-profile">
	<img class="wow-avatar left" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/images/avatar.gif" alt=""/>
	<div id="wow-detail" class="left">
		Welcome!<br/>		
		<?php if ($this->_tpl_vars["name"]){?>
		<?php echo $this->_tpl_vars["name"];?>
		<?php }else{ ?>
		Not Login User
		<?php $this->_tpl_vars["name"]=runFunc('readCookie',array()); ?>
		<?php } ?>
	</div>
</div>