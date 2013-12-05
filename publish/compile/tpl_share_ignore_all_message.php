<?php import('core.util.RunFunc');

$this->_tpl_vars["name"]=runFunc('readSession',array());

runFunc("ignore_all_message",array($this->_tpl_vars["name"]));

header("Location: ".runFunc('encrypt_url',array('action=share&method=messageAll')));