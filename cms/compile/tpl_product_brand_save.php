<?php 
import('core.util.RunFunc'); 
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');


$id = $this->_tpl_vars["IN"]["id"];

$dataArray["title"] = addslashes($this->_tpl_vars["IN"]["title"]);

$dataArray["intro"] = $this->_tpl_vars["IN"]["intro"];

$dataArray["special"] = $this->_tpl_vars["IN"]["special"];

$dataArray["published"] = $this->_tpl_vars["IN"]["published"];

$dataArray["publish_type"] = $this->_tpl_vars["IN"]["publish_type"];

$dataArray["description"] = addslashes($this->_tpl_vars["IN"]["description"]);

$dataArray["link"] = $this->_tpl_vars["IN"]["link"];

$dataArray["owner"] = $this->_tpl_vars["IN"]["owner"];

$dataArray["category_id"] = $this->_tpl_vars["IN"]["category_id"];

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

$dataArray["file_type"] = $file_type;
if($id ==""){

	
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_product_brand (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
}else{
	
	
	$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);

		$sql = "update cms_product_brand set $sql where id = '{$id}'";

		TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
		
		$result = $id;
}


if($logo["name"]!=""){
make_logo_img($logo["tmp_name"],$result,$file_type);
}


$tags = $_POST["tags"];


if($id != ""){
		runFunc("deleteBrandTags",array($id));
	}
if(count($tags)>0){
foreach($tags as $tag){

	runFunc("saveBrandTags",array($result,$tag));
}
}

if($this->_tpl_vars["IN"]["id"] ==""){
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("新增商品品牌  ".$title,$this->_tpl_vars["name"]));
}else{
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("更新商品品牌  ".$title,$this->_tpl_vars["name"]));
}
header("Location: ".runFunc('encrypt_url',array('action=cms&method=brands&type=products')));

function check_file_type($file){

	$detec=getimagesize($file);
	
	return $detec["mime"];
	
}

function make_logo_img($filename,$id,$file_type){
	
	
	list($width, $height) = getimagesize($filename);
	$newwidth = 288;
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
			imagejpeg($thumb,"brand_logo/brand_".$id.".jpg",100);
			break;
		
		case "png" :
			imagepng($thumb,"brand_logo/brand_".$id.".png",100);
			break;
			
		case "gif" :
			imagegif($thumb,"brand_logo/brand_".$id.".gif");
			break;
		
	}
	
	imagedestroy($thumb);
}


?>
