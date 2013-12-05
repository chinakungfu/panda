<?php
require_once('resource_applparam.php');
require_once('resource_mvcconfig.php');
require_once('resource_appAjax.php');
$app_dir = str_replace('\\','/',realpath(dirname(__FILE__)));
$tempAppDir = substr($app_dir,0,strripos($app_dir,'/'));
$core_dir=$tempAppDir.'/web-inf/lib';
if (!defined('corepath'))
{
	define('corepath',$core_dir);
}
if (!defined('apppath'))
{
	define('apppath',$app_dir);
}
require_once(corepath.'/coreconfig/public_gloablparam.php');
require_once(corepath.'/coreconfig/public_func.php');
require_once(corepath.'/coreconfig/public_htmltag.php');
require_once(corepath.'/coreconfig/public_logictag.php');
require_once(corepath.'/coreconfig/public_dbconfig.php');
require_once(corepath.'/coreconfig/public_tableconfig.php');
require_once(corepath.'/coreconfig/public_appconfig.php');
//载入核心函数
require_once(corepath.'/core/incfunc.php');
//include(apppath.'config.php');

import('core.controller.Controller');
if(empty($_GET['LCMSPID']))
{
	if(empty($_GET['action']) and empty($_GET['method']))
	{
		if($_POST['action']=='')
		{
			$_POST['action'] = 'resource';
		}
		if($_POST['method']=='')
		{
			$_POST['method'] = 'index';
		}
	}
}
runMvc();
?>
