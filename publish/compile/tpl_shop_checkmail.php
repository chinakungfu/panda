<?php

	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "result",
	'query' => "SELECT count(*) as count FROM cms_member_staff WHERE staffNo = '{$this->_tpl_vars["IN"]["email"]}' "
	);
	

	$this->_tpl_vars["result"] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	
	 $item_array = array();
	$item_array["count"] = (string)$this->_tpl_vars["result"]["data"]["0"]["count"];

     echo json_encode($item_array);
	?>