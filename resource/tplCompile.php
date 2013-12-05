<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
</head>
<?php
require_once('resource_applparam.php');
require_once('resource_appAjax.php');
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

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/save_single_image.tpl');
  ob_flush();

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/single_image.tpl');
  ob_flush();

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/save_resource.tpl');
  ob_flush();

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/edit_resource.tpl');
  ob_flush();

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/frame_list_resource.tpl');
  ob_flush();

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/list_resource.tpl');
  ob_flush();

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/mult_upload_files.tpl');
  ob_flush();

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/save_mult_upload_files.tpl');
  ob_flush();

  $content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/down_file.tpl');
  ob_flush();
ob_end_clean();
?>

