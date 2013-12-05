<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<cms action="content" return="listcontent" nodeid="{$IN.nodeId}" contentid="{$IN.id}"/>
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
   		  <div class="topt"><div class="fontbox">◎ 用户修改密码</div></div>
          <div class="cbox">
            <form action="app.php?action=edit&con=setpassword&nodeId=YHGLk7pW&contentId=[$user.staffId]" method="post">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <th width="164">用户名：</th>
                  <td width="604">[$user.staffName]</td>
                </tr>
                <tr>
                  <th>原密码：</th>
                  <td><input type="password" name="oldpwd"/></td>
                </tr>
                <tr>
                  <th>新密码：</th>
                  <td><input type="password" name="password"/></td>
                </tr>
                <tr>
                  <th>确认新密码：</th>
                  <td><input type="password" name="newpwd"/></td>
                </tr>
                <tr>
                  <th></th>
                  <td><input type="submit" value="修改密码"/></td>
                </tr>
            </table>
            </form>
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
