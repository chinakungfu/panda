<pp:include file="check_login.tpl" type="tpl"/>
<pp:var name="node" value="@getNodeInfoById($nodeId)"/>
<pp:if expr="$method=='addData'">
	<pp:var name="conPlanInfo" value="@getContentPlanInfoById($node.0.contentPlanId)"/>
	<pp:if expr="$conPlanInfo.0.addPre!=''">
		<pp:include file="{$conPlanInfo.0.addPre}" type="tpl"/>
	</pp:if>
</pp:if>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script language="javascript" type="text/javascript" src="skin/jsfiles/calendar_date_time.js"> </script>
<script type="text/javascript" src="../fckeditor/fckeditor.js"></script>

<pp:if expr="$method=='addData'">
<cms action="sql" return="fieldconfig" query="select * from cms_cms_fieldconfig where fieldConfigId='{$node.0.fieldConfigId}'" num="1"/>
<script type="text/javascript">
function ajax(url,callbackFunction)
{
	this.bindFunction = function (caller,object) {
		return function() {
			return caller.apply(object,[object]);
		};
	};
	this.stateChange = function (object) {
		if (this.request.readyState==4)
			this.callbackFunction.call(this,this.request.responseText);
	};
	this.getRequest = function() {
		if (window.ActiveXObject) return new ActiveXObject('Microsoft.XMLHTTP');
		else if (window.XMLHttpRequest) return new XMLHttpRequest();
		return false;
	};
	this.postBody = (arguments[2] || "");
	this.callbackFunction=callbackFunction;
	this.url=(url.match(/\?/))?url+'&s_tmp_ajax='+(new Date()).getTime():url+'?s_tmp_ajax='+(new Date()).getTime();
	this.request = this.getRequest();
	if(this.request) {
		var req = this.request;
		req.onreadystatechange = this.bindFunction(this.stateChange,this);
		if (this.postBody!=="") {
			req.open("POST",this.url,true);
			req.setRequestHeader('X-Requested-With','XMLHttpRequest');
			req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			req.setRequestHeader('Connection','close');
		} else {
			req.open("GET",this.url,true);
		}
		req.send(this.postBody);
	}
}
function doSubmit(checkStr){
	checkStr||document.getElementById('form1').submit();
	
	var reg=/^(action=\w+&method=\w+&table=\w+)&field=([\w\|]*)$/i;
	var match=reg.exec(checkStr);
	
	var data="index.php?"+match[1];
	var fields=match[2].split('|');
	for(var i=0;i<fields.length;i++){
		data += "&" + fields[i] + "=" + document.getElementById(fields[i]).value;
	}
	
	ajax("index.php",
		function(ret){
			eval("var json="+ret);
			if(json.state<0){
				alert(json.message);
			}else{
				document.getElementById('form1').submit();
			}
		},
		data
	);
}
</script>
</pp:if>
</head>

<body>
<div class="main_content">
	<div class="search_content detailMember">
		<form method="post" action="index.php" id="form1">
			<input type="hidden" name="action" value="cms">
			<input type="hidden" name="frameListAction" value="[$frameListAction]">
			<input type="hidden" name="frameListMethod" value="[$frameListMethod]">
			<input type="hidden" name="nodeId" value="[$nodeId]">
			<input type="hidden" name="para[nodeId]" value="[$node.0.nodeGuid]">
			<pp:var name="actParams" value="unserialize(base64_decode($actParams))"/>
			<loop name="actParams"  var="var" key="key">
			<!--<input type="hidden" name="para[[$key]]" value="[$var]" >-->	
			<input type="hidden" name="actParam[[$key]]" value="[$var]" >	
			</loop>
			<pp:if expr="$method=='addData'">
				<input type="hidden" name="method" value="saveAddData">
				<input type="hidden" name="contentModel" value="[$node.0.appTableName]">
			<pp:else/>
				<input type="hidden" name="method" value="saveEditData">
				<input type="hidden" name="appTableKeyName" value="[$node.0.appTableKeyName]">
				<input type="hidden" name="appTableKeyValue" value="[$appTableKeyValue]">
				<input type="hidden" name="contentModel" value="[$node.0.appTableName]">
			</pp:if>     
				[@editStr($node.0.fieldConfigId,$node.0.appTableName,$node.0.appTableKeyName,$appTableKeyValue,$node.0.nodeGuid)]
			    <div class="detailMember_doedit">
<!--				    <pp:if expr="$method=='addData'">
				    	<input type="button" onclick="doSubmit('[$fieldconfig.data.0.checkValue]')" value="保存" />
				    <pp:else/>
				    	<input type="submit" value="保存"/>
				    </pp:if>-->
					<input type="submit" value="保存"/>
				    <input type="button" value="取消" class="button" onClick="window.history.back();">
			    </div>
		</form>
	</div>
	<OBJECT id="dlgHelper" CLASSID="clsid:3050f819-98b5-11cf-bb82-00aa00bdce0b" width="100px" height="100px"></OBJECT>
	<pp:if expr="$method=='addData'">
		<pp:if expr="$conPlanInfo.0.addNext!=''">
			<pp:include file="{$conPlanInfo.0.addNext}" type="tpl"/>
		</pp:if>
	</pp:if>
</div>
</body>
</html>
