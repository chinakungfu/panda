<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());

if($this->_tpl_vars["name"]==""){
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=index')));
}

$password= $this->_tpl_vars["IN"]["recharge_gift_card"];

if(trim($password) == "" or $password == "GIFT CARD PASSWORD"){


	$success_content = "You gift card password is incorrect,please check it and try again.";
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge failure&alert_content='.$success_content.'&link_action=shop&link_method=recharge_with_gift_card')));

}else{

	$card = runFunc("giftCardCheck",array(trim($password)));

	if(count($card)>0 and $card[0]["status"]==1){

		
		$money =  $card[0]["money"];
		runFunc(addUserBalance,array($this->_tpl_vars["name"],$money));
		runFunc("usingGiftCard",array($this->_tpl_vars["name"],$card[0]["id"]));
		$user_info = runFunc('getStaffInfoById',array($this->_tpl_vars["name"]));	
		$mailArray['userId'] = $this->_tpl_vars["name"];
		
		$mailArray["P_BALANCE"] = $user_info[0]["balance"]-$money;
		$mailArray["BALANCE"] = $user_info[0]["balance"];
		
		runFunc("successRechargeOrder",array(4,$this->_tpl_vars["name"],$money));
		runFunc('sendMail',array($mailArray,"recharge_success"));
		$success_content = "Recharge  successful,please check your email ".$user_info[0]["email"]." about your account details. Thank you!
<br />For further questions, please contact wowshoppingservice@gmail.com";

	header("Location:/publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge successful&alert_content='.$success_content.'&link_action=share&link_method=homePage')));

	}else{

		$success_content = "You gift card password is incorrect or your gift card is already used,please check it and try again.";
		header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge failure&alert_content='.$success_content.'&link_action=shop&link_method=recharge_with_gift_card')));


	}

}
