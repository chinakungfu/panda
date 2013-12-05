<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->_tpl_vars["method"]=='saveMultFiles'){?>
	<?php if ($this->_tpl_vars["resourceId"]==''){?>
		<?php $this->_tpl_vars["resourceIdArray"]=runFunc('addMultFiles',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["fileFolder"])); ?>
		<?php if ($this->_tpl_vars["resourceId"]=='disableFile'){?>
			<script >alert('不能传php类型文件！');window.history.back();</script>
		<pp:elseif epxr="">
			<script >alert('上传失败！');window.history.back();</script>
		<?php }else{ ?>
			
			<?php $this->_tpl_vars["resourceIdStr"]=''; ?>
			<?php if(!empty($this->_tpl_vars['resourceIdArray'])){ 
 foreach ($this->_tpl_vars['resourceIdArray'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["resourceIdStr"]=$this->_tpl_vars["var"] . ',' . $this->_tpl_vars["resourceIdStr"]; ?>
			<?php  }
} ?>
			<?php $this->_tpl_vars["resourceIdStr"]=substr($this->_tpl_vars["resourceIdStr"],0,-1); ?>
			<script >window.opener.document.getElementById('<?php echo $this->_tpl_vars["resourceUrl"];?>').value = '<?php echo $this->_tpl_vars["resourceIdStr"];?>';window.top.close();</script>		
		<?php } ?>
	<?php } ?>
<?php } ?>
