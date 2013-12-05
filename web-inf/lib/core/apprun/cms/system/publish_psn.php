<?
/**
 * add zxqer 20090304
 * 该文件主要用来设置通用ＣＭＳ的发布点（PSN）管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');

/**
 *用于显示发布点PSN的基本信息 
 **/       
function listPublishPsn()
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
		$sql = "select * from {$GLOBALS['table']['cms']['psn']} order by psnId desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$psnArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到发布点PSN的基本信息 
 **/       
function getPublishPsnInfoById($psnId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['psn']} where psnId =:psnId";
		$psnArray['psnId'] = $psnId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$psnArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到发布点PSN的基本信息 
 **/       
function editPublishPsnInfo($psnId,$psnArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($psnArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['psn']} set $sql where psnId=:psnId";
		$psnArray['psnId'] = $psnId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$psnArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加发布点PSN的基本信息 
 **/       
function addPublishPsnInfo($psnArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($psnArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['psn']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$psnArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除发布点PSN的基本信息 
 **/       
function delPublishPsnInfo($psnId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['psn']} where psnId=:psnId";
		$psnArray['psnId'] = $psnId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$psnArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
?>