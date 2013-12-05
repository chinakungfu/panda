<?php
import('core.util.RunFunc');


runFunc("styleListBackToList",array($this->_tpl_vars["IN"]["id"]));



header("Location:".runFunc('encrypt_url',array('action=cms&method=style_list_recycle&type=share')));