<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["staff"]=runFunc('getStaffInfoById',array($this->_tpl_vars["staffId"])); ?>
<script >
window.top.opener.document.getElementById('inputMemberId').value = '<?php echo $this->_tpl_vars["staff"]["0"]["staffNo"];?>';
window.top.close();
</script>