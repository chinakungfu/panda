<?php
import('core.util.RunFunc');

$hot_items = runFunc("getMemberVotedItem",array($this->_tpl_vars["IN"]["user_id"],$this->_tpl_vars["IN"]["page"],$this->_tpl_vars["IN"]["size"]));

$hot_html = array();

 foreach($hot_items as $key=>$hot_item):
 $html = '<div class="poll_result_single_box oh ';
 if($key == 0){$html.= "first_poll_result";}
 $html .= '">';
 $html .= '<div class="poll_result_single_img_box fl">';
 $html .= '<a target="_blank" href="'.runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$hot_item["goodsid"]."&show_type=collections&from=collections_page")).'">';
 $html .= '	<img src="'. $hot_item["goodsImgURL"].'_310x310.jpg" title="'.$hot_item["goodsTitleCN"].'" /></a></div>';
 $html .= '<div class="poll_result_single_detail fl">';		
 $html .= '<div class="poll_result_single_title">';
 if(trim($hot_item["title"])!=""){$hot_item["goodsTitleCN"] =  $hot_item["title"];}
 if(strlen($hot_item["goodsTitleCN"])> 15){
 	$current_item_name =  mb_substr($hot_item["goodsTitleCN"],0,15,'utf-8')."...";
 }else{
 	$current_item_name = $hot_item["goodsTitleCN"];
 }			

 $html .= $current_item_name;
 $html .= '</div><div class="poll_result_single_votes">';
 
 $html .='<img src="../skin/images/vote_small.png" alt="" /> <span id="poll_result_vote_count_'.$hot_item["id"].'">'. $hot_item["vote_count"].' Votes</span></div></div></div>';
 
 $hot_html[$key]["hot_html"] = $html;
 
endforeach;


echo json_encode($hot_html);
