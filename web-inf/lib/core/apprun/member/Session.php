<?php
/**
 * *****
 * session的操作函数
 * 
 */
import('core.apprun.member.dbsession');
import('core.incfunc');
function openSession()
{	
}
function closeSession()
{	
}
function writeSession($userInfo)
{
	date_default_timezone_set('PRC');
	session_start();
	$sessId = md5(session_id());
	$IN = oas_parse_incoming();
	$ipAdr = $IN['IP_ADDRESS']; 
	setcookie("sesCoo",$sessId,time()+36000,'/');
	$sessData = $userInfo;
	$dbSession = new dbSession();
	return $dbSession->write($sessId,$sessData,$ipAdr,time()+36000);	
}
function readSession()
{
	$sessId = $_COOKIE['sesCoo'];
	//print $sessId;
	$dbSession = new dbSession();
	return $dbSession->read($sessId);
}
function destroySession()
{
	session_start();
	$sessId = $_COOKIE['sesCoo'];
	$dbSession = new dbSession();
	session_destroy();
	return $dbSession->destroy($sessId);
}
function gcSession()
{
	$sessId = $_COOKIE['sesCoo'];
	$dbSession = new dbSession();
	return $dbSession->gc($sessId);
}
function getSessionID()
{
	date_default_timezone_set('PRC');
	session_start();
	$sessId = md5(session_id());
	return $sessId;
}
?>