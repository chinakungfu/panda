<?php import('core.util.RunFunc'); ?><?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "shareOrderList",
	'query' => "SELECT * FROM cms_publish_order where orderUser='{$this->_tpl_vars["userInfo"]["0"]["staffId"]}'",
 ); 

$this->_tpl_vars['shareOrderList'] = CMS::CMS_sql($params); 
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

             <div class="mySareList">
                 <h2 style="color:#5e97ed">YOUR RECENT ORDER</h2>
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "shareSite",
	'query' => "SELECT cartIDstr FROM `cms_publish_order` WHERE `orderUser`='{$this->_tpl_vars["name"]}' and `orderStatus`>='4'",
 ); 

$this->_tpl_vars['shareSite'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>   
       <?php $this->_tpl_vars["shareNum"]=sizeof($this->_tpl_vars["shareSite"]["data"]); ?>
       <?php if ($this->_tpl_vars["shareNum"]>0){?>

	       <?php if(!empty($this->_tpl_vars["shareSite"]["data"])){ 
 foreach ($this->_tpl_vars["shareSite"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?> 
			<?php $this->_tpl_vars["cartIdString"]=$this->_tpl_vars["var"]["cartIDstr"] . ',' . $this->_tpl_vars["cartIdString"]; ?>		
	       <?php  }
} ?>
       <?php $this->_tpl_vars["cartIdString"]=substr($this->_tpl_vars["cartIdString"],0,-1); ?>

       <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "shareOrder",
	'query' => "SELECT a.goodsImgURL,a.goodsid,a.goodsTitleCN,a.goodsTitleEN, a.goodsType FROM cms_publish_goods a, cms_publish_cart b WHERE b.cartId in ({$this->_tpl_vars["cartIdString"]}) and b.ItemGoodsID=a.goodsid",
 ); 

$this->_tpl_vars['shareOrder'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>    
                 <table>
       
       <?php if(!empty($this->_tpl_vars["shareOrder"]["data"])){ 
 foreach ($this->_tpl_vars["shareOrder"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
		   <tr>
                     <td>
                      <dl>
                       <dt>
		       <?php if ($this->_tpl_vars["var"]["goodsType"]=='inside'){?>
					    <img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt="bagImg" />
					    <?php } elseif ($this->_tpl_vars["var"]["goodsType"]=='outside'){ ?>
					    <img src="<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt="bagImg" />
					    <?php } ?>
					    </dt>
                       <dd class="mySareListF00"><strong><?php echo $this->_tpl_vars["var"]["goodsTitleCN"];?><br /><?php echo $this->_tpl_vars["var"]["goodsTitleEN"];?> </strong></dd>
                       <dd class="mySareListF01"><?php if ($this->_tpl_vars["var"]["goodsType"]=='inside'){?><dd class="wowService">WOW SURPRISE SERVICE</dd>
													<?php } ?></dd>
                      </dl>
                    </td>
                    <td class="mySareListBtn"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=submitShare&goodsID=' . $this->_tpl_vars["var"]["goodsid"] ));?>">Share</a></td>
                   </tr>
          <?php  }
} ?>        
                 </table>
	<?php }else{ ?>
		Sorry, you have not bought anything yet.
	<?php } ?>
		 
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