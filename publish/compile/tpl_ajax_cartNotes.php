<?php import('core.util.RunFunc'); ?>
<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 ?>
<?php
	switch($this->_tpl_vars["dataType"]){
		case 'request':
			$dataArray["itemNotes"] = $this->_tpl_vars["data"];
		break;
		case 'props':
			$dataArray["props"] = $this->_tpl_vars["data"];
		break;
		case 'modifyPrice':
			$dataArray["modifyPriceStatus"] = $this->_tpl_vars["data"];
		break;
	}

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_cart set $sql where cartID='{$this->_tpl_vars["cartID"]}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
?>