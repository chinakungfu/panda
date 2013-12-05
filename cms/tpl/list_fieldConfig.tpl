<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<pp:include file="check_login.tpl" type="tpl"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>内容模型管理页面</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
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
   	<div class="main_content_nav">当前位置： 系统管理 >> 字段配置管理</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<pp:var name="result" value="@listFieldConfigInfo()"/>
       <pp:memfunc funcname="listPage($result.pageinfo,'index.php','5')"/>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">字段配置ID</td>
          	<td class="listHeader">字段配置名</td>
          	<td class="listHeader">配置描述</td>
          	<td class="listHeader">执行操作</td>
       </tr>  
       
       <loop name="result.data"  var="var" key="key">
       <tr>
          <td class="tdListItem">[$var.fieldConfigId]</td>
          <td class="tdListItem">[$var.fieldConfigName]</td>
          <td class="tdListItem">[$var.fieldConfigDes]</td>
          <td class="tdListItem">
          <pp:var name="editUrl" value="'action=cms&method=listField&fieldConfigId='.$var.fieldConfigId"/>
          	<pp:var name="delUrl" value="'action=cms&method=delFieldConfig&fieldConfigId='.$var.fieldConfigId"/>
            <a href="index.php[@encrypt_url($editUrl)]">编辑</a>&nbsp;&nbsp;
            <a href="index.php[@encrypt_url($delUrl)]">删除</a>
          </td>
       </tr>
       </loop>
    </table>
     <pp:memfunc funcname="listPage($result.pageinfo,'index.php','5')"/>
    </div>
<form id="from1" action="index.php" method="POST">
<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="saveAddFieldConfig">
<div class="detailMember_nav">新建字段配置</div>     
	<div class="detailMember_txt">字段配置名称：</div>
	<div class="detailMember_info"><input type="text" name="para[fieldConfigName]" value="" ></div>
	<div class="detailMember_txt">字段配置说明：</div>
	<div class="detailMember_info"><input type="text" name="para[fieldConfigDes]" value="" ></div>
<div class="detailMember_doedit">
<input type="submit" name="submit" value="创建"">
</div>
</form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
