<?php import('core.util.RunFunc'); 

$rechargeOrder = runFunc("getRechargeOrder",array($this->_tpl_vars["IN"]["orderID"]));

$user_id = $rechargeOrder[0]["user_id"];

$recharge = $rechargeOrder[0]["recharge"];

if($rechargeOrder[0]["status"] == 1){
	
//runFunc("updateRechargeOrderStatus",array($this->_tpl_vars["IN"]["orderID"]));

//runFunc("addUserBalance",array($user_id,$recharge));

$user_info = runFunc("getStaffInfoById",array($user_id));

$mailArray['userId'] = $user_id;


$mailArray["BALANCE"] = $user_info[0]["balance"];

//runFunc('sendMail',array($mailArray,"recharge_success"));

$success_content = "Recharge  successful,please check your email ".$user_info[0]["email"]." about your account details. Thank you!
<br />For further questions, please contact wowshoppingservice@gmail.com";

header("Location:/publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge successful&alert_content='.$success_content.'&link_action=share&link_method=homePage')));


}
else{

	header("Location:/publish/index.php".runFunc('encrypt_url',array('action=share&method=homePage')));
}


