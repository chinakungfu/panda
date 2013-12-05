<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>WOW TAOBAO</title>
	<link rel="stylesheet" href="[@getGlobalModelVar('Site_Domain')]skin/css/style.css"/>
	
</head>

<body>
  <pp:var name="result" value="<pp:memfunc funcname="GetGoodsInfo($IN.GoodsURL)"/>"/>

<pp:if expr="$result=='-1'">
[$result]
<pp:elseif expr="!is_array($result)">
[$result]
<pp:else/>

<pp:var name="nodeId" value="@getGlobalModelVar('goodsNodle')"/>
<pp:var name="node" value="@getNodeInfoById($nodeId)"/>

<form name="form" id="home-login" class="right" action="[@getGlobalModelVar('Site_Domain')]publish/index.php" method="post">
<input type="hidden" name="action" value="wow">
<input type="hidden" name="method" value="addCart">
<input type="hidden" name="nodeId" value="[$node.0.nodeId]">
<input type="hidden" name="para[nodeId]" value="[$node.0.nodeGuid]">
<input type="hidden" name="contentModel" value="[$node.0.appTableName]">
<input type="hidden" name="para[goodsImgURL]" value="[$result.img]">
<input type="hidden" name="para[goodsStatus]" value="Open">
<input type="hidden" name="para[goodsType]" value="outside">
<input type="hidden" name="para[goodsURL]" value="[$IN.GoodsURL]">

<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
	<pp:if expr="$name">
		<input type="hidden" name="para[goodsAddUser]" value="[$name]">	
		<input type="hidden" name="isLogin" value="1">	
	<pp:else/>	
		<input type="hidden" name="isLogin" value="0">
		<input type="hidden" name="para[goodsAddUser]" value="[@getSessionID()]">
	</pp:if>
<table>
<tr>
	<td>Goods Name:</td>
	<td><input name="para[goodsTitleCN]" type="text" class="home-login-input" id="username" Value="[$result.title]"/></td>
</tr>
<tr>
	<td>Engilsih Description:</td>
	<td><input name="para[goodsTitleEn]" type="text" class="home-login-input" id="username" Value="[$result.title]"/></td>
</tr>
<tr>
	<td>Price:</td>
	<td><input name="para[goodsUnitPrice]" type="text" class="home-login-input" id="username" Value="[$result.price]"/></td>
</tr>
<tr>
	<td>Freight:</td>
	<td><input name="para[goodsFreight]" type="text" class="home-login-input" id="username" Value="[$result.postage]"/></td>
</tr>
<tr>
	<td>QTY:</td>
	<td><input name="ItemQTY" type="text" class="home-login-input" id="username" /></td>
</tr>
<tr>
	<td>Note:</td>
	<td><textarea name="para[goodsNotes]" rows="4" class="home-login-input" id="username"></textarea></td>
</tr>
<tr>
	<td>Img:</td>
	<td><img id="logo" src="[$result.img]" width="200" height="200"/></td>
</tr>
</table>

<br>
<br>
<br>

<br>
<input type="submit" value="Add Cart"/>
<input type="button" value="Back" class="button" onClick="window.history.back();">
</form>
</pp:if>
 </body>
</html>