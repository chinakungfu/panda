<?php
import('core.util.RunFunc');

switch($this->_tpl_vars["IN"]["type"]){

case "COMMENT":
		
		runFunc("adminCommentBlock",array($this->_tpl_vars["IN"]["about_id"]));
		
		runFunc("memberMessageBlockMail",array("Comment",$this->_tpl_vars["IN"]["about_id"]));

		break;
		
		case "VOTE COMMENT":
		
		runFunc("voteCommentBlock",array($this->_tpl_vars["IN"]["about_id"]));
		
		runFunc("memberMessageBlockMail",array("Poll Vote Comment",$this->_tpl_vars["IN"]["about_id"]));
		
		break;
}
runFunc("adminUpdateSpamStatus",array(1,$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=spam_show&id='.$this->_tpl_vars["IN"]["id"].'&type=share')));