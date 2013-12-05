<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
$mail_last = "";
$mail_array = $_POST["buyer_mail"];
foreach($mail_array as $key=>$mail){
	$mail_array[$key] = trim($mail);
}

$mail_str = implode(",", array_unique($mail_array));
print_r($_POST);
$group_buy_item = array(

	"goods_id"=>$this->_tpl_vars["IN"]["group_item_id"],
	"item_name"=>$this->_tpl_vars["IN"]["group_buy_item_name"],
	"user_id"=>$this->_tpl_vars["name"],
	"send_mail"=>$mail_str,
	"description"=>nl2br($this->_tpl_vars["IN"]["group_buy_description"]),
	"only_friend_can_see"=>$this->_tpl_vars["IN"]["only_friend_can_see"],
	"price_rate"=>"0.8",
	"sell_way"=>"1",
);

runFunc("saveGroupBuy",array($group_buy_item));


$success_content = "You group buy is submitted successfully.Please wait for us checking your group buy!";
header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Submit successfully&alert_content='.$success_content.'&link_action=website&link_method=account')));
