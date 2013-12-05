<?php
import('core.util.RunFunc');


runFunc("commentBackToList",array($this->_tpl_vars["IN"]["id"]));



header("Location:".runFunc('encrypt_url',array('action=cms&method=comment_recycle&type=share')));