<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());

$id = $this->_tpl_vars["IN"]["id"];

runFunc("eventDelete",array($id));

header("Location: ".runFunc('encrypt_url',array('action=share&method=eventMain')));