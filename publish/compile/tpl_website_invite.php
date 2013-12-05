<?php header("Content-type: text/html; charset=utf-8");?>
<?php import('core.util.RunFunc'); ?>
<?php $site_title = runFunc('getGlobalModelVar',array('Site_Name'));
$seo_settings = runFunc("getSeoSettings");
?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]=='' && $this->_tpl_vars["IN"]['inviteID']){
		$inviteID = (int)$this->_tpl_vars["IN"]['inviteID'] / 2 - 1982;
		session_start();
		$_SESSION['inviteID'] = $inviteID;
		header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=registerUser')));	

}else{
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=index')));	
}?>