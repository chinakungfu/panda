<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<cms action="content" return="listcontent" nodeid="{$IN.nodeId}" contentid="{$IN.proNo}"/>
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
<pp:include file="manage_yplace.tpl" type="tpl"/>
        </div>
    </div>
    
    <div class="block">
   	  <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ [$node.nodeName]内容详情</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <th>项目名称</th>
                  <td>[$listcontent.proName]</td>
                  <th>项目规模</th>
                  <td>[$listcontent.proGm]</td>
                </tr>
                <tr>
                  <th>建设单位</th>
                  <td>[$listcontent.proJsUnit]</td>
                  <th>设计单位</th>
                  <td>[$listcontent.proSjUnit]</td>
                </tr>
                <tr>
                  <th>施工单位</th>
                  <td>[$listcontent.proSgUnit]</td>
                  <th>监理单位</th>
                  <td>[$listcontent.proJlUnit]</td>
                </tr>
                <tr>
                  <th>开工时间</th>
                  <td>[$listcontent.startDate]</td>
                  <th>竣工时间</th>
                  <td>[$listcontent.endDate]</td>
                </tr>
                <tr>
                  <th>概（预）算金额</th>
                  <td>[$listcontent.ysFare]</td>
                  <th>决算金额</th>
                  <td>[$listcontent.endFare]</td>
                </tr>
                <tr>
                  <th>备注</th>
                  <td colspan="3">[$listcontent.beiZhu]</td>
                </tr>
                <tr>
                  <th>设计成果文件</th>
                  <td colspan="3">[$listcontent.sjFile]</td>
                </tr>
                <tr>
                  <th>竣工成果文件</th>
                  <td colspan="3">[$listcontent.endFiles]</td>
                </tr>
            </table>
          </div>
      </div>
      
      
      
      <div class="copyrightBox">
      	<div class="cboxc">
<include file="manage/manage_inc_copyright.tpl" type="tpl"/>
        </div>
      </div>
    </div>
    
</div>
</body>
</html>
