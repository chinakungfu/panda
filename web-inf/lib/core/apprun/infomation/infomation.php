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
import('core.apprun.infomation.infomationType');
/**
 * 显示企业资讯信息
 * */
function listInfomation($sqlCon,$type)
{
	try {
		date_default_timezone_set('PRC');
		if($sqlCon!=null)
		{
			$Con[0] = $sqlCon;
			setSession($GLOBALS['IN']['action'],$GLOBALS['IN']['method'],$Con);
			$paramStr = "'".$sqlCon."'";
			if($type!='')
			{
				$sqlCon ="where ".$sqlCon." and NodeID='".$type."'";
			}else 
			{
				$sqlCon ="where ".$sqlCon;
			}
			
			$sql = "select * from {$GLOBALS['table']['infomation']['infomation']} ".$sqlCon;
		}elseif(querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method'])!='')
		{
			$sqlCon = querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
			if($type!='')
			{
				$sqlCon ="where ".$sqlCon." and NodeID='".$type."'";
			}else 
			{
				$sqlCon ="where ".$sqlCon;
			}			
			$sql = "select * from {$GLOBALS['table']['infomation']['infomation']} ".$sqlCon;
		}else 
		{
			$sql = "select * from {$GLOBALS['table']['infomation']['infomation']}"; 	
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
			$result['data'][$i]['PublishDate'] = date("Y-m-d H:i:s",$result['data'][$i]['PublishDate']);
		}
		return $result;
		//$sql = "select * from {$GLOBALS['table']['yellowPages']['Infomation']} order by InfomationId";
		//return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e)
	{
		throw $e;
	}
}

//
//
//
function addInfomation($InfomationArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$memberId = readSession();//获得用户的ID 
		$result = getInfomationType($InfomationArray['NodeId']);
		$InfomationArray['infoType'] = $result[0]["infoTypeName"];
		$InfomationArray['PublishDate'] = strtotime(date("Y-m-d H:i:s"));
		$InfomationArray['Editor'] = $memberId;
		foreach ($InfomationArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['infomation']['infomation']} (".$str_field.") values (".$str_value.")";
		//print $sql;exit;
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$InfomationArray);
	} 
	catch (Exception $e)
	{
		throw $e;
	}
}

//
//
//
function editInfomation($ContentID,$InfomationArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$memberId = readSession();//获得用户的ID
		foreach ($InfomationArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['infomation']['infomation']} set $sql where ContentID  =:ContentID";
		$InfomationArray['ContentID'] = $ContentID;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$InfomationArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}

//
function delInfomation($ContentID)
{
	try
	{
		$sql = "DELETE FROM {$GLOBALS['table']['infomation']['infomation']} WHERE ContentID=:ContentID";
		$params['ContentID'] = $ContentID;
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//
function getInfomation($ContentID)
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['infomation']['infomation']} where ContentID=:ContentID";
		$params['ContentID'] = $ContentID;
		//print_r(TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params));
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

?>