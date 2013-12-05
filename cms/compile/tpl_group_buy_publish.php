<?php

import('core.util.RunFunc');

$id = $this->_tpl_vars["IN"]["id"];
if($this->_tpl_vars["IN"]["published"]!=""){
	$dataArray["published"] = $this->_tpl_vars["IN"]["published"];
}
$dataArray["item_name"] = $this->_tpl_vars["IN"]["group_buy_item_name"];
$dataArray["fine_print"] = $this->_tpl_vars["IN"]["fine_print"];
$dataArray["price_rate"] = $this->_tpl_vars["IN"]["price_rate"];
$dataArray["sell_way"] = $this->_tpl_vars["IN"]["sell_type"];
$dataArray["group_size"] = $this->_tpl_vars["IN"]["group_size"];
$dataArray["start_time"] = $this->_tpl_vars["IN"]["start_time"];
$dataArray["special"] = $this->_tpl_vars["IN"]["special"];
$dataArray["end_time"] = date("Y-m-d",strtotime(date("Y-m-d", strtotime($this->_tpl_vars["IN"]["start_time"])) . " +".$this->_tpl_vars["IN"]["lasted_days"]." days"));

$dataArray["description"] = $this->_tpl_vars["IN"]["introduction"];
$dataArray["offcial"] = $this->_tpl_vars["IN"]["offcial"];

if($this->_tpl_vars["IN"]["offcial"]==1){

	if($this->_tpl_vars["IN"]["group_id"]!=""){
$group_id = $this->_tpl_vars["IN"]["group_id"];
		$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);

		$sql = "update cms_share_group_buy set $sql where id = '{$group_id}'";

		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
		
		$uid=runFunc('readSession',array());
		runFunc("makeAdminLog",array("修改官方团购 ".$this->_tpl_vars["IN"]["item_name"],$uid));
		
		$gid = $group_id;
	}else{

	$dataArray["goods_id"] = $this->_tpl_vars["IN"]["id"];
	$dataArray["created"] = date("Y-m-d H:i:s");

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_group_buy (".$str_field.") values (".$str_value.")";
	$gid = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("发布官方团购 ".$this->_tpl_vars["IN"]["item_name"],$uid));
	}
	
	
	
	
	header("Location: ".runFunc('encrypt_url',array('action=cms&method=adminGroupBuyEdit&id='.$gid.'&type=share')));

}else{

	$dataArray["only_friend_can_see"] = $this->_tpl_vars["IN"]["only_friend_can_see"];

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_share_group_buy set $sql where id = '{$id}'";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
	if($this->_tpl_vars["IN"]["first_publish"]!=""){
		
		$group_buy_item = runFunc("getMemberGroupBuyItem",array($this->_tpl_vars["IN"]["id"]));
		$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
		$mailArray["GROUP_BUY_LINK"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$this->_tpl_vars["IN"]["id"]));
		$mailArray["MAIL_QUEUE"] = $group_buy_item[0]["send_mail"];
		$mailArray['userId'] =  $group_buy_item[0]["user_id"];
		
		
		runFunc('sendMail',array($mailArray,"member_group_buy"));
		
		runFunc("adminSendFriendNotice",array($group_buy_item[0]["user_id"],"GROUP BUY CREATE",$group_buy_item[0]["id"]));
		
		$uid=runFunc('readSession',array());
		runFunc("makeAdminLog",array("审核通过团购 ".$this->_tpl_vars["IN"]["item_name"],$uid));
	}else{
		$uid=runFunc('readSession',array());
		runFunc("makeAdminLog",array("修改团购信息 ".$this->_tpl_vars["IN"]["item_name"],$uid));
	}

	header("Location: ".runFunc('encrypt_url',array('action=cms&method=memeberGroupBuyShow&id='.$id.'&type=share')));

}