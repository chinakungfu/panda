<?php import('core.util.RunFunc');

runFunc("final_order_confirm",array($this->_tpl_vars["IN"]["orderID"]));


header("Location: ". runFunc('encrypt_url',array('action=shop&method=orderDetail&orderID=' . $this->_tpl_vars["IN"]["orderID"])));