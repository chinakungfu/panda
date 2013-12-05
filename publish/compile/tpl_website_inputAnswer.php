<?php import('core.util.RunFunc'); ?>
<?php
$email = trim($this->_tpl_vars["IN"]["passwordEmail"]);
?>
<?php if ($this->_tpl_vars["IN"]["alertStr"]==1){
	//这是在验证问题出错是返回
	header("Location: ".runFunc('encrypt_url',array('action=website&method=notice&link_action=website&link_method=forgetPassword&alert_title=Answer is incorrect&alert_content=Your answer is incorrect,please try again')));
} elseif ($this->_tpl_vars["IN"]["alertStr"]==2){
	header("Location: ".runFunc('encrypt_url',array('action=website&method=notice&link_action=website&link_method=forgetPassword&alert_title=Answer is incorrect&alert_content=Your answer is incorrect,please try again'))); } 
?>

<?php if ($email != ''){?>

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
<script src="/skin/js/formValidator/formValidator-4.1.3.js"></script>
<script src="/skin/js/formValidator/formValidatorRegex.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({formID:"answer_form",theme:"answer",submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			//alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#answer").formValidator({onShowText:"Type Your Answer"}).inputValidator({min:2,onError: "Please Enter Your Answer"});
});
</script>			
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

				<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);?>
 <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "userInfo",
	'query' => "SELECT * FROM cms_member_staff where email = '".$email."'",
 ); 

	$this->_tpl_vars['userInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
	//print_r($this->_tpl_vars["userInfo"]["data"]);
?>
<?php if ($this->_tpl_vars["userInfo"]["data"][0]['staffId']){?>
  
				<form method="POST" action="" id="answer_form">
					<input type="hidden" name="userId" value="<?php echo $this->_tpl_vars["userInfo"]["data"]["0"]["staffId"];?>">
					<input type="hidden" name="safetyQuestion" value="<?php echo $this->_tpl_vars["userInfo"]["data"]["0"]["safetyQuestion"];?>">
					<input type="hidden" name="action" value="website">
					<input type="hidden" name="method" value="resetPassword">
					<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["IN"]["action"];?>&method=<?php echo $this->_tpl_vars["IN"]["method"];?>&passwordEmail=<?php echo $this->_tpl_vars["IN"]["passwordEmail"];?>">
				<div class="content">
                     <div class="resetpwd">
                        <div class="resetpwdtitle">
                            <h1>WELCOME TO WOWshopping</h1>
                            <h2>FIND YOUR PASSWORD</h2>
                            <h3>Step2:Security Question</h3>
                        </div>
                    </div>                   
                
                
                    <div class="requestpassword">
                        <h2>Please answer the following with the information you provided when originally registering.
    After answering correctly, you will receive an e-mail with your password.</h2>
                        
     					  <div class="safetyQuestion"><?php echo $this->_tpl_vars["userInfo"]["data"]["0"]["safetyQuestion"];?></div>
                          <input class="required" style="margin-top:20px;margin-bottom:15px;width:259px;height:39px;border:0;font:normal 16px Arial, Helvetica, sans-serif; padding-left:5px;" type="text" class="passwordEmail" id="answer" name="answer"/>
                          <div style="height:28px;" id="answerTip"></div>
                          <input type="submit" value="SUBMIT" class="submitEmailBtn"/>
    
      
                      </div>   
		   	   </div>
		    </form>
				
				<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

				
			

	<?php }else{ ?>
		<script>alert('Not a valid e-mail address.');location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=forgetPassword'));?>"</script>
	<?php } ?>
    	</div>
		</body>
	</html>
<?php }else{ ?>
	<script>alert('Please input Email address.');location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=forgetPassword'));?>"</script>
<?php } ?>