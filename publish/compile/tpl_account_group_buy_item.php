<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
<!DOCTYPE HTML>
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
<body onload="window.location.hash = 'here'">

	<div class="box">

	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);?>

		<div class="content">

		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_body.tpl
LNMV
		);
		include($inc_tpl_file);
		?>
		<?php
		if($this->_tpl_vars["IN"]["page"]){
		$page=$this->_tpl_vars["IN"]["page"];
		}else{
			$page=1;
		}
		
			 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	 $params = array (
				'action' => "sql",
				'return' => "lists",
				'query' => "SELECT * FROM cms_publish_order WHERE orderUser ={$this->_tpl_vars["name"]} AND orderStatus >=3 and orderStatus<9 and group_buy = 1 ORDER BY orderTime DESC",
	 );
	 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
	 $this->_tpl_vars['PageInfo'] = &$PageInfo;
	 
	 $result_count = count($this->_tpl_vars['lists']["data"]);

	 $rowsPerPage = 5;

	 $start = $rowsPerPage * ($page - 1);

	 $end = $start + $rowsPerPage - 1;

	 $page_down=$page+1;
	 $page_up=$page-1;
	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}

	$page_down=$page+1;
	$page_up=$page-1;
	if($page_up <= 0){
		$page_up=1;
	}
	if($page_down >= $page_count){
		$page_down=$page_count;
	}



	 ?>
			<div class="orderlistPay">
				<a name="here"></a>
				<h2 style="color: #700000">YOUR GROUP BUY ORDERS</h2>
				<?php if(!empty($this->_tpl_vars['lists']["data"])){?>
				<table style="margin-top: 20px;">
				
				<?php
						for($start;$start<=$end;$start++){ 
							if($this->_tpl_vars['lists']["data"][$start]){?>
					<tr>
						<td style="height:1px;border-top:1px solid #777777;border-bottom:none;" colspan=4></td>
					</tr>
					<tr>
					<?php $this->_tpl_vars["orderDate"]=date('Y-m-d H:i:s',$this->_tpl_vars['lists']["data"][$start]["orderTime"]); ?>
					<?php $this->_tpl_vars["orderStatus"]=runFunc('getOrderStatus',array($this->_tpl_vars['lists']["data"][$start]["orderStatus"])); ?>
						<td style="font-weight:bold">No:<?php echo $this->_tpl_vars['lists']["data"][$start]["OrderNo"];?>
						</td>
						<td style="font-weight:bold" align="center">Submit time: <?php echo $this->_tpl_vars["orderDate"];?>
						</td>
						<td style="font-weight:bold" align="center"><?php echo $this->_tpl_vars["orderStatus"];?></td>
						<td class="orderlistPayBtn">
					<?php if($this->_tpl_vars['lists']["data"][$start]["totalAmount"]>0):?>
						<a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=orderDetail&orderID=' . $this->_tpl_vars['lists']["data"][$start]["orderID"]));?>">View order</a>
						<br /> 
						
						<?php if($this->_tpl_vars['lists']["data"][$start]["orderStatus"]=='4'){?>
						<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=payment&orderID=' . $this->_tpl_vars['lists']["data"][$start]["orderID"]));?>" class="orderlistPayBtnLink">Pay</a> 
						<?php } ?>
						<?php endif;?>
						</td>
					</tr>
					<tr>
						<td style="border:0" colspan="4">
							<?php $group_buy_items = runFunc("adminGetGroupBuyOrderItems",array($this->_tpl_vars['lists']["data"][$start]["cartIDstr"]));?>
								<table class="group_order_item_table">
							<?php foreach($group_buy_items as $group_buy_item):?>
							<?php $group_goods = runFunc("getMemberGroupBuyItem",array($group_buy_item["id"]));?>
						<?php 
						$_GLOBAL['item_status_1'] = "Wating for package";
$_GLOBAL['item_status_2'] = "Wating for package";
$_GLOBAL['item_status_3'] = "Package";
$_GLOBAL['item_status_4'] = "Completed";
						
						?>
								<tr>
									<td width="50%" ><?php echo $group_buy_item["item_name"];?></td>
									<td width="15%"><?php if($group_buy_item["sell_way"]==1){echo "service fee ".((1-$group_buy_item["price_rate"])*100)."% off";}else{echo "price ".((1-$group_buy_item["price_rate"])*100)."% off";}?></td>
									<td style="text-align:center" width="20%">
									<?php $purchase_count = runFunc("getGroupPurchasedCount",array($group_buy_item["id"]));?>
									<?php if($group_buy_item["group_buy_off"]==1):?>
									
									This deal is off
									<?php elseif($group_buy_item["group_size"]>$purchase_count[0]["count"] or $group_buy_item["start_time"]>date("Y-m-d")):?>
									Pending
									<?php else:?>
									<?php echo $_GLOBAL['item_status_'.$group_buy_item["order_item_status"]];?>
									<?php endif;?>
									</td>
									<td style="text-align:right" width="15%"><?php if($group_buy_item["order_item_status"]==3):?><a onClick="javascript:return confirm('Are you sure you get what you need?')" class="orderlistPayBtnLink" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=group_buy_item_confirm&cart_id='.$group_buy_item["cartID"].'&page='.$page));?>">Confirm</a><?php endif;?></td>
								</tr>
							
							<?php endforeach;?>
							</table>
						</td>
					</tr>
					<?php  }
						}?>
				</table>
				<?php if(count($this->_tpl_vars['lists']["data"])>5):?>
				<div class="order_page fr">
				<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=group_buy_item&page='. $page_up));?>">prev</a>
				<span><?php echo $page;?>/<?php echo $page_count;?></span>
				<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=group_buy_item&page='. $page_down));?>">next</a>
				</div>
				<?php endif;?>
				<?php	}else{ ?>
				<p style="padding:10px">There no item in your order history.	</p>
				<?php }?>	
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
		<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>