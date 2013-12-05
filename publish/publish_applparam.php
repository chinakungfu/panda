<?php
$app['publish']['apppath'] = str_replace('\\','/',realpath(dirname(__FILE__)));
$tempAppDir = substr($app['publish']['apppath'],0,strripos($app['publish']['apppath'],'/'));
$app['publish']['domainpath'] =$tempAppDir;
$app['publish']['corepath'] =$tempAppDir.'/web-inf/lib';
$app['publish']['tpl_source_path']=$app['publish']['apppath'].'/tpl/';
$app['publish']['tpl_complie_path']=$app['publish']['apppath'].'/compile/';
$app['publish']['tpl_cache_path']=$app['publish']['apppath'].'/cache/';
$app['publish']['tpl_request_cache']='';
$app['publish']['tpl_compilefile_prefix']='tpl_';
$app['publish']['tpl_compile_filter']='';
$app['publish']['tpl_language']='UTF-8';
$app['publish']['varprefix']='_$$';
$app['publish']['cache_timeout']='300';
$app['publish']['cache_path']=$app['publish']['apppath'].'/cache/';
$app['publish']['openid_tmp_path']=$app['publish']['apppath'].'';
$app['publish']['openid_required_fields']='';
$app['publish']['openid_options_fields']='';
/*
$mail['member']['smtpserver']='ssl://smtp.gmail.com';
$mail['member']['smtpserverport']='465';
$mail['member']['smtpusermail']='wowshoppingservice@gmail.com';
$mail['member']['smtpuser']='wowshoppingservice@gmail.com';
$mail['member']['smtppass']='wowshopping2012';
*/
$mail['member']['smtpserver']='ssl://smtp.exmail.qq.com';
$mail['member']['smtpserverport']='465';
$mail['member']['smtpusermail']='service@wowshopping.com.cn';
$mail['member']['smtpuser']='service@wowshopping.com.cn';
$mail['member']['smtppass']='wowshopping2012';
$mail['member']['pasttime']='1';
$mail['member']['mailtype']='HTML';
$app['publish']['E_Type']='local';
$app['publish']['E_localpath']='D:\xampp\htdocs\info\publish';
$app['publish']['E_URL']='http://localhost/info/publish';
$app['publish']['multiTpl']='';

/*$app['publish']['urlParamType']='pathinfo';
$app['publish']['urlParams']=array(
	'a'=>'action',
	'm'=>'method',
	'n'=>'nodeId',
	'p'=>'page',
	'c'=>'currentPage'
);*/
$app['publish']['multiTpl']='';
$app['publish']['resourcetype']='图片,文件,音乐,电影,其它|image,file,music,movie,else';$app['resource']['resourceOfApp']='会员,会员中心,黄页,其它|member,memberCenter,yellowPages,else';
$app['publish']['resourceconfig']=array('member'=>array('servername'=>'一号','servermode'=>'local','serverftp'=>'','serverftpname'=>'','serverftppass'=>'','locate'=>'upfile','locateurl'=>'http://www.lonmo.com/bjyp/resourceManage/upfile/'),'source'=>array('servername'=>'二号','servermode'=>'ftp','serverftp'=>'lonmo.com','serverftpname'=>'user','serverftppass'=>'pass','locate'=>'/upfile/','locateurl'=>'http://www.lonmo.com/bjyp/resourceManage/upfile/'));
$app['publish']['uploadGoodsImgMaxCount']='2';
$attach['resource']['type'] = '';
$attach['resource']['path'] = 'd:\cmsroot\resource';
$attach['resource']['url'] = 'http://localhost/resource';
$attach['member']['type'] = 'local';
$attach['member']['path'] = 'D:\xampp\htdocs\info\member';
$attach['member']['url'] = 'http://localhost/info/member';
$attach['publish']['type'] = 'local';
$attach['publish']['path'] = 'D:\xampp\htdocs\info\publish';
$attach['publish']['url'] = 'http://localhost/info/publish';
$attach['user']['type'] = '';
$attach['user']['path'] = 'D:\cmsroot\user';
$attach['user']['url'] = 'http://localhost/user';
$attach['cms']['type'] = '';
$attach['cms']['path'] = 'D:\xampp\htdocs\info\cms';
$attach['cms']['url'] = 'http://localhost/info/cms';
$attach['web-inf']['type'] = '';
$attach['web-inf']['path'] = '';
$attach['web-inf']['url'] = '';
/**淘宝开发key设置**/
/*$taobao['appkey'] = "12666932";
$taobao['secretKey'] = "52ed26db2c1dcc3b06523748b59eeb18";*/
$taobao['appkey'] = "21552735";
$taobao['secretKey'] = "e51cbedde412b5d7f43629f600e33112";
$taobao['other'] = '口味,套餐,套餐类型,容量,金重,食品品类|flavour,combo,combo,volume,weight,category';
include_once($app['publish']['corepath'] . '/core/apprun/cmsware/CmswareInit.php');
$currentAppName='publish';
$currentApp=&$GLOBALS['app']['publish'];

?>
