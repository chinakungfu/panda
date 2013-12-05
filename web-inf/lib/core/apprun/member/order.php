<?php


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');


function getOrderList($page,$num,$KeyWords='')
{
	try
	{
		if(empty($num)) $IN['num'] = 10;
		if(empty($page)) $IN['page'] = 1;
		if(!empty($KeyWords)) $where = 'where orderNo =' . $IN['KeyWords'];
		

		$sql = "select * from {$GLOBALS['table']['member']['payinfo']} $where order by ID desc";
		$params['pageSize'] = $IN['num'];
		$params['currentPage'] = $IN['page'];
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//print_r($result);
		return $result;

	}
	catch (Exception $e)
	{
		throw $e;
	}
}

?>