<?php
/**
 * 权限验证函数
 * 根据传入的用户id,应用id,动作id,方法id判断用户的权限状态,
 * 如果传入的某个变量缺少，默认将采用当前状态下的参数值作为验证参数
 * 仅提供返回权限状态数字值
 */

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');

function memberAuth($uNo,$appId,$moduleId,$actionId,$distinctionNo)
{
	try
	{ 
		$sql = "select count(*) as rowscount from".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['staff_groups']} b,".
		"{$GLOBALS['table']['member']['group_roles']} c,".
		"{$GLOBALS['table']['member']['role_operations']} d ".
		"where a.staffId=b.staffId and b.groupId=c.groupId ".
		" and c.operationId=d.operationId and a.staffNo='".$uNo."'".
		" and d.appId='".$appId."'".
		" and d.moduleId='".$actionId."'".
		" and d.distinctionNo='".$distinctionNo."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if($result[0]['rowscount']>0)
		{
			return true;
		}else {
			return false;
		}
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
?>