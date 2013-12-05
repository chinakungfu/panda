<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员管理</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script language="javascript" type="text/javascript" src="skin/jsfiles/DateTimeCalendar.js">
</script>
</head>

<body>
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >> 我的资料</div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">

<form method="post" action="index.php" onSubmit="var chks=document.getElementsByName('law');if(chks[0].checked)
	{
		return true;
	}else
	{
		alert('必须同意“中国电信黄页网站法律声明”');
		return false;
	}
	return Validator.Validate(this,3)">
<input type="hidden" name="action" value="member">
<input type="hidden" name="StaffNo" value="">
<pp:if expr="$type=='1'">
<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoByNo($name)"/>"/>
<input type="hidden" name="type" value="1"/>
<pp:else/>
<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoByNo($name)"/>"/>
</pp:if>

<input type="hidden" name="method" value="saveEdit">
<input type="hidden" class="edit" name="staffId" value="[$staff.0.staffId]" >

    	<div class="detailMember_nav">基本信息</div>
                    <div class="detailMember_txt">帐号</div>
                        <div class="detailMember_info"><input type="text" id="staffNom" name="para[staffNo]" value="[$staff.0.staffNo]" readonly/></div>
                
                        <div class="detailMember_txt">昵称</div>
                            <div class="detailMember_info"><input type="text" class="edit" name="para[staffName]" value="[$staff.0.staffName]"></div>
                            
                         
                     <div class="detailMember_txt">用户性别</div>
                            <div class="detailMember_info">                
                   <select class="edit" name="para[sex]">
					<option value="男">男</option>
					<option value="女">女</option>
				</select></div>  
                    
                    <div class="detailMember_txt">出生日期</div>
                            <div class="detailMember_info"><input type="text" class="edit" name="para[birthDay]" value="[$staff.0.birthDay]" onfocus="calendar();" format="y-m-d" msg="生日日期错误，正确的为 年-月-日"></div> 
                     
                     
   <div class="detailMember_nav">联系信息</div>
                     
                <div class="detailMember_txt">QQ号</div>
                        <div class="detailMember_info"><input type="text" class="edit" name="para[qq]" value="[$staff.0.qq]"></div>
                  
             
            <div class="detailMember_txt">邮箱地址</div>
                        <div class="detailMember_info"><input type="text" class="edit" name="para[email]" value="[$staff.0.email]" dataType="Email" msg="信箱格式不正确"></div>
                        
                               
      <div class="detailMember_txt">MSN</div>
                        <div class="detailMember_info"><input type="text" class="edit" name="para[msn]" value="[$staff.0.msn]"></div> 
                        
               <div class="detailMember_txt">主页</div>
                        <div class="detailMember_info"> <input type="text" class="edit" name="para[homepage]" value="[$staff.0.homepage]"></div> 
            

                  
   <div class="detailMember_nav">安全信息</div>
            
    <div class="detailMember_txt">安全问题</div>
        	<div class="detailMember_info"> <input type="text" class="edit" name="para[safetyQuestion]" value="[$staff.0.safetyQuestion]" dataType="Require" msg="安全问题不能为空！"></div>  
                   
    <div class="detailMember_txt">问题答案</div>
   	  <div class="detailMember_info"> <input type="text" class="edit" name="para[questionResult]" value="[$staff.0.questionResult]" dataType="Require" msg="问题答案不能为空！"></div>   

   <!-- <pp:if expr="$isLow=='1'">
    <div class="detailMember_txt"><input type="checkbox" name="law" id="law" checked></div>
   	  <div class="detailMember_info">我同意<<<a href="http://beta.locoso.com/yellowpages/index.php?action=yellowPages&method=law&contentid=141" target="_blank">中国电信黄页网站法律声明</a>>>  *</div>
   	</pp:if>-->
    <div class=""><input type="submit" value="保存" />
    <input type="button" value="取消" class="button" onClick="location.href='index.php[@encrypt_url('action=member&method=detailMember')]';"></div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
