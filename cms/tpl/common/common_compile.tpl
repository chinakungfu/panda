<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<pp:include file="check_login.tpl" type="tpl"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用应用编译</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
</head>

<cms action="sql" return="ret" query="select * from {$contentModel} where {$appTableKeyName}='{$appTableKeyValue}'"/>
<pp:if expr="!empty($ret)">
	<pp:if expr="$ret.data.0.appUrl!=''">
		<script>location.href="[$ret.data.0.appUrl]/tplCompile.php";</script>
	<pp:else/>
		不能编译该应用，请检查应用的路径是否设置正确1。
	</pp:if>
<pp:else/>
不能编译该应用，请检查应用的路径是否设置正确2。
</pp:if>
</html>

