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
<script>

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
function submitData()
{
	//getActionId();
	select_submit('contentFrom', 'targetHeaderActionId', 'headerActionId');
	select_submit('contentFrom', 'targetRightActionId', 'rightActionId');
	select_submit('contentFrom', 'targetContentActionId', 'contentActionId');
	select_submit('contentFrom', 'targetBatchActionId', 'batchActionId');
	document.forms[0].submit();
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
<div class="main_content">
   	<div class="main_content_nav">当前位置： 系统管理 >> 内容编辑方案管理</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
       <?php $this->_tpl_vars["result"]=runFunc('listContentPlanInfo',array()); ?>
       <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">内容编辑方案ID</td>
          	<td class="listHeader">内容编辑方案名</td>
          	<td class="listHeader">内容编辑分页数</td>
          	<td class="listHeader">内容编辑分页长度</td>
          	<td class="listHeader">内容编辑方案描述</td>
          	<td class="listHeader">执行操作</td>
       </tr>  

       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["contentPlanId"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["contentPlanName"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["contentPlanPage"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["contentPlanSize"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["contentPlanDes"];?></td>
          <td class="tdListItem">
          <?php $this->_tpl_vars["editUrl"]='action=cms&method=listAction&contentPlanId='.$this->_tpl_vars["var"]["contentPlanId"]; ?>
          	<?php $this->_tpl_vars["delUrl"]='action=cms&method=delContentPlan&contentPlanId='.$this->_tpl_vars["var"]["contentPlanId"]; ?>
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["editUrl"]));?>">编辑</a>&nbsp;&nbsp;
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["delUrl"]));?>">删除</a>
          </td>
       </tr>
       <?php  }
} ?>
    </table>
     <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    </div>
<form action="index.php" method="POST" name='contentFrom' id="contentFrom">
<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="saveAddContentPlan">
<div class="detailMember_nav">新建内容编辑方案</div>     
	<div class="detailMember_txt">内容编辑方案名称：</div>
	<div class="detailMember_info"><input type="text" name="para[contentPlanName]" value="" ></div>
	<div class="detailMember_txt">内容编辑分页数：</div>
	<div class="detailMember_info"><input type="text" name="para[contentPlanPage]" value="" ></div>
	<div class="detailMember_txt">内容编辑分页长度：</div>
	<div class="detailMember_info"><input type="text" name="para[contentPlanSize]" value="" ></div>
	<div class="detailMember_txt">内容编辑方案说明：</div>
	<div class="detailMember_info"><input type="text" name="para[contentPlanDes]" value="<?php echo $this->_tpl_vars["contentPlan"]["0"]["contentPlanDes"];?>" ></div>
<div class="detailMember_nav">列表页动作</div>
	<div class="detailMember_txt">列表页头部动作：</div>
	<div class="">
	<table border="0">
		<tr>
			<td>待选动作<br>
				<input type="hidden" name="para[headerActionId]" id="headerActionId" value="">
				<select name="srcHeaderActionId" id="srcHeaderActionId" onDblClick="select_move_to(this.form, 'srcHeaderActionId', 'targetHeaderActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
				<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
					<option value="<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></option>
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
				<input type="hidden" name="para[rightActionId]" id="rightActionId" value="">
				<select name="srcRightActionId" id="srcRightActionId" onDblClick="select_move_to(this.form, 'srcRightActionId', 'targetRightActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
				<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
					<option value="<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></option>
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
				<input type="hidden" name="para[contentActionId]" id="contentActionId" value="">
				<select name="srcContentActionId" id="srcContentActionId" onDblClick="select_move_to(this.form, 'srcContentActionId', 'targetContentActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
				<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
					<option value="<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></option>
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
				<input type="hidden" name="para[batchActionId]" id="batchActionId" value="">
				<select name="srcBatchActionId" id="srcBatchActionId" onDblClick="select_move_to(this.form, 'srcBatchActionId', 'targetBatchActionId')" size="10" style="width:100px;">
				<?php $this->_tpl_vars["result"]=runFunc('listActionInfo',array()); ?>
				<?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
					<option value="<?php echo $this->_tpl_vars["var"]["actionGuid"];?>"><?php echo $this->_tpl_vars["var"]["actionTitle"];?></option>
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

				</select>
			</td>
		</tr>
	</table>
	</div>
	<div class="detailMember_nav">编辑页动作触发器(挑选执行模板)</div>
	<div class="detailMember_txt">新增之前：</div>
	<div class="detailMember_info"><input type="text" name="para[addPre]" value="" ></div>
	<div class="detailMember_txt">新增之后：</div>
	<div class="detailMember_info"><input type="text" name="para[addNext]" value="" ></div>
	<div class="detailMember_txt">保存之前：</div>
	<div class="detailMember_info"><input type="text" name="para[savePre]" value="" ></div>
	<div class="detailMember_txt">保存之后：</div>
	<div class="detailMember_info"><input type="text" name="para[saveNext]" value="" ></div>
	<div class="detailMember_txt">删除之前：</div>
	<div class="detailMember_info"><input type="text" name="para[delPre]" value="" ></div>
	<div class="detailMember_txt">删除之后：</div>
	<div class="detailMember_info"><input type="text" name="para[delNext]" value="" ></div>
<div class="detailMember_doedit">
<input type="button" value="创建" onclick="submitData();">
</div>
</form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
