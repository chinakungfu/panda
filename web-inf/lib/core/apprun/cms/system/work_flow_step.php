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
function listWorkFlowStep()
{
	try
	{
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$flowStepArray['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$flowStepArray['currentPage'] = 1;
		}
		$flowStepArray['pageSize'] = 10;
		$sql = "select * from {$GLOBALS['table']['cms']['workflow_step']} order by flowStepId desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$flowStepArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到工作流的基本信息 
 **/       
function getWorkFlowStepInfoById($flowStepId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['workflow_step']} where flowStepId =:flowStepId";
		$flowStepArray['flowStepId'] = $flowStepId;
		
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$flowStepArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据工作流惟一标识得到工作流的基本信息 
 **/       
function getWorkFlowStepInfoByGuid($flowGuid)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['workflow_step']} where flowGuid =:flowGuid";
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
function editWorkFlowStep($flowStepId,$flowStepArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($flowStepArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['workflow_step']} set $sql where flowStepId=:flowStepId";
		$flowStepArray['flowStepId'] = $flowStepId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$flowStepArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加工作流的基本信息 
 **/       
function addWorkFlowStep($flowStepArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($flowStepArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['workflow_step']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$flowStepArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除工作流的基本信息 
 **/       
function delWorkFlowStep($flowStepId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['workflow_step']} where flowStepId=:flowStepId";
		$flowStepArray['flowStepId'] = $flowStepId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$flowStepArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/***
 *dfs 
 */
function fullWorkFlowStepFlag($flowStepName)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($flowStepName);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>