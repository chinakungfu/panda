<?php
/**
 * *****
 * 日志增删改以及查询日志信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.logManage.upload');
import('core.apprun.member.Session');
//
//
//
function listlog($sqlCon)
{
	try {
		$memberId = readSession();//获得用户的ID
		if($sqlCon!=null)
		{
			$paramStr = "'".$sqlCon."'";
			$sqlCon ='where '.$sqlCon;
		}
		$orderby = 'order by logId';
		$sql = "select * from {$GLOBALS['table']['log']['log']} ".$sqlCon." ".$orderby;
		if($GLOBALS['IN']['currentPage']!=''){
			$params['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$params['currentPage'] = 1;
		}
		if($GLOBALS['IN']['isText'])
		{
			$isText = "&isText=".$GLOBALS['IN']['isText'];
		}		
		//$params['pageSize'] = $GLOBALS['pageconfig']['logManage']['pagesize'];
		$params['pageSize'] = 20;
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$result['pageinfo']['isText'] = $isText;
		$result['pageinfo']['wherestr'] = $paramStr;
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//新增一日志
//
//新增成功则返回新建日志的uid,失败则返回false;
function addlog($logClass,$logSource,$logType,$logEvent)
{
	try
	{
		date_default_timezone_set('PRC');
		$mameberId = readSession();//获得用户的ID
		$logManageArray['logClass'] = $logClass;
	 	$logManageArray['logDate'] = date("Y-m-d");
	 	$logManageArray['logTime'] = date("H:i:s");	 	
	 	$logManageArray['logSource'] = $logSource;
	 	$logManageArray['logType'] = $logType;
	 	$logManageArray['logEvent'] = $logEvent;
	 	$logManageArray['memberId'] = $mameberId;
	 	$logManageArray['logIp'] = $GLOBALS['IN']['IP_ADDRESS'];
		foreach ($logManageArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['log']['log']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$logManageArray);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//根据某日志属性删除日志,比如根据uid,email
function dellog($logManageId)
{
	try
	{
		$delUrl = getlogInfoById($logManageId);
		//print $delUrl;
		$delUrl = $GLOBALS['attachapp']['logManage']['path'].$delUrl;
		//print $delUrl;exit;
		$sql = "DELETE FROM {$GLOBALS['table']['log']['log']} WHERE `logId`=:logId";
		$params['logId'] = $logManageId;
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//传入日志ID，查询日志所有信息
function getlogInfoById($logManageId)
{
	try
	{
		$sql = "select * from {$GLOBALS['table']['log']['log']} where logId= {$logManageId}";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
?>