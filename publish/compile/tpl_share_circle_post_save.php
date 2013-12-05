<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());

$title = addslashes($this->_tpl_vars["IN"]["post_name"]);

$comment = nl2br($this->_tpl_vars["IN"]["comment"]);
$id = $this->_tpl_vars["IN"]["id"];
$dataArray["id"] = $this->_tpl_vars["IN"]["id"];
$dataArray["title"] = $this->_tpl_vars["IN"]["post_name"];
$dataArray["comment"] = $comment;
$dataArray["user_id"] = $this->_tpl_vars["name"];
$dataArray["circle_id"] = $this->_tpl_vars["IN"]["circle_id"];
$dataArray["created"] = date("Y-m-d H:i:s");

foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "replace into cms_share_circle_post (".$str_field.") values (".$str_value.")";
	$post_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

$circle_info = runFunc("getCircleById",array($dataArray["circle_id"]));

if($id !=""){
	runFunc("sendSiteMessage",array($circle_info[0]["user_id"],$this->_tpl_vars["name"],"CIRCLE POST UPDATE",$post_id,$comment));
}else{
	runFunc("sendSiteMessage",array($circle_info[0]["user_id"],$this->_tpl_vars["name"],"CIRCLE POST CREATE",$post_id,$comment));
}

if(isset($_POST["img_src"])){

	runFunc("deleteCirclePostImg",array($id));
	
	$img_titles = $_POST["img_title"];
	foreach($_POST["img_src"] as $key=>$img ){

	$imgArray["img"] = $img;
	$imgArray["post_id"] = $post_id;
	$imgArray["title"] = $img_titles[$key];
	$str_field = "";
	$str_value = "";
	foreach ($imgArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	
	$sql = "insert into cms_share_circle_post_img (".$str_field.") values (".$str_value.")";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$imgArray);

		
	}
}

header("Location: ".runFunc('encrypt_url',array('action=share&method=circlePage&id='.$dataArray["circle_id"])));
