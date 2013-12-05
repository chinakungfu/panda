<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<cms action="content" return="listcontent" nodeid="{$IN.nodeId}" contentid="{$IN.planningId}"/>
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
                  <th>规划名称</th>
                  <td>[$listcontent.planName]</td>
                  <th>编制单位</th>
                  <td>[$listcontent.planUnit]</td>
                </tr>
                <tr>
                  <th>编制时间</th>
                  <td>[$listcontent.startTime]</td>
                  <th>审批文号</th>
                  <td>[$listcontent.spFileNum]</td>
                </tr>
                <tr>
                  <th>审批单位</th>
                  <td>[$listcontent.spUnit]</td>
                  <th>审批时间</th>
                  <td>[$listcontent.spTime]</td>
                </tr>
                <tr>
                  <th>备注</th>
                  <td colspan="3">[$listcontent.beiZhu]</td>
                </tr>
                <tr>
                  <th>审批文件</th>
                  <td colspan="3">[$listcontent.spFile]</td>
                </tr>
                <tr>
                  <th>成果资料文件</th>
                  <td colspan="3">[$listcontent.content]</td>
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
