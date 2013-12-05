<?
/**
 * add zxqer 20081118
 * 该文件主要用来设置通用ＣＭＳ的列表管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.common.input_operation');
import('core.apprun.cms.node');
import('core.apprun.cms.publish');
import('core.apprun.cms.common.page');
import('core.apprun.cms.common.common');
import('core.param.param');
import('core.apprun.cms.spell_class');
import('core.apprun.cms.action');
/**
 *通用CMS列表显示
 **/
function listStr($nodeId,$fieldConfigId,$contentModel,$tableKeyName,$tableCon)
{
	try
	{
		if($GLOBALS['IN']['currentPage']!=''){
			$params['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else
		{
			$params['currentPage'] = 1;
		}
		$nodeInfo = getNodeInfoById($nodeId);//取得该结点号为$nodeId的所有配置
		$pageInfo = getPageInfo($nodeId);//取得每列显示多少行
		$params['pageSize'] = $pageInfo['pageSize'];
		if($fieldConfigId!=''&&$contentModel!=''&&$tableKeyName!='')
		{
			$sql = "select * from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId = :fieldConfigId and isDisplayHeader =:isDisplayHeader  order by fieldId";
			$param['fieldConfigId'] = $fieldConfigId;
			$param['isDisplayHeader'] = '1';
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
			$tableHeadStr ='<table class="tableList" border="1" id="list" width="100%">';
			$tableHeadStr .="<tr>";
			$tableHeadStr .= '<td class="listHeader" width="60px"><input type="checkbox" id="all" onclick="selectAll(\'selectAll\',this.id,\'checks\');"><span id="selectAll" name="" style="cursor:pointer" onclick="selectAll(this.id,\'all\',\'checks\');">全选</span></td>';
			foreach ($result as $key => $val)
			{
				if($val['tableHeadWidth']!='0')
				{
					$width = 'width="'.$val['tableHeadWidth'].'px"';
				}
				$tableHeadStr .= '<td class="listHeader" '.$width.'>'.$val['fieldTitle'].'</td>';
				$select .= 'a.'.$val['fieldName'].',';
				$fieldDefaultStr  .= $val['fieldDefaultValue'].',';
				$fieldInputPickerStr  .= $val['fieldInputPicker'].',';

				$fieldListExpStr .= $val['fieldDescription'].'_ET_'; //列表显示字段的自定义表达式，add by easyt,2009.7.19, 暂时先用备注字段，等张小权重新加字段后再修改

			}
			$select = 'a.'.$tableKeyName.','.$select."b.top,b.pink,b.sort,b.publishDate,b.state";//要查找的字段
			$fieldDefaultStr  = ' ,'.substr($fieldDefaultStr,0,-1);//查看字段的默认值
			$fieldInputPickerStr  = ' ,'.substr($fieldInputPickerStr,0,-1);//查看字段辅助类型

			$fieldListExpStr  = '_ET_'.substr($fieldListExpStr,0,-4);//列表显示字段的自定义表达式,字串处理，add by easyt,2009.7.19

			$tableHeadStr .= '<td class="listHeader" width="26px">置顶</td>';
			$tableHeadStr .= '<td class="listHeader" width="26px">精华</td>';
			$tableHeadStr .= '<td class="listHeader" width="26px">权重</td>';
			$tableHeadStr .= '<td class="listHeader" width="150px">发布时间</td>';
			$tableHeadStr .= '<td class="listHeader" width="50px">状态</td>';
			$tableHeadStr .= '<td class="listHeader" width="320px">执行操作</td></tr>';
			if( !empty($nodeInfo[0]['isDefaultCon']) )//结点默认条件, modify by easyt,2009.7.19,修改判断为空的方式，null和空串都支持
			{
				$nodeCon = " a.".$nodeInfo[0]['isDefaultCon'];
			}
			if( !empty($nodeInfo[0]['appWhereSQL']) )//用户自己定义的结点条件, modify by easyt,2009.7.19,修改判断为空的方式，null和空串都支持
			{
				$nodeCon = '1=1 '.explodeVerifyData($nodeInfo[0]['appWhereSQL'],0); //modify by easyt,2009.7.19,修改为如果有自定义条件就不要默认条件
			}
			//modify by easyt,2009.7.19
			if($tableCon!='')
			{
				$whereCon = $nodeCon." and ".$tableCon;
			}else{
				$whereCon = $nodeCon;
			}
			if($whereCon!='')
			{
				$whereCon .= " and b.isDel=0";
			}
			//echo $whereCon;
			//$sql = "select ".$select." from ".$contentModel." a , {$GLOBALS['table']['cms']['app_publish_state']} b where ".$whereCon;
			//$sql = $sql." and a.".$tableKeyName."=b.contentId and a.nodeId=b.nodeId order by b.sort desc,b.state,b.top desc,b.pink desc,a.".$tableKeyName." desc";
			$sql = <<<EOT
SELECT {$select} FROM {$contentModel} a LEFT JOIN {$GLOBALS['table']['cms']['app_publish_state']} b ON a.{$tableKeyName} = b.contentId AND a.nodeId = b.nodeId WHERE {$whereCon} ORDER BY b.sort DESC , b.state, b.top DESC , b.pink DESC , a.{$tableKeyName} DESC
EOT;
			//上面修改关联发布状态表的方式改为left join方式，不管状态表有无记录都列出所有内容表记录

			$selectArray = explode(',',$select); //把字段名列表转为数组
			$fieldDefaultArray = explode(',',$fieldDefaultStr); //把字段默认值列表转为数组
			$fieldInputPickerArray = explode(',',$fieldInputPickerStr); //把字段输入采集器列表转为数组
			$fieldListExp = explode('_ET_',$fieldListExpStr); //把字段列表显示自定义表达式转为数组
			//modify by easyt,end

			$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			foreach ($result['data'] as $key => $val)
			{
				$tableContentStr .= "<tr>";
				$tableContentStr .= '<td class="tdListItem" width="50"><input type="checkbox" name="checks" value="'.$val[$tableKeyName].'" onclick="selectConCheck(\'checks\')"></td>';
				for($i=1;$i<count($selectArray);$i++)
				{
					$selectFieldName = substr($selectArray[$i],2);//去掉字段名的前缀如：a.staff变成staff， 修正了一个逻辑BUG，循环每次都会去掉字段名数组的头两位
					if($fieldDefaultArray[$i]!='')//显示字段默认值
					{
						$checkTemVal = '';
						$checkBoxArray = explode(',',$val[$selectFieldName]);//数据表中实际值
						$fieldDefaulValue = explode(';',$fieldDefaultArray[$i]);
						foreach($checkBoxArray as $chKey => $chVal)
						{
							if(strpos('aaa'.$fieldDefaultArray[$i],$chVal.':')>0)
							{
								foreach($fieldDefaulValue as $FDVKey => $FDVVal)
								{
									$aaArray = explode(':',$FDVVal);
									if($aaArray[0]==$chVal)
									{
										$checkTemVal = $checkTemVal.$aaArray[1].',';
									}
								}
								if(substr($checkTemVal,strlen($checkTemVal)-1,strlen($checkTemVal))==',')//判断字符串后面是否以逗号隔开
								{
									$checkTemVal = substr($checkTemVal,0,-1);
								}
							}else
							{
								$checkTemVal = $fieldDefaulValue[$val[$selectFieldName]];
							}
						}

						$tableContentStr .= '<td class="tdListItem" '.$width.'>'.$checkTemVal.'</td>';
					}else if($fieldListExp[$i]!='')//自定义SQL执行取数据 modify zxq 20110730
					{
						$selfSqlArray = getFieldInfoBySql($fieldListExp[$i],$val[$selectFieldName]);
						if(!empty($selfSqlArray['data']))
						{
							foreach ($selfSqlArray['data'] as $sqlKey => $sqlVal)
							{
								$sqlSubNum=0;
								foreach ($sqlVal as $sqlSubKey => $sqlSubVal)
								{
									if($sqlSubNum==1)
									{
										$checkTemVal = $sqlSubVal;
									}
									$sqlSubNum++;
								}
							}
						}
						$tableContentStr .= '<td class="tdListItem" '.$width.'>'.$checkTemVal.'</td>';
					}else
					{
						if($fieldInputPickerArray[$i]=='upload')//上传图片显示
						{
							$tableContentStr .= '<td class="tdListItem" '.$width.'><img src="'.$GLOBALS['currentApp']['resconfig']['publicPost'].$val[$selectFieldName].'" width="20" height="20"></td>';
						}else
						{
							if($selectFieldName=='state')//取得发布状态
							{
								if($val[$selectFieldName]=='1')
								{
									$stateStr = "已发布";
								}else
								{
									$stateStr = "待发布";
								}
								$tableContentStr .='<td class="tdListItem" >'.$stateStr.'</td>';
							}elseif ($selectFieldName=='publishDate')//取得发布时间
							{
								$tableContentStr .='<td class="tdListItem" >'.date("Y-m-d H:i:s",$val[$selectFieldName]).'</td>';
							}
							else
							{
								//处理列表显示自定义表达式，add by easyt,2009.7.19
								$fieldDisplayVal = $val[$selectFieldName];
								if( !empty($fieldListExp[$i]) ) {
									$tmpVal = $val[$selectFieldName];
									$tmpExp = str_replace(array('[this]','[THIS]'),'$tmpVal',$fieldListExp[$i]); //将设置的自定义表达式中[this]换为当前字段
									@eval( '$fieldDisplayVal = ' . $tmpExp . ';' );
								}
								//判断该字段是不是有显示右击菜单
								$isDisplayMenu = isDisplayRightMenu($selectFieldName,$fieldConfigId);
								if($isDisplayMenu)
								{
									$rightMenu = "<span oncontextmenu=\"showContentRightMenu('contentRightMenu','contentRightMenu',".$val[$tableKeyName].");\" style=\"cursor:pointer\">".CsubStr($fieldDisplayVal,0,10)."</span>";
									if($fieldDisplayVal!='')
									{
										$tableContentStr .= '<td class="tdListItem" title="'.$fieldDisplayVal.'">'.$rightMenu.'</td>';
									}else
									{
										$tableContentStr .= '<td class="tdListItem" title="'.$fieldDisplayVal.'" oncontextmenu="showContentRightMenu('.$val[$tableKeyName].');return   false;" style="cursor:poiter"></td>';
									}
								}else
								{
									$rightMenu = CsubStr($fieldDisplayVal,0,10);
									$tableContentStr .= '<td class="tdListItem" title="'.$fieldDisplayVal.'">'.$rightMenu.'</td>';
								}
								//处理列表显示自定义表达式，add by easyt end,2009.7.19
								//$tableContentStr .= '<td class="tdListItem" title="'.$fieldDisplayVal.'">'.$rightMenu.'</td>';

							}
						}
					}
				}
				//$tableContentStr .='<td class="tdListItem">'.getDateTime($nodeId,$tableKeyName,$val[$tableKeyName],$val).'</td>';
				//$tableContentStr .='<td class="tdListItem" >'.getState($nodeId,$tableKeyName,$val[$tableKeyName],$val).'</td>';
				$tableContentStr .='<td class="tdListItem" >'.getBrowsStr($nodeId,$tableKeyName,$val[$tableKeyName],$val).getActionStr($nodeId,$tableKeyName,$val[$tableKeyName],$val).'</td></tr>';
			}
			$tableContentStr .= "</table>";
			$pageStr = listPage($result['pageinfo'],'index.php',$pageInfo['pageListSize'],'nodeId='.$nodeId.'&frameListAction=cms&frameListMethod=commonListFrame');
			$tableContentStr .= $pageStr."<br>";
			$tempBatchActionStr = getBatchAction($nodeId,"actionMap");
			if($tempBatchActionStr!='')
			{
				$tableContentStr .="<input type='hidden' name='type' id='type' >";
				$tableContentStr .=$tempBatchActionStr;
				$tableContentStr .="<input type='button' name='exc' value='执行' onclick='exBatch(1,\"actionMapP\");'>";
			}
			$str = $pageStr.$tableHeadStr.$tableContentStr;
		}else
		{
			$str = '';
		}
		return $str;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *通用CMS回收站列表显示
 **/
function listRecStr($nodeId,$fieldConfigId,$contentModel,$tableKeyName,$tableCon)
{
	try
	{
		if($GLOBALS['IN']['currentPage']!=''){
			$params['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else
		{
			$params['currentPage'] = 1;
		}
		$nodeInfo = getNodeInfoById($nodeId);//取得该结点号为$nodeId的所有配置
		$pageInfo = getPageInfo($nodeId);//取得每列显示多少行
		$params['pageSize'] = $pageInfo['pageSize'];
		if($fieldConfigId!=''&&$contentModel!=''&&$tableKeyName!='')
		{
			$sql = "select * from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId = :fieldConfigId and isDisplayHeader =:isDisplayHeader  order by fieldId";
			$param['fieldConfigId'] = $fieldConfigId;
			$param['isDisplayHeader'] = '1';
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
			$tableHeadStr ='<table class="tableList" border="1" id="list" width="100%">';
			$tableHeadStr .="<tr>";
			$tableHeadStr .= '<td class="listHeader" width="60px"><input type="checkbox" id="allRec" onclick="selectAll(\'selectAllRec\',this.id,\'checksRec\');"><span id="selectAllRec" name="" style="cursor:pointer" onclick="selectAll(this.id,\'allRec\',\'checksRec\');">全选</span></td>';
			foreach ($result as $key => $val)
			{
				if($val['tableHeadWidth']!='0')
				{
					$width = 'width="'.$val['tableHeadWidth'].'px"';
				}
				$tableHeadStr .= '<td class="listHeader" '.$width.'>'.$val['fieldTitle'].'</td>';
				$select .= 'a.'.$val['fieldName'].',';
				$fieldDefaultStr  .= $val['fieldDefaultValue'].',';
				$fieldInputPickerStr  .= $val['fieldInputPicker'].',';

				$fieldListExpStr .= $val['fieldDescription'].'_ET_'; //列表显示字段的自定义表达式，add by easyt,2009.7.19, 暂时先用备注字段，等张小权重新加字段后再修改

			}
			$select = 'a.'.$tableKeyName.','.$select."b.top,b.pink,b.publishDate,b.state";//要查找的字段
			$fieldDefaultStr  = ' ,'.substr($fieldDefaultStr,0,-1);//查看字段的默认值
			$fieldInputPickerStr  = ' ,'.substr($fieldInputPickerStr,0,-1);//查看字段辅助类型

			$fieldListExpStr  = '_ET_'.substr($fieldListExpStr,0,-4);//列表显示字段的自定义表达式,字串处理，add by easyt,2009.7.19

			$tableHeadStr .= '<td class="listHeader" width="320px">执行操作</td></tr>';
			if( !empty($nodeInfo[0]['isDefaultCon']) )//结点默认条件, modify by easyt,2009.7.19,修改判断为空的方式，null和空串都支持
			{
				$nodeCon = " a.".$nodeInfo[0]['isDefaultCon'];
			}
			if( !empty($nodeInfo[0]['appWhereSQL']) )//用户自己定义的结点条件, modify by easyt,2009.7.19,修改判断为空的方式，null和空串都支持
			{
				$nodeCon = '1=1 '.explodeVerifyData($nodeInfo[0]['appWhereSQL'],0); //modify by easyt,2009.7.19,修改为如果有自定义条件就不要默认条件
			}

			//modify by easyt,2009.7.19
			if($tableCon!='')
			{
				$whereCon = $nodeCon." and ".$tableCon;
			}else{
				$whereCon = $nodeCon;
			}
			if($whereCon!='')
			{
				$whereCon .= " and b.isDel=1";
			}
			//$sql = "select ".$select." from ".$contentModel." a , {$GLOBALS['table']['cms']['app_publish_state']} b where ".$whereCon;
			//$sql = $sql." and a.".$tableKeyName."=b.contentId and a.nodeId=b.nodeId order by b.sort desc,b.state,b.top desc,b.pink desc,a.".$tableKeyName." desc";
			$sql = <<<EOT
SELECT {$select} FROM {$contentModel} a LEFT JOIN {$GLOBALS['table']['cms']['app_publish_state']} b ON a.{$tableKeyName} = b.contentId AND a.nodeId = b.nodeId WHERE {$whereCon} ORDER BY b.sort DESC , b.state, b.top DESC , b.pink DESC , a.{$tableKeyName} DESC
EOT;
			//上面修改关联发布状态表的方式改为left join方式，不管状态表有无记录都列出所有内容表记录
			//echo $sql;exit;

			$selectArray = explode(',',$select); //把字段名列表转为数组
			$fieldDefaultArray = explode(',',$fieldDefaultStr); //把字段默认值列表转为数组
			$fieldInputPickerArray = explode(',',$fieldInputPickerStr); //把字段输入采集器列表转为数组
			$fieldListExp = explode('_ET_',$fieldListExpStr); //把字段列表显示自定义表达式转为数组
			//modify by easyt,end

			$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			foreach ($result['data'] as $key => $val)
			{
				$tableContentStr .= "<tr>";
				$tableContentStr .= '<td class="tdListItem" width="50"><input type="checkbox" name="checksRec" value="'.$val[$tableKeyName].'" onclick="selectConCheck(\'checksRec\')"></td>';
				for($i=1;$i<count($selectArray);$i++)
				{
					$selectFieldName = substr($selectArray[$i],2);//去掉字段名的前缀如：a.staff变成staff， 修正了一个逻辑BUG，循环每次都会去掉字段名数组的头两位
					if($fieldDefaultArray[$i]!='')//显示字段默认值
					{
						$checkTemVal = '';
						$checkBoxArray = explode(',',$val[$selectFieldName]);//数据表中实际值
						$fieldDefaulValue = explode(';',$fieldDefaultArray[$i]);
						foreach($checkBoxArray as $chKey => $chVal)
						{
							if(strpos('aaa'.$fieldDefaultArray[$i],$chVal.':')>0)
							{
								foreach($fieldDefaulValue as $FDVKey => $FDVVal)
								{
									$aaArray = explode(':',$FDVVal);
									if($aaArray[0]==$chVal)
									{
										$checkTemVal = $checkTemVal.$aaArray[1].',';
									}
								}
								if(substr($checkTemVal,strlen($checkTemVal)-1,strlen($checkTemVal))==',')//判断字符串后面是否以逗号隔开
								{
									$checkTemVal = substr($checkTemVal,0,-1);
								}
							}else
							{
								$checkTemVal = $fieldDefaulValue[$val[$selectFieldName]];
							}
						}

						$tableContentStr .= '<td class="tdListItem" '.$width.'>'.$checkTemVal.'</td>';
					}else if($fieldListExp[$i]!='')//自定义SQL执行取数据 modify zxq 20110730
					{
						$selfSqlArray = getFieldInfoBySql($fieldListExp[$i]);
						if(!empty($selfSqlArray['data']))
						{
							foreach ($selfSqlArray['data'] as $sqlKey => $sqlVal)
							{
								$sqlSubNum=0;
								foreach ($sqlVal as $sqlSubKey => $sqlSubVal)
								{
									if($sqlSubNum==1)
									{
										$checkTemVal = $sqlSubVal;
									}
									$sqlSubNum++;
								}
							}
						}
						$tableContentStr .= '<td class="tdListItem" '.$width.'>'.$checkTemVal.'</td>';
					}else
					{
						if($fieldInputPickerArray[$i]=='upload')
						{
							//$tableContentStr .= '<td class="tdListItem" '.$width.'><img src="'.$val[$selectFieldName].'" width="20" height="20"></td>';
						}else
						{
							//处理列表显示自定义表达式，add by easyt,2009.7.19
							if($selectFieldName!='top'&&$selectFieldName!='pink'&&$selectFieldName!='publishDate'&&$selectFieldName!='state')
							{
								$fieldDisplayVal = $val[$selectFieldName];
								if( !empty($fieldListExp[$i]) ) {
									$tmpVal = $val[$selectFieldName];
									$tmpExp = str_replace(array('[this]','[THIS]'),'$tmpVal',$fieldListExp[$i]); //将设置的自定义表达式中[this]换为当前字段
									@eval( '$fieldDisplayVal = ' . $tmpExp . ';' );
								}
								//处理列表显示自定义表达式，add by easyt end,2009.7.19
								$tableContentStr .= '<td class="tdListItem" title="'.$fieldDisplayVal.'">'.CsubStr($fieldDisplayVal,0,10).'</td>';
							}
						}
					}
				}
				$resumeTemUrl = 'index.php'.encrypt_url('action=cms&method=resume&nodeId='.$nodeId.'&contentModel='.$contentModel.'&appTableKeyName='.$tableKeyName.'&selectConId='.$val[$tableKeyName].',');
				$deleteTemUrl = 'index.php'.encrypt_url('action=cms&method=foreverDel&nodeId='.$nodeId.'&contentModel='.$contentModel.'&appTableKeyName='.$tableKeyName.'&selectConId='.$val[$tableKeyName].',');
				$tableContentStr .='<td class="tdListItem" ><a href="'.$resumeTemUrl.'">恢复</a> <a href="javascript:void(0);" onclick="if(window.confirm(\'该删除执行后，数据不可恢复！\')){window.location.href=\''.$deleteTemUrl.'\'}">删除</a></td></tr>';
			}
			$tableContentStr .= "</table>";
			$pageStr = listPage($result['pageinfo'],'index.php',$pageInfo['pageListSize'],'nodeId='.$nodeId.'&frameListAction=cms&frameListMethod=commonListFrame');
			$tableContentStr .= $pageStr."<br>";
			//			$tableContentStr .="<input type='hidden' name='selectConId' id='selectConId' >";
			$tableContentStr .='<select name="actionMapRec" id="actionMapRec" onchange="batchChange(this.id)">
			<option value="foreverDel">永久删除</option>
			<option value="resume">恢复</option>
			<option value="flushRec">清空回收站</option>
			</select>';
			$tableContentStr .="<input type='button' name='exc' value='执行' onclick='exBatch(2,\"actionMapRec\");'>";
			$str = $pageStr.$tableHeadStr.$tableContentStr;
}else
{
	$str = '';
}
return $str;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *通用CMS编辑显示
 **/
function editStr($fieldConfigId,$contentModel,$tableKeyName,$tableKeyValue,$nodeId)
{
	try
	{
		if($fieldConfigId!=''||$contentModel!=''||$tableKeyName||$tableKeyValue!='')
		{
			$sql = "select * from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId = :fieldConfigId  order by fieldId";
			$param['fieldConfigId'] = $fieldConfigId;
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
			$tableHeadStr ="<tr>";
			foreach ($result as $key => $val)
			{
				$title .= $val['fieldTitle'].',';
				$select .= $val['fieldName'].',';
				$isDisplayEditt .= $val['isDisplayEdit'].',';
				$fieldType  .= $val['fieldType'].',';
				$fieldInput  .= $val['fieldInput'].',';
				$fieldDefaultValue  .= $val['fieldDefaultValue'].',';
				$fieldInputFilter  .= $val['fieldInputFilter'].',';
				$fieldInputPicker  .= $val['fieldInputPicker'].',';
				$fieldDescription  .= $val['fieldDescription'].',';
			}
			$title = substr($title,0,-1);
			$select = substr($select,0,-1);
			$fieldType = substr($fieldType,0,-1);
			$fieldInput = substr($fieldInput,0,-1);
			$fieldDefaultValue = substr($fieldDefaultValue,0,-1);
			$fieldInputFilter = substr($fieldInputFilter,0,-1);
			$fieldInputPicker = substr($fieldInputPicker,0,-1);
			$fieldDescription = substr($fieldDescription,0,-1);
			if($tableKeyValue!='')
			{
				$sql = "select ".$select." from ".$contentModel." where ".$tableKeyName."=".$tableKeyValue;
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
				foreach ($result as $key => $val)
				{
					$selectArray = explode(',',$select);
					$titleArray = explode(',',$title);
					$isDisplayEdittAttay = explode(',',$isDisplayEditt);
					$fieldTypeArray = explode(',',$fieldType);
					$fieldInputArray = explode(',',$fieldInput);
					$fieldDefaultValueArray = explode(',',$fieldDefaultValue);
					$fieldInputFilterArray = explode(',',$fieldInputFilter);
					$fieldInputPickerArray = explode(',',$fieldInputPicker);
					$fieldDescriptionArray = explode(',',$fieldDescription);
					$editFieldStr .= '<input type="hidden" class="edit" name="'.$tableKeyName.'" value="'.$tableKeyValue.'" >';
					for($i=0;$i<count($selectArray);$i++)
					{
						if($isDisplayEdittAttay[$i]==1)
						{
						$editFieldStr .= inputStr($titleArray[$i],$selectArray[$i],$val[$selectArray[$i]],$fieldInputArray[$i],$fieldDefaultValueArray[$i],$fieldInputFilterArray[$i],$fieldInputPickerArray[$i],$fieldTypeArray[$i],$fieldDescriptionArray[$i],$nodeId);
						//$editFieldStr .= '<div class="detailMember_txt">'.$titleArray[$i].'</div>';
						//$editFieldStr .= '<div class="detailMember_info"><input type="text" id="'.$selectArray[$i].'" name="para['.$selectArray[$i].']" value="'.$val[$selectArray[$i]].'"></div>';
						}
					}
				}
			}else
			{
				$selectArray = explode(',',$select);
				$titleArray = explode(',',$title);
				$isDisplayEdittAttay = explode(',',$isDisplayEditt);
				$fieldTypeArray = explode(',',$fieldType);
				$fieldInputArray = explode(',',$fieldInput);
				$fieldDefaultValueArray = explode(',',$fieldDefaultValue);
				$fieldInputFilterArray = explode(',',$fieldInputFilter);
				$fieldInputPickerArray = explode(',',$fieldInputPicker);
				$fieldDescriptionArray = explode(',',$fieldDescription);
				$editFieldStr .= '<input type="hidden" class="edit" name="'.$tableKeyName.'" value="" >';
				for($i=0;$i<count($selectArray);$i++)
				{
					if($isDisplayEdittAttay[$i]==1)
					{
					$editFieldStr .= inputStr($titleArray[$i],$selectArray[$i],'',$fieldInputArray[$i],$fieldDefaultValueArray[$i],$fieldInputFilterArray[$i],$fieldInputPickerArray[$i],$fieldTypeArray[$i],$fieldDescriptionArray[$i],$nodeId);
					//					$editFieldStr .= '<div class="detailMember_txt">'.$titleArray[$i].'</div>';
					//					$editFieldStr .= '<div class="detailMember_info"><input type="text" id="'.$selectArray[$i].'" name="para['.$selectArray[$i].']" value=""></div>';
					}
				}
			}
		}else
		{
			$editFieldStr = '';
		}
		return $editFieldStr;
	} catch (Exception $e)
	{
		throw $e;
	}
}

/**
 *通用CMS增加数据函数 modify 20090311 by zxq
 **/
function addData($nodeId,$contentModel,$dataArray)
{

	try
	{
		date_default_timezone_set('PRC');
		$nodeInfo = getNodeInfoById($nodeId);//取得该结点号为$nodeId的所有配置
		$defaultInsertArray = explodeVerifyData($nodeInfo[0]['appInsertArray'],1);
		$verifyArray = explodeVerifyData($nodeInfo[0]['appValidArray'],2);

		checkInputData($nodeInfo,$dataArray,$verifyArray);
		if(!empty($defaultInsertArray))
		{
			foreach ($defaultInsertArray as $key => $val)
			{
				$dataArray[$key] = $val;
			}
		}
		$verifyArray = explodeVerifyData($nodeInfo[0]['appValidArray'],2);//数据校验栏
		//print_r($verifyArray);exit;
		foreach ($dataArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into ".$contentModel." (".$str_field.") values (".$str_value.")";
		//echo $sql;
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
		$publishArray['nodeId']=$dataArray['nodeId'];
		$publishArray['appTableName']=$contentModel;
		$publishArray['contentId']=$result;
		//print_r($publishArray);
		addPublish($publishArray);//向发布状态表中插入一条记录
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}

/**
 *通用CMS修改数据函数
 **/
function editData($nodeId,$contentModel,$tableKeyName,$tableKeyValue,$dataArray)
{
	try
	{
		date_default_timezone_set('PRC');
		$nodeInfo = getNodeInfoById($nodeId);//取得该结点号为$nodeId的所有配置
		$verifyArray = explodeVerifyData($nodeInfo[0]['appValidArray'],2);
		checkInputData($nodeInfo,$dataArray,$verifyArray);
		$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		//print_r($dataArray);
		$sql = "update $contentModel set $sql where $tableKeyName=$tableKeyValue";
		//print_r($dataArray);
		//print $sql;exit;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * add 20110711 zxq
 * 取通用CMS结点的一条记录
 * **/
function getDataByCon($contentModel,$tableKeyName,$tableKeyValue)
{
	try {
		$sql = "select * from {$contentModel} where ".$tableKeyName."=".$tableKeyValue;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *通用CMS删除操作
 **/
function delCommonData($nodeId,$contentModel,$tableKeyName,$tableKeyValue,$method='0')
{
	try
	{
		$nodeArray = getNodeInfoById($nodeId);
		if($method=='1')//彻底删除
		{
			$sql = "delete from ".$contentModel." where ".$tableKeyName." = ".$tableKeyValue;
			$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
			//同时要把发布表中的数据给删除
			$sql = "delete from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";
			$params['nodeId'] = $nodeArray[0]['nodeGuid'];
			$params['contentId'] = $tableKeyValue;
			$params['appTableName'] = $contentModel;
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);

			return $result;
		}else //一般删除
		{
			$sql = "update {$GLOBALS['table']['cms']['app_publish_state']} set isDel=1 where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";
			$params['nodeId'] = $nodeArray[0]['nodeGuid'];
			$params['contentId'] = $tableKeyValue;
			$params['appTableName'] = $contentModel;
			return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *恢复删除的数据
 **/
function resumeCommonData($nodeId,$contentModel,$tableKeyName,$tableKeyValue)
{
	try
	{
		$nodeArray = getNodeInfoById($nodeId);
		$sql = "update {$GLOBALS['table']['cms']['app_publish_state']} set isDel=0 where nodeId=:nodeId and contentId=:contentId and appTableName=:appTableName";
		$params['nodeId'] = $nodeArray[0]['nodeGuid'];
		$params['contentId'] = $tableKeyValue;
		$params['appTableName'] = $contentModel;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据结点号取得列表的分页信息
 * **/
function getPageInfo($nodeId)
{
	try {
		$sqlNode = "select * from {$GLOBALS['table']['cms']['site']} where nodeId =:nodeId";
		$paramsNode["nodeId"] = $nodeId;
		$resultNode = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlNode,$paramsNode);
		if(!empty($resultNode))
		{
			$sqlContentPlan = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where contentPlanId =:contentPlanId";
			$paramsContentPlan['contentPlanId'] = $resultNode[0]['contentPlanId'];
			$resultContentPlan = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlContentPlan,$paramsContentPlan);
			if(!empty($resultContentPlan))
			{
				$paramPage['pageSize'] = $resultContentPlan[0]['contentPlanPage'];
				$paramPage['pageListSize'] = $resultContentPlan[0]['contentPlanSize'];
			}else
			{
				$paramPage['pageSize'] = 10;
				$paramPage['pageListSize'] = 5;
			}

		}else
		{
			$paramPage['pageSize'] = 10;
			$paramPage['pageListSize'] = 5;
		}
		return $paramPage;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据结点号取得该结点在列表中显示的动作
 * **/
function getActionStr($nodeId,$tableKeyName,$tableKeyValue,$resultArray)
{
	try {
		$resultNode = getNodeInfoById($nodeId);
		$memberId = readSession();
		$groupArray = getGroupIdByStaffNo($memberId);
		if(!empty($resultNode))
		{
			$resultContent = getContentInfoById($resultNode[0]['contentPlanId']);//取得列表的动作和方法

			if(!empty($resultContent))
			{
				//$parmsStr = "frameListAction=cms&frameListMethod=commonListFrame&";
				$actionIdArr = explode(',',$resultContent[0]['contentActionId']);
				for ($i=0;$i<count($actionIdArr);$i++)
				{
					if($memberId!='admin')
					{
						if(checkDisplayNodeAuth($groupIdArray,$memberId,$resultNode[0]['nodeGuid'],$actionIdArr[$i]))//检测当前用户有没有操作动作的权限
						{
							$sqlAction = "select * from {$GLOBALS['table']['cms']['app_actionconfig']} where actionGuid =:actionGuid";
							$paramAction['actionGuid'] = $actionIdArr[$i];

							$resultAction = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlAction,$paramAction);
							if(!empty($resultAction))
							{
								$paramsStr = getExtrParams($resultAction[0]['pathParams'],$resultArray);
								$sqlPublish = "select publishId from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId='".$nodeId."' and contentId='".$tableKeyValue."' and appTableName='".$resultNode[0]['appTableName']."'";
								$resultPublish = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlPublish,$paramAction);
								if(!empty($resultPublish))
								{
									$publishId = $resultPublish[0]['publishId'];
								}
								$tempUrlStr = $resultAction[0]['tplPath'].encrypt_url("action=".$resultAction[0]['actionName']."&method=".$resultAction[0]['methodName']."&publishId=".$publishId."&nodeId=".$nodeId."&contentModel=".$resultNode[0]['appTableName']."&appTableKeyName=".$tableKeyName."&appTableKeyValue=".$tableKeyValue.$paramsStr);

								$str .="<a href='".$tempUrlStr."'>".$resultAction[0]['actionTitle']."</a>&nbsp;&nbsp;";
							}
						}
					}else
					{
						$sqlAction = "select * from {$GLOBALS['table']['cms']['app_actionconfig']} where actionGuid =:actionGuid";
						$paramAction['actionGuid'] = $actionIdArr[$i];
						$resultAction = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlAction,$paramAction);
						if(!empty($resultAction))
						{
							$paramsStr = getExtrParams($resultAction[0]['pathParams'],$resultArray);
							$sqlPublish = "select publishId from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId='".$resultNode[0]['nodeGuid']."' and contentId='".$tableKeyValue."' and appTableName='".$resultNode[0]['appTableName']."'";
							$resultPublish = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlPublish,$paramAction);
							if(!empty($resultPublish))
							{
								$publishId = $resultPublish[0]['publishId'];
							}
							//print $paramsStr."<br>";
							$tempUrlStr = $resultAction[0]['tplPath'].encrypt_url("action=".$resultAction[0]['actionName']."&method=".$resultAction[0]['methodName']."&publishId=".$publishId."&nodeId=".$nodeId."&contentModel=".$resultNode[0]['appTableName']."&appTableKeyName=".$tableKeyName."&appTableKeyValue=".$tableKeyValue."&type=1".$paramsStr);
							if($resultAction[0]['actionGoto']=='1')
							{
								$str .="<a href='".$tempUrlStr."'>".$resultAction[0]['actionTitle']."</a>&nbsp;&nbsp;";
							}elseif ($resultAction[0]['actionGoto']=='2')
							{
								$str .="<a href='javascript:void(0);' onclick=\"parent.location.href='".$tempUrlStr."'\">".$resultAction[0]['actionTitle']."</a>&nbsp;&nbsp;";
							}elseif ($resultAction[0]['actionGoto']=='3')
							{
								$str .="<a href='javascript:void(0);' onclick=\"window.open('".$tempUrlStr."','','')\" >".$resultAction[0]['actionTitle']."</a>&nbsp;&nbsp;";
							}elseif ($resultAction[0]['actionGoto']=='4')
							{
								$str .="<a href='javascript:void(0);' onclick=\"if(window.confirm('确定".$resultAction[0]['actionTitle']."吗？')){window.location='".$tempUrlStr."'}\" >".$resultAction[0]['actionTitle']."</a>&nbsp;&nbsp;";
							}
						}
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
/**
 *根据结点号取得该结点在列表中显示的浏览动作
 * **/
function getBrowsStr($nodeId,$tableKeyName,$tableKeyValue,$resultArray)
{
	try {
		$nodeArray = getNodeInfoById($nodeId);
		if(!empty($nodeArray))
		{
			$sqlPublish = "select url from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId='".$nodeArray[0]['nodeGuid']."' and contentId='".$tableKeyValue."'";
			$resultPublish = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlPublish,$paramAction);

			if(!empty($resultPublish))
			{
				if($resultPublish[0]['url']!=null)
				{
					/*if($pos = strpos($resultPublish[0]['url'],"?"))//动态发布处理
					{
						$paramsStr = encrypt_url(substr($resultPublish[0]['url'],$pos+1));
						$domanStr = substr($resultPublish[0]['url'],0,$pos+1);
						$str = "<a href='".$domanStr.$paramsStr."' target='_bank'>浏览</a>&nbsp;&nbsp;";
					}else
					{*/
						$str = "<a href='".$resultPublish[0]['url']."' target='_bank'>浏览</a>&nbsp;&nbsp;";
					//}
				}
			}
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据结点号取得该结点在列表中显示的发布状态
 * **/
function getState($nodeId,$tableKeyName,$tableKeyValue,$resultArray)
{
	try {
		$sqlNode = "select * from {$GLOBALS['table']['cms']['site']} where nodeId =:nodeId";
		$paramsNode["nodeId"] = $nodeId;
		$resultNode = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlNode,$paramsNode);
		if(!empty($resultNode))
		{
			$sqlPublish = "select state from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId='".$nodeId."' and contentId='".$tableKeyValue."' and appTableName='".$resultNode[0]['appTableName']."'";
			$resultPublish = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlPublish,$paramAction);
			if(!empty($resultPublish))
			{
				if($resultPublish[0]['state']=='1')
				{
					$str = "已发布";
				}else
				{
					$str = "待发布";
				}
			}else
			{
				$str = "待发布";
			}
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据结点号取得该结点在列表中显示的发布日期
 * **/
function getDateTime($nodeId,$tableKeyName,$tableKeyValue,$resultArray)
{
	try {
		date_default_timezone_set('PRC');
		$sqlNode = "select * from {$GLOBALS['table']['cms']['site']} where nodeId =:nodeId";
		$paramsNode["nodeId"] = $nodeId;
		$resultNode = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlNode,$paramsNode);
		if(!empty($resultNode))
		{
			$sqlPublish = "select publishDate from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId='".$nodeId."' and contentId='".$tableKeyValue."' and appTableName='".$resultNode[0]['appTableName']."'";
			$resultPublish = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlPublish,$paramAction);
			if(!empty($resultPublish))
			{
				if($resultPublish[0]['publishDate']!='')
				{
					$str = date("Y-m-d H:i:s",$resultPublish[0]['publishDate']);
				}else
				{
					$str = '';
				}
			}
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 取得内容编辑方案的基本信息
 * **/
function getContentInfoById($contentId)
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['app_contentplan']} where contentPlanId =:contentPlanId";
		$param['contentPlanId'] = $contentId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$param);
		return $result;
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 处理各动作的附加参数反回一字符串
 * **/
function getExtrParams($paramStr,$resultArray)
{
	try {
		$str = "";
		if($paramStr)
		{
			$paramStrArray = explode(',',$paramStr);
			foreach ($paramStrArray as $key => $val)
			{
				$parasArray = explode('=',$val);
				if($parasArray[1]!='')
				{
					if(strpos($parasArray[1],'[')==0&&strpos($parasArray[1],']')>0)
					{
						$fieldName = substr($parasArray[1],1,strlen($parasArray[1])-2);
						if(array_key_exists($fieldName,$resultArray))
						{
							$fieldValue = $resultArray[$fieldName];
						}
						//$str .="&".$parasArray[0]."=".$fieldValue;
						$returnArray[$parasArray[0]] = $fieldValue;
					}else
					{
						$returnArray[$parasArray[0]] = $parasArray[1];
					}
				}
//				if(strpos($parasArray[1],'[')==0&&strpos($parasArray[1],']')>0)
//				{
//					$fieldName = substr($parasArray[1],1,strlen($parasArray[1])-2);
//					if(array_key_exists($fieldName,$resultArray))
//					{
//						$fieldValue = $resultArray[$fieldName];
//					}
//					$str .="&".$parasArray[0]."=".$fieldValue;
//
//				}else
//				{
//					$str .="&".$parasArray[0]."=".$parasArray[1];
//				}
			}
			$str = "&actParams=".base64_encode(serialize($returnArray));
		}
		return $str;
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 列表中鼠标右击显示
 * */
function isDisplayRightMenu($fieldName,$fieldConfigId)
{
	try {
		$sql = "select isDisplayMenu from {$GLOBALS['table']['cms']['app_fields']} where fieldName=:fieldName and fieldConfigId =:fieldConfigId";
		$paramsField['fieldName'] = $fieldName;
		$paramsField['fieldConfigId'] = $fieldConfigId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$paramsField);
		return $result[0]['isDisplayMenu'];
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 该函数用于显示列表页的搜索框
 * **/
function getSelectData($nodeId)
{
	try {
		$sqlNode = "select * from {$GLOBALS['table']['cms']['site']} where nodeId =:nodeId";
		$paramsNode["nodeId"] = $nodeId;
		$resultNode = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlNode,$paramsNode);
		if(!empty($resultNode))
		{
			$sqlField = "select * from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId =:fieldConfigId";
			$paramsField["fieldConfigId"] = $resultNode[0]['fieldConfigId'];
			$resultField = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlField,$paramsField);
			if(!empty($resultField))
			{
				$str = '<table border="0" width="100%">
						<tr>
				    		<td>
				    			<table border="0" id="conditions"  width="100%"></table>
				    		</td>
				    		<td>
				    		<input type="button" name="buttion" value="搜索" onclick="search();"/>
				    		</td>
				    	</tr>
					</table>
				  </form>
				  </body>
				<script language="javascript" type="">
				  var sqlcondition =new sqlcondition("conditions");
				  fieldList=new Array();';
				foreach ($resultField as $key => $val)
				{
					if($val['fieldDefaultValue']!='')
					{
						$str .= 'fieldList['.$key.']=sqlcondition.newFieldbean("'.$val["fieldName"].'","'.$val["fieldTitle"].'","'.$val["fieldType"].'","'.$key.'","");';
						$dicListStr .= 'dictList'.$key.'=new Array();';
						$defaultValueArray = explode(';',$val['fieldDefaultValue']);
						for($i=0;$i<count($defaultValueArray);$i++)
						{
							$dicListStr .= 'dictList'.$key.'['.$i.']=sqlcondition.newDictBean("'.$key.'","'.$i.'","'.$defaultValueArray[$i].'");';
						}
						$dicListStr .= 'sqlcondition.setDictList(dictList'.$key.');';
					}else
					{
						$str .= 'fieldList['.$key.']=sqlcondition.newFieldbean("'.$val["fieldName"].'","'.$val["fieldTitle"].'","'.$val["fieldType"].'","","");';
					}

				}
				$str .= "sqlcondition.setFieldList(fieldList);";
				return $str.$dicListStr."sqlcondition.initHeader();</script>";
			}else
			{
				return null;
			}

		}else
		{
			return null;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * 把用户在结点配置中校验栏数据根据$flag这个标识
 * 生成不同的字符串返回
 * $flag为0 返回成 "and 字段1='aaaa',...,字段n='nnnn'"
 * $flag为1 返回成 "为数组"
 * $flag为2 返回成 "为数组"
 * **/
function explodeVerifyData($verifyStr,$flag)
{
	try {
		//modify zxq 20110729
		//从其它结点跳转过来，到动作参数
		$patt = "/".preg_quote('[')."([\S]+)" . preg_quote(']') . "/siU";
		if($verifyStr!=null)
		{
			$verifyArray = explode(',',$verifyStr);
		}
		if($flag=='0')
		{
			if(!empty($verifyArray))
			{
				for($i=0;$i<count($verifyArray);$i++)
				{
					if (preg_match_all($patt, $verifyArray[$i], $matches))
					{
						if($GLOBALS['IN'][$matches[1][0]]!="")
						{
							$returnStr .= " and a.".str_replace($matches[0][0],$GLOBALS['IN'][$matches[1][0]],$verifyArray[$i]);$verifyArray[$i];
						}else
						{
							$returnStr .= "";
						}
					}else
					{
						$returnStr .= " and a.".$verifyArray[$i];
					}
				}
			}
			return $returnStr;
		}elseif ($flag=='1')
		{
			if(!empty($verifyArray))
			{
				for($i=0;$i<count($verifyArray);$i++)
				{
					$subVerifyArray = explode('=',$verifyArray[$i]);
					$returnArray[$subVerifyArray[0]] = str_replace("'","",$subVerifyArray[1]);
				}
			}
			return $returnArray;
		}else
		{
			if(!empty($verifyArray))
			{
				for($i=0;$i<count($verifyArray);$i++)
				{
					if(strpos($verifyArray[$i],'>'))
					{
						$returnArray[$i][] = '>';
						$subVerifyArray = explode('>',$verifyArray[$i]);
						$returnArray[$i][] = $subVerifyArray[0];
						$returnArray[$i][] = str_replace("'","",$subVerifyArray[1]);
					}
					if(strpos($verifyArray[$i],'<'))
					{
						$returnArray[$i][] = '<';
						$subVerifyArray = explode('<',$verifyArray[$i]);
						$returnArray[$i][] = $subVerifyArray[0];
						$returnArray[$i][] = str_replace("'","",$subVerifyArray[1]);
					}
					if(strpos($verifyArray[$i],'>='))
					{
						$subVerifyArray = explode('>=',$verifyArray[$i]);
						$returnArray['>='][$subVerifyArray[0]] = str_replace("'","",$subVerifyArray[1]);
					}
					if(strpos($verifyArray[$i],'<='))
					{
						$returnArray[$i][] = '<=';
						$subVerifyArray = explode('<=',$verifyArray[$i]);
						$returnArray[$i][] = $subVerifyArray[0];
						$returnArray[$i][] = str_replace("'","",$subVerifyArray[1]);
					}
					if(strpos($verifyArray[$i],'!='))
					{
						$returnArray[$i][] = '!=';
						$subVerifyArray = explode('!=',$verifyArray[$i]);
						$returnArray[$i][] = $subVerifyArray[0];
						$returnArray[$i][] = str_replace("'","",$subVerifyArray[1]);
					}
					if(strpos($verifyArray[$i],'<>'))
					{
						$returnArray[$i][] = '<>';
						$subVerifyArray = explode('<>',$verifyArray[$i]);
						$returnArray[$i][] = $subVerifyArray[0];
						$returnArray[$i][] = str_replace("'","",$subVerifyArray[1]);
					}
				}
			}
			return $returnArray;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 判断用户输入的数据是否合法
 * **/
function checkInputData($nodeInfo,$dataArray,$checkArray)
{
	try {
		if(!empty($checkArray))
		{
			foreach ($checkArray as $key => $val)
			{
				if($val[0]=='>')
				{
					if($dataArray["$val[1]"]>$val[2])
					{
						$expr .= '1';
					}else
					{
						$expr .= '0';
						$sql ="select fieldTitle from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId='".$nodeInfo[0]['fieldConfigId']."' and fieldName='".$val[1]."'";
						$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
						$params .= $result[0]['fieldTitle']."(".$val[1].") 不".$val[0].$val[2]."\\n";
					}
				}
				if($val[0]=='<')
				{
					if($dataArray["$val[1]"]<$val[2])
					{
						$expr .= '1';
					}else
					{
						$expr .= '0';
						$sql ="select fieldTitle from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId='".$nodeInfo[0]['fieldConfigId']."' and fieldName='".$val[1]."'";
						$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
						$params .= $result[0]['fieldTitle']."(".$val[1].") 不".$val[0].$val[2]."\\n";
					}
				}
				if($val[0]=='<=')
				{
					if($dataArray["$val[1]"]<=$val[2])
					{
						$expr .= '1';
					}else
					{
						$expr .= '0';
						$sql ="select fieldTitle from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId='".$nodeInfo[0]['fieldConfigId']."' and fieldName='".$val[1]."'";
						$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
						$params .= $result[0]['fieldTitle']."(".$val[1].") 不".$val[0].$val[2]."\\n";
					}
				}
				if($val[0]=='>=')
				{
					if($dataArray["$val[1]"]>=$val[2])
					{
						$expr .= '1';
					}else
					{
						$expr .= '0';
						$sql ="select fieldTitle from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId='".$nodeInfo[0]['fieldConfigId']."' and fieldName='".$val[1]."'";
						$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
						$params .= $result[0]['fieldTitle']."(".$val[1].") 不".$val[0].$val[2]."\\n";
					}
				}
				if($val[0]=='!=')
				{
					if($dataArray["$val[1]"]!=$val[2])
					{
						$expr .= '1';
					}else
					{
						$expr .= '0';
						$sql ="select fieldTitle from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId='".$nodeInfo[0]['fieldConfigId']."' and fieldName='".$val[1]."'";
						$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
						$params .= $result[0]['fieldTitle']."(".$val[1].") 不".$val[0].$val[2]."\\n";
					}
				}
				if($val[0]=='<>')
				{
					if($dataArray["$val[1]"]!=$val[2])
					{
						$expr .= '1';
					}else
					{
						$expr .= '0';
						$sql ="select fieldTitle from {$GLOBALS['table']['cms']['app_fields']} where fieldConfigId='".$nodeInfo[0]['fieldConfigId']."' and fieldName='".$val[1]."'";
						$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$fieldsArray);
						$params .= $result[0]['fieldTitle']."(".$val[1].") 不".$val[0].$val[2]."\\n";
					}
				}
			}
		}
		$expr = 'aa'.$expr;
		if(strpos($expr,'0')>0)
		{

			echo ' <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo ' <script language="javascript">';
			echo 'alert("'.$params.'");history.back();';
			echo ' </script>';
			exit;
		}else
		{
			return true;
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}

/**
 *通用CMS附加发布列表显示
 **/
function listExtStr($nodeId,$fieldConfigId,$contentModel,$tableKeyName,$tableCon)
{
	try {
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$params['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else
		{
			$params['currentPage'] = 1;
		}
		$params['pageSize'] = 10;
		$nodeInfo = getNodeInfoById($nodeId);
		$tableHeadStr ='<table class="tableList" border="1" id="list" width="100%">';
		$tableHeadStr .="<tr>";
		$tableHeadStr .= '<td class="listHeader"><input type="checkbox" id="allP" onclick="selectAll(\'selectAllP\',this.id,\'checksP\');"><span id="selectAllP" name="" style="cursor:pointer" onclick="selectAll(this.id,\'allP\',\'checksP\');">全选</span></td>';
		$tableHeadStr .= '<td class="listHeader">标题</td>';
		$tableHeadStr .= '<td class="listHeader">修改时间</td>';
		$tableHeadStr .= '<td class="listHeader">修改人</td>';
		$tableHeadStr .= '<td class="listHeader">是否为首页</td>';
		$tableHeadStr .= '<td class="listHeader">状态</td>';
		$tableHeadStr .= '<td class="listHeader">执行操作</td>';
		$tableHeadStr .= '</tr>';

		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where nodeId='".$nodeInfo[0]['nodeGuid']."' and isDel=0 order by isIndex Desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		foreach ($result['data'] as $key => $val)
		{
			$updateUrlStr = "index.php".encrypt_url("action=cms&method=update&type=0&extraPublishId=".$val['extraPublishId']."&nodeId=".$nodeId);
			$editUrlStr = "index.php".encrypt_url("action=cms&method=editExtData&extraPublishId=".$val['extraPublishId']."&nodeId=".$nodeId);
			$delUrlStr = "index.php".encrypt_url("action=cms&method=delExtData&extraPublishId=".$val['extraPublishId']."&nodeId=".$nodeId);
			$publisUrlStr = "index.php".encrypt_url("action=cms&method=publish&type=0&extraPublishId=".$val['extraPublishId']."&nodeId=".$nodeId);
			$tableContentStr .= "<tr>";
			$tableContentStr .= '<td class="tdListItem"><input type="checkbox" name="checksP" value="'.$val["extraPublishId"].'" onclick="selectConCheck(\'checksP\')"></td>';
			$tableContentStr .= '<td class="tdListItem">'.$val["extraPublishName"].'</td>';
			$tableContentStr .= '<td class="tdListItem">'.date("Y-m-d H:i:s",$val["modifiedDate"]).'</td>';
			$tableContentStr .= '<td class="tdListItem">'.$val["lastModifiedUserName"].'</td>';
			$indexUrl = "../cms/index.php".encrypt_url("action=cms&method=setIndex&nodeId=".$nodeId."&extraPublishId=".$val['extraPublishId']."&isIndex=".$val['isIndex']);
			if($val['isIndex']=='1')
			{
				$tableContentStr .= '<td class="tdListItem"><input type="checkbox" name="isIndex" value="'.$val["isIndex"].'" onclick="changeIndex(\''.$indexUrl.'\')" checked></td>';
			}else
			{
				$tableContentStr .= '<td class="tdListItem"><input type="checkbox" name="isIndex" value="'.$val["isIndex"].'" onclick="changeIndex(\''.$indexUrl.'\')"></td>';
			}
			if($val['extraPublishState'])
			$extraPublishState = '已发布';
			else
			$extraPublishState = '未发布';
			$tableContentStr .= '<td class="tdListItem">'.$extraPublishState.'</td>';
			$tableContentStr .= '<td class="tdListItem">';
			if($val['extraPublishState']=='1')
			{
				$tableContentStr .= '<a href="'.$val['extraPublishURL'].'" target="_blank">浏览</a>&nbsp;&nbsp;';
			}
			$tableContentStr .= '<a href="'.$updateUrlStr.'">更新</a>&nbsp;&nbsp;<a href="'.$publisUrlStr.'">发布</a>&nbsp;&nbsp;	<a href="'.$editUrlStr.'">编辑</a>&nbsp;&nbsp;<a href="'.$delUrlStr.'">删除</a></td>';
			$tableContentStr .= '</tr>';
		}
		$tableContentStr .= '</table>';
		$pageStr = listPage($result['pageinfo'],'index.php',$pageInfo['pageListSize'],'nodeId='.$nodeId.'&frameListAction=cms&frameListMethod=commonListFrame');
		$tableContentStr .= $pageStr."<br>";
		$tableContentStr .="<input type='hidden' name='selectConId' id='selectConId' >";
		$tempBatchActionStr = getBatchAction($nodeId,"actionMapP");
		if($tempBatchActionStr!='')
		{
			//$tableContentStr .="<input type='hidden' name='selectConId' id='selectConId' >";
			$tableContentStr .="<input type='hidden' name='type' id='type'>";
			$tableContentStr .=$tempBatchActionStr;
			$tableContentStr .="<input type='button' name='exc' value='执行' onclick='exBatch(0,\"actionMapP\");'>";
		}
		return $tableHeadStr.$tableContentStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *cms附加发布新增操作
 */
function addExtData($nodeId,$arrayExt)
{
	try {
		date_default_timezone_set('PRC');
		$result = getExtInfoByGuid($arrayExt['extraPublishGuid']);
		if(!empty($result))
		{
			return false;
		}
		$nodeInfo = getNodeInfoById($nodeId);//取得该结点号为$nodeId的所有配置
		if($arrayExt['isIndex']=='1')
		{
			loopModifyIndexFlag($nodeInfo[0]['nodeGuid']);
		}
		$arrayExt['nodeId'] = $nodeInfo[0]['nodeGuid'];
		$arrayExt['creationUserName'] = "";
		$arrayExt['lastModifiedUserName'] = "";
		$arrayExt['creationDate'] = strtotime(date("Y-m-d H:i:s"));
		$arrayExt['modifiedDate'] = strtotime(date("Y-m-d H:i:s"));
		foreach ($arrayExt as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['app_table_extra']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$arrayExt);
		return $result;

	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *cms附加发布编辑操作
 */
function editExtData($nodeId,$extraPublishId,$arrayExt)
{
	try {
		date_default_timezone_set('PRC');
		$nodeInfo = getNodeInfoById($nodeId);//取得该结点号为$nodeId的所有配置
		if($arrayExt['isIndex']=='1')
		{
			loopModifyIndexFlag($nodeInfo[0]['nodeGuid']);
		}
		$arrayExt['nodeId'] = $nodeInfo[0]['nodeGuid'];
		$arrayExt['lastModifiedUserName'] = "";
		$arrayExt['modifiedDate'] = strtotime(date("Y-m-d H:i:s"));
		$sql = '';
		foreach ($arrayExt as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		//print_r($dataArray);
		$sql = "update {$GLOBALS['table']['cms']['app_table_extra']} set $sql where extraPublishId='".$extraPublishId."'";
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$arrayExt);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *cms附加发布删除操作
 */
function delExtData($extraPublishId)
{
	try {
		//$sql = "delete from {$GLOBALS['table']['cms']['app_table_extra']} where extraPublishId='".$extraPublishId."'";
		//return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,"");
		$sql = "update {$GLOBALS['table']['cms']['app_table_extra']} set isDel=1 where extraPublishId='".$extraPublishId."'";
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,"");
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 根据ID号取得附加发布操作
 */
function getExtInfoById($extraPublishId)
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where extraPublishId='".$extraPublishId."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 根据ID号取得附加发布操作
 */
function getExtInfoByGuid($extraPublishGuid)
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where extraPublishGuid='".$extraPublishGuid."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 取得附加发布的标识
 * */
function fullPublishFlag($extraPublishName)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($extraPublishName);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/***
*设置附加发布结点的首页
*/
function loopModifyIndexFlag($nodeId)
{
	try {
		$sql = "update {$GLOBALS['table']['cms']['app_table_extra']} set isIndex=0 where nodeId='".$nodeId."'";
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,"");
	}catch (Exception $e)
	{
		throw $e;
	}
}
function modifyIndexFlag($nodeId,$extraPublishId,$isIndex)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		if($isIndex=='0')
		{
			loopModifyIndexFlag($nodeInfo[0]['nodeGuid']);
			$sql = "update {$GLOBALS['table']['cms']['app_table_extra']} set isIndex=1 where nodeId='".$nodeInfo[0]['nodeGuid']."' and extraPublishId='".$extraPublishId."'";
			return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,"");
		}else
		{
			$sql = "update {$GLOBALS['table']['cms']['app_table_extra']} set isIndex=0 where nodeId='".$nodeInfo[0]['nodeGuid']."' and extraPublishId='".$extraPublishId."'";
			return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,"");
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
//取发布过的首页数据
function getNodeExtraIndexByNodeId($nodeId)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where nodeId='".$nodeInfo[0]['nodeGuid']."' and extraPublishState=1 and isIndex=1 and isDel=0";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//取发布过的首页数据
function getNodeIndexByNodeId($nodeId)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId='".$nodeInfo[0]['nodeGuid']."' and isDel=0 and indexUrl!=''";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//取未发布过首页数据
function getNodeExtraIndexNoPublishByNodeId($nodeId)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where nodeId='".$nodeInfo[0]['nodeGuid']."' and extraPublishState=0 and isIndex=1 and isDel=0";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//取不管理首页发没有发布数据
function getNodeExtraIndexAllByNodeId($nodeId)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where nodeId='".$nodeInfo[0]['nodeGuid']."' and isIndex=1 and isDel=0";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//附加全部内容
function getExtraPublishAllByNodeId($nodeId)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where nodeId='".$nodeInfo[0]['nodeGuid']."' and isDel=0";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//附加已发布的内容
function getExtraPublishedByNodeId($nodeId)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where nodeId='".$nodeInfo[0]['nodeGuid']."' and extraPublishState=1 and isDel=0";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//附加未发布的内容
function getExtraPublishByNodeId($nodeId)
{
	try {
		$nodeInfo = getNodeInfoById($nodeId);
		$sql = "select * from {$GLOBALS['table']['cms']['app_table_extra']} where nodeId='".$nodeInfo[0]['nodeGuid']."' and extraPublishState=0 and isDel=0";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,"");
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
function getHeaderAction($nodeId,$fieldConfigId,$contentModel,$tableKeyName,$tableCon,$headerType)
{
	try {
		//主要取动作参数zxq 20110728 modfiy
		foreach ($GLOBALS['IN'] as $key => $val)
		{
			if($key!='publishId'&&$key!='nodeId'&&$key!='contentModel'&&$key!='appTableKeyName'&&$key!='appTableKeyValue'&&$key!='type'&&$key!='action'&&$key!='method'&&$key!='IP_ADDRESS'&&$key!='request_method'&&$key!='authCode')
			{
				$newParaArray[$key]= $val;
			}
		}
		$actParamStr = serialize($newParaArray);
		$actParamStr = "&actParams=".base64_encode($actParamStr);
		$nodeInfo = getNodeInfoById($nodeId);
		$contentPlan = getContentInfoById($nodeInfo[0]['contentPlanId']);

		if(!empty($contentPlan))
		{
			if($contentPlan[0]['headerActionId']!='')
			{
				$actionArray = explode(',',$contentPlan[0]['headerActionId']);
				foreach ($actionArray as $key => $val)
				{
					$actionInfo = getActionInfoByGuid($val);
					if(!$headerType)
					{
						$tempUrl = $actionInfo[0]['tplPath'].encrypt_url("action=".$actionInfo[0]['actionName']."&method=".$actionInfo[0]['methodName']."&nodeId=".$nodeId."&contentModel=".$contentModel.$actParamStr);
					}else
					{
						$tempUrl = $actionInfo[0]['tplPath'].encrypt_url("action=cms&method=addExtData&nodeId=".$nodeId."&contentModel=".$contentModel.$actParamStr);
					}
					$str .= "<input type=\"button\" name=\"addbtn\" value=\"".$actionInfo[0]['actionTitle']."\" onclick=\"location.href='".$tempUrl."';\">";
				}
			}
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
function getContentRightMenuAction($nodeId,$fieldConfigId,$contentModel,$tableKeyName)
{
	try {

		$nodeInfo = getNodeInfoById($nodeId);
		$contentPlan = getContentInfoById($nodeInfo[0]['contentPlanId']);
		$str = '<div class="skin0" id="contentRightMenu" name="" onmouseover="highRightMenu(event)" onclick="jumpRightMenu(event);" onmouseout="lowRightMenu(event)">'."\n";;
		$strScript = '<SCRIPT language="JavaScript1.2">'."\n";
		if(!empty($contentPlan))
		{
			if($contentPlan[0]['rightActionId']!='')
			{
				$actionArray = explode(',',$contentPlan[0]['rightActionId']);
				foreach ($actionArray as $key => $val)
				{
					$actionInfo = getActionInfoByGuid($val);
					if(!empty($actionInfo))
					{
						if($actionInfo[0]['methodName']!='')
						{
							$tempUrl = "action=".$actionInfo[0]['actionName']."&method=".$actionInfo[0]['methodName']."&nodeId=".$nodeId."&contentModel=".$contentModel."&appTableKeyName=".$tableKeyName."&frameListAction=cms&frameListMethod=commonListFrame";
							$tempUrl = "index.php".encrypt_url($tempUrl);
							$str .='<DIV class="menuitems" name="" id="'.$actionInfo[0]['methodName'].'" url="'.$tempUrl.'">'.$actionInfo[0]['actionTitle'].'</DIV>'."\n";
							$strScriptA .=$actionInfo[0]['methodName'].'= document.getElementById("'.$actionInfo[0]['methodName'].'");'."\n";
							$strScriptB .=$actionInfo[0]['methodName'].".name=nodeId"."\n";
						}
					}
				}
			}
		}
		$str .="</div>"."\n";
		if($strScriptA!='')
		{
			$strScriptA = "if(getOs()=='Firefox')"."\n"."{"."\n".$strScriptA."}"."\n";
		}
		$strScript .=$strScriptA."document.body.onclick = hideContentRightMenu;"."\n";
		$strScript .="
		function showContentRightMenu(nodeType,menuId,nodeId) {
		//获取当前鼠标右键按下后的位置，据此定义菜单显示的位置
		var event=getEvent();
		var menuIdObj = document.getElementById(menuId);
		var rightedge = document.body.clientWidth-event.clientX;
		var bottomedge = document.body.clientHeight-event.clientY;

		if(nodeType=='contentRightMenu')
		{
			if(menuId=='contentRightMenu')
			{
				".$strScriptB."
			}
		}
		//如果从鼠标位置到窗口右边的空间小于菜单的宽度，就定位菜单的左坐标（Left）为当前鼠标位置向左一个菜单宽度
		if (rightedge <menuIdObj.offsetWidth)
		{
			menuIdObj.style.left = (document.body.scrollLeft + event.clientX - menuIdObj.offsetWidth)+'px';
		}else//否则，就定位菜单的左坐标为当前鼠标位置
		{
			menuIdObj.style.left = (document.body.scrollLeft + event.clientX)+'px';
		}
		//如果从鼠标位置到窗口下边的空间小于菜单的高度，就定位菜单的上坐标（Top）为当前鼠标位置向上一个菜单高度
		if (bottomedge <menuIdObj.offsetHeight)
		{
			//menuIdObj.style.top = (document.body.scrollTop + event.clientY - menuIdObj.offsetHeight)+'px';
			menuIdObj.style.top = (document.body.scrollTop + event.clientY)+'px';
		}else//否则，就定位菜单的上坐标为当前鼠标位置
		{
			menuIdObj.style.top = (document.body.scrollTop + event.clientY)+'px';
		}
		//设置菜单可见
		menuIdObj.style.visibility = \"visible\";
		return false;
	}"."\n";
		$strScript .="</script>";
		$returnStr = $str."\n".$strScript;
		return $returnStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
function getBatchAction($nodeId,$actionMap)
{
	try {
		$str ='<select name="'.$actionMap.'" id="'.$actionMap.'" onchange="batchChange(this.id)">';
		$nodeInfo = getNodeInfoById($nodeId);
		$contentPlan = getContentInfoById($nodeInfo[0]['contentPlanId']);
		$memberId = readSession();
		$groupArray = getGroupIdByStaffNo($memberId);
		if(!empty($contentPlan))
		{
			if($contentPlan[0]['batchActionId']!='')
			{
				$actionArray = explode(',',$contentPlan[0]['batchActionId']);
				foreach ($actionArray as $key => $val)
				{
					if($memberId!='admin')
					{
						if(checkDisplayNodeAuth($groupIdArray,$memberId,$nodeInfo[0]['nodeGuid'],$val))//检测当前用户有没有操作动作的权限
						{
							$actionInfo = getActionInfoByGuid($val);
							$str .= '<option value="'.$actionInfo[0]['methodName'].'">'.$actionInfo[0]['actionTitle'].'</option>';
						}
					}else
					{
						$actionInfo = getActionInfoByGuid($val);
						$str .= '<option value="'.$actionInfo[0]['methodName'].'">'.$actionInfo[0]['actionTitle'].'</option>';
					}
				}
				$str .='</select>';
				return $str;
			}else
			{
				return "";
			}
		}else
		{
			return "";
		}
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *
 * */
function executeCleanCache($appPath)
{
	try {
		if ( $handle = opendir( "$appPath" ) ) {
			while ( false !== ( $item = readdir( $handle ) ) ) {
				if ( $item != "." && $item != ".." ) {
					if ( is_dir( "$appPath/$item" ) ) {
						delFileUnderDir( "$appPath/$item" );
					} else {
						unlink( "$appPath/$item");
					}
				}
			}
			closedir( $handle );
		}
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}

?>