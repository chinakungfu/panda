<?php

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
 function userIsExists($userNo)
 {
 	try {
 		$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo='".$userNo."'";
 		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
 		return $result;
 	}catch (Exception $e)
 	{
 		throw $e;
 	}
 }
?>