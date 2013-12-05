<?php import('core.util.RunFunc');

$events = runFunc("getEventMyJoined",array($this->_tpl_vars["IN"]["user_id"],$this->_tpl_vars["IN"]["page"],$this->_tpl_vars["IN"]["size"]));


for ($i=0;$i<count($events);$i++){
$event_time = runFunc("getEventTime",array($events[$i]["id"]));
	switch ($events[$i]["event_time_type"]){

		case 1:
				
			$events[$i]["start_to_end"] = date("Y.m.d",strtotime($event_time["start_date"]));
				
			break;
				
		case 2:
				
			$events[$i]["start_to_end"] = date("Y.m.d",strtotime($event_time["start_date"]))." - ".date("Y.m.d",strtotime($event_time["end_date"]));
				
			break;
				
		case 3:
				
			$events[$i]["start_to_end"] = date("Y.m.d",strtotime($event_time["start_date"]))." - ".date("Y.m.d",strtotime($event_time["end_date"]));
				
			break;
				
		case 4:
				
			$kk = count($event_time)-1;
				
			$events[$i]["start_to_end"] = date("Y.m.d",strtotime($event_time["start_date"]))." - ".date("Y.m.d",strtotime($event_time["start_date"]));
				
			break;

	}
	if(strlen($events[$i]["name"])> 55){
		$events[$i]["name"] =  mb_substr($events[$i]["name"],0,55,'utf-8')."...";
	}

	$events[$i]["event_link"] = runFunc('encrypt_url',array('action=share&method=eventShow&id='.$events[$i]["id"]));

}

echo json_encode($events);
?>
