<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<cms action="content" return="listcontent" nodeid="{$IN.nodeId}" contentid="{$IN.fenleiNo}"/>
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
                  <th>建筑编号</th>
                  <td>[$listcontent.buidingNo]</td>
                  <th>标题名称</th>
                  <td>[$listcontent.title]</td>
                </tr>
                <tr>
                  <th>属性/类别</th>
                  <td>[$listcontent.fenleiType]</td>
                  <th>产权人</th>
                  <td>[$listcontent.ofPeople]</td>
                </tr>
                <tr>
                  <th>地址</th>
                  <td colspan="3">[$listcontent.address]</td>
                </tr>
                <tr>
                  <th>面积</th>
                  <td colspan="3">[$listcontent.area]&nbsp;平方米</td>
                </tr>
                <tr>
                  <th>介绍</th>
                  <td colspan="3">[$listcontent.intro]</td>
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
