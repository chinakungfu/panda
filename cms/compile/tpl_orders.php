<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
<script type="text/javascript" src="/publish/skin/jsfiles/datepicker/WdatePicker.js"></script>
<script type="text/javascript" src="skin/jsfiles/orderList.js"></script>
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

		$sort = $this->_tpl_vars['IN']['sort'];
		if(!$sort){
			$sort = 'orderTime';
		}

		$querysql = "select *,b.email AS userEmail from cms_publish_order as a left join cms_member_staff as b on a.orderUser = b.staffId left join cms_publish_address as c on c.addressId = a.orderAddress WHERE a.orderStatus NOT IN(22,31,23,32)";
		$sumQuerysql = "select SUM(totalAmount) as totalMoney,SUM(refundAmount) as totalRefundMoney from cms_publish_order as a left join cms_member_staff as b on a.orderUser = b.staffId left join cms_publish_address as c on c.addressId = a.orderAddress WHERE a.orderStatus NOT IN(22,31,23,32) and a.payment > 0";

		//adv模式
		if($this->_tpl_vars['IN']['searchType'] == 'adv'){
			$fromTime = $this->_tpl_vars['IN']['fromTime'];
			$endTime = $this->_tpl_vars['IN']['endTime'];
			$submitFromTime = $this->_tpl_vars['IN']['submitFromTime'];
			$submitEndTime = $this->_tpl_vars['IN']['submitEndTime'];
			$searchOrderNo = trim($this->_tpl_vars['IN']['searchOrderNo']);
			$searchOrderLocation = trim($this->_tpl_vars['IN']['searchOrderLocation']);
			$searchOrderDepartment = trim($this->_tpl_vars['IN']['searchOrderDepartment']);
			$searchOrderOperator = trim($this->_tpl_vars['IN']['searchOrderOperator']);
			$searchOrderStatus = $this->_tpl_vars['IN']['searchOrderStatus'];
			$searchServiceStatus = $this->_tpl_vars['IN']['searchServiceStatus'];
			$searchOrderPayment = $this->_tpl_vars['IN']['searchOrderPayment'];
			//echo $fromTime."|||".$endTime."|||".$searchOrderNo."|||".$searchByInfo;
			//exit;
			if($searchOrderNo || $searchOrderLocation || $searchOrderOperator || ($searchOrderStatus && $searchOrderStatus != 0) || ($searchServiceStatus && $searchServiceStatus != 0) || ($searchOrderPayment && $searchOrderPayment != 0) || ($fromTime && $endTime) || ($submitFromTime && $submitEndTime)){
				if($searchOrderNo){
					$querysql .= " and (a.orderNo Like '%{$searchOrderNo}%' or b.staffName Like '%{$searchOrderNo}%' or b.email Like '%{$searchOrderNo}%' or a.orderName Like '%{$searchOrderNo}%')";
					$sumQuerysql .= " and (a.orderNo Like '%{$searchOrderNo}%' or b.staffName Like '%{$searchOrderNo}%' or b.email Like '%{$searchOrderNo}%' or a.orderName Like '%{$searchOrderNo}%')";
				}
				if($searchOrderLocation){
					$querysql .= " and (c.address1 Like '%{$searchOrderLocation}%' or c.address2 Like '%{$searchOrderLocation}%' or c.addressCN1 Like '%{$searchOrderLocation}%' or c.addressCN2 Like '%{$searchOrderLocation}%' or c.city Like '%{$searchOrderLocation}%' or c.cityCN Like '%{$searchOrderLocation}%' or c.province Like '%{$searchOrderLocation}%' or c.provinceCN Like '%{$searchOrderLocation}%' or c.country Like '%{$searchOrderLocation}%' or c.countryCN Like '%{$searchOrderLocation}%')";
					$sumQuerysql .= " and (c.address1 Like '%{$searchOrderLocation}%' or c.address2 Like '%{$searchOrderLocation}%' or c.addressCN1 Like '%{$searchOrderLocation}%' or c.addressCN2 Like '%{$searchOrderLocation}%' or c.city Like '%{$searchOrderLocation}%' or c.cityCN Like '%{$searchOrderLocation}%' or c.province Like '%{$searchOrderLocation}%' or c.provinceCN Like '%{$searchOrderLocation}%' or c.country Like '%{$searchOrderLocation}%' or c.countryCN Like '%{$searchOrderLocation}%')";
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
						$querysql .= " and a.Returned > 0";
						$sumQuerysql .= " and a.Returned > 0";
					}else if($searchServiceStatus == '16'){	//退款
						$querysql .= " and a.order_return > 0";
						$sumQuerysql .= " and a.order_return > 0";
					}
				}
				if($searchOrderPayment && $searchOrderPayment != 0){
					$querysql .= " and a.payment = '{$searchOrderPayment}'";
					$sumQuerysql .= " and a.payment = '{$searchOrderPayment}'";
				}

				if($submitFromTime && $submitEndTime){
					$submitFromTime = $this->_tpl_vars['IN']['submitFromTime']." 00:00:00";
					$submitEndTime = $this->_tpl_vars['IN']['submitEndTime']." 23:59:59";
					if(strtotime($submitFromTime) < strtotime($submitEndTime)){
						$querysql .= " and a.orderTime_n between '".$submitFromTime ."' and '".$submitEndTime."'";
						$sumQuerysql .= " and a.orderTime_n between '".$submitFromTime ."' and '".$submitEndTime."'";
					}
				}
				if($fromTime && $endTime){
					$fromTime = $this->_tpl_vars['IN']['fromTime']." 00:00:00";
					$endTime = $this->_tpl_vars['IN']['endTime']." 23:59:59";
					if(strtotime($fromTime) < strtotime($endTime)){
						$querysql .= " and a.payTime between '".$fromTime ."' and '".$endTime."'";
						$sumQuerysql .= " and a.payTime between '".$fromTime ."' and '".$endTime."'";
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
					$querysql .= " and orderStatus = 5";
					$sumQuerysql .= " and orderStatus = 5";
					$sort = 'payTime';
					break;
				case 6: //Verified
					$querysql .= " and orderStatus = 6";
					$sumQuerysql .= " and orderStatus = 6";
					break;
				case 7: //Purchased
					$querysql .= " and orderStatus = 7";
					$sumQuerysql .= " and orderStatus = 7";
					$sort = 'payTime';
					break;
				case 10://On the way
					$querysql .= " and orderStatus = 10";
					$sumQuerysql .= " and orderStatus = 10";
					$sort = 'payTime';
					break;
				case 11: //Shipped
					$querysql .= " and orderStatus = 11";
					$sumQuerysql .= " and orderStatus = 11";
					$sort = 'payTime';
					break;
				case 19: //Confirmed
					$querysql .= " and orderStatus = 19";
					$sumQuerysql .= " and orderStatus = 19";
					break;
				case 14: //Return
					$querysql .= " and (Returned = 1 or replacement = 1) and orderStatus < 19";
					$sumQuerysql .= " and (Returned = 1 or replacement = 1 and orderStatus < 19)";
					break;
				case 15://Returned
					$querysql .= " and (Returned = 1 or replacement = 1) and orderStatus = 19";
					$sumQuerysql .= " and (Returned = 1 or replacement = 1 and orderStatus = 19)";
					break;
				case 16://refound
					$querysql .= " and order_return = 1";
					$sumQuerysql .= " and order_return = 1";
					break;
				case 17: //paid pack
					$querysql .= " and order_return = 2";
					$sumQuerysql .= " and order_return = 2";
					break;
				case 30://cencel
					$querysql .= " and orderStatus = 30";
					$sumQuerysql .= " and orderStatus = 30";
					break;
				case 20://Finished
					$querysql .= " and orderStatus = 19";
					$sumQuerysql .= " and orderStatus = 19";
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
					'query' => $querysql." ORDER BY a.{$sort} DESC limit {$pageStrat},{$rowsPerPage}",
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
    <a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders'));?>">Orders</a> > <a>Orderlist</a>
    </div>
    <div class="bagTitle">
    	ORDERS <span class="smallNum">(<b id="bagItemTatal"><?php echo $result_count;?></b>)</span> <span id="allStatus" style="color:#5e97ed;font-size:14px;cursor:pointer;">View All</span>
    </div>
        <div class="orderAdvSearch" id="orderAdvSearch">
        	<form name="fastSearch_form" id="fastSearch_form" action="index.php" method="post">
                <div class="orderAdvSearchNav">
                    <ul>
                    <li statusValue="3" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '3'):?>nan<?php endif;?>">Pending<br><span>待审核</span></li>
                    <li statusValue="4" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '4'):?>nan<?php endif;?>">Unpaid<br><span>待付款</span></li>
                    <li statusValue="5" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '5'):?>nan<?php endif;?>">Paid<br><span>已付款</span></li>

                    <li statusValue="6" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '6'):?>nan<?php endif;?>">Purchase<br><span>待采购</span></li>
                    <li statusValue="7" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '7'):?>nan<?php endif;?>">Purchased<br><span>已采购</span></li>


                    <li statusValue="10" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '10'):?>nan<?php endif;?>">On the way<br><span>发货中</span></li>
                    <li statusValue="11" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '11'):?>nan<?php endif;?>">Shipped<br><span>已发货</span></li>

<!--                     <li statusValue="19" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '19'):?>nan<?php endif;?>">Confirmed<br><span>已收货</span></li>-->
                    <li statusValue="14" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '14'):?>nan<?php endif;?>">Return<br><span>待退换货</span></li>

                    <li statusValue="15" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '15'):?>nan<?php endif;?>">Returned<br><span>已退换货</span></li>
                    <li statusValue="16" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '16'):?>nan<?php endif;?>">Refund <br><span>待退款</span></li>

                    <li statusValue="17" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '17'):?>nan<?php endif;?>">Paid Back <br><span>已退款</span></li>

                    <li statusValue="30" class="bgge <?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '30'):?>nan<?php endif;?>">Cancled<br><span>已取消</span></li>
                    <li statusValue="20" class="<?php if($this->_tpl_vars['IN']['fastOrderStatus'] == '20'):?>nan<?php endif;?>">Finished<br><span>已完成</span></li>
                    </ul>
                </div>
            	<input type="hidden" name="fastOrderStatus" id="fastOrderStatus" value="<?php if($this->_tpl_vars['IN']['fastOrderStatus']): echo $this->_tpl_vars['IN']['fastOrderStatus'];?><?php else:?>100<?php endif;?>" />
                <input type="hidden" name="searchType" value="fast"/>
                <input type="hidden" name="method" value="orders"/>
                <input type="hidden" name="action" value="cms"/>
            </form>
            <div class="clr"></div>
            <div style="width:1080px;margin:0 auto;height:20px;"><span class="itemShopHide"></span><span class="itemShopShow"></span></div>
            	<form name="advSearch_form" id="advSearch_form" style="display:none;" action="index.php" method="post">
            	<table width="1080px">
                    <tr>
                    	<td width="205px"></td>
                        <td width="180px">Order No/Order Name/User :</td>
                        <td width="350px"><input type="text" name="searchOrderNo" value="<?php if($this->_tpl_vars['IN']['searchOrderNo']){echo $this->_tpl_vars['IN']['searchOrderNo'];}?>" style="width:340px;" /></td>
                        <td>
                        	<a class="search_submit" id="search_submit">Search</a>
                        	<span class="searchClear" id="searchClear">clear</span>
                        </td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td>Location:</td>
                        <td>
                    		<input type="text" name="searchOrderLocation" id="searchOrderLocation" value="<?php echo $this->_tpl_vars['IN']['searchOrderLocation'];?>" style="width:130px;" />
                    		<span style="margin:0 10px;">Payment:</span>
 		                    <select name="searchOrderPayment" id="searchOrderPayment" style="width:130px;">
		                        <option value="0" <?php if(!$this->_tpl_vars['IN']['searchOrderPayment']):?>selected<?php endif;?>>All</option>
		                        <option value="1" <?php if($this->_tpl_vars['IN']['searchOrderPayment'] == '1'):?>selected<?php endif;?>>PAYPAL</option>
		                        <option value="2" <?php if($this->_tpl_vars['IN']['searchOrderPayment'] == '2'):?>selected<?php endif;?>>WOW ACCOUNT</option>
		                        <option value="3" <?php if($this->_tpl_vars['IN']['searchOrderPayment'] == '3'):?>selected<?php endif;?>>VISA or Master Card</option>
		                        <option value="4" <?php if($this->_tpl_vars['IN']['searchOrderPayment'] == '4'):?>selected<?php endif;?>>China Union Pay</option>
		                    </select>
                		</td>
                        <td></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td>Submit time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From</td>
                        <td>
                        	<input type="text" onClick="WdatePicker({lang:'en'})" style="width:130px;" name="submitFromTime" value="<?php echo $this->_tpl_vars['IN']['fromTime'];?>" />
                            <span style="margin:0 30px;">To</span>
                        	<input type="text" onClick="WdatePicker({lang:'en'})" style="width:130px;" name="submitEndTime"  value="<?php echo $this->_tpl_vars['IN']['endTime'];?>"/></td>
                        <td></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td>Transaction time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From</td>
                        <td>
                        	<input type="text" onClick="WdatePicker({lang:'en'})" style="width:130px;" name="fromTime" value="<?php echo $this->_tpl_vars['IN']['fromTime'];?>" />
                            <span style="margin:0 30px;">To</span>
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
		                        <option value="19" <?php if($this->_tpl_vars['IN']['searchOrderStatus'] == '19'):?>selected<?php endif;?>>Finished</option>
		                    </select>
		                    <span style="margin:0 15px;">Service:</span>
		                    <select name="searchServiceStatus" id="searchServiceStatus" style="width:130px;">
		                        <option value="0" <?php if(!$this->_tpl_vars['IN']['searchServiceStatus']):?>selected<?php endif;?>>All</option>
		                        <option value="16" <?php if($this->_tpl_vars['IN']['searchServiceStatus'] == '16'):?>selected<?php endif;?>>Refunded</option>
		                        <option value="14" <?php if($this->_tpl_vars['IN']['searchServiceStatus'] == '14'):?>selected<?php endif;?>>Returned</option>
		                    </select>
                		</td>
                        <td></td>
                    </tr>
                     <tr>
                    	<td></td>
                    	<td>Department:</td>
                        <td>
                    		<input type="text" name="searchOrderDepartment" id="searchOrderDepartment" value="<?php echo $this->_tpl_vars['IN']['searchOrderDepartment'];?>" style="width:130px;" />
                    		<span style="margin:0 10px;">Operator:</span>
							<input type="text" name="searchOrderOperator" id="searchOrderOperator" value="<?php echo $this->_tpl_vars['IN']['searchOrderOperator'];?>" style="width:130px;" />
                		</td>
                        <td></td>
                    </tr>
                    <tr style="border-bottom:2px solid #adaeab;height:30px;">
                    	<td colspan="4" align="right">
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="searchType" value="adv"/>
                <input type="hidden" name="method" value="orders"/>
                <input type="hidden" name="action" value="cms"/>
            	</form>
        </div>

    <div class="orderList">
        <div class="orderListNum" style="width:540px">
			All Orders (<?php echo $result_count;?>)
        </div>
        <div style="float:left; margin:10px auto;width:540px; text-align:right;color:#333;font:normal 14px Arial, Helvetica, sans-serif;">
        	Transaction Total：  <span class="hong"> ¥ <?php echo number_format(($this->_tpl_vars['sumMoney']['data'][0]['totalMoney'] - $this->_tpl_vars['sumMoney']['data'][0]['totalRefundMoney']), 2, '.', ',');?> </span>
        </div>
 			<div class="she_list_box fr">
				<img src="../../skin/images/shezhi.png" />
				<div class="she_list hide">
					<ul>
                    <li><a onClick="batchSendMail('payment','batch');">Send Payment Reminder</a></li>
                    <li><a onClick="batchSendMail('confirmation','batch');">Send Confirmation Reminder</a></li>
                    <li><a onClick="batchSendMail('refund','batch');">Send Refund Notice</a></li>
                    <li><a onClick="batchDeleteOrder('trash','batch');">Move to Trash</a></li>
                  	</ul>
				</div>
			</div>
        <div class="clr"></div>
    	<div class="orderListCon">
        <?php if(!empty($this->_tpl_vars['lists']["data"])):?>
            <table width="1080px">
                <tr class="orderListTh" style="color:#8c8d8e;font:normal 14px;">
                    <td width="20" align="center"><input type="checkbox" name="allOrderSelect" id="allOrderSelect" value="0" /></td>
                    <td width="120" align="center">Order No</td>
                    <td width="120" align="center">Order Name</td>
                    <td width="180" align="center">Customer</td>
                    <td width="110" align="center">Submit</td>
                    <td width="120" align="center">Paid</td>
                    <td width="100" align="center">Status</td>
                    <td width="150" align="center">Service Status</td>
                    <td width="60"></td>
                    <td width="100"></td>
                </tr>
              <?php foreach($this->_tpl_vars['lists']['data'] as $k => $v):?>

              	<tr id="<?php echo $v['orderID'];?>">
                <td colspan="10">
                    <table class="orderItemTable" width="1080px">
                        <tr style="height:30px;">
                            <td width="20" align="center"><input type="checkbox" name="orderSelect" class="orderSelect" value="<?php echo $v['orderID'];?>" /></td>
                            <td width="120" align="center">
							<?php if($v['country'] != 'China'):?>
                            <img src="../../skin/images/global2.png" width="12px" height="12px" />
                            <?php endif;?>
                            <a class="nan" href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=order&orderID='.$v['orderID']));?>"><?php echo $v['OrderNo'];?></a>
                			</td>
                            <td width="120" align="center">
                            <a class="nan" href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=order&orderID='.$v['orderID']));?>" title="<?php echo $v['orderName'];?>" alt="<?php echo $v['orderName'];?>"><?php echo runFunc('g_substr',array($v['orderName'],'20'));?></a>
                            </td>
                            <td width="180" align="center"><?php echo ($v['userEmail']?$v['userEmail']:$v['staffNo']);?></td>
                            <td width="110" align="center" style="color:#909090;font-size:12px;"><?php echo date("y-m-d H:i",$v['orderTime']);?></td>
                            <td width="120" align="center" style="color:#909090;font-size:12px;">
								<?php
									if($v['payTime']){
										echo date("y-m-d H:i",strtotime($v['payTime']))."</br>";
										echo "by ".$_GLOBAL['order_payment_'.$v["payment"]];
									}?>

                            </td>
                            <td width="100" align="center" class="nan" style="font-size:12px;">
                            	<?php echo $_GLOBAL['order_info_'.$v['orderStatus']];?></br><?php echo $_GLOBAL['order_info_cn_'.$v['orderStatus']];?>
                            </td>
                            <td width="150" class="hong" style="font-size:12px;">
                            	<?php
									switch($v['orderStatus']){
										case "4":
											if($v['pending'] == 1){
												echo $_GLOBAL['order_info_2']."</br>".$_GLOBAL['order_info_cn_2'];
											}elseif($v['pending'] == 2){
												echo '<div class="hui">'.$_GLOBAL['order_info_3']."</br>".$_GLOBAL['order_info_cn_3']."</div>";
											}else{
												echo '<div class="hui">'.$_GLOBAL['order_info_1']."</br>".$_GLOBAL['order_info_cn_1']."</div>";
											}
										break;
										case "5":
											if(!$v['verify']){
												echo $_GLOBAL['order_info_24']."</br>".$_GLOBAL['order_info_cn_24'];
											}else{
												echo '<div class="hui">'.$_GLOBAL['order_info_25']."</br>".$_GLOBAL['order_info_cn_25']."</div>";
											}
										break;
										case "12":
										case "13":

										break;
										case "14":
										case "15":

										break;
										case "16":
										case "17":

										break;
									}

									if($v['Returned']){
										if($v['orderStatus'] < 19){
											echo $_GLOBAL['order_info_14']."</br>".$_GLOBAL['order_info_cn_14']."</br>";
										}else{
											echo $_GLOBAL['order_info_15']."</br>".$_GLOBAL['order_info_cn_15']."</br>";
										}
									}
									if($v['replacement']){
										if($v['orderStatus'] < 19){
											echo $_GLOBAL['order_info_12']."</br>".$_GLOBAL['order_info_cn_12']."</br>";
										}else{
											echo $_GLOBAL['order_info_13']."</br>".$_GLOBAL['order_info_cn_13']."</br>";
										}
									}
									if($v['order_return'] == 1){
										echo $_GLOBAL['order_info_16']."</br>".$_GLOBAL['order_info_cn_16'];
									}
									if($v['order_return'] == 2){
										echo $_GLOBAL['order_info_17']."</br>".$_GLOBAL['order_info_cn_17'];
									}
								?>
                            </td>
                            <td width="60" align="right"></td>
                            <td width="100"></td>
                        </tr>

                        <tr height="20px" class="hui" style="font-size:12px;">
                        	<td colspan="8"></td>
                            <td style="text-align:right;">Paid:</td>
                            <td style="text-align:right;">
                            <?php if($v['payment']):?>
                            ¥ <?php echo number_format(($v['totalAmount']+$v['Additional']),2,'.',',');?></td>
                            <?php endif;?>
                        </tr>
                        <tr height="20px" class="hui" style="font-size:12px;">
                        	<td colspan="8"></td>
                            <td style="text-align:right;">Additional:</td>
                            <td style="text-align:right;"> ¥ <?php echo number_format($v['Additional'],2,'.',',');?></td>
                        </tr>
                        <tr height="20px" style="font-size:12px;">
                        	<td colspan="8"></td>
                            <td style="text-align:right;" class="hui">Refund:</td>
                            <td style="text-align:right;" class="hong"> - ¥ <?php echo number_format($v['refundAmount'],2,'.',',');?></td>
                        </tr>
                        <tr height="20px" class="hei" style="font-size:12px;">
                        	<td colspan="8"></td>
                            <td style="text-align:right;">Total:</td>
                            <td style="text-align:right;"> ¥ <?php echo number_format(($v['totalAmount']+$v['Additional']-$v['refundAmount']),2,'.',',');?></td>
                        </tr>
                        <tr class="itemLineBg270" height="10px"><td colspan="9"></td></tr>

                        <tr height="20px" style="font-size:12px;">
                        	<td colspan="8"></td>
                            <td style="text-align:right;" class="hui">Modify:</td>
                            <td style="text-align:right;" class="nan"><a style="cursor:default;" title="<?php echo $v['mender'];?>" alt="<?php echo $v['mender'];?>"><?php echo runFunc('g_substr',array($v['mender'],'14'));?></a></td>
                        </tr>
                        <tr height="20px" style="font-size:12px;">
                        	<td colspan="8"></td>
                            <td style="text-align:right;" class="hui">Verifier:</td>
                            <td style="text-align:right;" class="nan"><a style="cursor:default;" title="<?php echo $v['verifier'];?>" alt="<?php echo $v['verifier'];?>"><?php echo runFunc('g_substr',array($v['verifier'],'14'));?></a></td>
                        </tr>
                        <tr height="20px" style="font-size:12px;">
                        	<td colspan="8"></td>
                            <td style="text-align:right;" class="hui">Buyer:</td>
                            <td style="text-align:right;" class="nan"><a style="cursor:default;" title="<?php echo $v['buyer'];?>" alt="<?php echo $v['buyer'];?>"><?php echo runFunc('g_substr',array($v['buyer'],'14'));?></a></td>
                        </tr>

                        <tr style="border-bottom:2px solid #adaeab;height:10px;"><td colspan="10"></td></tr>
                    </table>
                </td>
                </tr>
              <?php endforeach;?>
              </table>
     			<?php echo runFunc("adminOrderPageNavi",array("cms","orders",$result_count,$rowsPerPage,$page,$this->_tpl_vars['IN']['searchType'],$this->_tpl_vars['IN']['searchMode'],$this->_tpl_vars['IN']['fromTime'],$this->_tpl_vars['IN']['endTime'],$this->_tpl_vars['IN']['submitFromTime'],$this->_tpl_vars['IN']['submitEndTime'],$this->_tpl_vars['IN']['searchOrderNo'],$this->_tpl_vars['IN']['searchOrderLocation'],$this->_tpl_vars['IN']['searchOrderOperator'],$this->_tpl_vars['IN']['searchOrderStatus'],$this->_tpl_vars['IN']['searchServiceStatus'],$this->_tpl_vars['IN']['fastOrderStatus'],$this->_tpl_vars['IN']['searchOrderPayment']));?>
		<?php else: ?>
				<p style="padding:10px;text-align:center;margin-top:30px;">There no item in your order list.</p>
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