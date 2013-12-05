<?
/**
 * add zxqer 20081120
 * 该文件主要用来设置通用ＣＭＳ的内容编辑方案管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.action');

/**
 *用于在编辑结点时，显示内容编辑方案下拉列表的函数 
 **/       
function selectContentPlanName()
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select contentPlanId,contentPlanName from {$GLOBALS['table']['cms']['app_contentplan']} order by contentPlanId";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
		foreach ($result as $key => $val)
		{
			$str .= "<option value='".$val['contentPlanId']."'>".$val['contentPlanName']."</option>";
		}
		return $str;
	} catch (Exception $e)
	{
		throw $e;
	}
}

/**
 *用于显示内容编辑方案的基本信息 
 **/       
function listContentPlanInfo()
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
		$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} order by contentPlanId";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$param);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到内容编辑方案的基本信息 
 **/       
function getContentPlanInfoById($contentPlanId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where contentPlanId = :contentPlanId";
		$contentPlanArray['contentPlanId'] = $contentPlanId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$contentPlanArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到内容编辑方案的基本信息 
 **/       
function editContentPlanInfo($contentPlanId,$contentPlanArray)
{
	try
	{
		//print_r($contentPlanArray);exit;
		date_default_timezone_set('PRC');
		$ContentPlanArray['createDate'] = strtotime(date("Y-m-d H:i:s"));
		foreach ($contentPlanArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['app_contentplan']} set $sql where contentPlanId=:contentPlanId";
		$contentPlanArray['contentPlanId'] = $contentPlanId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$contentPlanArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加内容编辑方案的基本信息 
 **/       
function addContentPlanInfo($contentPlanArray)
{
	try
	{
		date_default_timezone_set('PRC');
		//$ContentPlanArray['CreateDate'] = strtotime(date("Y-m-d H:i:s"));
		foreach ($contentPlanArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['app_contentplan']} (".$str_field.") values (".$str_value.")";
		//print $sql;exit;
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$contentPlanArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除内容编辑方案的基本信息 
 **/       
function delContentPlanInfo($contentPlanId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['app_contentplan']} where contentPlanId=:contentPlanId";
		$contentPlanArray['contentPlanId'] = $contentPlanId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$contentPlanArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *获得动作
 **/       
function getContentActionBycontentId($contentPlanId,$actionType)
{
	try
	{
		$sql = "select ".$actionType." from {$GLOBALS['table']['cms']['app_contentplan']} where contentPlanId=:contentPlanId";
		$contentPlanArray['contentPlanId'] = $contentPlanId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$contentPlanArray);
		if(!empty($result))
		{
			$result = explode(',',$result[0][$actionType]);
			$result = array_filter($result);
		}
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *检测动作是不是存在
 **/       
function checkActionExist($actionGuid,$actionGuidStr)
{
	try
	{
		$actionPos = strpos("aaaa".$actionGuidStr,$actionGuid);
		if($actionPos>0)
		{
			return true;
		}else 
		{
			return false;
		}
	} catch (Exception $e)
	{
		throw $e;
	}
}
?>