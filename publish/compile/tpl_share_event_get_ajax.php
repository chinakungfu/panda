<?php import('core.util.RunFunc');

$events = runFunc("getEventByCircleId",array($this->_tpl_vars["IN"]["event_id"],$this->_tpl_vars["IN"]["page"],$this->_tpl_vars["IN"]["size"]));


for ($i=0;$i<count($events);$i++){
	
	if( date("Y.m.d",strtotime($events[$i]["start"])) == date("Y.m.d",strtotime($events[$i]["end"])))
	{
		
		$events[$i]["start_to_end"] = date("Y.m.d",strtotime($events[$i]["start"]));
	}else{
		
		$events[$i]["start_to_end"] = date("Y.m.d",strtotime($events[$i]["start"]))."-".date("Y.m.d",strtotime($events[$i]["end"]));
	}
	
	if(strlen($events[$i]["name"])> 55){	
		$events[$i]["name"] =  mb_substr($events[$i]["name"],0,55,'utf-8')."...";
	}
	
	$events[$i]["event_link"] = runFunc('encrypt_url',array('action=share&method=eventShow&id='.$events[$i]["id"]));
	
}

echo json_encode($events);
?>
