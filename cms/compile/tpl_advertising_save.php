<?php
import('core.util.RunFunc');

$dataArray = array();

$dataArray["title"] = $this->_tpl_vars["IN"]["title"];
$dataArray["position"] = $this->_tpl_vars["IN"]["position"];
$dataArray["type"] = $this->_tpl_vars["IN"]["type"];
$dataArray["title"] = $this->_tpl_vars["IN"]["title"];

$dataArray["publish"] = $this->_tpl_vars["IN"]["publish"];
if($this->_tpl_vars["IN"]["type"] == 2){
	$dataArray["content"] = $this->_tpl_vars["IN"]["content"];
}
$links = $_POST["link"];

if($this->_tpl_vars["IN"]["id"]==""){
	$dataArray["created"] = date("Y-m-d H:i:s");
	$id = runFunc("advertisingSave",array($dataArray));
	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("新增广告 ".$this->_tpl_vars["IN"]["title"],$uid));

}else{

	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("修改广告 ".$this->_tpl_vars["IN"]["title"],$uid));
	runFunc("advertisingUpdate",array($dataArray,$this->_tpl_vars["IN"]["id"]));
	$id = $this->_tpl_vars["IN"]["id"];
}




if($this->_tpl_vars["IN"]["type"] == 1){

	$pics = $_FILES["pic"];

	if($this->_tpl_vars["IN"]["id"]!=""){
		$adv_imgs = $_FILES["img_pic"];
		$img_links = $_POST["img_links"];
		foreach($adv_imgs["name"] as $key=>$adv_img){
			$imgArray = array();
			if($adv_img !=""){
				$adv_current_img = runFunc("getAdvertisingBannerById",array($key));
				
				$adv_current_img_src = "../adv_banners/".$adv_current_img[0]["img"];
				if(file_exists($adv_current_img_src)){
					
					unlink($adv_current_img_src);
				}

				$file = array();
				$file["name"] = $adv_img;
				$file["tmp_name"] = $adv_imgs["tmp_name"][$key];


				$imgArray["img"] = uploadAdvImg($file,$key);

			}
			$imgArray["link"] = $img_links[$key];
					
				runFunc('updateAdvertisingBanner',array($imgArray,$key));

			
		}
	}

	foreach($pics["name"] as $key=>$pname){
		if($pname !=""){
			$file = array();
			$file["name"] = $pname;
			$file["tmp_name"] = $pics["tmp_name"][$key];


			$imgArray = array(
			"img" =>uploadAdvImg($file,$key),
			"adv_id" => $id,
			"link" => $links[$key]
			);

			runFunc("advertisingBannerSave",array($imgArray));
		}
	}
}


header("Location:".runFunc('encrypt_url',array('action=cms&method=advertising_edit&id='.$id.'&type=media')));


function uploadAdvImg($file,$key){

	$pathinfo = pathinfo($file["name"]);
	$filename = time().$key;
	$ext = @$pathinfo['extension'];


	$uploadDirectory = "../adv_banners/";


	move_uploaded_file($file["tmp_name"],$uploadDirectory.$file["name"]);

	rename($uploadDirectory.$file["name"], $uploadDirectory . $filename . '.' . $ext);
	$name = $filename . '.' . $ext;



	return $name;
}
