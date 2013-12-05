<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">
<script language="javascript" type="text/javascript">
if(window.confirm('请先登录！'))
{
	<pp:var name="tempUrl" value="'action=member&method=login&url='.$IN.frameRight"/>
	top.location.href="../member/index.php[@encrypt_url($tempUrl)]";
	
}else
{
	<?php echo 'location.href="'.$_SERVER['HTTP_REFERER'].'"'; ?>
}
</script>
</pp:if>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOCOSO</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
</head>

<body>
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >> 修改密码</div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">

<form method="post" action="index.php" onSubmit="return Validator.Validate(this,3)">
<input type="hidden" name="action" value="member">
<input type="hidden" name="method" value="savePassword">
<pp:if expr="$identify==''">
<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoByNo($name)"/>"/>
<input type="hidden" class="edit" name="staffId" value="[$name]" >
<input type="hidden" class="edit" name="identify" value="[$identify]" >
<pp:else/>
<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoByNo($staffNo)"/>"/>
<input type="hidden" class="edit" name="staffId" value="[$staffNo]" >
<input type="hidden" class="edit" name="identify" value="[$identify]" >
</pp:if>

        
                    <div class="detailMember_txt">用户账户：</div>
                        <div class="detailMember_info">[$staff.0.staffNo]</div>
                
                <pp:if expr="$identify==''">
                        <div class="detailMember_txt">旧密码：</div>
                            <div class="detailMember_info"><input type="password" class="edit" name="oldpassword" value="" dataType="Require" msg="旧密码不能为空"></div>
       			 </pp:if>
   
                <div class="detailMember_txt">新密码：</div>
                        <div class="detailMember_info"><input type="password" class="edit" name="newpassword" value="" dataType="Require" msg="新密码不能为空"></div>
                 
                  <div class="detailMember_txt">重复一次新密码：</div>
                        <div class="detailMember_info"><input type="password" class="edit" name="aginpassword" value="" dataType="Repeat" to="newpassword" msg="两次密码输入不一样"></div>

    
    <div><input type="submit" value="保存" />
    <pp:if expr="$identify==''">
    <input type="button" value="取消" class="button" onClick="location.href='index.php[@encrypt_url('action=member&method=detailMember')]';">
    </pp:if>
    </div>
    </form>    
    
     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
