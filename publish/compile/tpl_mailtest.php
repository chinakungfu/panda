<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='signup1'){?>
	<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
	<?php if ($this->_tpl_vars["name"]!=''){?>
		<?php $this->_tpl_vars["siteNmae"]= runFunc('getGlobalModelVar',array('Site_Domain')); ?>
		<?php $this->_tpl_vars["mailArr"]["verifyLink"]= $this->_tpl_vars["siteNmae"] . '/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateUser&staffId=' . $this->_tpl_vars["name"])); ?>
		<?php $this->_tpl_vars["result"]=runFunc('sendVerifyMail',array($this->_tpl_vars["name"],$this->_tpl_vars["VerifyLink"])); ?>	

		<?php if ($this->_tpl_vars["result"]){?>
			<script>alert('Successfully£¡');location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=surpriseindex'));?>"</script>
		<?php }else{ ?>
			<script>alert('Fail£¡');location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=surpriseindex'));?>"</script>
		<?php } ?>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='signup'){ ?>
	<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
	
	<?php if ($this->_tpl_vars["name"]!=''){?>
	
		<?php $this->_tpl_vars["siteNmae"]= runFunc('getGlobalModelVar',array('Site_Domain')); ?>
		<?php $this->_tpl_vars["mailArr"]["verifyLink"]= $this->_tpl_vars["siteNmae"] . '/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateUser&staffId=' . $this->_tpl_vars["name"])); ?>
		<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["name"]; ?>
		<?php $this->_tpl_vars["result"]=runFunc('sendMailTest',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"])); ?>
		
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='orderSubmit'){ ?>
	<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
	
	<?php if ($this->_tpl_vars["name"]!=''){?>	
		
		<?php $this->_tpl_vars["mailArr"]["orderNo"]='1336797506-56735'; ?>
		<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["name"]; ?>
		<?php $this->_tpl_vars["result"]=runFunc('sendMailTest',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"])); ?>
		
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='resetPassword'){ ?>
			
		
		<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["IN"]["userId"]; ?>
		<?php $this->_tpl_vars["mailArr"]["newPwd"]=$this->_tpl_vars["IN"]["newPwd"]; ?>
		<?php $this->_tpl_vars["result"]=runFunc('sendMailTest',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"])); ?>
		
	
<?php } ?>