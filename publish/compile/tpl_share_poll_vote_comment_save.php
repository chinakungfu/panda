<?php
import('core.util.RunFunc');

if(trim($this->_tpl_vars["IN"]["comment"])!=""){

	$vote = array(
			"comment" => $this->_tpl_vars["IN"]["comment"]
	);


	runFunc("addCommentToVote",array($vote,$this->_tpl_vars["IN"]["id"]));
	
	
	$items = runFunc("getVotePollByVoteId",array($this->_tpl_vars["IN"]["id"]));
	
	
	$html = '<div class="poll_vote_comment_contain oh first_poll_comment">';
	$html .= '<div class="poll_voter_info fl">';
	$user_info = runFunc("getShareMemberInfoAllInOne",array($items[0]["user_id"]));
	$html .= '<a href='.runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$items[0]["user_id"])).'>';
	$avatar = "../publish/avatar/".$user_info[0]["user_id"]."_thumb.".$user_info[0]["headImageUrl"];
	if(file_exists($avatar)){
	$html .= '<img id="userimg" class="fl" src="'.$avatar.'" alt="" />';
	}else{
		
	$html .= '<img id="userimg" class="fl" src="../skin/images/pic.jpg" />';
	}
	$html .= '</a>';
	$html .= '<div class="poll_voter_detail fl">';					
	$html .= '<a href="'.runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$items[0]["user_id"])).'">';
	if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
	if($user_info[0]["first_name"]!=""){$html .= $user_info[0]["first_name"]."&nbsp;";} $html .= trim($user_info[0]["last_name"]);
	elseif($user_info[0]["show_nick"]==1):
	$html .=$user_info["0"]["staffName"];
	else: $html .= $user_info["0"]["staffNo"];
	endif;
	$html .= '</a>';
	$html .= '<div style="font-size: 11px; line-height: 14px;">';
	$days = abs(strtotime(date("Y-m-d",strtotime($items[0]["created"]))) - strtotime(date("Y-m-d")))/86400;
	$html .= 'at '.date("g:i a",strtotime($items[0]["created"]))."<br />";
	if ($days ==0){$html .= "Today";}else{$html .= $days." days ago";}							
	$html .= '</div></div></div><div class="poll_vote_comment_text fl">';
	$html .=$items[0]["comment"];
	$html .= '</div>';
	$html .= '</div>';

	$items[0]["comment_box_html"] = $html;
							
	echo json_encode($items);
	
}