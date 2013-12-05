<?php

require_once('web-inf/lib/coreconfig/public_dbconfig.php');

$db_config = $GLOBALS['currentApp']['dbconfig'];

$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("a0222211743", $con);

if(isset($_GET["email"])){
$email = $_GET["email"];
}else{
$email = $_GET["manger_email"];
}


$sql = "select count(*) as count from cms_member_staff where email = '{$email}' or staffNo = '{$email}'";

$result = mysql_query($sql);

$row = mysql_fetch_array($result);

$check = $row[0]["count"];

mysql_close($con);

if($check["count"]>0){

	echo "false";
}else{
	echo "true";
}

