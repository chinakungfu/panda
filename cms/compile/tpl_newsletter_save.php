<?php
import('core.util.RunFunc');
include('../publish/appfunc/simple_html_dom.php');


$data1Array["title"] = $this->_tpl_vars["IN"]["letter_title"];
	
	$html_in = str_get_html($this->_tpl_vars["IN"]["description"]);
$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
	foreach($html_in->find("img") as $img){
		if(strpos($img->src,'wowshopping') !== false){
		 $img->src = $img->src;
		}else{
			 $img->src = $site_name.$img->src;
		}
	}
	$data1Array["content"] = $html_in;

if($this->_tpl_vars["IN"]["letter_id"]==""){
	$data1Array["created"] = date("Y-m-d H:i:s");
	foreach ($data1Array as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_newsletters (".$str_field.") values (".$str_value.")";
	$letter_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$data1Array);
}else{

	$sql = '';
	foreach ($data1Array as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_newsletters set $sql where id = '{$this->_tpl_vars["IN"]["letter_id"]}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$data1Array);
	
	$letter_id = $this->_tpl_vars["IN"]["letter_id"];
	
	$sql = "delete from cms_newsletters_item where letter_id = '{$letter_id}'";

	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	
}
$items = $_POST["request_item_id"];

$item_titles = $_POST["request_item_title"];

$items_table = "<tr>";

$request_item_original_price = $_POST["request_item_original_price"];

$request_item_price = $_POST["request_item_price"];
$request_item_url = $_POST["request_item_url"];
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
	$dataArray["price"] = $request_item_price[$key];
	$dataArray["original_price"] = $request_item_original_price[$key];
	$dataArray["letter_id"] = $letter_id;
	$dataArray["item_url"] = $request_item_url[$key];
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_newsletters_item (".$str_field.") values (".$str_value.")";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
	
	$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
	$items_table .= '<td style="vertical-align: top;"><a href="'.$dataArray["item_url"].'"><img width="150px;" style="border: 1px solid #777777;" src="'.$goods["goodsImgURL"].'_310x310.jpg"></a><br/><div style="width:150px;margin:auto;margin-top:10px;height: 32px; overflow: hidden;"><a style="color:#D54D4D;text-decoration:none" href="'.$dataArray["item_url"].'">'.$title.'</a></div><br/><font style="text-decoration: line-through;color:gray">￥'.number_format($dataArray["original_price"], 2, '.', ',').'</font><br/><font style="color:orange">￥'.number_format($dataArray["price"], 2, '.', ',').'</font><br><br></td>';
	
}

$items_table .= "</tr>";

if($this->_tpl_vars["IN"]["send"]==1){
	//$mailArray['mailto'] =  "";
	$mailArray["MAIL_TITLE"] =  $this->_tpl_vars["IN"]["letter_title"];
	$mailArray['REQUEST_ITEMS'] = $items_table;
	$mailArray["REPLY"] = $this->_tpl_vars["IN"]["description"];

runFunc('sendMail',array($mailArray,"newsletter_send"));
}




header("Location: ".runFunc('encrypt_url',array('action=cms&method=newsletter_edit&id='.$letter_id.'&type=media')));
