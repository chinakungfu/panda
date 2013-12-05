<?php

	function saveCategory($cid, $result) {
	require_once('web-inf/lib/coreconfig/public_dbconfig.php');
	$db_config = $GLOBALS['currentApp']['dbconfig'];
		$db = new mysqli("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"], "a0222211743");
		$stmt = $db->prepare("insert into taobao_categories (cid,items,date) values (?,?,?)");
		$stmt->bind_param("iss", $cid, $result->asXML(), date("m-d"));
		$stmt->execute();
	}
	function getCategory($cid) {
	require_once('web-inf/lib/coreconfig/public_dbconfig.php');
	$db_config = $GLOBALS['currentApp']['dbconfig'];
		$db = new mysqli("localhost", $db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"], "a0222211743");
		$result = $db->query("select * from taobao_categories where cid = ".$cid);
		$result = $result->fetch_object();

		if(isset($result->items)) {
			if(date("m-d") == $result->date) {
				return	(new SimpleXMLElement($result->items));
			}
		}
		return null;
	}
?>
