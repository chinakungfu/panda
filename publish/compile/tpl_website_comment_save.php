<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
$this->_tpl_vars["name"]=runFunc('readSession',array());


$comment = $this->_tpl_vars["IN"]["comment"];
$user_id = $this->_tpl_vars["name"];
$about_id =  $this->_tpl_vars["IN"]["id"];
$reply = $this->_tpl_vars["IN"]["reply"];

$type = $this->_tpl_vars["IN"]["type"];

$id = runFunc("saveComment",array($user_id,$comment,$about_id,$reply,$type));

$comment = runFunc("getCommentById",array($id,$type));
$count = runFunc("getComment",array($about_id,$type,true));



	
switch ($type){
	
	case "LIST GOODS":
		
		$to = runFunc("getItemDetail",array($about_id,"normal"));
		$reply_info = runFunc("getCommentById",array($reply,$type));

		if($to[0]["user_id"] != $reply_info[0]["user_id"]){
			runFunc("sendSiteMessage",array($to[0]["user_id"],$user_id,"LIST GOODS COMMENT",$about_id,$this->_tpl_vars["IN"]["comment"]));
		}
		
		if($to[0]["user_id"] == $reply_info[0]["user_id"]){
			
			runFunc("sendSiteMessage",array($reply_info[0]["user_id"],$user_id,"LIST GOODS COMMENT REPLY",$about_id,$this->_tpl_vars["IN"]["comment"]));
		}
		
		if($reply != 0 and $to[0]["user_id"] != $reply_info[0]["user_id"]){
			
			runFunc("sendSiteMessage",array($reply_info[0]["user_id"],$user_id,"LIST GOODS COMMENT REPLY",$about_id,$this->_tpl_vars["IN"]["comment"]));
		}
		
		break;
	
	case "GOODS":
		if($reply != 0){
		$reply_info = runFunc("getCommentById",array($reply,$type));
		runFunc("sendSiteMessage",array($reply_info[0]["user_id"],$user_id,"GOODS COMMENT REPLY",$about_id,$this->_tpl_vars["IN"]["comment"]));
		}
		break;
		
	case "CIRCLE POST":
		
		$post = runFunc("getCirclePost",array($about_id));
		$circle = runFunc("getCircleById",array($post["circle_id"]));
		$reply_info = runFunc("getCommentById",array($reply,$type));

		if($reply ==0){
			
			runFunc("sendSiteMessage",array($circle[0]["user_id"],$user_id,"MY CIRCLE POST COMMENT",$about_id,$this->_tpl_vars["IN"]["comment"]));
			
			runFunc("sendSiteMessage",array($post["user_id"],$user_id,"CIRCLE POST COMMENT",$about_id,$this->_tpl_vars["IN"]["comment"]));
		}
		else{
			if($reply_info[0]["user_id"] != $circle[0]["user_id"]){
				runFunc("sendSiteMessage",array($circle[0]["user_id"],$user_id,"MY CIRCLE POST COMMENT",$about_id,$this->_tpl_vars["IN"]["comment"]));
			}
			
			if($post["user_id"] != $reply_info[0]["user_id"]){
				
				runFunc("sendSiteMessage",array($post["user_id"],$user_id,"CIRCLE POST COMMENT",$about_id,$this->_tpl_vars["IN"]["comment"]));
			}
			
			runFunc("sendSiteMessage",array($reply_info[0]["user_id"],$user_id,"CIRCLE POST COMMENT REPLY",$about_id,$this->_tpl_vars["IN"]["comment"]));
		}

		break;
	
	case "EVENT":
		
		$event = runFunc("getEvent",array($about_id));
		$reply_info = runFunc("getCommentById",array($reply,$type));
		
	if($reply ==0){
			
			runFunc("sendSiteMessage",array($event[0]["user_id"],$user_id,"MY EVENT COMMENT",$about_id,$this->_tpl_vars["IN"]["comment"]));
			
		}else{
			if($reply_info[0]["user_id"] != $event[0]["user_id"]){
				runFunc("sendSiteMessage",array($event[0]["user_id"],$user_id,"MY EVENT COMMENT",$about_id,$this->_tpl_vars["IN"]["comment"]));
			}
			
			runFunc("sendSiteMessage",array($reply_info[0]["user_id"],$user_id,"MY EVENT COMMENT REPLY",$about_id,$this->_tpl_vars["IN"]["comment"]));
		}
		break;
	
}

$json = $comment[0];

if($comment[0]["reply_to"]>0){
	$reply = runFunc("getCommentById",array($comment[0]["reply_to"],$type));
	$json["reply"] =  $reply[0];
}

$avatar = '../publish/avatar/'.$comment[0]["user_id"].'_thumb.'.$comment[0]["headImageUrl"];

$avatar_link = runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$comment[0]["user_id"]));

if(file_exists($avatar)){
		
	$json["avatar"] = $avatar."_40.jpg";
}else{
	
	$json["avatar"] = "../skin/images/pic.jpg";
}

$json["avatar_link"] = $avatar_link;

$json["count_comment"] = $count[0]["count"];

echo json_encode($json);


?>