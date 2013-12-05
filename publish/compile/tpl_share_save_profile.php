<?php
import('core.util.RunFunc');
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;



	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	
	$nodeId = runFunc('getGlobalModelVar',array('shareNode'));
	$dataArray["first_name"] = $this->_tpl_vars["IN"]["first_name"];
	$dataArray["last_name"] = $this->_tpl_vars["IN"]["last_name"];
	$dataArray["DateOfBirth_Month"] = $this->_tpl_vars["IN"]["DateOfBirth_Month"];
	$dataArray["DateOfBirth_Day"] = $this->_tpl_vars["IN"]["DateOfBirth_Day"];
	$dataArray["ofc_see"] = $this->_tpl_vars["IN"]["ofc_see"];;
	$dataArray["mail"] = $this->_tpl_vars["IN"]["mail"];
	$dataArray["about_me"] = $this->_tpl_vars["IN"]["about_me"];
	$dataArray["Youtube"] = $this->_tpl_vars["IN"]["Youtube"];
	$dataArray["Flickr"] = $this->_tpl_vars["IN"]["Flickr"];
	$dataArray["Picasa"] = $this->_tpl_vars["IN"]["Picasa"];
	$dataArray["Linkedin"] = $this->_tpl_vars["IN"]["Linkedin"];
	$dataArray["Google"] = $this->_tpl_vars["IN"]["Google"];
	$dataArray["Myspace"] = $this->_tpl_vars["IN"]["Myspace"];
	$dataArray["smw_see"] = $this->_tpl_vars["IN"]["smw_see"];
	$dataArray["show_nick"] = $this->_tpl_vars["IN"]["show_nick"];
	$dataArray["sb_see"] = $this->_tpl_vars["IN"]["sb_see"];
	$dataArray["Newsletter"] = $this->_tpl_vars["IN"]["Newsletter"];
	$dataArray["Shopping_reminder"] = $this->_tpl_vars["IN"]["Shopping_reminder"];
	$dataArray["Activity"] = $this->_tpl_vars["IN"]["Activity"];
	$dataArray["Pinterest"] = $this->_tpl_vars["IN"]["Pinterest"];
	$dataArray["sex"] = $this->_tpl_vars["IN"]["sex"];
	$dataArray["Location"] = $this->_tpl_vars["IN"]["Location"];
	$dataArray["Country"] = $this->_tpl_vars["IN"]["Country"];
	$dataArray["State"] = $this->_tpl_vars["IN"]["State"];
	$dataArray["City"] = $this->_tpl_vars["IN"]["City"];
	$dataArray["facebook"] = $this->_tpl_vars["IN"]["facebook"];
	$dataArray["Twitter"] = $this->_tpl_vars["IN"]["Twitter"];
	$dataArray["real_name"] = $this->_tpl_vars["IN"]["real_name"];
	
	$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		//print_r($dataArray);
		$sql = "update cms_profile set $sql where user_id='{$this->_tpl_vars["IN"]["user_id"]}'";
		//print_r($dataArray);
		//print $sql;exit;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
		
		$memberArray = array("staffName"=>$this->_tpl_vars["IN"]["nick_name"]);	
		$sql = '';
		foreach ($memberArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		//print_r($dataArray);
		$sql = "update cms_member_staff set $sql where staffId='{$this->_tpl_vars["IN"]["user_id"]}'";
		//print_r($dataArray);
		//print $sql;exit;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
		
		header("Location: ".runFunc('encrypt_url',array('action=share&method=editProfile')));
?>

	