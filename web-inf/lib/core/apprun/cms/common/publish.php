<?
/**
 * add zxqer 20081119
 * 该文件主要用来设置通用ＣＭＳ的发布结点管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.node');
import('core.apprun.cms.node_auth');
//=============================================
//显示树型菜单函数 listPublishNode()
//=============================================
function listPublishNode()
{
	try {
		//提取一级菜单
		$sqlNode="select * from {$GLOBALS['table']['cms']['site']} where parentId='0' and isDel=0 order by nodeId";
		$resultNode=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlNode,$params);
		//如果一级菜单存在则开始菜单的显示
		$memberId = readSession();
		$groupIdArray = getGroupIdByStaffNo($memberId);
		$str = '<script language="javascript" type="text/javascript">';
		$str .= 'window.listPublishNodeTree = new MzTreeView("listPublishNodeTree");';
		$str .= 'listPublishNodeTree.setIconPath("skin/images/treeImage/");';
		$str .= 'listPublishNodeTree.N["0_publishBaseNode"] = "T:站点根;rightmethod:showRightMenu(\'publish\',\'menuBase\',\'0\')";';
		if(count($resultNode)>0)
		{
			$parmsStr = '';
			foreach ($resultNode as $key => $val)
			{
//				print checkParentAuth('molixuetang');
//				exit;
				if($memberId!='admin')//不是系统超级管理员
				{
					if(checkDisplayNodeAuth($groupIdArray,$memberId,$val['nodeGuid'],'CKJD5tyQ'))
					{
						$parmsStr = "action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame&";
						$url = "index.php".encrypt_url($parmsStr."nodeId=".$val['nodeId']);
						$str .='listPublishNodeTree.N["publishBaseNode_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';rightmethod:showRightMenu(\'publish\',\'menu\',\''.$val['nodeId'].'\');target:mainFrame";';
					}else 
					{
						$parmsStr = "";
						$url = "";
						
						if(checkParentAuth($val['nodeGuid']))
						{
							$str .='listPublishNodeTree.N["publishBaseNode_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';target:mainFrame";';
						}else 
						{
							$str .='listPublishNodeTree.N["publishBaseNode_'.$val['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$val['nodeName'].'</font>;url:'.$url.';target:mainFrame";';
						}
					}
				}else //系统超级管理员
				{
					$parmsStr = "action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame&";
					$url = "index.php".encrypt_url($parmsStr."nodeId=".$val['nodeId']);
					$str .='listPublishNodeTree.N["publishBaseNode_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';rightmethod:showRightMenu(\'publish\',\'menu\',\''.$val['nodeId'].'\');target:mainFrame";';
				}
			}
			//exit;
			$sqlSub = "select * from {$GLOBALS['table']['cms']['site']} where parentId!='0' and isDel=0 order by nodeId";
			$resultSub = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlSub,$params);
			$parmsStr = '';
			foreach ($resultSub as $keySub => $valSub)
			{
				if($memberId!='admin')//不是系统的超级管理员
				{				
					if(checkDisplayNodeAuth($groupIdArray,$memberId,$valSub['nodeGuid'],'CKJD5tyQ')||checkDisplayNodeAuth($groupIdArray,$memberId,$valSub['parentId'],'CKJD5tyQ'))
					{
						$parmsStr = "action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame&";
						$url = "index.php".encrypt_url($parmsStr."nodeId=".$valSub['nodeId']);
						if($val['isCommon'])
						{
							$str .='listPublishNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';icon:images/img/folderopen.gif;url:'.$url.';rightmethod:showRightMenu(\'publish\',\'menu\',\''.$valSub['nodeId'].'\');target:mainFrame";';
						}else
						{
							$str .='listPublishNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';icon:images/img/folderopen.gif;url:'.$url.';rightmethod:showRightMenu(\'publish\',\'menu\',\''.$valSub['nodeId'].'\');target:mainFrame";';
						}
					}else 
					{
						$parmsStr = "";
						$url = "";
						if(checkParentAuth($valSub['nodeGuid']))
						{
							if($val['isCommon'])
							{
								$str .='listPublishNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';icon:images/img/folderopen.gif;url:'.$url.';target:mainFrame";';
							}else
							{
								$str .='listPublishNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';icon:images/img/folderopen.gif;url:'.$url.';target:mainFrame";';
							}
						}else 
						{
							if($val['isCommon'])
							{
								$str .='listPublishNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$valSub['nodeName'].'</font>;icon:images/img/folderopen.gif;url:'.$url.';target:mainFrame";';
							}else
							{
								$str .='listPublishNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$valSub['nodeName'].'</font>;icon:images/img/folderopen.gif;url:'.$url.';target:mainFrame";';
							}
						}
					}
					
				}else //系统超级管理员
				{
					$parmsStr = "action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame&";
					$url = "index.php".encrypt_url($parmsStr."nodeId=".$valSub['nodeId']);
					if($val['isCommon'])
					{
						$str .='listPublishNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';icon:images/img/folderopen.gif;url:'.$url.';rightmethod:showRightMenu(\'publish\',\'menu\',\''.$valSub['nodeId'].'\');target:mainFrame";';
					}else
					{
						$str .='listPublishNodeTree.N["'.$valSub['parentId'].'_'.$valSub['nodeGuid'].'"] = "T:'.$valSub['nodeName'].';icon:images/img/folderopen.gif;url:'.$url.';rightmethod:showRightMenu(\'publish\',\'menu\',\''.$valSub['nodeId'].'\');target:mainFrame";';
					}
				}
			}
		}
		$str .='listPublishNodeTree.setURL("#");
		listPublishNodeTree.wordLine = false;
		listPublishNodeTree.setTarget("main");
		document.getElementById("publishListNode").innerHTML=listPublishNodeTree.toString();
		</script>';
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//根据条件显示树型菜单函数 listPublishNodeByCon($con)
//$con是条件如：aa　like　‘%a%’
//=============================================
function listPublishNodeByCon($con)
{
	try {
		$memberId = readSession();
		if($con!='')
		{
			if($con==1)//默认发布结点
			{
				$str = '<script language="javascript" type="text/javascript">';
				$str .= 'window.listPublishDefaultNodeTree = new MzTreeView("listPublishDefaultNodeTree");';
				$str .= 'listPublishDefaultNodeTree.setIconPath("skin/images/treeImage/");';
				$str .= 'listPublishDefaultNodeTree.N["0_publishDefault"] = "T:站点根";';
				$sql="select * from {$GLOBALS['table']['cms']['site']} where isCommon =:isCommon and isDel=0";
				$params['isCommon'] = $con;
				$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				if(count($result)>0)
				{

					foreach ($result as $key => $val)
					{
						if($memberId!='admin')//不是系统超级管理员
						{
							$groupIdArray = getGroupIdByStaffNo($memberId);
							if(checkDisplayNodeAuth($groupIdArray,$memberId,$val['nodeGuid'],'CKJD5tyQ'))
							{
								$parmsStr = "action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame&";
								$url = "index.php".encrypt_url($parmsStr."nodeId=".$val['nodeId']);
								$str .='listPublishDefaultNodeTree.N["publishDefault_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';target:mainFrame";';
							}else 
							{
								$parmsStr = "";
								$url = "";
								$str .='listPublishDefaultNodeTree.N["publishDefault_'.$val['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$val['nodeName'].'</font>;url:'.$url.';target:mainFrame";';
							}
							
						}else //系统超级管理员
						{
							$parmsStr = "action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame&";
							$url = "index.php".encrypt_url($parmsStr."nodeId=".$val['nodeId']);
							$str .='listPublishDefaultNodeTree.N["publishDefault_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';target:mainFrame";';
						}
					}
					$str .='listPublishDefaultNodeTree.setURL("#");
					listPublishDefaultNodeTree.wordLine = false;
					listPublishDefaultNodeTree.setTarget("main");
					document.getElementById("publishDefaultNode").innerHTML=listPublishDefaultNodeTree.toString();
					</script>';
				}else
				{
					$str = '暂无默认操作';
				}
				return $str;
			}else
			{
				$sql="select * from {$GLOBALS['table']['cms']['site']} where isDel=0 and ".$con."";
				$result=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				if(count($result)>0)
				{
					$str = '<script language="javascript" type="text/javascript">';
					$str .= 'window.listPublishDefaultNodeTree = new MzTreeView("listPublishDefaultNodeTree");';
					$str .= 'listPublishDefaultNodeTree.setIconPath("../skin/images/treeImage/");';
					$str .= 'listPublishDefaultNodeTree.N["0_publishDefault"] = "ctrl:sel;checked:0;T:站点根";';
					foreach ($result as $key => $val)
					{
						if($memberId!='admin')//不是系统超级管理员
						{
							$groupIdArray = getGroupIdByStaffNo($memberId);
							if(checkDisplayNodeAuth($groupIdArray,$memberId,$val['nodeGuid'],'CKJD5tyQ'))
							{
								$parmsStr = "action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame&";
								$url = "../index.php".encrypt_url($parmsStr."nodeId=".$val['nodeId']);
								$str .='listPublishDefaultNodeTree.N["publishDefault_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';target:mainFrame";';
							}else 
							{
								$parmsStr = "";
								$url = "";
								$str .='listPublishDefaultNodeTree.N["publishDefault_'.$val['nodeGuid'].'"] = "T:<font color=B2B1B1>'.$val['nodeName'].'</font>;url:'.$url.';target:mainFrame";';
							}
							
						}else //系统超级管理员
						{
							$parmsStr = "action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame&";
							$url = "../index.php".encrypt_url($parmsStr."nodeId=".$val['nodeId']);
							$str .='listPublishDefaultNodeTree.N["publishDefault_'.$val['nodeGuid'].'"] = "T:'.$val['nodeName'].';url:'.$url.';target:mainFrame";';
						}
						
					}
					$str .='listPublishDefaultNodeTree.setURL("#");
					listPublishDefaultNodeTree.wordLine = false;
					listPublishDefaultNodeTree.setTarget("main");
					document.getElementById("publishDefaultNode").innerHTML=listPublishDefaultNodeTree.toString();
					</script>';
					$fileStr = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								<link rel="stylesheet" type="text/css" href="../skin/cssfiles/cms.css" />
                                <script language="javaScript" src="../skin/jsfiles/MzTreeView.js"></script>
                                <body>
                                <div id="publishDefaultNode"></div>'.$str."</body>";
					$mFile = $GLOBALS['currentApp']['tpl_complie_path']."seachPublishNode.html";
					$fp = fopen($mFile,"w");
					fwrite($fp,$fileStr);
					fclose($fp);
					return "../cms/compile/seachPublishNode.html";
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
?>