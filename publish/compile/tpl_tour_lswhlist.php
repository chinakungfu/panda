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
        	<div class="c_gzjs">
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
	'action' => "list",
	'return' => "aboutList",
	'nodeid' => "GZJScohf",
	'orderby' => "i.publishDate ASC",
 ); 

$this->_tpl_vars['aboutList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>  
                        <?php if(!empty($this->_tpl_vars["aboutList"]["data"])){ 
 foreach ($this->_tpl_vars["aboutList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                            <?php if (($this->_tpl_vars["key"]+1)==count($this->_tpl_vars["aboutList"]["data"])){?>
                                <li style="border-bottom:none;"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
                            <?php }else{ ?>
                                <li><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
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
        <div class="rightbox">
        	<div class="cbox">
            	<div class="title"><?php echo $this->_tpl_vars["node"]["nodeName"];?></div>
                <div class="content">
            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "lyhdList",
	'nodeid' => "{$this->_tpl_vars["node"]["nodeGuid"]}",
	'orderby' => "i.publishDate DESC",
	'num' => "page-6",
 ); 

$this->_tpl_vars['lyhdList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
            	<?php if(!empty($this->_tpl_vars["lyhdList"]["data"])){ 
 foreach ($this->_tpl_vars["lyhdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                    <div class="listt"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo $this->_tpl_vars["var"]["title"];?></a>&nbsp;&nbsp;<span>[<?php echo runFunc('date',array('Y-m-d',$this->_tpl_vars["var"]["publishDate"]));?>]</span></div>
                    <div class="listc">
<?php $this->_tpl_vars["lyhdIntro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,125); ?>
<?php echo $this->_tpl_vars["lyhdIntro"];?><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">更多>></a>
                    </div>
                <?php  }
} ?>  
                </div>
                <div class="page">
                    <?php $this->_tpl_vars["listPage"]=runFunc('listPageUrl',array($this->_tpl_vars["lyhdList"]["pageinfo"],'../publish/index.php',10,"nodeId={$this->_tpl_vars["IN"]["nodeId"]}")); ?>
                    <?php
$_tmp13240177481258=$this->_tpl_vars;
$this->_tpl_vars["pageInfo"] = $this->_tpl_vars["listPage"];
$inc_tpl_file=includeFunc(<<<LNMV
tour_page.tpl
LNMV
);
include($inc_tpl_file);
$this->_tpl_vars=$_tmp13240177481258;
unset($_tmp13240177481258);
?>

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
