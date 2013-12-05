<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
<script type="text/javascript" src="skin/jsfiles/phoneOrderList.js"></script>
<div class="cms_main_box">
<div class="content">
    <?php
		if($this->_tpl_vars["IN"]["page"]){
			$page=$this->_tpl_vars["IN"]["page"];
		}else{
			$page=1;
		}
		$rowsPerPage = 15;
		$pageStrat = $page * $rowsPerPage - $rowsPerPage;
		$searchOrderStatus = $this->_tpl_vars['IN']['searchOrderStatus'];
		$searchOrderPayment = $this->_tpl_vars['IN']['searchOrderPayment'];
		
		$querysql = "select * from cms_publish_phone_order as a left join cms_member_staff as b on a.userID = b.staffId WHERE a.orderStatus > 3";
		$sumQuerysql = "select SUM(rechargeTotal) as totalMoney,SUM(refundTotal) as totalRefundMoney from cms_publish_phone_order as a left join cms_member_staff as b on a.userID = b.staffId WHERE a.orderStatus > 4";

	?>
    <?php

		if($searchOrderStatus && $searchOrderStatus != 0){
			$querysql .= " and a.orderStatus = ".$searchOrderStatus;
			$sumQuerysql .= " and a.orderStatus = ".$searchOrderStatus;						
		}
		if($searchOrderPayment && $searchOrderPayment != 0){
			$querysql .= " and a.paymentType = '{$searchOrderPayment}'";
			$sumQuerysql .= " and a.paymentType = '{$searchOrderPayment}'";
		}		    
    ?>
	<?php
		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;
		 $params = array (
					'action' => "sql",
					'return' => "lists",
					'query' => $querysql." ORDER BY a.submitTime DESC limit {$pageStrat},{$rowsPerPage}",
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

    <div class="orderList">
        <div class="orderListNum" style="width:540px">
			Mobile Phone Charge List (<?php echo $result_count;?>)
        </div>
	<div class="select_box fl">
		<h2>点击选择筛选项</h2>
		<div class="selectas hide saveHover">
			<ul>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_rechargePhoneList&type=orders'));?>">All</a></li>            
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_rechargePhoneList&type=orders&searchOrderPayment=1'));?>">Paypal</a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_rechargePhoneList&type=orders&searchOrderPayment=2'));?>">WOWaccount</a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_rechargePhoneList&type=orders&searchOrderPayment=3'));?>">Visa or Master Card</a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_rechargePhoneList&type=orders&searchOrderPayment=4'));?>">China Unipay</a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_rechargePhoneList&type=orders&searchOrderStatus=19'));?>">Finished</a></li>
            <li><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_rechargePhoneList&type=orders&searchOrderStatus=17'));?>">Paid Back</a></li>                                     
          	</ul>
		</div>
	</div>
        <div style="float:left; margin:10px auto;width:240px; text-align:right;color:#333;font:normal 14px Arial, Helvetica, sans-serif;">
        	Transaction Total：  <span class="hong"> ¥ 
	        <?php if($searchOrderStatus == 17):?>
            	<?php echo number_format($this->_tpl_vars['sumMoney']['data'][0]['totalRefundMoney'], 2, '.', ',');?> 
            <?php else:?>
				<?php echo number_format(($this->_tpl_vars['sumMoney']['data'][0]['totalMoney'] - $this->_tpl_vars['sumMoney']['data'][0]['totalRefundMoney']), 2, '.', ',');?> 
            <?php endif;?>
            </span>
        </div>
<!-- 			<div class="she_list_box fr">
				<img src="../../skin/images/shezhi.png" />
				<div class="she_list hide">
					<ul>
                    <li><a onClick="batchSendMail('payment','batch');">Send Payment Reminder</a></li>
                    <li><a onClick="batchSendMail('confirmation','batch');">Send Confirmation Reminder</a></li>
                    <li><a onClick="batchSendMail('refund','batch');">Send Refund Notice</a></li>
                    <li><a onClick="batchDeleteOrder('trash','batch');">Move to Trash</a></li>
                  	</ul>
				</div>
			</div>-->
        <div class="clr"></div>
    	<div class="orderListCon">
        <?php if(!empty($this->_tpl_vars['lists']["data"])):?>
            <table width="1080px">
                <tr class="orderListTh" style="color:#8c8d8e;font:normal 14px;">
                    <td width="20" align="center"><input type="checkbox" name="allOrderSelect" id="allOrderSelect" value="0" /></td>
                    <td width="110" align="center">Order No</td>
                    <td width="180" align="center">Customer</td>
                    <td width="100" align="center">Submit</td>
                    <td width="100" align="center">Phone Num</td>
                    <td width="80" align="center">Amount</td>
                    <td width="100" align="center">Total</td>
                    <td width="100" align="center">Status</td>
                    <td width="100" align="center">OperationTime</td>
                    <td width="100" align="center">Operator</td>
                    <td align="center"></td>
                </tr>
              <?php foreach($this->_tpl_vars['lists']['data'] as $k => $v):?>

              	<tr id="<?php echo $v['id'];?>">
                    <td align="center" style="color:#909090;font-size:12px;"><input type="checkbox" name="orderSelect" class="orderSelect" value="<?php echo $v['id'];?>" /></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo $v['orderNo'];?></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo ($v['email']?$v['email']:$v['staffNo']);?></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo date("y-m-d H:i",$v['submitTime']);?></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo $v['phoneNum'];?></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo number_format($v['rechargeMoney'], 2, '.', ',');?></td>
                    <td align="center" style="color:#909090;font-size:12px;">
						<?php echo number_format($v['rechargeTotal'], 2, '.', ',');?><br />
						<?php echo $_GLOBAL['order_payment_'.$v['paymentType']];?></td>

                    <td align="center" class="nan" style="font-size:12px;">
                        <?php echo $_GLOBAL['order_info_'.$v['orderStatus']];?></br><?php echo $_GLOBAL['order_info_cn_'.$v['orderStatus']];?>
                    </td>
                    <td align="center" style="color:#909090;font-size:12px;">
                    	<?php if($v['rechargeTime']){
							echo date("y-m-d H:i",$v['rechargeTime']);
                        }else if($v['refundTime']){
							echo date("y-m-d H:i",$v['refundTime']);
						}?>
                    </td>
                    <td align="center" style="color:#909090;font-size:12px;">
                    	<a style="cursor:default;" title="<?php echo $v['operator'];?>" alt="<?php echo $v['operator'];?>">
							<?php echo runFunc('g_substr',array($v['operator'],'14'));?>
                        </a>
                    </td>
                    <td align="center" style="font-size:12px;">
                    	<?php if($v['orderStatus'] == 5):?>
                    		<a class="nan" style="cursor:pointer;" onClick="changePhoneOrderStatus('<?php echo $v['id'];?>','finish');">完成</a>&nbsp;&nbsp; 
                        	<a class="nan" style="cursor:pointer;" onClick="changePhoneOrderStatus('<?php echo $v['id'];?>','refund');">退款</a>
                        <?php endif;?>
                        
                    	<?php if($v['orderStatus'] == 19):?>
                    		<a class="hui">已完成</a>&nbsp;&nbsp; 
                        <?php endif;?> 
                    	<?php if($v['orderStatus'] == 17):?>
                    		<a class="hui">已退款</a>&nbsp;&nbsp; 
                        <?php endif;?>                                                  
                    </td>
                </tr>

				<tr style="border-bottom:2px solid #adaeab;height:10px;"><td colspan="11"></td></tr>
              <?php endforeach;?>
              </table>
              
     			<?php echo runFunc("phoneOrderPageNavi",array("cms","orders_rechargePhoneList",$result_count,$rowsPerPage,$page,$this->_tpl_vars['IN']['searchOrderStatus'],$this->_tpl_vars['IN']['searchOrderPayment']));?>
		<?php else: ?>
				<p style="padding:10px;text-align:center;margin-top:30px;">There no item in your recharge phone order list.</p>
		<?php endif;?>
        </div>
    </div>

</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>