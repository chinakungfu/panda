<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:include file="check_login.tpl" type="tpl"/>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<title>用户组管理页面</title>
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
	document.forms[0].action.value="group";
	document.forms[0].method.value="beginInsert";
	document.forms[0].submit();
}
function editdata()
{
	document.forms[0].action.value="group";
	document.forms[0].method.value="beginUpdate";
	if (checkdata())
	{
		document.forms[0].submit();
	}

}
function deldata()
{
	document.forms[0].action.value="group";
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
			document.forms[0].groupId.value=chks[i].value;
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
function pagePrint()
{
  var pwin=window.open("","");   
  pwin.write(table.innerHTML);   
  pwin.print();
}
function AutomateExcel(tableID){ 
  var oXL = new ActiveXObject("Excel.Application"); 
    // Get a new workbook. 
  var oWB = oXL.Workbooks.Add(); 
  var osheet = oWB.ActiveSheet; 
  //var table = document.all.data;
  var hang = tableID.rows.length; 
  var lie = tableID.rows(0).cells.length; 
  // Add table headers going cell by cell. 
  for (i=0;i<hang-1;i++) 
 { 
   for (j=0;j<lie-1;j++) 
   { 
     osheet.Cells(i+1,j+1).value = tableID.rows(i).cells(j).innerText; 
    } 
 } 
  oXL.Visible = true; 
  oXL.UserControl = true; 
} 
function toExcel(tablename) //导出到excel 
{
    var mysheet=new ActiveXObject("Excel.Application"); 
    with(mysheet) 
    { 
        DataType = "HTMLData"; 
        HTMLData =tablename.outerHTML; 
        try
        { 
            ActiveSheet.Cells(1,1).value=""; 
            ActiveSheet.Cells(2,1).value=""; 
            // ActiveSheet.Cells(34,1).value="导出完毕"; 
            ActiveSheet.Export("导出.xls", 0); 
            alert('导出完毕'); 
        }; 
        catch (e)
        { 
            alert('导出Excel表失败，请确定已安装Excel2000(或更高版本),并且没打开同名xls文件'); 
        }; 
    } 
} 

function  AutomateExcel(tableid)  
{  
           var  i,j;  
     //  Start  Excel  and  get  Application  object.  
           var  oXL  =  new  ActiveXObject("Excel.Application");  
 
           oXL.Visible  =  true;  
 
     //  Get  a  new  workbook.  
           var  oWB  =  oXL.Workbooks.Add();  
           var  oSheet  =  oWB.ActiveSheet;  
 
     //  Add  table  headers  going  cell  by  cell.  
     //  tblout表的ID  
             for(i=0;i<tableid.rows.length;i++)  
                       for(j=0;j<tableid.rows(i).cells.length;j++)  
                                   oSheet.Cells(i+1,  j+1).Value  =  tableid.rows(i).cells(j).innerText  
       
           oXL.Visible  =  true;  
           oXL.UserControl  =  true;  
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
   	<div class="main_content_nav">后台管理系统 >> 用户组管理</div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">
  <form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="groupId">
    
     <table width="100%" id="editgroup">
      <tr>
        <td width="70%">
        <!--<input type="button" id="select" value="查询" onClick="parent.search();">&nbsp;&nbsp;-->
          <input type="button"  value="新 增" name="btnadd" onClick="adddata();">
          <input type="button"  value="修 改" name="btnedit" onClick="editdata();">
          <input type="button"  value="删 除" name="btndel" onClick="deldata();">
          <input type="hidden" name="sessionaction" value="[$action]">
  		  <input type="hidden" name="sessionmethod" value="[$method]"> 
        </TD>
        <td width="30%"></td>
      </tr>
    </TABLE>
    <pp:var name="result" value="<pp:memfunc funcname="listGroup($sqlCon,'')"/>"/>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">选中</td>
          	<!--<td class="listHeader">组Id</td>-->
          	<td class="listHeader">组标识</td>
      		<td class="listHeader">组名称</td>
      		<td class="listHeader">绑定功能</td>
       </tr> 
       
       <loop name="result.data"  var="var" key="key">
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="[$var.groupId]" onclick="selectConCheck();"></td>
          <!--<td class="tdListItem">[$var.groupId]</td>-->
          <td class="tdListItem">[$var.groupNo]</td>
          <td class="tdListItem">[$var.groupName]</td>
          <td class="tdListItem">
          <pp:var name="tempUrl" value="'action=group&method=bindops&groupId= ' .$var.groupId .'&type=group&sqlCon='.$sqlCon"/>
          <a href="index.php[@encrypt_url($tempUrl)]">绑定角色</a>
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
