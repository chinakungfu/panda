<?
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
/**
 * 获得给定的日期离当前日期还有多少天
 * **/
function getDays($dateStr)
{
	try {
		date_default_timezone_set('PRC');
		$currentDate = strtotime(date("Y-m-d"));
		$dateStr = strtotime($dateStr);
		$a_dt=getdate($currentDate);
		$b_dt=getdate($dateStr);
		$a_new=mktime(12,0,0,$a_dt['mon'],$a_dt['mday'],$a_dt['year']);
		$b_new=mktime(12,0,0,$b_dt['mon'],$b_dt['mday'],$b_dt['year']);
		return round(abs($a_new-$b_new)/86400);
	}catch (Exception $e)
	{
		throw $e;
	}
}
function loginCheck($userId,$password)
{
	//session_start();
	$password = md5($password);
	$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo='".$userId."' and block=0 and password='".$password."'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	//print_r($sql);
	//print_r('<BR>');
	//print_r($password);
	if($result!=null)
	{
		//unset($_SESSION['LoginErrNum']);
		return $result;
		print_r($result);
	}else
	{		
			//$_SESSION['LoginErrNum'] ++;
			return false;
		
	}
}
?>