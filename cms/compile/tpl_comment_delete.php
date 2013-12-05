<?php
import('core.util.RunFunc');

runFunc("adminCommentDelete",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=comment_list&type=share')));