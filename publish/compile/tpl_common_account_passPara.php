<?php import('core.util.RunFunc'); ?>

<?php $this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"]; ?>
<?php $this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"]; ?>
<?php if($this->_tpl_vars["IN"]["id"]!=""){	
			$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
		}
		if($this->_tpl_vars["IN"]["user_id"]!=""){	
			$this->_tpl_vars["paraArr"]["backUserId"] = $this->_tpl_vars["IN"]["user_id"];
		}
		
?>
<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>


<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=normal&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>