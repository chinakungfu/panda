<?php
/**
 * *****
 * 应用查询
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');

function listApp($IN)
{
	try {
		
		if(empty($IN['num'])) $IN['num'] = 10;
		if(empty($IN['page'])) $IN['page'] = 1;

		$sql = "select * from {$GLOBALS['table']['member']['app']} {$IN['where']} order by {$IN['order']} appId desc";
		$params['pageSize'] = $IN['num'];
		$params['currentPage'] = $IN['page'];

		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//print_r($result);
		return $result;
	
	}catch (Exception $e)
	{
		throw $e;
	}
}

?>