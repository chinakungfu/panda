<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
<style type="text/css">
body {
	margin: 0px;
	font-size:12px;
	font-family:Tahoma;
}

#register_top{
	background:url(images/register/user_reg_top.gif) repeat-x;
	height:105px;
	margin:0px;
	margin-bottom:30px;
	width:auto;
}

.register_content{
	width:960px;
	margin:0 auto;
	padding-left:50px;
}


#register_logo{
	margin-top:10px;
}

#register_logo_intro{
	margin:10px 0;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9px;
	font-weight:bold;
	color:#666;

}

#register_logo_cn{
	color:#10559e;
	font-size:14px;
	font-weight:bold;
}

#register_top_left{
	float:left;
	width:540px;
}

#register_top_right{
	float:left;
	width:350px;
	text-align:right;
	margin-top:15px;
	color:#10559e;
}
#register_top_right a{
	color:#10559e;
	text-decoration:none;
}
yellowpages/index.php?action=yellowPages&method=about&contentid=9&childC=1305&title=Help
/**/
#register_main{
	background:#f00;
	margin:0px auto;
}
#register_main_left{
	float:left;
	width:570px;
}
#register_main_top{
	background:url(images/register/user_reg_border_top.gif) no-repeat;
	width:550px;
	height:32px;
	font-weight:bold;
	font-size:14px;
	color:#ff9900;
	padding:10px 0 0 10px;
}
#register_main_content{
	width:540px;
	border:1px solid #e5e5e5;
	border-top:none;
	height:470px;
	padding:10px;
}

.register_main_txt{
	color:#1256a1;
	font-size:11px;
	font-weight:bold;
	width:180px;
	height:50px;
	float:left;
	margin-top:3px;
}

.register_main_input{
	float:left;
	width:350px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9px;
}
.register_main_input input{
	border:1px solid #ccc;
	width:280px;
}

.register_main_intro{
	float:left;
	font-size:10.5px;
	width:350px;
	line-height:20px;
	color:#666;
}

.register_main_creat{
	float:left;
	width:350px;
	text-align:right;
	margin:15px 0;
}

#register_line{
	margin:10px 0;
}

#register_main_right{
	float:left;
	margin-left:10px;
}
#register_learn_left{
	background:url(images/register/user_reg_learn_left.gif) no-repeat;
	height:145px;
	width:20px;
	float:left;
	margin-top:40px;
}
#register_learn_main{
	background:url(images/register/user_reg_learn_bg.gif) repeat-x;
	height:145px;
	width:300px;
	float:left;
	margin-top:40px;
}
#register_learn_right{
	background: url(images/register/user_reg_learn_right.gif) no-repeat;
	height:145px;
	width:10px;
	float:left;
	margin-top:40px;
}
#register_learn_U_NAME{
	color:#10559e;
	font-size:14px;
	font-weight:bold;
	margin-top:20px;
}
#register_learn_content{
	font-size:11px;
	margin:10px 0;
	line-height:22px;
}
#register_copyright{
	float:left;
	margin:10px 0;
}
.style1 {color: #FF0000}

</style></head>
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="jsfiles/json.js"></script>
<script type="text/javascript" src="jsfiles/ajax.js"></script>
<script type="text/javascript" src="jsfiles/ajaxControl.js"></script>
<script type="text/javascript" src="jsfiles/prototype.js"></script>
<script type="text/javascript" src="jsfiles/phprpc/utf.js"></script>
<script type="text/javascript" src="jsfiles/phprpc/base64.js"></script>
<script type="text/javascript" src="jsfiles/phprpc/phpserializer.js"></script>
<script type="text/javascript" src="jsfiles/phprpc/powmod.js"></script>
<script type="text/javascript" src="jsfiles/phprpc/xxtea.js"></script>
<script type="text/javascript" src="jsfiles/phprpc/bigint.js"></script>
<script type="text/javascript" src="jsfiles/phprpc/phprpc_client.js"></script>
<script type="text/javascript">
function checkUserNo(value)
{

	if(value!='')
	{
		call_tpl('member','checkData','backData(\'StaffNoMessage\')','return',document.forms[0].staffId.value,document.forms[0].StaffNo.value,'[$IN.method]','');
	}
	else
	
	{
		var div = document.getElementById('StaffNoMessage');
		div.style.display = "none";
		div.innerHTML = "";
	}
}

var company_state = 1;

function searchCompany()
{
	var company = document.getElementById('keyword');
	company_state = 1;
	company.readOnly = false;
}
function addCompany()
{
	var company = document.getElementById('keyword');
	var Y_code = document.getElementById('Y_code');
	
	company_state = 2;
	company.readOnly = true;
	company.value = '';
	Y_code.value = '';	
	
}

function checkSubmit()
{
		
	

	if(company_state == 1)
	{
	
			if(GetObj('keyword').value.length < 2)
			{
			
				GetObj('__ErrorMessagePanel_keyword').innerHTML = "<font color='red'>Minimum of 2 characters in length</font>";
				GetObj('keyword').focus();
				return false
			}
			else
			{
				GetObj('__ErrorMessagePanel_keyword').innerHTML = "Company name. ";
			}
	}

	
	if(company_state == 2)
	{
		GetObj('__ErrorMessagePanel_keyword').innerHTML = "Company name. ";
	}
	
	
	if(GetObj('StaffNo').value == '')
	{
		GetObj('__ErrorMessagePanel_StaffNo').innerHTML = "<font color='red'>User Can't empty!</font>";
		GetObj('StaffNo').focus();
		return false
		
	}
	else if(GetObj('StaffNo').value.length < 3 || GetObj('StaffNo').value.length > 16)
	{
		GetObj('__ErrorMessagePanel_StaffNo').innerHTML = "<font color='red'>The length of username must between 3 to 16 characters!</font>";
		GetObj('StaffNo').focus();
		return false
		
	}
	else
	{		
			GetObj('__ErrorMessagePanel_StaffNo').innerHTML = "";
			var div = document.getElementById('StaffNoMessage');
			if(div.innerHTML=='User ID has been in existence')
			{
				//alert("User ID has been in existence");
				var StaffNo = document.getElementById('StaffNo');
				StaffNo.focus();
				return false;
			}
	}
	
	
	if(GetObj('password').value == '')
	{
		GetObj('__ErrorMessagePanel_password').innerHTML = "<font color='red'>Password Can't empty!</font>";
		GetObj('password').focus();	
		return false
	}
	else if(GetObj('password').value.length < 5 || GetObj('password').value.length > 32)
	{
		GetObj('__ErrorMessagePanel_password').innerHTML = "<font color='red'>The length of username must between 5 to 16 characters!</font>"
		GetObj('password').focus();	
		return false
	}
	
	
	if(GetObj('password').value != GetObj('passwords').value)
	{
		GetObj('__ErrorMessagePanel_password').innerHTML = "<font color='red'>Confirm Password Wrong!</font>"
		GetObj('passwords').focus();	
		return false
	}
	else
	{
		GetObj('__ErrorMessagePanel_password').innerHTML = ""
	}
	
	
	if(GetObj('email').value == '')
	{
		GetObj('__ErrorMessagePanel_email').innerHTML = "<font color='red'>Email address Can't empty!</font>"
		GetObj('email').focus();	
		return false
	}
	
	if(GetObj('email').value.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == -1)
	{
		GetObj('__ErrorMessagePanel_email').innerHTML = '<font color="red">Wrong format</font>'; 
		GetObj('email').focus();	
		return false;
	}
	else
	{
		GetObj('__ErrorMessagePanel_email').innerHTML ='';
	}
	
	
	if(GetObj('safetyQuestion').value.length < 4)
	{
		GetObj('__ErrorMessagePanel_safetyQuestion').innerHTML = "<font color='red'>Minimum of 4 characters in length</font>"
		GetObj('safetyQuestion').focus();	
		return false
	}
	else
	{
		GetObj('__ErrorMessagePanel_safetyQuestion').innerHTML='';
	}
	
	if(GetObj('questionResult').value.length < 4)
	{
		GetObj('__ErrorMessagePanel_questionResult').innerHTML = "<font color='red'>Minimum of 4 characters in length</font>"
		GetObj('questionResult').focus();	
		return false
	}
	else
	{
		GetObj('__ErrorMessagePanel_questionResult').innerHTML='';
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


//定义变量lastindex 表示为鼠标在查询结果上滑动所在位置，初始为-1
var lastindex=-1;
//定义变量flag 表示是否根据用户输入的关键字进行ajax查询,flase为允许查询 true为禁止查询
var flag=false;
//返回的查询结果生成的数组长度
var listlength=0;
//创建自定字符串，优化效率
function StringBuffer(){this.data=[];}
//赋值
StringBuffer.prototype.append=function(){this.data.push(arguments[0]);return this;}

//输出
StringBuffer.prototype.tostring=function(){return this.data.join("");}
//去掉字符串两边空格
String.prototype.Trim = function(){return this.replace(/(^\s*)|(\s*$)/g, "");}
//隐藏函数 主要是隐藏显示的提示下拉层和iframe，关于iframe下面在说其作用
function hiddensearch()
{
	$('rlist').style.display="none";
	$('rFrame').style.display="none";
}
//显示函数 主要是显示的提示下拉层和iframe 参数num,根据该参数控制要显示提示层和iframe的高度
function showsearch(num)
{
	$('rlist').style.display='';
	$('rFrame').style.display='';
	//这里我定义每个返回查询结果的提示高度为20px,其中提示层总高度又加了num,是因为我在定义样式时使用了padding一个像素
	$('rlist').style.height=num*20+num+'px';
	//同样定位iframe的高度
	$('rFrame').style.height=num*20+num+'px';
}
//返回文本输入框的坐标函数，参数element为要返回的对象,参数offset可选为offsetLeft|offsetTop 分别表示为该对象距离左窗口上角的绝对位置
//利用这个函数可以定位我们要显示的提示层位置，使提示层正确的显示在文本输入框下面
function getposition(element,offset)
{
	var c=0;
	while(element)
	{
		c+=element[offset];
		element=element.offsetParent
	}
	return c;
}
//创建提示层函数 包括提示层和为了避免在文本输入框下面出现select下拉选框时我们的提示层不能再select之上的iframe
//可以理解为当文本输入框下有select下拉选框时从底向上依次为 select下拉选框-iframe-提示层
function createlist()
{
	//创建提示层
	var listDiv=document.createElement("div");
	//提示层id
	listDiv.id="rlist";
	listDiv.style.zIndex="2";
	listDiv.style.position="absolute";
	listDiv.style.border="solid 1px #000000";
	listDiv.style.backgroundColor="#FFFFFF";
	listDiv.style.display="none";
	listDiv.style.width=$('keyword').clientWidth+"px";
	listDiv.style.left=getposition($('keyword'),'offsetLeft')+1.5+"px";
	listDiv.style.top =(getposition($('keyword'),'offsetTop')+$('keyword').clientHeight +3)+"px";

	var listFrame=document.createElement("iframe");
	listFrame.id="rFrame";
	listFrame.style.zIndex="1";
	listFrame.style.position="absolute";
	listFrame.style.border="0";
	listFrame.style.display="none";
	listFrame.style.width=$('keyword').clientWidth+"px";
	listFrame.style.left=getposition($('keyword'),'offsetLeft')+1+"px";
	listFrame.style.top =(getposition($('keyword'),'offsetTop')+$('keyword').clientHeight +3)+"px";
	document.body.appendChild(listDiv);
	document.body.appendChild(listFrame);
}
function setstyle(element,classname)
{
	switch (classname)
	{
		case 'm':
		element.style.fontSize="12px";
		element.style.fontFamily="arial,sans-serif";
		element.style.backgroundColor="#3366cc";
		element.style.color="black";
		element.style.width=$('keyword').clientWidth-2+"px";
		element.style.height="20px";
		element.style.padding="1px 0px 0px 2px";
		if(element.displaySpan)element.displaySpan.style.color="white"
		break;
		case 'd':
		element.style.fontSize="12px";
		element.style.fontFamily="arial,sans-serif";
		element.style.backgroundColor="white";
		element.style.color="black";
		element.style.width=$('keyword').clientWidth-2+"px";
		element.style.height="20px";
		element.style.padding="1px 0px 0px 2px";
		if(element.displaySpan)element.displaySpan.style.color="green"
		break;
		case 't':
		element.style.width="80%";
		if(window.navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)element.style.cssFloat="left";
		else element.style.styleFloat="left";
		element.style.whiteSpace="nowrap";
		element.style.overflow="hidden";
		element.style.textOverflow="ellipsis";
		element.style.fontSize="12px";
		element.style.textAlign="left";
		break;
		case 'h':
		element.style.width="20%";
		if(window.navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)element.style.cssFloat="right";
		else element.style.styleFloat="right";
		element.style.textAlign="right";
		element.style.color="green";
		break;
	}
}
function focusitem(index)
{
	if($('item'+lastindex)!=null)setstyle($('item'+lastindex),'d');
	if($('item'+index)!=null)
	{
		setstyle($('item'+index), 'm');
		lastindex=index;
	}
	else $("keyword").focus();
}
function searchclick(index)
{
	$("keyword").value=$('U_NAME'+index).innerHTML;
	$("Y_code").value=$('Y_code'+index).innerHTML;
	flag=true;
}
function searchkeydown(e)
{
	if($('rlist').innerHTML=='')return;
	var keycode=(window.navigator.appName=="Microsoft Internet Explorer")?event.keyCode:e.which;
	//down
	if(keycode==40)
	{
		if(lastindex==-1||lastindex==listlength-1)
		{
			focusitem(0);
			searchclick(0);
		}
		else{
			focusitem(lastindex+1);
			searchclick(lastindex+1);
		}
	}
	if(keycode==38)
	{
		if(lastindex==-1)
		{
			focusitem(0);
			searchclick(0);
		}
		else{
			focusitem(lastindex-1);
			searchclick(lastindex-1);
		}
	}
	if(keycode==13)
	{
		focusitem(lastindex);
		$("keyword").value=$('U_NAME'+lastindex).innerText;
	}
	if(keycode==46||keycode==8){flag=false;ajaxsearch($F('keyword').substring(0,$F('keyword').length-1).Trim());}
}
function showresult(xmlhttp)
{
	var result=unescape(xmlhttp.responseText);
	if(result!=''){
		var resultstring=new StringBuffer();
		var U_NAME=result.split('$')[0];
		var Y_code=result.split('$')[1];
		var company = U_NAME.split('|');
		var node = Y_code.split('|');
		for(var i=0;i<company.length;i++)
		{
			resultstring.append('<div id="item'+i+'" onmousemove="focusitem('+i+')" onmousedown="searchclick('+i+')">');
			resultstring.append('<span id=U_NAME'+i+'>');
			resultstring.append(company[i]);
			resultstring.append('</span>');
			resultstring.append('<span id=Y_code'+i+'>');
			resultstring.append(node[i]);
			resultstring.append('</span>');
			resultstring.append('</div>');
		}
		$('rlist').innerHTML=resultstring.tostring();
		for(var j=0;j<U_NAME.split('|').length;j++)
		{
			setstyle($('item'+j),'d');
			$('item'+j).displaySpan=$('Y_code'+j);
			setstyle($('U_NAME'+j),'t');
			setstyle($('Y_code'+j),'h');
		}
		showsearch(U_NAME.split('|').length);
		listlength=U_NAME.split('|').length;
		lastindex=-1;
	}
	else hiddensearch();
}
function ajaxsearch(value)
{
	new Ajax.Request('core/apprun/searchInfo/search.php',{method:"get",parameters:"action=do&keyword="+escape(value),onComplete:showresult});
}
function main()
{
	$('keyword').className=$('keyword').className=='inputblue'?'inputfocus':'inputblue';
	if($F('keyword').Trim()=='')hiddensearch();
	else
	{
		if($F('keyword')!=''&&flag==false)ajaxsearch($F('keyword').Trim());
		if(listlength!=0)$('keyword').onkeydown=searchkeydown;
		else hiddensearch();
	}
}
function oninit()
{
	$('keyword').autocomplete="off";
	$('keyword').onfocus=main;
	$('keyword').onkeyup=main;
	$('keyword').onblur=hiddensearch;
	createlist();
}
Event.observe(window,'load',oninit);
</script>
<body>


<div id="register_top">

  <div class="register_content">
  
  	<div id="register_top_left">
   	  <div id="register_logo">
   	  
   	  
   	  <a href="../yellowpages"><img src="images/register/user_reg_logo.gif" border="0" /></a></div>
        	<div id="register_logo_intro">China Telecom Yellow Pages Local Search</div>
            	<div id="register_logo_cn"></div>
    
    </div>
    	<div id="register_top_right">
    	<pp:var name="newsList" value="<pp:memfunc funcname="getInfomationByType('','1301','')"/>"/> 
      <LOOP name="newsList.data" var="var" key="key">
      <a href="[$var.FromSite]&contentid=[$var.ContentID]"><font color="#0e4079">[$var.Title]</font></a>  | 
      </LOOP> 
      </div>

  </div>

	
</div>
    
<div class="register_content">

    <div id="register_main">
    
    	<div id="register_main_left">
    <form method="post" action="index.php" onSubmit="return checkSubmit();">
    <input type="hidden" name="action" value="member">
    <input type="hidden" name="method" value="saveRegister">
    <input type="hidden" class="edit" name="staffId" value="">
         	<div id="register_main_top">Required information for Locoso account</div>
            	<div id="register_main_content">          
                	
                    
                <div class="register_main_txt">企业名称：</div>
                	<div class="register_main_input">
                	<input name="keyword" type="text" class="inputblue" id="keyword" maxlength="20" style="width:300px;" />
                	<input name="yp[Y_code]" type="hidden" class="inputblue" id="Y_code" maxlength="20" style="width:300px;" />
                	</div>
                	
                    <div class="register_main_intro" id="__ErrorMessagePanel_keyword">企业名称. </div>  
                      
                	<div class="register_main_intro">
                	<input type="radio" name="radio" checked onclick="searchCompany();">搜索企业
                	<input type="radio" name="radio" onclick="addCompany();">新添企业

                	</div>   
                 
                 <div style="clear:both;"></div>
                    
                    
                   <div class="register_main_txt">用户帐户:</div>
                	<div class="register_main_input"><input type="text" id="StaffNo" class="edit" name="para[staffNo]" value="" onblur="checkUserNo(this.value);"><span class="style1">*</span><br />
<span id="__ErrorMessagePanel_StaffNo"></span>
</div>
                	<div class="register_main_intro" style="display:none" id="StaffNoMessage"></div>
                		<div class="register_main_intro">This will be used to sign-in to your account.</div>
                        
                 	    <div style="clear:both;"></div>
                    
            
                   <div class="register_main_txt">密   码:</div>
                	<div class="register_main_input"><input type="password" class="edit" id="password" name="para[password]" /><br />
<span id="__ErrorMessagePanel_password"></span>
</div>
                		<div class="register_main_intro">密码不能少于5个字符. </div>       
                 
                 	<div style="clear:both;"></div>
                   <div class="register_main_txt">重复一次密码:</div>
                	<div class="register_main_input"><input type="password" class="edit" name="passwords" /><br />
<span id="__ErrorMessagePanel_passwords"></span>
</div>
                		<div class="register_main_intro">Creating a Locoso Account will enable Web History. Web History is a feature that will provide you with a more personalized experience on Google that includes more relevant search results and recommendations. Learn More </div>
                 
                 <div style="clear:both;"></div>
                 
                         
                
               	  <div class="register_main_txt">电子邮箱:</div>
                	<div class="register_main_input"><input type="text" class="edit" name="para[email]" id="email"><br /><span id="__ErrorMessagePanel_email"></span></div>
                    
                		<div class="register_main_intro">e.g. myname@example.com.</div>
                        
               	  <div style="clear:both;"></div>
                  
                  
                 <div id="register_line"><img src="images/register/user_reg_line.gif" /></div>
                 
                    <div class="register_main_txt">安全问题:</div>
                	<div class="register_main_input"><input type="text" class="edit" name="para[safetyQuestion]" id="safetyQuestion"><br /><span id="__ErrorMessagePanel_safetyQuestion"></span></div>
                		<div class="register_main_intro"></div>
                        
                        <div style="clear:both;"></div>
                        
                   <div class="register_main_txt">答案: 
                   <div style="font-weight:normal;color:#ff9900; font-size:11px;">
(When you lost your password,you'll use the answer to get it.)</div>
</div>
                	<div class="register_main_input"><input type="text" name="para[questionResult]" id="questionResult" /><br /><span id="__ErrorMessagePanel_questionResult"></span></div>
                    <div class="register_main_creat" style=""><input type="image" src="images/register/user_reg_do.gif" /></div>       
                 

                </div>
               <div style="clear:both;"></div>
            <div id="register_copyright">Copyright  &copy; 2008<strong> China Telecom Yellow Pages</strong> All Rights Reserved </div>
            </form>
	  </div>
        
        <div id="register_main_right">
         <div id="register_learn_left"></div>
         	
             <div id="register_learn_main">
             	<div id="register_learn_U_NAME">Why do I need a Locoso ID?</div>
                <div id="register_learn_content">Your Locoso ID becomes the sign in name and password for your Locoso account</div>
             <div id="register_learn_do">
             <a href="../yellowpages/index.php?action=yellowPages&method=about&contentid=9&childC=1305&title=Help"> 
             <img src="images/register/user_reg_learn.gif" border="0" /></a></div>
             </div>
           
           <div id="register_learn_right"></div>
	       </div>
        
    </div>
 </div>   
<div id="test"></div>
</body>
</html>
