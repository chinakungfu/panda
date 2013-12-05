<?php
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
function listSMS()
{
	try {
		$sql = "select * from {$GLOBALS['table']['publish']['sender']} order by TaskID desc";
		if($GLOBALS['IN']['currentPage']!=''){
			$params['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$params['currentPage'] = 1;
		}
		$params['pageSize'] = 10;
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function addSMS($arraySMS)
{
	try {	
		if(!empty($arraySMS))
		{
			foreach ($arraySMS as $key => $val)
			{
				$str_field .= $key.",";
				$str_value .= ":".$key.",";
			}
			$str_field = substr($str_field,0,-1);
			$str_value = substr($str_value,0,-1);
		}
		$sql = "insert into {$GLOBALS['table']['publish']['sender']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$arraySMS);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function editSMS($SMSId,$arraySMS)
{
	try {
		if(!empty($arraySMS))
		{
			foreach ($arrayContact as $key => $var)
			{
				$sql .= "$key =:$key,";
			}
			$sql = substr($sql,0,-1);
			$sql = "update {$GLOBALS['table']['publish']['sender']} set $sql where TaskID=".$SMSId;
			return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$arraySMS);
		}
		
	}catch (Exception $e)
	{
		throw $e;
	}
}
function delSMS($SMSId)
{
	try {
		$infoIdArray = explode(',',$SMSId);
		for($i=0;$i<count($infoIdArray)-1;$i++)
		{		
			$sql = "delete from {$GLOBALS['table']['publish']['sender']} where TaskID=".$infoIdArray[$i];
			$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getSMSInfoById($SMSId)
{
	try {
		$sql = "select * from {$GLOBALS['table']['publish']['sender']} where TaskID=".$SMSId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function senderSms($mobileCode,$smsContent)
{
	try {
		date_default_timezone_set('PRC');
		$mobileCodeArray = explode(';',$mobileCode);
		if(!empty($mobileCodeArray))
		{
			foreach ($mobileCodeArray as $key => $val)
			{
				if(is_numeric($val))
				{
					if(strlen($val)==11)
					{
						$arraySMS['DestNumber'] = $val;
						$arraySMS['Content'] = $smsContent;
						$arraySMS['SendTime'] = date("Y-m-d H:i:s");
						$arraySMS['SendPriority'] = 16;
						$arraySMS['StatusReport'] = 0;			
						$arraySMS['EnglishFlag'] = 0;
						$arraySMS['MsgType'] = 0;
						$arraySMS['RecAction'] = 0;
						$arraySMS['ValidMinute'] = 0;
						$arraySMS['SendFlag'] = 0;
						$arraySMS['CommPort'] = 0;
						$arraySMS['SplitCount'] = 1;
						$arraySMS['PushUrl'] = "";				
						addSMS($arraySMS);
					}
				}
			}
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>