<?php
/**
 * *****
 * 菜单增删改以及查询角色信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.power.popedom');
import('core.apprun.cms.spell_class');
function listMenu($sqlCon)
{
	try {
		if($sqlCon!=null)
		{
			$paramStr = "'".$sqlCon."'";
			$sqlCon ='where '.$sqlCon;
		}
		$orderby = 'order by menuId desc';
		$sql = "select * from {$GLOBALS['table']['member']['menu']} ".$sqlCon." ".$orderby;
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
		if($GLOBALS['pageconfig']['member']['pagesize']=='')
		{
			 $GLOBALS['pageconfig']['member']['pagesize'] = 10;
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
function addMenu($menuArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$spell = new spell_class();
		$str = $spell->sStr2py($menuArray['menuName']);
		$str .= randomStr(4);
		$menuArray['menuGuid'] = $str;
 		foreach ($menuArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['member']['menu']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$menuArray);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function editMenu($menuId,$menuArray)
{
	try
	{
		//$spell = new spell_class();
		//$str = $spell->sStr2py($menuArray['menuName']);
		//$str .= randomStr(4);
		//$menuArray['menuGuid'] = $str;
		foreach ($menuArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['member']['menu']} set $sql where menuId=".$menuId;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$menuArray);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function delMenu($menuId)
{
	try
	{
		$infoIdArray = explode(',',$menuId);
		for($i=0;$i<count($infoIdArray)-1;$i++)
		{
			$sql = "DELETE FROM {$GLOBALS['table']['member']['menu']} WHERE menuId=:menuId";
			$params['menuId'] = $infoIdArray[$i];
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return true;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function getMenuById($menuId)
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['member']['menu']} where menuId= {$menuId}";
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function getMenuByType($type)
{
	try {
		$sql = "select * from {$GLOBALS['table']['member']['menu']} where menuType = '{$type}'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}


function leftMenu()
{
	try {
		$sql = "select * from {$GLOBALS['table']['member']['menu_type']} order by orderby";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$str = '<div class="left_menu_content">';
		foreach ($result as $key => $val)
		{
			$parentStr = '<a name="'.$val['menuTypeGoto'].'"></a><div class="left_menu_nav">'.$val['menuTypeName'].'</div>';
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
					$childStr .='<div class="menu_list bottom_border"><a href="'.$val1['menuUrl'].'" target="mainFrame">'.$val1['menuName'].'</a></div>';
				}
			}
			if($i>0)
			{
				$str .= $parentStr.$childStr;
			}
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getAllMenuInfo()
{
	try {
		$returnStr = "";
		$sqlCon = " order by orderBy DESC ";
		$sqlParent = "select * from {$GLOBALS['table']['member']['menu']} where menuParentGuid = '0' ".$sqlCon;
		$resultParent = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlParent,$params);
		if(!empty($resultParent))
		{
			foreach ($resultParent as $keyParent => $valParent)
			{
				$isDisplayRoot = false;
				$tempStr = "listNodeTree.N[\"baseNode_".$valParent['menuGuid']."\"] = \"T:".$valParent['menuName'].";url:;target:mainFrame\";\n";
				$sql = "select * from {$GLOBALS['table']['member']['menu']} where menuParentGuid  = '".$valParent['menuGuid']."' ".$sqlCon;
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				if(!empty($result))
				{
					foreach ($result as $key => $val)
					{
						$actionAndMethod = getActionAndMethod($val['menuUrl']);
						if(isMemberAuth('','',$actionAndMethod['action'],$actionAndMethod['method']))
						{
							if(!$isDisplayRoot)
							{
								$returnStr .= $tempStr;
								$isDisplayRoot = true;
							}
							$menuUrl = processParseMenuUrl($val['menuUrl']);
							$returnStr .= "listNodeTree.N[\"".$val['menuParentGuid']."_".$val['menuGuid']."\"] = \"T:".$val['menuName'].";url:".$menuUrl.";target:mainFrame\";\n";
						}
					}
				}
			}
		}
		return $returnStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getAllMenuInfoByEdit($sqlCon='')
{
	try {
		if($sqlCon!='')
		{
			$sqlCon = " order by orderBy ASC";
		}
		$sql = "select * from {$GLOBALS['table']['member']['menu']}".$sqlCon;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function processParseMenuUrl($url)
{
	try {
		$urlArray = explode('?',$url);
		$returnUrl = $urlArray[0].encrypt_url($urlArray[1]);
		return $returnUrl;
	}catch (Exception $e)
	{
		throw $e;	
	}
}
function getActionAndMethod($url)
{
	try {
		$urlArray = explode('?',$url);
		$paramsArray = explode("&",$urlArray[1]);
		for($i=0;$i<count($paramsArray);$i++)
		{
			$tempArray = explode("=",$paramsArray[$i]);
			$returnArray[$tempArray[0]] = $tempArray[1];
		}
		return $returnArray;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function randomStr($length, $numeric = 0) {
	//PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if ($numeric) {
		$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	} else {
		$hash = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$max = strlen($chars) - 1;
		for ($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}
?>