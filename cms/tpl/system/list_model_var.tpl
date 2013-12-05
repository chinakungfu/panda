<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<pp:include file="check_login.tpl" type="tpl"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script language=JavaScript type="" >
function addPublishPsn()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="addModelVar";
	document.forms[0].submit();
}
</script>
<style type="text/css">
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	color: #666666;
	text-decoration: none;
}
a:hover {
	color: #666666;
	text-decoration: underline;
}
a:active {
	color: #666666;
	text-decoration: none;
}
</style></head>
<body>

<div class="main_content">
   	<div class="main_content_nav">当前位置： 系统管理 >> 系统管理 >> 模块变量管理</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
<pp:var name="result" value="@listModelVar()"/>
<pp:memfunc funcname="listPage($result.pageinfo,'index.php','5')"/>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">变量标识</td>
          	<td class="listHeader">变量名</td>
          	<td class="listHeader">变量值</td>
          	<td class="listHeader">全局变量</td>
          	<td class="listHeader">执行操作</td>
       </tr> 
       <loop name="result.data"  var="var" key="key">
       <tr>
       		<td class="tdListItem">[$var.varTitle]</td>
          	<td class="tdListItem">[$var.varName]</td>
          	<td class="tdListItem">[$var.varValue]</td>
          	<pp:if expr="$var.isGlobal=='0'">
          	<td class="tdListItem">否</td>
          	<pp:else/>
          	<td class="tdListItem">是</td>
          	</pp:if>
            <td class="tdListItem">
            <pp:var name="editUrl" value="'action=cms&method=editModelVar&varId='.$var.varId"/>
          	<pp:var name="delUrl" value="'action=cms&method=delModelVar&varId='.$var.varId"/>
            <a href="index.php[@encrypt_url($editUrl)]">编辑</a>&nbsp;&nbsp;
            <a href="index.php[@encrypt_url($delUrl)]">删除</a></td>              
       </tr>
       </loop>
    </table>
    <pp:memfunc funcname="listPage($result.pageinfo,'index.php','5')"/>
    <table width="100%" id="editgroup">
      <tr>
        <td width="70%">
          <input type="button" value="新增模块变量" onClick="addPublishPsn();">
          </td>
        <td width="30%"></td>
      </tr>
    </TABLE>
    </form>
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
