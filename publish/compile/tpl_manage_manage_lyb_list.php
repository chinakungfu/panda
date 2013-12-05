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
   		  <div class="topt"><div class="fontbox">◎ <?php echo $this->_tpl_vars["node"]["nodeName"];?>列表</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th width="auto" style="text-align:left; padding-left:10px;">留言姓名</th>
                  <th width="100">联系电话</th>
                  <th width="100">发布日期</th>
                  <th width="98">操作</th>
                </tr>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "allList",
	'nodeid' => "{$this->_tpl_vars["node"]["nodeGuid"]}",
	'orderby' => "i.publishDate DESC",
	'num' => "page-20",
 ); 

$this->_tpl_vars['allList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
     <?php if(!empty($this->_tpl_vars["allList"]["data"])){ 
 foreach ($this->_tpl_vars["allList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                <tr>
                  <td style="text-align:left; padding-left:10px;"><?php echo $this->_tpl_vars["var"]["lyName"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["telephoneNum"];?></td>
                  <td><?php echo runFunc('date',array("Y-m-d", $this->_tpl_vars["var"]["publishDate"]));?></td>
                  <td><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">查看</a></td>
                </tr>
    <?php  }
} ?>
                <tr>
                  <td colspan="4">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td style="text-align:right; padding-right:10px;">
  <?php $this->_tpl_vars["listPage"]=runFunc('listPageUrl',array($this->_tpl_vars["allList"]["pageinfo"],'../publish/index.php',10,"nodeId={$this->_tpl_vars["IN"]["nodeId"]}")); ?>
  <?php
$_tmp13240177493565=$this->_tpl_vars;
$this->_tpl_vars["pageInfo"] = $this->_tpl_vars["listPage"];
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_page.tpl
LNMV
);
include($inc_tpl_file);
$this->_tpl_vars=$_tmp13240177493565;
unset($_tmp13240177493565);
?>

  						  </td>
                   	    </tr>
                    </table>
              </td></tr>
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
