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
	'contentid' => "{$this->_tpl_vars["IN"]["mpId"]}",
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
                  <th>门牌号</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["mpNo"];?></td>
                  <th>产权人</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["humanRights"];?></td>
                </tr>
                <tr>
                  <th>身份证号码</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["idNumber"];?></td>
                  <th>联系电话</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["telephone"];?></td>
                </tr>
                <tr>
                  <th>地址</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["address"];?></td>
                </tr>
                <tr>
                  <th>办证时间</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["bzTime"];?></td>
                  <th>楼层</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["floor"];?></td>
                </tr>
                <tr>
                  <th>占地面积</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["area"];?> 平方米</td>
                  <th>建筑面积</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["constructionArea"];?>平方米</td>
                </tr>
                <tr>
                  <th>房屋属性</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["properties"];?></td>
                  <th>保护等级</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["protectionClass"];?></td>
                </tr>
                <tr>
                  <th>修建年代</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["buildingYears"];?></td>
                  <th>规划图纸</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["drawing"];?></td>
                </tr>
                <tr>
                  <th>改造后图纸</th>
                  <td><?php if (!empty($this->_tpl_vars["listcontent"]["beforeChange"])){?><a href="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["listcontent"]["beforeChange"];?>">点击下载</a><?php }else{ ?>暂无规划图<?php } ?></td>
                  <th>改造前图纸</th>
                  <td><?php if (!empty($this->_tpl_vars["listcontent"]["afterChange"])){?><a href="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["listcontent"]["afterChange"];?>">点击下载</a><?php }else{ ?>暂无规划图<?php } ?></td>
                </tr>
                <tr>
                  <th>片区编号</th>
                  <td>第 <?php echo $this->_tpl_vars["listcontent"]["areaNo"];?> 区</td>
                  <th>建筑编号</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["buildingNo"];?> 号</td>
                </tr>
                <tr>
                  <th>备注</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["beiZhu"];?></td>
                </tr>
                <tr>
                  <th>房产情况介绍</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["intro"];?></td>
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
