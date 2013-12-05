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
	'contentid' => "{$this->_tpl_vars["IN"]["hjNo"]}",
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
    	<div class="cfont">当前位置：<a href="#">首页</a> / 居民管理</div>
    </div>
    
    <div class="block">
   	  <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 暂停人口内容详情</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <th>姓名</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["peopleName"];?></td>
                  <th>性别</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["sex"];?></td>
                </tr>
                <tr>
                  <th>民族</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["nation"];?></td>
                  <th>出生日期</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["birthDate"];?></td>
                </tr>
                <tr>
                  <th>所属行政区域</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["areaId"];?></td>
                </tr>
                <tr>
                  <th>村名称</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["villageName"];?></td>
                  <th>组名称</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["groupName"];?></td>
                </tr>
                <tr>
                  <th>档案号</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["docNum"];?></td>
                  <th>户主姓名</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["householdName"];?></td>
                </tr>
                <tr>
                  <th>户标识</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["householdId"];?></td>
                  <th>成员标识</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["memberId"];?></td>
                </tr>
                <tr>
                  <th>婚姻状况</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["marry"];?></td>
                  <th>婚姻状况发生日期</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["marryDate"];?></td>
                </tr>
                <tr>
                  <th>户口性质</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["account"];?></td>
                  <th>户籍地编码</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["householdCodes"];?></td>
                </tr>
                <tr>
                  <th>户籍地说明</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["householdIntro"];?></td>
                </tr>
                <tr>
                  <th>身份证号</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["idNumber"];?></td>
                </tr>
                <tr>
                  <th>原有子女</th>
                  <td>男：<?php echo $this->_tpl_vars["listcontent"]["oldMaleChildren"];?>&nbsp;&nbsp;女：<?php echo $this->_tpl_vars["listcontent"]["oldMaleChildren"];?></td>
                  <th>现有子女</th>
                  <td>男：<?php echo $this->_tpl_vars["listcontent"]["nowMaleChildren"];?>&nbsp;&nbsp;女：<?php echo $this->_tpl_vars["listcontent"]["nowMaleChildren"];?></td>
                </tr>
                <tr>
                  <th>变动类型</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["changeType"];?></td>
                  <th>变动日期</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["changeDate"];?></td>
                </tr>
                <tr>
                  <th>有无照片</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["isPhoto"];?></td>
                  <th>联系手机</th>
                  <td><?php echo $this->_tpl_vars["listcontent"]["mobileNum"];?></td>
                </tr>
                <tr>
                  <th>备注</th>
                  <td colspan="3"><?php echo $this->_tpl_vars["listcontent"]["intro"];?></td>
                </tr>
            </table>
          </div>
      </div>
      
      
      
      <div class="copyrightBox">
      	<div class="cboxc">
Copyright© 青岩镇人民政府 版权所有 All Right Reserved. 黔ICP备11000001号<br />
地址：贵州省贵阳市花溪南12公里处的213国道旁  电话：+86-0851-3200427  传真：+86-0851-3200427<br />
青岩住区管理信息化管理平台  课题申报单位：贵州省城乡规划设计研究院  技术支持：贵州惠智
        </div>
      </div>
    </div>
    
</div>
</body>
</html>
