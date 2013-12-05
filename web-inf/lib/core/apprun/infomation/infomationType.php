<?php
/**
 * *****
 * 资讯增删改以及查询用户信息函数
 * 严重注意：必须在主运行环境将资讯数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.yellowPagescenter.Mail');
import('core.apprun.yellowPages.encode');
import('core.tpl.TplTemplate');
import('core.apprun.resourceManage.resource');
import('core.apprun.yellowPages.infomation');
import('core.apprun.infomation.export');
import('core.apprun.member.Session');
import('core.apprun.page.Page');
/**
 * 显示企业资讯信息
 * */
function listInfomationType($sqlCon)
{
	try {
		if($sqlCon!=null)
		{
			$Con[0] = $sqlCon;
			setSession($GLOBALS['IN']['action'],$GLOBALS['IN']['method'],$Con);
			$paramStr = "'".$sqlCon."'";
			$sqlCon ="where ".$sqlCon;
			$sql = "select * from {$GLOBALS['table']['i']['infomation_type']} ".$sqlCon;
		}elseif(querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method'])!='')
		{
			$sqlCon = querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
			$sqlCon ="where ".$sqlCon;
			$sql = "select * from {$GLOBALS['table']['infomation']['infomation_type']} ".$sqlCon;
		}else 
		{
			$sql = "select * from {$GLOBALS['table']['infomation']['infomation_type']} order by infoTypeId";
		}
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
		print "当前条件：".querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']);	
		$params['pageSize'] = 10;
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$result['pageinfo']['isText'] = $isText;
		$result['pageinfo']['wherestr'] = $paramStr;
		for($i=0;$i<count($result['data']);$i++)
		{
			$result['data'][$i]['addDate'] = date("Y-m-d H:i:s",$result['data'][$i]['addDate']);
		}
		return $result;
		//$sql = "select * from {$GLOBALS['table']['yellowPages']['InfomationType']} order by InfomationTypeId";
		//return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e)
	{
		throw $e;
	}
}

//
//
//
function addInfomationType($InfomationTypeArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$memberId = readSession();//获得用户的ID
		$InfomationTypeArray['addDate'] = strtotime(date("Y-m-d H:i:s"));
		foreach ($InfomationTypeArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['infomation']['infomation_type']} (".$str_field.") values (".$str_value.")";
		//print $sql;exit;
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$InfomationTypeArray);
	} 
	catch (Exception $e)
	{
		throw $e;
	}
}

//
//
//
function editInfomationType($infoTypeId,$InfomationTypeArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$memberId = readSession();//获得用户的ID
		foreach ($InfomationTypeArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['infomation']['infomation_type']} set $sql where infoTypeId  =:infoTypeId";
		$InfomationTypeArray['infoTypeId'] = $infoTypeId;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$InfomationTypeArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}

//
function delInfomationType($infoTypeId)
{
	try
	{
		$sql = "DELETE FROM {$GLOBALS['table']['infomation']['infomation_type']} WHERE infoTypeId=:infoTypeId";
		$params['infoTypeId'] = $infoTypeId; 
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//
function getInfomationType($infoTypeId)
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['infomation']['infomation_type']} where infoTypeId= :infoTypeId";
		$params['infoTypeId'] = $infoTypeId;
		//print_r(TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params));
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//
function selectInfoType()
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['infomation']['infomation_type']}";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$optStr = "<option value=''></option>";
		for($i=0;$i<count($result);$i++)
		{
			$optStr .="<option value='".$result[$i]["infoTypeId"]."'>".$result[$i]["infoTypeName"]."</option>";
		}
		return $optStr;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
?>