<?php
/**
 * *****
 * 短信息增删改以及查询操作信息函数
 * 严重注意：必须在主运行环境将短信数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.member.popedom');
import('core.apprun.member.cookie');

//读取短信息列表
function messageList($page = '1',$num = '10')
{
	try
	{
		if(empty($num)) $num = 10;
		if(empty($page)) $page = 1;

		$sql = "select * from {$GLOBALS['table']['member']['message']}";

		$params['pageSize'] = $num;
		$params['currentPage'] = $page;

		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * $sendinfo 说明
 *
 * $userid 收件人ID
 * $title 短信标题
 * $content 短信内容
 */
function send($sendinfo)
{
	try
	{

		//发送者用户信息
		$sender_info = readCookie();

		//收件人用户信息
		$memer_info = getMemberByName($sendinfo['membername']);

		if(empty($memer_info))
		{
			//用户名不存在
			return -1;
		}


		$params = array(
		'senddate'=>time(),
		//从COOKIE里面提取ID
		'sendid'=>$sender_info['userid'],
		'messageform'=>$sender_info['username'],
		'ownid'=>$memer_info['userid'],
		'sendip'=>$sendinfo['IP_ADDRESS'],
		'title'=>$sendinfo['title'],
		'content'=>$sendinfo['content'],
		'state'=>'0',
		);


		foreach ($params as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}

		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);

		//先插入对方的收件箱里面
		$own_sql = "insert into {$GLOBALS['table']['member']['message']} (".$str_field.") values (".$str_value.")";

		TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$own_sql,$params);

		//给自己的收件箱里面插入信息

		//注销变量

		unset($params);
		unset($str_field);
		unset($str_value);

		$params = array(
		'senddate'=>time(),
		//从COOKIE里面提取ID
		'sendid'=>$sender_info['userid'],
		'messageform'=>$sender_info['username'],
		'ownid'=>'0',
		'sendip'=>$sendinfo['IP_ADDRESS'],
		'title'=>$sendinfo['title'],
		'content'=>$sendinfo['content'],
		'state'=>'1',
		);


		foreach ($params as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}

		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$send_sql = "insert into {$GLOBALS['table']['member']['message']} (".$str_field.") values (".$str_value.")";
		TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$send_sql,$params);


	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//收件箱
function box($page = '1',$num = '10')
{
	try
	{

		if(empty($num)) $num = 10;
		if(empty($page)) $page = 1;

		$member_info = readCookie();

		$sql = "select * from {$GLOBALS['table']['member']['message']} where ownid=". $member_info['userid'];
		$params['pageSize'] = $num;
		$params['currentPage'] = $page;
		//$params['ownid'] = $member_info['userid'];

		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		return $result;

	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//发件箱
function sendbox()
{
	try
	{

		if(empty($num)) $num = 1;
		if(empty($page)) $page = 3;

		$member_info = readCookie();

		$sql = "select * from {$GLOBALS['table']['member']['message']} where sendid = " . $member_info['userid'];
		$params['pageSize'] = $num;
		$params['currentPage'] = $page;
		echo $sql;exit;
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		return $result;

	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//查看信息

function messageView($message)
{
	try {

		if($message['messageid'])
		{
			//先查询信息内容
			$result = getMessageInfo($message['messageid']);

			//读取当前用户
			$member_info = readCookie();

			//判断信息拥有者是不是当前用户
			if($member_info['userid'] == $result['ownid'])
			{
				//将状态置为已读
				$params['messageid'] = $message['messageid'];
				$params['state'] = 1;
				$sql = "UPDATE {$GLOBALS['table']['member']['message']} set state = :state where messageid =:messageid";
				TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);

				return $result;
			}
			else
			{
				return false;
			}

		}
		else
		{
			return false;
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}

}

//删除短信息
function messageDelete($messageid)
{
	try
	{

		if($messageid)
		{
			$params['messageid'] = $messageid;
			$sql = "DELETE FROM {$GLOBALS['table']['member']['member']} WHERE `messageid`=:messageid";
			return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		else
		{
			return false;
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}

}


//根据用户名查询用户信息
function getMemberByName($username)
{
	try
	{
		$params = array(
		'memberName'=>$username,
		);

		$sql = "select * from {$GLOBALS['table']['member']['member']} where `memberName` = :memberName";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		return $result['0'];
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//根据ID获取短信息信息

function getMessageInfo($messageid)
{
	try {
		if($messageid)
		{
			$params['messageid'] = $messageid;
			$sql = "select * from {$GLOBALS['table']['member']['message']} where messageid =:messageid";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return $result['0'];
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}
}

?>