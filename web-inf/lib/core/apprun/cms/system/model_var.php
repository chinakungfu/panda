<?
/**
 * add zxqer 20090304
 * 该文件主要用来设置通用ＣＭＳ的字段管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');

/**
 *用于显示模板变量的基本信息 
 **/       
function listModelVar()
{
	try
	{
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$modelVarArray['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$modelVarArray['currentPage'] = 1;
		}
		$modelVarArray['pageSize'] = 10;
		$sql = "select * from {$GLOBALS['table']['cms']['tpl_vars']} order by varId desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$modelVarArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到模板变量的基本信息 
 **/       
function getModelVarInfoById($varId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['tpl_vars']} where varId =:varId";
		$modelVarArray['varId'] = $varId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$modelVarArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到模板变量的基本信息 
 **/       
function editModelVarInfo($varId,$modelVarArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($modelVarArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['tpl_vars']} set $sql where varId=:varId";
		$modelVarArray['varId'] = $varId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$modelVarArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加模板变量的基本信息 
 **/       
function addModelVarInfo($modelVarArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($modelVarArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['tpl_vars']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$modelVarArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除模板变量的基本信息 
 **/       
function delModelVarInfo($varId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['tpl_vars']} where varId=:varId";
		$modelVarArray['varId'] = $varId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$modelVarArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}

/**
 *取出cms所有的全局模板变量
 **/       
function getGlobalModelVar($tplVar)
{
	try
	{
		$sql = "select * from {$GLOBALS['table']['cms']['tpl_vars']} where varName='".$tplVar."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$modelVarArray);
		return $result[0]['varValue'];
	} catch (Exception $e)
	{
		throw $e;
	}
}
?>