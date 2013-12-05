<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<style type="text/css">
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	color: #666666;
	text-decoration: none;
}
a:hover {
	color: #666666;
	text-decoration: underline;
}
a:active {
	color: #666666;
	text-decoration: none;
}
</style>
<pp:if expr="$method=='saveBackup'">
	<pp:var name="result" value="@backupData($selectConId,$operationType,$MaxFileSize,$addDrop)"/>
	<pp:if expr="$result">
		<pp:if expr="$operationType=='1'">
			<div class="main_content">
			   	<div class="main_content_nav">您已成功备份数据表</div>
				<div class="search_content detailMember"> 
				<div class="detailMember_txt">
				[$result]
				</div>
			   	<div class="detailMember_txt"><a href="index.php[@encrypt_url('action=cms&method=backup')]">返回</a></div>
			   	</div>
		   	</div>
		<pp:else/>
			<div class="main_content">
			   	<div class="main_content_nav">您已成功优化数据</div>
				<div class="search_content detailMember"> 
			   	<div class="detailMember_txt"><a href="index.php[@encrypt_url('action=cms&method=backup')]">返回</a></div>
			   	</div>
		   	</div>
		</pp:if>
	
	</pp:if>
<pp:elseif expr="$method=='saveRestore'">
	<pp:var name="result" value="@restoreData($IN.para)"/>
	<pp:if expr="$result">
	<div class="main_content">
	   	<div class="main_content_nav">您已成功恢复数据</div>
		<div class="search_content detailMember"> 
	   	<div class="detailMember_txt"><a href="index.php[@encrypt_url('action=cms&method=restore')]">返回</a></div>
	   	</div>
   	</div>
	</pp:if>
</pp:if>