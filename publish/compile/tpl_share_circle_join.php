<?php

import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());


$id = $this->_tpl_vars["IN"]["id"];

$check = runFunc("checkJoin",array($id,$this->_tpl_vars["name"]));
if(count($check)>0){
	
	exit;
}



runFunc("joinCircle",array($id,$this->_tpl_vars["name"]));

$circle_info = runFunc("getCircleById",array($id));

runFunc("sendSiteMessage",array($circle_info[0]["user_id"],$this->_tpl_vars["name"],"CIRCLE JOIN",$id));

$member_count = runFunc("getCircleMember",array($id,1,true));

$members = runFunc("getCircleMember",array($id,100));
$user_info = runFunc("getShareMemberInfoAllInOne",array($circle_info[0]["user_id"]));
$html ="";
foreach($members as $member):
	if($member["user_id"] == $user_info[0]["user_id"] or $member[staffName]=="")continue;
			$html .='<div class="circle_member_box oh">';
			$html .='<a href="'.runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$member["user_id"])).'">';
			$avatar = "../publish/avatar/".$member["user_id"]."_thumb.".$member["headImageUrl"];
			if(file_exists($avatar)){
			$html .= '<img id="userimg" class="fl" src="'.$avatar.'" alt="" />';
			}else{
				$html .= '<img id="userimg" class="fl" src="../skin/images/pic.jpg" />';
			}
				$html .= '</a>';
			$html .= '<div class="circle_member_name fl">';
			$html .= '<a href="'.runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$member["user_id"])).'">';	
			$user_info = runFunc("getShareMemberInfoAllInOne",array($member["user_id"]));				
			if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
			if($user_info[0]["first_name"]!=""){$html .=  $user_info[0]["first_name"]."&nbsp;";} $html .=  trim($user_info[0]["last_name"]);
			elseif($user_info[0]["show_nick"]==1):
				$html .=  $user_info["0"]["staffName"];
			else:
				$html .=  $user_info["0"]["staffNo"];
			endif;
			
					$html .= '</a></div></div>';

			endforeach;

$json = array(
	"count" => $member_count[0]["count"],
	"members_html" => $html
);


echo json_encode($json);