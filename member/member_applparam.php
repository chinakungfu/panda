<?php
$app['member']['apppath'] = str_replace('\\','/',realpath(dirname(__FILE__)));
$tempAppDir = substr($app['member']['apppath'],0,strripos($app['member']['apppath'],'/'));
$app['member']['corepath'] =$tempAppDir.'/web-inf/lib';
$app['member']['tpl_source_path']=$app['member']['apppath'].'/tpl/';
$app['member']['tpl_complie_path']=$app['member']['apppath'].'/compile/';
$app['member']['tpl_cache_path']=$app['member']['apppath'].'/cache/';
$app['member']['tpl_request_cache']='false';
$app['member']['tpl_compilefile_prefix']='tpl_';
$app['member']['tpl_compile_filter']='';
$app['member']['tpl_language']='UTF-8';
$app['member']['varprefix']='_$$';
$app['member']['cache_timeout']='300';
$app['member']['cache_path']=$app['member']['apppath'].'/cache/';
$app['member']['openid_tmp_path']=$app['member']['apppath'].'';
$app['member']['openid_required_fields']='';
$app['member']['openid_options_fields']='';
$app['member']['E_Type']='local';
$app['member']['E_localpath']='D:\xampp\htdocs\info\member';
$app['member']['E_URL']='http://localhost/info/member';
$app['member']['Is_createdatabase']='false';
$app['member']['multiTpl']='';$app['member']['pagesize']='10';
$attach['cms']['type'] = '';
$attach['cms']['path'] = 'D:\xampp\htdocs\info\cms';
$attach['cms']['url'] = 'http://localhost/info/cms';
$attach['resource']['type'] = '';
$attach['resource']['path'] = 'd:\cmsroot\resource';
$attach['resource']['url'] = 'http://localhost/resource';
$attach['comment']['type'] = 'local';
$attach['comment']['path'] = 'd:/xampp/htdocs/commoncms/comment';
$attach['comment']['url'] = 'http://localhost/commoncms/comment';
$attach['infomation']['type'] = 'local';
$attach['infomation']['path'] = 'd:/xampp/htdocs/commoncms/infomation';
$attach['infomation']['url'] = 'http://localhost/commoncms/infomation';
$attach['log']['type'] = 'local';
$attach['log']['path'] = 'd:/xampp/htdocs/commoncms/logManage';
$attach['log']['url'] = 'http://localhost/commoncms/logManage';
$attach['membercenter']['type'] = '';
$attach['membercenter']['path'] = '';
$attach['membercenter']['url'] = '';
$attach['member']['type'] = 'local';
$attach['member']['path'] = 'D:\xampp\htdocs\info\member';
$attach['member']['url'] = 'http://localhost/info/member';
$attach['web-inf']['type'] = '';
$attach['web-inf']['path'] = '';
$attach['web-inf']['url'] = '';
include_once($app['member']['corepath'] . '/core/apprun/cmsware/CmswareInit.php');
$currentAppName='member';
$currentApp=&$GLOBALS['app']['member']

?>
