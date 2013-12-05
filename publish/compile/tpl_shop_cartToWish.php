<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php if ($this->_tpl_vars["method"]=='CartToWishlist'){
$this->_tpl_vars["tempUrl1"]='action=shop&method=myCart';
$this->_tpl_vars["tempUrl2"]='action=shop&method=WOWd2d';
$this->_tpl_vars["tempUrl3"]='action=website&method=login';

		$this->_tpl_vars["name"]=runFunc('readSession',array());		
		if ($this->_tpl_vars["name"]){

			import('core.apprun.cmsware.CmswareNode');
			import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			$params = array (
				'action' => "sql",
				'return' => "addresslist",
				'query' => "UPDATE cms_publish_cart SET ItemStatus='Wish',ItemQTY='1',itemNotes='',props='' WHERE cartID='{$this->_tpl_vars["IN"]["cartID"]}' and UserName='{$this->_tpl_vars["name"]}'",
			);
			CMS::CMS_sql($params);
			$this->_tpl_vars['PageInfo'] = &$PageInfo;		
		?>
			<?php
				 import('core.apprun.cmsware.CmswareNode'); 
				 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
				 $params = array ( 
					'action' => "sql",
					'return' => "wishCount",
					'query' => "select count(cartID) as qty from cms_publish_cart where UserName='{$this->_tpl_vars["name"]}'",
				 ); 

				$this->_tpl_vars['wishCount'] = CMS::CMS_sql($params); 
				$this->_tpl_vars['PageInfo'] = &$PageInfo;  
			?>
			<?php if ($this->_tpl_vars["wishCount"]["data"]["0"]["qty"]==0){?>
							
					<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl1"]));?>'</script>
				<?php }else{ ?>
					<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl2"]));?>'</script>
				<?php } ?>
		<?php }else{ ?>
			<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl3"]));?>'</script>
<?php }
} ?>