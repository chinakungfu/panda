<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用应用编译</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
</head>

<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "ret",
	'query' => "select * from {$this->_tpl_vars["contentModel"]} where {$this->_tpl_vars["appTableKeyName"]}='{$this->_tpl_vars["appTableKeyValue"]}'",
 ); 

$this->_tpl_vars['ret'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php if (!empty($this->_tpl_vars["ret"])){?>
	<?php if ($this->_tpl_vars["ret"]["data"]["0"]["appUrl"]!=''){?>
		<script>location.href="<?php echo $this->_tpl_vars["ret"]["data"]["0"]["appUrl"];?>/tplCompile.php";</script>
	<?php }else{ ?>
		不能编译该应用，请检查应用的路径是否设置正确1。
	<?php } ?>
<?php }else{ ?>
不能编译该应用，请检查应用的路径是否设置正确2。
<?php } ?>
</html>

