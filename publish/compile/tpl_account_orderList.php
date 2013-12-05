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
<script type="text/javascript" src="/publish/skin/jsfiles/datepicker/WdatePicker.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/accountOrderList.js"></script>
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
		if($this->_tpl_vars['IN']['fastOrderStatus'] == 32){
			$querysql = "select * from cms_publish_order WHERE orderUser ={$this->_tpl_vars["name"]} and orderStatus NOT IN(22,23,30,31)";
			$sumQuerysql = "select SUM(totalAmount) as totalMoney,SUM(refundAmount) as totalRefundMoney from cms_publish_order WHERE orderUser = {$this->_tpl_vars["name"]} and orderStatus NOT IN(22,23,30,31)";
		}else{
			$querysql = "select * from cms_publish_order WHERE orderUser ={$this->_tpl_vars["name"]} and orderStatus NOT IN(22,23,31,32)";
			$sumQuerysql = "select SUM(totalAmount) as totalMoney,SUM(refundAmount) as totalRefundMoney from cms_publish_order WHERE orderUser = {$this->_tpl_vars["name"]} and orderStatus NOT IN(22,23,30,31,32) and payment > 0";			
		}
		//normal模式
		if($this->_tpl_vars['IN']['searchType'] == 'normal'){
			switch($this->_tpl_vars['IN']['searchMode']){
				case 1:
					$querysql = $querysql;
					$sumQuerysql = $sumQuerysql;
					break;
				case 2:
					$querysql .= " and orderTime_n > DATE_ADD(NOW(), INTERVAL -3 MONTH)";
					$sumQuerysql .= " and orderTime_n > DATE_ADD(NOW(), INTERVAL -3 MONTH)";
					break;
			}
		//adv模式
		}else if($this->_tpl_vars['IN']['searchType'] == 'adv'){
			$fromTime = $this->_tpl_vars['IN']['fromTime'];
			$endTime = $this->_tpl_vars['IN']['endTime'];
			$searchOrderNo = trim($this->_tpl_vars['IN']['searchOrderNo']);
			$searchOrderStatus = $this->_tpl_vars['IN']['searchOrderStatus'];
			$searchServiceStatus = $this->_tpl_vars['IN']['searchServiceStatus'];

			if($searchOrderNo || ($searchOrderStatus && $searchOrderStatus != 0) || ($searchServiceStatus && $searchServiceStatus != 0) || ($fromTime && $endTime)){
				if($searchOrderNo){
					$querysql .= " and (orderNo LIKE '%".$searchOrderNo."%' or orderName LIKE '%".$searchOrderNo."%')";
					$sumQuerysql .= " and (orderNo LIKE '%".$searchOrderNo."%' or orderName LIKE '%".$searchOrderNo."%')";
				}
				if($searchOrderStatus && $searchOrderStatus != 0){
					if($searchOrderStatus == 3){
						$querysql .= " and a.pending = 1";
						$sumQuerysql .= " and a.pending = 1";
					}else{
						$querysql .= " and a.orderStatus = ".$searchOrderStatus;
						$sumQuerysql .= " and a.orderStatus = ".$searchOrderStatus;						
					}
				}
				if($searchServiceStatus && $searchServiceStatus != 0){
					if($searchServiceStatus == '14'){ //退货
						$querysql .= " and Returned > 0";
						$sumQuerysql .= " and Returned > 0";
					}else if($searchServiceStatus == '16'){	//退款
						$querysql .= " and order_return > 0";
						$sumQuerysql .= " and order_return > 0";
					}
				}
				if($fromTime && $endTime){
					$fromTime = $this->_tpl_vars['IN']['fromTime']." 00:00:00";
					$endTime = $this->_tpl_vars['IN']['endTime']." 23:59:59";
					if(strtotime($fromTime) < strtotime($endTime)){
						$querysql .= " and orderTime_n between '".$fromTime ."' and '".$endTime."'";
						$sumQuerysql .= " and orderTime_n between '".$fromTime ."' and '".$endTime."'";
					}
				}
			}else{
				$this->_tpl_vars['IN']['fastOrderStatus'] == 100;
				$querysql = $querysql;
				$sumQuerysql = $sumQuerysql;
			}
		//fast模式
		}else if($this->_tpl_vars['IN']['searchType'] == 'fast'){
			switch($this->_tpl_vars['IN']['fastOrderStatus']){
				case 3: //Pending
					$querysql .= " and orderStatus = 4 and pending = 1";
					$sumQuerysql .= " and orderStatus = 4 and pending = 1";
					break;
				case 4://Unpaid
					$querysql .= " and orderStatus = 4";
					$sumQuerysql .= " and orderStatus = 4";
					break;
				case 5: //Paid
					$querysql .= " and (orderStatus = 5 or orderStatus = 6 or orderStatus = 7)";
					$sumQuerysql .= " and (orderStatus = 5 or orderStatus = 6 or orderStatus = 7)";
					break;
				case 10://On the way
					$querysql .= " and orderStatus = 10";
					$sumQuerysql .= " and orderStatus = 10";
					break;
				case 11: //Shipped
					$querysql .= " and orderStatus = 11";
					$sumQuerysql .= " and orderStatus = 11";
					break;
				case 15://Returned
					$querysql .= " and (Returned > 0 or replacement > 0)";
					$sumQuerysql .= " and (Returned > 0 or replacement > 0)";
					break;
				case 17: //Refounded
					$querysql .= " and order_return > 1";
					$sumQuerysql .= " and order_return > 1";
					break;
				case 19://Finished
					$querysql .= " and orderStatus = 19";
					$sumQuerysql .= " and orderStatus = 19";
					break;
				case 21://Closed
					$querysql .= " and orderStatus = 21";
					$sumQuerysql .= " and orderStatus = 21";
					break;
				case 30://Closed
					$querysql .= " and orderStatus = 30";
					$sumQuerysql .= " and orderStatus = 30";
					break;
				case 32://Closed
					$querysql .= " and orderStatus = 32";
					$sumQuerysql .= " and orderStatus = 32";
					break;											
				case 100://all
					$querysql = $querysql;
					$sumQuerysql = $sumQuerysql;
					break;
			}

		}else{
			$this->_tpl_vars['IN']['searchType'] = 'normal';
			$this->_tpl_vars['IN']['fastOrderStatus'] == 100;
			$querysql = $querysql;
			$sumQuerysql = $sumQuerysql;
		}
	?>
	<?php
		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;
		 $params = array (
					'action' => "sql",
					'return' => "lists",
					'query' => $querysql." ORDER BY orderTime DESC limit {$pageStrat},{$rowsPerPage}",
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
		 //各种订单数量
		 $MyOrdersCount = runFunc("getMyOrdersCount",array($this->_tpl_vars["name"]));
		 $PendingCount = runFunc("getMyOrdersPendingCount",array($this->_tpl_vars["name"]));
		 $UnpaidCount = runFunc("getMyOrdersUnpaidCount",array($this->_tpl_vars["name"]));
		 $PaidCount = runFunc("getMyOrdersPaidCount",array($this->_tpl_vars["name"]));
		 $OnthewayCount = runFunc("getMyOrdersOnthewayCount",array($this->_tpl_vars["name"]));
		 $ShippedCount = runFunc("getMyOrdersShippedCount",array($this->_tpl_vars["name"]));
		 $ReturnedCount = runFunc("getMyOrdersReturnedCount",array($this->_tpl_vars["name"]));
		 $RefoundedCount = runFunc("getMyOrdersRefoundedCount",array($this->_tpl_vars["name"]));
		 $FinishedCount = runFunc("getMyOrdersFinishedCount",array($this->_tpl_vars["name"]));
		 $ClosedCount = runFunc("getMyOrdersClosedCount",array($this->_tpl_vars["name"]));
		 $CanceledCount = runFunc("getMyOrdersCancelCount",array($this->_tpl_vars["name"]));
	 ?>

    <div class="bagNav">
    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Home</a> > <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderList'));?>">Orders</a>
    </div>
    <div class="bagTitle">
    	Order History <span id="bagItemTatal" class="smallNum">(<b><?php echo $MyOrdersCount[0]["count"];?></b>)</span>
        <div style="color:#adaeab;font:normal 12px Arial, Helvetica, sans-serif;width:976px;margin:0 auto;">
            Additional payments status may show when needed (see: <a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Globle Service</a> & <span class="nan">Additional Payments</span> )
        </div>
    </div>
	<div id="result"></div>

        <div class="orderAdvSearch" id="orderAdvSearch">
        	<form name="fastSearch_form" id="fastSearch_form" action="index.php" method="post">
                <div class="orderAdvSearchNav">
                    <ul>
                        <li statusValue="100" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '100' || !$this->_tpl_vars['IN']['fastOrderStatus']):?>nan<?php endif;?>">All</li>
                        <li statusValue="3" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '3'):?>nan<?php endif;?>">Pending<br><span>(<?php echo $PendingCount[0]["count"];?>)</span></li>
                        <li statusValue="4" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '4'):?>nan<?php endif;?>">Unpaid<br><span>(<?php echo $UnpaidCount[0]["count"];?>)</span></li>
                        <li statusValue="5" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '5'):?>nan<?php endif;?>">Paid<br><span>(<?php echo $PaidCount[0]["count"];?>)</span></li>
                        <li statusValue="10" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '10'):?>nan<?php endif;?>">On the way<br><span>(<?php echo $OnthewayCount[0]["count"];?>)</span></li>
                        <li statusValue="11" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '11'):?>nan<?php endif;?>">Shipped<br><span>(<?php echo $ShippedCount[0]["count"];?>)</span></li>
                        <li statusValue="15" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '15'):?>nan<?php endif;?>">Returned<br><span>(<?php echo $ReturnedCount[0]["count"];?>)</span></li>
                        <li statusValue="17" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '17'):?>nan<?php endif;?>">Refunded<br><span>(<?php echo $RefoundedCount[0]["count"];?>)</span></li>
                        <li statusValue="19" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '19'):?>nan<?php endif;?>">Finished<br><span>(<?php echo $FinishedCount[0]["count"];?>)</span></li>
                        <li statusValue="21" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '21'):?>nan<?php endif;?>">Closed<br><span>(<?php echo $ClosedCount[0]["count"];?>)</span></li>
                        <li statusValue="30" class="<?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '30'):?>nan<?php endif;?>">Canceled<br><span>(<?php echo $CanceledCount[0]["count"];?>)</span></li>
                        <li statusValue="32" style="float:right;"><img src="/skin/images/trash.png"></li>
                    </ul>
                </div>
            	<input type="hidden" name="fastOrderStatus" id="fastOrderStatus" value="<?php if($this->_tpl_vars['IN']['fastOrderStatus']): echo $this->_tpl_vars['IN']['fastOrderStatus'];?><?php else:?>100<?php endif;?>" />
                <input type="hidden" name="searchType" value="fast"/>
                <input type="hidden" name="method" value="orderList"/>
                <input type="hidden" name="action" value="account"/>
            </form>
            <div class="clb"></div>
            	<form name="advSearch_form" id="advSearch_form" action="index.php" method="post">
            	<table width="976px">
                    <tr>
                    	<td width="135px"></td>
                        <td width="180px">Order No or Order Name:</td>
                        <td width="350px"><input type="text" name="searchOrderNo" value="<?php if($this->_tpl_vars['IN']['searchOrderNo']){echo $this->_tpl_vars['IN']['searchOrderNo'];}?>" style="width:340px;" /></td>
                        <td>
                        	<a class="search_submit" id="search_submit">Search</a>
                        	<span class="searchClear" id="searchClear">clear</span>
                        </td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td>Transaction time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From</td>
                        <td>
                        	<input type="text" onClick="WdatePicker({lang:'en'})" style="width:130px;" name="fromTime" value="<?php echo $this->_tpl_vars['IN']['fromTime'];?>" />
                            <span style="margin:0 28px;">To</span>
                        	<input type="text" onClick="WdatePicker({lang:'en'})" style="width:130px;" name="endTime"  value="<?php echo $this->_tpl_vars['IN']['endTime'];?>"/></td>
                        <td></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td>Transaction Status:</td>
                        <td>
                    <select name="searchOrderStatus" id="searchOrderStatus" style="width:130px;">
                        <option value="0" <?php if(!$this->_tpl_vars['IN']['searchOrderStatus']):?>selected<?php endif;?>>All</option>
                        <option value="3" <?php if($this->_tpl_vars['IN']['searchOrderStatus'] == '3'):?>selected<?php endif;?>>Pending</option>
                        <option value="4" <?php if($this->_tpl_vars['IN']['searchOrderStatus'] == '4'):?>selected<?php endif;?>>Unpaid</option>
                        <option value="5" <?php if($this->_tpl_vars['IN']['searchOrderStatus'] == '5'):?>selected<?php endif;?>>Paid</option>

                        <option value="8" <?php if($this->_tpl_vars['IN']['searchOrderStatus'] == '8'):?>selected<?php endif;?>>Need pay additional</option>
                        <option value="18" <?php if($this->_tpl_vars['IN']['searchOrderStatus'] == '18'):?>selected<?php endif;?>>Waiting Confirmation</option>
                        <option value="6" <?php if($this->_tpl_vars['IN']['searchOrderStatus'] == '6'):?>selected<?php endif;?>>Finished</option>
                    </select>
                    <span style="margin:0 15px;">Service:</span>
                    <select name="searchServiceStatus" id="searchServiceStatus" style="width:130px;">
                        <option value="0" <?php if(!$this->_tpl_vars['IN']['searchServiceStatus']):?>selected<?php endif;?>>All</option>
                        <option value="17" <?php if($this->_tpl_vars['IN']['searchServiceStatus'] == '17'):?>selected<?php endif;?>>Refunded</option>
                        <option value="14" <?php if($this->_tpl_vars['IN']['searchServiceStatus'] == '14'):?>selected<?php endif;?>>Returned</option>
                    </select>
                		</td>
                        <td></td>
                    </tr>
                    <tr style="border-bottom:2px solid #adaeab;height:30px;">
                    	<td colspan="4" align="right">
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="searchType" value="adv"/>
                <input type="hidden" name="method" value="orderList"/>
                <input type="hidden" name="action" value="account"/>
            	</form>
        </div>

    <div class="orderList">
        <div class="orderListNum">
			All Orders (<?php echo $result_count;?>)
        </div>
        <div style="float:left; margin:10px auto;width:487px; text-align:right;color:#333;font:normal 14px Arial, Helvetica, sans-serif;">
        	Transaction Total：  <span class="hong"> ¥ <?php echo number_format($this->_tpl_vars['sumMoney']['data'][0]['totalMoney'], 2, '.', ',');?> </span>
        </div>

        <div class="clb"></div>
    	<div class="orderListCon">
        <?php if(!empty($this->_tpl_vars['lists']["data"])):?>
            <table width="976px">
                <tr class="orderListTh">
                    <td width="20" align="center"><input type="checkbox" name="allOrderSelect" id="allOrderSelect" value="0" /></td>
                    <td width="150" align="center">Order No</td>
                    <td width="288" align="center">Order Name</td>
                    <td width="150" align="center">Submit</td>
                    <td width="10" align="center"></td>
                    <td width="150" align="center">Paid</td>
                    <td width="110"></td>
                    <td width="97"></td>
                </tr>
              <?php foreach($this->_tpl_vars['lists']['data'] as $k => $v):?>
              	<tr id="<?php echo $v['orderID'];?>">
                <td colspan="8">
                    <table class="orderItemTable">
                        <tr style="height:30px;">
                            <td width="20" align="center"><input type="checkbox" name="orderSelect" value="<?php echo $v['orderID'];?>" /></td>
                            <td width="150" align="center">
                            	<a class="nan" style="font-size:12px;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderDetail&orderID='.$v['orderID']));?>"><?php echo $v['OrderNo'];?></a></td>
                            <td width="288" align="center">
                            
                            	<span style="cursor:pointer;" class="orderNameView nan<?php if(!$v['orderName']):?> hide<?php endif;?>"><?php echo $v['orderName'];?></span>
                        
                            	<input orderID="<?php echo $v['orderID'];?>" style="color:#777;width:265px; text-align:center;" type="text" name="orderName" class="orderName<?php if($v['orderName']):?> hide<?php endif;?>" defaultValue="Name this order" value="<?php echo $v['orderName']?$v['orderName']:"Name this order";?>" maxlength="36" />

                            </td>
                            <td width="150" align="center" style="color:#adaeab;font-size:12px;"><?php echo $v['orderTime_n'];?></td>
                            <td width="30" align="center"></td>
                            <td width="150" align="center" style="color:#adaeab;font-size:12px;"><?php echo $v['payTime'];?></td>
                            <td width="110"></td>
                            <td width="97"></td>
                        </tr>
                        <?php if($v['payment']):?>
                        <tr style="color:#adaeab;font-size:12px;">
                        	<td></td>
                        	<td></td>
                            <td></td>
                            <td></td>
                          	<td></td>
                        	<td><?php echo $_GLOBAL['order_payment_'.$v['payment']];?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php endif;?>
                        <tr height="20px" class="hui" style="font-size:12px;">
                        	<td></td>
                            <td valign="top"></td>
                            <td colspan="4" style="text-align:left;">
                            </td>
                            <td style="text-align:right;">Paid:</td>
                            <td style="text-align:right;">
                            <?php if($v['payment']):?>
                            ¥ <?php echo number_format(($v['totalAmount']+$v['Additional']),2,'.',',');?></td>
                            <?php endif;?>
                        </tr>
                        <tr height="20px" class="hui" style="font-size:12px;">
                        	<td></td>
                            <td valign="top"></td>
                            <td colspan="4" style="text-align:left;">
                            </td>
                            <td style="text-align:right;">Additional:</td>
                            <td style="text-align:right;"> ¥ <?php echo number_format($v['Additional'],2,'.',',');?></td>
                        </tr>
                        <tr height="20px" style="font-size:12px;">
                        	<td></td>
                            <td valign="top"></td>
                            <td colspan="4" style="text-align:left;">
                            </td>
                            <td style="text-align:right;" class="hui">Refund:</td>
                            <td style="text-align:right;" class="hong"> - ¥ <?php echo number_format($v['refundAmount'],2,'.',',');?></td>
                        </tr>                        
                        <tr height="30px">
                        	<td></td>
                            <td style="font-size:12px;" valign="top">Status</td>
                            <td colspan="4" style="text-align:left;">
                            	<?php if($v['pending'] == 1 && $v['orderStatus'] == 4): ?>
									<img src="../../skin/images/pending.png" />
                                <?php elseif(($v['pending'] == 0 || $v['pending'] == 2) && $v['orderStatus'] == 4):?>
                                	<img src="../../skin/images/waitingPayment.png" />
                                <?php elseif($v['orderStatus'] == 5 || $v['orderStatus'] == 6 || $v['orderStatus'] == 7 || $v['orderStatus'] == 8 || $v['orderStatus'] == 9):?>
                                	<img src="../../skin/images/inProgress.png" />
                                <?php elseif($v['orderStatus'] >= 10 && $v['orderStatus'] <= 17):?>
                                	<img src="../../skin/images/ontheway.png" />
								<?php elseif($v['orderStatus'] >= 18 && $v['orderStatus'] <= 21):?>
                                	<img src="../../skin/images/allShipped.png" />
                                <?php else:?>
                                	<img src="../../skin/images/inProgress.png" />
								<?php endif;?>
                            </td>
                            <td style="text-align:right;">Total</td>
                            <td style="text-align:right;" class="hong"> ¥ <?php echo number_format($v['totalAmount'],2,'.',',');?></td>
                        </tr>
                        <tr style="font-size:12px;">
                        	<td colspan="6"></td>
                        	<td colspan="2" align="right" style="text-align:right;">
                            	<?php if(($v['pending'] == 1) && ($v['orderStatus'] == 4)): ?>
                                		<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=newPayment&orderID='.$v['orderID']));?>" class="bghong orderItemBtn hand">Pay Now</a>
										<!--<span class="bghui orderItemBtn">Pay Now</span>-->
                                <?php elseif(($v['pending'] == 0 || $v['pending'] == 2) && $v['orderStatus'] == 4):?>
                                		<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=newPayment&orderID='.$v['orderID']));?>" class="bghong orderItemBtn hand">Pay Now</a>
                                <?php elseif($v['orderStatus'] == 8):?>
                                		<a href="javascript:void(0);" class="bghuang orderItemBtn hand">Pay Additional</a>
                                <?php elseif($v['orderStatus'] == 18):?>

										<a onClick="confirmOrder(this,'<?php echo $v['orderID'];?>','confirm','one');" class="bgnan orderItemBtn hand">Confirm Receipt</a>
                                <?php elseif($v['orderStatus'] == 11):?>
										<a onClick="confirmOrder(this,'<?php echo $v['orderID'];?>','confirm','one');" class="bgnan orderItemBtn hand">Confirm Receipt</a>
                                <?php elseif($v['orderStatus'] == 19):?>
										<div class="bghui confirmed">Finished</div>                       
                                <?php elseif($v['orderStatus'] == 20):?>
                                	    <span class="orderItemBtn" style="color:#adaeab;text-align:right;">Finished</span>
                                <?php elseif($v['orderStatus'] == 21):?>
                                	    <span class="orderItemBtn" style="color:#adaeab;text-align:right;">closed</span>
                                <?php elseif($v['orderStatus'] == 30):?>
                                	    <span class="orderItemBtn" style="color:#adaeab;text-align:right;">Canceled</span>
								<?php endif;?>
                            </td>
                        </tr>
                        <tr style="border-bottom:2px solid #adaeab;height:30px;">
                        <td colspan="8" style="text-align:right;">
                        	<?php if($v['orderStatus'] == 4):?>
                        	<span class="nan" style="cursor:pointer;" onClick="deleteOrder('<?php echo $v['orderID'];?>','cancel','one');">Cancel Order</span>
                            <?php endif;?>                          
                            <?php if($v['orderStatus'] < 5 || $v['orderStatus'] == 19 || $v['orderStatus'] == 21 || $v['orderStatus'] == 30):?>
                            <span class="nan" style="margin-left:20px;cursor:pointer;" onClick="deleteOrder('<?php echo $v['orderID'];?>','trash','one');">Move to Trash</span>
                            <?php endif;?>
                            <?php if($v['orderStatus'] == 4 || $v['orderStatus'] == 30 || $v['orderStatus'] == 19 || $v['orderStatus'] == 21):?>
                            <span class="nan" style="cursor:pointer;margin-left:20px;" onClick="deleteOrder('<?php echo $v['orderID'];?>','delete','one');">Delete</span>						<?php endif;?>
                        </td></tr>
                    </table>
                </td>
                </tr>
              <?php endforeach;?>
              </table>
     			<?php echo runFunc("orderPageNavi",array("account","orderList",$result_count,$rowsPerPage,$page,$this->_tpl_vars['IN']['searchType'],$this->_tpl_vars['IN']['searchMode'],$this->_tpl_vars['IN']['fromTime'],$this->_tpl_vars['IN']['endTime'],$this->_tpl_vars['IN']['searchOrderNo'],$this->_tpl_vars['IN']['searchOrderStatus'],$this->_tpl_vars['IN']['searchServiceStatus'],$this->_tpl_vars['IN']['fastOrderStatus']));?>
		<?php else: ?>
				<p style="padding:10px;text-align:center;margin-top:30px;">There no item in your order history.</p>
		<?php endif;?>
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
    <span id="back-top" class="gotoup" style="display: none; position: fixed; bottom: 50px; top: auto;"></span>
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