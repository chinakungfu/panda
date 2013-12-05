<?php
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.membercenter.Mail');
import('core.apprun.member.encode');
import('core.tpl.TplTemplate');
import('core.apprun.resourceManage.resource');
import('core.apprun.page.Page');
import('core.apprun.yellowpages.yellowpages');


$smtp = new Smtp("ssl://smtp.gmail.com","465",true,"wowshoppingservice@gmail.com","ivision2011");

$result = $smtp->sendmail("334588338@qq.com", "wowshoppingservice@gmail.com", "hello", "hello", "TXT");

print_r($result);