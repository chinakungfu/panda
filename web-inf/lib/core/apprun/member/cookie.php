<?php
/*********************************************
* Cewer 4 (CMSware)
* Copyright by Lonmo Inc. All right reserved
* 2004-2012
* www.lonmo.com
**********************************************/
/**
 * *****
 * cokie的操作函数
 * 
 */

import('core.function.functions');


function writeCookie($userInfo)
{

	//加密COOKIE值
	$userInfo = serialize($userInfo);
	$cookie = passport_encrypt($userInfo,'#$%DF&^$8454dD23c');

	if(setcookie('member',$cookie,time() + 3600 * 24,'/'))
	{
		return true;
	}
	else
	{
		return false;
	}
	
}
function readCookie()
{

	//$cookie = passport_decrypt($_COOKIE[$GLOBALS['currentAppName']],$GLOBALS['currentApp']['cookie_key']);
	$cookie = passport_decrypt($_COOKIE['member'],'#$%DF&^$8454dD23c');
	return unserialize($cookie);
}

function deleteCookie()
{
	if(setcookie('member',$cookie,time() - 3600 * 24,'/'))
	{
		
		return true;
	}
	else
	{
		return false;
	}	
}

?>