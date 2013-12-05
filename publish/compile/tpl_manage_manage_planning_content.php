<?php
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
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "content",
	'return' => "listcontent",
	'nodeid' => "{$this->_tpl_vars["IN"]["nodeId"]}",
	'contentid' => "{$this->_tpl_vars["IN"]["planningId"]}",
 ); 

$this->_tpl_vars['listcontent'] = CMS::CMS_content($params); 
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
   		  <div class="topt"><div class="fontbox">◎ <?php echo $this->_tpl_vars["node"]["nodeName"];?>内容详情</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <th>规划名称</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["planName"];?></td>
                  <th>编制单位</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["planUnit"];?></td>
                </tr>
                <tr>
                  <th>编制时间</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["startTime"];?></td>
                  <th>审批文号</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["spFileNum"];?></td>
                </tr>
                <tr>
                  <th>审批单位</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["spUnit"];?></td>
                  <th>审批时间</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["spTime"];?></td>
                </tr>
                <tr>
                  <th>备注</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["beiZhu"];?></td>
                </tr>
                <tr>
                  <th>审批文件</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["spFile"];?></td>
                </tr>
                <tr>
                  <th>成果资料文件</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["content"];?></td>
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
