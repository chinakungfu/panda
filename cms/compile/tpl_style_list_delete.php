<?php
import('core.util.RunFunc');

runFunc("adminstyleListDelete",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=style_list&type=share')));