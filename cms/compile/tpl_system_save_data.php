<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<style type="text/css">
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	color: #666666;
	text-decoration: none;
}
a:hover {
	color: #666666;
	text-decoration: underline;
}
a:active {
	color: #666666;
	text-decoration: none;
}
</style>
<?php if ($this->_tpl_vars["method"]=='saveBackup'){?>
	<?php $this->_tpl_vars["result"]=runFunc('backupData',array($this->_tpl_vars["selectConId"],$this->_tpl_vars["operationType"],$this->_tpl_vars["MaxFileSize"],$this->_tpl_vars["addDrop"])); ?>
	<?php if ($this->_tpl_vars["result"]){?>
		<?php if ($this->_tpl_vars["operationType"]=='1'){?>
			<div class="main_content">
			   	<div class="main_content_nav">您已成功备份数据表</div>
				<div class="search_content detailMember"> 
				<div class="detailMember_txt">
				<?php echo $this->_tpl_vars["result"];?>
				</div>
			   	<div class="detailMember_txt"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=backup'));?>">返回</a></div>
			   	</div>
		   	</div>
		<?php }else{ ?>
			<div class="main_content">
			   	<div class="main_content_nav">您已成功优化数据</div>
				<div class="search_content detailMember"> 
			   	<div class="detailMember_txt"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=backup'));?>">返回</a></div>
			   	</div>
		   	</div>
		<?php } ?>
	
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='saveRestore'){ ?>
	<?php $this->_tpl_vars["result"]=runFunc('restoreData',array($this->_tpl_vars["IN"]["para"])); ?>
	<?php if ($this->_tpl_vars["result"]){?>
	<div class="main_content">
	   	<div class="main_content_nav">您已成功恢复数据</div>
		<div class="search_content detailMember"> 
	   	<div class="detailMember_txt"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=restore'));?>">返回</a></div>
	   	</div>
   	</div>
	<?php } ?>
<?php } ?>