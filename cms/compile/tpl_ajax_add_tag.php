<?php
import('core.util.RunFunc');


$cat_id = $this->_tpl_vars["IN"]["cat_id"];

$title = $this->_tpl_vars["IN"]["title"];

$id = runFunc("adminSaveTags",array(array("title"=>$title,"cat_id"=>$cat_id,"published"=>1)));

$json = array(
			"title"=>$title,
			"id"=>$id
		);

echo json_encode($json);
