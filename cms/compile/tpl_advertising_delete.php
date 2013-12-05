<?php
import('core.util.RunFunc');
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	
	$page = 1;
}
$sql = "select * from cms_advertising where id in ({$this->_tpl_vars["IN"]["id"]})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$uid=runFunc('readSession',array());
			foreach($result as $item){
				runFunc("makeAdminLog",array("删除  广告 ".$item["title"],$uid));
			}

runFunc("deleteAdvertising",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=advertising_list&type=media&page='.$page)));
