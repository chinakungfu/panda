<?php
import('core.util.RunFunc');


	$data1Array["name"] = $this->_tpl_vars["IN"]["reply_name"];
	$data1Array["email"] = $this->_tpl_vars["IN"]["email"];
	$data1Array["content"] = $this->_tpl_vars["IN"]["description"];

$items = $_POST["request_item_id"];

	$data1Array["created"] = date("Y-m-d H:i:s");
	foreach ($data1Array as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_admin_request_mail (".$str_field.") values (".$str_value.")";
	$mail_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$data1Array);


$item_titles = $_POST["request_item_title"];
$reply =$this->_tpl_vars["IN"]["description"];

$items_table = "<tr>";

foreach($items as $key=>$item){
	$str_value = "";
	$str_field = "";
	if(count($items)>3 and (($key)%3)==0){
		$items_table .="</tr><tr>";
	}
	$goods = runFunc("getAdminGoodsById",array($item));
	if($item_titles[$key]!=""){
		$title = $item_titles[$key];
	}else{
		$title = $goods["goodsTitleCN"];
	}
	
	$dataArray["goods_id"] = $item;
	$dataArray["title"] = $title;
	$dataArray["mail_id"] = $mail_id;
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_admin_request_mail_item (".$str_field.") values (".$str_value.")";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
	
	$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
	$items_table .= '<td><a href="'.$site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item."&show_type=collections&from=collections_page")).'"><img style="border: 1px solid #777777" width="150px;" src="'.$goods["goodsImgURL"].'"/></a><br/><div style="width:150px;margin:auto"><a style="color:#D54D4D;text-decoration:none" href="'.$site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item."&show_type=collections&from=collections_page")).'">'.$title.'</a></div><br/>￥'.number_format($goods["goodsUnitPrice"], 2, '.', ',').'</td>';
	
}

$items_table .= "</tr>";

$mailArray['reply_name'] =  $this->_tpl_vars["IN"]["reply_name"];
$mailArray['REQUEST_ITEMS'] = $items_table;
$mailArray['reply_email'] = $this->_tpl_vars["IN"]["email"];


$mailArray["REPLY"] = $reply;

runFunc('sendMail',array($mailArray,"request_answer_by_admin"));

$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("回复 ".$this->_tpl_vars["IN"]["reply_name"] ."的咨询",$this->_tpl_vars["name"]));

header("Location: ".runFunc('encrypt_url',array('action=cms&method=admin_help_mail_show&id='.$mail_id.'&type=users')));
