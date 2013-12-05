<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用ＣＭＳ</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script type="text/javascript" src="skin/jsfiles/cms.js"></script>
</head>

<body>
<div class="main_content">
<form method="post" action="index.php">
<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="saveSetDefaultNode">
<input type="hidden" class="edit" name="nodeId" value="<?php echo $this->_tpl_vars["nodeId"];?>" >
<div class="detailMember_nav">请选择操作</div> 
<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"],'')); ?>      
<div class="detailMember_txt">是否为默认操作：</div>
<input type="radio" id="isDefault" name="isDefault" value="0">否
<input type="radio" id="isDefault" name="isDefault" value="1">是<br>
<input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.close();">     
</div>
</form>
<br />
<div style="clear:both"></div>
<div class="copyright"></div>
</div>
<script>
radioIsSelected('isDefault','<?php echo $this->_tpl_vars["node"]["0"]["isCommon"];?>');
</script>
</body>
</html>
