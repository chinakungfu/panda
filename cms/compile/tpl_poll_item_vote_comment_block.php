<?php

import('core.util.RunFunc');




runFunc("voteCommentBlock",array($this->_tpl_vars["IN"]["id"]));

runFunc("memberMessageBlockMail",array("Poll Vote Comment",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=poll_show&id='.$this->_tpl_vars["IN"]["poll_id"].'&type=share&good_id='.$this->_tpl_vars["IN"]["good_id"])));
