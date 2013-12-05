<?php
/**
 * *****
 * 系统级的配置及查询操作信息函数
 * 严重注意：必须在主运行环境将系统数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.function.functions');
import('core.apprun.member.cookie');
import('core.apprun.member.api');

//查询注册参数
function getRegister()
{
	try
	{
		$params['var'] = 'isRegister';
		$sql = "select * from {$GLOBALS['table']['member']['system']} where var = :var";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result['0'];

	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//设置注册参数
function setRegister($IN)
{
	try
	{

		if(!empty($IN))
		{
			$params['var'] = 'isRegister';
			$params['value'] = $IN['value'];


			$sql = "UPDATE {$GLOBALS['table']['member']['system']} set value = :value where var = :var ";
			$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return $result;
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}
}


//获取系统设置信息
function getSystemSet()
{
	try
	{
		$sql = "select * from {$GLOBALS['table']['member']['system']}";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		
		//组合数组
		foreach ($result as $key=>$value)
		{
			$sys_info[$value['var']] = htmlspecialchars($value['value']);
		}
		
		return $sys_info;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}


//保存本地信息
function saveSystemSet($IN)
{
	try
	{
		//print_r($IN);exit;
		$array = array('messageVerify','filterIplist','badKeywords');
		
		foreach ($array as $value)
		{
			$params['value'] = $IN[$value];
			$params['var'] = $value;
			$sql = "UPDATE {$GLOBALS['table']['member']['system']} set value = :value where var = :var ";
			$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			unset($params);
		}
		
		return true;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

?>