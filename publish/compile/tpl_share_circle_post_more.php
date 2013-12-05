<?php

import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());


$posts = runFunc("getCirclePostByCircleId",array($this->_tpl_vars["IN"]["id"],5,$this->_tpl_vars["IN"]["page"]));
$html = "";

if(count($posts)==0){
	
	echo 0;
	exit;
}

foreach ($posts as $key=>$post){

	$html .='<div class="circle_page_post_box">';
	$html .='<div class="circle_page_post_box_top oh">';
	
	$html .='<div class="circle_page_post_title_box fl">';
	$html .= '<a class="circle_post_title" href="'.runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$this->_tpl_vars["IN"]["id"])).'">'.$post["title"].'</a>';
	$html .= '</div>';
	if($this->_tpl_vars["name"] == $post["user_id"]){
		
		$html .= '<div class="post_ctrl_bar fr">';		
		$html .= '<a class="post_ctrl_bar_editor" href='.runFunc('encrypt_url',array('action=share&method=circlePostEdit&id='.$post["id"].'&circle_id='.$this->_tpl_vars["IN"]["id"])).'"></a>';
		$html .= '<a id="'.$post["id"].'" onClick="delete_post(this)" class="post_ctrl_bar_delete"></a>';
		$html .= '</div>';
		
	}
	
	$html .= '</div>';
	
	$imgs = runFunc("getPostImg",array($post["id"],3));
	if(count($imgs)>0){
		
		$html .= '<div class="circle_post_content"><table class=""><tr>';
		foreach($imgs as $img):
	 					$html .= '<td><a href="'.runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$this->_tpl_vars["IN"]["id"])).'" class="img_in_circle_post"><img src="../circle_post_img/'.$post["user_id"].'/'.'thumb_'.$img["img"].'" alt="" /></a></td>';
	 	endforeach;
		$html .= '</tr></table></div>';
	}else{
		$html .='<div class="circle_post_content circle_only_text">';
	 			if(strlen($post["comment"])> 250){	
					$html .= mb_substr($post["comment"],0,250,'utf-8')."...";
				}else{
					$html .= $post["comment"];
				}
	 	$html .= '</div>';
		
	}
		
		$html .= '<div class="circle_post_footer oh"><div class="post_created fl">';
					
		$html .= 'Post by: <a href="'.runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$post["user_id"])).'">';
		$user_info = runFunc("getShareMemberInfoAllInOne",array($post["user_id"]));
		if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
		if($user_info[0]["first_name"]!=""){$html .= $user_info[0]["first_name"]."&nbsp;";} $html .= trim($user_info[0]["last_name"]);
		elseif($user_info[0]["show_nick"]==1):
		$html .= $user_info["0"]["staffName"];
		else:
		$html .= $user_info["0"]["staffNo"];
		endif;
		$html .= '</a></div>';
				
		$html .= '<div class="post_comment_count fr">';
				$comment_count = runFunc("getComment",array($post["id"],"CIRCLE POST",true));
		$html .= $comment_count[0]["count"].' Comments';

		$html .='</div></div>';
	
	$html .= '</div>';
}

echo $html;




?>