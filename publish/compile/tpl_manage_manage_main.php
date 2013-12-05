<?php import('core.util.RunFunc'); ?><?php
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_check.php
LNMV
);
include($inc_tpl_file);
?>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link rel="stylesheet" type="text/css" media="screen" href="/skin/css/adminstyle.css" />
</head>

<body class="rightbody">
<div class="mainbox">
	<div class="yplace">
    	<div class="cfont">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
manage_yplace.tpl
LNMV
);
include($inc_tpl_file);
?>

        </div>
    </div>
    
    <div class="block">
   	  <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 课题介绍</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center">
                <tr>
                  <td width="23%" height="auto" valign="middle"><img src="/skin/images/intro_pic.jpg" width="161" height="102" border="0" /></td>
                  <td width="77%" valign="middle" class="introfont">
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "introC",
	'where' => "i.pink = '1'",
	'nodeid' => "KTJSC3GX",
	'num' => "1",
 ); 

$this->_tpl_vars['introC'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    <?php if(!empty($this->_tpl_vars["introC"]["data"])){ 
 foreach ($this->_tpl_vars["introC"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
    <?php $this->_tpl_vars["intro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,195); ?>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars["intro"];?><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">【详细】</a>
	<?php  }
} ?>
                  </td>
                </tr>
            </table>
          </div>
      </div>
      <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 住区管理</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center">
                <tr>
                  <td class="piclistbox"><a href="/publish/search.php?nodeId=JMGLZT1m&pageSize=20&tpl=manage/manage_zqgl_jmgl"><img src="/skin/images/jmgl.jpg" width="104" height="75" border="0" /></a><br /><a href="/publish/search.php?nodeId=JMGLZT1m&pageSize=20&tpl=manage/manage_zqgl_jmgl">居民管理</a></td>
                  <td class="piclistbox"><a href="/publish/search.php?nodeId=MZGLPj5b&pageSize=20&tpl=manage/manage_mzgl"><img src="/skin/images/mzgl.jpg" width="104" height="75" border="0" /></a><br /><a href="/publish/search.php?nodeId=MZGLPj5b&pageSize=20&tpl=manage/manage_mzgl">民宅管理</a></td>
                  <td class="piclistbox"><a href="/publish/search.php?nodeId=JDGLSnOB&pageSize=20&tpl=manage/manage_street"><img src="/skin/images/jdgl.jpg" width="104" height="75" border="0" /></a><br /><a href="/publish/search.php?nodeId=JDGLSnOB&pageSize=20&tpl=manage/manage_street">行政管理</a></td>
                  <td class="piclistbox"><a href="/publish/search.php?nodeId=GGSSGLjzF1&pageSize=20&tpl=manage/manage_fenlei"><img src="/skin/images/ggssgl.jpg" width="104" height="75" border="0" /></a><br /><a href="/publish/search.php?nodeId=GGSSGLjzF1&pageSize=20&tpl=manage/manage_fenlei">公共设施管理</a></td>
                  
                </tr>
            </table>
          </div>
      </div>
      <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 规划建设管理</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center">
                <tr>
                  <td valign="top">
                  	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                    	<tr>
                          <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">古镇资料库</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=manage&method=gzzlc&nodeId=GZXZcqTB'));?>">更多>></a></td>
                            	</tr>
                            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "zlkList",
	'nodeid' => "GZXZcqTB",
	'orderby' => "i.publishDate DESC",
	'num' => "4",
 ); 

$this->_tpl_vars['zlkList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     							<?php if(!empty($this->_tpl_vars["zlkList"]["data"])){ 
 foreach ($this->_tpl_vars["zlkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                                <tr><td colspan="2" class="fk_listT"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">· <?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 27));?></a></td></tr>
                                <?php  }
} ?>
                            </table>
                          </td>
                          <td width="4%"></td>
                          <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">规划项目库</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=manage&method=planning&nodeId=GHXMKAlsF'));?>">更多>></a></td>
                            	</tr>
                                <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "zlkList",
	'nodeid' => "GHXMKAlsF",
	'orderby' => "i.publishDate DESC",
	'num' => "4",
 ); 

$this->_tpl_vars['zlkList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     							<?php if(!empty($this->_tpl_vars["zlkList"]["data"])){ 
 foreach ($this->_tpl_vars["zlkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                                <tr><td colspan="2" class="fk_listT"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">· <?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["planName"] , 0, 27));?></a></td></tr>
                                <?php  }
} ?>
                            </table>
                          </td>
                    	</tr>
                        <tr><td height="10"></td></tr>
                        <tr>
                    	  <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">建设项目库</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=manage&method=jsxmc&nodeId=JSXMKP9Wq'));?>">更多>></a></td>
                            	</tr>
                            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "zlkList",
	'nodeid' => "JSXMKP9Wq",
	'orderby' => "i.publishDate DESC",
	'num' => "4",
 ); 

$this->_tpl_vars['zlkList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     							<?php if(!empty($this->_tpl_vars["zlkList"]["data"])){ 
 foreach ($this->_tpl_vars["zlkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                                <tr><td colspan="2" class="fk_listT"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">· <?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["proName"] , 0, 27));?></a></td></tr>
                                <?php  }
} ?>
                            </table>
                          </td>
                          <td width="4%"></td>
                    	  <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">规划建设动态</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=manage&method=list&nodeId=GHJSDTmDgN'));?>">更多>></a></td>
                            	</tr>
                            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "zlkList",
	'nodeid' => "GHJSDTmDgN",
	'orderby' => "i.publishDate DESC",
	'num' => "4",
 ); 

$this->_tpl_vars['zlkList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     							<?php if(!empty($this->_tpl_vars["zlkList"]["data"])){ 
 foreach ($this->_tpl_vars["zlkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                                <tr><td colspan="2" class="fk_listT"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">· <?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 27));?></a></td></tr>
                                <?php  }
} ?>
                            </table>
                          </td>
                        </tr>
                    </table>
                  </td>
                </tr>
            </table>
          </div>
      </div>
      
      <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 社会协同管理</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center">
                <tr>
                  <td valign="top">
                  	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                    	<tr>
                          <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">公告通知</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=manage&method=list&nodeId=GGTZWHLHGd'));?>">更多>></a></td>
                            	</tr>
                            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "zlkList",
	'nodeid' => "GGTZWHLHGd",
	'orderby' => "i.publishDate DESC",
	'num' => "4",
 ); 

$this->_tpl_vars['zlkList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     							<?php if(!empty($this->_tpl_vars["zlkList"]["data"])){ 
 foreach ($this->_tpl_vars["zlkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                                <tr><td colspan="2" class="fk_listT"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">· <?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 27));?></a></td></tr>
                                <?php  }
} ?>
                            </table>
                          </td>
                          <td width="4%"></td>
                    	  <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">公众调查</td>
                            	  <td width="24%" class="fk_boxM"><a href="#">更多>></a></td>
                            	</tr>
                            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "zlkList",
	'nodeid' => "GZDCCJOfXy",
	'orderby' => "i.publishDate DESC",
	'num' => "4",
 ); 

$this->_tpl_vars['zlkList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     							<?php if(!empty($this->_tpl_vars["zlkList"]["data"])){ 
 foreach ($this->_tpl_vars["zlkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                                <tr><td colspan="2" class="fk_listT"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">· <?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 27));?></a></td></tr>
                                <?php  }
} ?>
                            </table>
                          </td>
                    	</tr>
                    </table>
                  </td>
                </tr>
                <tr><td height="10"></td></tr>
                <tr>
                  <td valign="top">
                  	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                    	<tr>
                          <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">办事指南</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=manage&method=bslist&nodeId=BSZNqUoC'));?>">更多>></a></td>
                            	</tr>
                            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "zlkList",
	'nodeid' => "BSZNqUoC",
	'orderby' => "i.publishDate DESC",
	'num' => "4",
 ); 

$this->_tpl_vars['zlkList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     							<?php if(!empty($this->_tpl_vars["zlkList"]["data"])){ 
 foreach ($this->_tpl_vars["zlkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                                <tr><td colspan="2" class="fk_listT"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">· <?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 27));?></a></td></tr>
                                <?php  }
} ?>
                            </table>
                          </td>
                          <td width="4%"></td>
                    	  <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">办事文档</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=manage&method=bslist&nodeId=BSWDb6ps'));?>">更多>></a></td>
                            	</tr>
                            <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "zlkList",
	'nodeid' => "BSWDb6ps",
	'orderby' => "i.publishDate DESC",
	'num' => "4",
 ); 

$this->_tpl_vars['zlkList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     							<?php if(!empty($this->_tpl_vars["zlkList"]["data"])){ 
 foreach ($this->_tpl_vars["zlkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    
                                <tr><td colspan="2" class="fk_listT"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">· <?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 27));?></a></td></tr>
                                <?php  }
} ?>
                            </table>
                          </td>
                    	</tr>
                    </table>
                  </td>
                </tr>
            </table>
          </div>
      </div>
      <div class="copyrightBox">
      	<div class="cboxc">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_inc_copyright.tpl
LNMV
);
include($inc_tpl_file);
?>

        </div>
      </div>
    </div>
    
</div>
</body>
</html>
