<?php import('core.util.RunFunc');session_start();
$this->_tpl_vars["name"]=runFunc('readSession',array());
if($this->_tpl_vars["name"]!=""){
	header("Location:".runFunc('encrypt_url',array('action=shop&method=shopindex')));
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
	$.formValidator.initConfig({formID:"regForm",theme:"reguser",submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			//alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#userEmail").formValidator({onShowText:" Email Address",onShow:"",onFocus:"",onCorrect:""}).inputValidator({min:6,max:50,onError:"Invalid email address"}).regexValidator({regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onError:"Incorrect email address"})	.ajaxValidator({
		dataType : "json",
		async : true,
		url : "/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerAjaxValidator'));?>&type=userEmail",
		success : function(data){
			$("#errorlist").html(data);
			if(data == 0){
				return true;
			}else{
				return false;
			}
		},
		buttons: $("#reg_submit"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "Your email is already registered.",
		onWait : ""
	});
	$("#userName").formValidator({onShowText:" Username",onShow:"",onFocus:"3~30 characters",onCorrect:""}).inputValidator({min:3,max:30,onError:"Invalid username, please check."}).regexValidator({regExp:"notempty",dataType:"enum",onError:"Incorrect username, please check."})
	    .ajaxValidator({
		dataType : "json",
		async : true,
		url : "/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerAjaxValidator'));?>&type=userName",
		success : function(data){
			if(data == 0){
				return true;
			}else{
				return false;
			}
		},
		buttons: $("#reg_submit"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "Your username is already in use.",
		onWait : ""
	});
	$("#password").formValidator({onShow:"",onFocus:"",onCorrect:""}).inputValidator({min:6,max:16,empty:{leftEmpty:false,rightEmpty:false,emptyError:"Your password can't have space."},onError:"6~16 characters"}).passwordValidator();
	$("#password").focus(function(){
		$("#pass_placeholder").hide();
	});
	$("#password").blur(function(){
		if($(this).val() == ''){
			$("#pass_placeholder").show();
		}
	});
	$("#pass_placeholder").click(function(){
		$("#password").focus();
		$(this).hide();
	});
	$("#questionResult").formValidator({onShowText:" Enter Your Answer",onShow:"",onFocus:"",onCorrect:""}).inputValidator({min:1,max:30,onError:"Please enter answer."});

	$("#select1").formValidator({onShow:"",onFocus:"",onCorrect:"",defaultValue:""}).inputValidator({min:1,onError: "Please select a question"});
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
		<!--<ul id="errorlist"></ul>-->
		<form action="/publish/index.php" method="post" id="regForm">
			<input type="hidden" name="action" value="website" />
			<input type="hidden" name="method" value="addRegUser" />
			<input type="hidden" name="backUrl" value="<?php echo runFunc('url2str',array($this->_tpl_vars["IN"]));?>" />
			<input type="hidden" name="signUpType" value="signUp" />
            <input type="hidden" name="inviteID" value="<?php echo $_SESSION['inviteID'];?>" />
			<div class="content">
				<div class="register">
                	<div class="regtitle">
                    	<h1>WELCOME TO WOWshopping</h1>
                        <h2>ACCOUNT REGISTRATION</h2>
                    </div>
                    <div class="regcont">
                    	<div class="regtab">
                            <table border="0" width="905px">
                                <tr>
                                  <td style="height:70px;width:320px; vertical-align:middle; "></td>
                                  <td style="height:70px; vertical-align:middle; text-align:right; overflow:hidden;width:260px;">

                                	<input name="userEmail" id="userEmail" type="text" style="width:260px;height:36px;"
									value="<?php echo $this->_tpl_vars["IN"]["staffNo"];?>" />
                                    </td>
                                   <td class="reg_info"><div id="userEmailTip"></div></td>
                                </tr>

                                <tr>
                                  <td></td>
                                  <td>
                                	<input name="userName" id="userName" type="text" style="width:260px;height:36px;"
									value="<?php echo $this->_tpl_vars["IN"]["userName"];?>" />
                                    </td>
                                  <td class="reg_info"><div id="userNameTip"></div></td>
                                </tr>

                                <tr>
                                <td><label class="placeholder" id="pass_placeholder">Password</label></td>
                                <td>
                                <input type="password" name="password" id="password" style="width:260px;height:36px;" value="" />
                                </td>
                                <td class="reg_info"><div id="passwordTip"></div></td>
                                </tr>

                                <tr>
                                <td></td>
                                <td>

								<select id="select1" name="safetyQuestion">
									<?php
									$inc_tpl_file=includeFunc(<<<LNMV
common/saftyQuestion.tpl
LNMV
									);
									include($inc_tpl_file);
									?>
								</select>
				      			</td>
                                <td class="reg_info"><div id="select1Tip"></div></td>
                                </tr>

								<tr>
                                    <td><label class="placeholder"></label></td>
                                    <td>
                                    <input type="text" name="questionResult" id="questionResult" style="width:260px;height:36px;"
                                        value="<?php echo $this->_tpl_vars["IN"]["questionResult"];?>" />
                                    </td>
                                    <td class="reg_info"><div id="questionResultTip"></div></td>
                                </tr>

                                <tr>
                                <td></td>
                                <td>
                                <button type="submit" name="regsubmit" class="reg_submit" id="reg_submit">Register</button>
                                <!--<a href="#" class="reg_submit">Register</a>-->
                                </td>
                                <td class="reg_info"></td></tr>

                                <tr>
                                    <td></td>
                                    <td><p style="line-height:28px;">By clicking Register, you agree to our <font color="#880808">Terms</font> and that you have read our <font color="#880808">Data Use Policy</font>.</p></td>
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
