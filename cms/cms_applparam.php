<?php
$app['cms']['apppath'] = str_replace('\\','/',realpath(dirname(__FILE__)));
$tempAppDir = substr($app['cms']['apppath'],0,strripos($app['cms']['apppath'],'/'));
$app['cms']['corepath'] =$tempAppDir.'/web-inf/lib';
$app['cms']['tpl_source_path']=$app['cms']['apppath'].'/tpl/';
$app['cms']['tpl_complie_path']=$app['cms']['apppath'].'/compile/';
$app['cms']['tpl_cache_path']=$app['cms']['apppath'].'/cache/';
$app['cms']['tpl_request_cache']='';
$app['cms']['tpl_compilefile_prefix']='tpl_';
$app['cms']['tpl_compile_filter']='';
$app['cms']['tpl_language']='UTF-8';
$app['cms']['varprefix']='_$$';
$app['cms']['cache_timeout']='800';
$app['cms']['cache_path']=$app['cms']['apppath'].'/cache/';
$app['cms']['openid_tmp_path']=$app['cms']['apppath'].'';
$app['cms']['openid_required_fields']='';
$app['cms']['openid_options_fields']='';
$app['cms']['Is_createdatabase']='';
$app['cms']['E_realpath']='/home/vhosts/www.66guo.com/cms';
$app['cms']['E_apppath']='/home/vhosts/www.66guo.com/cms';
$app['cms']['E_corepath']='/home/vhosts/www.66guo.com/web-inf/lib';
$attach['cms']['type'] = 'remote';
$attach['cms']['path'] = 'D:\xampp\htdocs\info\cms';
$attach['cms']['url'] = 'http://localhost/info/cms';
$attach['publish']['type'] = 'local';
$attach['publish']['path'] = 'D:\xampp\htdocs\info\publish';
$attach['publish']['url'] = 'http://localhost/info/publish';
$attach['user']['type'] = '';
$attach['user']['path'] = 'D:\cmsroot\user';
$attach['user']['url'] = 'http://localhost/user';
$attach['resource']['type'] = '';
$attach['resource']['path'] = 'd:\cmsroot\resource';
$attach['resource']['url'] = 'http://localhost/resource';
$attach['member']['type'] = 'local';
$attach['member']['path'] = 'D:\xampp\htdocs\info\member';
$attach['member']['url'] = 'http://localhost/info/member';
include_once($app['cms']['corepath'] . '/core/apprun/cmsware/CmswareInit.php');
$currentAppName='cms';
$currentApp=&$GLOBALS['app']['cms'];
//$mail['member']['smtpserver']='ssl://smtp.gmail.com';
$mail['member']['smtpserver']='ssl://smtp.exmail.qq.com';
$mail['member']['smtpserverport']='465';
/*$mail['member']['smtpusermail']='wowshoppingservice@gmail.com';
$mail['member']['smtpuser']='wowshoppingservice@gmail.com';
$mail['member']['smtppass']='wowshopping2012';*/
$mail['member']['smtpusermail']='service@wowshopping.com.cn';
$mail['member']['smtpuser']='service@wowshopping.com.cn';
$mail['member']['smtppass']='wowshopping2012';

$mail['member']['pasttime']='1';
$mail['member']['mailtype']='HTML';
/*$taobao['appkey'] = "21479038";
$taobao['secretKey'] = "a32ad48af7ea2b59d52d1a8817d70bfb";*/
$taobao['appkey'] = "21552735";
$taobao['secretKey'] = "e51cbedde412b5d7f43629f600e33112";
?>