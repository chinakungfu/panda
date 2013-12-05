<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());

$name = $this->_tpl_vars["IN"]["file_name"];
if($name !=""){
$file = "../circles_img/".$this->_tpl_vars["name"]."/".$this->_tpl_vars["IN"]["file_name"].".".$this->_tpl_vars["IN"]["ext"];

runFunc('screen_shot',array($file,$file,$_POST["x1"],$_POST["x2"],$_POST["y1"],$_POST["y2"],$_POST["width"],$_POST["height"],"../circles_img/".$this->_tpl_vars["name"]."/".$name));
runFunc('screen_shot',array($file,$file,0,0,0,0,180,180,"../circles_img/".$this->_tpl_vars["name"]."/".$name,1));
runFunc('screen_shot',array($file,$file,0,0,0,0,50,50,"../circles_img/".$this->_tpl_vars["name"]."/thumb_".$name,1));

}
//$tags = $_POST["tags"];


	$dataArray["name"] = $this->_tpl_vars["IN"]["circles_name"];
	$dataArray["introduction"] = $this->_tpl_vars["IN"]["introduction"];
	$dataArray["email"] = $this->_tpl_vars["IN"]["circles_email"];
	$dataArray["about"] = $this->_tpl_vars["IN"]["circle_about"];
	$dataArray["phone"] = $this->_tpl_vars["IN"]["circles_phone"];


$id = $this->_tpl_vars["IN"]["id"];

if($id ==""){
	$dataArray["img"] = $this->_tpl_vars["IN"]["file_name"].".".$this->_tpl_vars["IN"]["ext"];
	$dataArray["created"] = date("Y-m-d H:i:s");
	$dataArray["user_id"] = $this->_tpl_vars["name"];
	$dataArray["status"] = 1;
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_circle (".$str_field.") values (".$str_value.")";
	$circle = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
	runFunc("sendFriendNotice",array($this->_tpl_vars["name"],"CIRCLE CREATE",$circle));
}else{
	
	if($name !=""){
		$dataArray["img"] = $this->_tpl_vars["IN"]["file_name"].".".$this->_tpl_vars["IN"]["ext"];	
	}
	
	$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
	
	
	$sql = "update cms_share_circle set $sql where id = '{$id}'";
	$circle = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
	
	$circle = $id;

}
if($id==""){

	runFunc("joinCircle",array($circle,$this->_tpl_vars["name"]));
}

/*
runFunc("deleteAllCircleTag",array($circle));

foreach($tags as $tag){

	$sql = "insert into cms_share_circle_tag_xref (tag_id,circle_id) values('{$tag}','{$circle}')";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);
}
*/

header("Location: ".runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle)));



