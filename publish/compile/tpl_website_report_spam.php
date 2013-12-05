<?php import('core.util.RunFunc');


$this->_tpl_vars["name"]=runFunc('readSession',array());


$check = runFunc("checkReport",array($this->_tpl_vars["IN"]["about_id"],$this->_tpl_vars["name"],$this->_tpl_vars["IN"]["type"]));
$json = array();
if($check[0]["count"]>0){

	$json["exist"] = 1;
	echo json_encode($json);
	exit;
}

$dataArray = array(
	"user_id" => $this->_tpl_vars["name"],
	"reason" =>$this->_tpl_vars["IN"]["reason"],
	"about_id" =>$this->_tpl_vars["IN"]["about_id"],
	"type" =>$this->_tpl_vars["IN"]["type"],
	"created" =>date("Y-m-d H:i:s")
);

runFunc("reportSpam",array($dataArray));

$json["exist"] = 0;
echo json_encode($json);