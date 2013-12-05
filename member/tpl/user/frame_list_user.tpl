<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:include file="check_login.tpl" type="tpl"/>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<title>操作管理页面</title>
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
	document.forms[0].action.value="staff";
	document.forms[0].method.value="beginInsert";
	document.forms[0].submit();
}
function editdata()
{
	document.forms[0].action.value="staff";
	document.forms[0].method.value="beginUpdate";
	if (checkdata())
	{
		document.forms[0].submit();
	}

}
function deldata()
{
	document.forms[0].action.value="staff";
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
			document.forms[0].staffId.value=chks[i].value;
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
function selectUserNo()//黄页编号
{
	document.forms[0].action.value="staff";
	document.forms[0].method.value="selectUserNo";
	if (checkdata())
	{
		document.forms[0].submit();
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
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >> 用户管理</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
  <form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="staffId">
  <input type="hidden" name="isCompanyMember" value="[$IN.isCompanyMember]">
  <input type="hidden" name="para[isCompanyMember]" id="isCompanyMember" value="[$IN.isCompanyMember]">
      <table width="100%" id="editgroup">
      <tr>
        <td width="70%">
        <!--<input type="button" id="select" value="查询" onClick="parent.search();">&nbsp;&nbsp;-->
          
          <pp:if expr="$mode!=''">
          <input type="button" value="选取用户账户" onclick="selectUserNo()">
          <pp:else/>
          <input type="button"  value="新 增" name="btnadd" onClick="adddata();">
          <input type="button"  value="修 改" name="btnedit" onClick="editdata();">
          <input type="button"  value="删 除" name="btndel" onClick="deldata();">
          </pp:if>
          <input type="hidden" name="sessionaction" value="[$action]">
  		  <input type="hidden" name="sessionmethod" value="[$method]"> 
          <!--<input type="button" value="显示全部" onClick="clearCon();">	-->			
        </TD>
        <td width="30%"></td>
      </tr>
    </TABLE>
    <pp:var name="result" value="<pp:memfunc funcname="listStaff($sqlCon)"/>"/>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">选中</td>
            <!-- <td class="listHeader">用户Id</td> -->
      		<td class="listHeader">帐号</td>
      		<td class="listHeader">昵称</td>
      		<td class="listHeader">用户性别</td>
      		<td class="listHeader">注册时间</td>
      		<td class="listHeader">所属角色</td>
      		<td class="listHeader">绑定操作</td>
       </tr>  
       
       <loop name="result.data"  var="var" key="key">
       <pp:var name="roleName" value="''"/>
       <CMS action="SQL" return="staffRoles" query="select * from {$app.table_pre}member_group_roles where groupId='{$var.staffNo}'"/>
       <loop name="staffRoles.data"  var="v" key="k">
       <CMS action="SQL" return="role" query="select * from {$app.table_pre}member_role where roleNo='{$v.roleId}'"/>
       <pp:var name="roleName" value="$roleName . ' ' . $role.data.0.roleName"/>
       </loop>
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="[$var.staffId]" onclick="selectConCheck();"></td>
          <!-- <td class="tdListItem">[$var.staffId]</td> -->
          <td class="tdListItem">[$var.staffNo]</td>
          <td class="tdListItem">[$var.staffName]</td>
          <td class="tdListItem"> [$var.sex] </td>
          <td class="tdListItem">[$var.registerDate]</td>
          <td class="tdListItem">[$roleName]</td>
          <td class="tdListItem">
           <!--<pp:var name="tempUrl" value="'action=staff&method=bindops&staffId= ' .$var.staffId .'&type=group&sqlCon='.$sqlCon"/>
          <a href="index.php[@encrypt_url($tempUrl)]">绑定用户组</a>
          &nbsp;&nbsp;&nbsp;-->
          <pp:var name="tempUrl" value="'action=group&method=bindops&staffId= ' .$var.staffId .'&type=staff&sqlCon='.$sqlCon"/>
          <a href="index.php[@encrypt_url($tempUrl)]">绑定角色</a>
          <!--<pp:var name="tempUrl" value="'action=staff&method=bindops&staffId= ' .$var.staffId .'&type=staff&sqlCon='.$sqlCon"/>
          <a href="index.php[@encrypt_url($tempUrl)]">绑定用户组</a>-->
         <!-- <a href="index.php?action=staff&method=bindGroup&staffId=[$var.staffId]&type=groupf&sqlCon=[$sqlCon]" >绑定用户组</a>
          &nbsp;&nbsp;&nbsp;
          <a href="index.php?action=group&method=bindRole&staffId=[$var.staffId]&type=staff&sqlCon=[$sqlCon]">绑定角色</a>--></td>         
       </tr>
       </loop>
    </table>
    <pp:if expr="$mode!=''">
       		[@listPage($result.pageinfo,"index.php","5","mode=1&isCompanyMember={$isCompanyMember}&sqlCon={$sqlCon}")]
       	<pp:else/>
       		[@listPage($result.pageinfo,"index.php","5","mode=&isCompanyMember={$isCompanyMember}&sqlCon={$sqlCon}")]
       	</pp:if>
    <input type='hidden' name='selectConId' id='selectConId' >
  </form>
    
     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>