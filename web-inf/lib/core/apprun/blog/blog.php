<?php
/**
 * *****
 * 会员增删改以及查询博客信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.blogcenter.Mail');
import('core.apprun.blog.encode');
import('core.tpl.TplTemplate');
import('core.apprun.yellowpages.export');
import('core.apprun.member.Session');

//显示博客列表
function listBlog($sqlCon)
{
	$mameberId = readSession();//获得用户的ID
	try {
		if($sqlCon!=null)
		{
			$paramStr = "'".$sqlCon."'";
			//$sqlCon =$sqlCon;
			$sql = "select * from {$GLOBALS['table']['blog']['bloginfo']} where ".$sqlCon." and blogauther = '".$mameberId."' order by blogdate desc";
		}else 
		{
			$sql = "select * from {$GLOBALS['table']['blog']['bloginfo']} where blogauther = '".$mameberId."' order by blogdate desc";
		}
		//$sql = "select * from {$GLOBALS['table']['blog']['bloginfo']}".$sqlCon;
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
		$params['pageSize'] = $GLOBALS["pageconfig"]['blog']['pagesize'];
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$result['pageinfo']['isText'] = $isText;
		$result['pageinfo']['wherestr'] = $paramStr;
		return $result;
		//$sql = "select * from {$GLOBALS['table']['blog']['bloginfo']} order by blogId";
		//return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e)
	{
		throw $e;
	}
}
//新增一博客，传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//新增成功则返回新建博客的uid,失败则返回false;
function addblog($blogArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$mameberId = readSession();//获得用户的ID
	 	$blogArray['blogdate'] = date("Y-m-d H:i:s");
	 	$blogArray['blogauther'] = $mameberId;
		foreach ($blogArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['blog']['bloginfo']} (".$str_field.") values (".$str_value.")";
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$blogArray);
	} 
	catch (Exception $e)
	{
		throw $e;
	}
}

//修改指定uid的博客信息,传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//失败返回false, 成功返回影响行数
function editBlog($blogId,$blogArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$mameberId = readSession();//获得用户的ID
	 	$blogArray['blogdate'] = date("Y-m-d H:i:s");
	 	$blogArray['blogauther'] = $mameberId;
		foreach ($blogArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['blog']['bloginfo']} set $sql where blogId={$blogId}";
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$blogArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}

//根据某博客属性删除博客,比如根据uid,email
function delblog($blogId)
{
	try
	{
		$sql = "DELETE FROM {$GLOBALS['table']['blog']['bloginfo']} WHERE `blogId`=:blogId";
		$params['blogId'] = $blogId;
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//传入博客ID，查询博客所有信息
function getBlogInfoById($blogId)
{
	try
	{
		export();
		$sql = "select * from {$GLOBALS['table']['blog']['bloginfo']} where blogId= ".$blogId;
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
?>