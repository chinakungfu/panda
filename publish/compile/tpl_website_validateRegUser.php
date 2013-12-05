<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>

<?php //echo $this->_tpl_vars["IN"]["staffId"]; ?>
<?php if ($this->_tpl_vars["method"]=='validateRegUser'){ ?>
	<?php $this->_tpl_vars["result"]=runFunc('validateStaff',array($this->_tpl_vars["IN"]["staffId"])); ?>
	<?php if ($this->_tpl_vars["result"]['status'] == -1){
			$success_content = "This user does not exist.";
			header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Authentication Failed&alert_content='.$success_content.'&link_action=website&link_method=index')));
			exit;
	} ?>    
	<?php if ($this->_tpl_vars["result"]['status'] == -2){
			$success_content = "This user has been authenticated.";
			header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Authentication Failed&alert_content='.$success_content.'&link_action=website&link_method=index')));
			exit;
	} ?>      
	<?php if ($this->_tpl_vars["result"]['status'] == 1){
			runFunc('writeSession',array($this->_tpl_vars["IN"]["staffId"]));
            if($this->_tpl_vars["IN"]["validateType"] == 'admin'){
            	header("Location:index.php".runFunc('encrypt_url',array('action=account&method=modify')));
            }else{
				header("Location:index.php".runFunc('encrypt_url',array('action=website&method=addRegAddress')));
			}
			
		} ?>
<?php } ?>