<?php
/**
 * 权限验证函数
 * 根据传入的用户id,应用id,动作id,方法id判断用户的权限状态,
 * 如果传入的某个变量缺少，默认将采用当前状态下的参数值作为验证参数
 * 仅提供返回权限状态数字值
 */

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.member.Session');
function memberAuthArray($uNo,$appId,$moduleId,$actionId)
{
	try
	{ 
		if($uNo=='')
		{
			$uNo = readSession();
		}
		if($uNo=='')
		{
			$uNo = 'tourist';
		}
		$sql = "select e.operationNo,e.distinctionNo from ".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['staff_groups']} b,".
		"{$GLOBALS['table']['member']['group_roles']} c,".
		"{$GLOBALS['table']['member']['role_operations']} d,".
		"{$GLOBALS['table']['member']['operations']} e".
		" where a.staffId=b.staffId and b.groupId=c.groupId ".
		" and c.roleId=d.roleId and d.operationId=e.operationId ".
		" and a.staffNo='".$uNo."'".
		" and e.appId='".$appId."'".
		" and e.moduleId='".$moduleId."'".
		" and e.actionId='".$actionId."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;			
	}catch (Exception $e){
		throw $e;
	}
}
function isMemberAuth($uNo,$appId,$moduleId,$actionId)
{
	try {
		if($uNo=='')
		{
			$uNo = readSession();
		}
		if($uNo=='')
		{
			$uNo = 'tourist';
		}
		if($appId=='')
		{
			$appId = $GLOBALS['currentAppName'];
		}
		if($uNo=='admin')
		{
			$sqlStaff = "select staffId from {$GLOBALS['table']['member']['staff']} where staffNo = '".$uNo."'";
			$resultStaff = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlStaff,$params);
			if(!empty($resultStaff))
			{
				$sqlStaffGroup = "select * from {$GLOBALS['table']['member']['staff_groups']} where staffId = '".$resultStaff[0]['staffId']."'";
				$resultStaffGroup = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlStaffGroup,$params);
			}
			
			if(empty($resultStaffGroup))
			{
				return true;
			}else 
			{
				$sql = "select e.distinctionNo,e.contentFlag from ".
				"{$GLOBALS['table']['member']['staff']} a,".
				"{$GLOBALS['table']['member']['staff_groups']} b,".
				"{$GLOBALS['table']['member']['group_roles']} c,".
				"{$GLOBALS['table']['member']['role_operations']} d,".
				"{$GLOBALS['table']['member']['operations']} e".
				" where a.staffNo=b.staffId and b.groupId=c.groupNo ".
				" and c.roleId=d.roleId and d.operationId=e.operationNo ".
				" and a.staffNo='".$uNo."'".
				" and e.appId='".$appId."'".
				" and e.moduleId='".$moduleId."'".
				" and e.actionId='".$actionId."' group by e.operationNo";
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				return $result;
			}
			
		}else
		{
			$sql = "select e.distinctionNo,e.contentFlag,e.isSecondAuth from ".
			"{$GLOBALS['table']['member']['staff']} a,".
			//"{$GLOBALS['table']['member']['staff_groups']} b,".
			"{$GLOBALS['table']['member']['group_roles']} c,".
			"{$GLOBALS['table']['member']['role_operations']} d,".
			"{$GLOBALS['table']['member']['operations']} e".
			//" where ((a.staffNo=b.staffId and b.groupId=c.groupId) or (a.staffNo = c.groupId)) ".//绑定用户组和角色
			" where a.staffNo = c.groupId".//绑定用户组和角色
			" and c.roleId=d.roleId and d.operationId=e.operationNo ".
			" and a.staffNo='".$uNo."'".
			" and e.appId='".$appId."'".
			" and e.moduleId='".$moduleId."'".
			" and e.actionId='".$actionId."' group by e.operationNo";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return $result;
		}
	}catch (Exception $e){
		throw $e;
	}
}
?>