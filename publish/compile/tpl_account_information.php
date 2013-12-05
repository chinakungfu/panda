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
		
			
		$querysql = "select user_id,created as time,recharge as money,payment as infoStatus,orderNo,orderID,remark from cms_publish_recharge_order WHERE user_id ={$this->_tpl_vars["name"]} and status = 2";
		$sumQuerysql = "select SUM(recharge) as totalMoney from cms_publish_recharge_order WHERE user_id ={$this->_tpl_vars["name"]} and status = 2";
		//接收参数
		if($this->_tpl_vars['IN']['searchType'] == 'normal'){
			switch($this->_tpl_vars['IN']['searchMonth']){
				case 1:
					//$lastMonth = mktime(date('h'),date('i'),date('s'),date('m')-1,date('d'),date('y')); 
					$querysql .= " and created > DATE_ADD(NOW(), INTERVAL -1 MONTH)";
					$sumQuerysql .= " and created > DATE_ADD(NOW(), INTERVAL -1 MONTH)";
					break;
				case 2:
					$querysql .= " and created > DATE_ADD(NOW(), INTERVAL -2 MONTH)";
					$sumQuerysql .= " and created > DATE_ADD(NOW(), INTERVAL -2 MONTH)";	
					break;
				case 3:
					$querysql .= " and created > DATE_ADD(NOW(), INTERVAL -6 MONTH)";	
					$sumQuerysql .= " and created > DATE_ADD(NOW(), INTERVAL -6 MONTH)";
					break;
			}
		}else if($this->_tpl_vars['IN']['searchType'] == 'adv'){
			$fromTime = $this->_tpl_vars['IN']['fromTime'];
			$endTime = $this->_tpl_vars['IN']['endTime'];
			$searchOrderNo = $this->_tpl_vars['IN']['searchOrderNo'];
			$searchByInfo = $this->_tpl_vars['IN']['searchByInfo'];	
			//echo $fromTime."|||".$endTime."|||".$searchOrderNo."|||".$searchByInfo;
			//exit;
			if($searchOrderNo || ($searchByInfo && $searchByInfo != 0) || ($fromTime && $endTime)){				
				if($searchOrderNo){
					$querysql .= " and orderNo = ".$searchOrderNo;
					$sumQuerysql .= " and orderNo = ".$searchOrderNo;
				}
				if($searchByInfo && $searchByInfo != 0){
					$querysql .= " and payment = ".$searchByInfo;
					$sumQuerysql .= " and payment = ".$searchByInfo;
				}
				if($fromTime && $endTime){
					$fromTime = $this->_tpl_vars['IN']['fromTime']." 00:00:00";
					$endTime = $this->_tpl_vars['IN']['endTime']." 23:59:59";
					if(strtotime($fromTime) < strtotime($endTime)){					
						$querysql .= " and created between '".$fromTime ."' and '".$endTime."'";
						$sumQuerysql .= " and created between '".$fromTime ."' and '".$endTime."'";
					}
				}
			}else{
				$this->_tpl_vars['IN']['searchMonth'] = 1;
				$querysql .= " and created > DATE_ADD(NOW(), INTERVAL -1 MONTH)";
				$sumQuerysql .= " and created > DATE_ADD(NOW(), INTERVAL -1 MONTH)";
			}	
		}else{
			$this->_tpl_vars['IN']['searchType'] = 'normal';
			$this->_tpl_vars['IN']['searchMonth'] = 1;
			$querysql .= " and created > DATE_ADD(NOW(), INTERVAL -1 MONTH)";	
			$sumQuerysql .= " and created > DATE_ADD(NOW(), INTERVAL -1 MONTH)";		
		}
	?>   
	<?php
		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;
		 $params = array (
					'action' => "sql",
					'return' => "lists",
					'query' => $querysql." ORDER BY time DESC limit {$pageStrat},{$rowsPerPage}",
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
    <div class="bagTitle" style="border:none;">Recharge and Refund History</div>
		<div class="searchHistroy">
			<form name="normalSearch" id="normalSearch" action="index.php" method="post">
                <select name="searchMonth" id="searchMonth">
                    <option value="1" <?php if($this->_tpl_vars['IN']['searchMonth'] == '1'):?>selected<?php endif;?>>View last 30 days</option>
                    <option value="2" <?php if($this->_tpl_vars['IN']['searchMonth'] == '2'):?>selected<?php endif;?>>View last 60 days</option>
                    <option value="3" <?php if($this->_tpl_vars['IN']['searchMonth'] == '3'):?>selected<?php endif;?>>View last 6 monthes</option>
                </select>
                <input type="hidden" name="searchType" value="normal"/>
                <input type="hidden" name="method" value="information"/>
                <input type="hidden" name="action" value="account"/>                        
			</form>
 			<div style="float:right;">Advanced Search &nbsp;&nbsp;&nbsp;<span class="searchHide"></span><span class="searchShow"></span></div>
            <div class="clb"></div>
        </div>
        <div class="advSearch" id="advSearch">
        	<form name="advSearch_form" id="advSearch_form" action="index.php" method="post">
            	<table width="975px">
                    <tr>
                    	<td width="105px"></td>
                        <td width="180px">Order No or Order Name:</td>
                        <td width="350px"><input type="text" name="searchOrderNo" value="" style="width:340px;" /></td>
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
                            <span style="margin:0 30px;">To</span>  
                        	<input type="text" onClick="WdatePicker({lang:'en'})" style="width:130px;" name="endTime"  value="<?php echo $this->_tpl_vars['IN']['endTime'];?>"/></td>
                        <td></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td>Search by Info</td>
                        <td>                       
                    <select name="searchByInfo" id="searchByInfo" class="select_style">
                        <option value="0" <?php if(!$this->_tpl_vars['IN']['searchByInfo']):?>selected<?php endif;?>>select searchByInfo</option>
                        <option value="1" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '1'):?>selected<?php endif;?>>PAYPAL Recharge</option>
                        <option value="2" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '2'):?>selected<?php endif;?>>service info</option>
                        <option value="3" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '3'):?>selected<?php endif;?>>Bank Card Recharge</option>
                        <option value="4" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '4'):?>selected<?php endif;?>>Credits Exchange</option>
                        <option value="5" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '5'):?>selected<?php endif;?>>Gift Card Exchange</option>
                        <option value="6" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '6'):?>selected<?php endif;?>>MANUAL(CASH)</option>                        <option value="7" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '7'):?>selected<?php endif;?>>Refund</option>
                        <option value="8" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '8'):?>selected<?php endif;?>>VISA</option>
                        <option value="9" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '9'):?>selected<?php endif;?>>UNIPAY</option><!--                        <option value="10" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '10'):?>selected<?php endif;?>>Wire transfer</option>
                        <option value="11" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '11'):?>selected<?php endif;?>>WESTERN UNION</option>                       	<option value="11" <?php if($this->_tpl_vars['IN']['searchByInfo'] == '12'):?>selected<?php endif;?>>MANUAL(POS)</option>-->
                   </select>
                		</td>
                        <td></td>
                    </tr>                    
                    <tr class="itemLineBg980">
                    	<td colspan="4" align="right">
                        Transaction Total：   <font color="#a10000">¥ <?php echo $this->_tpl_vars['sumMoney']['data'][0]['totalMoney'];?></font>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="searchType" value="adv"/> 
                <input type="hidden" name="method" value="information"/>
                <input type="hidden" name="action" value="account"/>                 
            </form>    
        </div>        
 		<script language="javascript">
		$(function(){
			$("#searchClear").click(function(){
				$("#advSearch_form input:text").each(function(index, element) {
					$(this).val("");
                });
			});
			$(".searchHide").click(function(){
				$("#advSearch").hide();
			});
			$(".searchShow").click(function(){
				$("#advSearch").show();
			});
			$("#searchMonth").change(function(){
				if($(this).val() > 0){
					$("#normalSearch").submit();
				}
			});	
			$("#search_submit").click(function(){
				var searchOrderNo = $("#advSearch_form input[name='searchOrderNo']").val();
				var fromTime = $("#advSearch_form input[name='fromTime']").val();
				var endTime = $("#advSearch_form input[name='endTime']").val();
				checkEndTime(fromTime,endTime);
				var searchByInfo = $("#searchByInfo").val();
				
				if(searchOrderNo || (searchByInfo && searchByInfo != 0) || (fromTime && endTime && checkEndTime(fromTime,endTime))){
					$("#advSearch_form").submit();
				}			
			});

		$(".viewRemark").hover(
			function() {
				var remark = $(this).next(".hideRemark").text();
				var resulthtml = "<p>"+ remark +"</p>";
			
				var scroH = $(document).scrollTop();
				var itemScroH = $(this).offset().top;
				var resultScroH = itemScroH - scroH;
				var itemScroL = $(this).offset().left;
				$("#bigresult").css({"position":"fixed","top":(resultScroH - 50),"left":(itemScroL + 120),"z-index":100});
				$('#bigresult').html(resulthtml);
				$("#bigresult").show();
		  	},
		  function(){
				$("#bigresult").hide();
		  }
		);				
			
			
		});
		
		</script> 
        
              
     <div class="rechargeHistroy">
		<?php if(!empty($this->_tpl_vars['lists']["data"])):?>
				<table width="975px">
					<tr style="border-bottom:2px solid #ccc;height:40px;color:#333;">
						<td width="200px" align="center">Time</td>
						<td width="250px" align="center">Amount of Consumption (RMB)</td>
						<td width="200px" align="center">Payment Info</td>
						<td width="200px" align="center">Refund Info</td>
                        <td align="center">Service Info</td>
					</tr>
			<?php foreach($this->_tpl_vars['lists']["data"] as $k => $v){ ?>
                        <tr style="border-bottom:1px solid #ddd;">
                            <td>
								<?php echo $v["time"];?>
                            </td>
                            <td align="center">
                            	<?php if($v["infoStatus"] == 7):?>
                                <span style="color:#a10000;">+ ¥ <?php echo number_format($v["money"],'2','.',',');?></span>
                                <?php elseif($v["infoStatus"] == 2):?>
                                <span style="color:#ff9900;">- ¥ <?php echo number_format(str_replace('-','',$v["money"]),'2','.',',');?></span>
                                <?php else:?>
                                <span>¥ <?php echo number_format($v["money"],'2','.',',');?></span>
                            	<?php endif;?>
                            	
                            </td>
                            <td align="center">
								<?php echo $_GLOBAL['recharge_info_'.$v["infoStatus"]];?>
                            </td>
                            <td align="center">
                            <?php 
								if($v["infoStatus"] == 7):?>
									<a style='color:#a10000;' href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderDetail&orderID='.$v["orderID"]))?>"><?php echo $v["orderNo"];?></a>
							<?php endif;?>
                            	
                            </td>
                            <td align="center" style="overflow:hidden;">
                            <?php
								if($v["remark"]){
									echo "<div class='viewRemark' style='color:#ff9900;cursor:pointer;'>View Detail</div>"."<span class='hideRemark hide'>".$v["remark"]."</span>";
									
								}
							?>
                            </td>
                            
                        </tr>
                        
				<?php }?>
				</table>
 				
     			<?php echo runFunc("accountPageNavi",array("account","information",$result_count,$rowsPerPage,$page,$this->_tpl_vars['IN']['searchType'],$this->_tpl_vars['IN']['searchMonth'],$this->_tpl_vars['IN']['fromTime'],$this->_tpl_vars['IN']['endTime'],$this->_tpl_vars['IN']['searchOrderNo'],$this->_tpl_vars['IN']['searchByInfo']));?> 
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