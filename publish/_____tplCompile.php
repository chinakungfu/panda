<?php
header('content-Type: text/html; charset=utf-8');
require_once('publish_applparam.php');
require_once('publish_appAjax.php');
require_once($GLOBALS['currentApp']['corepath'].'/coreconfig/public_func.php');
require_once($GLOBALS['currentApp']['corepath'].'/coreconfig/public_gloablparam.php');
require_once($GLOBALS['currentApp']['corepath'].'/coreconfig/public_htmltag.php');
require_once($GLOBALS['currentApp']['corepath'].'/coreconfig/public_logictag.php');
require_once($GLOBALS['currentApp']['corepath'].'/coreconfig/public_dbconfig.php');
require_once($GLOBALS['currentApp']['corepath'].'/core/incfunc.php');
import('core.tpl.TplCompile');
import('core.tpl.TplTemplate');
$tpl=new TplCompile();
$tpl->setLogicTags($GLOBALS['currentApp']['logictags']);

ob_start();

//


$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/');
ob_flush();




ob_end_clean();
?>