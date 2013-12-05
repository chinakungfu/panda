<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">
<script language="javascript" type="text/javascript">
if(window.confirm('请先登录系统！'))
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
<title>CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
</head>
<body>
<div class="main_content">
	<div class="main_content_nav">后台管理系统 >> 我的资料</div>
	<div style="clear:both"></div>
	<div class="search_content detailMember">
		<form method="post" action="index.php">
		<input type="hidden" name="action" value="member">
		<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoByNo($name)"/>"/>
		<input type="hidden" name="method" value="editUser">
		<input type="hidden" class="edit" name="staffId" value="[$staff.0.staffId]" >
		<div class="detailMember_nav">基本信息</div>
			<div class="detailMember_txt">帐号</div>
				<pp:if expr="$staff.0.staffNo!=''">
			    	<div class="detailMember_info">[$staff.0.staffNo]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.staffNo]</div><br>
			    </pp:if>
			<div class="detailMember_txt">昵称</div>
				<pp:if expr="$staff.0.staffName!=''">
			    	<div class="detailMember_info">[$staff.0.staffName]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.staffName]</div><br>
			    </pp:if>   
			 <div class="detailMember_txt">用户性别</div>
			 	<pp:if expr="$staff.0.sex!=''">
			    	<div class="detailMember_info">[$staff.0.sex]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.sex]</div><br>
			    </pp:if> 
			<div class="detailMember_txt">出生日期</div>
				<pp:if expr="$staff.0.birthDay!=''">
			    	<div class="detailMember_info">[$staff.0.birthDay]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.birthDay]</div><br>
			    </pp:if>
		<div class="detailMember_nav">联系信息</div>
			<div class="detailMember_txt">QQ号</div>
				<pp:if expr="$staff.0.qq!=''">
			    	<div class="detailMember_info">[$staff.0.qq]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.qq]</div><br>
			    </pp:if>
			<div class="detailMember_txt">邮箱地址</div>
				<pp:if expr="$staff.0.email!=''">
			    	<div class="detailMember_info">[$staff.0.email]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.email]</div><br>
			    </pp:if>     
			 <div class="detailMember_txt">MSN</div>
			 	<pp:if expr="$staff.0.msn!=''">
			    	<div class="detailMember_info">[$staff.0.msn]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.msn]</div><br>
			    </pp:if>
			<div class="detailMember_txt">主页</div>
				<pp:if expr="$staff.0.homepage!=''">
			    	<div class="detailMember_info">[$staff.0.homepage]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.homepage]</div><br>
			    </pp:if>          
		<div class="detailMember_nav">安全信息</div>        
		    <div class="detailMember_txt">安全问题</div>
		    	<pp:if expr="$staff.0.safetyQuestion!=''">
			    	<div class="detailMember_info">[$staff.0.safetyQuestion]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.safetyQuestion]</div><br>
			    </pp:if>         
		    <div class="detailMember_txt">问题答案</div>
		    	<pp:if expr="$staff.0.questionResult!=''">
			    	<div class="detailMember_info">[$staff.0.questionResult]</div>
			    <pp:else/>
			    	<div class="detailMember_info">[$staff.0.questionResult]</div><br>
			    </pp:if>
				<input type="submit" value="编辑我的资料" />    
	</div>
	    </form> 
	    <br>
	  <div style="clear:both"></div>
	  <div class="copyright"></div>
    </div>
</body>
</html>
