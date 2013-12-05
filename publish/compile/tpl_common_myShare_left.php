<?php import('core.util.RunFunc'); ?><div class="mainMyShare fl">
   <div class="contentRLeft">
	<dl class="userInfo">
		<?php if ($this->_tpl_vars["userInfo"]["0"]["headImageUrl"]!=''){?>
	    <dt><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["userInfo"]["0"]["headImageUrl"];?>" width="50" height="50" align="logo" id="userHeaderImg"></dt>
	    <?php }else{ ?>
	    <dt><img src="../skin/images/pic.jpg" width="50" height="50" align="logo" id="userHeaderImg"></dt>
	    <?php } ?>
	    <dd>Welcome Back</dd>
	    <dd><?php echo $this->_tpl_vars["userInfo"]["0"]["staffName"];?></dd>
	    <dd id="userEmail"></dd>
	</dl>
	<div id="userInfoList">
	    
	    <p><div id="upload" ><span>upload your photo here<span></div><span id="status" ></span></p>
	    
	    
	    

	</div>
	
    </div>
    <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "friendInfo",
	'query' => "SELECT b.staffName, b.headImageUrl from cms_publish_friend a, cms_member_staff b where a.userId='{$this->_tpl_vars["name"]}' and a.friendUserId=b.staffId",
 ); 

$this->_tpl_vars['friendInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php $this->_tpl_vars["favoriteRow"]=count($this->_tpl_vars["friendInfo"]["data"]); ?>
    <div class="friendInfo">
    
	<h2>Friends (<?php echo $this->_tpl_vars["favoriteRow"];?>)</h2>
	<?php if(!empty($this->_tpl_vars["friendInfo"]["data"])){ 
 foreach ($this->_tpl_vars["friendInfo"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?> 
	<dl>
	    <dt>
	    <?php if ($this->_tpl_vars["var"]["headImageUrl"]){?>
			<img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["headImageUrl"];?>"/> 
		<?php }else{ ?>
			<dt><img src="../skin/images/pic.jpg" alt="userInfo""/></dt>
		<?php } ?>
	    </dt>
	    <dd><?php echo $this->_tpl_vars["var"]["staffName"];?></dd>
	</dl>                        
	<?php  }
} ?>
    </div>
</div>
 <div class="imglistMyShare fr">
                <h2>
                    <a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=myShare'));?>" <?php if ($this->_tpl_vars["IN"]["method"]=='myShare'){?> id="imglistMyShareLink" <?php } ?> ><img src="../skin/images/myshare.jpg" align="myshare" /></a>
                    <a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=myShareLove'));?>"><img src="../skin/images/myHeatrs.jpg" align="myHeatrs" /></a>
                    <a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=myWishList'));?>" <?php if ($this->_tpl_vars["IN"]["method"]=='myWishList'){?> id="imglistMyShareLink" <?php } ?> ><img src="../skin/images/myWish.jpg" align="myWish" /></a>
                    
                </h2>