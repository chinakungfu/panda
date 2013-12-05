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
function listWorkFlow()
{
	try
	{
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$psnArray['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$psnArray['currentPage'] = 1;
		}
		$psnArray['pageSize'] = 10;
		$sql = "select * from {$GLOBALS['table']['cms']['workflow']} order by flowId desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$psnArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到工作流的基本信息 
 **/       
function getWorkFlowInfoById($flowId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['workflow']} where flowId =:flowId";
		$flowArray['flowId'] = $flowId;
		
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$flowArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据工作流惟一标识得到工作流的基本信息 
 **/       
function getWorkFlowInfoByGuid($flowGuid)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['workflow']} where flowGuid =:flowGuid";
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
function editWorkFlow($flowId,$flowArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($flowArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['workflow']} set $sql where flowId=:flowId";
		$flowArray['flowId'] = $flowId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$flowArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加工作流的基本信息 
 **/       
function addWorkFlow($flowArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($flowArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['workflow']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$flowArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除工作流的基本信息 
 **/       
function delWorkFlow($flowId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['workflow']} where flowId=:flowId";
		$flowArray['flowId'] = $flowId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$flowArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/***
 *dfs 
 */
function fullWorkFlag($flowName)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($flowName);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>