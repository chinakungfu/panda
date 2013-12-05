<?php
/**
 * *****
 * 会员增删改以及查询角色信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');

function listMenu($menuType)
{
	try {
		$sql = "select * from {$GLOBALS['table']['membercenter']['menu']} where menuType = :menuType";
		$params["menuType"] = $menuType;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}


?>