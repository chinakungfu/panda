<?
/**
 * add zxqer 20090216
 * 该文件主要用来设置通用ＣＭＳ的好布管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.controller.Controller');
import('core.tpl.TplTemplate');
import('core.tpl.TplRun');
import('core.apprun.cms.system.publish_psn');
import('core.tpl.TplTemplate');
import('core.tpl.TplRun');
import('core.apprun.cms.node');
import('core.apprun.cms.common.batch');
/**
 *根据ID得到发布的基本信息 
 **/       
function getPublishInfoById($contentId,$nodeId,$tableName)
{
	try
	{
		date_default_timezone_set('PRC');
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['app_publish_state']} where contentId ='".$contentId."' and nodeId='".$nodeInfo[0]['nodeGuid']."' and appTableName='".$tableName."'";
//		$publishArray['contentId'] = $contentId;
//		$publishArray['nodeId'] = $nodeInfo[0]['nodeGuid'];
//		$publishArray['appTableName'] = $tableName;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$publishArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到发布的基本信息 
 **/       
function editPublish($contentId,$nodeId,$appTableName,$publishArray)
{
	try
	{
		//print_r($publishArray);exit;
		date_default_timezone_set('PRC');
		$nodeInfo = getNodeInfoById($nodeId);
		foreach ($publishArray as $key => $var)
		{
			$sql .= "$key =:$key,";
			//$sql .= "$key ='".$var."',";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['app_publish_state']} set $sql where contentId ='".$contentId."' and nodeId='".$nodeInfo[0]['nodeGuid']."' and appTableName='".$appTableName."'";
		
		//print_r($publishArray);
		//print $sql;exit;
		//$publishArray['publishId'] = $publishId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$publishArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加发布的基本信息 
 **/       
function addPublish($publishArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$params['publishDate'] = strtotime(date("Y-m-d H:i:s"));
		foreach ($publishArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['app_publish_state']} (".$str_field.") values (".$str_value.")";
		//echo $sql;
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$publishArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除发布的基本信息 
 **/       
function delPublish($publishId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['app_publish_state']} where publishId=:publishId";
		$publishArray['publishId'] = $publishId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$publistArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *正式发布成文件 
 **/       
function endPublish($publishArray,$type='1')
{
	try
	{
		if($type)
		{
			//print_r($publishArray);exit;
			if($publishArray[0]['publishMode']=='1')//静态发布
			{
				
				$publishArray = changeArray($publishArray);
				$publishTpl = new TplRun();
				//首页
				$urlStr = substr($publishArray[0]['staticIndexUrl'],0,strpos($publishArray[0]['staticIndexUrl'],"?")+1);
				$fileName = $publishArray[0]['staticIndexUrl']."&".$publishArray[0]['appTableKeyName']."=".$publishArray[0]['appTableKeyValue'];
				$paramUrl = encrypt_url(substr($fileName,strpos($fileName,"?")+1),'lonmozxqer',false);
				$urlStr = substr($fileName,0,strpos($fileName,"?"));
				$fileName = $urlStr.$paramUrl;
				if(!strpos($fileName,"p://"))
				{  
					$fileName = "http://".$_SERVER['HTTP_HOST'].$urlStr.$paramUrl;
				}
				$contents = getUrlContent($fileName);
				$backUrlArray = $publishTpl->createStaticFile($contents,$publishArray,"0");
				modifyPublish($publishArray,$backUrlArray['portUrl'],$backUrlArray['localPath'],'0');
				//图片
				$urlStr = substr($publishArray[0]['staticImageUrl'],0,strpos($publishArray[0]['staticImageUrl'],"?")+1);
				$fileName = $publishArray[0]['staticImageUrl']."&".$publishArray[0]['appTableKeyName']."=".$publishArray[0]['appTableKeyValue'];
				$paramUrl = encrypt_url(substr($fileName,strpos($fileName,"?")+1),'lonmozxqer',false);
				$urlStr = substr($fileName,0,strpos($fileName,"?"));
				$fileName = $urlStr.$paramUrl;
				if(!strpos($fileName,"p://"))
				{  
					$fileName = "http://".$_SERVER['HTTP_HOST'].$urlStr.$paramUrl;
				}
				$contents = getUrlContent($fileName);
				
				$backUrlArray = $publishTpl->createStaticFile($contents,$publishArray,"1");
				modifyPublish($publishArray,$backUrlArray['portUrl'],$backUrlArray['localPath'],"1");
				//内容
				$urlStr = substr($publishArray[0]['staticContentUrl'],0,strpos($publishArray[0]['staticContentUrl'],"?")+1);
				$fileName = $publishArray[0]['staticContentUrl']."&".$publishArray[0]['appTableKeyName']."=".$publishArray[0]['appTableKeyValue'];
				$paramUrl = encrypt_url(substr($fileName,strpos($fileName,"?")+1),'lonmozxqer',false);
				$urlStr = substr($fileName,0,strpos($fileName,"?"));
				$fileName = $urlStr.$paramUrl;
				if(!strpos($fileName,"p://"))
				{  
					$fileName = "http://".$_SERVER['HTTP_HOST'].$urlStr.$paramUrl;
				}
				//print_r($fileName);exit;
				$contents = getUrlContent($fileName);
				//$contents = getUrlContent($fileName);
				$backUrlArray = $publishTpl->createStaticFile($contents,$publishArray,"2");
				modifyPublish($publishArray,$backUrlArray['portUrl'],$backUrlArray['localPath'],"2");
			}else if($publishArray[0]['publishMode']=='2')//动态发布
			{
				$fileName = $publishArray[0]['dynamicContentUrl']."&".$publishArray[0]['appTableKeyName']."=".$publishArray[0]['appTableKeyValue']."&nodeId=".$publishArray[0]['nodeId'];
				$paramUrl = encrypt_url(substr($fileName,strpos($fileName,"?")+1),'lonmozxqer',false);
				$urlStr = substr($fileName,0,strpos($fileName,"?"));
				$fileName = $urlStr.$paramUrl;
				modifyPublish($publishArray,$fileName,'',$isSetPublish,'');
			}else//不对外发布
			{
	
			}
		}else //附加发布
		{
			if($publishArray[0]['publishMode']=='1')//静态发布
			{
				$publishArray = changeArray($publishArray);
				$publishTpl = new TplRun();
				$paramUrl = encrypt_url(substr($publishArray[0]['contentPortalURL'],strpos($publishArray[0]['contentPortalURL'],"?")+1)."&".$publishArray[0]['appTableKeyName']."=".$publishArray[0]['appTableKeyValue']);
				$urlStr = substr($publishArray[0]['contentPortalURL'],0,strpos($publishArray[0]['contentPortalURL'],"?")+1);
				$contents = getUrlContent($urlStr.$paramUrl);
				$backUrlArray = $publishTpl->createStaticFile($contents,$publishArray,'0');
				//print_r($backUrlArray);exit;
				modifyExtraPublish($publishArray,$backUrlArray['portUrl'],$backUrlArray['localPath']);
			}else if($publishArray[0]['publishMode']=='2')//动态发布
			{
				
				$fileName = $publishArray[0]['appUrl']."&".$publishArray[0]['appTableKeyName']."=".$publishArray[0]['appTableKeyValue'];
				
				$paramUrl = encrypt_url(substr($fileName,strpos($fileName,"?")+1));
				$urlStr = substr($fileName,0,strpos($fileName,"?"));
				$fileName = $urlStr.$paramUrl;
				modifyExtraPublish($publishArray,$fileName,'',$isSetPublish,'');
			}else//不对外发布
			{
	
			}
		}
		return true;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 处理发布的数组
 * 主要是宏替换
 * **/
function changeArray($publishArray)
{
	try {
		foreach ($publishArray[0] as $key => $val)
		{
			if($key=='contentPSN')
			{
				$patt = "/{(.*)}/siU";
				if (preg_match_all($patt, $val, $matches))
				{
					$endPath = substr($val,strpos($val,'}')+1);
					if(substr($endPath,-1)!='/')
					{
						$endPath = $endPath."/";
					}
					$contentPsnArray = explode(':',$matches[1][0]);
					$psnArray = getPublishPsnInfoById($contentPsnArray[1]);
					$publishArray[0]['contentPSN'] = $psnArray[0]["psn"].$endPath;
					$publishArray[0]['contentPSN'] = str_replace("//","/",$publishArray[0]['contentPSN']);
				}
			}
			if($key=='contentURL')
			{
				$patt = "/{(.*)}/siU";
				if (preg_match_all($patt, $val, $matches))
				{
					$endPath = substr($val,strpos($val,'}')+1);
					if(substr($endPath,-1)!='/')
					{
						$endPath = $endPath."/";
					}
					$contentPsnArray = explode(':',$matches[1][0]);
					$psnArray = getPublishPsnInfoById($contentPsnArray[1]);
					$publishArray[0]['contentURL'] = $psnArray[0]["psnUrl"].$endPath;;
					$publishArray[0]['contentURL'] = str_replace("//","/",$publishArray[0]['contentURL']);
					$publishArray[0]['contentURL'] = str_replace(":/","://",$publishArray[0]['contentURL']);
				}
			}
			if($key=='subDir')
			{
				if($val!='auto')
				{
					if($val=='Y-m-d')
					{
						$publishArray[0]['subDir']=date("Y-m-d");
					}elseif ($val=='Y/m/d')
					{
						$publishArray[0]['subDir']=date("Y")."/".date("m")."/".date("d")."/";
					}elseif ($val=='Y-m')
					{
						$publishArray[0]['subDir']=date("Y-m");
					}elseif ($val=='Y')
					{
						$publishArray[0]['subDir']=date("Y-m");
					}
				}else 
				{
					$publishArray[0]['subDir']='publish/';
				}
			}
			if($key=='publishFileFormat')
			{
				$patt = "/{(.*)}/siU";
				if (preg_match_all($patt, $val, $matches))
				{
					foreach ($matches[1] as $mkey => $mval)
					{
						if($mval=='TimeStamp')
						{
							$timeStamp = strtotime(date("Y-m-d H:i:s"));
							$val = str_replace($matches[0][$mkey],$timeStamp,$val);
						}
						if($mval=='tableKeyName')
						{
							$tableKeyName = $publishArray[0]['appTableKeyValue'];
							$val = str_replace($matches[0][$mkey],$tableKeyName,$val);
						}
						if($mval=='nodeId')
						{
							$nodeId = $publishArray[0]['nodeId'];
							$val = str_replace($matches[0][$mkey],$nodeId,$val);
						}
					}
					$publishArray[0]['publishFileFormat'] = $val;
				}
			}
		}
		return $publishArray;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到发布的基本信息 
 **/       
function modifyPublish($publishArray,$portUrl,$localPath,$fileType)
{
	try
	{
		date_default_timezone_set('PRC');
//		if($isSetPublish)
//		{
			$sql = "select publishDate from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";
			
			$param['nodeId'] = $publishArray[0]['nodeId'];
			$param['contentId'] = $publishArray[0]['appTableKeyValue'];
			$param['appTableName'] = $publishArray[0]['appTableName'];
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
			if($result[0]['publishDate']!=''&&$result[0]['publishDate']!='0')
			{
				$params['modifyDate'] = strtotime(date("Y-m-d H:i:s"));
			}else
			{
				$params['publishDate'] = strtotime(date("Y-m-d H:i:s"));
				$params['modifyDate'] = strtotime(date("Y-m-d H:i:s"));
			}
			$params['state'] = 1;
			if($fileType=='0')
			{
				$params['indexUrl'] = $localPath;
			}elseif($fileType=='1') 
			{
				$params['imageUrl'] = $localPath;
			}elseif ($fileType=='2')
			{
				$params['url'] = $portUrl;
				$params['publishLocalFile'] = $localPath;
			}else 
			{
				$params['url'] = $portUrl;
				$params['publishLocalFile'] = $localPath;
			}
			//$params['publishDate'] = strtotime(date("Y-m-d H:i:s"));
			$sql = '';
			foreach ($params as $key => $var)
			{
				$sql .= $key ."=:".$key.",";
			}
			$sql = substr($sql,0,-1);
			$sql = "update {$GLOBALS['table']['cms']['app_publish_state']} set $sql where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";
			$params['nodeId'] = $publishArray[0]['nodeId'];
			$params['contentId'] = $publishArray[0]['appTableKeyValue'];
			$params['appTableName'] = $publishArray[0]['appTableName'];
			$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			
//		}else
//		{
//			$publishArray[0]['State'] = 1;
//			$publishArray[0]['URL'] = $fileName;
//			$params['publishDate'] = strtotime(date("Y-m-d H:i:s"));
//			foreach ($publishArray[0] as $key => $val)
//			{
//				if($key!='appTableKeyName')
//				{
//					$str_field .= $key.",";
//					$str_value .= ":".$key.",";
//				}
//			}
//			$str_field = substr($str_field,0,-1);
//			$str_value = substr($str_value,0,-1);
//			$sql = "insert into {$GLOBALS['table']['cms']['app_publish_state']} (".$str_field.") values (".$str_value.")";
//			$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$publishArray[0]);
//		}
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 修改附加发布表
 * */
function modifyExtraPublish($publishArray,$portUrl,$localPath)
{
	try {
		$sql = "update {$GLOBALS['table']['cms']['app_table_extra']} set extraPublishURL='".$portUrl."',extraPublishLocal='".$localPath."',extraPublishState=1 where extraPublishId='".$publishArray[0]['extraPublishId']."'";
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,"");
	}catch (Exception $e)
	{
		
	}
}
//结点更新函数
function saveNodeUpdate($nodeId,$start,$counter,$subNode,$arrayParams)
{
	try {
//		print $nodeId."<br>";
//		print $start."<br>";
//		print $counter."<br>";
//		print $subNode."<br>";
//		print_r($arrayParams);exit;
		$nodeArray = getNodeInfoById($nodeId);
		if($arrayParams['subNode']!='')
		{
			
		}else 
		{
			if($arrayParams['index'])//更新首页
			{
				$indexArray = getNodeExtraIndexByNodeId($nodeId);
				publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConIdExtra,$frameListAction,$frameListMethod,$indexArray[0]['extraPublishId'],'0');
			}
			if($arrayParams['extraPublish'])//更新结点的附加发布
			{
				$extraPublishArray = getExtraPublishedByNodeId($nodeId);//取得结点附加发布中所有已发布的数据
				if(!empty($extraPublishArray))
				{
					foreach ($extraPublishArray as $key => $val)
					{
						if($val['isIndex']!=1)
						{
							$selectConIdExtra .= $val[contentId].",";
						}
					}
				}
				publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConIdExtra,$frameListAction,$frameListMethod,$extraPublishId,'0');
			}
			if($arrayParams['contentPage'])//当前结点内容更新
			{
				//$sql = "select a.".$nodeArray[0]['appTableKeyName']." from ".$nodeArray[0]['appTableName']." a,{$GLOBALS['table']['cms']['app_publish_state']} b where a.nodeId = b.nodeId and b.state='1' and a.nodeId=:nodeId";
				$sql = "SELECT contentId FROM {$GLOBALS['table']['cms']['app_publish_state']} WHERE isDel='0' and state = '1' AND nodeId =:nodeId";
				$params['nodeId'] = $nodeArray[0]['nodeGuid'];
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				foreach ($result as $key => $val)
				{
					$selectConId .= $val[contentId].",";
				}
				publish($nodeId,$nodeArray[0]['appTableName'],$nodeArray[0]['appTableKeyName'],'',$selectConId,$action,$method);
			}
			
			return true;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
//结点发布函数
function saveNodePublish($nodeId,$start,$counter,$subNode,$arrayParams,$isMandatory,$i=0)
{
	try {
		$nodeArray = getNodeInfoById($nodeId);
		if($$subNode!='')//发布子结点
		{
			$allArraySubId = getSubNodeByParentNode($nodeArray[0]['nodeGuid'],$nodeArray[0]['nodeGuid'],$allArraySubId);
			$sqlWhere = "(";
			foreach ($allArraySubId as $key => $val)
			{
				$sqlWhere .= "nodeId='".$val."' or ";
			}
			$sqlWhere = substr($sqlWhere,0,-4);
			$sqlWhere .= ")";
			$sqlCount = "select count(*) as rowCount from {$GLOBALS['table']['cms']['app_publish_state']} where state='0' and ".$sqlWhere;
			$resultCount = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlCount,$params);
			$totalCount = $resultCount[0]['rowCount'];
			$sql = "select contentId,nodeId from {$GLOBALS['table']['cms']['app_publish_state']} where state='0' and ".$sqlWhere." limit ".$start.",".$counter;
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			foreach ($result as $key => $val)
			{
				if($val['contentId']!=null)
				{
					$nodeArray = getNodeInfoByNodeGuid($val['nodeId']);
					publish($nodeArray[0]['nodeId'],$nodeArray[0]['appTableName'],$nodeArray[0]['appTableKeyName'],$val['contentId'],$selectConId,$action,$method);
				}
			}
			$i++;
			$start = $i*$counter;
			if($start<$totalCount)
			{
				saveNodePublish($nodeId,$start,$counter,$subNode,$i);//递归结点发布
			}else 
			{
				return true;
			}
		}else //不发布子结点
		{
			if(!$isMandatory)//发布未发布
			{
				if($arrayParams['index'])//更新首页
				{
					$indexArray = getNodeExtraIndexNoPublishByNodeId($nodeId);
					publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConIdExtra,$frameListAction,$frameListMethod,$indexArray[0]['extraPublishId'],'0');
				}
				if($arrayParams['extraPublish'])//更新结点的附加发布
				{
					$extraPublishArray = getExtraPublishByNodeId($nodeId);//取得结点附加发布中所有已发布的数据
					if(!empty($extraPublishArray))
					{
						foreach ($extraPublishArray as $key => $val)
						{
							if($val['isIndex']!=1)
							{
								$selectConIdExtra .= $val[contentId].",";
							}
						}
					}
					publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConIdExtra,$frameListAction,$frameListMethod,$extraPublishId,'0');
				}
				if($arrayParams['contentPage'])//当前结点内容更新
				{
					$sqlCount = "select count(*) as rowCount from {$GLOBALS['table']['cms']['app_publish_state']} where state='0' and nodeId=:nodeId and isDel=0";
					$params['nodeId'] = $nodeArray[0]['nodeGuid'];
					$resultCount = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlCount,$params);
					$totalCount = $resultCount[0]['rowCount'];
					$sql = "select contentId from {$GLOBALS['table']['cms']['app_publish_state']} where state='0' and isDel=0 and nodeId=:nodeId limit ".$start.",".$counter;
					$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
					foreach ($result as $key => $val)
					{
						if($val['contentId']!=null)
						{
							publish($nodeId,$nodeArray[0]['appTableName'],$nodeArray[0]['appTableKeyName'],$val['contentId'],$selectConId,$action,$method);
						}
					}
					$i++;
					$start = $i*$counter;
					if($start<$totalCount)
					{
						saveNodePublish($nodeId,$start,$counter,$subNode,$i);//递归结点发布
					}else 
					{
						return true;
					}
				}
			}else//完全发布
			{
				if($arrayParams['index'])//更新首页
				{
					$indexArray = getNodeExtraIndexAllByNodeId($nodeId);
					publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConIdExtra,$frameListAction,$frameListMethod,$indexArray[0]['extraPublishId'],'0');
				}
				if($arrayParams['extraPublish'])//更新结点的附加发布
				{
					$extraPublishArray = getExtraPublishAllByNodeId($nodeId);//取得结点附加发布中所有已发布的数据
					if(!empty($extraPublishArray))
					{
						foreach ($extraPublishArray as $key => $val)
						{
							if($val['isIndex']!=1)
							{
								$selectConIdExtra .= $val[contentId].",";
							}
						}
					}
					publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConIdExtra,$frameListAction,$frameListMethod,$extraPublishId,'0');
				}
				if($arrayParams['contentPage'])//当前结点内容更新
				{
					$sqlCount = "select count(*) as rowCount from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and isDel=0";
					$params['nodeId'] = $nodeArray[0]['nodeGuid'];
					$resultCount = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlCount,$params);
					$totalCount = $resultCount[0]['rowCount'];
					$sql = "select contentId from {$GLOBALS['table']['cms']['app_publish_state']} where isDel=0 and nodeId=:nodeId limit ".$start.",".$counter;
					$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
					foreach ($result as $key => $val)
					{
						if($val['contentId']!=null)
						{
							publish($nodeId,$nodeArray[0]['appTableName'],$nodeArray[0]['appTableKeyName'],$val['contentId'],$selectConId,$action,$method);
						}
					}
					$i++;
					$start = $i*$counter;
					if($start<$totalCount)
					{
						saveNodePublish($nodeId,$start,$counter,$subNode,$i);//递归结点发布
					}else 
					{
						return true;
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
function getUrlContent($url)
{

	$url_parsed = parse_url($url);
	$host = $url_parsed['host'];
	$port = $url_parsed['port'];

	if ( $port == 0 )
	{
		$port = 80;
	}

	$path = $url_parsed['path'];

	if (empty($path))
	{
		$path = "/";
	}

	if ( $url_parsed['query'] != "" )
	{
		$path .= "?".$url_parsed['query'];
	}

	$out = "GET {$path} HTTP/1.0\r\nHost: {$host}\r\n\r\n";

	if ($fp = @fsockopen( $host, $port, $errno, $errstr, 30 ))
	{

		fwrite($fp,$out);
		$body = false;
		while (!feof($fp))
		{
			$s = fgets($fp,1024);

			if ($body)
			{
				$in .= $s;
			}
			if ( $s == "\r\n" )
			{
				$body = true;
			}
		}

		fclose($fp);

		return $in;
	}
	else
	{
		return false;
	}
}
?>