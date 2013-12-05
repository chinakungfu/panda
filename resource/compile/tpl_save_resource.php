<?php import('core.util.RunFunc'); ?><?php
$inc_tpl_file=includeFunc(<<<LNMV
isLogin
LNMV
);
include($inc_tpl_file);
?>

<?php if ($this->_tpl_vars["method"]=='saveResource'){?>
	<?php runFunc('addResource',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["fileFolder"]))?>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
frameListResource.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } elseif ($this->_tpl_vars["method"]=='selectResource'){ ?>
	<?php $this->_tpl_vars["url"]=runFunc('selectResource',array($this->_tpl_vars["resourceId"])); ?>
		<?php if ($this->_tpl_vars["isText"]==''){?>
			<?php runFunc('modifyUrl',array($this->_tpl_vars["resourceId"]))?>
			<script >window.top.close();</script>
		<?php }else{ ?>
			<script >window.top.opener.document.getElementById('headImageUrl').value = '<?php echo $this->_tpl_vars["url"];?>';window.top.opener.document.getElementById('resourceId').value = '<?php echo $this->_tpl_vars["resourceId"];?>';window.top.close();</script>
		<?php } ?>
<?php }else{ ?>
	<?php runFunc('delResource',array({$this->_tpl_vars["resourceId"]}))?>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
frame_list_resource.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>