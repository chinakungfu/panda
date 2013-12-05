<?php
import('core.util.RunFunc');


$items = $_POST["request_item_id"];
$message_id = $this->_tpl_vars["IN"]["message_id"];
$item_titles = $_POST["request_item_title"];
$reply =$this->_tpl_vars["IN"]["description"];
$items_table = "<tr>";

foreach($items as $key=>$item){
	
	if(count($items)>3 and (($key)%3)==0){
		$items_table .="</tr><tr>";
	}
	$goods = runFunc("getAdminGoodsById",array($item));
	if($item_titles[$key]!=""){
		$title = $item_titles[$key];
	}else{
		$title = $goods["goodsTitleCN"];
	}
	runFunc("saveHelpMessageItem",array($item,$title,$message_id));
	$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
	$items_table .= '<td><a href="'.$site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item."&show_type=collections&from=collections_page")).'"><img style="border: 1px solid #777777" width="150px;" src="'.$goods["goodsImgURL"].'"/></a><br/><div style="width:150px;margin:auto"><a style="color:#D54D4D;text-decoration:none" href="'.$site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item."&show_type=collections&from=collections_page")).'">'.$title.'</a></div><br/>￥'.number_format($goods["goodsUnitPrice"], 2, '.', ',').'</td>';
	
}

$items_table .= "</tr>";

$mailArray['userId'] =  $this->_tpl_vars["IN"]["user_id"];
$mailArray['REQUEST_ITEMS'] = $items_table;
$mailArray["REPLY"] = $reply;

runFunc('sendMail',array($mailArray,"request_answer"));

runFunc("updateHelpMessageReply",array($reply,$message_id));
$user_info = runFunc("getUser",array($this->_tpl_vars["IN"]["id"]));
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("回复 ".$user_info[0]["staffNo"] ."的咨询",$this->_tpl_vars["name"]));

header("Location: ".runFunc('encrypt_url',array('action=cms&method=adminHelpMessage&id='.$message_id.'&type=users')));
