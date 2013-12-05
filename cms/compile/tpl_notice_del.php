<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	$page = 1;
}
if($this->_tpl_vars["IN"]["status"]){
	$status = $this->_tpl_vars["IN"]["status"];
}

$id = $this->_tpl_vars["IN"]["id"];
$noticeList = runFunc("getAdminNoticeById",array($id));
$uid=runFunc('readSession',array());
runFunc("makeAdminLog",array("删除公告 ".$noticeList["title"],$uid));
runFunc("deleteNotice",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=notice_list&type=users&page='.$page.'&status='.$status)));