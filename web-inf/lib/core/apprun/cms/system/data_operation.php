<?
/**
 * add zxqer 200909011
 * 该文件主要用来设置通用ＣＭＳ的字段管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.resourceManage.upload');
import('core.xml.XMLDoc');
import('core.xml.XMLTag');
/**
 *用于显示模板变量的基本信息 
 **/       
function getDatabaseTables()
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "show table status from ".$GLOBALS['currentApp']['dbconfig'][$GLOBALS['currentApp']['defaultDataSourceId']]['dbName'];
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		if(!empty($result))
		{
			foreach ($result as $key => $val)
			{
				$total = ($val['Data_length']+$val['Index_length'])/1024;
				$pos = strpos($total,'.');
				if($pos)
				{
					$total = substr($total,0,$pos+2);
				}else 
				{
					$total = $total.".0";
				}
				$result[$key]['total'] = $total." KB";
			}
		}
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
function backupData($selectConId,$operationType,$MaxFileSize,$addDrop)
{
	try {
		$tableArray = explode(',',$selectConId);
		$tableArrayCount = count($tableArray)-1;
		if($operationType=='1')
		{
			$n = 0;
			$randBt = random(4);
			$filename = "cms_back_".date("Y_m_d")."_".$randBt;
			$indexContent = "<backUp>"."\n";
			for ($i=0;$i<$tableArrayCount;$i++)
			{
				$strSql .= make_header($tableArray[$i]);
				$sqlFields = "select * from ".$tableArray[$i];
				$resultFields = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlFields,"");
				if(!empty($resultFields))
				{
					foreach ($resultFields as $key => $val)
					{
						$strSql.=make_record($tableArray[$i],$val);
						if(strlen($strSql)>=$MaxFileSize*1024*1024)
						{
							$filename.="_".$n.".sql";
							$indexContent .="<file>".$filename."</file>"."\n";
							write_file($strSql,$filename);
							$n++;
							$strSql = '';
							$filename = "cms_back_".date("Y_m_d")."_".$randBt;
						}
					}
				}
			}
			$indexContent .= "<backUp>";
			write_file($indexContent,$filename.".xml");
			return readXmlFile($GLOBALS['currentApp']['apppath']."/backup/",$filename.".xml");
		}else 
		{
			for ($i=0;$i<$tableArrayCount;$i++)
			{
				$sql = "OPTIMIZE TABLE ".$tableArray[$i];
				TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
			}
			return true;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getDBackupDataStr($table)
{
	try {
		$strSqlHeader=make_header($table);
		$sqlFields = "select * from ".$table;
		$resultFields = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlFields,"");
		if(!empty($resultFields))
		{
			foreach ($resultFields as $key => $val)
			{
				$strSqlRecord.=make_record($table,$val);
			}
		}
		return $strSqlHeader.$strSqlRecord;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getAllBackupDataStr()
{
	try {
		$sqlTables = "show table status from ".$GLOBALS['currentApp']['dbconfig'][$GLOBALS['currentApp']['defaultDataSourceId']]['dbName'];
		$resultTables = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlTables,"");
		$strSql = "";
		if(!empty($resultTables))
		{
			foreach ($resultTables as $keyA => $valA)
			{
				$strSqlHeader.=make_header($valA['Name']);
				$sqlFields = "select * from ".$valA['Name'];
				$resultFields = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlFields,"");
				if(!empty($resultFields))
				{
					foreach ($resultFields as $key => $val)
					{
						$strSqlRecord.=make_record($valA['Name'],$val);
					}
				}
			}
		}
		return $strSqlHeader.$strSqlRecord;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function restoreData($arrayData)
{
	try {
//		if($arrayData['backupModel']=='0')//从本地恢复数据
//		{
//			switch ($_FILES['myfile']['error'])
//			{
//				case 1:
//				case 2:
//					return "您上传的文件大于服务器限定值，上传未成功";
//					break;
//				case 3:
//					return "未能从本地完整上传备份文件";
//					break;
//				case 4:
//					return "从本地上传备份文件失败";
//					break;
//				case 0:
//					break;
//			}
//			$fname=date("Ymd",time())."_".random2(4).".sql";
//			$localFile = $_FILES['myfile']['name'];
//			if (is_uploaded_file($_FILES['myfile']['tmp_name'])) 
//			{
//				copy($_FILES['myfile']['tmp_name'], "./backup/".$fname);
//			}
//			if (file_exists("./backup/".$fname))
//			{
//				if(importBackData("./backup/".$fname)) 
//				{
//					unlink("./backup/".$fname);
//					return "本地备份文件".$localFile."成功导入数据库";
//				}
//				else 
//					return "本地备份文件".$localFile."导入数据库失败";
//			}
//		}elseif ($arrayData['backupModel']=='1')//从服务器恢复数据
//		{
//			$filename="./backup/".$arrayData['serverfile'];
//			if(importBackData($filename))
//				return  "备份文件".$arrayData['serverfile']."成功导入数据库";
//			else 
//				return  "备份文件".$arrayData['serverfile']."导入失败";
//		}
		if($arrayData['serverfile']!='')
		{
			$filename=$GLOBALS['currentApp']['apppath']."/backup/".$arrayData['serverfile'];
			$parser=new XMLDoc();
			$parser->LoadFromFile($filename);
			$parser->parse();
			$tree=$parser->GetDocumentElement();
			unset($parser);
			if ($tree->TagName=='backUp')
			{
				$dsList=$tree->GetElementsByTagName('backUp');
				$total = count($dsList);
				for ($i=0;$i<$total;$i++)
				{
					$childList=$dsList[$i]->GetChild();
					$listCount=count($childList);
					for ($j=0;$j<$listCount;$j++)
					{
						if($childList[$j]->data!='')
						{
							$str = $GLOBALS['currentApp']['apppath']."/backup/".$childList[$j]->data;
							importBackData($str);
						}
					}
				}
			}
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function make_header($table)
{
	try {
		$tmp="DROP TABLE IF EXISTS ".$table."\n";
		$tempSql = "show create table ".$table;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$tempSql,"");
		if(!empty($result))
		{
			foreach ($result as $key => $val)
			{
				$tmp.=preg_replace("/\n/","",$val['Create Table']);
				$tmp.="\n";
			}
		}
		return $tmp;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//

function make_record($table,$num_fields)
{
	try {
		$comma="";
		$comma .= "INSERT INTO ".$table." VALUES(";
		foreach ($num_fields as $key => $val)
		{
			$comma .= "'".mysql_escape_string($val)."',";
		}
		$comma = substr($comma,0,-1);
		$comma .= ")\n";
		return $comma;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
function readXmlFile($apppath,$fileName)
{
	try {
		$parser=new XMLDoc();
		$parser->LoadFromFile($apppath.$fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName=='backUp')
		{
			$dsList=$tree->GetElementsByTagName('backUp');
			$total = count($dsList);
			for ($i=0;$i<$total;$i++)
			{
				$childList=$dsList[$i]->GetChild();
				$listCount=count($childList);
				for ($j=0;$j<$listCount;$j++)
				{
					if($childList[$j]->data!='')
					{
						$str .= $apppath.$childList[$j]->data."\n";
					}
				}
			}
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function down_file($sql,$filename)
{
	try {
		ob_end_clean();
		header("Content-Encoding: none");
		header("Content-Type: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));

		header("Content-Disposition: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ')."filename=".$filename);

		header("Content-Length: ".strlen($sql));
		header("Pragma: no-cache");

		header("Expires: 0");
		echo $sql;
		$e=ob_get_contents();
		ob_end_clean();
	}catch (Exception $e)
	{
		throw $e;
	}
}
function write_file($sql,$filename)
{
	try {
		$re=true;
		if(!@$fp=fopen("./backup/".$filename,"w+"))
		{
			$re=false; echo "failed to open target file";
		}
		if(!@fwrite($fp,$sql))
		{
			$re=false; echo "failed to write file";
		}
		if(!@fclose($fp))
		{
			$re=false; echo "failed to close target file";
		}
		return realpath("./backup/".$filename);
		//return $re;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function writeable($dir)
{
	try {
		if(!is_dir($dir)) {
			@mkdir($dir, 0777);
		}
		if(is_dir($dir))
		{
			if($fp = @fopen("$dir/test.test", 'w'))
			{
				@fclose($fp);
				@unlink("$dir/test.test");
				$writeable = 1;
			}
			else {
				$writeable = 0;
			}
		}
		return $writeable;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/*
获取所有备份数据库文件
*/
function getBackupDataFile()
{
	try {
		$handle=opendir('./backup');
		while ($file = readdir($handle))
		{
			if(eregi("^([0-9a-z_]+)(\.xml)$",$file))
			{
				$str.= "<option value='$file'>$file</option>";
			}
		}
		closedir($handle);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function importBackData($fname)
{
	$sqls=file($fname);
	foreach($sqls as $sql)
	{
		str_replace("\r","",$sql);
		str_replace("\n","",$sql);
		$sql = trim($sql);
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		if(!empty($result))
			return false;
	}
	return true;
}
?>