<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveInsert'){?>
<?php runFunc('addStaff',array($this->_tpl_vars["IN"]["para"]))?>
<?php } elseif ($this->_tpl_vars["method"]=='saveEdit'){ ?>
<?php runFunc('editStaff',array($this->_tpl_vars["staffId"],$this->_tpl_vars["IN"]["para"]))?>
<?php } elseif ($this->_tpl_vars["method"]=='delData'){ ?>
<?php runFunc('delStaff',array($this->_tpl_vars["selectConId"]))?>
<?php } ?>
<script>parent.location.href="index.php<?php echo runFunc('encrypt_url',array('action=staff&method=listUser'));?>";</script>
