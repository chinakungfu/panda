<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php
	$orderID = $this->_tpl_vars["IN"]["orderID"];
	$orderName = $this->_tpl_vars["IN"]["orderName"];
	if ($this->_tpl_vars["name"] && $orderID && $orderName){
		$orderArray['orderName'] = $orderName;
		$updatedata=runFunc('updateOrderStatus',array($orderID,$orderArray));
		if($updatedata){
			$result['status'] = 1;
		}else{
			$result['status'] = -2;
		}
	}else{
		$result['status'] = -1;
	}
	echo json_encode($result);