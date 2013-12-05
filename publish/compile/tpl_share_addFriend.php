<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
	<?php $this->_tpl_vars["paraArr"]["backAction"]=share; ?>
	<?php $this->_tpl_vars["paraArr"]["backMethod"]=addFriend; ?>
	<?php $this->_tpl_vars["paraArr"]["shareID"]=$this->_tpl_vars["IN"]["shareID"]; ?>
	<?php $this->_tpl_vars["paraArr"]["userId"]=$this->_tpl_vars["IN"]["userId"]; ?>

	<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>

	<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=addFriend&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
<?php }else{ ?>

	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "friendNo",
	'query' => "select count(friendId) as friendNo  from cms_publish_friend WHERE userId='{$this->_tpl_vars["name"]}' and friendUserId='{$this->_tpl_vars["IN"]["userId"]}'",
 ); 

$this->_tpl_vars['friendNo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php if ($this->_tpl_vars["friendNo"]["data"]["0"]["friendNo"]>0){?>
		<script>alert('Already added.');location.href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["IN"]["shareID"]));?>"</script>	
	<?php }else{ ?>
		<?php $this->_tpl_vars["friendNodeId"]=92; ?>
		<?php $this->_tpl_vars["friendNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["friendNodeId"])); ?>
		<?php $this->_tpl_vars["friendContentModel"]=$this->_tpl_vars["friendNode"]["0"]["appTableName"]; ?>

		<?php if ($this->_tpl_vars["method"]=='addFriend'){?>

			<?php $this->_tpl_vars["friendPara"]["friendUserId"]=$this->_tpl_vars["IN"]["userId"]; ?>
			<?php $this->_tpl_vars["friendPara"]["nodeId"]=$this->_tpl_vars["friendNode"]["0"]["nodeGuid"]; ?>
			<?php $this->_tpl_vars["friendPara"]["userId"]=$this->_tpl_vars["name"]; ?>
			
			
			<?php date_default_timezone_set("prc");?>
			<?php $this->_tpl_vars["friendPara"]["addTime"]=strtotime(date('Y-m-d H:i:s',time())); ?>
			
			<?php $this->_tpl_vars["addfriendTable"]=runFunc('addData',array($this->_tpl_vars["friendNodeId"],$this->_tpl_vars["friendContentModel"],$this->_tpl_vars["friendPara"])); ?>		
			<?php if ($this->_tpl_vars["addfriendTable"]){?>
			
				
					<script>alert('Add friend successfully.');location.href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["IN"]["shareID"]));?>"</script>
				
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>
