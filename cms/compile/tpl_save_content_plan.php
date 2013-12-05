<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddContentPlan'){?>
<?php $this->_tpl_vars["contentPlanId"]=runFunc('addContentPlanInfo',array($this->_tpl_vars["IN"]["para"])); ?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listContentPlan'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditContentPlan'){ ?>
<?php runFunc('editContentPlanInfo',array($this->_tpl_vars["contentPlanId"],$this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listContentPlan'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delContentPlan'){ ?>
<?php runFunc('delContentPlanInfo',array($this->_tpl_vars["contentPlanId"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listContentPlan'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>