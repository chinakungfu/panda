<?php
/**
 * *****
 * 菜单增删改以及查询角色信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.power.popedom');
import('core.apprun.membercenter.menu');
function listMenuType($sqlCon)
{
	try {
		if($sqlCon!=null)
		{
			$paramStr = "'".$sqlCon."'";
			$sqlCon ='where '.$sqlCon;
		}
		$orderby = 'order by menutypeId desc';
		$sql = "select * from {$GLOBALS['table']['member']['menu_type']} ".$sqlCon." ".$orderby;
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
		$params['pageSize'] = $GLOBALS['pageconfig']['member']['pagesize'];
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$result['pageinfo']['isText'] = $isText;
		$result['pageinfo']['wherestr'] = $paramStr;
		return $result;

	}catch (Exception $e)
	{
		throw $e;
	}
}
function addMenuType($menuTypeArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($menuTypeArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['member']['menu_type']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$menuTypeArray);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function editMenuType($menutypeId,$menuTypeArray)
{
	try
	{
		foreach ($menuTypeArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['member']['menu_type']} set $sql where menutypeId=".$menutypeId;
		//print $sql;exit;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$menuTypeArray);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function delMenuType($menutypeId)
{
	try
	{
		$infoIdArray = explode(',',$menutypeId);
		for($i=0;$i<count($infoIdArray)-1;$i++)
		{
			$sql = "DELETE FROM {$GLOBALS['table']['member']['menu_type']} WHERE menutypeId=:menutypeId";
			$params['menutypeId'] = $infoIdArray[$i];
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return true;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function getMenuTypeById($menutypeId)
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['member']['menu_type']} where menutypeId= {$menutypeId}";
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function getMenuTypeByType($type)
{
	try {
		$sql = "select * from {$GLOBALS['table']['member']['menu_type']} where menuType = :menuType";
		$params["menuType"] = $menuType;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function echoMenuType()
{
	try {
		$sql = "select * from {$GLOBALS['table']['member']['menu_type']} order by menutypeId desc";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$str = "<option value=''></option>";
		foreach ($result as $key => $val)
		{
			$str .= "<option value='".$val['menuTypeId']."'>".$val['menuTypeName']."</option>";
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}

function topMenu()
{
	try {
		$sql = "select * from {$GLOBALS['table']['member']['menu_type']} order by orderby";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		foreach ($result as $key => $val)
		{
			$parentStr = '<li class="active"><a href="index.php?action=member&method=left#'.$val['menuTypeGoto'].'" 
			target="leftFrame">'.$val['menuTypeName'].'</a></li>';
			$childArray = getMenuByType($val['menuTypeId']);
			//print_r($childArray);
			$i='0';
			$childStr = '';
			foreach ($childArray as $key1 => $val1)
			{
				$isOk = isMemberAuth('',$val1['appName'],$val1['moduleName'],$val1['actionName'],$val1['distinctionName']);
				if($isOk)
				{
					$i++;
				}
			}
			if($i>0)
			{
				$str .= $parentStr;
			}
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>