<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOCOSO</title>
<pp:include file="check_login.tpl" type="tpl"/>
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
		call_tpl('member','checkData','backData(\'staffNoMessage\')','return','',staffNo.value,'[$IN.method]','');
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
    <pp:if expr="$method=='beginInsert'">
        新增用户设置
        <pp:else/>
        修改用户设置
        </pp:if></div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">


<form method="post" action="index.php" onSubmit="return checkSubmit();">

<input type="hidden" name="action" value="staff">
<pp:if expr="$method=='beginInsert'">
<input type="hidden" name="method" value="saveInsert">
<pp:else/>
<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoById($staffId)"/>"/>
<input type="hidden" name="method" value="saveEdit">
</pp:if>
<pp:if expr="$method=='beginInsert'">				
            <input type="hidden" class="edit" name="staffId" value="">
            <pp:else/>
            <input type="hidden" class="edit" name="staffId" value="[$staff.0.staffId]" >
  </pp:if>

    	<div class="detailMember_nav">基本信息</div>
        			<pp:var name="memberId" value="$staff.0.staffNo"/>
<!--    				<pp:if expr="$IN.Y_code==''">
						<pp:var name="Y_code" value="{@getYellowPagesCode($memberId)}"/>
					<pp:else/>
						<pp:var name="Y_code" value="$IN.Y_code"/>
					</pp:if>-->
			    	<!--<pp:memfunc funcname="writeCompanyNameToSession($Y_code,$memberId)"/>-->
                    <div class="detailMember_txt">帐号</div>
                    <pp:if expr="$method=='beginInsert'">
                        <div class="detailMember_info">
                        <input type="text" id="staffNo" name="para[staffNo]" value="[$staff.0.staffNo]" onblur="checkUserNo(this.value);"><span id="__ErrorMessagePanel_staffNo"> * 帐号不能为空</span>
                        </div>
                    <pp:else/>
                    	<div class="detailMember_info"><input type="text" id="staffNo" name="para[staffNo]" value="[$staff.0.staffNo]"  readonly><span id="__ErrorMessagePanel_staffNo"> * 帐号不能为空</span></div>
                    </pp:if>
                    <div style="display:none" id="staffNoMessage"></div>
                        <div class="detailMember_txt">姓名</div>
                            <div class="detailMember_info"><input type="text" class="edit" id="staffName" name="para[staffName]" value="[$staff.0.staffName]"><span id="__ErrorMessagePanel_staffName"> * 姓名不能为空</span></div>
                     <div class="detailMember_txt">用户密码</div>
                            <div class="detailMember_info"><input type="password" id="password" class="edit" name="para[password]" value="888888" ><span id="__ErrorMessagePanel_password"> * 用户密码不能为空</span></div>
                            
                            
                     <div class="detailMember_txt">用户性别</div>
                            <div class="detailMember_info">                
                   <select class="edit" name="para[sex]">
					<option value="男">男</option>
					<option value="女">女</option>
				</select></div>  
                    <div class="detailMember_txt">出生日期</div>
                            <div class="detailMember_info"><input type="text" class="edit" id="birthDay" name="para[birthDay]" value="[$staff.0.birthDay]" onfocus="calendar();"  ><span id="__ErrorMessagePanel_birthDay"> * 出生日期不能为空</span></div>      
                     
   <div class="detailMember_nav">联系信息</div>
                     
                <div class="detailMember_txt">QQ号</div>
                        <div class="detailMember_info"><input type="text" class="edit" name="para[qq]" value="[$staff.0.qq]"></div>
                  
             
            <div class="detailMember_txt">邮箱地址</div>
                        <div class="detailMember_info"><input type="text" class="edit" id="email" name="para[email]" value="[$staff.0.email]"><span id="__ErrorMessagePanel_email"> * 邮箱地址不能为空</span></div>
                        
                               
      <div class="detailMember_txt">MSN</div>
                        <div class="detailMember_info"><input type="text" class="edit" name="para[msn]" value="[$staff.0.msn]"></div> 
               <pp:if expr="$IN.isCompanyMember=='0'">         
               <div class="detailMember_txt">主页</div>
                        <div class="detailMember_info"> <input type="text" class="edit" name="para[homepage]" value="[$staff.0.homepage]"></div> 
               </pp:if>
               
               <pp:if expr="$IN.isCompanyMember=='1'">
               	<div class="detailMember_txt">联系电话</div>
                   <div class="detailMember_info"><input type="text" class="edit" id="contactTel" name="para[contactTel]" value="[$staff.0.contactTel]"></div> 
                <div class="detailMember_txt">手机</div>
                   <div class="detailMember_info"><input type="text" class="edit" id="mobile" name="para[mobile]" value="[$staff.0.mobile]"></div> 
               </pp:if>
            
    
   <div class="detailMember_nav">安全信息</div>
            
    <div class="detailMember_txt">安全问题</div>
        	<div class="detailMember_info"> <input type="text" class="edit" name="para[safetyQuestion]" value="[$staff.0.safetyQuestion]"  /></div>  
                   
    <div class="detailMember_txt">问题答案</div>
   	  <div class="detailMember_info"> <input type="text" class="edit" name="para[questionResult]" value="[$staff.0.questionResult]"></div>   

    
    <div class=""><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
