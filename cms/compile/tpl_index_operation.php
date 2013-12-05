<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->_tpl_vars["method"]=='refeshIndex'){?>

		

<?php } elseif ($this->_tpl_vars["method"]=='viewIndex'){ ?>
	<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"],'')); ?>
	<?php if ($this->_tpl_vars["node"]["0"]["publishMode"]=='1'){?>
		<?php $this->_tpl_vars["result"]=runFunc('getNodeIndexByNodeId',array($this->_tpl_vars["nodeId"])); ?>
		<script>location.href="<?php echo $this->_tpl_vars["result"]["0"]["indexUrl"];?>";</script>
	<?php } elseif ($this->_tpl_vars["node"]["0"]["publishMode"]=='2'){ ?>
		<?php $this->_tpl_vars["urlArray"]=explode('?',$this->_tpl_vars["node"]["0"]["dynamicIndexUrl"]); ?>
		<?php $this->_tpl_vars["param"]=$this->_tpl_vars["urlArray"]['1'] . '&nodeId=' . $this->_tpl_vars["node"]["0"]["nodeGuid"]; ?>
		<?php $this->_tpl_vars["tempUrl"]=$this->_tpl_vars["urlArray"][0] . encrypt_url($this->_tpl_vars["param"]); ?>
		<script>location.href="<?php echo $this->_tpl_vars["tempUrl"];?>";</script>
	<?php } ?>
	
<?php } ?>