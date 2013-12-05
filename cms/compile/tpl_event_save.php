<?php

import('core.util.RunFunc');



if($this->_tpl_vars["IN"]["created"]==1){
	$dataArray["user_id"] = 99;
}else{

	$circle = runFunc("getAdminCircleById",array($this->_tpl_vars["IN"]["circle_id"]));

	$this->_tpl_vars["IN"]["circle_id"];
	$dataArray["user_id"] = $circle[0]["user_id"];


}



$dataArray["name"] = $this->_tpl_vars["IN"]["name"];
$dataArray["organizers"] = $this->_tpl_vars["IN"]["organizers"];
$dataArray["introduction"] = $this->_tpl_vars["IN"]["introduction"];
$dataArray["location"] = $this->_tpl_vars["IN"]["location"];
$dataArray["map"] = $this->_tpl_vars["IN"]["map_location_num"];
$dataArray["phone"] = $this->_tpl_vars["IN"]["phone"];
$dataArray["email"] = $this->_tpl_vars["IN"]["email"];
$dataArray["address"] = $this->_tpl_vars["IN"]["address"];
$dataArray["circle_id"] = $this->_tpl_vars["IN"]["circle_id"];
$dataArray["status"] = $this->_tpl_vars["IN"]["status"];
$dataArray["event_pay"] = $this->_tpl_vars["IN"]["event_pay"];
$dataArray["special"] = $this->_tpl_vars["IN"]["special"];
$dataArray["event_time_type"] = $this->_tpl_vars["IN"]["time_type"];
$dataArray["group_id"] = $this->_tpl_vars["IN"]["group_id"];
$dataArray["official"] = 1;
//$dataArray["out_link"] = $this->_tpl_vars["IN"]["out_link"];



$id = $this->_tpl_vars["IN"]["id"];

if($id ==""){

if($_FILES["event_img"]["name"]!=""){
	$dataArray["img"] = uploadEventImg($_FILES["event_img"],$dataArray["user_id"]);
}
if($_FILES["event_img_large"]["name"]!=""){
	$dataArray["large_img"] = uploadEventImg($_FILES["event_img_large"],$dataArray["user_id"],true);
}

	$dataArray["created"] = date("Y-m-d H:i:s");
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_event (".$str_field.") values (".$str_value.")";
	$event_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("发布官方活动 ".$this->_tpl_vars["IN"]["name"],$uid));
}else{
$event_old = runFunc("getAdminEvent",array($this->_tpl_vars["IN"]["id"]));
if($_FILES["event_img"]["name"]!=""){
	$dataArray["img"] = uploadEventImg($_FILES["event_img"],$dataArray["user_id"]);
}else{
	moveEventImg($event_old[0]["img"],$event_old[0]["user_id"],$dataArray["user_id"]);

}

if($_FILES["event_img_large"]["name"]!=""){
	$dataArray["large_img"] = uploadEventImg($_FILES["event_img_large"],$dataArray["user_id"],true);
}else{

	moveEventImg($event_old[0]["large_img"],$event_old[0]["user_id"],$dataArray["user_id"]);
}


	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);


	$sql = "update cms_share_event set $sql where id = '{$id}'";
	$event_id = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("修改官方活动 ".$this->_tpl_vars["IN"]["name"],$uid));

	$event_id = $id;

}


runFunc("deleteAdminEventTime",array($event_id));

switch ($dataArray["event_time_type"]){

		case 1:

			runFunc("saveAdminEventTime",array($event_id,$this->_tpl_vars["IN"]["start_date_type_1"],$this->_tpl_vars["IN"]["start_date_type_1"],$this->_tpl_vars["IN"]["start_time_type_1"],$this->_tpl_vars["IN"]["end_time_type_1"],""));


			break;

		case 2:

			runFunc("saveAdminEventTime",array($event_id,$this->_tpl_vars["IN"]["start_date_type_2"],$this->_tpl_vars["IN"]["end_date_type_2"],$this->_tpl_vars["IN"]["start_time_type_2"],$this->_tpl_vars["IN"]["end_time_type_2"],""));

			break;

		case 3:

			$week_days = $_POST["week_days"];
			$week_day_str = implode(",", $week_days);
			runFunc("saveAdminEventTime",array($event_id,$this->_tpl_vars["IN"]["start_date_type_3"],$this->_tpl_vars["IN"]["end_date_type_3"],$this->_tpl_vars["IN"]["start_time_type_3"],$this->_tpl_vars["IN"]["end_time_type_3"],$week_day_str));
			break;

		case 4:
			$start_dates = $_POST["start_date"];
			$start_times = $_POST["start_time"];
			$end_times = $_POST["end_time"];
			foreach ($start_dates as $key=>$start_date){
			if($start_date=="" or $start_times[$key]=="" or $end_times[$key]==""){
				continue;
			}
			runFunc("saveAdminEventTime",array($event_id,$start_date,$start_date,$start_times[$key],$end_times[$key],""));
			}


			break;
	}

function moveEventImg($file,$old_user,$user_id){


	if(!is_dir("../circle_event_img/".$user_id."/")){
		mkdir("../circle_event_img/".$user_id."/");
	}

	copy("../circle_event_img/".$old_user."/".$file, "../circle_event_img/".$user_id."/".$file);
	if($user_id != $old_user){
	unlink("../circle_event_img/".$old_user."/".$file);
	}


}


function uploadEventImg($file,$user_id,$large=false){

	$pathinfo = pathinfo($file["name"]);
	$filename = time();
	$ext = @$pathinfo['extension'];

	if(!is_dir("../circle_event_img/".$user_id)){
		mkdir("../circle_event_img/".$user_id);
	}

	$uploadDirectory = "../circle_event_img/".$user_id."/";


	move_uploaded_file($file["tmp_name"],$uploadDirectory.$file["name"]);

	if($large==false){
		rename($uploadDirectory.$file["name"], $uploadDirectory . $filename . '.' . $ext);
		$name = $filename . '.' . $ext;
	}
	else{
		rename($uploadDirectory.$file["name"], $uploadDirectory . "large_".$filename . '.' . $ext);
		$name = "large_".$filename . '.' . $ext;
	}



	return $name;
}


header("Location: ".runFunc('encrypt_url',array('action=cms&method=eventList&type=share')));