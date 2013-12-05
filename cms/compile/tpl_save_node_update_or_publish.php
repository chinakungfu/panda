<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveNodeUpdate'){?>
	<?php runFunc('saveNodeUpdate',array($this->_tpl_vars["nodeId"],'0',$this->_tpl_vars["counter"],$this->_tpl_vars["subNode"],$this->_tpl_vars["IN"]["para"]))?>
	<script>window.close();</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveNodePublish'){ ?>
	<?php runFunc('saveNodePublish',array($this->_tpl_vars["nodeId"],'0',$this->_tpl_vars["counter"],$this->_tpl_vars["subNode"],$this->_tpl_vars["IN"]["para"],$this->_tpl_vars["isMandatory"]))?>
	<script>window.close();</script>
<?php } ?>