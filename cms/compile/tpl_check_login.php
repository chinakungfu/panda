<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
<?php header("Location: ../member/index.php".runFunc('encrypt_url',array('action=member&method=login')));?>
<?php }else{ 
$user_info = runFunc("getUser",array($this->_tpl_vars["name"]));
if($user_info[0]["groupName"]=="官方管理员" or $user_info[0]["groupName"]=="administrator" or $user_info[0]["groupName"]=="Site Manager"){
	
runFunc('writeSession',array($this->_tpl_vars["name"]));
	
}else{?>
<?php header("Location: ../member/index.php".runFunc('encrypt_url',array('action=member&method=login')));?>
<?php } 
}
?>
