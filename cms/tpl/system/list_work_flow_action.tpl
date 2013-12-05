<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<pp:include file="check_login.tpl" type="tpl"/>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script language="JavaScript" type="" >
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
	document.forms[0].action.value="cms";
	document.forms[0].method.value="addWorkFlowAction";
	document.forms[0].submit();
}
function editdata()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="editWorkFlowAction";
	if (checkdata())
	{
		document.forms[0].submit();
	}

}
function selfFlow()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="selfWorkFlowAction";
	if (checkdata())
	{
		document.forms[0].submit();
	}

}

function deldata()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="delWorkFlowAction";
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
			document.forms[0].flowActionId.value=chks[i].value;
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
</script>
</head>
<body>
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>工作流动作</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">

 <form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="flowActionId">
    <table width="100%" id="editgroup">
      <tr>
        <td  width="70%">
          <input type="button"  value="新 增" name="btnadd" onClick="adddata();">
          <input type="button"  value="修 改" name="btnedit" onClick="editdata();">
          <input type="button" value="删 除" name="btndel" onClick="deldata();">
        </TD>
        <td width="30%"></td>
      </tr>
    </TABLE>
    <pp:var name="result" value="<pp:memfunc funcname="listWorkFlowAction()"/>"/>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
    		<td class="listHeader">选中</td>
          	<td class="listHeader">工作流动作名称</td>
          	<td class="listHeader">工作流动作介绍</td>
       </tr>  
       
       <loop name="result.data"  var="var" key="key">
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="[$var.flowActionId]" onclick="selectConCheck();"></td>
          <td class="tdListItem">[$var.flowActionName]</td>
          <td class="tdListItem">[$var.flowActionRemark]</td>
       </tr>
       </loop>
    </table>
    <pp:memfunc funcname="listPage($result.pageinfo,'index.php','5')"/>
    <input type='hidden' name='selectConId' id='selectConId' >
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>

</body>
</html>
