<?php

import('core.util.RunFunc');


runFunc("adminCommentBlock",array($this->_tpl_vars["IN"]["id"]));

runFunc("memberMessageBlockMail",array("Comment",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=event_show&id='.$this->_tpl_vars["IN"]["event_id"].'&type=share&comment_id='.$this->_tpl_vars["IN"]["comment_id"])));
