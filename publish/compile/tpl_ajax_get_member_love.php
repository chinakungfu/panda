<?php import('core.util.RunFunc');


$loves = runFunc("getMemberListLove",array($this->_tpl_vars["IN"]["user_id"],$this->_tpl_vars["IN"]["type"],$this->_tpl_vars["IN"]["page"],$this->_tpl_vars["IN"]["size"]));

for($i=0;$i<count($loves);$i++){

	if(strlen($loves[$i]["title"])> 20){
		$loves[$i]["title"] = mb_substr($loves[$i]["title"],0,20,'utf-8')."...";
	}
	
	$avatar_link = runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$loves[$i]["creater_id"]));
	
	$loves[$i]["avatar_link"] = $avatar_link;
	
	$loves[$i]["created"] = date("M d",strtotime($loves[$i]["created"]));
	
	$loves[$i]["link"] = runFunc('encrypt_url',array('action=share&method=showList&id='.$loves[$i]["id"].'&user_id='.$loves[$i]["creater_id"]));
	
	$item_info = runFunc("getMemberShareListItem",array($loves[$i]["id"]),1);

	$loves[$i]["img"] = $item_info[0]["goodsImgURL"];
	
	
}

echo json_encode($loves);
?>
