<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
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
   		  <div class="topt"><div class="fontbox">◎ 暂住流动人口管理列表</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th width="40">选择</th>
                  <th width="30">ID</th>
                  <th>村名称</th>
                  <th>组名称</th>
                  <th>户主姓名</th>
                  <th>姓名</th>
                  <th>性别</th>
                  <th>民族</th>
                  <th>出生日期</th>
                  <th>婚姻状况</th>
                  <th>户口性质</th>
                  <th>操作</th>
                </tr>
<cms action="list" return="jmglList" nodeid="JMGLZT1m" where="c.householdCodes != '520111101'" OrderBy="i.publishDate DESC" num="page-20"/>
     <loop name="jmglList.data" var="var" key="key">
                <tr>
                  <td><input type="checkbox" name="" id=""  /></td>
                  <td></td>
                  <td>[$var.villageName]</td>
                  <td>[$var.groupName]</td>
                  <td>[$var.householdName]</td>
                  <td>[$var.peopleName]</td>
                  <td>[$var.sex]</td>
                  <td>[$var.nation]</td>
                  <td>[$var.birthDate]</td>
                  <td>[$var.marry]</td>
                  <td>[$var.account]</td>
                  <td><a href="[$var.url]">浏览</a> 编辑</td>
                </tr>
    </loop>
                <tr>
                  <td colspan="12">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td width="34%" style="text-align:left; padding-left:10px;"><input name="" id="" type="button" value="全选" />&nbsp;&nbsp;<input name="" id="" type="button" value="删除" /></td>
                    	  <td width="66%" style="text-align:right; padding-right:10px;">
<pp:var name="listPage" value="@listPageUrl($jmglList.pageinfo,'../publish/index.php',10,"nodeId={$IN.nodeId}")" />
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
