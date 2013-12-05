<?php 
import('core.util.RunFunc'); 


$prop_id = $this->_tpl_vars["IN"]["prop_id"];

$result = runFunc("getPropValues",array($prop_id));


echo json_encode($result);
