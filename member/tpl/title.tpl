<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BigBooks.com.cn</title>

<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/style_cnyp_admin.css" />

</head>

<body>
<!--头部-->
<pp:if expr="$IN.isCompany=='0'">
	<div class="top">
	
	<div class="top_left">
		<div class="user_action"><strong><pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
		<a href="../member/index.php?action=member&method=detailMember" target="mainFrame">[$name]</a></strong> - <u><a href="index.php?action=member&method=destroy">退出</a></u></div>
	    <div style="clear:both"></div>    
		</div>
	
	</div>
<pp:else/>
	<div id="header">
		<div class="logo"> <a href="../yellowpages" target="_blank"><img src="../yellowpages/skin/images/logo_admin.gif" border="0" /></a>
    </div>
        <div class="header_right">
        <pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
        <div class="register">[<a href="../member/index.php?action=member&method=detailMember" target="mainFrame">[$name]</a>|<a href="../member/index.php?action=member&method=destroy">退出</a>]</div>
            <div class="topguide">
                <ul>
                    <li><a href="http://www.96886.com" target="_blank">96886</a></li>
                    <li><a href="http://sh.bigbooks.com.cn" target="_blank">ENGLISH</a></li>
                    <li><a href="../yellowpages/index.php?action=yellowPages&method=cp_fw" target="_blank">产品与服务</a></li>
                    <li><a href="http://www.webmail.yellowpage.com.cn" target="_blank">黄页邮箱</a></li>
                    <li><a href="../shop/" target="_blank">网上书店</a></li>
                </ul>    
        	</div> 
        </div>
        
	</div>
</pp:if>
<!--菜单部分开始-->
<div class="menu">
<div class="menu_line"></div>
	<ul>
	[@topMenu()]
	<pp:if expr="$name!='admin'">
		<pp:var name="Y_code" value="@getYellowPagesCode($name)"/>
			<pp:if expr="$Y_code">
				<CMS action="SQL" return="yellowpageList" query="select ContentID from yp_yellowpages_yellowpages where Y_code='{$Y_code}'"/>
				<pp:if expr="$yellowpageList.0.ContentID">
				<li class="active"><a href="../yellowpages/index.php?action=yellowPages&method=page&id=[$yellowpageList.0.ContentID]" target="_blank">我的企业</a></li>
				</pp:if>
			<pp:else/>
				未绑定企业
			</pp:if>
	</pp:if>
  </ul>
</div>
</body>
</html>
