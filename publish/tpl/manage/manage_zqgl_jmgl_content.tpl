<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<cms action="content" return="listcontent" nodeid="{$IN.nodeId}" contentid="{$IN.hjNo}"/>
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
   		  <div class="topt"><div class="fontbox">◎ [$node.nodeName]详情</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <th>姓名</th>
                  <td>[$listcontent.peopleName]</td>
                  <th>性别</th>
                  <td>[$listcontent.sex]</td>
                </tr>
                <tr>
                  <th>民族</th>
                  <td>[$listcontent.nation]</td>
                  <th>出生日期</th>
                  <td>[$listcontent.birthDate]</td>
                </tr>
                <tr>
                  <th>所属行政区域</th>
                  <td colspan="3">[$listcontent.areaId]</td>
                </tr>
                <tr>
                  <th>村名称</th>
                  <td>[$listcontent.villageName]</td>
                  <th>组名称</th>
                  <td>[$listcontent.groupName]</td>
                </tr>
                <tr>
                  <th>档案号</th>
                  <td>[$listcontent.docNum]</td>
                  <th>户主姓名</th>
                  <td>[$listcontent.householdName]</td>
                </tr>
                <tr>
                  <th>户标识</th>
                  <td>[$listcontent.householdId]</td>
                  <th>成员标识</th>
                  <td>[$listcontent.memberId]</td>
                </tr>
                <tr>
                  <th>婚姻状况</th>
                  <td>[$listcontent.marry]</td>
                  <th>婚姻状况发生日期</th>
                  <td>[$listcontent.marryDate]</td>
                </tr>
                <tr>
                  <th>户口性质</th>
                  <td>[$listcontent.account]</td>
                  <th>户籍地编码</th>
                  <td>[$listcontent.householdCodes] <if test="$listcontent.householdCodes != '520111101'">暂住人口</if></td>
                </tr>
                <tr>
                  <th>户籍地说明</th>
                  <td colspan="3">[$listcontent.householdIntro]</td>
                </tr>
                <tr>
                  <th>身份证号</th>
                  <td colspan="3">[$listcontent.idNumber]</td>
                </tr>
                <tr>
                  <th>原有子女</th>
                  <td>男：[$listcontent.oldMaleChildren]&nbsp;&nbsp;女：[$listcontent.oldMaleChildren]</td>
                  <th>现有子女</th>
                  <td>男：[$listcontent.nowMaleChildren]&nbsp;&nbsp;女：[$listcontent.nowMaleChildren]</td>
                </tr>
                <tr>
                  <th>变动类型</th>
                  <td>[$listcontent.changeType]</td>
                  <th>变动日期</th>
                  <td>[$listcontent.changeDate]</td>
                </tr>
                <tr>
                  <th>有无照片</th>
                  <td><if test="empty($listcontent.isPhoto)">暂无照片<else><img src="../web-inf/lib/coreconfig/[$listcontent.isPhoto]" width="130" height="145" border="0"></if></td>
                  <th>联系手机</th>
                  <td>[$listcontent.mobileNum]</td>
                </tr>
                <tr>
                  <th>备注</th>
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
