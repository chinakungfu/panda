<?
/**
 * add zxqer 20081107
 * 该文件主要用来设置通用ＣＭＳ的结点管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.spell_class');
import('core.apprun.resourceManage.ascll');
import('core.apprun.resourceManage.dirOperation');
define('PATHSEPARATOR','/');
import('core.xml.XMLDoc');
import('core.xml.XMLTag');
import('core.lang.FileException');
import('core.param.param');
import('core.apprun.cms.system.data_operation');
import('core.apprun.cms.node_auth');

//=============================================
//显示树型菜单函数 listNode()
//=============================================
function listNode()
{
	try {
		$memberId = readSession();
		//提取一级菜单
		$sql="select * from {$GLOBALS['table']['cms']['site']} where parentId='0' and isDel=0 order by nodeId";
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$str = '<script language="javascript" type="text/javascript">';
		$str .= 'window.listNodeTree = new MzTreeView("listNodeTree");';
		$str .= 'listNodeTree.setIconPath("skin/images/treeImage/");';
		$str .= 'listNodeTree.N["0_baseNode"] = "T:站点根;rightmethod:showRightMenu(\'node\',\'menuBase\',\'0\');";';
		//如果一级菜单存在则开始菜单的显示
		if(count($result)>0)
		{
			foreach ($result as $key => $val)
			{
				if($memberId!='admin')//no administrator
				{
					$groupIdArray = getGroupIdByStaffNo($memberId);
					if(checkDisplayNodeAuth($groupIdArray,$memberId,$val['nodeGuid'],'CKJD5tyQ'))
					{
						$url = "index.php".encrypt_url("action=cms&method=editNode&nodeId=".$val['nodeId']);
						$str .='listNodeTree.N["baseNode_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';rightmethod:showRightMenu(\'node\',\'menu\',\''.$val['nodeId'].'\');target:mainFrame";';
					}else 
					{
						$url = "";
						if(checkParentAuth($val['nodeGuid']))
						{
							$str .='listNodeTree.N["baseNode_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';target:mainFrame";';
						}else 
						{
							$str .='listNodeTree.N["baseNode_'.$val['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$val['nodeName'].'</font>;url:'.$url.';target:mainFrame";';
						}
					}
				}else 
				{
					$url = "index.php".encrypt_url("action=cms&method=editNode&nodeId=".$val['nodeId']);
					$str .='listNodeTree.N["baseNode_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';rightmethod:showRightMenu(\'node\',\'menu\',\''.$val['nodeId'].'\');target:mainFrame";';
				}	
			}
			$sqlSub = "select * from {$GLOBALS['table']['cms']['site']} where parentId!='0' and isDel=0 order by nodeId";
			$resultSub = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlSub,$params);
			foreach ($resultSub as $keySub => $valSub)
			{
				if($memberId!='admin')//no administrator
				{
					$groupIdArray = getGroupIdByStaffNo($memberId);
					if(checkDisplayNodeAuth($groupIdArray,$memberId,$valSub['nodeGuid'],'CKJD5tyQ'))
					{
						$url = "index.php".encrypt_url("action=cms&method=editNode&nodeId=".$valSub['nodeId']);
						$str .='listNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';url:'.$url.';rightmethod:showRightMenu(\'node\',\'menu\',\''.$valSub['nodeId'].'\');target:mainFrame";';
					}else 
					{
						$url = "";
						if(checkParentAuth($valSub['nodeGuid']))
						{
							$str .='listNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';url:'.$url.';target:mainFrame";';
						}else 
						{
							$str .='listNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$valSub['nodeName'].'</font>;url:'.$url.';target:mainFrame";';
						}
					}
				}else 
				{
					$url = "index.php".encrypt_url("action=cms&method=editNode&nodeId=".$valSub['nodeId']);
					$str .='listNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';url:'.$url.';rightmethod:showRightMenu(\'node\',\'menu\',\''.$valSub['nodeId'].'\');target:mainFrame";';
				}	
			}
		}
		$str .='listNodeTree.setURL("#");
		listNodeTree.wordLine = false;
		listNodeTree.setTarget("main");
		document.getElementById("nodeList").innerHTML=listNodeTree.toString();
		</script>';
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//显示选择树型菜单函数 selectListNode()
//=============================================
function selectListNode()
{
	try {
		$str = '<script language="javascript" type="text/javascript">';
		$str .= 'window.listNodeTree = new MzTreeView("listNodeTree");';
		$str .= 'listNodeTree.setIconPath("skin/images/treeImage/");';
		$str .= 'listNodeTree.N["0_baseNode"] = "ctrl:sel;checked:0;T:站点根";';
		//提取一级菜单
		$sql="select * from {$GLOBALS['table']['cms']['site']} where parentId='0' and isDel=0";
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//如果一级菜单存在则开始菜单的显示
		if(count($result)>0)
		{
			foreach ($result as $key => $val)
			{
				$url = "index.php".encrypt_url("action=cms&method=editNode&nodeId=".$val['nodeId']);
				$str .='listNodeTree.N["baseNode_'.$val['nodeGuid'].'"] = "ctrl:sel;checked:0;T:'.$val['nodeName'].';url:'.$url.'";';
			}
			$sqlSub = "select * from {$GLOBALS['table']['cms']['site']} where parentId!='0' and isDel=0 order by nodeId";
			$resultSub = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlSub,$params);
			foreach ($resultSub as $keySub => $valSub)
			{
				$url = "index.php".encrypt_url("action=cms&method=editNode&nodeId=".$val['nodeId']);
				$str .='listNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "ctrl:sel;checked:0;T:'.$valSub['nodeName'].';url:'.$url.'";';
			}
		}
		$str .='listNodeTree.setURL("#");
		listNodeTree.wordLine = false;
		listNodeTree.setTarget("main");
		document.getElementById("nodeList").innerHTML=listNodeTree.toString();
		</script>';
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//根据条件显示树型菜单函数 listNodeByCon($con)
//$con是条件如：aa　like　‘%a%’
//=============================================
function listNodeByCon($con)
{
	try {
		$memberId = readSession();
		if($con!='')
		{
			if($con==1)//默认结点管理
			{
				$str = '<script language="javascript" type="text/javascript">';
				$str .= 'window.tree = new MzTreeView("tree");';
				$str .= 'tree.setIconPath("skin/images/treeImage/");';
				$str .= 'tree.N["0_aaaa"] = "T:站点根";';
				$sql="select * from {$GLOBALS['table']['cms']['site']} where isCommon =:isCommon and isDel=0";
				$params['isCommon'] = $con;
				$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				if(count($result)>0)
				{
					foreach ($result as $key => $val)
					{
						if($memberId!='admin')//no administrator
						{
							$groupIdArray = getGroupIdByStaffNo($memberId);
							if(checkDisplayNodeAuth($groupIdArray,$memberId,$val['nodeGuid'],'CKJD5tyQ'))
							{
								$url = "index.php?".encrypt_url("action=cms&method=editNode&nodeId=".$val['nodeId']);
								$str .='tree.N["aaaa_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';rightmethod:showNodeMenu(\''.$val['nodeId'].'\');target:mainFrame";'; 
							}else 
							{
								$url = "";
								$str .='tree.N["aaaa_'.$val['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$val['nodeName'].'</font>;url:'.$url.';rightmethod:showNodeMenu(\''.$val['nodeId'].'\');target:mainFrame";'; 
							}
						}else 
						{
							$url = "index.php".encrypt_url("action=cms&method=editNode&nodeId=".$val['nodeId']);
							$str .='tree.N["aaaa_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';rightmethod:showNodeMenu(\''.$val['nodeId'].'\');target:mainFrame";'; 
						}
					}
					//$str .= "document.write(d);</script>";
					$str .='tree.setURL("#");
					tree.wordLine = false;
					tree.setTarget("main");
					document.getElementById("listNodeByCon").innerHTML=tree.toString();
					</script>';
				}else
				{
					$str = '暂无默认操作';
				}
				return $str;
			}else
			{
				$str = '<script language="javascript" type="text/javascript">';
				$str .= 'window.tree = new MzTreeView("tree");';
				$str .= 'tree.setIconPath("../skin/images/treeImage/");';
				$str .= 'tree.N["0_bbbb"] = "T:站点根";';
				$sql="select * from {$GLOBALS['table']['cms']['site']} where isDel=0 and ".$con;
				$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				if(count($result)>0)
				{
					foreach ($result as $key => $val)
					{
						if($memberId!='admin')//no administrator
						{
							$groupIdArray = getGroupIdByStaffNo($memberId);
							if(checkDisplayNodeAuth($groupIdArray,$memberId,$val['nodeGuid'],'CKJD5tyQ'))
							{
								$url = "../index.php".encrypt_url("action=cms&method=editNode&nodeId=".$val['nodeId']);
								$str .='tree.N["bbbb_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';rightmethod:showNodeMenu(\''.$val['nodeId'].'\');target:mainFrame";'; 
							}else 
							{
								$url = "";
								$str .='tree.N["bbbb_'.$val['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$val['nodeName'].'</font>;url:'.$url.';rightmethod:showNodeMenu(\''.$val['nodeId'].'\');target:mainFrame";'; 
							}
						}else 
						{
							$url = "../index.php".encrypt_url("action=cms&method=editNode&nodeId=".$val['nodeId']);
							$str .='tree.N["bbbb_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';rightmethod:showNodeMenu(\''.$val['nodeId'].'\');target:mainFrame";'; 
						}
					}
					$str .='tree.setURL("#");
					tree.wordLine = false;
					tree.setTarget("main");
					document.getElementById("searchResult").innerHTML=tree.toString();
					</script>';
					$fileStr = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								<link rel="stylesheet" type="text/css" href="../skin/cssfiles/cms.css" />
                                <script language="javaScript" src="../skin/jsfiles/MzTreeView.js"></script>
                                <body>
                                <div id="searchResult"></div>'.$str."</body>";
					$mFile = $GLOBALS['currentApp']['tpl_complie_path']."seachNode.html";
					$fp = fopen($mFile,"w");
					fwrite($fp,$fileStr);
					fclose($fp);
					return "../cms/compile/seachNode.html";
				}else
				{
					$str = "无搜索结果";
					return $str;
				}
			}
		}else
		{
			$str = listNode();
			return $str;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 设置结点默认操作
 * */
function isDefaultNode($nodeId,$isDefault)
{
	try {
		if($isDefault=='')
		{
			$isDefault = 0;
		}
		$sql="update {$GLOBALS['table']['cms']['site']} set isCommon =:isCommon where nodeId =:nodeId";
		$params['nodeId'] = $nodeId;
		$params['isCommon'] =$isDefault;
		$result=TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 移动结点内容
 * */
function moveNode($nodeId,$parentId)
{
	try {
		$sql="update {$GLOBALS['table']['cms']['site']} set parentId =:parentId where nodeId =:nodeId";
		$params['nodeId'] = $nodeId;
		$params['parentId'] = $parentId;
		$result=TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * 基于结点内容
 * */
function nodeBase($nodeId,$baseNodeId)
{
	try {
		//取得基于点的基本信息
		$sql="select * from {$GLOBALS['table']['cms']['site']} where nodeGuid =:nodeGuid";
		$params['nodeGuid'] = $baseNodeId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if(!empty($result))
		{
			$nodeArray = $result[0];
			unset($nodeArray['nodeName']);
		}
		$sql = '';
		foreach ($nodeArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['site']} set $sql where nodeGuid=:nodeGuid";
		$nodeArray['nodeGuid'] = $nodeId;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$nodeArray);
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 结点排序
 * */
function sortNode($nodeId,$sortNodeNo)
{
	try {
		$sql = "update {$GLOBALS['table']['cms']['site']} set isOrder=:isOrder where nodeId=:nodeId";
		$nodeArray['nodeId'] = $nodeId;
		$nodeArray['isOrder'] = $sortNodeNo;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$nodeArray);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 根据结点ID获得结点内容
 * */
function getNodeInfoById($nodeId)
{
	try {
		$sql="select * from {$GLOBALS['table']['cms']['site']} where nodeId =:nodeId";
		$params['nodeId'] = $nodeId;
		//echo $params['nodeId'];
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * 根据结点标识获得结点内容
 * */
function getNodeInfomationByGuid($nodeGuid)
{
	try {
		$sql="select * from {$GLOBALS['table']['cms']['site']} where nodeGuid =:nodeGuid";
		$params['nodeGuid'] = $nodeGuid;
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 获得当前结点的父结点
 * **/
function getNodeParentById($nodeId,$str)
{
	try {
		$sql="select * from {$GLOBALS['table']['cms']['site']} where nodeGuid =:nodeGuid";
		$params['nodeGuid'] = $nodeId;
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//$str = "->".$result[0]['Name'].$str;

		if(!empty($result))
		{
			getNodeParentById($result[0]['parentId'],$result[0]['nodeName']);
		}
		if($str!='')
		{
			print ">>".$str;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 添加结点信息
 * **/
function addNode($nodeArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$nodeArray['memberId'] = readSession();
		$nodeArray['createDate'] = strtotime(date("Y-m-d H:i:s"));
		if($nodeArray['nodeGuid']==null)
		{
			$nodeGuid = fullNodeFlag($nodeArray['nodeName']);
			if(!checkNodeFlag($nodeGuid))
			{
				$nodeArray['nodeGuid'] = $nodeGuid;
			}
		}
		$getNodeinfo = getNodeInfomationByGuid($nodeArray['nodeGuid']);
		if(!empty($getNodeinfo))
		{
			return false;
		}
		$nodeArray['isDefaultCon'] = "nodeId='".$nodeArray['nodeGuid']."'";
		if($nodeArray['parentId']==null)
		{
			//$nodeArray['parentId'] = $nodeArray['nodeGuid'];
			$nodeArray['parentId'] = '0';
		}
		foreach ($nodeArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['site']} (".$str_field.") values (".$str_value.")";
		//print_r($sql);exit;
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$nodeArray);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 修改结点信息
 * **/
function editNode($nodeId,$nodeArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$oldNodeArray = getNodeInfoById($nodeId);//判断是否修改了结点的惟一标识
//		print_r($oldNodeArray);
		//print_r($nodeArray);exit;

		/*if($nodeArray['nodeGuid']!=$oldNodeArray[0]['nodeGuid'])
		{
			//修改该结点下所有子结点的所父结点号
			$sql = "update {$GLOBALS['table']['cms']['site']} set parentId='".$nodeArray['nodeGuid']."' where parentId=:parentId";
			$para['parentId'] = $oldNodeArray[0]['nodeGuid'];
			TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$para);
		}*/
		//$nodeArray['isDefaultCon'] = "nodeId='".$nodeArray['nodeGuid']."'";
		$sql = '';
		foreach ($nodeArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['site']} set $sql where nodeId=:nodeId";
		$nodeArray['nodeId'] = $nodeId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$nodeArray);
		$sqlpub = "update {$GLOBALS['table']['cms']['app_publish_state']} set appTableName='".$nodeArray['appTableName']."' where nodeId='".$nodeArray['nodeGuid']."'";
		//print $sqlpub;exit;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sqlpub,"");
		
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除结点 
 **/
function delNode($nodeId)
{
	try
	{
		date_default_timezone_set('PRC');
		//$sql = "delete from {$GLOBALS['table']['cms']['site']} where nodeId=:nodeId";
		//$nodeArray['nodeId'] = $nodeId;
		//print_r($nodeArray);print $sql;exit;
		//return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$nodeArray);
		$sql = "update {$GLOBALS['table']['cms']['site']} set isDel=1 where nodeId=:nodeId";
		$nodeArray['nodeId'] = $nodeId;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$nodeArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function listNodeAuth($nodeId)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['operation']} where nodeId=:nodeId order by operationId desc";
		$params['nodeId'] = $nodeInfo[0]['nodeGuid'];
		
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function saveNodeAuth($nodeId,$groupArray,$userArray)
{
	try {
//		print_r($groupArray);
//		print_r($userArray);exit;
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select actionGuid from {$GLOBALS['table']['cms']['app_actionconfig']} order by actionId desc";
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if(!empty($result))
		{
			foreach ($result as $key => $val)
			{
				$groupIdStr = '';
				$userIdStr = '';
				$checkAuth = checkNodeAuth($nodeInfo[0]['nodeGuid'],$val['actionGuid']);
				if(!empty($checkAuth))
				{
					updateNodeAuth($nodeInfo[0]['nodeGuid'],$groupArray['dataGroup'.$val['actionGuid']],$userArray['dataUser'.$val['actionGuid']],$val['actionGuid']);
				}else 
				{
					addNodeAuth($nodeInfo[0]['nodeGuid'],$groupArray['dataGroup'.$val['actionGuid']],$userArray['dataUser'.$val['actionGuid']],$val['actionGuid']);
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
 * 
 * */
function checkNodeAuth($nodeId,$authId)
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['operation']} where nodeId=:nodeId and operationCode=:operationCode";
		$params['nodeId'] = $nodeId;
		$params['operationCode'] = $authId;
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;		
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function checkNodeAuthGroupId($nodeId,$authId,$id,$type)
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['operation']} where nodeId=:nodeId and operationCode=:operationCode";
		$params['nodeId'] = $nodeId;
		$params['operationCode'] = $authId;
		$isTrue = false;
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if(!$type)//用户组
		{
			$groupIdArray = explode(',',$result[0]['groupId']);
			for ($i=0;$i<count($groupIdArray);$i++)
			{
				if($id==$groupIdArray[$i])
				{
					$isTrue = true;
				}
			}
		}else 
		{
			$userIdArray = explode(',',$result[0]['memberId']);
			for ($i=0;$i<count($userIdArray);$i++)
			{
				if($id==$userIdArray[$i])
				{
					$isTrue = true;
				}
			}
		}
		return $isTrue;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function addNodeAuth($nodeId,$groupStr,$userStr,$authId)
{
	try {
		$sql = "insert into {$GLOBALS['table']['cms']['operation']} (nodeId,memberId,groupId,operationCode) values (:nodeId,:memberId,:groupId,:operationCode)";
		$params['nodeId'] = $nodeId;
		$params['memberId'] = $userStr;
		$params['groupId'] = $groupStr;
		$params['operationCode'] = $authId;
		$result=TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;		
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function updateNodeAuth($nodeId,$groupStr,$userStr,$authId)
{
	try {
		$sql = "update {$GLOBALS['table']['cms']['operation']} set memberId=:memberId,groupId=:groupId where nodeId=:nodeId and operationCode=:operationCode";
		$params['nodeId'] = $nodeId;
		$params['memberId'] = $userStr;
		$params['groupId'] = $groupStr;
		$params['operationCode'] = $authId;
		$result=TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);	
	}catch (Exception $e)
	{
		throw $e;
	}
}
function uniDecode($str,$charcode){
	$text = preg_replace_callback("/%u[0-9A-Za-z]{4}/",toUtf8,$str);
	return $text;
}

//=============================================
//显示导出结点树型菜单函数 exportListNode()
//=============================================
function exportListNode()
{
	try {
		//提取一级菜单
		$sql="select * from {$GLOBALS['table']['cms']['site']} where parentId='0' order by nodeId";
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//如果一级菜单存在则开始菜单的显示dtree
//		if(count($result)>0)
//		{
//			$str = "<script type='text/javascript'>d = new dTree('d');d.add(0,-1,'根节点<img class=\'img\' src=\'images/img/folderopen.gif\' onclick=showHideNodeMenu(\'menu1\',\'\',\'show\',this,1) name=\'0\'>');";
//			foreach ($result as $key => $val)
//			{
//				$str .= "d.add('".$val['nodeGuid']."','".$val['parentId']."','<input type=checkbox style=\'width:10px; height: 10px;\' id=checkbox".$val['nodeGuid']." name=check class=".$val['parentId']." value=".$val['nodeGuid']." onclick=\'checkStatus(this.value,this)\'> ".$val['nodeName']."','','','');";
//			}
//		}
//		$str .= "document.write(d);</script>";
		//mztree
		if(count($result))
		{
			$str = '<script language="javascript" type="text/javascript">';
			$str .= 'window.exportTree = new MzTreeView("exportTree");';
			$str .= 'exportTree.setIconPath("skin/images/treeImage/");';
			$str .= 'exportTree.N["0_baseNode"] = "ctrl:sel;checked:0;T:站点根";';
			foreach ($result as $key => $val)
			{
				$str .='exportTree.N["baseNode_'.$val['nodeGuid'].'"] = "ctrl:sel;checked:0;T:'.$val['nodeName'].'";';
			}
			$sqlSub = "select * from {$GLOBALS['table']['cms']['site']} where parentId!='0' order by nodeId";
			$resultSub = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlSub,$params);
			foreach ($resultSub as $keySub => $valSub)
			{
				$str .='exportTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "ctrl:sel;checked:0;T:'.$valSub['nodeName'].'";'; 
			}
		}
		$str .='exportTree.setURL("#");
	exportTree.wordLine = false;
	exportTree.setTarget("main");
	document.getElementById("exportNode").innerHTML=exportTree.toString();
	</script>';
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//导出结点树型菜单函数 exportNode($exportNodeId)
//=============================================
function exportNode($exportNodeId)
{
	try {
		$getAllNodeIdArray = array();
		$nodeArray = explode(',',$exportNodeId);
		for($i=1;$i<count($nodeArray)-1;$i++)
		{
			if(!array_key_exists($nodeArray[$i],$getAllNodeIdArray))
			{
				$getAllNodeIdArray[$nodeArray[$i]] = $nodeArray[$i];
				//$currentNodeInfo = getNodeInfoById($nodeArray[$i]);
				$getAllNodeIdArray = getSubNodeByParentNode($nodeArray[$i],$nodeArray[$i],$getAllNodeIdArray);
			}
		}
		return createExportNodeFile($getAllNodeIdArray);
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//导入结点树型菜单函数 importNode()
//=============================================
function importNode()
{
	try {
		$upfilePath = uploadNideFile($GLOBALS['_FILES']);
		if($upfilePath)
		{
			$nodeInof = parseNodeXml($upfilePath);
			foreach ($nodeInof as $key => $val)
			{
				$isNodeExist = checkNodeExist($val['nodeGuid'],$val['nodeName']);
				if(empty($isNodeExist))//检查结点表中是不是有完全一样的结点
				{
					addNode($val);
				}
			}
			return true;
		}else
		{
			return false;
		}

		//return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//取得某一结点的所有子结点getSubNodeByParentNode($parentNodeId)
//=============================================
function getSubNodeByParentNode($nodeId,$parentNodeId,$getAllNodeIdArray)
{
	try {
		$sql="select nodeId,nodeGuid from {$GLOBALS['table']['cms']['site']} where parentId =:parentId";
		$params['parentId'] = $parentNodeId;
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if(!empty($result))
		{
			foreach ($result as $key => $val)
			{
				$getAllNodeIdArray[$val['nodeGuid']] = $val['nodeGuid'];
				$aaa = getSubNodeByParentNode($val['nodeGuid'],$val['nodeGuid'],$getAllNodeIdArray);
				if($aaa!=null)
				{
					$getAllNodeIdArray  = arrayMarge($aaa,$getAllNodeIdArray);
				}
			}
		}else
		{
			$getAllNodeIdArray[$nodeId] = $nodeId;
		}
		if(!empty($getAllNodeIdArray))
		{
			return array_unique($getAllNodeIdArray);
		}else
		{
			return null;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//取出所有结点的数据后，写入到xml文件中
//文件名怎么生成
//=============================================
function createExportNodeFile($allExportNodeIdArray)
{
	try {
		if(!empty($allExportNodeIdArray))
		{
			$fileName = "nodeInfo".date("YmdHis").".xml";
			$fileName = $GLOBALS['currentApp']['apppath'].'/export/nodexml/'.$fileName;
			if($fp =fopen($fileName, 'w'))
			{
				$typeFile = '<?xml version="1.0" encoding="UTF-8"?>';
				$nodesStart ='<nodes>';
				fwrite($fp, $typeFile."\r\n");
				fwrite($fp, $nodesStart."\r\n");
				foreach ($allExportNodeIdArray as $key => $val)
				{
					$sql="select * from {$GLOBALS['table']['cms']['site']} where nodeGuid =:nodeGuid";
					$params['nodeGuid'] = $val;
					$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
					if(!empty($result))
					{
						foreach ($result as $key => $val)
						{
							$nodeStart ='<node id="'.$val['nodeId'].'">';
							fwrite($fp, "    ".$nodeStart."\r\n");
							$parentId ="<parentId>".$val['parentId']."</parentId>";
							fwrite($fp, "        ".$parentId."\r\n");
							$nodeName ="<nodeName>".$val['nodeName']."</nodeName>";
							fwrite($fp, "        ".$nodeName."\r\n");
							$nodeTitle ="<nodeTitle>".$val['nodeTitle']."</nodeTitle>";
							fwrite($fp, "        ".$nodeTitle."\r\n");
							$nodeGuid ="<nodeGuid>".$val['nodeGuid']."</nodeGuid>";
							fwrite($fp, "        ".$nodeGuid."\r\n");
							$contentURL ="<contentURL>".$val['contentURL']."</contentURL>";
							fwrite($fp, "        ".$contentURL."\r\n");
							$publishMode ="<publishMode>".$val['publishMode']."</publishMode>";
							fwrite($fp, "        ".$publishMode."\r\n");
							$indexTpl ="<indexTpl>".$val['indexTpl']."</indexTpl>";
							fwrite($fp, "        ".$indexTpl."\r\n");
							$indexName ="<indexName>".$val['indexName']."</indexName>";
							fwrite($fp, "        ".$indexName."\r\n");
							$contentTpl ="<contentTpl>".$val['contentTpl']."</contentTpl>";
							fwrite($fp, "        ".$contentTpl."\r\n");
							$imageTpl ="<imageTpl>".$val['imageTpl']."</imageTpl>";
							fwrite($fp, "        ".$imageTpl."\r\n");
							$subDir ="<subDir>".$val['subDir']."</subDir>";
							fwrite($fp, "        ".$subDir."\r\n");
							$publishFileFormat ="<publishFileFormat>".$val['publishFileFormat']."</publishFileFormat>";
							fwrite($fp, "        ".$publishFileFormat."\r\n");
							$nodeAttr ="<nodeAttr>".$val['nodeAttr']."</nodeAttr>";
							fwrite($fp, "        ".$nodeAttr."\r\n");
							$fieldConfigId ="<fieldConfigId>".$val['fieldConfigId']."</fieldConfigId>";
							fwrite($fp, "        ".$fieldConfigId."\r\n");
							$contentEditPlan ="<contentEditPlan>".$val['contentEditPlan']."</contentEditPlan>";
							fwrite($fp, "        ".$contentEditPlan."\r\n");
							$appTableName ="<appTableName>".$val['appTableName']."</appTableName>";
							fwrite($fp, "        ".$appTableName."\r\n");
							$contentEditPlan ="<contentEditPlan>".$val['contentEditPlan']."</contentEditPlan>";
							fwrite($fp, "        ".$contentEditPlan."\r\n");
							$contentPlanId ="<contentPlanId>".$val['contentPlanId']."</contentPlanId>";
							fwrite($fp, "        ".$contentPlanId."\r\n");
							$appTableKeyName ="<appTableKeyName>".$val['appTableKeyName']."</appTableKeyName>";
							fwrite($fp, "        ".$appTableKeyName."\r\n");
							$isDefaultCon ="<isDefaultCon>".$val['isDefaultCon']."</isDefaultCon>";
							fwrite($fp, "        ".$isDefaultCon."\r\n");
							$appWhereSQL ="<appWhereSQL>".$val['appWhereSQL']."</appWhereSQL>";
							fwrite($fp, "        ".$appWhereSQL."\r\n");
							$appInsertArray ="<appInsertArray>".$val['appInsertArray']."</appInsertArray>";
							fwrite($fp, "        ".$appInsertArray."\r\n");
							$appValidArray ="<appValidArray>".$val['appValidArray']."</appValidArray>";
							fwrite($fp, "        ".$appValidArray."\r\n");
							$indexPortalURL ="<indexPortalURL>".$val['indexPortalURL']."</indexPortalURL>";
							fwrite($fp, "        ".$indexPortalURL."\r\n");
							$page ="<page>".$val['page']."</page>";
							fwrite($fp, "        ".$page."\r\n");
							$isOrder ="<isOrder>".$val['isOrder']."</isOrder>";
							fwrite($fp, "        ".$isOrder."\r\n");
							$isDel ="<isDel>".$val['isDel']."</isDel>";
							fwrite($fp, "        ".$isDel."\r\n");
							$appName ="<appName>".$val['appName']."</appName>";
							fwrite($fp, "        ".$appName."\r\n");
							$appUrl ="<appUrl>".$val['appUrl']."</appUrl>";
							fwrite($fp, "        ".$appUrl."\r\n");
							$nodeEnd ='</node>';
							fwrite($fp, "    ".$nodeEnd."\r\n");
						}
					}
				}
				$nodesEnd ='</nodes>';
				fwrite($fp, $nodesEnd."\r\n");
			}
			fclose($fp);
		}
		return $fileName;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//检查结点标识是否存在
//=============================================
function checkNodeFlag($nodeFlag)
{
	try {
		$sql="select nodeId from {$GLOBALS['table']['cms']['site']} where nodeGuid =:nodeGuid";
		$params['nodeGuid'] = $nodeFlag;
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//自动生成结点标识
//=============================================
function fullNodeFlag($nodeName)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($nodeName);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//生成随机数
//=============================================
function random($length, $numeric = 0) {
	//PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if ($numeric) {
		$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	} else {
		$hash = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$max = strlen($chars) - 1;
		for ($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}
//=============================================
//合并数组，其键值不变
//=============================================
function arrayMarge($newArray,$oldArray)
{
	try {
		foreach ($newArray as $key => $val)
		{
			$oldArray[$key] = $val;
		}
		return $oldArray;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * 上传结点文件
 * $uploadFileo为上传的源文件
 * */
function uploadNideFile($upLoadFile)
{
	try {
		@header("Content-Type:text/html;charset=utf-8");
		$TimeLimit=60; /*设置超时限制时间 缺省时间为30秒 设置为0时为不限时 */
		set_time_limit($TimeLimit);
		if($upLoadFile)
		{
			foreach ($upLoadFile as $k=>$v)
			{
				$upLoadPath = $GLOBALS['currentApp']['apppath'].'/import/nodexml/';//以会员的账户创建一个文件夹
				//文件夹转码
				$upLoadPath = iconv('utf-8','gb2312',$upLoadPath);
				$ascllClass = new ascii();
				$fileName=$upLoadPath.$v['name']; //上传文件名
				$fileName = iconv('utf-8','gb2312',$fileName);
				if(!file_exists($fileName))
				{
					if(copy($v['tmp_name'],$fileName))
					{
						return $fileName;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return $fileName;
				}
			}
		}
		else
		{
			return false;
		}
	}catch (Exception $e){
		throw $e;
	}
}
//=============================================
//解析结点xml文件，返回数据
//=============================================
function parseNodeXml($fileName)
{
	if (($fileName=='')||($fileName==null))
	{
		return "";
	}
	$content="";
	try {
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName=='nodes')
		{
			$dsList=$tree->GetElementsByTagName('node');
			$total=count($dsList);
			$nodeInfo=array();
			for ($i=0;$i<$total;$i++)
			{
				$childList=$dsList[$i]->GetChild();
				$listCount=count($childList);
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=='parentId')
					{
						$nodeInfo[$i]['parentId']=$childList[$j]->data;
					}
					elseif  ($childList[$j]->TagName=='nodeName')
					{
						$nodeInfo[$i]['nodeName']=$childList[$j]->data;
					}
					elseif  ($childList[$j]->TagName=='nodeTitle')
					{
						$nodeInfo[$i]['nodeTitle']=$childList[$j]->data;
					}
					elseif  ($childList[$j]->TagName=='nodeGuid')
					{
						$nodeInfo[$i]['nodeGuid']=$childList[$j]->data;
					}
					elseif  ($childList[$j]->TagName=='contentURL')
					{
						$nodeInfo[$i]['contentURL']=$childList[$j]->data;
					}
					elseif  ($childList[$j]->TagName=='publishMode')
					{
						$nodeInfo[$i]['publishMode']=$childList[$j]->data;
					}
					elseif  ($childList[$j]->TagName=='indexTpl')
					{
						$dbConfig[$i]['indexTpl']=$childList[$j]->data;
					}
					elseif  ($childList[$j]->TagName=='indexName')
					{
						$nodeInfo[$i]['indexName']=$childList[$j]->data;
					}elseif ($childList[$j]->TagName=='contentTpl')
					{
						$nodeInfo[$i]['contentTpl']=$childList[$j]->data;
					}elseif ($childList[$j]->TagName=='imageTpl')
					{
						$nodeInfo[$i]['imageTpl']=$childList[$j]->data;
					}elseif ($childList[$j]->TagName=='subDir')
					{
						$nodeInfo[$i]['subDir']=$childList[$j]->data;
					}elseif ($childList[$j]->TagName=='publishFileFormat')
					{
						$nodeInfo[$i]['publishFileFormat']=$childList[$j]->data;
					}elseif ($childList[$j]->TagName=='nodeAttr')
					{
						$nodeInfo[$i]['nodeAttr']=$childList[$j]->data;
					}elseif ($childList[$j]->TagName=='fieldConfigId')
					{
						$nodeInfo[$i]['fieldConfigId']=$childList[$j]->data;
					}elseif ($childList[$j]->TagName=='contentEditPlan')
					{
						$nodeInfo[$i]['contentEditPlan']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='appTableName')
					{
						$nodeInfo[$i]['appTableName']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='contentPlanId')
					{
						$nodeInfo[$i]['contentPlanId']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='appTableKeyName')
					{
						$nodeInfo[$i]['appTableKeyName']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='isDefaultCon')
					{
						$nodeInfo[$i]['isDefaultCon']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='appWhereSQL')
					{
						$nodeInfo[$i]['appWhereSQL']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='appInsertArray')
					{
						$nodeInfo[$i]['appInsertArray']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='appValidArray')
					{
						$nodeInfo[$i]['appValidArray']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='indexPortalURL')
					{
						$nodeInfo[$i]['indexPortalURL']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='page')
					{
						$nodeInfo[$i]['page']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='isOrder')
					{
						$nodeInfo[$i]['isOrder']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='isDel')
					{
						$nodeInfo[$i]['isDel']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='appName')
					{
						$nodeInfo[$i]['appName']=$childList[$j]->data;
					}
					elseif ($childList[$j]->TagName=='appUrl')
					{
						$nodeInfo[$i]['appUrl']=$childList[$j]->data;
					}
				}
			}
			unset($dsList);
			return $nodeInfo;
		}

	}
	catch (FileException $e)
	{
		throw $e;
	}
}
//=============================================
//检查导入的结点的标识和结点名是不是已经存在
//checkNodeExist
//=============================================
function checkNodeExist($nodeGuid,$nodeName)
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['site']} where nodeGuid=:nodeGuid and nodeName=:nodeName";
		$params['nodeGuid'] = $nodeGuid;
		$params['nodeName'] = $nodeName;
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//检查导入的结点的标识是不是已经存在
//checkNodeFlag
//=============================================
//function checkNodeFlag($nodeGuid)
//{
//	try {
//		$sql = "selcet * from {$GLOBALS['table']['cms']['site']} where nodeGuid=:nodeGuid";
//		$params['nodeGuid'] = $nodeGuid;
//		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
//		return $result;
//	}catch (Exception $e)
//	{
//		throw $e;
//	}
//}
//=============================================
//检查导入的结点的标识是不是已经存在
//checkNodeFlag
//=============================================
function createNodeXml()
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['site']} where parentId =:parentId";
		$params['parentId'] = '0';
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$fileName = 'D:/xampp/htdocs/commoncms/cms/tree.xml';
		if($fp =fopen($fileName, 'w'))
		{
			$str .= '<?xml version="1.0" encoding="UTF-8"?>';
			$str .='<tree id="0">';
			if(!empty($result))
			{
				foreach ($result as $key => $val)
				{
					$subStr='';
					$str .='<item text="'.$val['nodeName'].'" id="'.$val['nodeId'].'" open="1" im0="tombs.gif" im1="tombs.gif" im2="iconSafe.gif" call="1" select="1">';
					$subStr = getNodeInfoByGuid($val['nodeId'],$val['nodeGuid'],$val['nodeName'],$subStr,'0');
					$str .=$subStr.'</item>';
				}
			}
			$str .='</tree>';
			//print_r($str);
			fwrite($fp, $str."\r\n");
			fclose($fp);
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//检查导入的结点的标识是不是已经存在
//checkNodeFlag
//=============================================
function getNodeInfoByGuid($nodeId,$nodeGuid,$nodeName,$str,$flag)
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['site']} where parentId=:parentId";
		$params['parentId'] = $nodeGuid;
		$tempstr .= $str;
		$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if(!empty($result))
		{
			if($flag=='1')
			{	
				if(strpos('aaa'.$str,'<item text="'.$nodeName.'" id="'.$nodeId.'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">')>0)
				{
					foreach ($result as $key => $val)
					{
						$str.='<item text="'.$val['nodeName'].'" id="'.$val['nodeId'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">';
						$str =getNodeInfoByGuid($val['nodeId'],$val['nodeGuid'],$val['nodeName'],$str,'1');
						$str.="</item>";
					}
				}else 
				{
					$str .='<item text="'.$nodeName.'" id="'.$nodeId.'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">';
					foreach ($result as $key => $val)
					{	
						$str.='<item text="'.$val['nodeName'].'" id="'.$val['nodeId'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">';
						$str =getNodeInfoByGuid($val['nodeId'],$val['nodeGuid'],$val['nodeName'],$str,'1');
						$str.="</item>";
					}
					$str .="</item>";
				}
			}elseif ($flag=='0')
			{
				foreach ($result as $key => $val)
				{
					$str.='<item text="'.$val['nodeName'].'" id="'.$val['nodeId'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">';
					$str =getNodeInfoByGuid($val['nodeId'],$val['nodeGuid'],$val['nodeName'],$str,'1');
					$str.="</item>";
				}
			}
		}else 
		{
				$str =str_replace('<item text="'.$nodeName.'" id="'.$nodeId.'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">','',$str);
				$str .= '<item text="'.$nodeName.'" id="'.$nodeId.'" im0="book_titel.gif" im1="book.gif" im2="book_titel.gif">';
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//根据结点的惟一标识获得结点的所有信息
function getNodeInfoByNodeGuid($nodeGuid)
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['site']} where nodeGuid=:nodeGuid";
		$params['nodeGuid'] = $nodeGuid;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>