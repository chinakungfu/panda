<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["operaterType"]==0){?>
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "delGoodsImgInfo",
	'query' => "delete from cms_publish_goods_img where Id='{$this->_tpl_vars["goodsImgId"]}'",
 ); 
$this->_tpl_vars['delGoodsImgInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php  
import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "delResourceInfo",
	'query' => "delete from cms_resource_resource where resourceId='{$this->_tpl_vars["resourceId"]}'",
 ); 

$this->_tpl_vars['delResourceInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "goodsImgList",
	'query' => "select * from cms_resource_resource r,cms_publish_goods_img gi where r.resourceId=gi.resourceId and goodsId='{$this->_tpl_vars["goodsId"]}'",
 ); 

$this->_tpl_vars['goodsImgList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php $this->_tpl_vars["json_str"]=json_encode($this->_tpl_vars["goodsImgList"]); ?>
	<?php echo $this->_tpl_vars["json_str"];?>
<?php }else{ ?>
	<?php $this->_tpl_vars["resourceId"]=runFunc('addResource',array($this->_tpl_vars["para"],$this->_tpl_vars["fileFolder"],1,$this->_tpl_vars["maxFileSize"])); ?>
	<?php if ($this->_tpl_vars["resourceId"]=='tooMax'){?>
		<?php echo $this->_tpl_vars["resourceId"];?>
	<?php }else{ ?>
		<?php if ($this->_tpl_vars["resourceId"]){?>
			<?php $this->_tpl_vars["url"]=runFunc('selectResource',array($this->_tpl_vars["resourceId"])); ?>
			<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
			<?php if ($this->_tpl_vars["goodsId"]!=''){?>
				<?php if ($this->_tpl_vars["goodsId"]!=-1){?>
					<?php $this->_tpl_vars["dateTime"]=time(); ?>
					<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "insertGoodsInfo",
	'query' => "insert into cms_publish_goods_img (resourceId,goodsId,imgUrl,createUserId,createDateTime) values ('{$this->_tpl_vars["resourceId"]}','{$this->_tpl_vars["goodsId"]}','{$this->_tpl_vars["url"]}','{$this->_tpl_vars["name"]}','{$this->_tpl_vars["dateTime"]}')",
 ); 

$this->_tpl_vars['insertGoodsInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
					<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "goodsImgList",
	'query' => "select * from cms_resource_resource r,cms_publish_goods_img gi where r.resourceId=gi.resourceId and goodsId='{$this->_tpl_vars["goodsId"]}'",
 ); 

$this->_tpl_vars['goodsImgList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
					<?php $this->_tpl_vars["json_str"]=json_encode($this->_tpl_vars["goodsImgList"]); ?>
					<?php echo $this->_tpl_vars["json_str"];?>
				<?php }else{ ?>
					<?php echo $this->_tpl_vars["url"];?>					
				<?php } ?>
			<?php }else{ ?>
				<?php echo $this->_tpl_vars["url"];?>
				<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "upUserInfo",
	'query' => "update cms_member_staff set headImageUrl='{$this->_tpl_vars["url"]}' where staffId='{$this->_tpl_vars["name"]}'",
 ); 

$this->_tpl_vars['upUserInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
			<?php } ?>
		<?php }else{ ?>
		
		<?php } ?>
	<?php } ?>
		
<?php } ?>