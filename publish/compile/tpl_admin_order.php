<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML>
<html>
	<head>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>

		
	</head>
	<body>
	    
		<div class="box">
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

			<?php if ($this->_tpl_vars["userInfo"]["0"]["groupName"]!='administrator'){?>
				<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login'));?>'</script>	
			<?php } ?>
			
			
			<div class="content">
			
			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "orderList",
	'query' => "SELECT * FROM cms_publish_order WHERE orderStatus ='3' ORDER BY orderTime DESC",
 ); 

$this->_tpl_vars['orderList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
			
			<div class="orderlistPay">			
				
				<table>
					<tr>
						<th width="140px">&nbsp;</th><th width="260px" align="center">Submit time</th><th width="180">Status</th><th>&nbsp;</th> 
					</tr>
					
					<?php if(!empty($this->_tpl_vars["orderList"]["data"])){ 
 foreach ($this->_tpl_vars["orderList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
						<tr>
							<?php $this->_tpl_vars["orderDate"]=date('Y-m-d H:i:s',$this->_tpl_vars["var"]["orderTime"]); ?>
							<?php $this->_tpl_vars["orderStatus"]=runFunc('getOrderStatus',array($this->_tpl_vars["var"]["orderStatus"])); ?>
							<td>No:<?php echo $this->_tpl_vars["var"]["OrderNo"];?></td><td align="center"><?php echo $this->_tpl_vars["orderDate"];?></td><td align="center"><?php echo $this->_tpl_vars["orderStatus"];?></td>
							<td class="orderlistPayBtn"><a href="index.php<?php echo runFunc('encrypt_url',array('action=admin&method=orderDetail&orderID=' . $this->_tpl_vars["var"]["orderID"]));?>">View details</a><br />
							
						</tr>
					<?php  }
} ?>
				</table>

			</div>
		</div>
			
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

		</div>
	</body>
</html>