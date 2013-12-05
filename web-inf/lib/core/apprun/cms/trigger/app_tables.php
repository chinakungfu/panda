<?
/**
 * add zxqer 20110708
 * 该文件主要用来管理cms应用的数据表管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.datasource.TplCompile');
/**
 * 创建数据表
 * */
function createAppTable($tableInfo)
{
	try {
		//$tableInfo = getSysTableInfo($tableId);
		$appInfo = getAppInfoById($tableInfo['appId']);
//		$isExistTable = checkExistAppTables($tableInfo['appId'],$tableInfo['tableName']);
//		if(!$isExistTable)
//		{
			$sql = "CREATE TABLE ".$GLOBALS['currentApp']['table_pre'].$appInfo[0]['appName']."_".$tableInfo['tableName']."(";
			$sql .= "nodeId varchar(50)";
			$sql .=") ".getTableEngine($tableInfo['tableEngine'])." ".getTableCharset($tableInfo['tableCharset']);
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
			$inserStr = '$table[\''.$appInfo[0]['appName'].'\'][\''.$tableInfo['tableName'].'\']=$dbName_table_pre.'.'\''.$appInfo[0]['appName'].'_'.$tableInfo['tableName'].'\';';
			$tpl=new TplCompile();
			$dbFilePath = corepath.'/coreconfig/public_tableconfig.php';
			$content = $tpl->readTemplate($dbFilePath);
			$content .= "\n".$inserStr;
			if($fp =fopen($dbFilePath, 'w'))
			{
				fwrite($fp, $content);
				fclose($fp);
			}
			return true;
//		}else
//		{
//			return false;
//		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 修改数据表
 * */
function editAppTable($oldTableInfo,$newAppId,$newTableName)
{
	try {
		//$tableInfo = getSysTableInfo($tableId);
		$oldAppInfo = getAppInfoById($oldTableInfo[0]['appId']);
		$newAppInfo = getAppInfoById($newAppId);
		$oldInserStr = '$table[\''.$oldAppInfo[0]['appName'].'\'][\''.$oldTableInfo[0]['tableName'].'\']=$dbName_table_pre.'.$appInfo[0]['appName'].'_'.'\''.$oldTableInfo[0]['tableName'].'\';';
		$newInserStr = '$table[\''.$newAppInfo[0]['appName'].'\'][\''.$newTableName.'\']=$dbName_table_pre.'.$appInfo[0]['appName'].'_'.'\''.$newTableName.'\';';

		$sql = "alter table ".$GLOBALS['currentApp']['table_pre'].$oldAppInfo[0]['appName']."_".$oldTableInfo[0]['tableName']." rename ".$GLOBALS['currentApp']['table_pre'].$oldAppInfo[0]['appName']."_".$newTableName;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

		$tpl=new TplCompile();
		$dbFilePath = corepath.'/coreconfig/public_tableconfig.php';
		$content = $tpl->readTemplate($dbFilePath);
		$content = str_replace($oldInserStr,$newInserStr,$content);
		if($fp =fopen($dbFilePath, 'w'))
		{
			fwrite($fp, $content);
			fclose($fp);
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 删除数据表
 * */
function delAppTable($nodeId,$contentModel,$tableKeyName,$tableKeyValue)
{
	try {
		$tableInfo = getSysTableInfo($tableKeyValue);
		$nodeArray = getNodeInfoById($nodeId);
		$appInfo = getAppInfoById($tableInfo[0]['appId']);
		if(!empty($tableInfo))
		{
			//删除mysql中的表
			$sql = "drop table ".$GLOBALS['currentApp']['table_pre'].$appInfo[0]['appName']."_".$tableInfo[0]['tableName'];
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$inserStr = '$table[\''.$appInfo[0]['appName'].'\'][\''.$tableInfo[0]['tableName'].'\']=$dbName_table_pre.'.'\''.$appInfo[0]['appName'].'_'.$tableInfo[0]['tableName'].'\';';
			$tpl=new TplCompile();
			$dbFilePath = corepath.'/coreconfig/public_tableconfig.php';
			$content = $tpl->readTemplate($dbFilePath);
			$content = str_replace($inserStr,'',$content);
			if($fp =fopen($dbFilePath, 'w'))
			{
				fwrite($fp, $content);
				fclose($fp);
			}

			//删除cms表的数据
			$sql = "delete from ".$contentModel." where ".$tableKeyName." = ".$tableKeyValue;
			$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
			//同时要把发布表中的数据给删除
			$sql = "delete from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";
			$params['nodeId'] = $nodeArray[0]['nodeGuid'];
			$params['contentId'] = $tableKeyValue;
			$params['appTableName'] = $contentModel;
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			//删除表的所有字段
			$allFieldInfo = getAllFieldInfoByTableId($tableKeyValue);
			if(!empty($allFieldInfo))
			{
				foreach ($allFieldInfo as $key => $val)
				{
					//delAppTableField($val['nodeId'],$val['appTableName'],'fieldId',$val['contentId'],1);

					$sql = "delete from ".$val['appTableName']." where fieldId = ".$val['contentId'];
					$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
					//同时要把发布表中的数据给删除
					$sql = "delete from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";
					$params['nodeId'] = $val['nodeId'];
					$params['contentId'] = $val['contentId'];
					$params['appTableName'] = $val['appTableName'];
					TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				}
			}
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 检测数据表
 * */
function checkExistAppTables($appId,$tableName)
{
	try {
		$appInfo = getAppInfoById($appId);
		$sql = "show tables like '".$GLOBALS['currentApp']['table_pre'].$appInfo[0]['appName']."_".$tableName."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 创建数据表字段
 * */
function addFieldForTable($tableId,$fieldInfo)
{
	try {
		$tableInfo = getSysTableInfo($tableId);
		//$fieldInfo = getSysFieldInfo($fieldId);
		$appInfo = getAppInfoById($tableInfo[0]['appId']);
		$isExistTableField = checkAppTableFieldExist($tableInfo[0]['tableName'],$appInfo[0]['appName'],$fieldInfo['fieldName']);
		$getFieldIndexType  = "";
		if(!$isExistTableField)
		{
			$getFieldTypeStr = getTableTypeAndSize($fieldInfo['fieldType'],$fieldInfo['fieldSize']);
			$getFieldPrecStr = getFieldPrec($fieldInfo['fieldPrec']);
			$getFieldIsNullStr = getFieldIsNull($fieldInfo['fieldIsNull']);
			$getFieldIsDefaultStr = getFieldIsDefault($fieldInfo['fieldIsDefault']);
			$getFieldExtraStr = getFieldExtra($fieldInfo['fieldExtra']);
			if($fieldInfo['fieldIndexType']=='primary')
			{
			//$getFieldIndexType = getFieldIndexType($tableInfo[0]['tableName'],$tableInfo[0]['appId'],$fieldInfo[0]['fieldName'],$fieldInfo[0]['fieldIndexType']);

				$sql = "ALTER TABLE ".$GLOBALS['currentApp']['table_pre'].$appInfo[0]['appName']."_".$tableInfo[0]['tableName']." ADD ".$fieldInfo['fieldName'].$getFieldTypeStr.$getFieldPrecStr.$getFieldIsNullStr.$getFieldIsDefaultStr.$getFieldExtraStr." PRIMARY KEY";
			}else
			{
				$getFieldIndexType = getFieldIndexType($tableInfo[0]['tableName'],$appInfo[0]['appName'],$fieldInfo['fieldName'],$fieldInfo['fieldIndexType']);
				$sql = "ALTER TABLE ".$GLOBALS['currentApp']['table_pre'].$appInfo[0]['appName']."_".$tableInfo[0]['tableName']." ADD ".$fieldInfo['fieldName'].$getFieldTypeStr.$getFieldPrecStr.$getFieldIsNullStr.$getFieldIsDefaultStr.$getFieldExtraStr;
			}
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
			if($getFieldIndexType!="")
			{
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$getFieldIndexType);
			}
			return true;
		}else
		{
			return false;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 修改数据表字段
 * */
function editFieldForTable($oldfieldInfo,$tableId,$newFieldInfo)
{
	try {
		$tableInfo = getSysTableInfo($tableId);
		$appInfo = getAppInfoById($tableInfo[0]['appId']);
		$diffArray = array_diff($oldfieldInfo[0],$newFieldInfo);
		unset($diffArray['fieldId']);
		if(!empty($diffArray))
		{
			$getFieldTypeStr = getTableTypeAndSize($newFieldInfo['fieldType'],$newFieldInfo['fieldSize']);
			$getFieldPrecStr = getFieldPrec($newFieldInfo['fieldPrec']);
			$getFieldIsNullStr = getFieldIsNull($newFieldInfo['fieldIsNull']);
			$getFieldIsDefaultStr = getFieldIsDefault($newFieldInfo['fieldIsDefault']);
			$getFieldExtraStr = getFieldExtra($newFieldInfo['fieldExtra']);
			if($newFieldInfo['fieldIndexType']=='primary')
			{
				$sql = "ALTER TABLE ".$GLOBALS['currentApp']['table_pre'].$appInfo[0]['appName']."_".$tableInfo[0]['tableName']." CHANGE  ".$oldfieldInfo[0]['fieldName']." ".$newFieldInfo['fieldName'].$getFieldTypeStr.$getFieldPrecStr.$getFieldIsNullStr.$getFieldIsDefaultStr.$getFieldExtraStr." PRIMARY KEY";
			}else
			{
				$getFieldIndexType = getFieldIndexType($tableInfo[0]['tableName'],$appInfo[0]['appName'],$newFieldInfo['fieldName'],$newFieldInfo['fieldIndexType']);

				$sql = "ALTER TABLE ".$GLOBALS['currentApp']['table_pre'].$appInfo[0]['appName']."_".$tableInfo[0]['tableName']." CHANGE  ".$oldfieldInfo[0]['fieldName']." ".$newFieldInfo['fieldName'].$getFieldTypeStr.$getFieldPrecStr.$getFieldIsNullStr.$getFieldIsDefaultStr.$getFieldExtraStr;
			}
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
			if($getFieldIndexType!="")
			{
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$getFieldIndexType);
			}
			return true;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 删除数据表字段
 * */
function delAppTableField($nodeId,$contentModel,$tableKeyName,$tableKeyValue,$delType=0)
{
	try {
		$fieldInfo = getSysFieldInfo($tableKeyValue);
		$nodeArray = getNodeInfoById($nodeId);
		if(!empty($fieldInfo))
		{
			$tableInfo = getSysTableInfo($fieldInfo[0]['tableId']);
			$appInfo = getAppInfoById($tableInfo[0]['appId']);
			$sql = "alter table ".$GLOBALS['currentApp']['table_pre'].$appInfo[0]['appName']."_".$tableInfo[0]['tableName']." drop column ".$fieldInfo[0]['fieldName'];
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			$sql = "delete from ".$contentModel." where ".$tableKeyName." = ".$tableKeyValue;
			$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
			//同时要把发布表中的数据给删除
			$sql = "delete from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";
			$params['nodeId'] = $nodeArray[0]['nodeGuid'];
			$params['contentId'] = $tableKeyValue;
			$params['appTableName'] = $contentModel;
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 检测数据表字段
 * */
function checkAppTableFieldExist($tableName,$appId,$fieldName)
{
	try {
		$sql = "DESCRIBE ".$GLOBALS['currentApp']['table_pre'].$appId."_".$tableName." ".$fieldName;
		//print $sql;exit;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 取数据表信息
 * */
function getSysTableInfo($tableId)
{
	try {
		$params['tableId'] = $tableId;
		$sql = "select * from {$GLOBALS['table']['cms']['sys_tables']} where tableId=:tableId";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 取数据表字段信息
 * */
function getSysFieldInfo($fieldId)
{
	try {
		$params['fieldId'] = $fieldId;
		$sql = "select * from {$GLOBALS['table']['cms']['sys_fields']} where fieldId=:fieldId";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 权限表ID到所有字段
 * */
function getAllFieldInfoByTableId($tableId)
{
	try {
		if($tableId!=""&&$tableId!=null)
		{
			$sql="select * from {$GLOBALS['table']['cms']['sys_fields']} a,{$GLOBALS['table']['cms']['app_publish_state']} b where a.fieldId=b.contentId and a.nodeId=b.nodeId and a.tableId=".$tableId;
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 设置数据表字符集
 * */
function getTableCharset($charset="utf8")
{
	try {
		if($charset=='utf8')
		{
			return "CHARACTER SET ".$charset." COLLATE ".$charset."_general_ci";
		}elseif ($charset=='gb2312')
		{
			return "CHARACTER SET ".$charset." COLLATE ".$charset."_chinese_ci";
		}elseif ($charset=='gbk')
		{
			return "CHARACTER SET ".$charset." COLLATE ".$charset."_chinese_ci";
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 设置数据表引擎
 * */
function getTableEngine($engine="MYISAM")
{
	try {
		return "ENGINE = ".$engine;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 取数据表字段类型及长度
 * */
function getTableTypeAndSize($fieldType,$fieldSize)
{
	try {
		switch ($fieldType)
		{
		case "VARCHAR":
			if(!$fieldSize)
			{
				$fieldSize = 250;
			}
			$returnStr = " VARCHAR(".$fieldSize.")";
			break;
		case "TINYINT":
			if(!$fieldSize)
			{
				$fieldSize = 4;
			}
			$returnStr = " TINYINT(".$fieldSize.")";
			break;
		case "TEXT":
			$returnStr = " TEXT";
			break;
		case "DATE":
			$returnStr = " DATE";
			break;
		case "SMALLINT":
			if(!$fieldSize)
			{
				$fieldSize = 6;
			}
			$returnStr = " SMALLINT(".$fieldSize.")";
			break;
		case "MEDIUMINT":
			if(!$fieldSize)
			{
				$fieldSize = 9;
			}
			$returnStr = " MEDIUMINT(".$fieldSize.")";
			break;
		case "INT":
			if(!$fieldSize)
			{
				$fieldSize = 11;
			}
			$returnStr = " INT(".$fieldSize.")";
			break;
		case "BIGINT":
			if(!$fieldSize)
			{
				$fieldSize = 20;
			}
			$returnStr = " BIGINT(".$fieldSize.")";
			break;
		case "FLOAT":
			$returnStr = " FLOAT";
			break;
		case "DOUBLE":
			$returnStr = " DOUBLE";
			break;
		case "DECIMAL":
			$returnStr = " DECIMAL";
			break;
		case "DATETIME":
			$returnStr = " DATETIME";
			break;
		case "TIMESTAMP":
			$returnStr = " TIMESTAMP";
			break;
		case "TIME":
			$returnStr = " TIME";
			break;
		case "YEAR":
			$returnStr = " YEAR(4)";
			break;
		case "CHAR":
			if(!$fieldSize)
			{
				$fieldSize = 250;
			}
			$returnStr = " CHAR(".$fieldSize.")";
			break;
		case "TINYBLOB":
			$returnStr = " TINYBLOB";
			break;
		case "TINYTEXT":
			$returnStr = " TINYTEXT";
			break;
		case "BLOB":
			$returnStr = " BLOB";
			break;
		case "MEDIUMBLOB":
			$returnStr = " MEDIUMBLOB";
			break;
		case "MEDIUMTEXT":
			$returnStr = " MEDIUMTEXT";
			break;
		case "LONGBLOB":
			$returnStr = " LONGBLOB";
			break;
		case "LONGTEXT":
			$returnStr = " LONGTEXT";
			break;
		case "ENUM":
			$returnStr = " ENUM";
			break;
		case "SET":
			$returnStr = " SET";
			break;
		case "BIT":
			if(!$fieldSize)
			{
				$fieldSize = 250;
			}
			$returnStr = " BIT(".$fieldSize.")";
			break;
		case "BOOL":
			$returnStr = " BOOL";
			break;
		case "BINARY":
			$returnStr = " BINARY";
			break;
		case "VARBINARY":
			$returnStr = " VARBINARY";
			break;
		}
		return $returnStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}

function getFieldPrec($fieldPrec)
{
	try {
		if($fieldPrec=='utf8_general_ci')
		{
			$returnStr = " CHARACTER SET utf8 COLLATE utf8_general_ci";
		}elseif($fieldPrec=='gbk_chinese_ci')
		{
			$returnStr = " CHARACTER SET gbk COLLATE utf8_general_ci";
		}elseif ($fieldPrec=='gb2312_chinese_ci')
		{
			$returnStr = " CHARACTER SET utf8 COLLATE utf8_general_ci";
		}
		return $returnStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getFieldProperty($fieldProperty)
{
	try {
		return true;
	}catch(Exception $e)
	{
		throw $e;
	}
}
function getFieldIsNull($fieldIsNull)
{
	try {
		if($fieldIsNull=='not null')
		{
			$returnStr = " NOT NULL";
		}elseif ($fieldIsNull=='null')
		{
			$returnStr = " NULL";
		}
		return $returnStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getFieldIsDefault($fieldIsDefault)
{
	try {
		if($fieldIsDefault)
		{
			$returnStr = "DEFAULT '".$fieldIsDefault."'";
		}
		return $returnStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}

function getFieldExtra($isFieldExtra)
{
	try {
		if($isFieldExtra=='auto_increment')
		{
			$returnStr=" AUTO_INCREMENT";
		}
		return $returnStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getFieldIndexType($tableName,$appId,$fieldName,$fieldIndexType)
{
	try {
		$tableName = $GLOBALS['currentApp']['table_pre'].$appId."_".$tableName;
		if($fieldIndexType=='primary')
		{
			$returnStr = "ALTER TABLE ".$tableName." ADD PRIMARY KEY ( ".$fieldName." )";
		}elseif ($fieldIndexType=='index')
		{
			$returnStr = "ALTER TABLE ".$tableName." ADD INDEX ( ".$fieldName." )";
		}elseif ($fieldIndexType=='unique')
		{
			$returnStr = "ALTER TABLE ".$tableName." ADD UNIQUE ( ".$fieldName." )";
		}
		return $returnStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getAppInfoById($appId)
{
	try{
		if($appId)
		{
			$sql = "select * from {$GLOBALS['table']['cms']['sys_apps']} where appId=".$appId;
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>