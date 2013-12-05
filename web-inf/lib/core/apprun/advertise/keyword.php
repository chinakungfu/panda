<?php
/**
 * *****
 * 区域增删改以及查询角色信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.power.popedom');
import('core.apprun.membercenter.menu');
function listKeyword($sqlCon)
{
	try {
		if($sqlCon!=null)
		{
			$paramStr = "'".$sqlCon."'";
			$sqlCon ='where '.$sqlCon;
		}
		$orderby = 'order by keywordId desc';
		$sql = "select * from {$GLOBALS['table']['advertise']['keyword']} ".$sqlCon." ".$orderby;
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
		$params['pageSize'] = $GLOBALS['pageconfig']['advertise']['pagesize'];
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$result['pageinfo']['isText'] = $isText;
		$result['pageinfo']['wherestr'] = $paramStr;
		return $result;

	}catch (Exception $e)
	{
		throw $e;
	}
}
function addKeyword($keywordArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($keywordArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['advertise']['keyword']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$keywordArray);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function editKeyword($keywordId,$keywordArray)
{
	try
	{
		foreach ($keywordArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['advertise']['keyword']} set $sql where keywordId=".$keywordId;
		//print $sql;exit;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$keywordArray);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function delKeyword($keywordId)
{
	try
	{
		$infoIdArray = explode(',',$keywordId);
		for($i=0;$i<count($infoIdArray)-1;$i++)
		{
			$sql = "DELETE FROM {$GLOBALS['table']['advertise']['keyword']} WHERE keywordId=:keywordId";
			$params['keywordId'] = $infoIdArray[$i];
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return true;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function getKeywordById($keywordId)
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['advertise']['keyword']} where keywordId= {$keywordId}";
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
?>