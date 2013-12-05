<?
/**
 * add zxqer 20081107
 * 该文件主要用来设置通用ＣＭＳ的字段管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
/**
 *用于在编辑结点时，显示字段下拉列表的函数 
 **/       
function selectFieldName()
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select fieldId,fieldName from {$GLOBALS['table']['cms']['app_fields']} order by fieldId";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
		foreach ($result as $key => $val)
		{
			$str .= "<option value='".$val['FieldID']."'>".$val['FieldName']."</option>";
		}
		return $str;
	} catch (Exception $e)
	{
		throw $e;
	}
}

/**
 *用于显示数据表的基本信息 
 **/       
function listFieldInfo($fieldId)
{
	try
	{
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$fieldsArray['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$fieldsArray['currentPage'] = 1;
		}
		$fieldsArray['pageSize'] = 10;
		$sql = "select * from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId ='".$fieldId."'";
		$fieldsArray['fieldConfigId'] = $fieldId;
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到数据表的基本信息 
 **/       
function getFieldInfoById($fieldsId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['app_fields']} where fieldId =:fieldId";
		$fieldsArray['fieldId'] = $fieldsId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到数据表的基本信息 
 **/       
function editFieldInfo($fieldsId,$fieldsArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($fieldsArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['app_fields']} set $sql where fieldId=:fieldId";
		$fieldsArray['fieldId'] = $fieldsId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加数据表的基本信息 
 **/       
function addFieldInfo($fieldsArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($fieldsArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['app_fields']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除数据表的基本信息 
 **/       
function delFieldInfo($fieldsId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['app_fields']} where fieldId=:fieldId";
		$fieldsArray['fieldId'] = $fieldsId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
?>