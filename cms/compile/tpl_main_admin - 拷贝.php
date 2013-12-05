<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
    <?php

		$querysql = "select * from cms_publish_order_yuanshi";

		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params;
		 $params = array (
					'action' => "sql",
					'return' => "lists",
					'query' => $querysql,
		 );
		 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
		 $this->_tpl_vars['PageInfo'] = &$PageInfo;
		
		//print_r($this->_tpl_vars['lists']);
	 foreach($this->_tpl_vars['lists']['data'] as $k => $v){
		 $orderUser = $v['orderUser'];
		 $orderID = $v['orderID'];
		 $email = $v['email'];
		 $address1 = $v['address1'];
		 $address2 = $v['address2'];
		 $city = $v['city'];
		 //echo $orderUser.$fullName."</br>";
		 $querysql2 = "select * from cms_publish_address where userId = '{$orderUser}' and email = '{$email}' and city = '{$city}'";		 
/*		if($address2){
		 $querysql2 = "select * from cms_publish_address where userId = '{$orderUser}' and fullName = '{$fullName}' and address1 = '{$address1}' and address2 = '{$address2}'";
		}else{
		 $querysql2 = "select * from cms_publish_address where userId = '{$orderUser}' and fullName = '{$fullName}' and address1 = '{$address1}'";			
		}*/
		//echo $querysql2;
		 global $params2;
		 $params2 = array (
					'action' => "sql",
					'return' => "lists2",
					'query' => $querysql2,
		 );
		 $this->_tpl_vars['lists2'] = CMS::CMS_sql($params2);
		 $orderAddress = $this->_tpl_vars['lists2']['data'][0]['addressId'];
		 if($orderAddress){
			 $querysql3 = "update cms_publish_order set orderAddress = '{$orderAddress}' where orderID = '{$orderID}'";
		}
		 global $params3;
		 $params3 = array (
					'action' => "sql",
					'return' => "lists3",
					'query' => $querysql3,
		 );
		 $this->_tpl_vars['lists3'] = CMS::CMS_sql($params3);
		 
	}
echo 'OK';