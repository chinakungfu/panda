<?
/**
 * add zxqer 20090304
 * 该文件主要用来设置通用ＣＭＳ的工作流管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.spell_class');
/**
 *用于显示发布点PSN的基本信息 
 **/       
function listWorkFlowAction()
{
	try
	{
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$flowActionArray['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$flowActionArray['currentPage'] = 1;
		}
		$flowActionArray['pageSize'] = 10;
		$sql = "select * from {$GLOBALS['table']['cms']['workflow_action']} order by flowActionId desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$flowActionArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到工作流的基本信息 
 **/       
function getWorkFlowActionInfoById($flowActionId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['workflow_action']} where flowActionId =:flowActionId";
		$flowActionArray['flowActionId'] = $flowActionId;
		
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$flowActionArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据工作流惟一标识得到工作流的基本信息 
 **/       
function getWorkFlowActionInfoByGuid($flowGuid)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['workflow_action']} where flowGuid =:flowGuid";
		$flowsArray['flowGuid'] = $flowGuid;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$flowsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到工作流的基本信息 
 **/       
function editWorkFlowAction($flowActionId,$flowActionArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($flowActionArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['workflow_action']} set $sql where flowActionId=:flowActionId";
		$flowActionArray['flowActionId'] = $flowActionId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$flowActionArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加工作流的基本信息 
 **/       
function addWorkFlowAction($flowActionArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($flowActionArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['workflow_action']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$flowActionArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除工作流的基本信息 
 **/       
function delWorkFlowAction($flowActionId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['workflow_action']} where flowActionId=:flowActionId";
		$flowActionArray['flowActionId'] = $flowActionId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$flowActionArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/***
 *dfs 
 */
function fullWorkFlowActionFlag($flowActionName)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($flowActionName);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>