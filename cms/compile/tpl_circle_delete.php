<?php
import('core.util.RunFunc');

runFunc("adminCircleDelete",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_list&type=share')));