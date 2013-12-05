<?php
/**
 * *****
 * 会员增删改以及查询用户组信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.page.Page');
import('core.apprun.cms.system.data_operation');
//验证是否存在
//memberIsExists('username','artfantasy')
//存在返回true
function GroupIsExists($memberNo)
{
	try{
		$sql = "SELECT * FROM {$GLOBALS['table']['member']['group']} WHERE groupNo= :groupNo LIMIT 1";
		$params['groupNo'] = $memberNo;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return (boolean)$result[0]['id'];
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
//
//
//function listGroup()
//{
//	try {
//		$sql = "select * from {$GLOBALS['table']['member']['group']} order by groupId";
//		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
//	}catch (Exception $e)
//	{
//		throw $e;
//	}
//}
function listGroup($sqlCon,$bindFlag)
{
	try {
		if($bindFlag=='1')
		{
			$sql = "select * from {$GLOBALS['table']['member']['group']}";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return $result;
		}else 
		{
			if($sqlCon!=null)
			{
				$Con = substr($sqlCon,strpos($sqlCon,'%')+1,-2);
				setSession($GLOBALS['IN']['action'],$GLOBALS['IN']['method'],$Con);
				setSession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con",$sqlCon);
				$paramStr = "'".$sqlCon."'";
				$sqlCon ="where ".$sqlCon;
				$sql = "select * from {$GLOBALS['table']['member']['group']} ".$sqlCon;
				print "您查找的是：".querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
			}elseif(querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con")!='')
			{
				$sqlCon = querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con");
				$sqlCon ="where ".$sqlCon;
				$sql = "select * from {$GLOBALS['table']['member']['group']} ".$sqlCon." order by groupId desc";
			}else 
			{
				$sql = "select * from {$GLOBALS['table']['member']['group']} order by groupId desc";
			}
			//$sql = "select * from {$GLOBALS['table']['member']['staff']}".$sqlCon;
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
			if(!$GLOBALS["pageconfig"]['member']['pagesize'])
			{
				$GLOBALS["pageconfig"]['member']['pagesize'] = 10;
			}
			$params['pageSize'] = $GLOBALS["pageconfig"]['member']['pagesize'];
			$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			$result['pageinfo']['isText'] = $isText;
			$result['pageinfo']['wherestr'] = $paramStr;
			return $result;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
//新增一用户组，传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//新增成功则返回新建用户组的uid,失败则返回false;
function addGroup($memberArray)
{
	try
	{
		foreach ($memberArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['member']['group']} (".$str_field.") values (".$str_value.")";
		/*$birthDay = '0000-00-00';
		$groupNo = $groupName = $password = $email = $safetyQuestion = $questionResult = $sex = $homepage = $qq = $rowId = $msn='';
		extract($memberArray);
		!preg_match("/^(((19)|(20))[0-9][0-9])-(1[0-2]|0[1-9])-(3[0,1]|[1,2][0-9]|0[1-9])$/i",$birthdate) && $birthdate = '0000-00-00';
		
		
		//$sql = "insert into {$GLOBALS['table']['member']['group']}
				//(groupNo,groupName,password,email,safetyQuestion,questionResult,sex,birthDay,homepage,qq,rowId,msn)
				//values (:groupNo,:groupName,:password,:email,:safetyQuestion,:questionResult,:sex,:birthDay,:homepage,:qq,:rowId,:msn)";
		$params = array(
				'groupNo' => $groupNo,
				'groupName' => $groupName,
				'password' => $password,
				'email' => $email,
				'safetyQuestion' => $safetyQuestion,
				'questionResult' => $questionResult,
				'sex' => $sex,
				'birthDay' => $birthDay,
				'homepage' => $homepage,
				'qq' => $qq,
				'rowId' => $rowId,
				'msn' => $msn,
			);*/
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
	} 
	catch (Exception $e)
	{
		throw $e;
	}
}

//修改指定uid的用户组信息,传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//失败返回false, 成功返回影响行数
function editGroup($memberId,$memberArray)
{
	try
	{	
		foreach ($memberArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['member']['group']} set $sql where groupId=".$memberId;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}

//根据某用户组属性删除用户组,比如根据uid,email
function delGroup($memberId)
{
	try
	{
		$infoIdArray = explode(',',$memberId);
		for($i=0;$i<count($infoIdArray)-1;$i++)
		{
			$sql = "DELETE FROM {$GLOBALS['table']['member']['group']} WHERE `groupId`=:groupId";
			$params['groupId'] = $infoIdArray[$i];
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return true;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//传入用户组ID，查询用户组所有信息
function getGroupInfoById($memberId)
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['member']['group']} where groupId= {$memberId}";
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//自动生成用户组标识
//=============================================
function fullGroupFlag($groupName)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($groupName);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function getGroupInfoByStr($groupIdStr)
{
	try {
		if($groupIdStr!='')
		{
			$sql = "select * from {$GLOBALS['table']['member']['group']} where groupNo in (".$groupIdStr.")";
			return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
//
//用户或用户组绑定角色
function staffGroupBindRole($groupId,$roleId,$RelationType)
{
	try {
		$sql = "insert into {$GLOBALS['table']['member']['group_roles']} (groupId,roleId,relationType) values ('".$groupId."','".$roleId."','".$RelationType."')";
		//print $sql;
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 删除绑定的角色
 * */
function delGroupBindRole($groupId,$type)
{
	try {
		$sql = "delete from {$GLOBALS['table']['member']['group_roles']} where groupId='".$groupId."' and relationType='".$type."'";
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e){
		throw $e;
	}
}
/*
**
**
**判断用户组或用户绑定了哪些角色
*/
function checkRole($groupId,$roleId,$type)
{
	try {
		$groupId = trim($groupId);
		$roleId = trim($roleId);
		$type = trim($type);
		$sql = "select * from {$GLOBALS['table']['member']['group_roles']} where groupId='".$groupId."' and roleId='".$roleId."' and relationType=".$type;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if($result!=null)
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