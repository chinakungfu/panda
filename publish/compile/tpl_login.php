<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
	if($this->_tpl_vars["name"] != ""){
		header("Location:index.php".runFunc('encrypt_url',array('action=website&method=index')));
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
	$.formValidator.initConfig({formID:"login_form",theme:"login",submitOnce:true,/*ajaxForm:{
              dataType : "html",
              buttons:$("#login_submit"),
              url: "/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerAjaxValidator'));?>&type=login",
			  success : function(result){alert(result);},
        },*/
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<span>" + msg + "</span>")
			});
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#staffNo").formValidator({onShowText:" Enter UserName or Email"}).regexValidator({regExp:"notempty",dataType:"enum",onError:"Username or email can not be empty."});
	$("#password").regexValidator({regExp:"notempty",dataType:"enum",onError:"Password can not be empty."});
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
	var passVal = $("#password").val();
	if(passVal != ''){
		$("#pass_placeholder").hide();
	}
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
			<div class="content">
                  <div class="login">
                    <div class="logintitle">
                        <h1>WELCOME TO WOWshopping</h1>
                    </div>
                  </div>
			    <div class="logintab">
                	<div id="errorlist" class="errorlist">
                    <h3 id="showLoginMessage">
					<?php if ($this->_tpl_vars["IN"]["alertStr"] == 2):?>
                    		Invalid username or incorrect password, please check again.
                    <?php elseif($this->_tpl_vars["IN"]["alertStr"] == 3):?>
                    		Invalid username or incorrect password, please check again.
                    <?php elseif($this->_tpl_vars["IN"]["alertStr"] == 4):?>
                    		Sorry,Your username haven't been verified, please go to your mail box to finish verification.
                    <?php elseif($this->_tpl_vars["IN"]["alertStr"] == 5):?>
							Your account has been blocked by WOWshopping, please contact our service.
					<?php endif; ?>
                    </h3>
					</div>
						<form action="/publish/index.php" method="post" id="login_form">
							<input type="hidden" name="action" value="website">
							<input type="hidden" name="method" value="CheckUser">
							<?php $this->_tpl_vars["paraUrl"]=unserialize($this->_tpl_vars["IN"]["paraStr"]); ?>
							<?php if ($this->_tpl_vars["IN"]["loginType"]=='normal'){?>
									<?php if($this->_tpl_vars["paraUrl"]["backMethod"] == "item_show" || $this->_tpl_vars["paraUrl"]["backMethod"] == "item_hotShow"):?>
                                   	 	<input type="hidden" name="backUrl" value="action=website&method=index">
                                    <?php else:?>
										<?php if(isset($this->_tpl_vars["paraUrl"]["backId"]) and isset($this->_tpl_vars["paraUrl"]["backUserId"])){?>
                                            <input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&id=<?php echo $this->_tpl_vars["paraUrl"]["backId"];?>&user_id=<?php echo $this->_tpl_vars["paraUrl"]["backUserId"];?>">
                                        <?php }else{?>
                                            <input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>">
                                        <?php }?>                                  
                                    <?php endif;?>

							<?php } elseif ($this->_tpl_vars["IN"]["loginType"]=='CartToWish'){ ?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>">
							<?php } elseif ($this->_tpl_vars["IN"]["loginType"]=='addWish'){ ?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&ItemQTY=<?php echo $this->_tpl_vars["paraUrl"]["ItemQTY"];?>&ItemGoodsID=<?php echo $this->_tpl_vars["paraUrl"]["ItemGoodsID"];?>&itemPrice=<?php echo $this->_tpl_vars["paraUrl"]["itemPrice"];?>&itemFreight=<?php echo $this->_tpl_vars["paraUrl"]["itemFreight"];?>&loginType=addWish">
							<?php } elseif ($this->_tpl_vars["IN"]["loginType"]=='OrderToWish'){ ?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&orderID=<?php echo $this->_tpl_vars["paraUrl"]["orderID"];?>">
							<?php } elseif ($this->_tpl_vars["IN"]["loginType"]=='cancelOrder'){ ?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&orderID=<?php echo $this->_tpl_vars["paraUrl"]["orderID"];?>">
							<?php } elseif ($this->_tpl_vars["IN"]["loginType"]=='addFriend'){ ?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&shareID=<?php echo $this->_tpl_vars["paraUrl"]["shareID"];?>&userId=<?php echo $this->_tpl_vars["paraUrl"]["userId"];?>">
							<?php } elseif ($this->_tpl_vars["IN"]["loginType"]=='addShareWish'){ ?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&ItemQTY=<?php echo $this->_tpl_vars["paraUrl"]["ItemQTY"];?>&ItemGoodsID=<?php echo $this->_tpl_vars["paraUrl"]["ItemGoodsID"];?>&shareID=<?php echo $this->_tpl_vars["paraUrl"]["shareID"];?>&itemPrice=<?php echo $this->_tpl_vars["paraUrl"]["itemPrice"];?>&itemFreight=<?php echo $this->_tpl_vars["paraUrl"]["itemFreight"];?>&loginType=addShareWish">
							<?php } elseif ($this->_tpl_vars["IN"]["loginType"]=='addFavorite'){ ?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&shareID=<?php echo $this->_tpl_vars["paraUrl"]["shareID"];?>">
							<?php }elseif($this->_tpl_vars["IN"]["loginType"]=='circle_page'){?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&id=<?php echo $this->_tpl_vars["paraUrl"]["backId"];?>">
							<?php }elseif($this->_tpl_vars["IN"]["loginType"]=='circlePost'){?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&id=<?php echo $this->_tpl_vars["paraUrl"]["backId"];?>&circle_id=<?php echo $this->_tpl_vars["paraUrl"]["circle_id"];?>">
							<?php }elseif($this->_tpl_vars["IN"]["loginType"]=='event_page'){?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&id=<?php echo $this->_tpl_vars["paraUrl"]["backId"];?>">
							<?php }elseif($this->_tpl_vars["IN"]["loginType"]=='addNewCart'){?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&id=<?php echo $this->_tpl_vars["paraUrl"]["backId"];?>&show_type=<?php echo $this->_tpl_vars["paraUrl"]["show_type"];?>&from=<?php echo $this->_tpl_vars["paraUrl"]["from"];?>">
							<?php }elseif($this->_tpl_vars["IN"]["loginType"]=='addCart'){?>
										<input type="hidden" name="backUrl" value="action=<?php echo $this->_tpl_vars["paraUrl"]["backAction"];?>&method=<?php echo $this->_tpl_vars["paraUrl"]["backMethod"];?>&id=<?php echo $this->_tpl_vars["paraUrl"]["backId"];?>&show_type=<?php echo $this->_tpl_vars["paraUrl"]["show_type"];?>&from=<?php echo $this->_tpl_vars["paraUrl"]["from"];?>">
							<?php }?>
                            <table border="0" width="905px">
                                <tr>
                                  <td style="height:70px;width:320px; vertical-align:middle; "></td>
                                  <td style="height:70px; vertical-align:middle; text-align:right; overflow:hidden;width:260px;">
    								<input type="text" name="staffNo" id="staffNo" style="width:260px;padding-left:5px;height:39px;width:259px; border:none;" />
                                   </td>
                                   <td class="reg_info"><div id="staffNoTip"></div></td>
                                </tr>
                                <tr>
                                  <td><label class="placeholder" id="pass_placeholder">Password</label></td>
                                  <td style="height:70px; vertical-align:middle; text-align:right; overflow:hidden;width:260px;">
    								<input type="password" name="password" id="password" style="width:260px;padding-left:5px;height:39px;width:259px; border:none;" />
                                   </td>
                                   <td class="reg_info"><div id="passwordTip"></div></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td class="checkbox">
    								<input type="checkbox"><span>Keep me logged in</span>
                                   </td>
                                   <td></td>
                                </tr>
                               <tr>
                                <td></td>
                                <td class="addressSubmit">
                                <button type="submit" name="loginsubmit" class="login_submit" id="login_submit">Login</button>
                                <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=forgetPassword'));?>">Forget your password?</a>
                                </td>
                                <td class="reg_info"></td>
                               </tr>
                                 <tr>
                                  <td></td>
                                  <td class="joinNow">Not a member yet? <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerUser'));?>">Join now!</a></td>
                                   <td></td>
                                </tr>
                             </table>
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
	</body>
</html>