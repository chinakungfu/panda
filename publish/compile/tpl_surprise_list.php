<?php import('core.util.RunFunc'); ?><?php
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
				    
				    
				    <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "surpriseSite",
	'query' => "SELECT * FROM `cms_publish_goods` WHERE `nodeId`='{$this->_tpl_vars["IN"]["nodeId"]}' order by `goodsid` DESC",
	'num' => "page-8",
 ); 

$this->_tpl_vars['surpriseSite'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
				    <?php $this->_tpl_vars["listPage"]=runFunc('listPageUrl',array($this->_tpl_vars["surpriseSite"]["pageinfo"],'../publish/index.php',10,"nodeId={$this->_tpl_vars["IN"]["nodeId"]}")); ?>
					 <?php
$_tmp13432928989323=$this->_tpl_vars;
$this->_tpl_vars["pageInfo"] = $this->_tpl_vars["listPage"];
$inc_tpl_file=includeFunc(<<<LNMV
surpriseItem_page.tpl
LNMV
);
include($inc_tpl_file);
$this->_tpl_vars=$_tmp13432928989323;
unset($_tmp13432928989323);
?>

				    <div class="surpriseContInfo clb">
				    
				    <?php if(!empty($this->_tpl_vars["surpriseSite"]["data"])){ 
 foreach ($this->_tpl_vars["surpriseSite"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				        <dl>
                            <dt><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=goodsDetail&goodsID=' . $this->_tpl_vars["var"]["goodsid"] ));?>"><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt="<?php echo $this->_tpl_vars["var"]["goodsTitleCN"];?>"/></a></dt>
			    <?php $this->_tpl_vars["SinglePrice"]=number_format($this->_tpl_vars["var"]["goodsUnitPrice"], 2, '.', ','); ?>
                            <dd> <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=goodsDetail&goodsID=' . $this->_tpl_vars["var"]["goodsid"] ));?>"><?php echo $this->_tpl_vars["var"]["goodsTitleEn"];?></a></dd>
                            <dd class="yuanWen">￥ &nbsp;<?php echo $this->_tpl_vars["SinglePrice"];?></dd>
                        </dl>
			<?php  }
} ?> 
                        
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