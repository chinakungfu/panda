<?php

import('core.apprun.member.Group');
import('core.apprun.member.Role');
import('core.apprun.member.Operation');
import('core.datasource.DbFactory');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.function.functions');
import('core.apprun.member.cookie');
import('core.apprun.member.member');
import('core.apprun.member.app');
/**
 * 根据用会员名或者会员ID号获取会员信息
 *
 * @param 函数名 $func
 * @param 参数 $params
 * @return unknown
 */


function callFunc($funcId,$params = NULL)
{
	$strCode=$funcId.'($params)';
	eval("\$rslt=".$strCode.";");
	return $rslt;
}


/**
 * 根据用户名或者用户ID获取用户信息,默认为用户名
 *
 * @param String $memberName 会员名
 * @param Int $isMemberId  会员ID
 * @param String $returnkey 返回字段
 * @return unknown
 */

function API_getMemberInfo($memberName,$isMemberId = NULL , $returnkey = NULL)
{
	return callFunc('getMemberInfo',array('memberName'=>$memberName,'isMemberId'=>$isMemberId,'returnkey'=>$returnkey));
}

/**
 * 获取附加字段的内容
 *
 * @param unknown_type $MemberId
 */

function API_getMemberField($MemberId)
{
	return getMemberField($MemberId);
}


/**
 * 注册接口
 *
 * @param String $memberName 会员名
 * @param String $passWord 密码（明文）
 * @param String $email 电子邮件
 * @param Int $state 用户状态
 * @param Int $gid 默认组
 * @param String $nickName 昵称
 * @return errer_id,memberid
 */

function API_register($memberName,$passWord,$email,$state = 1,$nickName = NULL)
{
	return callFunc('addMember',array('memberName'=>$memberName,'passWord'=>md5($passWord),'email'=>$email,'state'=>$state,'nickName'=>$nickName));
}

/**
 * 新增会员属性附加数组
 * 
 *
 * @param array $param
 * @param Int $memberId 会员ID
 */

function API_insertMemberField($param)
{
	return insertMemberField($param);
}


/**
 * 编辑会员属性附加数组
 * 
 *
 * @param array $param
 * @param Int $memberId 会员ID
 */
function API_updateMemberField($param,$memberId)
{
	return updateMemberField($param,$memberId);
}



/**
 * 用户登陆接口
 *
 * @param String $memberName 用户名
 * @param String $passWord 密码(明文)
 * @return errer_id，memberid
 */
function API_login($memberName,$passWord)
{
	$member_info = API_getMemberInfo($memberName);
	unset($member_info['passWord']);
	return writeCookie($member_info);
	//return callFunc('checkMemberInfo',array('memberName'=>$memberName,'passWord'=>md5($passWord)));
}

/**
 * 用户修改资料
 *
 * @param String $memberId 会员名
 * @param String $email 电子邮件
 * @param Int $state 用户状态
 * @param Int $gid 默认组
 * @param String $nickName 昵称
 * @param String $question 问题
 * @param String $answer 答案
 * @return errer_id,memberid
 */

function API_editMember($memberId,$email,$state='',$nickName='',$question='',$answer='')
{
	return callFunc('editMember',array('memberId'=>$memberId,'email'=>$email,'state'=>$state,'nickName'=>$nickName,'question'=>$question,'answer'=>$answer));

}

/**
 * 修改密码
 *
 * @param String $memberId 会员id
 * @param String $oldPassword 旧密码
 * @param String $newPassword 新密码
 * @param String $isAdmin 是否为管理模式
 * @return return true/false
 * 
 */
function API_editPassWord($memberId,$oldPassword,$newPassword,$isAdmin = 0){
	return callFunc('changePassWord',array('memberId'=>$memberId,'oldPassword'=>$oldPassword,'newPassword'=>$newPassword,'isAdmin'=>$isAdmin));
}

/**
 * 获取会员列表
 *
 * @param Int $page 页数
 * @param Int $num 数目
 * @param String $where 查询条件
 * @param String $order 排序
 * @return $array
 */

function API_listMember($num,$page = NULL,$where = NULL,$order = NULL)
{
	return callFunc('memberList',array('num'=>$num,'page'=>$page,'where'=>$where,'order'=>$order));
}

/**
 * 删除会员信息
 *
 * 如果想同时删除多个会员，请传入数组的形式如 $memberId = array(1,2,3,3,4,5);
 * 
 * @param int $memberId 会员ID
 * @return True / False
 */
function API_delMember($memberId)
{
	return callFunc('delMember',array('memberId'=>$memberId));
}

/**
 * 判断会员是否绑定该组
 *
 * @param Int $memberId 会员ID
 * @param Int $groupId 会员组
 */
function API_checkGroup($memberId,$groupId)
{
	$GLOBALS['currentApp']['dbaccess']=DbFactory::getDataAccessByDsId($GLOBALS['currentApp']['defaultDataSourceId']);
	return checkGroup($memberId,$groupId);
}


/**
 * 验证问题
 *
 * @param Int  $memberId 会员ID
 * @param String $question 问题
 * @param String $answer 答案
 * @return unknown
 */
function API_checkQuestion($memberId,$question,$answer)
{
	return callFunc('checkQuestion',array('memberId'=>$memberId,'question'=>$question,'answer'=>$answer));
}

/**
 *  绑定会员组;
 *  组用数据形式传入 
 *  如
 *  API_memeberBindGroup(1,array(11,12))
 * 
 * 
 * @param Int $memberId 会员ID
 * @param Int array  $groupIdArray
 * @return True / False
 */

function API_memeberBindGroup($memberId,$groupIdArray)
{
	return callFunc('memeberBindGroup',array('memberId'=>$memberId,'groupIdArray'=>$groupIdArray));
}

/**
 * 读取COOKIE中的用户，
 * @return UserInfo / FLASE
 */

function API_getCookieMemberInfo()
{

	return getCookieMemberInfo();
}
/**
 * 清除COOKIE
 *
 * @return unknown
 */
function API_clearCookie()
{
	return memberOut();
}

/**
 * 
 * 会员部分结束
 * 组操作开始
 * 
 */

/**
 * 根据组ID来获取组信息
 *
 * @param Int $groupId 组ID
 * @return GroupInfo
 */ 
function  API_getGroupInfoById($groupId)
{
	return getGroupInfoById($groupId);
}


/**
 * 根据组名获取组信息
 *
 * @param  String  $groupNo 组标识
 * @return GroupInfo
 */
function API_getGroupInfoByNo($groupNo)
{
	return getGroupInfoByNo($groupNo);
}

/**
 * 添加会员组
 *
 * @param String $groupNo 组标识
 * @param String $groupName 组名
 * @param String $remark 简介
 * @return groupId / errer_id
 */
function API_addGroup($groupNo,$groupName,$remark)
{
	return callFunc('addGroup',array('groupNo'=>$groupNo,'groupName'=>$groupName,'remark'=>$remark));
}

/**
 * 修改组信息
 *
 * @param Int $groupId 组ID
 * @param String $groupNo 组标识
 * @param String $groupName 组名
 * @param String $remark 简介
 * @return true / errer_id
 */
function API_editGroup($groupId,$groupNo,$groupName,$remark)
{
	return callFunc('editGroup',array('groupId'=>$groupId,'groupNo'=>$groupNo,'groupName'=>$groupName,'remark'=>$remark));
}


/**
 * 删除分组
 *
 * @param int $groupId 组ID
 * @return  True / False
 */

function API_delGroup($groupId)
{
	return callFunc('delGroup',array('groupId'=>$groupId));
}

/**
 * 获取组列表
 *
 * @param Int $num   数量
 * @param Int $page  分页
 * @param String $where  条件
 * @param String $order  排序
 * @return groupList
 */


function API_listGroup($num,$page,$where = NULL,$order = NULL)
{
	return callFunc('listGroup',array('num'=>$num,'page'=>$page,'where'=>$where,'order'=>$order));
}

/**
 *  给会员组绑定权限
 * 
 * @param Int $groupId 组ID
 * @param Int $roleId 权限ID
 * @return ID / False
 */
function API_GroupBindRole($groupId,$roleId)
{
	return memberGroupBindRole($groupId,$roleId,0);
}

/**
 * 给会员绑定权限
 *
 * @param Int $memberId 会员ID
 * @param Int $roleId 权限ID
 * @return ID / False
 */

function API_memberBindRole($memberId,$roleId)
{
	return memberGroupBindRole($memberId,$roleId,1);
}


/**
 * 检查会员组是否绑定指定的角色
 * 
 *
 * @param Int $groupId 组ID
 * @param Int $roleId 角色ID
 * @return True / False
 * 
 */

function API_checkGroupRole($groupId,$roleId)
{
	return checkRole($groupId,$roleId,0);
}

/**
 * 检查会员是否绑定指定的角色
 *
 * @param Int $memberId 会员ID
 * @param Int $roleId 角色ID
 * @param String $type
 * @return True / False
 */

function API_checkMemberRole($memberId,$roleId)
{
	return checkRole($memberId,$roleId,1);
}

/**
 * 删除组绑定的角色
 *
 * @param Int $groupId 组ID
 * @return True / False
 */

function API_deleteGroupRole($groupId)
{
	return delGroupBindRole($groupId);
}
/**
 * 删除会员绑定的角色
 *
 * @param Int $memberId 会员ID
 * @return True / False
 */

function API_deleteMemberRole($memberId)
{
	return delGroupBindRole($memberId);
}

/**
 * 会员组部分结束
 * 角色管理开始
 * 
 */


/**
 * 根据ID获取角色的信息
 *
 * @param Int $Id 角色ID
 * @return unknown
 */
function API_getRoleInfoById($Id)
{
	return getRoleInfoById($Id);
}

/**
 * 根据标识获取角色的信息
 *
 * @param String $No 角色标识
 * @return unknown
 */

function API_getRoleInfoByNo($No)
{
	return getRoleInfoByNo($No);
}

/**
 * 获取角色列表
 *
 * @param Int $num 数量
 * @param Int $page 分页
 * @param Strring $where 查询条件
 * @param Strring $order 排序
 * @return reslut
 */
function API_listRole($num,$page=NULL,$where = NULL,$order = NULL)
{
	return callFunc('listRole',array('num'=>$num,'page'=>$page,'where'=>$where,'order'=>$order));
}

/**
 * 添加角色
 *
 * @param String $roleNo 角色标识
 * @param String $roleName 角色名
 * @param String $roleDesc 角色简介
 * @return unknown
 */
function API_addRole($roleNo,$roleName,$roleDesc)
{
	return callFunc('addRole',array('roleNo'=>$roleNo,'roleName'=>$roleName,'roleDesc'=>$roleDesc));
}
/**
 * 编辑角色
 *
 * @param Int $roleId 角色Id
 * @param String $roleNo 角色标识
 * @param String $roleName 角色名
 * @param String $roleDesc 角色描述
 * @return Id / False
 */
function API_editRole($roleId,$roleNo,$roleName,$roleDesc)
{
	return callFunc('editRole',array('roleId'=>$roleId,'roleNo'=>$roleNo,'roleName'=>$roleName,'roleDesc'=>$roleDesc));
}
/**
 * 删除角色
 *
 * @param Int $RoleId 角色ID
 * @return unknown
 */
function API_delRole($RoleId)
{
	return delRole($RoleId);
}

/**
 * 角色绑定权限
 *
 * @param Int $roleId
 * @param Int $operationId
 * @return unknown
 */

function API_roleBindOperation($roleId,$operationId)
{
	return roleBindOperation($roleId,$operationId);
}
/**
 * 删除角色绑定的权限
 *
 * @param  Int $Id 角色ID
 * @return True / False
 */
function API_delRoleBindOperation($Id)
{
	return delRoleBindOperation($Id);
}

/**
 * 检查角色是否绑定
 *
 * @param Int $roleId 角色ID
 * @param Int $operationId 权限ID
 * @return unknown
 */

function API_checkOperation($roleId,$operationId)
{
	return checkOperation($roleId,$operationId);
}

/**
 * 角色结束
 */

/**
 * 根据ID号获取权限的信息
 *
 * @param Int $Id 权限ID
 * @return unknown
 */
function API_getOperationInfoById($Id)
{
	return getOperationInfoById($Id);
}
/**
 * 根据标识获取权限的信息
 *
 * @param String $No 权限标识
 * @return unknown
 */
function API_getOperationInfoByNo($No)
{
	return getOperationInfoByNo($No);
}
/**
 * 权限列表
 *
 * @param Int $num 数量
 * @param Int $page 分页
 * @param String $where 条件
 * @param String $order 排序
 * @return unknown
 */

function API_listOperation($num,$page=NULL,$where = NULL,$order = NULL)
{
	return callFunc('listOperation',array('num'=>$num,'page'=>$page,'where'=>$where,'order'=>$order));
}

/**
 * 添加权限
 *
 * @param String $operationNo 操作标识
 * @param String $operationName 操作名称
 * @param Int $appId 应用ID
 * @param Int $moduleId 模块ID
 * @param Int $actionId 动作ID
 * @return unknown
 */
function API_addOperation($operationNo,$operationName,$appId,$moduleId,$actionId)
{
	return callFunc('addOperation',array('operationNo'=>$operationNo,'operationName'=>$operationName,'appId'=>$appId,'moduleId'=>$moduleId,'actionId'=>$actionId));
}

/**
 * 编辑权限
 *
 * @param Int $operationId 权限ID
 * @param String $operationNo 操作标识
 * @param String $operationName 操作名称
 * @param Int $appId 应用ID
 * @param Int $moduleId 模块ID
 * @param Int $actionId 动作ID
 * @return unknown
 */
function API_editOperation($operationId,$operationNo,$operationName,$appId,$moduleId,$actionId)
{
	return callFunc('editOperation',array('operationId'=>$operationId,'operationNo'=>$operationNo,'operationName'=>$operationName,'appId'=>$appId,'moduleId'=>$moduleId,'actionId'=>$actionId));
}
/**
 * 删除权限
 *
 * @param Int $operationId
 * @return unknown
 */
function API_delOperation($operationId)
{
	return delOperation($operationId);
}


/**
 * 应用列表 
 */


/**
 * 应用列表 
 *
 * @param Int $num 数量
 * @param Int $page 分页
 * @param String $where 条件
 * @param String $order 排序
 * @return unknown
 */

function API_listApp($num,$page=NULL,$where = NULL,$order = NULL)
{
	return callFunc('listApp',array('num'=>$num,'page'=>$page,'where'=>$where,'order'=>$order));
}
?>