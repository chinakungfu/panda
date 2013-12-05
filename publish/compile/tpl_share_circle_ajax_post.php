<?php import('core.util.RunFunc'); 

$comment = nl2br($this->_tpl_vars["IN"]["comment"]);
if(trim($comment)==""){
	echo "empty";
	exit;
}
$circle_id = $this->_tpl_vars["IN"]["circle_id"];
$post_user_id = $this->_tpl_vars["IN"]["post_user_id"];

$circle_info = runFunc("getCircleById",array($circle_id));
$user_id = $circle_info[0]["user_id"];

$created = date("Y-m-d H:i:s");
$title = "Quick post";

//$sql = "insert into cms_share_circle_post (title,comment,user_id,circle_id,created) values('{$title}','{$comment}','{$post_user_id}','{$circle_id}','{$created}')";
$nodeId = runFunc('getGlobalModelVar',array('shareNode'));
$dataArray["title"] = $title;
$dataArray["comment"] = $comment;
$dataArray["user_id"] = $post_user_id;
$dataArray["circle_id"] = $circle_id;
$dataArray["created"] = $created;

foreach ($dataArray as $key => $val)
{
	$str_field .= $key.",";
	$str_value .= ":".$key.",";
}
$str_field = substr($str_field,0,-1);
$str_value = substr($str_value,0,-1);
$sql = "insert into cms_share_circle_post (".$str_field.") values (".$str_value.")";
$post_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

//$post_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);
runFunc("sendSiteMessage",array($circle_info[0]["user_id"],$post_user_id,"CIRCLE POST CREATE",$post_id,$comment));

$post = runFunc("getCirclePost",array($post_id));

$html .='<div class="circle_page_post_box">';
	$html .='<div class="circle_page_post_box_top oh">';
	
	$html .='<div class="circle_page_post_title_box fl">';
	$html .= '<a class="circle_post_title" href="'.runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post_id.'&circle_id='.$circle_id)).'">'.$post["title"].'</a>';
	$html .= '</div>';
	if($post_user_id == $post["user_id"]){
		
		$html .= '<div class="post_ctrl_bar fr">';		
		$html .= '<a class="post_ctrl_bar_editor" href='.runFunc('encrypt_url',array('action=share&method=circlePostEdit&id='.$post_id.'&circle_id='.$circle_id)).'"></a>';
		$html .= '<a id="'.$post["id"].'" onClick="delete_post(this)" class="post_ctrl_bar_delete"></a>';
		$html .= '</div>';
		
	}
	
	$html .= '</div>';
	

		$html .='<div class="circle_post_content circle_only_text">';
	 			if(strlen($post["comment"])> 250){	
					$html .= mb_substr($post["comment"],0,250,'utf-8')."...";
				}else{
					$html .= stripslashes($post["comment"]);
				}
	 	$html .= '</div>';
		
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
				$comment_count = runFunc("getComment",array($post_id,"CIRCLE POST",true));
		$html .= $comment_count[0]["count"].' Comments';

		$html .='</div></div>';
	
	$html .= '</div>';
	
	
	echo $html;