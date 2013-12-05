<?php
/**
 * *****
 * 会员增删改以及查询角色信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.page.Page');
import('core.apprun.cms.system.data_operation');
//验证是否存在
//memberIsExists('username','artfantasy')
//存在返回true
function RoleIsExists($memberNo)
{
	try{
		$sql = "select * from {$GLOBALS['table']['member']['role']} where roleNo='".$memberNo."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
//
//
//function listRole()
//{
//	try {
//		$sql = "select * from {$GLOBALS['table']['member']['role']} order by roleId";
//		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
//	}catch (Exception $e)
//	{
//		throw $e;
//	}
//}
function listRole($sqlCon,$bindFlag)
{
	try {
		if($bindFlag=='1')
		{
			$sql = "select * from {$GLOBALS['table']['member']['role']}";
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
				$sql = "select * from {$GLOBALS['table']['member']['role']} ".$sqlCon." order by roleId desc";
				print "您查找的是：".querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']);	
			}elseif(querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con")!='')
			{
				$sqlCon = querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con");
				$sqlCon ="where ".$sqlCon;
				$sql = "select * from {$GLOBALS['table']['member']['role']} ".$sqlCon;
			}else 
			{
				$sql = "select * from {$GLOBALS['table']['member']['role']} order by roleId desc";
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
//新增一角色，传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//新增成功则返回新建角色的uid,失败则返回false;
function addRole($memberArray)
{
	try
	{
		//$memberArray['password'] = md5($memberArray['password']);
		
		foreach ($memberArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['member']['role']} (".$str_field.") values (".$str_value.")";
		/*$birthDay = '0000-00-00';
		$roleNo = $roleName = $password = $email = $safetyQuestion = $questionResult = $sex = $homepage = $qq = $rowId = $msn='';
		extract($memberArray);
		!preg_match("/^(((19)|(20))[0-9][0-9])-(1[0-2]|0[1-9])-(3[0,1]|[1,2][0-9]|0[1-9])$/i",$birthdate) && $birthdate = '0000-00-00';
		
		
		//$sql = "insert into {$GLOBALS['table']['member']['role']}
				//(roleNo,roleName,password,email,safetyQuestion,questionResult,sex,birthDay,homepage,qq,rowId,msn)
				//values (:roleNo,:roleName,:password,:email,:safetyQuestion,:questionResult,:sex,:birthDay,:homepage,:qq,:rowId,:msn)";
		$params = array(
				'roleNo' => $roleNo,
				'roleName' => $roleName,
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

//修改指定uid的角色信息,传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//失败返回false, 成功返回影响行数
function editRole($memberId,$memberArray)
{
	try
	{	
		foreach ($memberArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['member']['role']} set $sql where roleId=".$memberId;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}

//根据某角色属性删除角色,比如根据uid,email
function delRole($memberId)
{
	try
	{
		
		$infoIdArray = explode(',',$memberId);
		for($i=0;$i<count($infoIdArray)-1;$i++)
		{
			$sql = "DELETE FROM {$GLOBALS['table']['member']['role']} WHERE `roleId`=:roleId";
			$params['roleId'] = $infoIdArray[$i];
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return true;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//传入角色ID，查询角色所有信息
function getRoleInfoById($memberId)
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['member']['role']} where roleId= {$memberId}";
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//自动生成角色标识
//=============================================
function fullRoleFlag($roleName)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($roleName);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/*
**
**角色绑定操作
*/
function roleBindOperation($roleId,$operationId)
{
	try {
		$sql = "insert into {$GLOBALS['table']['member']['role_operations']} (roleId,operationId) values ('".$roleId."','".$operationId."')";
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e)
	{
		throw $e;
	}
}
/*
**
**删除绑定的操作
*/
function delRoleBindOperation($roleId)
{
	try {
		$sql = "delete from {$GLOBALS['table']['member']['role_operations']} where roleId='".$roleId."'";
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e){
		throw $e;
	}
}
/*
**
**判断该角色绑定了哪些操作
*/
function checkOperation($roleId,$operationId)
{
	try {
		$roleId = trim($roleId);
		$operationId = trim($operationId);
		$sql = "select * from {$GLOBALS['table']['member']['role_operations']} where roleId='".$roleId."' and operationId='".$operationId."'";		
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