<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name">
<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>  
	</head>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			<div class="content">
			    
			       <pp:include file="common/account_body.tpl" type="tpl"/>
			  
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>
<pp:else/>
	<!--
	<pp:var name="paraStrtmp" value="@arr2str($IN.para)"/>	
	<pp:var name="strPara" value="str2arr($paraStr)"/>
	<pp:var name="paraStr" value="str_replace('=','%6D',$paraStrtmp)"/>
	<pp:var name="paraStr" value="str_replace('&','%5D',$paraStr)"/>
	<pp:var name="paraStr" value="str_replace(':','%3F',$paraStr)"/>
	<pp:var name="paraStr" value="str_replace('/','%2F',$paraStr)"/>
	-->
	<pp:var name="paraArr.backAction" value="$IN.action"/>
	<pp:var name="paraArr.backMethod" value="$IN.method"/>
	<pp:var name="paraStr" value="serialize($paraArr)"/>
	

	<script>location.href='index.php[@encrypt_url('action=website&method=login&backaction=shop&backmethod=addWish&paraStr=' . $paraStr )]'</script>
</pp:if>