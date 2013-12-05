<?php
$GLOBALS['currentApp']['apps'] = array(
	'app' => array(
		'cms' => array(
			'localapp'=> true,
			'apppath'=>substr(apppath,0,strripos(apppath,'/')).'/cms/',
			'appUrl'=>'http://gzlonmocms.com/cms/'
		),
		'member' => array(
			'localapp'=> true,
			'apppath'=>substr(apppath,0,strripos(apppath,'/')).'/member/',
			'appUrl'=>'http://gzlonmocms.com/member/'
		),
		'resource' => array(
			'localapp'=> true,
			'apppath'=>substr(apppath,0,strripos(apppath,'/')).'/resource/',
			'appUrl'=>'http://gzlonmocms.com/resource/'
		),
	),
	'siteName' => 'PowerColor Demo Site!'
);
?>