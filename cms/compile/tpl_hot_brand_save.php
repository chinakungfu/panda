<?php 
import('core.util.RunFunc'); 
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');


$id = $this->_tpl_vars["IN"]["id"];


$dataArray["name"] = $this->_tpl_vars["IN"]["name"];

$dataArray["published"] = $this->_tpl_vars["IN"]["published"];

$dataArray["link"] = $this->_tpl_vars["IN"]["link"];

$dataArray["cat_id"] = $this->_tpl_vars["IN"]["cat_id"];

$logo = $_FILES["brand_logo"];

$file_type = $this->_tpl_vars["IN"]["file_type"];
if($logo["name"]!=""){
switch(check_file_type($logo["tmp_name"])){
	case "image/jpeg":
		$file_type = "jpg"; //jpeg file
	break;
	case "image/gif":
		$file_type = "gif"; //gif file
 	 break;
 	 case "image/png":
	 	 $file_type = "png"; //png file
 	 break;
	}
}

$dataArray["img"] = $file_type;
if($id ==""){
	$dataArray["created"] = date("Y-m-d H:i:s");
	
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_hot_brand (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
}else{
	
	
	$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);

		$sql = "update cms_hot_brand set $sql where id = '{$id}'";

		TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
		
		$result = $id;
}

if($logo["name"]!=""){
make_logo_img($logo["tmp_name"],$result,$file_type);
}

if($this->_tpl_vars["IN"]["id"] ==""){
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("新增商品热门品牌 ".$this->_tpl_vars["IN"]["name"],$this->_tpl_vars["name"]));
}else{
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("更新商品热门品牌 ".$this->_tpl_vars["IN"]["name"],$this->_tpl_vars["name"]));
}

header("Location: ".runFunc('encrypt_url',array('action=cms&method=hot_brand_list&type=products')));

function check_file_type($file){

	$detec=getimagesize($file);
	
	return $detec["mime"];
	
}

function make_logo_img($filename,$id,$file_type){
	
	
	list($width, $height) = getimagesize($filename);
	$newwidth = 75;
	$newheight = $height * ($newwidth/$width);
	
	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	
	switch ($file_type){
		
		case "jpg" :
			$source = imagecreatefromjpeg($filename);
			break;
		
		case "png" :
			$source = imagecreatefrompng($filename);
			break;
			
		case "gif" :
			$source = imagecreatefromgif($filename);
			break;
		
	}

	// Resize
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
	// Output
	switch ($file_type){
		
		case "jpg" :
			imagejpeg($thumb,"brand_logo/hot_brand_".$id.".jpg",100);
			break;
		
		case "png" :
			imagepng($thumb,"brand_logo/hot_brand_".$id.".png",100);
			break;
			
		case "gif" :
			imagegif($thumb,"brand_logo/hot_brand_".$id.".gif");
			break;
		
	}
	
	imagedestroy($thumb);
}


?>