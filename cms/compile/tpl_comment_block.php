<?php
import('core.util.RunFunc');


runFunc("commentBlock",array($this->_tpl_vars["IN"]["id"]));

runFunc("memberMessageBlockMail",array("Comment",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=comment_show&id='.$this->_tpl_vars["IN"]["id"].'&type=share')));