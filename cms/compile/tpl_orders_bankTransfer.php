<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
<script type="text/javascript" src="skin/jsfiles/bankTransferList.js"></script>
<div class="cms_main_box">
<div class="content">
    <?php
		$settings = runFunc("getGlobalSetting");
		//print_r($settings[0]['USD_rate']);
		if($this->_tpl_vars["IN"]["page"]){
			$page=$this->_tpl_vars["IN"]["page"];
		}else{
			$page=1;
		}
		$rowsPerPage = 15;
		$pageStrat = $page * $rowsPerPage - $rowsPerPage;
		$searchOrderStatus = $this->_tpl_vars['IN']['searchOrderStatus'];
		//$searchOrderPayment = $this->_tpl_vars['IN']['searchOrderPayment'];
		
		$querysql = "select * from cms_publish_bank_transfer as a left join cms_member_staff as b on a.userID = b.staffId WHERE a.status > 3";
		$sumRMBQuerysql = "select SUM(rechargeMoney) as totalMoney from cms_publish_bank_transfer as a left join cms_member_staff as b on a.userID = b.staffId WHERE a.status > 3 and moneyType = 2";
		$sumUSDQuerysql = "select SUM(rechargeMoney) as totalMoney from cms_publish_bank_transfer as a left join cms_member_staff as b on a.userID = b.staffId WHERE a.status > 3 and moneyType = 1";
	?>
    <?php

		if($searchOrderStatus && $searchOrderStatus != 0){
			$querysql .= " and a.status = ".$searchOrderStatus;
			$sumQuerysql .= " and a.status = ".$searchOrderStatus;						
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
					'return' => "sumRMBMoney",
					'query' => $sumRMBQuerysql,
		 );

		 $this->_tpl_vars['sumRMBMoney'] = CMS::CMS_sql($params2);
		 
		 
		 $params3 = array (
					'action' => "sql",
					'return' => "sumUSDMoney",
					'query' => $sumUSDQuerysql,
		 );
		 $this->_tpl_vars['sumUSDMoney'] = CMS::CMS_sql($params3);

		 
	 	 $result_count = count($this->_tpl_vars['lists']["data"]);
		 
		 $sumRMBMoney = $this->_tpl_vars['sumRMBMoney']['data'][0]['totalMoney'];
		 $sumUSDMoney = $this->_tpl_vars['sumUSDMoney']['data'][0]['totalMoney'];
		 $sumMoney = $sumUSDMoney * $settings[0]['USD_rate'] + $sumRMBMoney;
	 ?>

    <div class="orderList">
        <div class="orderListNum" style="width:250px;font-size:16px;">
			Bank Transfer List &nbsp;&nbsp;<span style="font: 12px Verdana,Arial;">(<?php echo $result_count;?>)</span>
        </div>
	<div class="select_box fl">
		<h2>点击选择筛选项</h2>
		<div class="selectas hide saveHover">
			<ul>
             <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_bankTransfer&type=orders'));?>">All</a></li>            
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_bankTransfer&type=orders&searchOrderStatus=19'));?>">Finished</a></li>
             <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_bankTransfer&type=orders&searchOrderStatus=5'));?>">Waiting</a></li>                                            
          	</ul>
		</div>
	</div>
        <div style="float:left; margin:10px auto;width:530px; text-align:right;color:#333;font:normal 14px Arial, Helvetica, sans-serif;">
        	RMB Total： <span class="hong"> ¥ <?php echo number_format($sumRMBMoney, 2, '.', ',');?></span> &nbsp;&nbsp;
        	USD Total： <span class="hong"> $ <?php echo number_format($sumUSDMoney, 2, '.', ',');?></span> &nbsp;&nbsp;
        	Transaction Total： <span class="hong"> ¥ <?php echo number_format($sumMoney, 2, '.', ',');?></span>
        </div>
        <div class="clr"></div>
    	<div class="orderListCon">
        <?php if(!empty($this->_tpl_vars['lists']["data"])):?>
            <table width="1080px" style="table-layout:fixed;word-wrap:break-word;">
                <tr class="orderListTh" style="color:#8c8d8e;font:normal 14px;">
                    <td width="20" align="center"><input type="checkbox" name="allOrderSelect" id="allOrderSelect" value="0" /></td>
                   
                    <td width="200" align="center">Customer</td>
                    <td width="90" align="center">Submit</td>
                    <td width="170" align="center">name(汇款人)</td>
                    <td width="70" align="center">Country</td>
                    <td width="70" align="center">Tsf Time</td>
                    <td width="90" align="center">Amount</td>
                   
                    <td width="90" align="center">Status</td>
                    <td width="100" align="center">OperationTime</td>
                    <td width="100" align="center">Operator</td>
                    <td align="center"></td>
                </tr>
              <?php foreach($this->_tpl_vars['lists']['data'] as $k => $v):?>

              	<tr id="<?php echo $v['id'];?>">
                    <td align="center" style="color:#909090;font-size:12px;"><input type="checkbox" name="orderSelect" class="orderSelect" value="<?php echo $v['id'];?>" /></td>

                    <td align="center" style="color:#909090;font-size:12px;"><?php echo ($v['email']?$v['email']:$v['staffNo']);?></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo date("y-m-d H:i",$v['submitTime']);?></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo $v['senderName'];?></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo $v['country'];?></td>
                    <td align="center" style="color:#909090;font-size:12px;"><?php echo date("y-m-d",$v['payTime']);?></td>
                    <td align="center" style="color:#909090;font-size:12px;">
                    <span class="hong">
						<?php if($v["moneyType"] == 1){echo '$';}else if($v["moneyType"] == 2){echo '¥';}?>
						<?php echo number_format($v['rechargeMoney'], 2, '.', ',');?>
                    </span>
                   	</td>
                    <td align="center" class="nan" style="font-size:12px;">
                        <?php echo $_GLOBAL['order_info_'.$v['status']];?></br><?php echo $_GLOBAL['order_info_cn_'.$v['status']];?>
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
                    	<?php if($v['status'] == 5):?>
                    		<a class="nan" style="cursor:pointer;" onClick="changeBankTransferStatus('<?php echo $v['id'];?>','finish');">完成</a>&nbsp;&nbsp; 
                            <a class="nan" target="_blank" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$v["staffId"].'&type=users'));?>" style="cursor:pointer;">去充值</a>
                        <?php endif;?> 
                    	<?php if($v['status'] == 19):?>
                    		<a class="hui">已完成</a>&nbsp;&nbsp; 
                        <?php endif;?>                                                 
                    </td>
                </tr>

				<tr style="border-bottom:2px solid #adaeab;height:10px;"><td colspan="11"></td></tr>
              <?php endforeach;?>
              </table>
              
     			<?php echo runFunc("phoneOrderPageNavi",array("cms","orders_rechargePhoneList",$result_count,$rowsPerPage,$page,$this->_tpl_vars['IN']['searchOrderStatus']));?>
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