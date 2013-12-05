<?php import('core.util.RunFunc'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

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
  <input type="hidden" name="isCompanyMember" value="<?php echo $this->_tpl_vars["IN"]["isCompanyMember"];?>">
  <input type="hidden" name="para[isCompanyMember]" id="isCompanyMember" value="<?php echo $this->_tpl_vars["IN"]["isCompanyMember"];?>">
      <table width="100%" id="editgroup">
      <tr>
        <td width="70%">
        
          
          <?php if ($this->_tpl_vars["mode"]!=''){?>
          <input type="button" value="选取用户账户" onclick="selectUserNo()">
          <?php }else{ ?>
          <input type="button"  value="新 增" name="btnadd" onClick="adddata();">
          <input type="button"  value="修 改" name="btnedit" onClick="editdata();">
          <input type="button"  value="删 除" name="btndel" onClick="deldata();">
          <?php } ?>
          <input type="hidden" name="sessionaction" value="<?php echo $this->_tpl_vars["action"];?>">
  		  <input type="hidden" name="sessionmethod" value="<?php echo $this->_tpl_vars["method"];?>"> 
          			
        </TD>
        <td width="30%"></td>
      </tr>
    </TABLE>
    <?php $this->_tpl_vars["result"]=runFunc('listStaff',array($this->_tpl_vars["sqlCon"])); ?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">选中</td>
            
      		<td class="listHeader">帐号</td>
      		<td class="listHeader">昵称</td>
      		<td class="listHeader">用户性别</td>
      		<td class="listHeader">注册时间</td>
      		<td class="listHeader">所属角色</td>
      		<td class="listHeader">绑定操作</td>
       </tr>  
       
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <?php $this->_tpl_vars["roleName"]=''; ?>
       <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "SQL",
	'return' => "staffRoles",
	'query' => "select * from {$this->_tpl_vars["app"]["table_pre"]}member_group_roles where groupId='{$this->_tpl_vars["var"]["staffNo"]}'",
 ); 

$this->_tpl_vars['staffRoles'] = CMS::CMS_SQL($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
       <?php if(!empty($this->_tpl_vars["staffRoles"]["data"])){ 
 foreach ($this->_tpl_vars["staffRoles"]["data"] as $this->_tpl_vars['k']=>$this->_tpl_vars['v']){ ?>
       <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "SQL",
	'return' => "role",
	'query' => "select * from {$this->_tpl_vars["app"]["table_pre"]}member_role where roleNo='{$this->_tpl_vars["v"]["roleId"]}'",
 ); 

$this->_tpl_vars['role'] = CMS::CMS_SQL($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
       <?php $this->_tpl_vars["roleName"]=$this->_tpl_vars["roleName"] . ' ' . $this->_tpl_vars["role"]["data"]["0"]["roleName"]; ?>
       <?php  }
} ?>
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="<?php echo $this->_tpl_vars["var"]["staffId"];?>" onclick="selectConCheck();"></td>
          
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["staffNo"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["staffName"];?></td>
          <td class="tdListItem"> <?php echo $this->_tpl_vars["var"]["sex"];?> </td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["registerDate"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["roleName"];?></td>
          <td class="tdListItem">
           
          <?php $this->_tpl_vars["tempUrl"]='action=group&method=bindops&staffId= ' .$this->_tpl_vars["var"]["staffId"] .'&type=staff&sqlCon='.$this->_tpl_vars["sqlCon"]; ?>
          <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>">绑定角色</a>
          
         </td>         
       </tr>
       <?php  }
} ?>
    </table>
    <?php if ($this->_tpl_vars["mode"]!=''){?>
       		<?php echo runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],"index.php","5","mode=1&isCompanyMember={$this->_tpl_vars["isCompanyMember"]}&sqlCon={$this->_tpl_vars["sqlCon"]}"));?>
       	<?php }else{ ?>
       		<?php echo runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],"index.php","5","mode=&isCompanyMember={$this->_tpl_vars["isCompanyMember"]}&sqlCon={$this->_tpl_vars["sqlCon"]}"));?>
       	<?php } ?>
    <input type='hidden' name='selectConId' id='selectConId' >
  </form>
    
     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>