<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php
	 $userID = $this->_tpl_vars["name"];
	 $cartID = $this->_tpl_vars["cartID"];
	 $orderID = $this->_tpl_vars["orderID"];
	 $item_price = $this->_tpl_vars["item_price"];
	 $purchaseTotal = $this->_tpl_vars["purchaseTotal"];
	 $purchaseInfo = $this->_tpl_vars["purchaseInfo"];	 
	 $serviceRemark = $this->_tpl_vars["serviceRemark"];
	 $refundPrice = $this->_tpl_vars["refundPrice"];	 
	 $expressNum = $this->_tpl_vars["expressNum"];
	 $expressUrl = $this->_tpl_vars["expressUrl"];	 
	 $pay_back_message = $this->_tpl_vars["pay_back_message"];
	 $dataType = $this->_tpl_vars["dataType"];
	 if($cartID && $orderID){
		switch($dataType){
			case 'modify':
				 if($item_price && $item_price >0){
					$dataArray['modifyPrice'] = (float)$item_price;
					$dataArray['modifyPriceTime'] = time();
					$dataArray['modifyPriceStatus'] = 2;
					$cart = runFunc("getCartById",array($cartID));
					$dataArray['itemTotal']= $dataArray['modifyPrice'] * $cart[0]["ItemQTY"];
				 }
				 $dataArray['purchaseInfo'] = trim($purchaseInfo);
				 $dataArray['serviceRemark'] = trim($serviceRemark);
				 runFunc("updateItemInfo",array($cartID,$dataArray));
				 $result = runFunc("updateOrderTotal",array($orderID));					 				 
			break;
			case 'purchase':
				$dataArray['purchaseTotal'] = (float)$purchaseTotal;
				 runFunc("updateItemInfo",array($cartID,$dataArray));
				 $result = runFunc("updateOrderTotal",array($orderID));				
			break;			
			case 'refund':
				$dataArray['pay_back_money'] = (float)$refundPrice;
				$dataArray['pay_back_message'] = $pay_back_message;
				 runFunc("updateItemInfo",array($cartID,$dataArray));
				 $result = runFunc("updateOrderTotal",array($orderID));					
			break;
			case 'delivery':
				 $dataArray['expressNum'] = trim($expressNum);
				 $dataArray['expressUrl'] = trim($expressUrl);	
				 $result = runFunc("updateItemInfo",array($cartID,$dataArray));		
			break;						
		}
	 }else{
		 $result = false;
	}
	return $result;
?>
