<?php

import('core.util.RunFunc');


runFunc("adminCommentBlock",array($this->_tpl_vars["IN"]["id"]));


runFunc("memberMessageBlockMail",array("Comment",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_post_show&id='.$this->_tpl_vars["IN"]["circle_post_id"].'&type=share&comment_id='.$this->_tpl_vars["IN"]["comment_id"])));
