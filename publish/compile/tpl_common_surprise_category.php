<?php import('core.util.RunFunc'); ?><div class="surpriseLeft fl">
	<h2>FIND<span>GIFTS FOR ...</span></h2>
	<ul>
		<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "surpriseSite",
	'query' => "select * from cms_cms_site  where parentId = 'specialDHKg'",
 ); 

$this->_tpl_vars['surpriseSite'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
		<?php if(!empty($this->_tpl_vars["surpriseSite"]["data"])){ 
 foreach ($this->_tpl_vars["surpriseSite"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
			<?php $this->_tpl_vars["urlArray"]=explode('?',$this->_tpl_vars["var"]["dynamicIndexUrl"]); ?>
			<li><a href="<?php echo $this->_tpl_vars["urlArray"]["0"];?><?php echo runFunc('encrypt_url',array($this->_tpl_vars["urlArray"][1] .'&nodeId=' . $this->_tpl_vars["var"]["nodeGuid"] ));?>"><?php echo $this->_tpl_vars["var"]["nodeName"];?></a></li>
		<?php  }
} ?> 
	</ul>
	
</div>