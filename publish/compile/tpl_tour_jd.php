<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["IN"]["nodeId"]!=''){?>
	<?php
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
<?php }else{ ?>
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "node",
	'return' => "node",
	'nodeid' => "LYJDR5si",
 ); 

$this->_tpl_vars['node'] = CMS::CMS_node($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php } ?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "content",
	'return' => "listcontent",
	'nodeid' => "{$this->_tpl_vars["IN"]["nodeId"]}",
	'contentid' => "{$this->_tpl_vars["IN"]["newsId"]}",
 ); 

$this->_tpl_vars['listcontent'] = CMS::CMS_content($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "jdList",
	'nodeid' => "LYJDR5si",
	'orderby' => "i.publishDate ASC",
 ); 

$this->_tpl_vars['jdList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php if(!empty($this->_tpl_vars["jdList"]["data"])){ 
 foreach ($this->_tpl_vars["jdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>        
		<?php if (empty($this->_tpl_vars["listcontent"])){?>
			<?php if ($this->_tpl_vars["key"]=='0'){?>
				<?php $this->_tpl_vars["listcontent"]=$this->_tpl_vars["var"]; ?>
			<?php } ?>
		<?php } ?>	
<?php  }
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$inc_tpl_file=includeFunc(<<<LNMV
tour_title.tpl
LNMV
);
include($inc_tpl_file);
?>

<link rel="stylesheet" type="text/css" media="screen" href="/skin/css/style.css" />
</head>

<body>
<div id="mainbox">
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
tour_header.tpl
LNMV
);
include($inc_tpl_file);
?>

	
    <div id="contentbox">
    	<?php
$inc_tpl_file=includeFunc(<<<LNMV
tour_yplace.tpl
LNMV
);
include($inc_tpl_file);
?>

        <div class="leftbox">
        	<div class="c_lyjd">
            	<div class="title"></div>
                <div class="content">
                	<div class="left_all_list">
                    	<div class="top"></div>
                        <div class="mid">
                        	<ul>
                        <?php if(!empty($this->_tpl_vars["jdList"]["data"])){ 
 foreach ($this->_tpl_vars["jdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
								<?php if ($this->_tpl_vars["newsId"]!=''){?>
									<?php if ($this->_tpl_vars["var"]["contentId"]==$this->_tpl_vars["newsId"]){?>
										<?php if (($this->_tpl_vars["key"]+1)==count($this->_tpl_vars["jdList"]["data"])){?>
											<li class="current" style="border-bottom:none;"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
										<?php }else{ ?>
											<li class="current"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
										<?php } ?>
									<?php }else{ ?>
										<?php if (($this->_tpl_vars["key"]+1)==count($this->_tpl_vars["jdList"]["data"])){?>
											<li style="border-bottom:none;"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
										<?php }else{ ?>
											<li><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
										<?php } ?>
									<?php } ?>
								<?php }else{ ?>
									<?php if ($this->_tpl_vars["key"]=='0'){?>
										<li class="current"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
									<?php }else{ ?>
										<?php if (($this->_tpl_vars["key"]+1)==count($this->_tpl_vars["jdList"]["data"])){?>
											<li style="border-bottom:none;"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
										<?php }else{ ?>
											<li><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
										<?php } ?>
									<?php } ?>
								<?php } ?>
                        <?php  }
} ?>
                            </ul>
                        </div>
                        <div class="bottom"></div>
                    </div>
                </div>
            </div>
            <div class="claer"></div>
            <div class="c_lyline">
            	<div class="title"></div>
                <div class="content">
                	<ul>
                <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "lineList",
	'nodeid' => "LYXL4Mhb",
	'num' => "5",
 ); 

$this->_tpl_vars['lineList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
                    <?php if(!empty($this->_tpl_vars["lineList"]["data"])){ 
 foreach ($this->_tpl_vars["lineList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                        <li><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
                    <?php  }
} ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php $this->_tpl_vars["listContentPage"]=runFunc('listContentPage',array($this->_tpl_vars["currentPage"],'../publish/index.php',$this->_tpl_vars["listcontent"]["content"],"nodeId={$this->_tpl_vars["IN"]["nodeId"]}&newsId={$this->_tpl_vars["IN"]["newsId"]}")); ?>
        <div class="rightbox">
        	<div class="cbox">
            	<div class="title"><?php echo $this->_tpl_vars["listcontent"]["title"];?></div>
                <div class="content">
                	<div class="intro"><?php echo $this->_tpl_vars["listContentPage"]["pageInfo"]["content"];?></div>
                    
                </div>
                <div class="page">
                
                <ul>
                    <?php if (!empty($this->_tpl_vars["listContentPage"]["pageInfo"]["prePage"])){?>
                    <li><a href="/<?php echo $this->_tpl_vars["listContentPage"]["pageInfo"]["prePage"];?>" class="next">&lt; 上一页</a></li>
                    <?php }else{ ?>
                    <li><a href="#" class="next" title="已经是第一页了">&lt; 上一页</a></li>
                    <?php } ?>
                    <?php if(!empty($this->_tpl_vars["listContentPage"]["url"]["list"])){ 
 foreach ($this->_tpl_vars["listContentPage"]["url"]["list"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                        <?php if ($this->_tpl_vars["listContentPage"]["pageInfo"]["currentPage"] != $this->_tpl_vars["key"]){?>
                        <li><a href="/<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["key"];?></a></li>
                        <?php }else{ ?>
                        <li><span><?php echo $this->_tpl_vars["key"];?></span></li>
                        <?php } ?>
                    <?php  }
} ?>
                    <?php if (!empty($this->_tpl_vars["listContentPage"]["pageInfo"]["nextPage"])){?>
                    <li><a href="/<?php echo $this->_tpl_vars["listContentPage"]["pageInfo"]["nextPage"];?>" class="next">下一页 &gt;</a></li>
                    <?php }else{ ?>
                    <li><a href="#" class="next" title="已经到最后一页了">下一页 &gt;</a></li>
                    <?php } ?>
                </ul>
                </div>
            </div>
        </div>
    </div>
    
    <?php
$inc_tpl_file=includeFunc(<<<LNMV
tour_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

</div>
</body>
</html>
