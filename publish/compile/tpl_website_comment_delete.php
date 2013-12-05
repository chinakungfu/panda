<?php import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());

runFunc("commentDelete",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["name"]));


$count = runFunc("getComment",array($this->_tpl_vars["IN"]["about_id"],$this->_tpl_vars["IN"]["type"],true));


$json = $count[0];

echo json_encode($json);

?>