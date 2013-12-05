<pp:var name="addDataResult" value="@readCookie()"/>
<pp:var name="DataResult" value="@getSessionID()"/>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  
 </head>

 <body>
 
<form name="form" id="home-login" class="right" action="[@getGlobalModelVar('Site_Domain')]publish/index.php" method="post">
<input type="hidden" name="action" value="website">
<input type="hidden" name="method" value="GetGoods">
Goods URL: <input type="text" name="GoodsURL" />

<input type="submit" value="Submit"/>
</form>

	
Cookie:[$addDataResult]
<br>
	
SessionID:[$DataResult]
 </body>
</html>
