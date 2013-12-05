<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->_tpl_vars["method"]=='destroy'){?>
<?php $this->_tpl_vars["result"]=runFunc('readSession',array()); ?>
<?php runFunc('logoutStaff',array($this->_tpl_vars["result"]))?>
<?php runFunc('destroySession',array())?>
	<script language="javascript" type="text/javascript">
	top.opener=null;top.close();
	</script>
<?php }else{ ?>
<?php runFunc('destroySession',array())?>
<?php $action = trim($this->_tpl_vars["IN"]["current_action"]);
		switch ($action){	
			case "shop":
				header("Location:".runFunc('encrypt_url',array('action=website&method=index')));
				break;
			case "share":			
				header("Location:".runFunc('encrypt_url',array('action=share&method=listMain')));
				break;
			case "surprise":
				header("Location:".runFunc('encrypt_url',array('action=share&method=listMain')));
				break;
			default:
				header("Location:".runFunc('encrypt_url',array('action=website&method=index')));
		}
?>
<?php } ?>