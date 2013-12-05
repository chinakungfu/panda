<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
</head>
<?php
require_once('member_applparam.php');
require_once('member_appAjax.php');
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

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/group/bind_role.tpl');
ob_flush();


$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/group/edit_group.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/group/frame_list_group.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/group/group_bind_role.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/group/save_group.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/operation/edit_operation.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/operation/frame_list_operation.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/operation/list_operation.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/operation/save_operation.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/role/bind_operation.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/role/check_role_no.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/role/edit_role.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/role/frame_list_role.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/role/list_role.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/role/role_bind_operation.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/role/save_role.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/user/bind_group.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/left.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/user/edit_user.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/user/frame_list_user.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/user/list_user.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/user/save_user.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/user/select_user_no.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/user/user_bind_group.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/session_destroy.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/title.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/group/list_group.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/button_left.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/check_staff_no.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/check_user.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/detail_user.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/find_password.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/find_passworded.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/login.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/logout.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/mail_send_to_message.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/main.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/modify_password.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/modify_user.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/question_result.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/save_modify_user.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/save_password.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/send_to_mail.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/set_password.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/role/full_role_flag.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/group/full_group_flag.tpl');
ob_flush();

$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/operation/full_operation_flag.tpl');
ob_flush();
$content=$tpl->compile($GLOBALS['currentApp']['apppath'].'/tpl/check_login.tpl');
ob_flush();
ob_end_clean();
?>

