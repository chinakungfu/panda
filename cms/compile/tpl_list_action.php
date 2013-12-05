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

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script language=JavaScript type="" >
function editContentPlan()
{
	select_submit('contentFrom', 'targetHeaderActionId', 'headerActionId');
	select_submit('contentFrom', 'targetRightActionId', 'rightActionId');
	select_submit('contentFrom', 'targetContentActionId', 'contentActionId');
	select_submit('contentFrom', 'targetBatchActionId', 'batchActionId');
	document.forms[0].action.value="cms";
	document.forms[0].method.value="saveEditContentPlan";
	document.forms[0].submit();
}
function addAction()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="addAction";
	document.forms[0].submit();
}
function actionOrder()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="actionOrder";
	document.forms[0].submit();
}
function getActionId()
{
	var actionchecks=document.getElementsByName('actionchecks');
	var con = '';
	for(i=0;i<actionchecks.length;i++)
	{
		if(actionchecks[i].checked)
		{
			con = actionchecks[i].value+','+con
		}
	}
	document.all.actionId.value = con;
}
function checkChecks()
{
	var actionchecks=document.getElementsByName('actionchecks');
	var actionId=document.getElementById('actionId');
	var actionArray = actionId.value.split(',');
	for(i=0;i<actionchecks.length;i++)
	{
		for(j=0;j<actionArray.length;j++)
		{
			if(actionArray[j]==actionchecks[i].value)
			{
				actionchecks[i].checked = true;
			}
		}
	}
}
</script>
<style type="text/css">
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	color: #666666;
	text-decoration: none;
}
a:hover {
	color: #666666;
	text-decoration: underline;
}
a:active {
	color: #666666;
	text-decoration: none;
}
</style></head>
<body>


<?php if ($this->_tpl_vars["contentPlanId"]!=''){?>
<div class="main_content">
   	<div class="main_content_nav">当前位置： 系统管理 >> 内容编辑方案 >>修改内容编辑方案</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="contentPlanId" value="<?php echo $this->_tpl_vars["contentPlanId"];?>">
<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
<?php $this->_tpl_vars["contentPlan"]=runFunc('getContentPlanInfoById',array($this->_tpl_vars["contentPlanId"])); ?>
<div class="detailMember_nav">新建内容编辑方案</div>
	<div class="detailMember_txt">内容编辑方案名称：</div>
	<div class="detailMember_info"><input type="text" name="para[contentPlanName]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["contentPlanName"];?>" ></div>
	<div class="detailMember_txt">内容编辑分页数：</div>
	<div class="detailMember_info"><input type="text" name="para[contentPlanPage]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["contentPlanPage"];?>" ></div>
	<div class="detailMember_txt">内容编辑分页长度：</div>
	<div class="detailMember_info"><input type="text" name="para[contentPlanSize]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["contentPlanSize"];?>" ></div>
	<div class="detailMember_txt">内容编辑方案说明：</div>
	<div class="detailMember_info"><input type="text" name="para[contentPlanDes]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["contentPlanDes"];?>" ></div>
	
	<div class="detailMember_txt">列表页头部动作：</div>
	<div class="">
	<table border="0">
		<tr>
			<td>待选动作<br>
				<input type="hidden" name="para[headerActionId]" id="headerActionId" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["headerActionId"];?>">
				<select name="srcHeaderActionId" id="srcHeaderActionId" onDblClick="select_move_to(this.form, 'srcHeaderActionId', 'targetHeaderActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
				<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["checkActionExist"]=runFunc('checkActionExist',array($this->_tpl_vars["var"]["actionGuid"],$this->_tpl_vars["contentPlan"]["0"]["headerActionId"])); ?>
				<?php if (!$this->_tpl_vars["checkActionExist"]){?>
					<option value="<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></option>
				<?php } ?>
				<?php  }
} ?>
				</select>
			</td>
			<td>
				<br>
				<input type="button" value="=>" onClick="select_move_to(this.form, 'srcHeaderActionId', 'targetHeaderActionId')"><br><br>
				<input type="button" value="<=" onClick="select_move_to(this.form, 'targetHeaderActionId', 'srcHeaderActionId')"><br><br>
				<input type="button" value="全选" onClick="select_move_all_to(this.form, 'srcHeaderActionId', 'targetHeaderActionId')"><br>
				<input type="button" value="全删" onClick="select_move_all_to(this.form, 'targetHeaderActionId', 'srcHeaderActionId')">
			</td>
			<td>选定动作<br>
				<select name="para[targetHeaderActionId]" id="targetHeaderActionId"  onDblClick="select_move_to(this.form, 'targetHeaderActionId', 'srcHeaderActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('getContentActionBycontentId',array($this->_tpl_vars["contentPlanId"],'headerActionId')); ?>	
				<?php if(!empty($this->_tpl_vars['result'])){ 
 foreach ($this->_tpl_vars['result'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["actionResult"]=runFunc('getActionInfoByGuid',array($this->_tpl_vars["var"])); ?>
					<?php if ($this->_tpl_vars["actionResult"]["0"]["actionTitle"]){?>
						<option value="<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["actionResult"]["0"]["actionTitle"];?></option>
					<?php } ?>
				<?php  }
} ?>	
				</select>
			</td>
		</tr>
	</table>
	</div>
		<div class="detailMember_txt">列表页右击菜单动作：</div>
	<div class="">
	<table border="0">
		<tr>
			<td>待选动作<br>
				<input type="hidden" name="para[rightActionId]" id="rightActionId" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["rightActionId"];?>">
				<select name="srcRightActionId" id="srcRightActionId" onDblClick="select_move_to(this.form, 'srcRightActionId', 'targetRightActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
				<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["checkActionExist"]=runFunc('checkActionExist',array($this->_tpl_vars["var"]["actionGuid"],$this->_tpl_vars["contentPlan"]["0"]["rightActionId"])); ?>
				<?php if (!$this->_tpl_vars["checkActionExist"]){?>
					<option value="<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></option>
				<?php } ?>
				<?php  }
} ?>
				</select>
			</td>
			<td>
				<br>
				<input type="button" value="=>" onClick="select_move_to(this.form, 'srcRightActionId', 'targetRightActionId')"><br><br>
				<input type="button" value="<=" onClick="select_move_to(this.form, 'targetRightActionId', 'srcRightActionId')"><br><br>
				<input type="button" value="全选" onClick="select_move_all_to(this.form, 'srcRightActionId', 'targetRightActionId')"><br>
				<input type="button" value="全删" onClick="select_move_all_to(this.form, 'targetRightActionId', 'srcRightActionId')">
			</td>
			<td>选定动作<br>
				<select name="para[targetRightActionId]" id="targetRightActionId"  onDblClick="select_move_to(this.form, 'targetRightActionId', 'srcRightActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('getContentActionBycontentId',array($this->_tpl_vars["contentPlanId"],'rightActionId')); ?>	
				<?php if(!empty($this->_tpl_vars['result'])){ 
 foreach ($this->_tpl_vars['result'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["actionResult"]=runFunc('getActionInfoByGuid',array($this->_tpl_vars["var"])); ?>
					<?php if ($this->_tpl_vars["actionResult"]["0"]["actionTitle"]){?>
						<option value="<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["actionResult"]["0"]["actionTitle"];?></option>
					<?php } ?>
				<?php  }
} ?>	
				</select>
			</td>
		</tr>
	</table>
	</div>
	<div class="detailMember_txt">列表页操作动作：</div>
	<div class="">
	<table border="0">
		<tr>
			<td>待选动作<br>
				<input type="hidden" name="para[contentActionId]" id="contentActionId" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["contentActionId"];?>">
				<select name="srcContentActionId" id="srcContentActionId" onDblClick="select_move_to(this.form, 'srcContentActionId', 'targetContentActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
				<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["checkActionExist"]=runFunc('checkActionExist',array($this->_tpl_vars["var"]["actionGuid"],$this->_tpl_vars["contentPlan"]["0"]["contentActionId"])); ?>
				<?php if (!$this->_tpl_vars["checkActionExist"]){?>
					<option value="<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></option>
				<?php } ?>
				<?php  }
} ?>
				</select>
			</td>
			<td>
				<br>
				<input type="button" value="=>" onClick="select_move_to(this.form, 'srcContentActionId', 'targetContentActionId')"><br><br>
				<input type="button" value="<=" onClick="select_move_to(this.form, 'targetContentActionId', 'srcContentActionId')"><br><br>
				<input type="button" value="全选" onClick="select_move_all_to(this.form, 'srcContentActionId', 'targetContentActionId')"><br>
				<input type="button" value="全删" onClick="select_move_all_to(this.form, 'targetContentActionId', 'srcContentActionId')">
			</td>
			<td>选定动作<br>
				<select name="para[targetContentActionId]" id="targetContentActionId"  onDblClick="select_move_to(this.form, 'targetContentActionId', 'srcContentActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('getContentActionBycontentId',array($this->_tpl_vars["contentPlanId"],'contentActionId')); ?>	
				<?php if(!empty($this->_tpl_vars['result'])){ 
 foreach ($this->_tpl_vars['result'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["actionResult"]=runFunc('getActionInfoByGuid',array($this->_tpl_vars["var"])); ?>
					<?php if ($this->_tpl_vars["actionResult"]["0"]["actionTitle"]){?>
						<option value="<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["actionResult"]["0"]["actionTitle"];?></option>
					<?php } ?>
				<?php  }
} ?>
				</select>
			</td>
		</tr>
	</table>
	</div>
	<div class="detailMember_txt">列表页批量动作：</div>
	<div class="">
	<table border="0">
		<tr>
			<td>待选动作<br>
				<input type="hidden" name="para[batchActionId]" id="batchActionId" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["batchActionId"];?>">
				<select name="srcBatchActionId" id="srcBatchActionId" onDblClick="select_move_to(this.form, 'srcBatchActionId', 'targetBatchActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
				<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["checkActionExist"]=runFunc('checkActionExist',array($this->_tpl_vars["var"]["actionGuid"],$this->_tpl_vars["contentPlan"]["0"]["batchActionId"])); ?>
				<?php if (!$this->_tpl_vars["checkActionExist"]){?>
					<option value="<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></option>
				<?php } ?>
				<?php  }
} ?>
				</select>
			</td>
			<td>
				<br>
				<input type="button" value="=>" onClick="select_move_to(this.form, 'srcBatchActionId', 'targetBatchActionId')"><br><br>
				<input type="button" value="<=" onClick="select_move_to(this.form, 'targetBatchActionId', 'srcBatchActionId')"><br><br>
				<input type="button" value="全选" onClick="select_move_all_to(this.form, 'srcBatchActionId', 'targetBatchActionId')"><br>
				<input type="button" value="全删" onClick="select_move_all_to(this.form, 'targetBatchActionId', 'srcBatchActionId')">
			</td>
			<td>选定动作<br>
				<select name="para[targetBatchActionId]" id="targetBatchActionId"  onDblClick="select_move_to(this.form, 'targetBatchActionId', 'srcBatchActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('getContentActionBycontentId',array($this->_tpl_vars["contentPlanId"],'batchActionId')); ?>	
				<?php if(!empty($this->_tpl_vars['result'])){ 
 foreach ($this->_tpl_vars['result'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php $this->_tpl_vars["actionResult"]=runFunc('getActionInfoByGuid',array($this->_tpl_vars["var"])); ?>
					<?php if ($this->_tpl_vars["actionResult"]["0"]["actionTitle"]){?>
						<option value="<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["actionResult"]["0"]["actionTitle"];?></option>
					<?php } ?>
				<?php  }
} ?>
				</select>
			</td>
		</tr>
	</table>
	</div>
	
	<div class="detailMember_nav">编辑页动作触发器(挑选执行模板)</div>
	<div class="detailMember_txt">新增之前：</div>
	<div class="detailMember_info"><input type="text" name="para[addPre]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["addPre"];?>" ></div>
	<div class="detailMember_txt">新增之后：</div>
	<div class="detailMember_info"><input type="text" name="para[addNext]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["addNext"];?>" ></div>
	<div class="detailMember_txt">保存之前：</div>
	<div class="detailMember_info"><input type="text" name="para[savePre]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["savePre"];?>" ></div>
	<div class="detailMember_txt">保存之后：</div>
	<div class="detailMember_info"><input type="text" name="para[saveNext]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["saveNext"];?>" ></div>
	<div class="detailMember_txt">删除之前：</div>
	<div class="detailMember_info"><input type="text" name="para[delPre]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["delPre"];?>" ></div>
	<div class="detailMember_txt">删除之后：</div>
	<div class="detailMember_info"><input type="text" name="para[delNext]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["delNext"];?>" ></div>
	<input type="button" value="修改内容编辑方案" onClick="editContentPlan();">
<?php }else{ ?>
<div class="main_content">
   	<div class="main_content_nav">当前位置： 系统管理 >> 动作配置管理 >>动作配置管理</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="contentPlanId" value="<?php echo $this->_tpl_vars["contentPlanId"];?>">
<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
	 <table width="100%" id="editgroup">
      <tr>
        <td width="70%">
          <input type="button" value="新增动作" onClick="addAction();">
          <input type="button" value="动作排序" onClick="actionOrder();">	
          </TD>
        <td width="30%"></td>
      </tr>
    </TABLE>
<?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">动作标题</td>
      		<td class="listHeader">动作标识</td>
          	<td class="listHeader">动作名称</td>
          	<td class="listHeader">方法名称</td>
          	<td class="listHeader">入口路径</td>
          	<td class="listHeader">动作类型</td>
          	<td class="listHeader">执行操作</td>
       </tr> 
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
       		<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></td>
       		<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["actionGuid"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["actionName"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["methodName"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["tplPath"];?></td>
          	<td class="tdListItem">
          	<?php if ($this->_tpl_vars["var"]["actionType"]=='1'){?>
          	列表页动作
          	<?php } elseif ($this->_tpl_vars["var"]["actionType"]=='2'){ ?>
          	编辑页动作
          	<?php } elseif ($this->_tpl_vars["var"]["actionType"]=='3'){ ?>
          	其它页动作
          	<?php } ?>
          	</td>
            <td class="tdListItem">
            <?php $this->_tpl_vars["editUrl"]='action=cms&method=editAction&contentPlanId='.$this->_tpl_vars["contentPlanId"] .'&actionId='.$this->_tpl_vars["var"]["actionId"]; ?>
          	<?php $this->_tpl_vars["delUrl"]='action=cms&method=delAction&contentPlanId='.$this->_tpl_vars["contentPlanId"] .'&actionId='.$this->_tpl_vars["var"]["actionId"]; ?>
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["editUrl"]));?>">编辑</a>&nbsp;&nbsp;
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["delUrl"]));?>">删除</a>
            </td>              

       </tr>
       <?php  }
} ?>
    </table>
    <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
<?php } ?>
    

    
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
