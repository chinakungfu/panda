<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php $settings =  runFunc("getGlobalSetting");?>
<?php if ($this->_tpl_vars["name"]){?>
<?php			
		$orderID = $this->_tpl_vars["IN"]["orderID"];
		$cartID = $this->_tpl_vars["IN"]["cartID"];

		$orderInfo = runFunc("getOrderCartStrByOrderId",array($orderID));
		$cartStr = $orderInfo["cartIDstr"];
		$orderItem = explode(',',$cartStr);

		if(count($orderItem) > 1){
			$newOrderItem = "";
			for($i=0;$i<count($orderItem);$i++){
				if(!$newOrderItem){
					if($orderItem[$i] != $cartID){
						$newOrderItem .= $orderItem[$i];
					}					
				}else{
					if($orderItem[$i] != $cartID){
						$newOrderItem .= ",".$orderItem[$i];
					}					
				}

			}

			//更新总价
			$amount = runFunc("makeOrderAmout",array($newOrderItem));
			$shopNum = runFunc("makeOrderFreight",array($newOrderItem));
			
			$freight = $shopNum*$settings[0]["freight"];//总运费
			$service_fee = $settings[0]["service_fee"]*$amount["amount"];//所有商品服务费
			
			if($orderInfo['invoice'] == 1){
				$tax = ($service_fee + $amount["amount"] + $freight) * $settings[0]["tax_rate"];
			}else{
				$tax = 0;
			}
			$dataArray["cartIDstr"] = $newOrderItem;
			$dataArray["service_fee"] = $service_fee;		//总服务费
			$dataArray["order_amount"] = $amount["amount"];	//商品总价
			$dataArray["order_freight"] = $freight;			//总运费
			$dataArray["tax"] = $tax;						//税价	
			$dataArray["totalAmount"] = $amount["amount"]+ $freight + $dataArray["service_fee"] + $dataArray["tax"];	//总总价钱		
			
			$sql = '';
			foreach ($dataArray as $key => $var)
			{
				$sql .= "$key =:$key,";
			}
			$sql = substr($sql,0,-1);
			$sql = "update cms_publish_order set $sql where orderID = {$orderID} and orderUser = {$this->_tpl_vars["name"]}";
			
			$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

			if($result){
				header("Location: ".runFunc('encrypt_url',array('action=account&method=orderDetail&orderID='.$orderID)));
			}else{
				echo "error";
			}			
		
	
	}else{
			$dataArray['orderStatus'] = 31;
			$dataArray['deleteTime'] = time();
			$sql = '';
			foreach ($dataArray as $key => $var)
			{
				$sql .= "$key =:$key,";
			}
			$sql = substr($sql,0,-1);
			$sql = "update cms_publish_order set $sql where orderID = {$orderID} and orderUser = {$this->_tpl_vars["name"]}";
			$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);	
						
			if($result){
				header("Location: ".runFunc('encrypt_url',array('action=website&method=account')));
			}else{
				echo "error";
			}
					
		}


?>
<?php } ?>