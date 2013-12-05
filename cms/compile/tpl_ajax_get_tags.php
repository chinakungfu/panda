<?php 
import('core.util.RunFunc'); 


$cat_id = $this->_tpl_vars["IN"]["cat_id"];

$result = runFunc("getTagsByCatId",array($cat_id));


echo json_encode($result);
