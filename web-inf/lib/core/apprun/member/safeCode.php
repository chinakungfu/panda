<? 
function isCode($code)
{
	session_start();
	$code = strtolower($code);
	$_SESSION["code"] = strtolower($_SESSION["code"]);
	if($code==$_SESSION["code"])
	{
		return true;
	}else
	{
		return false;
	}
}
?>
