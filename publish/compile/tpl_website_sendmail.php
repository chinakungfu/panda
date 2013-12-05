<?php import('core.util.RunFunc'); ?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "node",
	'return' => "node",
	'nodeid' => "{$this->_tpl_vars["IN"]["nodeId"]}",
 ); 

$this->_tpl_vars['node'] = CMS::CMS_node($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>

</head>
<body>

<div class="box">
	
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>			
<div class="surprise clb">
				<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/surprise_category.tpl
LNMV
);
include($inc_tpl_file);
?>
				<div class="surpriseContent fl">
					<?php $this->_tpl_vars["titleLeft"]=substr($this->_tpl_vars["node"]["nodeName"], 0,9); ?>
					<?php $this->_tpl_vars["titleRight"]=substr($this->_tpl_vars["node"]["nodeName"],10); ?>
				    <h2><?php echo $this->_tpl_vars["titleLeft"];?> <span><?php echo $this->_tpl_vars["titleRight"];?></span></h2>
				    <div class="surpriseContInfo clb">	
				        <dl>	
					    <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=mailtest&method=signup'));?>">Sign up mail</a></dd>					    
					</dl>
					<dl>					    
					    <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=mailtest&method=changeMail&goodsID=' . $this->_tpl_vars["var"]["goodsid"] ));?>">change mail account</a></dd>					    
					</dl>
					<dl>	
					    <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=mailtest&method=orderSubmit&orderID=1'));?>">Order Information</a></dd>    
					</dl>
					<dl>	
					    <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=mailtest&method=resetPassword'));?>">Reset Password</a></dd>    
					</dl>
                        
				    </div>
				</div>
			</div>
			
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

			
		</div>
	</body>
</html>