<?php

import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());


$id = $this->_tpl_vars["IN"]["id"];

$result = runFunc("deleteCirclePost",array($id,$this->_tpl_vars["name"]));

runFunc("deleteCirclePostComment",array($id));


$json = array(

	"result" => $result
);

echo json_encode($json);