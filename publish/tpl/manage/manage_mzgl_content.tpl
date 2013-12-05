<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<cms action="content" return="listcontent" nodeid="{$IN.nodeId}" contentid="{$IN.mpId}"/>
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
                  <th>门牌号</th>
                  <td>[$listcontent.mpNo]</td>
                  <th>产权人</th>
                  <td>[$listcontent.humanRights]</td>
                </tr>
                <tr>
                  <th>身份证号码</th>
                  <td>[$listcontent.idNumber]</td>
                  <th>联系电话</th>
                  <td>[$listcontent.telephone]</td>
                </tr>
                <tr>
                  <th>地址</th>
                  <td colspan="3">[$listcontent.address]</td>
                </tr>
                <tr>
                  <th>办证时间</th>
                  <td>[$listcontent.bzTime]</td>
                  <th>楼层</th>
                  <td>[$listcontent.floor]</td>
                </tr>
                <tr>
                  <th>占地面积</th>
                  <td>[$listcontent.area] 平方米</td>
                  <th>建筑面积</th>
                  <td>[$listcontent.constructionArea]平方米</td>
                </tr>
                <tr>
                  <th>房屋属性</th>
                  <td>[$listcontent.properties]</td>
                  <th>保护等级</th>
                  <td>[$listcontent.protectionClass]</td>
                </tr>
                <tr>
                  <th>修建年代</th>
                  <td>[$listcontent.buildingYears]</td>
                  <th>规划图纸</th>
                  <td>[$listcontent.drawing]</td>
                </tr>
                <tr>
                  <th>改造后图纸</th>
                  <td><if test="!empty($listcontent.beforeChange)"><a href="../web-inf/lib/coreconfig/[$listcontent.beforeChange]">点击下载</a><else>暂无规划图</if></td>
                  <th>改造前图纸</th>
                  <td><if test="!empty($listcontent.afterChange)"><a href="../web-inf/lib/coreconfig/[$listcontent.afterChange]">点击下载</a><else>暂无规划图</if></td>
                </tr>
                <tr>
                  <th>片区编号</th>
                  <td>第 [$listcontent.areaNo] 区</td>
                  <th>建筑编号</th>
                  <td>[$listcontent.buildingNo] 号</td>
                </tr>
                <tr>
                  <th>备注</th>
                  <td colspan="3">[$listcontent.beiZhu]</td>
                </tr>
                <tr>
                  <th>房产情况介绍</th>
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
