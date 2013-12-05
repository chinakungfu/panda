<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->_tpl_vars["method"]=='saveSingleImage'){?>
	<?php if ($this->_tpl_vars["resourceId"]==''){?>
		<?php $this->_tpl_vars["resourceId"]=runFunc('addResource',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["fileFolder"])); ?>
		<?php if ($this->_tpl_vars["resourceId"]=='disableFile'){?>
			<script >alert('不能传php类型文件！');window.history.back();</script>
		<pp:elseif epxr="">
			<script >alert('上传失败！');window.history.back();</script>
		<?php }else{ ?>
			<?php $this->_tpl_vars["url"]=runFunc('selectResource',array($this->_tpl_vars["resourceId"])); ?>
			<script >window.opener.document.getElementById('<?php echo $this->_tpl_vars["resourceUrl"];?>').value = '<?php echo $this->_tpl_vars["url"];?>';window.top.close();</script>		
		<?php } ?>
	<?php } ?>
<?php } ?>
