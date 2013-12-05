<?php
/**
 * *****
 * 会员增删改以及查询操作信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.function.functions');
import('core.apprun.member.cookie');
import('core.apprun.member.api');
import('core.apprun.member.group');
import('core.apprun.member.role');

//API级函数

/**
 * 根据用户ID或者用户名获取用户信息
 *
 * @param $array(memberName,isMemberId,returnkey)
 * @return $type
 * 
 * 
 * @return
 *  $memberInfo 返回用户信息
 * 
 * @return
 *  -2 提示没有任何标识
 *  -1 未找到用户信息
 * 
 */

function getMemberInfo($array)
{
	try
	{
		//先判断要查询的字段
		$returnkey = !empty($array['returnkey'])?$array['returnkey']:'*';

		if(empty($array['memberName']))
		{
			$array['memberName'] = $array['memberId'];
		}

		if(empty($array['memberName']))
		{
			//没有输入任何东西
			return -2;
		}
		if(!empty($array['isMemberId']))
		{
			$sql = "select ". $returnkey ." from {$GLOBALS['table']['member']['member']} where memberId = " . $array['memberName'];
			$params['memberId'] = $array['memberName'];

		}
		else
		{
			$sql = "select ". $returnkey ." from {$GLOBALS['table']['member']['member']} where memberName = :memberName";
			$params['memberName'] = $array['memberName'];
		}

		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		if(!empty($result['0']))
		{
			//注销密码变量
			unset($result['0']['passWord']);
			return $result['0'];
		}
		else
		{
			return -1;
		}
	}

	catch (Exception $e)
	{
		throw $e;
	}
}

function getMemberField($memberId)
{
	try
	{
		if(empty($memberId))
		{
			//没有输入任何东西
			return -1;
		}


		$sql = "select * from {$GLOBALS['table']['member']['field']} where memberId = :memberId";
		$params['memberId'] = $memberId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		if(!empty($result['0']))
		{

			return $result['0'];
		}
		else
		{
			return -2;
		}
	}

	catch (Exception $e)
	{
		throw $e;
	}
}


/**
 * 增加会员函数
 *
 * @param array array('state','gid','memberName','nickName','passWord','email');
 * @return result
 */

function addMember($array)
{
	try
	{

		//允许通过的字段
		$member_field = array('state','gid','memberName','nickName','passWord','email');

		//重新组合字段，抛弃指定外的数组
		foreach ($array as $key=>$value)
		{
			if(in_array($key,$member_field))
			{
				$params[$key] = $value;
			}
		}


		//判断用户名和密码是否赋值
		if(empty($params['memberName']) || empty($params['passWord']))
		{
			return -2;
		}


		if(empty($params['gid'])) $params['gid']= 1;
		if(empty($params['state'])) $params['state']= 1;
		if(empty($params['gid'])) $params['gid']= 1;
		//if(empty($params['regdata'])) $params['regdata']= time();
		if(empty($params['regdata'])) $params['regdata']= date('Y-m-d H:i:s',time());

		$params['regIp'] = $GLOBALS['IN']['IP_ADDRESS'];


		foreach ($params as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}

		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);

		//定义插入SQL
		$insert_sql = "insert into {$GLOBALS['table']['member']['member']} (".$str_field.") values (".$str_value.")";
		//定义查询SQL
		$select_sql = "select memberName from {$GLOBALS['table']['member']['member']} where memberName = :memberName";

		$select_params = array(
		'memberName'=>$params['memberName'],
		);


		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$select_sql,$select_params);

		//返回插入的会员ID
		if(empty($result['0']['memberName'])){
			return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$insert_sql,$params);
		}
		else
		{
			//返回已经注册了的信息
			return -1;
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * 附加字段
 *
 * @param array $array
 * 
 */
function insertMemberField($array)
{

	if(is_array($array))
	{

		foreach ($array as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}

		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);

		//定义插入SQL
		$sql = "insert into {$GLOBALS['table']['member']['field']} (".$str_field.") values (".$str_value.")";
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$array);
	}
	else
	{
		return -1;
	}

}

function updateMemberField($array,$memberId)
{
	if(is_array($array))
	{
		foreach ($array as $key => $val)
		{

				$str_field .= $key." = :" . $key .',';
			
		}
		
		$str_field = substr($str_field,0,-1);
		$array['memberId'] = $memberId;
		
		$sql = "UPDATE {$GLOBALS['table']['member']['field']} set ". $str_field ." where memberId = :memberId ";
		//echo $sql;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$array);
	}
	else
	{
		return -1;
	}
}

/**
 * 根据数值，修改用户信息
 *
 * @param array $array
 * @return array
 */

function editMember($array)
{
	try
	{

		//允许通过的字段
		$member_field = array('memberId','state','gid','nickName','email','question','answer');

		if(empty($array['memberId']))
		{
			//缺少必要参数 memberId；
			return -1;
		}

		//先查询原来的数据
		$sql = "select * from {$GLOBALS['table']['member']['member']} where memberId = :memberId";
		$params['memberId'] = $array['memberId'];
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);


		//重新组合字段，抛弃指定外的数组
		foreach ($array as $key=>$value)
		{
			if(in_array($key,$member_field))
			{
				if(!empty($value))
				{
					$params[$key] = $value;
				}
				
			}
		}

		//print_r($params);exit;
		//先检查是不是存在某个用户
		if($result['0']['memberName'])
		{

			//先检查用户是不是改变了
			if($params['nickName'] != $result['0']['nickName'])
			{
				//查询新用户名是否重复
				$sql = "select * from {$GLOBALS['table']['member']['member']} where nickName = :nickName";
				//注销数组
				//unset($params);
				$check_params['nickName'] = $params['nickName'];
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$check_params);
				if($result['0'])
				{
					//提示已经存在该用户
					return -2;
				}
			}


			$params = array(

			'memberId' => $params['memberId'],
			'nickName' => $params['nickName'],
			'email' => $params['email'],
			'state' => $params['state'],
			'question' => $params['question'],
			'answer' => $params['answer'],

			);

			$sql = "UPDATE {$GLOBALS['table']['member']['member']} set nickName  = :nickName,email = :email,state = :state,question= :question,answer = :answer where memberId = :memberId ";

			$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);

			//如果修改成功
			if($result > 0)
			{
				return $result;
			}
			else
			{
				return -3;
			}

		}
	}
	catch (Exception $e)
	{
		throw $e;
	}

}

/**
 * 修改密码的函数
 *
 * @return errer_id;memberId
 */
function changePassWord($array)
{

	extract ($array, EXTR_PREFIX_SAME, "m_");
	//$memberId,$oldPassword,$newPassword,$isAdmin = 0
	
	if(empty($newPassword))
	{
		//新密码为空
		return -1;
	}
	//假如是管理模式
	if($isAdmin)
	{
		$params['memberId'] = $memberId;
		$params['passWord'] = $newPassword;
		$sql = "UPDATE {$GLOBALS['table']['member']['member']} set passWord = :passWord where memberId = :memberId ";
		$result =  TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		return $result;
	}

	$params['memberId'] = $memberId;
	$params['passWord'] = $oldPassword;


	$sql = "select * from {$GLOBALS['table']['member']['member']} where memberId = :memberId and passWord = :passWord ";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);


	//假如用户信息正确
	if(!empty($result['0']))
	{
		unset($params);
		$params['memberId'] = $memberId;
		$params['passWord'] = $newPassword;

		$sql = "UPDATE {$GLOBALS['table']['member']['member']} set passWord = :passWord where memberId = :memberId ";
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}
	else
	{
		//原密码错误
		return -2;
	}
}

/**
 * 检查问题答案是否正确
 *
 * @param unknown_type $array
 */
function checkQuestion($array)
{
	try
	{
		
		$sql = "select * from {$GLOBALS['table']['member']['member']} where memberId = :memberId and question = :question and answer = :answer";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$array);
		
		if($result['0'])
		{
			return true;
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
/**
 * 根据用户名和密码，判断会员是否存在
 *
 * @param array $array
 * @return int
 */

function checkMemberInfo($array)
{
	try
	{
		$memberName = $array['memberName'];
		$passWord = $array['passWord'];


		if(empty($memberName) || empty($passWord))
		{
			//返回-1，提示：用户名和密码不能为空
			return  -3;
		}

		$params = array(
		'memberName'=>$memberName,
		//'passWord'=>md5($passWord),
		);


		$sql = "select * from {$GLOBALS['table']['member']['member']} where memberName = :memberName";

		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		//先检查用户名是否存在
		if($result['0'])
		{
			//检查密码
			if($passWord != $result['0']['passWord'])
			{
				//提示密码错误
				return -2;
			}

			//注销密码变量
			unset($result['0']['passWord']);
			//记录这次的登录时间和上次的登录时间
			unset($params);
			$params['lastLoginIp'] = $result['0']['nowLoginIp'];
			$params['lastLoginDate'] = $result['0']['nowLoginDate'];
			$params['nowLoginIp'] = $GLOBALS['IN']['IP_ADDRESS'];
			$params['nowLoginDate'] = time();
			$params['memberId'] = $result['0']['memberId'];
			
			$sql = "UPDATE {$GLOBALS['table']['member']['member']} set lastLoginIp =:lastLoginIp , lastLoginDate =:lastLoginDate , nowLoginIp =:nowLoginIp ,nowLoginDate=:nowLoginDate where memberId = :memberId ";
			TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);

			if(writeCookie($result['0']))
			{
				//登陆成功
				return $result['0'];
			}
			else
			{
				//提示COOKIE写入失败
				return -4;
			}

		}
		else
		{
			//返回 0，提示:用户名不存在
			return -1;
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//读取用户列表
function memberList($IN)
{
	try
	{
		if(empty($IN['num'])) $IN['num'] = 10;
		if(empty($IN['page'])) $IN['page'] = 1;

		$sql = "select * from {$GLOBALS['table']['member']['member']} $IN[where] order by $IN[order] memberId desc";
		$params['pageSize'] = $IN['num'];
		$params['currentPage'] = $IN['page'];
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//print_r($result);
		return $result;

	}
	catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * 删除用户
 *
 * @param int $array 用户ID号
 * @return true / false
 */
function delMember($array)
{
	try
	{
		if(is_array($array['memberId']))
		{

			foreach ($array['memberId'] as $key=>$value)
			{
				$memberId .= $key == 0?$value:','.$value;
			}

			$sql = "DELETE FROM {$GLOBALS['table']['member']['member']} WHERE memberId in ( {$memberId} )";
			return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		}
		elseif(!empty($array['memberId']))
		{
			$sql = "DELETE FROM {$GLOBALS['table']['member']['member']} WHERE memberId=:memberId";
			$params['memberId'] = $array['memberId'];
			return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		else
		{
			//参数不正确
			return  -1;
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}
}


//用户登出
function memberOut()
{
	if(deleteCookie())
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

//根据COOKIE读取用户信息

function getCookieMemberInfo()
{
	return readCookie();
}


/**
 * 会员ID，会员组数组，如array();
 *
 * @param array $array
 * @return True / False
 */

function memeberBindGroup($array)
{
	try {

		extract ($array, EXTR_PREFIX_SAME, "m_");

		//会员组不是数组形式
		if(!is_array($groupIdArray))
		{
			return  -1;
		}
		//先删除原来的关系对应表
		delMemeberBindGroup($memberId);

		foreach ($groupIdArray as $var)
		{
			$sql = "insert into {$GLOBALS['table']['member']['member_groups']}
			(memberId,groupId) values ('".$memberId."','".$var."')";
			TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}

		return true;

	}catch (Exception $e){

		throw $e;
	}
}
/**
 * 
 * 删除绑定的用户组
 * */
function delMemeberBindGroup($memberId)
{
	try {
		$sql = "delete from {$GLOBALS['table']['member']['member_groups']} where memberId=:memberId";
		$params['memberId'] = $memberId;
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e){
		throw $e;
	}
}

/**
 * 
 * 判断用户绑定了该组
 * 
 * 
 * */
function checkGroup($memberId,$groupId)
{
	try {

		$sql = "select * from {$GLOBALS['table']['member']['member_groups']} where memberId=:memberId and groupId=:groupId";
		$params['memberId'] = $memberId;
		$params['groupId'] = $groupId;
		
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

		if(!empty($result))
		{
			return true;

		}else {

			return false;

		}
	}catch (Exception $e){
		throw $e;
	}
}

?>