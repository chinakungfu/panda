<?
/**
 * add zxqer 20081107
 * 该文件主要用来设置通用ＣＭＳ的数据表管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
/**
 *用于在编辑结点时，显示内容模型下拉列表的函数 
 **/       
function selectTableName()
{
	try
	{
		$result = $GLOBALS['table'];
		foreach ($result as $key => $val)
		{
			foreach ($val as $k => $v)
			{
			$str .= "<option value='".$v."'>".$v."</option>";
			}
		}
		return $str;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *用于在编辑结点时，显示字段配置下拉列表的函数 
 **/       
function selectFieldConfigName()
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select fieldConfigId,fieldConfigName from {$GLOBALS['table']['cms']['fieldconfig']} order by fieldConfigId";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
		foreach ($result as $key => $val)
		{
			$str .= "<option value='".$val['fieldConfigId']."'>".$val['fieldConfigName']."</option>";
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
function listFieldConfigInfo()
{
	try
	{
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$param['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$param['currentPage'] = 1;
		}
		$param['pageSize'] = "10";
		$sql = "select * from {$GLOBALS['table']['cms']['fieldconfig']} order by fieldConfigId";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$param);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到数据表的基本信息 
 **/       
function getFieldConfigInfoById($fieldConfigId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['fieldconfig']} where fieldConfigId = :fieldConfigId";
		$fieldConfigArray['fieldConfigId'] = $fieldConfigId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$fieldConfigArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到数据表的基本信息 
 **/       
function editFieldConfigInfo($fieldConfigId,$fieldConfigArray)
{
	try
	{
		date_default_timezone_set('PRC');
		//$fieldConfigArray['createDate'] = strtotime(date("Y-m-d H:i:s"));
		foreach ($fieldConfigArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['fieldconfig']} set $sql where fieldConfigId=:fieldConfigId";
		$fieldConfigArray['fieldConfigId'] = $fieldConfigId;
		//print $sql;
		//print_r($fieldConfigArray);exit;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldConfigArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加数据表的基本信息 
 **/       
function addFieldConfigInfo($fieldConfigArray)
{
	try
	{
		//print_r($fieldConfigArray);exit;
		date_default_timezone_set('PRC');
		//$fieldConfigArray['CreateDate'] = strtotime(date("Y-m-d H:i:s"));
		foreach ($fieldConfigArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['fieldconfig']} (".$str_field.") values (".$str_value.")";
		//print $sql;exit;
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldConfigArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除数据表的基本信息 
 **/       
function delFieldConfigInfo($fieldConfigId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['fieldconfig']} where fieldConfigId=:fieldConfigId";
		$fieldConfigArray['fieldConfigId'] = $fieldConfigId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldConfigArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
?>