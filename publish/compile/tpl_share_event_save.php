<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());



$name = $this->_tpl_vars["IN"]["file_name"];
if($name !=""){
$file = "../circle_event_img/".$this->_tpl_vars["name"]."/".$this->_tpl_vars["IN"]["file_name"].".".$this->_tpl_vars["IN"]["ext"];

runFunc('screen_shot',array($file,$file,$_POST["x1"],$_POST["x2"],$_POST["y1"],$_POST["y2"],$_POST["width"],$_POST["height"],"../circle_event_img/".$this->_tpl_vars["name"]."/".$name));
runFunc('screen_shot',array($file,$file,0,0,0,0,325,175,"../circle_event_img/".$this->_tpl_vars["name"]."/".$name,1));

}



	$dataArray["name"] = $this->_tpl_vars["IN"]["event_name"];
	$dataArray["organizers"] = $this->_tpl_vars["IN"]["event_organizers"];
	$dataArray["introduction"] = nl2br($this->_tpl_vars["IN"]["introduction"]);
	$dataArray["location"] = $this->_tpl_vars["IN"]["location"];
	$dataArray["map"] = $this->_tpl_vars["IN"]["map_location_num"];
	$dataArray["phone"] = $this->_tpl_vars["IN"]["phone"];
	$dataArray["email"] = $this->_tpl_vars["IN"]["email"];
	$dataArray["address"] = $this->_tpl_vars["IN"]["address"];
	$dataArray["circle_id"] = $this->_tpl_vars["IN"]["circle_id"];
	$dataArray["event_time_type"] = $this->_tpl_vars["IN"]["time_type"];
	$dataArray["event_pay"] = $this->_tpl_vars["IN"]["event_pay"];
	
	
$id = $this->_tpl_vars["IN"]["id"];

if($id ==""){
	$dataArray["img"] = $this->_tpl_vars["IN"]["file_name"].".".$this->_tpl_vars["IN"]["ext"];
	$dataArray["created"] = date("Y-m-d H:i:s");
	$dataArray["user_id"] = $this->_tpl_vars["name"];
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_event (".$str_field.") values (".$str_value.")";
	$event_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
	runFunc("sendFriendNotice",array($this->_tpl_vars["name"],"EVENT CREATE",$event_id));
	
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
	
	
	$sql = "update cms_share_event set $sql where id = '{$id}'";
	$event_id = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
	
	$event_id = $id;

}

runFunc("deleteEventTime",array($event_id));

switch ($dataArray["event_time_type"]){
	
		case 1:

			runFunc("saveEventTime",array($event_id,$this->_tpl_vars["IN"]["start_date_type_1"],$this->_tpl_vars["IN"]["start_date_type_1"],$this->_tpl_vars["IN"]["start_time_type_1"],$this->_tpl_vars["IN"]["end_time_type_1"],""));
			
			break;
		
		case 2: 
	
			runFunc("saveEventTime",array($event_id,$this->_tpl_vars["IN"]["start_date_type_2"],$this->_tpl_vars["IN"]["end_date_type_2"],$this->_tpl_vars["IN"]["start_time_type_2"],$this->_tpl_vars["IN"]["end_time_type_2"],""));
			
			break;
			
		case 3:
			
			$week_days = $_POST["week_days"];
			$week_day_str = implode(",", $week_days);
			runFunc("saveEventTime",array($event_id,$this->_tpl_vars["IN"]["start_date_type_3"],$this->_tpl_vars["IN"]["end_date_type_3"],$this->_tpl_vars["IN"]["start_time_type_3"],$this->_tpl_vars["IN"]["end_time_type_3"],$week_day_str));
			break;
			
		case 4:
			$start_dates = $_POST["start_date"];
			$start_times = $_POST["start_time"];
			$end_times = $_POST["end_time"];
			foreach ($start_dates as $key=>$start_date){
			if($start_date=="" or $start_times[$key]=="" or $end_times[$key]==""){
				continue;
			}
			runFunc("saveEventTime",array($event_id,$start_date,$start_date,$start_times[$key],$end_times[$key],""));
			}
			
			
			break;
	}




header("Location: ".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event_id)));



