<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["tempUrl"]='action=shop&method=myCart'; ?>
<?php if ($this->_tpl_vars["method"]=='updateCart'){?>	
	<?php if ($this->_tpl_vars["IN"]["para"]["goodsTitleEn"]!='Input the English name here if you can'){?>
		<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateGoods",
	'query' => "UPDATE cms_publish_goods SET goodsTitleEn = '{$this->_tpl_vars["IN"]["para"]["goodsTitleEn"]}' WHERE goodsID = '{$this->_tpl_vars["IN"]["para"]["goodsID"]}' ",
 ); 
$this->_tpl_vars['updateGoods'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php } ?>
	<?php if ($this->_tpl_vars["IN"]["para"]["goodsNotes"]=='Please input Color, Size here......'){?>
		<?php $this->_tpl_vars["goodsNotes"]=''; ?>
	<?php } ?>
	<?php
	
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
if(count($this->_tpl_vars["IN"]["props"])>0){
 $props = implode("|",$this->_tpl_vars["IN"]["props"]);
 }else{
	$props = "";
 }

	$dataArray["ItemQTY"] = $this->_tpl_vars["IN"]["para"]["ItemQTY"];
	$dataArray["props"] = $props;
	$dataArray["itemNotes"] = $this->_tpl_vars["IN"]["para"]["goodsNotes"];
	$dataArray["itemSize"] = $this->_tpl_vars["IN"]["para"]["goodsSize"];
	$dataArray["itemColor"] = $this->_tpl_vars["IN"]["para"]["goodsColor"];
	
	$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		
		$sql = "update cms_publish_cart set $sql WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}'";
	
		$this->_tpl_vars['updateCart'] = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

 
?>
	
	<?php if ($this->_tpl_vars["updateCart"]){?>	
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
	<?php } ?>
<?php } ?>