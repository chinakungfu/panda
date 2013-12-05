<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');


$id = $this->_tpl_vars["IN"]["id"];

$group_buy = $this->_tpl_vars["IN"]["group_buy"];
$page = $this->_tpl_vars["IN"]["page"];
//$dataArray["no_freight"] = $this->_tpl_vars["IN"]["no_freight"];
$dataArray["goodsOthersTitle"] = $this->_tpl_vars["IN"]["item_others_title"];
$dataArray["goodsOthers"] = $this->_tpl_vars["IN"]["item_others"];
$dataArray["brand_id"] = $this->_tpl_vars["IN"]["brand_id"];
$dataArray["special"] = $this->_tpl_vars["IN"]["special"];
$dataArray["cat_id"] = $this->_tpl_vars["IN"]["cat_id"];
$dataArray["goodsTitleCN"] = $this->_tpl_vars["IN"]["title"];
$dataArray["goodsTitleEn"] = $this->_tpl_vars["IN"]["titleEN"];
$dataArray["goodsUnitPrice"] = $this->_tpl_vars["IN"]["price"];
$dataArray["goodsFreight"] = $this->_tpl_vars["IN"]["freight"];
$dataArray["goodsDesc"] = $this->_tpl_vars["IN"]["item_description"];
$dataArray["goodsIntro"] = $this->_tpl_vars["IN"]["item_intro"];
$dataArray["goodsDetail"] = $this->_tpl_vars["IN"]["item_detail"];
$dataArray["published"] = $this->_tpl_vars["IN"]["published"];
$dataArray["goodsType"] = "inside";
$dataArray["goodsStatus"] = "open";
$dataArray["other_image_title_1"] = $this->_tpl_vars["IN"]["other_image_title_1"];
$dataArray["other_image_title_2"] = $this->_tpl_vars["IN"]["other_image_title_2"];
$dataArray["other_image_title_3"] = $this->_tpl_vars["IN"]["other_image_title_3"];
$dataArray["other_image_title_4"] = $this->_tpl_vars["IN"]["other_image_title_4"];
$dataArray["other_image_title_5"] = $this->_tpl_vars["IN"]["other_image_title_5"];
$dataArray["goodsOriginalPrice"] = $this->_tpl_vars["IN"]["goodsOriginalPrice"];
$dataArray["show_link"] = $this->_tpl_vars["IN"]["show_link"];

$dataArray["goodsShopId"] = $this->_tpl_vars["IN"]["goodsShopId"];
$dataArray["goodsShopName"] = $this->_tpl_vars["IN"]["goodsShopName"];
$dataArray["goodsShopUrl"] = $this->_tpl_vars["IN"]["goodsShopUrl"];
$props = array();
$prop_attr_string_array = $_POST["prop_value"];



foreach($_POST["prop_title"] as $key=>$prop_title){
	if(trim($_POST["prop_title"]) == "" or trim($prop_attr_string_array[$key]) == ""){

		continue;
	}

	$prop_attr_array = explode(";", $prop_attr_string_array[$key]);
	$prop_attr_array_great = array();
	foreach($prop_attr_array as $prop_attr_item){
		if(trim($prop_attr_item)!=""){
			$prop_attr_array_great[] = $prop_attr_item;
		}
	}

	$props[][$prop_title] = $prop_attr_array_great;

}

$props_string = json_encode($props);

$dataArray["props"] = $props_string;
if($id !=""){
	$this->_tpl_vars["name"]=runFunc('readSession',array());

	$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);


runFunc("makeAdminLog",array("更新产品信息 ".$this->_tpl_vars["IN"]["title"],$this->_tpl_vars["name"]));
 	$sql = "update cms_publish_goods set $sql where goodsid = '{$id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	$result = $id;

}else{
	$this->_tpl_vars["name"]=runFunc('readSession',array());
	$dataArray["created"] = time();
	$dataArray["goodsAddUser"] = $this->_tpl_vars["name"];
	$dataArray["created"] = date("Y-m-d H:i:s");
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_publish_goods (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

	$this->_tpl_vars["name"]=runFunc('readSession',array());
	runFunc("makeAdminLog",array("新增产品 ".$this->_tpl_vars["IN"]["title"],$this->_tpl_vars["name"]));
}

$pro_id = $result;

$tags = $_POST["tags"];

if($id != ""){
		runFunc("deleteGoodsTags",array($id));
	}
if(count($tags)>0){
foreach($tags as $tag){

	runFunc("saveGoodsTags",array($result,$tag));
}
}


$custom_tags = $_POST["custom_tags"];
if($custom_tags != ""){
	$custom_tags_array = explode(";", $custom_tags);
	if(count($custom_tags_array)>0){
		foreach($custom_tags_array as $custom_tag){
			$tagArray = array("title"=>$custom_tag,"cat_id"=>99,"published"=>1);
			$custom_id = runFunc("makeGoodTags",array($tagArray));
			runFunc("saveGoodsTags",array($result,$custom_id));
		}
	}

}


$imgs = $_FILES["img"];
$img_num = "";

$other_imgs = $_FILES["other_image"];

foreach($other_imgs[name] as $other_key=>$other_img){

	if($other_img!=""){


	switch(check_file_type($other_imgs["tmp_name"][$other_key])){

	case "image/jpeg":
		$file_type = "jpg"; //jpeg file

		make_other_img($other_imgs["tmp_name"][$other_key],$result,$other_key+1,$file_type,70);
		make_other_img($other_imgs["tmp_name"][$other_key],$result,$other_key+1,$file_type,500);

	runFunc("updateGoodsOtherImg",array("other_image_".($other_key+1),"../goods_other_img/goods_".$result."_".($other_key+1).".".$file_type,$result));
	break;

	}
	}
}

foreach($imgs[name] as $key=>$img){


if($img !=""){

switch(check_file_type($imgs["tmp_name"][$key])){
	case "image/jpeg":
		$file_type = "jpg"; //jpeg file
		make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,600);
		make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,310);
		make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,100);
	if($key!=0){

		$img_num = $key;
	}
	$site_name = getglobalsettingByProduct('Site_Domain');
	runFunc("updateGoodsImg",array("goodsImgURL".$img_num,$site_name."/goods_img/goods_".$result."_".$key.".".$file_type,$result));
	break;
	case "image/gif":
		$file_type = "gif"; //gif file
		make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,600);
		make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,310);
		make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,100);
	if($key!=0){

		$img_num = $key;
	}
	$site_name = getglobalsettingByProduct('Site_Domain');
	runFunc("updateGoodsImg",array("goodsImgURL".$img_num,$site_name."/goods_img/goods_".$result."_".$key.".".$file_type,$result));
 	 break;
 	 case "image/png":
	 	 $file_type = "png"; //png file
	 	 make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,610);
	 	 make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,310);
		 make_product_img($imgs["tmp_name"][$key],$result,$key,$file_type,100);
	if($key!=0){

		$img_num = $key;
	}
	$site_name = getglobalsettingByProduct('Site_Domain');
	runFunc("updateGoodsImg",array("goodsImgURL".$img_num,$site_name."/goods_img/goods_".$result."_".$key.".".$file_type,$result));
 	 break;
	}
}
}


if($group_buy==1){

	header("Location: ".runFunc('encrypt_url',array('action=cms&method=groupBuyAdd&type=share&id='.$pro_id)));
}else{

header("Location: ".runFunc('encrypt_url',array('action=cms&method=product_list&type=products&page='.$page)));
}
function check_file_type($file){

	$detec=getimagesize($file);

	return $detec["mime"];

}

function make_product_img($filename,$id,$key,$file_type,$kp_width){


	list($width, $height) = getimagesize($filename);
	$newwidth = $kp_width;
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
			imagejpeg($thumb,"../goods_img/goods_".$id."_".$key.".jpg"."_".$kp_width."x".$kp_width.".jpg",100);
			break;

		case "png" :
			imagepng($thumb,"../goods_img/goods_".$id."_".$key.".png",100);
			break;

		case "gif" :
			imagegif($thumb,"../goods_img/goods_".$id."_".$key.".gif");
			break;

	}

	imagedestroy($thumb);
}

function make_other_img($filename,$id,$key,$file_type,$kp_height){


	list($width, $height) = getimagesize($filename);
	$newheight = $kp_height;
	$newwidth = $width * ($newheight/$height);

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
			imagejpeg($thumb,"../goods_other_img/goods_".$id."_".$key.".jpg"."_".$kp_height."x".$kp_height.".jpg",100);
			break;

		case "png" :
			imagepng($thumb,"../goods_other_img/goods_".$id."_".$key.".png",100);
			break;

		case "gif" :
			imagegif($thumb,"../goods_other_img/goods_".$id."_".$key.".gif");
			break;

	}

	imagedestroy($thumb);
}

function getglobalsettingByProduct($tplVar){


	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db("a0222211743", $con);

	$sql = "select * from cms_cms_tpl_vars where varName='".$tplVar."'";

	$result = mysql_query($sql);

	while ($row = mysql_fetch_array($result)){

		$value = $row['varValue'];
	}

	return $value;

}

?>
