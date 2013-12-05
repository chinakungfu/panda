<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());



$id = $this->_tpl_vars["IN"]["id"];

echo $link = $this->_tpl_vars["IN"]["link"];



runFunc("readMessage",array($id));

header("Location: ".runFunc('encrypt_url',array($link)));