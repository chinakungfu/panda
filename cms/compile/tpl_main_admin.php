<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
    <?php

		$querysql = "select * from cms_publish_cart where ItemStatus != 'Delete'";

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

		 $cartID = $v['cartID'];
		 $itemPrice = $v['itemPrice'];
		 $ItemQTY = $v['ItemQTY'];
		 $itemTotal = $v['itemTotal'];
		 if(!$itemTotal){
			 $newItemTotal = (float)($ItemQTY * $itemPrice);
				 $querysql3 = "update cms_publish_cart set itemTotal = '{$newItemTotal}' where cartID = '{$cartID}'";
				 
				 global $params3;
				 $params3 = array (
							'action' => "sql",
							'return' => "lists3",
							'query' => $querysql3,
				 );
				 $this->_tpl_vars['lists3'] = CMS::CMS_sql($params3); 			 
			 
		}
	 
	}
echo 'OK';