<?php
import('core.util.RunFunc');



runFunc("groupBuyRefuse",array($this->_tpl_vars["IN"]["group_id"]));

$group_buy_item = runFunc("getMemberGroupBuyItem",array($this->_tpl_vars["IN"]["group_id"]));

$mailArray['userId'] =  $group_buy_item[0]["user_id"];

if($this->_tpl_vars["IN"]["refuse"]==0){

runFunc('sendMail',array($mailArray,"member_group_buy_refuse"));

}

header("Location: ".runFunc('encrypt_url',array('action=cms&method=memeberGroupBuyShow&id='.$this->_tpl_vars["IN"]["group_id"].'&type=share')));

