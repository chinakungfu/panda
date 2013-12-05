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
<style type="text/css">
#bigresult{
	background: none repeat scroll 0 0 #DDDDDD;
    border: 1px solid #999999;
    display: none;
    text-align: center;
    width: 150px;
	height:100px;
	line-height:100px;
	vertical-align:middle;
}
</style>
<body>

<div class="box">

	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
website/lang.tpl
LNMV
	);
	include($inc_tpl_file);
	?>

	<div class="content">
    <?php	
		if($this->_tpl_vars["IN"]["page"]){
			$page=$this->_tpl_vars["IN"]["page"];
		}else{
			$page=1;
		}
		$rowsPerPage = 20;
		$pageStrat = $page * $rowsPerPage - $rowsPerPage;
		
		$querysql = "select * from cms_publish_phone_order WHERE userID ={$this->_tpl_vars["name"]} and orderStatus > 4";
		$sumQuerysql = "select SUM(rechargeTotal) as totalMoney,SUM(refundTotal) as totalRefundMoney from cms_publish_phone_order WHERE userID ={$this->_tpl_vars["name"]} and orderStatus > 4";
	?>   
	<?php
		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;
		 $params = array (
					'action' => "sql",
					'return' => "lists",
					'query' => $querysql." ORDER BY submitTime DESC limit {$pageStrat},{$rowsPerPage}",
		 );
		 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
		 $this->_tpl_vars['PageInfo'] = &$PageInfo;	

		 $params2 = array (
					'action' => "sql",
					'return' => "sumMoney",
					'query' => $sumQuerysql,
		 );

		 $this->_tpl_vars['sumMoney'] = CMS::CMS_sql($params2);
		 $this->_tpl_vars['PageInfo2'] = &$PageInfo2;	

		 $params3 = array (
					'action' => "sql",
					'return' => "totalList",
					'query' => $querysql,
		 );

		 $this->_tpl_vars['totalList'] = CMS::CMS_sql($params3);
		 $this->_tpl_vars['PageInfo3'] = &$PageInfo3;
		 
	 	$result_count = count($this->_tpl_vars['totalList']["data"]);
	 ?>
    <div class="bagNav">
    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Home</a> > <a>Payment</a>
    </div>
    <div class="bagTitle" style="border:none;">Mobile Phone Charge History</div>
        <div class="advSearch" id="advSearch">
            <table width="975px">                  
                <tr class="itemLineBg980">
                    <td colspan="4" align="right">
                    Transaction Total：   <font color="#a10000">¥ <?php echo $this->_tpl_vars['sumMoney']['data'][0]['totalMoney'];?></font>
                    </td>
                </tr>
            </table>  
        </div>          
     <div class="rechargeHistroy">
		<?php if(!empty($this->_tpl_vars['lists']["data"])):?>
				<table width="975px">
					<tr style="border-bottom:2px solid #ccc;height:40px;color:#333;">
						<td width="200px" align="center">Time</td>
						<td width="250px" align="center">Amount of Consumption (RMB)</td>
						<td width="200px" align="center">Payment Info</td>
                        <td align="center">Service Info</td>
					</tr>
			<?php foreach($this->_tpl_vars['lists']["data"] as $k => $v){ ?>
                        <tr style="border-bottom:1px solid #ddd;">
                            <td>
                                <?php echo date("y-m-d H:i",$v['submitTime']);?>
                            </td>
                            <td align="center">
                                <span>¥ <?php echo number_format($v["rechargeTotal"],'2','.',',');?></span>      	
                            </td>
                            <td align="center">
								<?php echo $_GLOBAL['order_payment_'.$v["paymentType"]];?>
                            </td>
                            <td align="center" style="overflow:hidden;">
                            <?php if($v["orderStatus"] == 5):?>
                            	<span class="nan">Waiting</span>
                            <?php elseif($v["orderStatus"] == 17):?>
                            	<span class="huang">Refund</span>
                            <?php elseif($v["orderStatus"] == 19):?>
                            	<span class="hui">Finish</span>                             
							<?php endif;?>
                            </td>                            
                        </tr>
				<?php }?>
				</table>
 				
     			<?php echo runFunc("phoneOrderPageNavi",array("account","phoneOrderHistroy",$result_count,$rowsPerPage,$page));?> 
		<?php else: ?>
				<p style="padding:10px;text-align:center;margin-top:30px;">There are no records in your recharge history.</p>
		<?php endif;?>
        </div>
        <div id="bigresult"></div>
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