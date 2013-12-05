<?php import('core.util.RunFunc');


$id = $this->_tpl_vars["IN"]["id"];

runFunc("deleteAdminHotBrand",array($id));

header("Location: ".runFunc('encrypt_url',array('action=cms&method=hot_brand_list&type=products')));
