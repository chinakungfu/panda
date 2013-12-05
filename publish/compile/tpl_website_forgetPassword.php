<?php import('core.util.RunFunc'); 
$this->_tpl_vars["user_id"]=runFunc('readSession',array());
if($this->_tpl_vars["user_id"]!=""){
	header("Location:".runFunc('encrypt_url',array('action=website&method=index')));
}
?>
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
	$.formValidator.initConfig({formID:"forgot_form",theme:"resetpwd",submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			//alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#passwordEmail").formValidator({onShowText:"Email Address",onCorrect:""}).regexValidator({regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onError:"Incorrect email address"}).ajaxValidator({
		dataType : "json",
		async : true,
		url : "/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerAjaxValidator'));?>&type=resetpwdEmail",
		success : function(data){
			//$("#errorlist").html(data);
			if(data == 0){
				return true;
			}else{
				return false;
			}
		},
		buttons: $("#resetpwd_submit"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "The email address does not exist",
		onWait : ""
	});
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
			
			
			<div class="content">

                <div class="resetpwd">
                    <div class="resetpwdtitle">
                        <h1>WELCOME TO WOWshopping</h1>
                        <h2>FIND YOUR PASSWORD</h2>
                        <h3>Step1:E-Mail Address</h3>
                    </div>
                </div>           
            	<!--<div id="errorlist"></div>-->
				<div class="requestpassword">
					<h2>To have your password e-mailed to you, please enter your e-mail address below,then click submit.</h2>
					<form  action="/publish/index.php" method="post" id="forgot_form">
						<input type="hidden" name="action" value="website">
						<input type="hidden" name="method" value="inputAnswer">
                        <input type="text" style="margin-top:40px;margin-bottom:15px;width:259px;height:39px;border:0;font:normal 16px Arial, Helvetica, sans-serif; padding-left:5px;"  name="passwordEmail" id="passwordEmail"/><div style="height:28px;" id="passwordEmailTip"></div>
                        <input type="submit" id="resetpwd_submit" value="SUBMIT" class="submitEmailBtn"/>

					</form>
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
<script type="text/javascript">
	$(function(){

		$("#forgot_form").validate({
			errorPlacement: function(error, element) {
        		}
			});


	});
</script>
	</body>
</html>