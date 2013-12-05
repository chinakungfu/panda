<?php import('core.util.RunFunc'); 
if($this->_tpl_vars["IN"]["tab"] == 1){
	
	$orders = runFunc('getOrderList',array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["IN"]["page"],$this->_tpl_vars["IN"]["size"]));
	

foreach($orders as $order){
	$good = runFunc('getOrderListGoods',array($order["cartIDstr"]));
	$json[] = (object)$good;
}
}elseif($this->_tpl_vars["IN"]["tab"] == 2){
	
	$json = runFunc('getShareList',array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["IN"]["page"],$this->_tpl_vars["IN"]["size"]));
}elseif($this->_tpl_vars["IN"]["tab"] == 3){
	$result = runFunc('getUrlSearch',array($this->_tpl_vars["IN"]["url"],$this->_tpl_vars["IN"]["id"]));
	
	if($result == "-1"){
		
		return false;
	}
	$json = (object)$result;
}

 echo json_encode($json);
?>
