<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["type"]=='group'){?>
<?php runFunc('delGroupBindRole',array($this->_tpl_vars["groupNo"],'0'))?>
	<?php if ($this->_tpl_vars["index"]!=''){?>
		<?php if(!empty($this->_tpl_vars['index'])){ 
 foreach ($this->_tpl_vars['index'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
		<?php runFunc('staffGroupBindRole',array($this->_tpl_vars["groupNo"],$this->_tpl_vars["var"],'0'))?>
		<?php  }
} ?>
	<?php } ?>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
group/frame_list_group.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } elseif ($this->_tpl_vars["type"]=='staff'){ ?>
<?php runFunc('delGroupBindRole',array($this->_tpl_vars["staffNo"],'1'))?>
<?php if ($this->_tpl_vars["index"]!=''){?>
		<?php if(!empty($this->_tpl_vars['index'])){ 
 foreach ($this->_tpl_vars['index'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
		<?php runFunc('staffGroupBindRole',array($this->_tpl_vars["staffNo"],$this->_tpl_vars["var"],'1'))?>
		<?php  }
} ?>
	<?php } ?>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
user/frame_list_user.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>