<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:include file="check_login.tpl" type="tpl"/>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<title>角色管理页面</title>
<script language=JavaScript type="" >
function selectConCheck()
{
	var con = '';
	var chks =document.getElementsByName('checks');
	for(i=0;i<chks.length;i++){

		if(chks[i].checked){

			 con = chks[i].value+','+con;

		}

	}
	var selectCon=document.getElementById('selectConId');
	selectCon.value = con;
}
function adddata()
{
	document.forms[0].action.value="role";
	document.forms[0].method.value="beginInsert";
	document.forms[0].submit();
}
function editdata()
{
	document.forms[0].action.value="role";
	document.forms[0].method.value="beginUpdate";
	if (checkdata())
	{
		document.forms[0].submit();
	}

}
function deldata()
{
	document.forms[0].action.value="role";
	document.forms[0].method.value="delData";
	if (checkdata())
	{
		document.forms[0].submit();
	}
}
function checkdata()
{
	var bool=0;
	var chks=document.getElementsByName("checks");
	for(i=0;i<chks.length;i++){
		if(chks[i].checked){
			document.forms[0].roleId.value=chks[i].value;
			bool=1;
			break;
		}
	}
	if (bool==1)
	{
		return true;
	}
	else
	{
		window.alert("你首先要选择一条记录然后再记录!");
		return false;
	}
}
function clearCon()
{
	document.forms[0].action.value="yellowPages";
	document.forms[0].method.value="clearCon";
	document.forms[0].submit();
}
</script>
</head>
<body>
<pp:var name="data" value="<pp:session funcname="readSession()"/>"/>
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >> 角色管理</div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">

    <form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="roleId">

    <table width="100%" id="editgroup">
      <tr>
        <td  width="70%">
        <!--<input type="button" id="select" value="查询" onClick="parent.search();">&nbsp;&nbsp;-->
        
          <input type="button" value="新 增" name="btnadd" onClick="adddata();">
          <input type="button" value="修 改" name="btnedit" onClick="editdata();">
          <input type="button" value="删 除" name="btndel" onClick="deldata();">
          <input type="hidden" name="sessionaction" value="[$action]">
  			<input type="hidden" name="sessionmethod" value="[$method]"> 
          <!--<input type="button" value="显示全部" onClick="clearCon();">-->
          <!--
          <input type="button" class="button1" value="打 印" name="btnprint" onClick="insertdata();">
          <input type="button" class="button1" value="导 出" name="btnexport" onClick="insertdata();">
       	  <input type="button" id="select" value="查询" class="button1" onClick="parent.search();">
          -->
         </TD>
        <td width="30%"></td>
      </tr>
    </TABLE>
    <pp:var name="result" value="<pp:memfunc funcname="listRole($sqlCon,'')"/>"/>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">选中</td>
          <!--<td class="listHeader">角色Id</td>-->
      		<td class="listHeader">角色标识</td>
      		<td class="listHeader">角色名称</td>
      		<td class="listHeader">角色说明</td>
      		<td class="listHeader">绑定功能</td>
       </tr>
       
       <loop name="result.data"  var="var" key="key">
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="[$var.roleId]" onclick="selectConCheck();"></td>
         <!-- <td class="tdListItem">[$var.roleId]</td>-->
          <td class="tdListItem">[$var.roleNo]</td>
          <td class="tdListItem">[$var.roleName]</td>
          <td class="tdListItem">[@CsubStr($var.roleDesc,0,25)]</td>
          <td class="tdListItem">
          <pp:var name="tempUrl" value="'action=role&method=bindops&roleId= ' .$var.roleId .'&sqlCon='.$sqlCon"/>
          <a href="index.php[@encrypt_url($tempUrl)]">绑定功能</a>
          </td>         
       </tr>
       </loop>
    </table>
    <pp:memfunc funcname="listPage($result.pageinfo,'index.php','5')"/>
    <input type='hidden' name='selectConId' id='selectConId' >
  </form>
    
     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
