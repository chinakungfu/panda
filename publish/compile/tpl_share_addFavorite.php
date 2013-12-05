<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
	<?php $this->_tpl_vars["paraArr"]["backAction"]=share; ?>
	<?php $this->_tpl_vars["paraArr"]["backMethod"]=addFavorite; ?>
	<?php $this->_tpl_vars["paraArr"]["shareID"]=$this->_tpl_vars["IN"]["shareID"]; ?>	

	<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>

	<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=addFriend&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
<?php }else{ ?>

	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "FavoriteNo",
	'query' => "select count(favoriteId) as FavoriteNo  from cms_publish_favorite WHERE userId='{$this->_tpl_vars["name"]}' and shareId='{$this->_tpl_vars["IN"]["shareID"]}'",
 ); 

$this->_tpl_vars['FavoriteNo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php if ($this->_tpl_vars["FavoriteNo"]["data"]["0"]["FavoriteNo"]>0){?>
		<script>alert('Already added.');location.href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["IN"]["shareID"]));?>"</script>
		
	
	<?php }else{ ?>
		<?php $this->_tpl_vars["FavoriteNodeId"]=93; ?>
		<?php $this->_tpl_vars["FavoriteNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["FavoriteNodeId"])); ?>
		<?php $this->_tpl_vars["FavoriteContentModel"]=$this->_tpl_vars["FavoriteNode"]["0"]["appTableName"]; ?>

		<?php if ($this->_tpl_vars["method"]=='addFavorite'){?>
			
			<?php $this->_tpl_vars["FavoritePara"]["nodeId"]=$this->_tpl_vars["FavoriteNode"]["0"]["nodeGuid"]; ?>
			<?php $this->_tpl_vars["FavoritePara"]["userId"]=$this->_tpl_vars["name"]; ?>	
			<?php $this->_tpl_vars["FavoritePara"]["shareID"]=$this->_tpl_vars["IN"]["shareID"]; ?>
			
			<?php date_default_timezone_set("prc");?>
			<?php $this->_tpl_vars["FavoritePara"]["addTime"]=strtotime(date('Y-m-d H:i:s',time())); ?>
			
			<?php $this->_tpl_vars["addFavoriteTable"]=runFunc('addData',array($this->_tpl_vars["FavoriteNodeId"],$this->_tpl_vars["FavoriteContentModel"],$this->_tpl_vars["FavoritePara"])); ?>		
			<?php if (addFavoriteTable){?>
				<script>alert('Add Favorite successfully.');location.href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["IN"]["shareID"]));?>"</script>
				
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>