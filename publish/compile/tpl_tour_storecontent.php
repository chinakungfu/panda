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
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "content",
	'return' => "listcontent",
	'nodeid' => "{$this->_tpl_vars["IN"]["nodeId"]}",
	'contentid' => "{$this->_tpl_vars["IN"]["productId"]}",
 ); 

$this->_tpl_vars['listcontent'] = CMS::CMS_content($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
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
        	<div class="c_lystore">
            	<div class="title"></div>
                <div class="content">
                	<div class="left_all_list">
                    	<div class="top"></div>
                        <div class="mid">
                        	<ul> 
                        <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "storeSite",
	'query' => "select * from cms_cms_site  where parentId = 'LYSPLLhC'",
 ); 

$this->_tpl_vars['storeSite'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
                        	<?php if(!empty($this->_tpl_vars["storeSite"]["data"])){ 
 foreach ($this->_tpl_vars["storeSite"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                            <?php $this->_tpl_vars["urlArray"]=explode('?',$this->_tpl_vars["var"]["dynamicIndexUrl"]); ?>
                                <?php if ($this->_tpl_vars["var"]["nodeGuid"]==$this->_tpl_vars["node"]["nodeGuid"]){?>
                                    <?php if (($this->_tpl_vars["key"]+1)==count($this->_tpl_vars["storeSite"]["data"])){?>
                                        <li class="current" style="border-bottom:none;">
<a href="<?php echo $this->_tpl_vars["urlArray"]["0"];?><?php echo runFunc('encrypt_url',array($this->_tpl_vars["urlArray"][1] .'&nodeId=' . $this->_tpl_vars["var"]["nodeGuid"] ));?>"><?php echo $this->_tpl_vars["var"]["nodeName"];?></a></li>
                                    <?php }else{ ?>
                                        <li class="current">
<a href="<?php echo $this->_tpl_vars["urlArray"]["0"];?><?php echo runFunc('encrypt_url',array($this->_tpl_vars["urlArray"][1] .'&nodeId=' . $this->_tpl_vars["var"]["nodeGuid"]));?>"><?php echo $this->_tpl_vars["var"]["nodeName"];?></a></li>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <?php if (($this->_tpl_vars["key"]+1)==count($this->_tpl_vars["storeSite"]["data"])){?>
                                        <li style="border-bottom:none;">
<a href="<?php echo $this->_tpl_vars["urlArray"]["0"];?><?php echo runFunc('encrypt_url',array($this->_tpl_vars["urlArray"][1] .'&nodeId=' . $this->_tpl_vars["var"]["nodeGuid"]));?>"><?php echo $this->_tpl_vars["var"]["nodeName"];?></a></li>
                                    <?php }else{ ?>
                                        <li>
<a href="<?php echo $this->_tpl_vars["urlArray"]["0"];?><?php echo runFunc('encrypt_url',array($this->_tpl_vars["urlArray"][1] .'&nodeId=' . $this->_tpl_vars["var"]["nodeGuid"]));?>"><?php echo $this->_tpl_vars["var"]["nodeName"];?></a></li>
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
            <div class="c_lyjd">
            	<div class="title"></div>
                <div class="content2">
            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "jdList",
	'where' => "c.photo != ''",
	'nodeid' => "LYJDR5si",
	'num' => "5",
 ); 

$this->_tpl_vars['jdList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    			<?php if(!empty($this->_tpl_vars["jdList"]["data"])){ 
 foreach ($this->_tpl_vars["jdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    	
                    <div class="t">> <a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></div>
                    <div class="c">
                    	<div class="pic"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["photo"];?>" width="84" height="64" border="0" /></a></div>
                        <div class="con"><?php $this->_tpl_vars["jdIntro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,30); ?><?php echo $this->_tpl_vars["jdIntro"];?><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">【更多】</a></div>
                    </div>
                <?php  }
} ?>    
                    
                </div>
            </div>
        </div>
        <div class="rightbox">
        	<div class="cbox">
            	<div class="title"><?php echo $this->_tpl_vars["listcontent"]["title"];?></div>
                <div class="content">
                	<div class="intro"><?php echo $this->_tpl_vars["listcontent"]["intro"];?> </div>
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
