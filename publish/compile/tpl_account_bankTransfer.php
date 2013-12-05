<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
if ($this->_tpl_vars["name"]==""){?>
<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

<?php } ?>
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
<script language="javascript">
$(function(){
		$(".recharge_bank_num").focus(function(){
			var defaultVal = $(this).attr("defaultVal");
			var urlVal = $(this).val();
			if(urlVal == defaultVal){	
				$(this).val("");
			}
			$(this).css("color","#333");
		});
		$(".recharge_bank_num").blur(function(){
			var defaultVal = $(this).attr("defaultVal");
			var urlVal = $(this).val();
			if(urlVal == ''){
				$(this).val(defaultVal);
				$(this).css("color","#A0A0A0");
			}
		});

		$("#recharge_bank_submit").click(function(){
			
			var amount = $("input[name='amount']").val();
			var amountdefaultVal = $("input[name='amount']").attr('defaultVal');
			
			var senderName = $("input[name='senderName']").val();
			var senderNamedefaultVal = $("input[name='senderName']").attr('defaultVal');			

			var paymentTime = $("input[name='payTime']").val();
			var paymentTimedefaultVal = $("input[name='payTime']").attr('defaultVal');			
			
			if(amount == '' || amount == amountdefaultVal || senderName == '' || senderName == senderNamedefaultVal || paymentTime == '' || paymentTime == paymentTimedefaultVal){
				alert('Please fill out the form in the project with a * !');
				return false;
			}else{
				if(!isfloat(amount) || amount <= 0){
					alert('Please fill in the Numbers greater than zero.');
					$("input[name='amount']").focus();
				}else{
					$("#recharge_bank_form").submit();
				}
			}
	
		});

});
</script>
</head>
<body>
<?php $settings =  runFunc("getGlobalSetting");?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	include($inc_tpl_file);

	$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["orderID"]));

	if($loginUser == ""){

	$current_user_id =  $tmpUser;
}else{
	$current_user_id =  $loginUser;
}

$loginUser = runFunc('readSession',array());
$user_info = runFunc("getStaffInfoById",array($loginUser));

	?>
<div class="content" style="width: 976px;">
        <div class="notic_content">
            <div class="notic_header" style="height:50px;padding:30px 0 30px;">	
                <h1 style="color:#333;">Bank Transfer</h1>
            </div>
        </div>
    <div class="recharge_main_box oh" style="margin:30px auto 0; background-color:#333333;">
        <img src="../../skin/images/bankTransfer.jpg" alt="" class="fl" style="margin:30px 0 30px 40px;" />
        <div class="fl recharge_bank_box">
            <div class="recharge_bank_title">You are choosing Bank Transfer</div>
            <table width="400px" class="recharge_bank_content">
                <tr><td width="115px" class="tname">Reciver name: </td><td class="tval">Fu Zheng Yang / 傅正扬</td></tr>
                <tr><td class="tname">TT Account:  </td><td class="tval">6227 0020 0169 0013 171</td></tr>
                <tr><td class="tname">Bank name: </td><td class="tval">China Construction Bank  / 中国建设银行</td></tr>
                <tr><td class="tname">Swift code: </td><td class="tval">PCBCCNBJJSS</td></tr>
                <tr><td class="tname" valign="top">Bank address: </td>
                	<td class="tval" valign="top">
                        <p>Orchard Manors Xing Ming Street, </p>
                        <p>Suzhou,Jiangsu</p>
                        <p>China</p>
                        <p>苏州工业园区星明街都市花园分理处</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clb" style="text-align:center;font:bold 14px Arial, Helvetica, sans-serif;color:#adaeab;line-height:50px; vertical-align:middle;">After you have sent money to the above Bank account ,please fill and submit your payment informatiom</div>
    </div>
    
    
 <form id="recharge_bank_form" action="index.php" method="post">   
	<div class="recharge_bank_info">
		<table width="974px" class="recharge_bank_tab">
        	<tr style="height:30px;">
            	<td width="175px"></td>
                <td width="340px" valign="middle" style="color:#333;font:normal 14px Arial, Helvetica, sans-serif; padding-left:50px;">
                <input checked="checked" type="radio" name="moneyType" value="2" /> RMB &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="moneyType" value="1" /> Dollar
                </td>
                <td></td>
            </tr>
        	<tr>
            	<td valign="middle" align="right" class="recharge_bank_tbname">Amount</td>
                <td valign="middle" align="left" class="recharge_bank_tbval"><input type="text" name="amount" class="recharge_bank_num" defaultVal = 'USD or RMB only' value="USD or RMB only" /><span>*</span></td>
                <td rowspan="4" valign="top" style="padding-right:40px; padding-top:10px;font:normal 14px Arial, Helvetica, sans-serif;color:#adaeab; line-height:30px;">
                 Please fill in this form, after money transfer successfully.
 We will check our bank account within 24 hours. If there 
 are no problems, the money will be added to your account 
 immediately. Please pay attention to your wow account 
 balance and account history.
                </td>
            </tr>
        	<tr>
            	<td valign="middle" align="right" class="recharge_bank_tbname">Country</td>
                <td valign="middle" align="left" class="recharge_bank_tbval"><input type="text" name="country" class="recharge_bank_num" defaultVal = 'Please enter your bank location' value="Please enter your bank location" /></td>

            </tr>
        	<tr>
            	<td valign="middle" align="right" class="recharge_bank_tbname">Sender’s name</td>
                <td valign="middle" align="left" class="recharge_bank_tbval"><input type="text" name="senderName" class="recharge_bank_num" defaultVal = 'Please enter name exactly' value="Please enter name exactly" /><span>*</span></td>

            </tr>     
         	<tr>
            	<td valign="middle" align="right" class="recharge_bank_tbname">Date of Payment</td>
                <td valign="middle" align="left" class="recharge_bank_tbval"><input type="text" class="recharge_bank_num" onClick="WdatePicker({lang:'en'})" name="payTime" defaultVal = 'Please enter your Date of Payment' value="Please enter your Date of Payment" />
                <span>*</span>&nbsp;
                </td>
            </tr>                               
        </table>
    </div> 
    <div style="width:100%" class="oh fr">
    <button class="recharge_bank_submit" type="button" name="recharge_bank_submit" id="recharge_bank_submit">SUBMIT</button>
    </div>
    <div class="clb"></div>
    <input type="hidden" name="method" value="bankTransferSave"/>
    <input type="hidden" name="action" value="account"/>
    </form>   
    
    
    <?php
		$settings = runFunc("getGlobalSetting");
		$querysql = "select * from cms_publish_bank_transfer WHERE userID ={$this->_tpl_vars["name"]}";
		$sumQuerysql = "select SUM(rechargeMoney) as totalMoney from cms_publish_bank_transfer WHERE userID ={$this->_tpl_vars["name"]}";
		$sumRMBQuerysql = "select SUM(rechargeMoney) as totalMoney from cms_publish_bank_transfer WHERE userID ={$this->_tpl_vars["name"]} and moneyType = 2";
		$sumUSDQuerysql = "select SUM(rechargeMoney) as totalMoney from cms_publish_bank_transfer WHERE userID ={$this->_tpl_vars["name"]} and moneyType = 1";	
	?>   
	<?php
		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;
		 $params = array (
					'action' => "sql",
					'return' => "lists",
					'query' => $querysql." ORDER BY submitTime DESC",
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

		 $countNum = count($this->_tpl_vars['lists']["data"]);
		 
		 $sumRMBMoney = $this->_tpl_vars['sumRMBMoney']['data'][0]['totalMoney'];
		 $sumUSDMoney = $this->_tpl_vars['sumUSDMoney']['data'][0]['totalMoney'];
		 $sumMoney = $sumUSDMoney * $settings[0]['USD_rate'] + $sumRMBMoney;		 
		 
	 ?>
        <div class="advSearch" id="advSearch" style="margin-top:40px;">
            <table width="975px">                  
                <tr class="itemLineBg980">
                	<td style="color: #333333;
    font: 24px Arial,Helvetica,sans-serif;">Bank Transfer History &nbsp;&nbsp;<span class="smallNum">(<?php echo $countNum?$countNum:0;?>)</span></td>
                    <td colspan="4" align="right">
        	RMB Total： <span class="hong"> ¥ <?php echo number_format($sumRMBMoney, 2, '.', ',');?></span> &nbsp;&nbsp;
        	USD Total： <span class="hong"> $ <?php echo number_format($sumUSDMoney, 2, '.', ',');?></span> &nbsp;&nbsp;
        	Transaction Total： <span class="hong"> ¥ <?php echo number_format($sumMoney, 2, '.', ',');?></span>
                    </td>
                </tr>
            </table>  
        </div>          
     <div class="rechargeHistroy">
		<?php if(!empty($this->_tpl_vars['lists']["data"])):?>
				<table width="975px" style="table-layout:fixed;word-wrap:break-word;">
					<tr style="border-bottom:2px solid #ccc;height:40px;color:#333;">
						<td width="230px" align="center">Submit Time</td>
						<td width="230px" align="center">Transfer Time</td>
						<td width="200px" align="center">Amount</td>
                        <td align="center">Service Info</td>
					</tr>
			<?php foreach($this->_tpl_vars['lists']["data"] as $k => $v){ ?>
                        <tr style="border-bottom:1px solid #ddd;">
                            <td>
                                <?php echo date("Y-m-d H:i",$v['submitTime']);?>
                            </td>
                            <td align="center">
                                <?php echo date("Y-m-d",$v['payTime']);?>  	
                            </td>
                            <td align="center">
								<span class="hong"><?php if($v["moneyType"] == 1){echo '$';}else if($v["moneyType"] == 2){echo '¥';}?> <?php echo number_format($v["rechargeMoney"],'2','.',',');?></span> 
                            </td>
                            <td align="center" style="overflow:hidden;">
                            <?php if($v["status"] == 5):?>
                            	<span class="nan">Waiting</span>
                            <?php elseif($v["status"] == 17):?>
                            	<span class="huang">Refund</span>
                            <?php elseif($v["status"] == 19):?>
                            	<span class="hui">Finish</span>                             
							<?php endif;?>
                            </td>
                            
                        </tr>
                        
				<?php }?>
				</table>

		<?php else: ?>
				<p style="padding:10px;text-align:center;margin-top:30px;">There are no records in your recharge history.</p>
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

</body>
</html>