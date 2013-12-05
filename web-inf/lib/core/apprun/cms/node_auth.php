<?
/**
 * add zxqer 20090924
 * 该文件主要用来设置通用ＣＭＳ的结点权限
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.node');
/**
 * 
 * */
function checkDisplayNodeAuth($groupArray,$memberId,$nodeId,$authCode)
{
	try {
		$result = checkNodeAuth($nodeId,$authCode);
		$groupFlag = false;
		$memberFlag = false;
		if(!empty($result))
		{
			$groupAuthArray = explode(',',$result[0]['groupId']);
			$memberAuthArray = explode(',',$result[0]['memberId']);
			foreach ($groupAuthArray as $authkey => $authval)
			{
				if(!empty($groupArray))
				{
					foreach ($groupArray as $key => $val)
					{
						if($authval==$val['groupId'])
						{
							$groupFlag = true;
							break;
						}
					}
				}
			}
			foreach ($memberAuthArray as $authkey => $authval)
			{
				if($memberId!='')
				{
					if($memberId==$authval)
					{
						$memberFlag = true;
						break;
					}
				}
			}
		}
		if($memberFlag||$groupFlag)
		{
			return true;
		}else 
		{
			return false;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function getGroupIdByStaffNo($memberId)
{
	try {
		$staffInfo = getStaffInfoBystaffNo($memberId);
		$sql = "select groupId from {$GLOBALS['table']['member']['staff_groups']} where staffId=:staffId";
		$params['staffId'] = $staffInfo[0]['staffNo'];
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//传入用户账户，查询用户所有信息
function getStaffInfoBystaffNo($memberNo)
{
	try
	{
		$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo= '".$memberNo."'";
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function checkParentAuth($parentNodeGuid)
{
	try {
		global $returnFlagTu;
		$returnFlagTu = false;
		$sql = "select * from {$GLOBALS['table']['cms']['site']} where isDel=0 and parentId=:parentId";
		$params['parentId'] = $parentNodeGuid;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$memberId = readSession();
		$groupIdArray = getGroupIdByStaffNo($memberId);
		if(!empty($result))
		{
			foreach ($result as $key => $val)
			{
				if(checkDisplayNodeAuth($groupIdArray,$memberId,$val['nodeGuid'],'CKJD5tyQ'))
				{
					$returnFlagTu = true;
					break;
				}
				if(!$returnFlagTu)
				{
					$returnFlagTu = false;
					checkParentAuth($val['nodeGuid'],$returnFlagTu);
				}
			}			
		}
		return $returnFlagTu;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>