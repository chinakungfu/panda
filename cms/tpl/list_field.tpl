<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<pp:include file="check_login.tpl" type="tpl"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>内容模型管理页面</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script language=JavaScript type="" >
function editTable()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="saveEditFieldConfig";
	document.forms[0].submit();
}
function addField()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="addField";
	document.forms[0].submit();
}
function fieldOrder()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="fieldOrder";
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
   	<div class="main_content_nav">当前位置： 系统管理 >> 字段配置管理 >> 编辑字段集</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="fieldConfigId" value="[$fieldConfigId]">
<pp:var name="fieldConfig" value="@getFieldConfigInfoById($fieldConfigId)"/>
	<div class="detailMember_txt">字段配置名称：</div>
	<div class="detailMember_info"><input type="text" name="para[fieldConfigName]" value="[$fieldConfig.0.fieldConfigName]" ></div>
	<div class="detailMember_txt">字段配置说明：</div>
	<div class="detailMember_info"><input type="text" name="para[fieldConfigDes]" value="[$fieldConfig.0.fieldConfigDes]" ></div>
<div class="detailMember_nav">编辑字段集</div>
<pp:var name="result" value="@listFieldInfo($fieldConfigId)"/>
<pp:memfunc funcname="listPage($result.pageinfo,'index.php','5')"/>    
<table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">字段中文名</td>
          	<td class="listHeader">字段英文名</td>
          	<td class="listHeader">字段类型</td>
          	<td class="listHeader">字段长度</td>
          	<td class="listHeader">字段输入类型</td>
          	<td class="listHeader">字段可选值</td>
          	<td class="listHeader">表单输入限制</td>
          	<td class="listHeader">表单值采集器</td>
          	<td class="listHeader">表单输入预设模板</td>
          	<td class="listHeader">执行操作</td>
       </tr>  
       
       <loop name="result.data"  var="var" key="key">
       <tr>
          <td class="tdListItem">[$var.fieldTitle]</td>
          	<td class="tdListItem">[$var.fieldName]</td>
          	<td class="tdListItem">[$var.fieldType]</td>
          	<td class="tdListItem">[$var.fieldSize]</td>
          	<td class="tdListItem">[$var.fieldInput]</td>
          	<td class="tdListItem" title="[$var.fieldDefaultValue]">[@CsubStr($var.fieldDefaultValue,0,10)]</td>
          	<td class="tdListItem">[$var.fieldInputFilter]</td>
          	<td class="tdListItem">[$var.fieldInputFilter]</td>
          	<td class="tdListItem">[$var.fieldInputPicker]</td>
          <td class="tdListItem">
          <pp:var name="editUrl" value="'action=cms&method=editField&fieldConfigId='.$fieldConfigId .'&fieldId='.$var.fieldId"/>
          	<pp:var name="delUrl" value="'action=cms&method=delField&fieldConfigId='.$fieldConfigId .'&fieldId='.$var.fieldId"/>
            <a href="index.php[@encrypt_url($editUrl)]">编辑</a>&nbsp;&nbsp;
            <a href="index.php[@encrypt_url($delUrl)]">删除</a>
          </td>              

       </tr>
       </loop>
    </table>
    <pp:memfunc funcname="listPage($result.pageinfo,'index.php','5')"/>
    <table width="100%" id="editgroup">
      <tr>
        <td width="70%">
          <input type="button" value="修改" onClick="editTable();">
          <input type="button" value="新增字段" onClick="addField();">
          <input type="button" value="字段排序" onClick="fieldOrder();">	
          </TD>
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
