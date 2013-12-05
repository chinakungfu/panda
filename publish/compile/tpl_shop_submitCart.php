<?php import('core.util.RunFunc'); ?>
<?php
	if($this->_tpl_vars["goodsitem"]){
		header("Location: ".runFunc('encrypt_url',array('action=shop&method=cartToOrder&cartIdStr='.$this->_tpl_vars["goodsitem"])));
	}else if($this->_tpl_vars["group_carts"] && $this->_tpl_vars["check_type"] == 'group_buy'){
		header("Location: ".runFunc('encrypt_url',array('action=shop&method=WOWd2d&check_type=group_buy&cartIdStr='.$this->_tpl_vars["group_carts"])));
	}else{
		header("Location: ".runFunc('encrypt_url',array('action=shop&method=myCart')));
	}
?>