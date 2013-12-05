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
		
	$cards = runFunc("getGiftCardByUserId",array($this->_tpl_vars["name"]));
		
	 $result_count = count($cards);

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

	 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	 $params = array (
				'action' => "sql",
				'return' => "lists",
				'query' => "SELECT * FROM cms_publish_order WHERE orderUser ={$this->_tpl_vars["name"]} AND orderStatus >=3 ORDER BY orderTime DESC",
	 );
	 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
	 $this->_tpl_vars['PageInfo'] = &$PageInfo;

	 ?>
			<div class="orderlistPay">
				<a name="here"></a>
				<h2 style="color: #700000">YOUR GIFT CARD</h2>
				<?php if(!empty($this->_tpl_vars['lists']["data"])){?>
				<table>
					<tr>
						<th width="140px">Password</th>
						<th width="260px" align="center">Status</th>
						<th width="180">Used By</th>
						<th>Using Time</th>
					</tr>					
				<?php
						for($start;$start<=$end;$start++){ 
							if($cards[$start]){?>
					<tr>
						<td><?php echo $cards[$start]["password"];?>
						</td>
						<td align="center"><?php if($cards[$start]["status"]==1){echo "Standby";}elseif($cards[$start]["status"]==2){echo "Used";}?>
						</td>
						<td align="center">	
						<?php if($cards[$start]["used_by"]):?>
						<a style="color:#5E97ED" href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$cards[$start]["used_by"]));?>">
						<?php $used_info = runFunc("getShareMemberInfoAllInOne",array($cards[$start]["used_by"]));?>
						<?php if($used_info[0]["real_name"]==1 and ($used_info[0]["first_name"]!="" or $used_info[0]["last_name"] !="")):?>
							<?php if($used_info[0]["first_name"]!=""){echo $used_info[0]["first_name"]."&nbsp;";} echo trim($used_info[0]["last_name"]);?>
						<?php elseif($used_info[0]["show_nick"]==1):?>
							<?php echo $used_info["0"]["staffName"];?>
						<?php else:?>
						<?php echo $used_info["0"]["staffNo"];?>
						<?php endif;?>
						</a>
						<?php else:?>
						
						--
						<?php endif;?>
						</td>
						<td align="center">
						<?php if($cards[$start]["used_time"]):?>
						<?php echo $cards[$start]["used_time"];?>
						<?php else:?>
						--
						<?php endif;?>
						</td>
					</tr>
					<?php  }
						}?>
				</table>
				<?php if(count($cards)>5):?>
				<div class="order_page fr">
				<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=gift_card&page='. $page_up));?>">prev</a>
				<span><?php echo $page;?>/<?php echo $page_count;?></span>
				<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=gift_card&page='. $page_down));?>">next</a>
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