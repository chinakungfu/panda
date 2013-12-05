<?
/**
 * add zxqer 20081125
 * 该文件主要用来设置通用ＣＭＳ的批量操作管理的
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.common.common');
import('core.apprun.cms.node');
import('core.apprun.cms.publish');
/**
 * 批量更新列表页选定的内容
 * **/
function update($contentModel,$appTableKeyName,$selectConId)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				print $selectConIdArray[$i]."<br>";
			}
			exit;
			//			$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where ContentPlanID=:ContentPlanID";
			//			$params['ContentPlanID'] = $val['ContentPlanID'];
			//			$resultContentPlan =TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			//			return $str;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * 批量发布列表页选定的内容
 * **/

function publish1($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$action,$method,$extraPublishId='',$type='1')
{
	print_r ($nodeId."-".$contentModel."-".$appTableKeyName."-".$appTableKeyValue."-".$selectConId."-".$action."-".$method."-".$extraPublishId."-".$type);
}
function publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$action,$method,$extraPublishId='',$type='1')
{
	try {
		if($type=='1'||$type=='')//内容管理发布
		{
			$nodeArray = getNodeInfoById($nodeId);
			if($selectConId!='')//判断是不是批量发布,不为空是批量发布
			{
				$selectConIdArray = explode(',',$selectConId);
				$count = count($selectConIdArray)-1;
				for($i=0;$i<$count;$i++)
				{
					$sqlPublish = "select * from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId='".$nodeArray[0]['nodeGuid']."' and contentId='".$selectConIdArray[$i]."' and appTableName='".$contentModel."'";
					$resultPublish = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlPublish,$paramAction);
					if(!empty($resultPublish))
					{
						if($resultPublish[0]['staticIndexUrl']=='')
						{
							$resultPublish[0]['staticIndexUrl'] = $nodeArray[0]['staticIndexUrl'];
						}
						if($resultPublish[0]['staticContentUrl']=='')
						{
							$resultPublish[0]['staticContentUrl'] = $nodeArray[0]['staticContentUrl'];
						}
						if($resultPublish[0]['staticImageUrl']=='')
						{
							$resultPublish[0]['staticImageUrl'] = $nodeArray[0]['staticImageUrl'];
						}
						if($resultPublish[0]['selfPSN']=='')
						{
							$resultPublish[0]['selfPSN'] = $nodeArray[0]['contentPSN'];
						}
						if($resultPublish[0]['selfTemplate']=='')
						{
							$resultPublish[0]['selfTemplate'] = $nodeArray[0]['contentTpl'];
						}
						if($resultPublish[0]['selfURL']=='')
						{
							$resultPublish[0]['selfURL'] = $nodeArray[0]['contentURL'];
						}
						if($resultPublish[0]['publishMode']=='')
						{
							$resultPublish[0]['publishMode'] = $nodeArray[0]['publishMode'];
						}
						if($resultPublish[0]['selfPublishFileName']=='')
						{
							$resultPublish[0]['selfPublishFileName'] = $nodeArray[0]['publishFileFormat'];
						}
						if($resultPublish[0]['dynamicIndexUrl']=='')
						{
							$resultPublish[0]['dynamicIndexUrl'] = $nodeArray[0]['dynamicIndexUrl'];
						}
						if($resultPublish[0]['dynamicContentUrl']=='')
						{
							$resultPublish[0]['dynamicContentUrl'] = $nodeArray[0]['dynamicContentUrl'];
						}
						if($resultPublish[0]['dynamicImageUrl']=='')
						{
							$resultPublish[0]['dynamicImageUrl'] = $nodeArray[0]['dynamicImageUrl'];
						}
						$resultPublish[0]['appTableKeyName'] = $nodeArray[0]['appTableKeyName'];
						$resultPublish[0]['appTableKeyValue'] = $selectConIdArray[$i];
						$resultPublish[0]['appTableName'] = $nodeArray[0]['appTableName'];
						$resultPublish[0]['contentPSN'] = $nodeArray[0]['contentPSN'];
						$resultPublish[0]['contentURL'] = $nodeArray[0]['contentURL'];
						$resultPublish[0]['indexName'] = $nodeArray[0]['indexName'];
						$resultPublish[0]['subDir'] = $nodeArray[0]['subDir'];
						$resultPublish[0]['publishFileFormat'] = $nodeArray[0]['publishFileFormat'];
						$resultPublish[0]['nodeId'] = $nodeArray[0]['nodeGuid'];

						if($resultPublish[0]['publishLocalFile']!=null)
						{
							delete_file($resultPublish[0]['publishLocalFile']);
						}
					}else
					{
						$resultPublish[0]['staticIndexUrl'] = $nodeArray[0]['staticIndexUrl'];
						$resultPublish[0]['staticContentUrl'] = $nodeArray[0]['staticContentUrl'];
						$resultPublish[0]['staticImageUrl'] = $nodeArray[0]['staticImageUrl'];
						$resultPublish[0]['selfPSN'] = $nodeArray[0]['contentPSN'];
						$resultPublish[0]['selfTemplate'] = $nodeArray[0]['contentTpl'];
						$resultPublish[0]['selfURL'] = $nodeArray[0]['contentURL'];
						$resultPublish[0]['publishMode'] = $nodeArray[0]['publishMode'];
						$resultPublish[0]['selfPublishFileName'] = $nodeArray[0]['publishFileFormat'];
						$resultPublish[0]['contentPSN'] = $nodeArray[0]['contentPSN'];
						$resultPublish[0]['contentURL'] = $nodeArray[0]['contentURL'];
						$resultPublish[0]['appName'] = $nodeArray[0]['appName'];
						$resultPublish[0]['appUrl'] = $nodeArray[0]['appUrl'];
						$resultPublish[0]['appTableKeyName'] = $nodeArray[0]['appTableKeyName'];
						$resultPublish[0]['appTableKeyValue'] = $selectConIdArray[$i];
						$resultPublish[0]['indexName'] = $nodeArray[0]['indexName'];
						//zxq modify 20110801
						$resultPublish[0]['dynamicIndexUrl'] = $nodeArray[0]['dynamicIndexUrl'];
						$resultPublish[0]['dynamicContentUrl'] = $nodeArray[0]['dynamicContentUrl'];
						$resultPublish[0]['dynamicImageUrl'] = $nodeArray[0]['dynamicImageUrl'];
						
						$resultPublish[0]['subDir'] = $nodeArray[0]['subDir'];
						$resultPublish[0]['nodeId'] = $nodeArray[0]['nodeGuid'];
						$resultPublish[0]['publishFileFormat'] = $nodeArray[0]['publishFileFormat'];
						$resultPublish[0]['appTableName'] = $nodeArray[0]['appTableName'];
					}
					//return endPublish($resultPublish,$isSetPublish,$backUrl);
					endPublish($resultPublish);
				}
				//header("location:".$backUrl);
			}else//单一发布
			{
				$sqlPublish = "select * from {$GLOBALS['table']['cms']['app_publish_state']} where nodeID='".$nodeArray[0]['nodeGuid']."' and contentId='".$appTableKeyValue."' and appTableName='".$contentModel."'";
				$resultPublish = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlPublish,$paramAction);
				if(!empty($resultPublish))
				{
//					if($resultPublish[0]['contentPortalURL']=='')
//					{
//						$resultPublish[0]['contentPortalURL'] = $nodeArray[0]['contentPortalURL'];
//					}
					if($resultPublish[0]['staticIndexUrl']=='')
					{
						$resultPublish[0]['staticIndexUrl'] = $nodeArray[0]['staticIndexUrl'];
					}
					if($resultPublish[0]['staticContentUrl']=='')
					{
						$resultPublish[0]['staticContentUrl'] = $nodeArray[0]['staticContentUrl'];
					}
					if($resultPublish[0]['staticImageUrl']=='')
					{
						$resultPublish[0]['staticImageUrl'] = $nodeArray[0]['staticImageUrl'];
					}
					
					if($resultPublish[0]['selfPSN']=='')
					{
						$resultPublish[0]['selfPSN'] = $nodeArray[0]['contentPSN'];
					}
					if($resultPublish[0]['selfTemplate']=='')
					{
						$resultPublish[0]['selfTemplate'] = $nodeArray[0]['contentTpl'];
					}
					if($resultPublish[0]['selfURL']=='')
					{
						$resultPublish[0]['selfURL'] = $nodeArray[0]['contentURL'];
					}
					if($resultPublish[0]['publishMode']=='')
					{
						$resultPublish[0]['publishMode'] = $nodeArray[0]['publishMode'];
					}
					if($resultPublish[0]['selfPublishFileName']=='')
					{
						$resultPublish[0]['selfPublishFileName'] = $nodeArray[0]['publishFileFormat'];
					}
//					if($resultPublish[0]['appName']=='')
//					{
//						$resultPublish[0]['appName'] = $nodeArray[0]['appName'];
//					}
//					if($resultPublish[0]['appUrl']=='')
//					{
//						$resultPublish[0]['appUrl'] = $nodeArray[0]['dynamicContentUrl'];
//					}
					if($resultPublish[0]['dynamicIndexUrl']=='')
					{
						$resultPublish[0]['dynamicIndexUrl'] = $nodeArray[0]['dynamicIndexUrl'];
					}
					if($resultPublish[0]['dynamicContentUrl']=='')
					{
						$resultPublish[0]['dynamicContentUrl'] = $nodeArray[0]['dynamicContentUrl'];
					}
					if($resultPublish[0]['dynamicImageUrl']=='')
					{
						$resultPublish[0]['dynamicImageUrl'] = $nodeArray[0]['dynamicImageUrl'];
					}
					$resultPublish[0]['appTableKeyName'] = $nodeArray[0]['appTableKeyName'];
					$resultPublish[0]['appTableKeyValue'] = $appTableKeyValue;
					$resultPublish[0]['appTableName'] = $nodeArray[0]['appTableName'];
					$resultPublish[0]['contentPSN'] = $nodeArray[0]['contentPSN'];
					$resultPublish[0]['contentURL'] = $nodeArray[0]['contentURL'];
					$resultPublish[0]['indexName'] = $nodeArray[0]['indexName'];
					$resultPublish[0]['subDir'] = $nodeArray[0]['subDir'];
					$resultPublish[0]['publishFileFormat'] = $nodeArray[0]['publishFileFormat'];
					$resultPublish[0]['nodeId'] = $nodeArray[0]['nodeGuid'];

					if($resultPublish[0]['publishLocalFile']!=null)
					{
						delete_file($resultPublish[0]['publishLocalFile']);
					}
				}else
				{
					//$resultPublish[0]['contentPortalURL'] = $nodeArray[0]['contentPortalURL'];
					$resultPublish[0]['staticIndexUrl'] = $nodeArray[0]['staticIndexUrl'];
					$resultPublish[0]['staticContentUrl'] = $nodeArray[0]['staticContentUrl'];
					$resultPublish[0]['staticImageUrl'] = $nodeArray[0]['staticImageUrl'];
					
					$resultPublish[0]['selfPSN'] = $nodeArray[0]['contentPSN'];
					$resultPublish[0]['selfTemplate'] = $nodeArray[0]['contentTpl'];
					$resultPublish[0]['selfURL'] = $nodeArray[0]['contentURL'];
					$resultPublish[0]['publishMode'] = $nodeArray[0]['publishMode'];
					$resultPublish[0]['selfPublishFileName'] = $nodeArray[0]['publishFileFormat'];
					$resultPublish[0]['contentPSN'] = $nodeArray[0]['contentPSN'];
					$resultPublish[0]['contentURL'] = $nodeArray[0]['contentURL'];
					$resultPublish[0]['indexName'] = $nodeArray[0]['indexName'];
//					$resultPublish[0]['appName'] = $nodeArray[0]['appName'];
//					$resultPublish[0]['appUrl'] = $nodeArray[0]['dynamicContentUrl'];
					$resultPublish[0]['dynamicIndexUrl'] = $nodeArray[0]['dynamicIndexUrl'];
					$resultPublish[0]['dynamicContentUrl'] = $nodeArray[0]['dynamicContentUrl'];
					$resultPublish[0]['dynamicImageUrl'] = $nodeArray[0]['dynamicImageUrl'];
					
					$resultPublish[0]['appTableKeyName'] = $nodeArray[0]['appTableKeyName'];
					$resultPublish[0]['appTableKeyValue'] = $appTableKeyValue;
					$resultPublish[0]['subDir'] = $nodeArray[0]['subDir'];
					$resultPublish[0]['nodeId'] = $nodeArray[0]['nodeGuid'];
					$resultPublish[0]['publishFileFormat'] = $nodeArray[0]['publishFileFormat'];
					$resultPublish[0]['appTableName'] = $nodeArray[0]['appTableName'];
				}
				//print_r($resultPublish);exit;
				endPublish($resultPublish);
				//header("location:".$backUrl);
			}
		}else if($type=='0')//附加发布操作
		{
			$nodeArray = getNodeInfoById($nodeId);
			if($selectConId!='')//判断是不是批量发布
			{
				$selectConIdArray = explode(',',$selectConId);
				$count = count($selectConIdArray)-1;
				for($i=0;$i<$count;$i++)
				{
					$extraPublishArray = getExtInfoById($selectConIdArray[$i]);
					if(!empty($extraPublishArray))
					{
						foreach ($extraPublishArray as $key => $val)
						{
							if($val['staticURL'])
							{
								$nodeArray[0]['contentPortalURL']=$val['staticURL'];
							}
							if($val['extraPublishMode'])
							{
								$nodeArray[0]['publishMode']=$val['extraPublishMode'];
							}
							if($val['selfPublishFileName'])
							{
								$nodeArray[0]['indexName']=$val['selfPublishFileName'];
							}
							if($val['selfTemplate'])
							{
								$nodeArray[0]['contentTpl']=$val['selfTemplate'];
							}
							if($val['selfPSN'])
							{
								$nodeArray[0]['contentPSN']=$val['selfPSN'];
							}
							if($val['selfPSNURL'])
							{
								$nodeArray[0]['contentURL']=$val['selfPSNURL'];
							}
							if($val['dynamicURL'])
							{
								$nodeArray[0]['appUrl']=$val['dynamicURL'];
							}
							$nodeArray[0]['extraPublishId'] = $val['extraPublishId'];
						}
						endPublish($nodeArray,'0');
					}
				}
			}else
			{
				$extraPublishArray = getExtInfoById($extraPublishId);
				if(!empty($extraPublishArray))
				{
					foreach ($extraPublishArray as $key => $val)
					{
						if($val['staticURL'])
						{
							$nodeArray[0]['contentPortalURL']=$val['staticURL'];
						}
						if($val['extraPublishMode'])
						{
							$nodeArray[0]['publishMode']=$val['extraPublishMode'];
						}
						if($val['selfPublishFileName'])
						{
							$nodeArray[0]['indexName']=$val['selfPublishFileName'];
						}
						if($val['selfTemplate'])
						{
							$nodeArray[0]['contentTpl']=$val['selfTemplate'];
						}
						if($val['selfPSN'])
						{
							$nodeArray[0]['contentPSN']=$val['selfPSN'];
						}
						if($val['selfPSNURL'])
						{
							$nodeArray[0]['contentURL']=$val['selfPSNURL'];
						}
						if($val['dynamicURL'])
						{
							$nodeArray[0]['appUrl']=$val['dynamicURL'];
						}
						$nodeArray[0]['extraPublishId'] = $val['extraPublishId'];
					}
					endPublish($nodeArray,'0');
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
 * 批量取消发布列表页选定的内容
 * **/
function cancelPublish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$extraPublishId='',$type='1')
{
	try {
		if($type)
		{
			$nodeArray = getNodeInfoById($nodeId);
			if($selectConId!='')
			{
				$selectConIdArray = explode(',',$selectConId);
				$count = count($selectConIdArray)-1;
				for($i=0;$i<$count;$i++)
				{
					$sql = "select * from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName and state=1";
					$param['nodeId'] = $nodeArray[0]['nodeGuid'];
					$param['contentId'] = $selectConIdArray[$i];
					$param['appTableName'] = $contentModel;
					$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
					if($result[0]['publishLocalFile']!=null)
					{
						delete_file($result[0]['publishLocalFile']);//删除静态html文件
					}
					$sql = '';
					$params['state'] = 0;
					$params['url'] = '';
					$params['publishLocalFile'] = '';
					$params['publishDate'] = '';
					$sql = '';
					foreach ($params as $key => $var)
					{
						$sql .= "$key =:$key,";
					}
					$sql = substr($sql,0,-1);
					$sql = "update {$GLOBALS['table']['cms']['app_publish_state']} set $sql where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";

					$params['nodeId'] = $nodeArray[0]['nodeGuid'];
					$params['contentId'] = $selectConIdArray[$i];
					$params['appTableName'] = $contentModel;
					$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				}
			}else
			{
					$sql = "select * from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName and state=1";
					$param['nodeId'] = $nodeArray[0]['nodeGuid'];
					$param['contentId'] = $appTableKeyValue;
					$param['appTableName'] = $contentModel;
					$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
					if($result[0]['publishLocalFile']!=null)
					{
						delete_file($result[0]['publishLocalFile']);//删除静态html文件
					}
					$sql = '';
					$params['state'] = 0;
					$params['url'] = '';
					$params['publishLocalFile'] = '';
					$params['publishDate'] = '';
					$sql = '';
					foreach ($params as $key => $var)
					{
						$sql .= "$key =:$key,";
					}
					$sql = substr($sql,0,-1);
					$sql = "update {$GLOBALS['table']['cms']['app_publish_state']} set $sql where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";

					$params['nodeId'] = $nodeArray[0]['nodeGuid'];
					$params['contentId'] = $appTableKeyValue;
					$params['appTableName'] = $contentModel;
					$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			}
		}else
		{
			$nodeArray = getNodeInfoById($nodeId);
			if($selectConId!='')
			{
				$selectConIdArray = explode(',',$selectConId);
				$count = count($selectConIdArray)-1;
				for($i=0;$i<$count;$i++)
				{
					$extraPublishArray = getExtInfoById($selectConIdArray[$i]);
					if($extraPublishArray[0]['extraPublishLocal']!=null)
					{
						delete_file($extraPublishArray[0]['extraPublishLocal']);//删除静态html文件
					}
					$arrayExt['extraPublishState'] = 0;
					$arrayExt['extraPublishURL'] = '';
					$arrayExt['extraPublishLocal'] = '';
					editExtData($nodeId,$selectConIdArray[$i],$arrayExt);
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
 * 批量临时取消发布列表页选定的内容
 * **/
function tempCancelPublish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$extraPublishId='',$type='1')
{
	try {
		if($type)
		{
			$nodeArray = getNodeInfoById($nodeId);
			if($selectConId!='')
			{
				$selectConIdArray = explode(',',$selectConId);
				$count = count($selectConIdArray)-1;
				for($i=0;$i<$count;$i++)
				{
					$sql = "select * from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName and state=1";
					$param['nodeId'] = $nodeArray[0]['nodeGuid'];
					$param['contentId'] = $selectConIdArray[$i];
					$param['appTableName'] = $contentModel;
					$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
					if($result[0]['publishLocalFile']!=null)
					{
						delete_file($result[0]['publishLocalFile']);//删除静态html文件
					}
					$sql = '';
					$params['state'] = 0;
					$params['url'] = '';
					$params['publishLocalFile'] = '';
					$params['publishDate'] = '';
					$sql = '';
					foreach ($params as $key => $var)
					{
						$sql .= "$key =:$key,";
					}
					$sql = substr($sql,0,-1);
					$sql = "update {$GLOBALS['table']['cms']['app_publish_state']} set $sql where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";

					$params['nodeId'] = $nodeArray[0]['nodeGuid'];
					$params['contentId'] = $selectConIdArray[$i];
					$params['appTableName'] = $contentModel;
					$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				}
			}
		}else
		{
			$nodeArray = getNodeInfoById($nodeId);
			if($selectConId!='')
			{
				$selectConIdArray = explode(',',$selectConId);
				$count = count($selectConIdArray)-1;
				for($i=0;$i<$count;$i++)
				{
					$extraPublishArray = getExtInfoById($selectConIdArray[$i]);
					if($extraPublishArray[0]['extraPublishLocal']!=null)
					{
						delete_file($extraPublishArray[0]['extraPublishLocal']);//删除静态html文件
					}
					$arrayExt['extraPublishState'] = 0;
					$arrayExt['extraPublishURL'] = '';
					$arrayExt['extraPublishLocal'] = '';
					editExtData($nodeId,$selectConIdArray[$i],$arrayExt);
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
 * 批量复制列表页选定的内容
 * **/
function batchCopy($nodeId,$contentModel,$appTableKeyName,$toNodeGuid,$selectConId)
{
	try {
//		print "contentModel:".$contentModel."<br>";
//		print "appTableKeyName:".$appTableKeyName."<br>";
//		print "toNodeGuid:".$toNodeGuid."<br>";
//		print "selectConId:".$selectConId."<br>";
		$nodeArray = getNodeInfoById($nodeId);
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				copyContent($nodeArray[0]['nodeGuid'],$contentModel,$appTableKeyName,$toNodeGuid,$selectConIdArray[$i]);
				//print $selectConIdArray[$i]."<br>";
			}
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 数据复制
 * */
function copyContent($nodeGuid,$contentModel,$appTableKeyName,$toNodeGuid,$appTableKeyValue)
{
	try {
		$sql = "select * from {$contentModel} where ".$appTableKeyName."=".$appTableKeyValue;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if(!empty($result))
		{
			$result[0]['nodeId'] = $toNodeGuid;
			unset($result[0][$appTableKeyName]);
			foreach ($result[0] as $key => $val)
			{
				$str_field .= $key.",";
				$str_value .= ":".$key.",";
			}
			$str_field = substr($str_field,0,-1);
			$str_value = substr($str_value,0,-1);
			$sql = "insert into {$contentModel} (".$str_field.") values (".$str_value.")";
			$insertResult = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$result[0]);
			//查看发布表中的原始数据
			$sql = "select * from {$GLOBALS['table']['cms']['app_publish_state']} where contentId ='".$appTableKeyValue."' and nodeId='".$nodeGuid."' and appTableName='".$contentModel."'";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			if(!empty($result))
			{
				$result[0]['nodeId'] = $toNodeGuid;
				$result[0]['appTableName'] = $contentModel;
				$result[0]['contentId'] = $insertResult;
				unset($result[0]['publishId']);
				addPublish($result[0]);//向发布状态表中插入一条记录
			}else 
			{
				$publishArray['nodeId']=$toNodeGuid;
				$publishArray['appTableName']=$contentModel;
				$publishArray['contentId']=$insertResult;
				addPublish($publishArray);//向发布状态表中插入一条记录
			}
		}
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量转移列表页选定的内容
 * **/
function batchMove($nodeId,$contentModel,$appTableKeyName,$toNodeGuid,$selectConId)
{
	try {
		$nodeArray = getNodeInfoById($nodeId);
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				moveContent($nodeArray[0]['nodeGuid'],$contentModel,$appTableKeyName,$toNodeGuid,$selectConIdArray[$i]);
			}
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 数据移动
 * */
function moveContent($nodeGuid,$contentModel,$appTableKeyName,$toNodeGuid,$appTableKeyValue)
{
	try {
		$sql = "update {$contentModel} set nodeId = '".$toNodeGuid."' where ".$appTableKeyName."=".$appTableKeyValue;
		
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$sql = "update {$GLOBALS['table']['cms']['app_publish_state']} set nodeId='".$toNodeGuid."' where contentId ='".$appTableKeyValue."' and nodeId='".$nodeGuid."' and appTableName='".$contentModel."'";
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量批量置顶列表页选定的内容
 * **/
function batchTop($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$publishArray)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				editPublish($selectConIdArray[$i],$nodeId,$contentModel,$publishArray);
			}

		}else
		{
			editPublish($appTableKeyValue,$nodeId,$contentModel,$publishArray);
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量批量精华列表页选定的内容
 * **/
function batchBest($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$publishArray)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				editPublish($selectConIdArray[$i],$nodeId,$contentModel,$publishArray);
			}

		}else
		{
			editPublish($appTableKeyValue,$nodeId,$contentModel,$publishArray);
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量批量权重列表页选定的内容
 * **/
function batchSort($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$publishArray)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				editPublish($selectConIdArray[$i],$nodeId,$contentModel,$publishArray);
			}

		}else
		{
			editPublish($appTableKeyValue,$nodeId,$contentModel,$publishArray);
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * 批量批量删除列表页选定的内容
 * **/
function batchDel($nodeId,$contentModel,$appTableKeyName,$selectConId,$method)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				delCommonData($nodeId,$contentModel,$appTableKeyName,$selectConIdArray[$i],$method);
			}
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量永久删除列表页选定的内容
 * **/
function foreverDel($nodeId,$contentModel,$appTableKeyName,$selectConId,$method)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				delCommonData($nodeId,$contentModel,$appTableKeyName,$selectConIdArray[$i],$method);
			}
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量创建虚连接列表页选定的内容
 * **/
function createVoidLink($contentModel,$appTableKeyName,$selectConId)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				print $selectConIdArray[$i]."<br>";
			}
			exit;
			//			$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where ContentPlanID=:ContentPlanID";
			//			$params['ContentPlanID'] = $val['ContentPlanID'];
			//			$resultContentPlan =TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			//			return $str;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量创建索引连接列表页选定的内容
 * **/
function createIndexLink($contentModel,$appTableKeyName,$selectConId)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				print $selectConIdArray[$i]."<br>";
			}
			exit;
			//			$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where ContentPlanID=:ContentPlanID";
			//			$params['ContentPlanID'] = $val['ContentPlanID'];
			//			$resultContentPlan =TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			//			return $str;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量结点-全部取消发布列表页选定的内容
 * **/
function nodeCancelPublish($contentModel,$appTableKeyName,$selectConId)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				print $selectConIdArray[$i]."<br>";
			}
			exit;
			//			$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where ContentPlanID=:ContentPlanID";
			//			$params['ContentPlanID'] = $val['ContentPlanID'];
			//			$resultContentPlan =TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			//			return $str;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量结点-全部临时取消发布列表页选定的内容
 * **/
function nodeTempCancelPublish($contentModel,$appTableKeyName,$selectConId)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				print $selectConIdArray[$i]."<br>";
			}
			exit;
			//			$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where ContentPlanID=:ContentPlanID";
			//			$params['ContentPlanID'] = $val['ContentPlanID'];
			//			$resultContentPlan =TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			//			return $str;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 批量结点-全部重新发布列表页选定的内容
 * **/
function nodeAllRepublish($contentModel,$appTableKeyName,$selectConId)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				print $selectConIdArray[$i]."<br>";
			}
			exit;
			//			$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where ContentPlanID=:ContentPlanID";
			//			$params['ContentPlanID'] = $val['ContentPlanID'];
			//			$resultContentPlan =TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			//			return $str;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 恢复删除的数据
 * **/
function resumeData($nodeId,$contentModel,$appTableKeyName,$selectConId)
{
	try {
		if($selectConId!='')
		{
			$selectConIdArray = explode(',',$selectConId);
			$count = count($selectConIdArray)-1;
			for($i=0;$i<$count;$i++)
			{
				resumeCommonData($nodeId,$contentModel,$appTableKeyName,$selectConIdArray[$i]);
			}
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 清空回收站
 * **/
function flushRecData($nodeId,$contentModel,$appTableKeyName)
{
	try {
		$nodeArray = getNodeInfoById($nodeId);
		//查询该结点的所有删除数据
		$sql = "select contentId from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and appTableName=:appTableName and isDel=1";
		$params['nodeId'] = $nodeArray[0]['nodeGuid'];
		$params['appTableName'] = $contentModel;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//删除发布表的数据
		$sql = "delete from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and appTableName=:appTableName and isDel=1";
		$params['nodeId'] = $nodeArray[0]['nodeGuid'];
		$params['appTableName'] = $contentModel;
		TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//循环删除内容表的数据
		if(!empty($result))
		{
			foreach ($result as $key => $val)
			{
				$sql = "delete from ".$contentModel." where ".$tableKeyName." = ".$val['contentId'];
				$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
			}
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/*
* 删除文件夹及其文件夹下所有文件
*/
function delete_file($file){
	$delete = @unlink($file);
	clearstatcache();
	if(@file_exists($file)){
		$filesys = eregi_replace("/","//",$file);
		$delete = @system("del $filesys");
		clearstatcache();
		if(@file_exists($file)){
			$delete = @chmod ($file, 0777);
			$delete = @unlink($file);
			$delete = @system("del $filesys");
		}
	}
	clearstatcache();
	if(@file_exists($file)){
		return false;
	}else{
		return true;
	}
}
?>