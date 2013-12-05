<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["shareCommentNodeId"]=runFunc('getGlobalModelVar',array('shareCommentNode')); ?>
<?php $this->_tpl_vars["shareCommentNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["shareCommentNodeId"])); ?>
<?php $this->_tpl_vars["shareCommentContentModel"]=$this->_tpl_vars["shareCommentNode"]["0"]["appTableName"]; ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
<script>alert("Sorry, you are not login!");location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=shareCommentindex'));?>"</script>

<?php }else{ ?>
<?php if (empty($this->_tpl_vars["shareCommentPara"]["commentContent"])){?>
<script>alert("Sorry, you need input 1 character at least.");location.href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["IN"]["shareID"]));?>"</script>

<?php }else{ ?>
<?php if ($this->_tpl_vars["method"]=='addShareComments'){?>
<?php $this->_tpl_vars["shareCommentPara"]["shareId"]=$this->_tpl_vars["IN"]["shareID"]; ?>
<?php $this->_tpl_vars["shareCommentPara"]["nodeId"]=$this->_tpl_vars["shareCommentNode"]["0"]["nodeGuid"]; ?>
<?php $this->_tpl_vars["shareCommentPara"]["userId"]=$this->_tpl_vars["name"]; ?>
<?php $this->_tpl_vars["shareCommentPara"]["commentType"]=2; ?>

<?php date_default_timezone_set("prc");?>
<?php $this->_tpl_vars["shareCommentPara"]["commentDate"]=strtotime(date('Y-m-d H:i:s',time())); ?>

<?php $this->_tpl_vars["addshareCommentTable"]=runFunc('addData',array($this->_tpl_vars["shareCommentNodeId"],$this->_tpl_vars["shareCommentContentModel"],$this->_tpl_vars["shareCommentPara"])); ?>
<?php if (addshareCommentTable){?>

<?php $this->_tpl_vars["publishshareCommentTable"]=runFunc('publish',array($this->_tpl_vars["shareCommentNodeId"],$this->_tpl_vars["shareCommentContentModel"],$this->_tpl_vars["shareCommentNode"]["0"]["appTableKeyName"],$this->_tpl_vars["addshareCommentTable"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"])); ?>
<?php if (publishshareCommentTable){?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["IN"]["shareID"]));?>"</script>
<?php } ?>
<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='replyShareComments'){ ?>
<?php $this->_tpl_vars["shareCommentPara"]["shareId"]=$this->_tpl_vars["IN"]["shareID"]; ?>
<?php $this->_tpl_vars["shareCommentPara"]["nodeId"]=$this->_tpl_vars["shareCommentNode"]["0"]["nodeGuid"]; ?>
<?php $this->_tpl_vars["shareCommentPara"]["userId"]=$this->_tpl_vars["name"]; ?>
<?php $this->_tpl_vars["shareCommentPara"]["commentType"]=3; ?>

<?php
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
	'action' => "sql",
	'return' => "shareComment",
	'query' => "SELECT a.commentDate,a.commentContent,b.staffName FROM cms_publish_sharecomment a,cms_member_staff b where a.commentId='{$this->_tpl_vars["IN"]["replayCommitId"]}' and a.userId=b.staffId LIMIT 1",
);

$this->_tpl_vars['shareComment'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;
?>

<?php $this->_tpl_vars["shareCommentPara"]["replyInfo"]=$this->_tpl_vars["shareComment"]["data"]["0"]["staffName"] . '||' . $this->_tpl_vars["shareComment"]["data"]["0"]["commentDate"] . '||' . $this->_tpl_vars["shareComment"]["data"]["0"]["commentContent"]; ?>

<?php date_default_timezone_set("prc");?>
<?php $this->_tpl_vars["shareCommentPara"]["commentDate"]=strtotime(date('Y-m-d H:i:s',time())); ?>

<?php $this->_tpl_vars["addshareCommentTable"]=runFunc('addData',array($this->_tpl_vars["shareCommentNodeId"],$this->_tpl_vars["shareCommentContentModel"],$this->_tpl_vars["shareCommentPara"])); ?>
<?php if (addshareCommentTable){?>

<?php $this->_tpl_vars["publishshareCommentTable"]=runFunc('publish',array($this->_tpl_vars["shareCommentNodeId"],$this->_tpl_vars["shareCommentContentModel"],$this->_tpl_vars["shareCommentNode"]["0"]["appTableKeyName"],$this->_tpl_vars["addshareCommentTable"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"])); ?>
<?php if (publishshareCommentTable){?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["IN"]["shareID"]));?>"</script>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>
