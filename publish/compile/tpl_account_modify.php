<?php import('core.util.RunFunc');
$this->_tpl_vars["name"]=runFunc('readSession',array());
if(!$this->_tpl_vars["name"]){
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
	$.formValidator.initConfig({formID:"reset_pwd",theme:"reguser",submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			//alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#oldPassword").formValidator({onShowText:"",onShow:"",onFocus:"",onCorrect:""}).inputValidator({min:6,max:16,empty:{leftEmpty:false,rightEmpty:false,emptyError:"Your password can't have space."},onError:"6~16 characters"});
		
	$("#newPassword").formValidator({onShowText:"",onShow:"",onFocus:"",onCorrect:""}).inputValidator({min:6,max:16,empty:{leftEmpty:false,rightEmpty:false,emptyError:"Your password can't have space."},onError:"6~16 characters"}).passwordValidator();
	$("#retypePassword").formValidator({onShowText:"",onShow:"",onFocus:"",onCorrect:""}).inputValidator({min:1,empty:{leftEmpty:false,rightEmpty:false,emptyError:"Your password can't have space."},onError:"6~16 characters"}).compareValidator({desID:"newPassword",operateor:"=",onError:"Passwords don't match. Try again?"});
		
	$("#questionResult").formValidator({onShowText:"",onShow:"",onFocus:"",onCorrect:""}).inputValidator({min:1,onError:"Please enter answer."});

	$(".resetPwdInput input").focus(function(){
		$(this).parent().prev().children(".placeholder").hide();
	});
	$(".resetPwdInput input").blur(function(){
		if($(this).val() == ''){
			$(this).parent().prev().children(".placeholder").show();
		}
	});	
  	$(".placeholder").click(function(){
        $(this).parent().next().children("input").focus();//使密码输入框获取焦点
        $(this).hide();//隐藏文本输入框
   	})
});
</script>
<style type="text/css">
.resetPwdInput input{
	width:260px;
	height:36px;
}
</style>
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
    <?php $user = runFunc("getStaffInfoById",array($this->_tpl_vars["name"]));?>
		<!--<ul id="errorlist"></ul>-->
		<form action="/publish/index.php" method="post" class="formAdd" id="reset_pwd">
			<input type="hidden" name="action" value="account">
			<input type="hidden" name="method" value="updatePassword">			
			<input type="hidden" name="para[staffId]" value="<?php echo $user["0"]["staffId"];?>">
			<input type="hidden" name="para[staffNo]" value="<?php echo $user["0"]["staffNo"];?>">
			<input type="hidden" name="para[safetyQuestion]" value="<?php echo $user["0"]["safetyQuestion"];?>">
			<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["IN"]["action"];?>&method=<?php echo $this->_tpl_vars["IN"]["method"];?>">
			<div class="content">
				<div class="register">
                	<div class="regtitle">
                    	<h1>WELCOME TO WOWshopping</h1>
                        <h2>CHANGE YOUR PASSWORD</h2>
                    </div>
                    <div class="regcont">
                        <div style="text-align:center;color:#a10000;">
                        <?php if ($this->_tpl_vars["IN"]["alertStr1"]){?>
                                <h3 id="showLoginMessage"><?php echo $this->_tpl_vars["IN"]["alertStr1"];?></h3>
                        <?php } ?>
                        </div>                   
                    	<div class="regtab">
                            <table border="0" width="905px">
                                <tr>
                                  <td style="height:70px;width:320px; vertical-align:middle; ">
                                  	<label class="placeholder">Old Password</label>
                                  </td>
                                  <td style="width:262px;" class="resetPwdInput">
									<input type="password"  id="oldPassword" name="para[oldPassword]" />
                                  </td>
                                  <td class="reg_info"><div id="oldPasswordTip"></div></td>
                                </tr>

                                <tr>
                                  <td><label class="placeholder">New Password</label></td>
                                  <td class="resetPwdInput">
                                	<input type="password" id="newPassword" class="resetPwdInput" name="para[newPassword]" />
                                    </td>
                                  <td class="reg_info"><div id="newPasswordTip"></div></td>
                                </tr>

                                <tr>
                                <td><label class="placeholder">Retype New Password</label></td>
                                <td class="resetPwdInput">
                                <input type="password" name="para[rePassword]" class="resetPwdInput" id="retypePassword" value="" />
                                </td>
                                <td class="reg_info"><div id="retypePasswordTip"></div></td>
                                </tr>

                                <tr>
                                <td></td>
                                <td>
                                	<p style="font:18px normal Arial, Helvetica, sans-serif;color:#333;">Security Answer:</p>
									<p style="font:18px normal Arial, Helvetica, sans-serif;color:#a10000;">&nbsp;&nbsp;&nbsp;<?php echo $user["0"]["safetyQuestion"];?></p>
				      			</td>
                                <td class="reg_info"></td>
                                </tr>

								<tr>
                                    <td><label class="placeholder">Type Your Answer</label></td>
                                    <td class="resetPwdInput">
                                    	<input type="text" name="para[questionResult]" class="resetPwdInput" id="questionResult" value="" />
                                    </td>
                                    <td class="reg_info"><div id="questionResultTip"></div></td>
                                </tr>                               
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" name="regsubmit" class="reg_submit" id="reset_submit">submit</button>
                                    <!--<a href="#" class="reg_submit">Register</a>-->
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
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

	</div>
</body>
</html>
