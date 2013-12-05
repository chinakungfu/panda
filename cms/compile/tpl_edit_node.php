<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php if ($this->_tpl_vars["IN"]["authCode"]["0"]["distinctionNo"]=='2'){?>
no pudedom!
<? exit; ?>
<?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<link type="text/css" href="skin/cssfiles/jq/ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/utf.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/base64.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phpserializer.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/powmod.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/xxtea.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/bigint.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phprpc_client.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajaxControl.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script language="javascript" src="skin/jsfiles/dtree.js"></script>
<script type="text/javascript" src="skin/jsfiles/tree/jquery-1.3.2.js"></script>
<script type="text/javascript" src="skin/jsfiles/ui/ui.core.js"></script>
<script type="text/javascript" src="skin/jsfiles/ui/ui.tabs.js"></script>
<link type="text/css" href="demos.css" rel="stylesheet" />
<script>
$(function() {
	$("#tabs").tabs();
});
function checkIsParent(value)
{
	var detailOperation = document.getElementById('detailOperation');
	if(value=='0')
	{
		detailOperation.style.display='none';
	}else
	{
		detailOperation.style.display='';
	}
}
function tplSelect(tpl,form, element)
{
	var arr = showModalDialog("http://localhost/commoncms/cms/compile/admin_select.php?sId=<?php echo $this->_tpl_vars["sId"];?>&o=tpl&tpl=" + tpl,"color","dialogWidth:428px;dialogHeight:266px;help:0;status:0;scroll:no");
	if(arr != null) {
		with(form){
			eval(element + ".value= '" +  arr + "'")
		}
	}
}

//选择文件夹
function chooseFolder(id){
	var savePath;
	var objSrc=new ActiveXObject("Shell.Application").BrowseForFolder(0,'请选择文件目录:',0,"");
	if(objSrc!=null){
		savePath=objSrc.self.Path;
		document.getElementById(id).value=savePath;
	}
}
//改变模板目录
function changeSubDir(value,el)
{
	var subDir = document.getElementById(el);
	subDir.value = value;
}
function openFormatFileWindows(url,title)
{
	window.open(url, title, 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
}
function checkNodeFlag(value)
{
	call_tpl('cms','checkNodeFlag','backShowMessage(\'checkNodeFlagMessage\')','return',value,'');
}
function fullNodeFlag(value)
{
	call_tpl('cms','fullNodeFlag','backGetData(\'nodeGuid\')','return',value,'');
}
function changeCheck(value)
{
	var appWhereSQL = document.getElementById('appWhereSQL');
	var appInsertArray = document.getElementById('appInsertArray');
	var appValidArray = document.getElementById('appValidArray');
	if(value=='1')
	{
		appWhereSQL.readOnly = false;
		appInsertArray.readOnly = false;
		appValidArray.readOnly = false;
	}else
	{
		appWhereSQL.readOnly = true;
		appInsertArray.readOnly = true;
		appValidArray.readOnly = true;
	}
}
function checkChecks(chcksName,dataStr)
{
//	alert(chcksName);
//	alert(dataStr);
	var actionchecks=document.getElementsByName(chcksName);
	//var actionId=document.getElementById('actionId');
	var actionArray = dataStr.split(',');
	for(i=0;i<actionchecks.length;i++)
	{
		for(j=0;j<actionArray.length;j++)
		{
//			alert("arr:"+actionArray[j]);
//			alert("chcks:"+actionchecks[i].value);
			if(actionArray[j]==actionchecks[i].value)
			{
				actionchecks[i].checked = true;
			}
		}
	}
}
 
function saveAuth()
{
	prepareSubmit();
	document.forms[0].action.value="cms";
	document.forms[0].method.value="saveNodeAuth";
	document.forms[0].submit();
}

function prepareSubmit(){
		<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
		<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
			select_submit('clientform', 'targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'dataGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>');
			select_submit('clientform', 'targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'dataUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>');
		<?php  }
} ?> 
		return true;
}


</script>
</head>

<body>

<form method="post" action="index.php" name='clientform' id=clientform >
<input type="hidden" name="action" value="cms">
	
	<?php if ($this->_tpl_vars["method"]=='addNode'){?>
		<input type="hidden" name="method" value="saveAddNode">
		<input type="hidden" class="edit" name="nodeId" value="">
		<?php $this->_tpl_vars["parentNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"],'')); ?>
		<input type="hidden" class="edit" name="para[parentId]" value="<?php echo $this->_tpl_vars["parentNode"]["0"]["nodeGuid"];?>" >
		<?php if ($this->_tpl_vars["parentId"]!=''){?>
			<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoByNodeGuid',array($this->_tpl_vars["parentId"])); ?>
		<?php } ?>
	<?php }else{ ?>
		<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"],'')); ?>
		<input type="hidden" name="method" value="saveEditNode">
		<input type="hidden" class="edit" name="nodeId" value="<?php echo $this->_tpl_vars["node"]["0"]["nodeId"];?>" >
		<input type="hidden" class="edit" name="para[parentId]" value="<?php echo $this->_tpl_vars["node"]["0"]["parentId"];?>" >
	<?php } ?>
	<div class="main_content">
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">结点设置</a></li>
			<li><a href="#tabs-2">权限设置</a></li>
		</ul>
		<div id="tabs-1">
			<div style="clear:both"></div>
			<div class="search_content detailMember">       
					<div class="detailMember_nav">基本信息</div>
						<div class="detailMember_txt">父结点：</div>
						<?php if ($this->_tpl_vars["method"]=='addNode'){?>
						<div class="detailMember_info"><?php runFunc('getNodeParentById',array($this->_tpl_vars["parentNode"]["0"]["nodeGuid"],''))?>&nbsp;</div>
						<?php }else{ ?>
						<div class="detailMember_info"><?php runFunc('getNodeParentById',array($this->_tpl_vars["node"]["0"]["nodeGuid"],''))?>&nbsp;</div>
						<?php } ?>
						<div class="detailMember_txt">结点名称：</div>
						<?php if ($this->_tpl_vars["method"]=='addNode'){?>
						<div class="detailMember_info"><input type="text" id="nodeName" name="para[nodeName]" value="" onblur="fullNodeFlag(this.value);"></div>
						<?php }else{ ?>
						<div class="detailMember_info"><input type="text" id="nodeName" name="para[nodeName]" value="<?php echo $this->_tpl_vars["node"]["0"]["nodeName"];?>"></div>
						<?php } ?>
						<div class="detailMember_txt">结点唯一标识符：</div>
						<div class="detailMember_info">
						<?php if ($this->_tpl_vars["method"]!='addNode'){?>
							<input type="text" id="nodeGuid" name="para[nodeGuid]" value="<?php echo $this->_tpl_vars["node"]["0"]["nodeGuid"];?>" disabled>
						<?php }else{ ?>
							<input type="text" id="nodeGuid" name="para[nodeGuid]" value="">
						<?php } ?>
						该标识符唯一标识该结点可以代替nodeId进行CMS内容调用</div>
						<div id="checkNodeFlagMessage"></div>
						<div class="detailMember_txt">发布模式：</div>
						<div>
						<input type='radio' id="publishMode" name='para[publishMode]' value="1" onclick="changeDisplayData(this.value);">静态发布
						<input type='radio' id="publishMode" name='para[publishMode]' value="2" onclick="changeDisplayData(this.value);">动态发布
						<input type='radio' id="publishMode" name='para[publishMode]' value="3" onclick="changeDisplayData(this.value);">不对外发布
						</div>
						<div class="detailMember_txt">自动发布：</div>
						<div>
						<input type='radio' id="isAutoPublish" name='para[isAutoPublish]' value="1">是
						<input type='radio' id="isAutoPublish" name='para[isAutoPublish]' value="0">否
						</div>
						<div class="detailMember_txt">内容编辑方案：</div>
						<div class="detailMember_info">
						<select id="contentPlanId" name="para[contentPlanId]">
						<?php echo runFunc('selectContentPlanName',array());?>
						</select>
						</div>
						<div class="detailMember_txt">内容模型套用表：</div>
						<div class="detailMember_info">
						<?php if ($this->_tpl_vars["method"]=='editNode'&&$this->_tpl_vars["node"]["0"]["appTableName"]!=''){?>
						<select id="appTableName" name="para[appTableName]" disabled>
						<?php }else{ ?>
						<select id="appTableName" name="para[appTableName]">
						<?php } ?>
						<option value=""></option>
						<?php echo runFunc('selectTableName',array());?>
						</select>一旦选择将不可再更改
						</div>
						<div class="detailMember_txt">字段配置方案：</div>
						<div class="detailMember_info">
						<?php if ($this->_tpl_vars["method"]=='editNode'&&$this->_tpl_vars["node"]["0"]["fieldConfigId"]!=''){?>
						<select id="fieldConfigId" name="para[fieldConfigId]" disabled>
						<?php }else{ ?>
						<select id="fieldConfigId" name="para[fieldConfigId]">
						<?php } ?>
						<option value=""></option>
						<?php echo runFunc('selectFieldConfigName',array());?>
						</select>一旦选择将不可再更改
						</div>
						<div class="detailMember_txt">SEO配置：</div>
						<div class="detailMember_info">
						<?php if ($this->_tpl_vars["method"]=='editNode'&&$this->_tpl_vars["node"]["0"]["seoConfig"]!=''){?>
						<select id="seoConfig" name="para[seoConfig]" disabled>
						<?php }else{ ?>
						<select id="seoConfig" name="para[seoConfig]">
						<?php } ?>
						<option value=""></option>
						<?php echo runFunc('selectSeoName',array());?>
						</select>一旦选择将不可再更改
						</div>
						<div class="detailMember_txt">应用内容模型键值名：</div>
						<div class="detailMember_info"><input type="text" id="appTableKeyName" name="para[appTableKeyName]" value="<?php echo $this->_tpl_vars["node"]["0"]["appTableKeyName"];?>"></div>
						<div class="detailMember_nav">内容校验设置</div>
						<div class="detailMember_txt">是否定义校验条件：</div>
						<input type="radio" id="isCheck" name="para[isCheck]"  value="0" checked onclick="changeCheck(this.value);">否
						<input type="radio" id="isCheck" name="para[isCheck]"  value="1" onclick="changeCheck(this.value);">是
						<input type="hidden" id="isDefaultCon" name="para[isDefaultCon]" value="<?php echo $this->_tpl_vars["node"]["0"]["isDefaultCon"];?>">
						<div class="detailMember_txt">应用内容模型条件：</div>
						<div class="detailMember_info">
						<input type="text" id="appWhereSQL" name="para[appWhereSQL]" value="<?php echo $this->_tpl_vars["node"]["0"]["appWhereSQL"];?>" readonly>
						如：字段名1='xxxx',...,字段名n=nnnn。
						</div>
						<div class="detailMember_txt">应用内容模型默认插入数组：</div>
						<div class="detailMember_info">
						<input type="text" id="appInsertArray" name="para[appInsertArray]" value="<?php echo $this->_tpl_vars["node"]["0"]["appInsertArray"];?>" readonly>
						如：字段名1='xxxx',...,字段名n=>'nnnn'
						</div>
						<div class="detailMember_txt">应用内容模型默认校验数组：</div>
						<div class="detailMember_info">
						<input type="text" id="appValidArray" name="para[appValidArray]" value="<?php echo $this->_tpl_vars["node"]["0"]["appValidArray"];?>" readonly>
						如：字段名1>'100',...,字段名n<'500'
						</div>
					<div class="detailMember_nav">模板设置</div>
						<div class="detailMember_txt">首页模板：</div>
						<div class="detailMember_info">
						<input type="text" id="indexTpl" name="para[indexTpl]" value="<?php echo $this->_tpl_vars["node"]["0"]["indexTpl"];?>"></div>
						<div class="detailMember_txt">内容页模板：</div>
						<div class="detailMember_info">
						<input type="text" id="contentTpl" name="para[contentTpl]" value="<?php echo $this->_tpl_vars["node"]["0"]["contentTpl"];?>"></div>
						<div class="detailMember_txt">图片页模板：</div>
						<div class="detailMember_info">
						<input type="text" id="imageTpl" name="para[imageTpl]" value="<?php echo $this->_tpl_vars["node"]["0"]["imageTpl"];?>"></div>
					<div id="staticPublish" style="display:none">
					<div class="detailMember_nav">静态发布设置</div>
						<div class="detailMember_txt">首页静态内容发布入口：</div>
						<div class="detailMember_info">
						<input type="text" id="contentPortalURL" name="para[staticIndexUrl]" value="<?php echo $this->_tpl_vars["node"]["0"]["staticIndexUrl"];?>"></div>
						<div class="detailMember_txt">内容页静态内容发布入口：</div>
						<div class="detailMember_info">
						<input type="text" id="contentPortalURL" name="para[staticContentUrl]" value="<?php echo $this->_tpl_vars["node"]["0"]["staticContentUrl"];?>"></div>	
						<div class="detailMember_txt">图片页静态内容发布入口：</div>
						<div class="detailMember_info">
						<input type="text" id="contentPortalURL" name="para[staticImageUrl]" value="<?php echo $this->_tpl_vars["node"]["0"]["staticImageUrl"];?>"></div>
					
						<div class="detailMember_txt">静态内容发布点(PSN)：</div>
						<div class="detailMember_info">
						<input type="text" id="contentPSN" name="para[contentPSN]" value="<?php echo $this->_tpl_vars["node"]["0"]["contentPSN"];?>"></div>
						<div class="detailMember_txt">静态内容发布URL：</div>
						<div class="detailMember_info"><input type="text" id="contentURL" name="para[contentURL]" value="<?php echo $this->_tpl_vars["node"]["0"]["contentURL"];?>"></div>
						<div class="detailMember_txt">结点首页文件名：</div>
						<div class="detailMember_info"><input type="text" id="indexName" name="para[indexName]" value="<?php echo $this->_tpl_vars["node"]["0"]["indexName"];?>"></div>
						<div class="detailMember_txt">静态发布分卷目录结构：</div>
						<div class="detailMember_info">
						<input type="text" id="subDir" name="para[subDir]" value="<?php echo $this->_tpl_vars["node"]["0"]["subDir"];?>">
						<select name="selSubDir" id="selSubDir" onchange="changeSubDir(this.value,'subDir');">
						<option value="">-</option>
			          	<option value="">none</option>
			          	<option value="Y-m-d">Y-m-d</option>
			          	<option value="Y/m/d">Y/m/d</option>
			          	<option value="Y-m">Y-m</option>
			          	<option value="Y">Y</option>
			          	<option value="auto">auto</option>
			          	</select>
			          	</div>
						<div class="detailMember_txt">静态发布文件格式：</div>
						<div class="detailMember_info">
						<input type="text" id="publishFileFormat" name="para[publishFileFormat]" value="<?php echo $this->_tpl_vars["node"]["0"]["publishFileFormat"];?>">
						<?php $this->_tpl_vars["tempUrl"]='action=cms&method=staticFileDialog&backId=publishFileFormat&publishFileFormat='.$this->_tpl_vars["node"]["0"]["publishFileFormat"]; ?>
						<input type="button" value="..." onclick="openFormatFileWindows('index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>','静态文件格式');"></div>
					</div>
					<div id="dynamicPublish" style="display:none">
						<div class="detailMember_nav">动态发布设置</div>
						<div class="detailMember_txt">首页动态入口URL：</div>
						<div class="detailMember_info"><input type="text" id="appUrl" name="para[dynamicIndexUrl]" value="<?php echo $this->_tpl_vars["node"]["0"]["dynamicIndexUrl"];?>"></div>
						<div class="detailMember_txt">内容页动态入口URL：</div>
						<div class="detailMember_info"><input type="text" id="appUrl" name="para[dynamicContentUrl]" value="<?php echo $this->_tpl_vars["node"]["0"]["dynamicContentUrl"];?>"></div>
						<div class="detailMember_txt">图片页动态入口URL：</div>
						<div class="detailMember_info"><input type="text" id="appUrl" name="para[dynamicImageUrl]" value="<?php echo $this->_tpl_vars["node"]["0"]["dynamicImageUrl"];?>"></div>
						
					</div>
			    <div class="detailMember_doedit"><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
			    </div>
		</div>
		<div id="tabs-2">
			<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"],'')); ?>
			<div class="search_content detailMember">
			<table class="tableList" border="1" id="list" width="100%">
			<tr>
				<td class="listHeader" width="120px">原始创建人:</td>
				<td class="tdListItem"><?php echo $this->_tpl_vars["node"]["0"]["memberId"];?></td>
			</tr>
			<tr>
				<td class="listHeader" width="80px">继承父结点权限:</td>
				<td class="tdListItem">
				<table>
				<tr>
				<td>
				<input type="radio" name="isParent" value="1" onclick="checkIsParent(this.value)" checked>是
				<input type="radio" name="isParent" value="0" onclick="checkIsParent(this.value)">否
				</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td class="listHeader" colspan="2">
				<table>
				<tr>
				<td>
				用户组权限设置
				</td>
				</tr>
				</table>
				</td>
			</tr>
			<div id="detailOperation" style="display:none">
			<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
			<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
			<tr>
				<td class="tdListItem" width="80px"><?php echo $this->_tpl_vars["var"]["actionTitle"];?>-用户组</td>
				<td class="tdListItem">
				<table border="0">
					<tr>
						<td>用户组<br>
						<input type="hidden" name="group[dataGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>]" id="dataGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>" value="">
						<select name="srcGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>" id="srcGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>" onDblClick="select_move_to(this.form, 'srcGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')" size="10" style="width:100px;">
						<?php $this->_tpl_vars["result"]=runFunc('listGroup',array($this->_tpl_vars["sqlCon"],'')); ?>
						<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key1']=>$this->_tpl_vars['var1']){ ?>
						
						<?php $this->_tpl_vars["isCheckNodeAuth"]=runFunc('checkNodeAuthGroupId',array($this->_tpl_vars["node"]["0"]["nodeGuid"],$this->_tpl_vars["var"]["actionGuid"],$this->_tpl_vars["var1"]["groupNo"],'0')); ?>
						<?php if (!$this->_tpl_vars["isCheckNodeAuth"]){?>
							<option value="<?php echo $this->_tpl_vars["var1"]["groupNo"];?>"><?php echo $this->_tpl_vars["var1"]["groupName"];?></option>
						<?php } ?>
						<?php  }
} ?>
						</select>
						</td>
						<td>
						<br>
						<input type="button" value="=>" onClick="select_move_to(this.form, 'srcGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')"><br><br>
						<input type="button" value="<=" onClick="select_move_to(this.form, 'targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'srcGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')"><br><br>
						<input type="button" value="全选" onClick="select_move_all_to(this.form, 'srcGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')"><br>
						<input type="button" value="全删" onClick="select_move_all_to(this.form, 'targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'srcGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')"></td>
						<td>选定组<br>
						<select name="group[targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>]" id="targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"  onDblClick="select_move_to(this.form, 'targetGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'srcGroup<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')" size="10" style="width:100px;">
						<?php $this->_tpl_vars["nodeAuth"]=runFunc('checkNodeAuth',array($this->_tpl_vars["node"]["0"]["nodeGuid"],$this->_tpl_vars["var"]["actionGuid"])); ?>
						<?php if(!empty($this->_tpl_vars['nodeAuth'])){ 
 foreach ($this->_tpl_vars['nodeAuth'] as $this->_tpl_vars['key2']=>$this->_tpl_vars['var2']){ ?>
							<?php $this->_tpl_vars["groupRes"]=getGroupInfoByStr($this->_tpl_vars["var2"]["groupId"]); ?>
								<?php if(!empty($this->_tpl_vars['groupRes'])){ 
 foreach ($this->_tpl_vars['groupRes'] as $this->_tpl_vars['key3']=>$this->_tpl_vars['var3']){ ?>
									<option value="<?php echo $this->_tpl_vars["var3"]["groupId"];?>"><?php echo $this->_tpl_vars["var3"]["groupName"];?></option>
								<?php  }
} ?>
						<?php  }
} ?>
						</select>
					</td>
					</tr>
				</table>
           		
				
				</td>
			</tr>
			<?php  }
} ?>
			<tr>
				<td class="listHeader" colspan="2">
				<table>
				<tr>
				<td>
				用户权限设置
				</td>
				</tr>
				</table></td>
			</tr>
			<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
			<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
			<tr>
				<td class="tdListItem" width="80px"><?php echo $this->_tpl_vars["var"]["actionTitle"];?>-用户</td>
				<td class="tdListItem">
				<table border="0">
					<tr>
						<td>用户<br>
						<input type="hidden" name="user[dataUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>]" id="dataUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>" value="">
						<select name="srcUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>" id="srcUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"  onDblClick="select_move_to(this.form, 'srcUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')" size="10" style="width:100px;">
						<?php $this->_tpl_vars["result"]=runFunc('listStaff',array($this->_tpl_vars["sqlCon"],'1')); ?>
						<?php if(!empty($this->_tpl_vars['result'])){ 
 foreach ($this->_tpl_vars['result'] as $this->_tpl_vars['key1']=>$this->_tpl_vars['var1']){ ?>
							<?php $this->_tpl_vars["isCheckNodeAuth"]=runFunc('checkNodeAuthGroupId',array($this->_tpl_vars["node"]["0"]["nodeGuid"],$this->_tpl_vars["var"]["actionGuid"],$this->_tpl_vars["var1"]["staffNo"],'1')); ?>
							<?php if (!$this->_tpl_vars["isCheckNodeAuth"]){?>
								<option value="<?php echo $this->_tpl_vars["var1"]["staffNo"];?>"><?php echo $this->_tpl_vars["var1"]["staffName"];?></option>
							<?php } ?>
						<?php  }
} ?>
						</select>
						</td>
						<td>
						<br>
						<input type="button" value="=>" onClick="select_move_to(this.form, 'srcUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')"><br><br>
						<input type="button" value="<=" onClick="select_move_to(this.form, 'targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'srcUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')"><br><br>
						<input type="button" value="全选" onClick="select_move_all_to(this.form, 'srcUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')"><br>
						<input type="button" value="全删" onClick="select_move_all_to(this.form, 'targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'srcUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')"></td>
						<td>选定用户<br>
						<select name="user[targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>]" id="targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"  onDblClick="select_move_to(this.form, 'targetUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>', 'srcUser<?php echo $this->_tpl_vars["var"]["actionGuid"];?>')" size="10" style="width:100px;">
						<?php $this->_tpl_vars["nodeAuth"]=runFunc('checkNodeAuth',array($this->_tpl_vars["node"]["0"]["nodeGuid"],$this->_tpl_vars["var"]["actionGuid"])); ?>
						<?php if(!empty($this->_tpl_vars['nodeAuth'])){ 
 foreach ($this->_tpl_vars['nodeAuth'] as $this->_tpl_vars['key2']=>$this->_tpl_vars['var2']){ ?>
							<?php $this->_tpl_vars["userRes"]=getStaffInfoByStr($this->_tpl_vars["var2"]["memberId"]); ?>
								<?php if(!empty($this->_tpl_vars['userRes'])){ 
 foreach ($this->_tpl_vars['userRes'] as $this->_tpl_vars['key3']=>$this->_tpl_vars['var3']){ ?>
									<option value="<?php echo $this->_tpl_vars["var3"]["staffNo"];?>"><?php echo $this->_tpl_vars["var3"]["staffName"];?></option>
								<?php  }
} ?>
						<?php  }
} ?>
						</select>
					</td>
					</tr>
				</table>
				
				</td>
			</tr>
			<?php  }
} ?>
			
			</div>
			</table>
			<input type="button" name="auth" value="保存" onclick="saveAuth();">
			</div>
		</div>
	</div>
    </form> 
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
<script>
changeCheck(<?php echo $this->_tpl_vars["node"]["0"]["isCheck"];?>);
radioIsSelected('publishMode','<?php echo $this->_tpl_vars["node"]["0"]["publishMode"];?>');
radioIsSelected('isAutoPublish','<?php echo $this->_tpl_vars["node"]["0"]["isAutoPublish"];?>');
radioIsSelected('isCheck','<?php echo $this->_tpl_vars["node"]["0"]["isCheck"];?>');
jsSelectValue("contentPlanId",'<?php echo $this->_tpl_vars["node"]["0"]["contentPlanId"];?>');
jsSelectValue("appTableName",'<?php echo $this->_tpl_vars["node"]["0"]["appTableName"];?>');
jsSelectValue("fieldConfigId",'<?php echo $this->_tpl_vars["node"]["0"]["fieldConfigId"];?>');
jsSelectValue("seoConfig",'<?php echo $this->_tpl_vars["node"]["0"]["seoConfig"];?>');
changeDisplayData('<?php echo $this->_tpl_vars["node"]["0"]["publishMode"];?>');
</script>
</body>
</html>
