<?php import('core.util.RunFunc');


$id = $this->_tpl_vars["IN"]["id"];

runFunc("deleteAdminHotBrandCategory",array($id));

header("Location: ".runFunc('encrypt_url',array('action=cms&method=hot_brand_category_list&type=products')));
