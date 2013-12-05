<?php import('core.util.RunFunc'); ?><?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
a:link 
	text-decoration: none;

a:visited 
	text-decoration: none;

a:hover 
	text-decoration: underline;

a:active 
	text-decoration: none;

</style>
<head>
<?php if ($this->_tpl_vars["actParams"]!=''){?>
<?php $this->_tpl_vars["actParams"]=unserialize(base64_decode($this->_tpl_vars["actParams"])); ?>
<?php if(!empty($this->_tpl_vars['actParams'])){ 
 foreach ($this->_tpl_vars['actParams'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
	<?php if ($this->_tpl_vars["key"]=='frameListAction'){?>
		<?php $this->_tpl_vars["key"]='action'; ?>
	<?php } ?>
	<?php if ($this->_tpl_vars["key"]=='frameListMethod'){?>
		<?php $this->_tpl_vars["key"]='method'; ?>
	<?php } ?>
	<?php if ($this->_tpl_vars["params"]){?>
		<?php $this->_tpl_vars["params"]=$this->_tpl_vars["params"] . '&' . $this->_tpl_vars["key"] . '=' . $this->_tpl_vars["var"]; ?>
	<?php }else{ ?>
		<?php $this->_tpl_vars["params"]=$this->_tpl_vars["params"] . $this->_tpl_vars["key"] . '=' . $this->_tpl_vars["var"]; ?>
	<?php } ?>	
<?php  }
} ?>
<?php }else{ ?>
<?php if(!empty($this->_tpl_vars['IN'])){ 
 foreach ($this->_tpl_vars['IN'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
	<?php if ($this->_tpl_vars["key"]!='action'&&$this->_tpl_vars["key"]!='method'){?>
		<?php if ($this->_tpl_vars["key"]=='frameListAction'){?>
			<?php $this->_tpl_vars["key"]='action'; ?>
		<?php } ?>
		<?php if ($this->_tpl_vars["key"]=='frameListMethod'){?>
			<?php $this->_tpl_vars["key"]='method'; ?>
		<?php } ?>
		<?php if ($this->_tpl_vars["params"]){?>
			<?php $this->_tpl_vars["params"]=$this->_tpl_vars["params"] . '&' . $this->_tpl_vars["key"] . '=' . $this->_tpl_vars["var"]; ?>
		<?php }else{ ?>
			<?php $this->_tpl_vars["params"]=$this->_tpl_vars["params"] . $this->_tpl_vars["key"] . '=' . $this->_tpl_vars["var"]; ?>
		<?php } ?>
	<?php } ?>
<?php  }
} ?>
<?php } ?>


<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<link href="skin/cssfiles/style_condition.css"  rel="stylesheet" type="text/css"/>
<script language="javascript" src="skin/jsfiles/conditioninput.js"></script>
<script language="javascript" src="skin/jsfiles/calendar.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<title>通用CMS</title>
<script>
function search()
{
	var sqlConStr = sqlcondition.generateStatement();
	//sqlConStr = escape(sqlConStr);
	document.all.listInfo.src = "index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["params"]));?>&sqlCon="+sqlConStr;
}
</script>
</head>
<body>
    <iframe id="listInfo" src="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["params"]));?>" frameborder="0" width="100%" height="90%"></iframe>
	
	<?php echo runFunc('getSelectData',array($this->_tpl_vars["nodeId"]));?>
		
</html>
