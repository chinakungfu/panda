<?php import('core.util.RunFunc'); ?>
<?php 
$this->_tpl_vars["user_id"] = runFunc('readSession',array());
if(!$this->_tpl_vars["user_id"]){
	header("Location:".runFunc('encrypt_url',array('action=shop&method=myCart')));
	exit();
}
if ($this->_tpl_vars["method"]=='submitOrder'){ 
	
	$current_user_id = $this->_tpl_vars["user_id"];
	//$pay_link = 'action=shop&method=payment&orderID=';
	$cartStr = $this->_tpl_vars["IN"]["cartIdStr"];
	if($cartStr==""){	
		header("Location:".runFunc('encrypt_url',array('action=shop&method=myCart')));
		exit;
	}
	$orderAddressId = $this->_tpl_vars["IN"]["cartThreeAddressId"];
	$invoice = $this->_tpl_vars["IN"]["isInvoice"];
	$invoiceTitle = $this->_tpl_vars["IN"]["invoiceTitle"];
	$invoiceNum = $this->_tpl_vars["IN"]["invoiceNum"];
	$pending = $this->_tpl_vars["IN"]["pending"];
	$isRequest = $this->_tpl_vars["IN"]["isRequest"];
	
	if($this->_tpl_vars["IN"]["check_type"] == "group_buy"){		
		$group_buy = true;
	}else{	
		$group_buy = false;
	}	
	$order_id = runFunc("addCartToOrder",array($current_user_id,$orderAddressId,$cartStr,$invoice,$invoiceTitle,$invoiceNum,$group_buy,$pending,$isRequest));
	
	if($order_id){
		header("Location:index.php".runFunc('encrypt_url',array('action=shop&method=orderToPay&orderID='.$order_id)));
	}else{
		echo "失败!";
	}
}
?>