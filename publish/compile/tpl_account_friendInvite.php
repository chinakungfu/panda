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
<script type="text/javascript">
	
$(function(){
	$("#inviteEmail").focus(function(){
		var defaultVal = $(this).attr("defaultVal");
		var urlVal = $(this).val();
		if(urlVal == defaultVal){	
			$(this).val("");
		}
		$(this).css("color","#333");
	});
	$("#inviteEmail").blur(function(){
		var defaultVal = $(this).attr("defaultVal");
		var urlVal = $(this).val();
		if(urlVal == ''){
			$(this).val(defaultVal);
			$(this).css("color","#A0A0A0");
			$("#errorResult").text('');
		}else{
			testEmail(urlVal,false);
		}
	});	
	$("#inviteEmail").keydown(function(e){
		if(e.keyCode==13){
			var defaultVal = $(this).attr("defaultVal");
			var urlVal = $(this).val();
			if(urlVal != '' && urlVal != defaultVal){
				testEmail(urlVal,true);
			}		   
		}
	});	
	$(".submit_btn").click(function(){
		if($(".addInviteEmail").length){
			$("#mail_invent_send_form").submit();
		}else{
			alert('Please add an email address');
			$("#inviteEmail").focus();
		}
	});
});
function testEmail(inviteEmail,isAdd){
	$.ajax({
	   url: "index.php",
		type : 'POST',
		dataType : "json",
		data:{
			action		: "account",
			method		: "friendInviteTest",
			inviteEmail : inviteEmail
		},
	   success: function(result){
		   switch(result.status){
			   case -1:
			   		$("#errorResult").text("Invalid email address");
					$("#errorResult").css('color','#a10000');
			   break;
			   case -2:
			   		$("#errorResult").text("Already a member");
					$("#errorResult").css('color','#a10000');
			   break;	
			   case -3:
			   		$("#errorResult").text("Recently invited");
					$("#errorResult").css('color','#a10000');
			   break;
			   case 1:
					var isRepeat = false;
					$(".addInviteEmail").each(function(index, element) {
						if($(this).text() == inviteEmail){
							isRepeat = true;
						}
					});
					var addlength = $(".addInviteEmail").length + 1;
					var addInviteMoney = addlength * 50;
					if(!isRepeat){
						if(isAdd == true){
							var addHtml = '<li><span class="addInviteEmail">'+ inviteEmail +'</span> <img src="../../skin/images/select.png" /><input type="hidden" name="inviteEmail['+ addlength +']" value="'+ inviteEmail +'" /></li>';
							$(".invite_result ul").append(addHtml);
							$("#addInviteMoney").text(addInviteMoney);
							$("#inviteEmail").val("");			
							$("#errorResult").text('');			
						}else{
							$("#errorResult").text('Looks good, press enter to submit!');
							$("#errorResult").css('color','#707070');					
						}						
					}else{
						$("#errorResult").text("Recently invited");
						$("#errorResult").css('color','#a10000');
					}

			   break;			   			   		   
			}
		},		
	});
}
</script>
</head>
<body>

<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php 
	$SITE_DOMAIN =  runFunc("getGlobalSettingsVar",array('SITE_DOMAIN'));
	$userInfo =  runFunc("getUser",array($this->_tpl_vars["name"]));
	if(!$userInfo[0]['inviteUrl']){
		$inviteID = (1982 + (int)$userInfo[0]['staffId'])*2;
		$inviteUrl = "/publish/index.php".runFunc('encrypt_url',array('action=website&method=invite&inviteID='.$inviteID));

		$sql = "update cms_member_staff set inviteUrl = '{$inviteUrl}' where staffId = {$this->_tpl_vars["name"]}";
		TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);	
	}else{
		$inviteUrl = $userInfo[0]['inviteUrl'];
	}
?>
<div class="content">
	<div class="invite_friends">
         <div class="invite_top">
                <h1>Share & Get 50RMB</h1>
                <h2>Email your friends and invite to WOWshopping and you'll get 50RMB after their first order ships</h2>
         </div>
         
        <div class="invite_middle">
            <a class="submit_btn" style="margin:20px auto;">Invite Now</a>
            <div class="clb"></div>
            
            <div class="invite_content_left">
                
					<h3>Invite Your Friends  <span style="color:#5e97ed;font-size:14px;">Potential Earnings: <font id="addInviteMoney">0</font> RMB</span></h3>
                    <p>Type the email address of the friend you want to invite on 
WOWshopping and press Enter/Return when you're done.</p>
					<input id="inviteEmail" name="inviteEmail" type="text" defaultVal="Email Address" value="Email Address" style="width:370px;height:30px;padding-left:5px;color:#A0A0A0;vertical-align:middle;margin:20px auto 5px;" />
                    <p id="errorResult" style="color:#a10000; min-height:30px;"></p>
            	<form id="mail_invent_send_form" action="index.php" method="post">
                    <div class="invite_result">
                        <ul></ul>
                    </div>
                    <input name="action" type="hidden" value="account" />
                    <input name="method" type="hidden" value="friendInviteSave" />
                </form>
            </div>
            
            <div class="invite_content_right">
            	<h3>Your Invite Link</h3>
                <p>Spread the love! Share WOWshopping with friends, add to blogs
and post on Facebook and Twitter.</p>
				<p style="color:#5e97ed; word-break:break-all;"><?php echo $SITE_DOMAIN['varValue'].$inviteUrl;?></p>
                <p>Copy and share your personal invite link!</p>
            </div>
        	<div class="clb"></div>
        </div>
        
        
        <div class="invite_bottom">
    <?php
		if($this->_tpl_vars["IN"]["page"]){
			$page=$this->_tpl_vars["IN"]["page"];
		}else{
			$page=1;
		}
		$rowsPerPage = 20;
		$pageStrat = $page * $rowsPerPage - $rowsPerPage;	
	
		$settings = runFunc("getGlobalSetting");
		$querysql = "select * from cms_member_invite WHERE userID ={$this->_tpl_vars["name"]}";
		$sumQuerysql = "select SUM(inviteMoney) as totalMoney from cms_member_invite WHERE userID ={$this->_tpl_vars["name"]} and status = 3";
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

		 $countNum = count($this->_tpl_vars['lists']["data"]);
		 $sumMoney = $this->_tpl_vars['sumMoney']['data'][0]['totalMoney'];	 


		 $params3 = array (
					'action' => "sql",
					'return' => "totalList",
					'query' => $querysql,
		 );

		 $this->_tpl_vars['totalList'] = CMS::CMS_sql($params3);
		 		 
		 $result_count = count($this->_tpl_vars['totalList']["data"]);
	 ?>
        <div class="advSearch" id="advSearch" style="margin-top:40px;">
            <table width="826px">                  
                <tr>
                	<td style="color: #333333;font: 20px Arial,Helvetica,sans-serif;">Keep Track Of Your Sharing</td>
                    <td align="right">
        	 Total Earnings:  <span class="hong"> ¥ <?php echo number_format($sumMoney, 2, '.', ',');?></span>
                    </td>
                </tr>
                <tr class="itemLineBg818" style="height:5px;"><td colspan="2"></td></tr>
            </table>  
        </div>          
     <div class="rechargeHistroy">
		<?php if(!empty($this->_tpl_vars['lists']["data"])):?>
				<table width="826px" style="table-layout:fixed;word-wrap:break-word;">
					<tr style="border-bottom:2px solid #ccc;height:40px;color:#333;">
						<td width="230px" align="center">Date</td>
						<td width="230px" align="center">Email</td>
						<td align="center" width="240px">Status</td>
                        <td></td>
					</tr>
			<?php foreach($this->_tpl_vars['lists']["data"] as $k => $v){ ?>
                        <tr style="border-bottom:1px solid #ddd;">
                            <td>
                                <?php echo date("Y-m-d H:i",$v['submitTime']);?>
                            </td>
                            <td align="center">
                                <?php echo $v['inviteEmail'];?>  	
                            </td>
                            <td align="center">
                            	<?php
									switch($v["status"]){
										case '1':
											echo 'No Response';
										break;
										case '2':
											echo 'Join';
										break;
										case '3':
											echo $v['inviteMoney']."RMB";
										break;										
									}
								?>
                            </td>
                            <td align="center"><?php if($v["status"] == 1):?>
								<a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=friendInviteSave&inviteEmail='.$v['inviteEmail']));?>">Invite again</a>
							<?php endif;?></td>
                        </tr>
                        
				<?php }?>
				</table>
			<?php echo runFunc("phoneOrderPageNavi",array("account","friendInvite",$result_count,$rowsPerPage,$page));?>
		<?php else: ?>
				<p style="padding:10px;text-align:center;margin-top:30px;">There are no records in your recharge history.</p>
		<?php endif;?>
        </div>             
        </div>         

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