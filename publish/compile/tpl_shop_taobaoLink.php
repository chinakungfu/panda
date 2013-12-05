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
		<script type="text/javascript">
		jQuery(function(){
			jQuery(".mySareListBaoLink").click(function()
			{
				if(!jQuery(this).hasClass("active_mySareListBaoLinkH3"))
				{
					jQuery(".mySareListBaoLink").removeClass("active_mySareListBaoLinkH3");
					jQuery(this).addClass("active_mySareListBaoLinkH3");
					jQuery(".mySareListBaoLinkH3").css("margin-top","30px");
					jQuery(".mySareListBaoLinkH3").css("border-bottom","0");
					jQuery(this).children(".mySareListBaoLinkH3").animate({'margin-top':"5px"},300,function(){
							jQuery(this).next(".mySareListBaoLinkInfo01").show();
							jQuery(this).next(".mySareListBaoLinkInfo02").show();
						});
					jQuery(this).children(".mySareListBaoLinkH3").css("border-bottom","1px solid #ccc");
					jQuery(".mySareListBaoLinkInfo01").hide();
					jQuery(".mySareListBaoLinkInfo02").hide();
				}
			});
			jQuery(".mySareListBaoLink").hover(function(){
				jQuery(this).addClass("hover_mySareListBaoLinkH3");
			},function(){
				jQuery(this).removeClass("hover_mySareListBaoLinkH3");
			});
		});
		</script>
	<body>
	
		<div class="box">
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>


			
			<div class="sharemain clb">
				
				<div class="mySareListBao">
					<h2>LINKS ON <span>TAOBAO</span></h2>
					<div class="mySareListBaoBox">
						<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "linkList",
	'query' => "SELECT * FROM cms_publish_link order by linkSequence ",
 ); 

$this->_tpl_vars['linkList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
						<?php if(!empty($this->_tpl_vars["linkList"]["data"])){ 
 foreach ($this->_tpl_vars["linkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
							
							<?php if ($this->_tpl_vars["var"]["parentId"]==-1){?>
								<div class="mySareListBlock" style= "overflow:hidden" >
								
								<h5><?php echo $this->_tpl_vars["var"]["linkName"];?></h5>
								<?php if(!empty($this->_tpl_vars["linkList"]["data"])){ 
 foreach ($this->_tpl_vars["linkList"]["data"] as $this->_tpl_vars['key1']=>$this->_tpl_vars['var1']){ ?>
									<?php $this->_tpl_vars["linkCount"]=0; ?>
									<?php if ($this->_tpl_vars["var1"]["parentId"]==$this->_tpl_vars["var"]["linkId"]){?>
									<div class="mySareListBaoLink">
									<h3 class="mySareListBaoLinkH3"><?php echo $this->_tpl_vars["var1"]["linkName"];?></h3>
									<div class="mySareListBaoLinkInfo02">
									<table width="290px" id="mySareListBaoTable">
										<tr>
										<?php if(!empty($this->_tpl_vars["linkList"]["data"])){ 
 foreach ($this->_tpl_vars["linkList"]["data"] as $this->_tpl_vars['key2']=>$this->_tpl_vars['var2']){ ?>
											<?php if ($this->_tpl_vars["var2"]["parentId"]==$this->_tpl_vars["var1"]["linkId"] and $this->_tpl_vars["linkCount"]<6){?>
												<?php if ($this->_tpl_vars["linkCount"]==0){?>
													<td width="140px" ><a href="<?php echo $this->_tpl_vars["var2"]["linkUrl"];?>" class="mySareListBaoLinkInfo02Link" target="_blank"><?php echo $this->_tpl_vars["var2"]["linkName"];?></a></td><td width="1px">|</td>
												<?php } elseif ($this->_tpl_vars["linkCount"]%2==0){ ?>				
													</tr>
													<tr>
													<td width="140px"><a href="<?php echo $this->_tpl_vars["var2"]["linkUrl"];?>" class="mySareListBaoLinkInfo02Link" target="_blank"><?php echo $this->_tpl_vars["var2"]["linkName"];?></a></td><td width="1px">|</td>
												<?php }else{ ?>
													
													<td width="140px"><a href="<?php echo $this->_tpl_vars["var2"]["linkUrl"];?>" class="mySareListBaoLinkInfo02Link" target="_blank"><?php echo $this->_tpl_vars["var2"]["linkName"];?></a></td>
												<?php } ?>
												<?php $this->_tpl_vars["linkCount"]=$this->_tpl_vars["linkCount"]+1; ?>
											<?php } ?>
										<?php  }
} ?>
										</tr>										
										</table>		
									</div>
								</div>
									<?php } ?>
								<?php  }
} ?>
								</div>
							<?php } ?>
							
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