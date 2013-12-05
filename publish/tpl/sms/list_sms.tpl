<include file="manage/manage_check.php" type="tpl"/>
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
			当前位置：<a href="/publish/index.php?LCMSPID=ADEHbVUjVG4Ca1I8BjwKbVA%2BXm4BMFA1BmdTego%2BUGYDJwVkBWgBNgQ%2FAG1XMQBjDm8%3D">首页</a> > 短信列表
        </div>
    </div>
    
    <div class="block">
   	  <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 短信列表</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th width="60">手机号</th>
                  <th width="120">日期时间</th>
                  <th width="50">状态</th>
                  <th >内容</th>
                </tr>
<pp:appfunc app="publish" file="./appfunc/sms" return="result" funcname="listSMS()"/>
     <loop name="result.data" var="var" key="key">
                <tr>
                  <td>[$var.DestNumber]</td>
                  <td>[$var.SendTime]</td>
                  <td>
                  <pp:if expr="$var.SendFlag==0">
                  等待发送
                  <pp:elseif expr="$var.SendFlag==1">
                  正在发送
                  <pp:elseif expr="$var.SendFlag==2">
                  发送成功
                  </pp:if>
                  </td>
                  <td>[$var.Content]</td>
                </tr>
    </loop>
                <tr>
                  <td colspan="4">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td style="text-align:right; padding-right:10px;">
  <pp:var name="listPage" value="@listPageUrl($result.pageinfo,'../publish/index.php',10,"")" />
  <include file="manage/manage_page.tpl" type="tpl" global="1" pageInfo="$listPage"/>
  						  </td>
                   	    </tr>
                    </table>
              </td></tr>
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
