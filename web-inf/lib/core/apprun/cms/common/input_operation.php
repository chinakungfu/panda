<?
/**
 * add zxqer 20081120
 * 该文件主要用来设置通用ＣＭＳ的表单的
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
/**
 *表单字符串输出 
 **/       
function inputStr($fieldTitle,$fieldName,$fieldValue,$fieldInputType,$fieldDefault,$fieldLimit,$fieldHelp,$filedType='',$fieldUrl='',$nodeId=null)
{
	try
	{
		$titleStr = '<div class="detailMember_txt">';
		$editStr = '<div class="detailMember_info">';
		$divEnd = '</div>';
		$inputLimitStr = inputLimit($fieldLimit);
		$inputHelpStr = inputHelp($fieldName,$fieldValue,$fieldHelp);
		switch ($fieldInputType)
		{
			case text :
				$editFieldStr .= $titleStr.$fieldTitle.$divEnd;
				if($fieldHelp!='date')
				{
					$editFieldStr .= $editStr.'<input type="text" id="'.$fieldName.'" name="para['.$fieldName.']" value="'.$fieldValue.'" '.$inputLimitStr.'>'.$inputHelpStr.$divEnd;
				}else 
				{
					$editFieldStr .= $editStr.'<input type="text" id="'.$fieldName.'" name="para['.$fieldName.']" value="'.$fieldValue.'" '.$inputLimitStr.' '.$inputHelpStr.'>'.$divEnd;
				}
				return $editFieldStr;
				break;	
			case textarea:
				$editFieldStr .= $titleStr.$fieldTitle.$divEnd;
				$editFieldStr .= $editStr.'<textarea type="text" rows="10" cols="72" id="'.$fieldName.'" name="para['.$fieldName.']" '.$inputLimitStr.'>'.$fieldValue.'</textarea>'.$divEnd;
				return $editFieldStr;
				break;
			case select:
				if($filedType!='contentlink')
				{
					$editFieldStr .= $titleStr.$fieldTitle.$divEnd;
					$editFieldStr .= $editStr.'<select id="'.$fieldName.'" name="para['.$fieldName.']">';
					if($fieldDefault!='')
					{
						$fieldDefaultArray = explode(';',$fieldDefault); 
						//print_r($fieldDefaultArray);
						for($i=0;$i<count($fieldDefaultArray);$i++)
						{
							if(strpos("test".$fieldDefaultArray[$i],':')>0)//用户自己定义select的value值与name值如：aaa:bbb;ccc:ddd mofify zxq 20110711
							{
								$fieldSubDefArray = explode(':',$fieldDefaultArray[$i]);
								$editFieldStr .= '<option value="'.$fieldSubDefArray[0].'">'.$fieldSubDefArray[1].'</option>';
								
							}else//aaa;bbb;ccc;ddd
							{
								$optionValue = $i+1;
								$editFieldStr .= '<option value="'.$optionValue.'">'.$fieldDefaultArray[$i].'</option>';
							}
						}
					}else 
					{
						$fieldDefaultArray = getFieldInfoBySql($fieldUrl);
						foreach ($fieldDefaultArray['data'] as $key => $val)
						{
							$editFieldStr .= '<option value="'.$val[$fieldDefaultArray['selectInfo'][0]].'">'.$val[$fieldDefaultArray['selectInfo'][1]].'</option>';
						}
					}
					$editFieldStr .= "</select>".$divEnd;
					$editFieldStr .= "<script>jsSelectValue('".$fieldName."','".$fieldValue."');</script>";
				}else
				{
					$fieldUrlArray = explode('?',$fieldUrl . "&nodeId=$nodeId&fieldName=$fieldName");
					$url = encrypt_url($fieldUrlArray[1]);
					$url = $fieldUrlArray[0].$url;
					if(!empty($fieldValue)){
						import("core.apprun.cmsware.CmswareNode");
						$oNode=new Node;
						
						$options="";
						foreach(explode(',',$fieldValue) as $v){
							$sql="select nodeId from cms_cms_app_publish_state where publishId=$v";
							$node=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
						
							$node=$oNode->getNodeInfo($node[0]['nodeId'],'nodeGuid,appTableName,appTableKeyName');
							$sql="select i.publishId, c.title from cms_cms_app_publish_state i, {$node['appTableName']} c where i.nodeId=c.nodeId and i.contentId=c.{$node['appTableKeyName']} and i.nodeId='{$node['nodeGuid']}' and i.publishId = $v";
							$list=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
							if(!empty($list)){
								
								foreach($list as $val){
									$options.="<option value={$val['publishId']}>{$val['title']}</option>";
								}
							}
						}
					}
					$editFieldStr .= $titleStr.$fieldTitle.$divEnd;
					$editFieldStr .= '<table border=0 cellPadding=2 cellSpacing=0 >
					<tr><td >
					<select id=CustomLinks_' . $fieldName . ' size=10>'.$options.'</select><INPUT TYPE=hidden id='.$fieldName.' name=para['.$fieldName.'] value="'.$fieldValue.'">
					</td><td class=line_height>&nbsp;<input name=button5 type=button tabindex=13  value=× onclick=fieldRelDel("CustomLinks_'.$fieldName.'")>
					<br><br>&nbsp;<input name=button5 type=button tabindex=13 value=∧ onclick=fieldRelMoveUp("CustomLinks_'.$fieldName.'")><br>&nbsp;
					<input name=button5 type=button tabindex=13 value=∨ onclick=fieldRelMoveDown("CustomLinks_'.$fieldName.'")><br><br>
					&nbsp;<input name="button5" type=button tabindex=13 value=... onclick=fieldRelEditContentLink("'.$url.'")></td><td>
					&nbsp;<input name=button5 type=button tabindex=13 value=&nbsp;Go&nbsp; onclick=fieldRelGoSelect("CustomLinks_'.$fieldName.'")></td></tr></table>';
				}
				return $editFieldStr;
				break;
			case radio:
				$editFieldStr .= $titleStr.$fieldTitle.$divEnd;
				if($fieldDefault!='')
				{
					$fieldDefaultArray = explode(';',$fieldDefault); 
					for($i=0;$i<count($fieldDefaultArray);$i++)
					{
						$editFieldStr .= '<input type="radio" id="'.$fieldName.'" name="para['.$fieldName.']" value="'.$i.'">'.$fieldDefaultArray[$i];
					}
				}
				$editFieldStr .= "<script>radioIsSelected('".$fieldName."','".$fieldValue."');</script>";
				return $editFieldStr;
				break;
			case checkbox:
				$editFieldStr .= $titleStr.$fieldTitle.$divEnd;
				if($fieldDefault!='')
				{
					$fieldDefaultArray = explode(';',$fieldDefault); 
					$editFieldStr .= '<input type="hidden" id="'.$fieldName.'" name="para['.$fieldName.']" value="'.$fieldValue.'">'; 
					for($i=0;$i<count($fieldDefaultArray);$i++)
					{
						if(strpos($fieldDefaultArray[$i],':')>0)
						{
							$fieldSubDefArray = explode(':',$fieldDefaultArray[$i]);
							$editFieldStr .= '<input type="checkbox" id="'.$fieldName.$i.'" name="'.$fieldName.'" value="'.$fieldSubDefArray[0].'" onclick="selectCheckBox(this)"><label for="'.$fieldSubDefArray[0].'">'.$fieldSubDefArray[1].'</label>';
						}else
						{
							$editFieldStr .= '<input type="checkbox" id="'.$fieldName.$i.'" name="'.$fieldName.'" value="'.$i.'" onclick="selectCheckBox(this.name,this.value)"><label for="'.$i.'">'.$fieldDefaultArray[$i].'</label>';
						}
					}
				}
				$editFieldStr .= "<script>checkBoxIsSelected('".$fieldName."','".$fieldValue."');</script>";
				return $editFieldStr;
				break;
			case password:
				$editFieldStr .= $titleStr.$fieldTitle.$divEnd;
				$editFieldStr .= $editStr.'<input type="password" id="'.$fieldName.'" name="para['.$fieldName.']" value="'.$fieldValue.'" '.$inputLimitStr.'>'.$divEnd;
				return $editFieldStr;
				break;
			case richEditor:
				$editFieldStr .= $titleStr.$fieldTitle.$divEnd;
				$editFieldStr .= $editStr.'<textarea type="text" id="'.$fieldName.'" name="para['.$fieldName.']" '.$inputLimitStr.'>'.$fieldValue.'</textarea>'.$divEnd;
				$editFieldStr .= "<script language=\"JavaScript\" type=\"\" > 
	var oFCKeditor = new FCKeditor('".$fieldName."' ) ;
	oFCKeditor.BasePath = '../fckeditor/' ;
	oFCKeditor.preBasePath = '../infomation/' ;
	oFCKeditor.ToolbarSet = 'Default' ;
	oFCKeditor.Width = '800' ;
	oFCKeditor.Height = '351' ;
	oFCKeditor.Value = '' ;
	//oFCKeditor.Create() ;
	oFCKeditor.ReplaceTextarea() ;
</script>";
			return $editFieldStr;
			default:
				return '';			
		}
	} catch (Exception $e)
	{
		throw $e;
	}
}
function inputLimit($fieldLimit)
{
	try {
		switch ($fieldLimit)
		{
			case notnull :
				$str .= 'onblur="isNotNull();"';
				return $str;
				break;
			case num :
				$str .= 'onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"';
				return $str;
				break;
			case num_letter :
				$str .= 'onKeypress="if ((event.keyCode < 48 || event.keyCode > 57)&&(event.keyCode < 65 || event.keyCode > 90)&&(event.keyCode < 97 || event.keyCode > 122)) event.returnValue = false;"';
				return $str;
				break;
			case unique :
				$str .= 'onblur="isNumLetter();"';
				return $str;
				break;
			default:
				return '';
				break;
		}
	} catch (Exception $e)
	{
		throw $e;
	}
}

function inputHelp($fieldName,$fieldValue,$fieldHelp)
{
	try { 
		switch ($fieldHelp)
		{
			case color :
				$str = '<input id="'.$fieldName.'" name="'.$fieldValue.'" type="button" value="..." onclick="callColorDlg(this.id,this.name)">';
				return $str;
				break;
			case date :
				$str = 'onclick="calendar();"';
				return $str;
				break;
			case upload :
				$url = encrypt_url('action=resource&method=singleImage&location=image&appName=cms');
				$str = '<input name="'.$fieldName.'" type="button" value="..." onclick="submitHead(\'../resource/index.php'.$url.'\',this.name)">';
				$str .= '<input type="hidden" name="resourceId" id="resourceId">';
				return $str;
				break;
			case upload_attach :
				$url = encrypt_url('action=resource&method=singleImage&location=image&appName=cms');
				$str = '<input name="'.$fieldName.'" type="button" value="上传" onclick="submitHead(\'../resource/index.php'.$url.'\',this.name)">';
				$str .= '<input type="hidden" name="resourceId" id="resourceId">';
				return $str;
				return $str;
				break;
			case tpl :
				return $str;
				break;
			case psn :
			case content :
				return $str;
				break;
			default:
				return '';
		}
	} catch (Exception $e)
	{
		throw $e;
	}
}
function getFieldInfoBySql($sqlStr,$sqlCon='')
{
	try {
		$sqlStr  = str_replace("{hao}",",",$sqlStr);
		$sqlStr  = str_replace("{table_pre}",$GLOBALS['currentApp']['table_pre'],$sqlStr);
		$reg = "/(select|SELECT)(.*?)(from|FROM)(.*?)$/U";
		if (preg_match_all($reg,$sqlStr,$matches))
		{
			if($sqlCon!='')
			{
				$sqlCon = " where ".substr($matches[2][0],0,strpos($matches[2][0],','))."=".$sqlCon;
			}
			$sqlStr = $sqlStr.$sqlCon;
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlStr,$dataArray);
		}
		$returnResult['data'] = $result;
		$returnResult['selectInfo'] = explode(",",trim($matches[2][0]));
		return $returnResult;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>