<?php import('core.util.RunFunc'); 



$result = runFunc("getMemberShareListItem",array($this->_tpl_vars["IN"]["list_id"]));


echo json_encode($result);