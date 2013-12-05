<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOCOSO</title>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script language="javascript" type="text/javascript" src="skin/jsfiles/calendar_date.js"></script>

<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajaxControl.js"></script>
<script type="text/javascript" src="skin/jsfiles/prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/utf.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/base64.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phpserializer.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/powmod.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/xxtea.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/bigint.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phprpc_client.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script type="text/javascript">
function checkUserNo(value)
{

	if(value!='')
	{
		var staffNo = document.getElementById('staffNo');
		call_tpl('member','checkData','backData(\'staffNoMessage\')','return','',staffNo.value,'<?php echo $this->_tpl_vars["IN"]["method"];?>','');
	}
	else
	
	{
		var div = document.getElementById('staffNoMessage');
		div.style.display = "none";
		div.innerHTML = "";
	}
}
function checkSubmit()
{
	if(GetObj('staffNo').value == '')
	{
		GetObj('__ErrorMessagePanel_staffNo').innerHTML = "<font color='red'>帐号不能为空！</font>";
		GetObj('staffNo').focus();
		return false
		
	}
	else if(GetObj('staffNo').value.length < 4 || GetObj('staffNo').value.length > 18)
	{
		GetObj('__ErrorMessagePanel_staffNo').innerHTML = "<font color='red'>帐号必须是大于4个且小于18个字节！</font>";
		GetObj('staffNo').focus();
		return false
		
	}
	else
	{		
			GetObj('__ErrorMessagePanel_staffNo').innerHTML = "";
			var div = document.getElementById('staffNoMessage');
			if(div.innerHTML=='会员帐号已存在!')
			{
				var StaffNo = document.getElementById('staffNo');
				GetObj('staffNo').focus();
				return false;
			}
	}
	if(GetObj('staffName').value == '')
	{
		GetObj('__ErrorMessagePanel_staffName').innerHTML = "<font color='red'>姓名不能为空！</font>";
		GetObj('staffName').focus();
		return false
		
	}
	
	if(GetObj('password').value == '')
	{
		GetObj('__ErrorMessagePanel_password').innerHTML = "<font color='red'>密码不能为空！</font>";
		GetObj('password').focus();	
		return false
	}
	else if(GetObj('password').value.length < 6 || GetObj('password').value.length > 32)
	{
		GetObj('__ErrorMessagePanel_password').innerHTML = "<font color='red'>密码必须是大于6个且小于32个字节！</font>"
		GetObj('password').focus();	
		return false
	}
	if(GetObj('password').value == '')
	{
		GetObj('__ErrorMessagePanel_password').innerHTML = "<font color='red'>密码不能为空！</font>";
		GetObj('password').focus();	
		return false
	}
	else if(GetObj('password').value.length < 6 || GetObj('password').value.length > 32)
	{
		GetObj('__ErrorMessagePanel_password').innerHTML = "<font color='red'>密码必须是大于6个且小于32个字节！</font>"
		GetObj('password').focus();	
		return false
	}
	if(GetObj('birthDay').value == '')
	{
		GetObj('__ErrorMessagePanel_birthDay').innerHTML = "<font color='red'>出生日期不能为空！</font>";
		GetObj('birthDay').focus();
		return false
		
	}
	
	
	if(GetObj('email').value == '')
	{
		GetObj('__ErrorMessagePanel_email').innerHTML = "<font color='red'>Email不能为空！</font>"
		GetObj('email').focus();	
		return false
	}
	
	if(GetObj('email').value.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == -1)
	{
		GetObj('__ErrorMessagePanel_email').innerHTML = '<font color="red">邮箱地址不正确！</font>'; 
		GetObj('email').focus();	
		return false;
	}
	else
	{
		GetObj('__ErrorMessagePanel_email').innerHTML ='';
	}
	return true;
	
}

function GetObj(objName){
	if(document.getElementById){
		return eval('document.getElementById("' + objName + '")');
	}else if(document.layers){
		return eval("document.layers['" + objName +"']");
	}else{
		return eval('document.all.' + objName);
	}
}
</script>
</head>

<body >
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >>         
    <?php if ($this->_tpl_vars["method"]=='beginInsert'){?>
        新增用户设置
        <?php }else{ ?>
        修改用户设置
        <?php } ?></div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">


<form method="post" action="index.php" onSubmit="return checkSubmit();">

<input type="hidden" name="action" value="staff">
<?php if ($this->_tpl_vars["method"]=='beginInsert'){?>
<input type="hidden" name="method" value="saveInsert">
<?php }else{ ?>
<?php $this->_tpl_vars["staff"]=runFunc('getStaffInfoById',array($this->_tpl_vars["staffId"])); ?>
<input type="hidden" name="method" value="saveEdit">
<?php } ?>
<?php if ($this->_tpl_vars["method"]=='beginInsert'){?>				
            <input type="hidden" class="edit" name="staffId" value="">
            <?php }else{ ?>
            <input type="hidden" class="edit" name="staffId" value="<?php echo $this->_tpl_vars["staff"]["0"]["staffId"];?>" >
  <?php } ?>

    	<div class="detailMember_nav">基本信息</div>
        			<?php $this->_tpl_vars["memberId"]=$this->_tpl_vars["staff"]["0"]["staffNo"]; ?>

			    	
                    <div class="detailMember_txt">帐号</div>
                    <?php if ($this->_tpl_vars["method"]=='beginInsert'){?>
                        <div class="detailMember_info">
                        <input type="text" id="staffNo" name="para[staffNo]" value="<?php echo $this->_tpl_vars["staff"]["0"]["staffNo"];?>" onblur="checkUserNo(this.value);"><span id="__ErrorMessagePanel_staffNo"> * 帐号不能为空</span>
                        </div>
                    <?php }else{ ?>
                    	<div class="detailMember_info"><input type="text" id="staffNo" name="para[staffNo]" value="<?php echo $this->_tpl_vars["staff"]["0"]["staffNo"];?>"  readonly><span id="__ErrorMessagePanel_staffNo"> * 帐号不能为空</span></div>
                    <?php } ?>
                    <div style="display:none" id="staffNoMessage"></div>
                        <div class="detailMember_txt">姓名</div>
                            <div class="detailMember_info"><input type="text" class="edit" id="staffName" name="para[staffName]" value="<?php echo $this->_tpl_vars["staff"]["0"]["staffName"];?>"><span id="__ErrorMessagePanel_staffName"> * 姓名不能为空</span></div>
                     <div class="detailMember_txt">用户密码</div>
                            <div class="detailMember_info"><input type="password" id="password" class="edit" name="para[password]" value="888888" ><span id="__ErrorMessagePanel_password"> * 用户密码不能为空</span></div>
                            
                            
                     <div class="detailMember_txt">用户性别</div>
                            <div class="detailMember_info">                
                   <select class="edit" name="para[sex]">
					<option value="男">男</option>
					<option value="女">女</option>
				</select></div>  
                    <div class="detailMember_txt">出生日期</div>
                            <div class="detailMember_info"><input type="text" class="edit" id="birthDay" name="para[birthDay]" value="<?php echo $this->_tpl_vars["staff"]["0"]["birthDay"];?>" onfocus="calendar();"  ><span id="__ErrorMessagePanel_birthDay"> * 出生日期不能为空</span></div>      
                     
   <div class="detailMember_nav">联系信息</div>
                     
                <div class="detailMember_txt">QQ号</div>
                        <div class="detailMember_info"><input type="text" class="edit" name="para[qq]" value="<?php echo $this->_tpl_vars["staff"]["0"]["qq"];?>"></div>
                  
             
            <div class="detailMember_txt">邮箱地址</div>
                        <div class="detailMember_info"><input type="text" class="edit" id="email" name="para[email]" value="<?php echo $this->_tpl_vars["staff"]["0"]["email"];?>"><span id="__ErrorMessagePanel_email"> * 邮箱地址不能为空</span></div>
                        
                               
      <div class="detailMember_txt">MSN</div>
                        <div class="detailMember_info"><input type="text" class="edit" name="para[msn]" value="<?php echo $this->_tpl_vars["staff"]["0"]["msn"];?>"></div> 
               <?php if ($this->_tpl_vars["IN"]["isCompanyMember"]=='0'){?>         
               <div class="detailMember_txt">主页</div>
                        <div class="detailMember_info"> <input type="text" class="edit" name="para[homepage]" value="<?php echo $this->_tpl_vars["staff"]["0"]["homepage"];?>"></div> 
               <?php } ?>
               
               <?php if ($this->_tpl_vars["IN"]["isCompanyMember"]=='1'){?>
               	<div class="detailMember_txt">联系电话</div>
                   <div class="detailMember_info"><input type="text" class="edit" id="contactTel" name="para[contactTel]" value="<?php echo $this->_tpl_vars["staff"]["0"]["contactTel"];?>"></div> 
                <div class="detailMember_txt">手机</div>
                   <div class="detailMember_info"><input type="text" class="edit" id="mobile" name="para[mobile]" value="<?php echo $this->_tpl_vars["staff"]["0"]["mobile"];?>"></div> 
               <?php } ?>
            
    
   <div class="detailMember_nav">安全信息</div>
            
    <div class="detailMember_txt">安全问题</div>
        	<div class="detailMember_info"> <input type="text" class="edit" name="para[safetyQuestion]" value="<?php echo $this->_tpl_vars["staff"]["0"]["safetyQuestion"];?>"  /></div>  
                   
    <div class="detailMember_txt">问题答案</div>
   	  <div class="detailMember_info"> <input type="text" class="edit" name="para[questionResult]" value="<?php echo $this->_tpl_vars["staff"]["0"]["questionResult"];?>"></div>   

    
    <div class=""><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
