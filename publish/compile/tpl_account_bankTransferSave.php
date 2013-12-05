<?php import('core.util.RunFunc');
	$loginUser = runFunc('readSession',array());
if ($loginUser==""){
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
		);
		include($inc_tpl_file);
		exit;
 } 

	$dataArray["userID"] = $loginUser;
	$dataArray["submitTime"] = time();
	$dataArray["moneyType"] = $this->_tpl_vars["IN"]["moneyType"];
	$dataArray["rechargeMoney"] = $this->_tpl_vars["IN"]["amount"];
	$dataArray["country"] = $this->_tpl_vars["IN"]["country"];
	$dataArray["senderName"] = $this->_tpl_vars["IN"]["senderName"];
	$dataArray["status"] = 5;

	$y=date("Y",$this->_tpl_vars["IN"]["payTime"]); 
	$m=date("m",$this->_tpl_vars["IN"]["payTime"]); 
	$d=date("d",$this->_tpl_vars["IN"]["payTime"]); 
	$dataArray["payTime"] = mktime($m, $d ,$y);
	//$dataArray["payTime2"] = date("y-m-d",$dataArray["payTime"])."</br>"; 

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);

	$sql = "insert into cms_publish_bank_transfer (".$str_field.") values (".$str_value.")";
	$bank_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	$success_content = 'Submit is successful, we will cost for you as soon as possible!';
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Submitted successfully&alert_content='.$success_content.'&link_action=account&link_method=bankTransfer')));

	?>
