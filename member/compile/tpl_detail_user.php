<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
<script language="javascript" type="text/javascript">
if(window.confirm('请先登录系统！'))
{
	<?php $this->_tpl_vars["tempUrl"]='action=member&method=login&url='.$this->_tpl_vars["IN"]["frameRight"]; ?>
	top.location.href="../member/index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>";
	
}else
{
	<?php echo 'location.href="'.$_SERVER['HTTP_REFERER'].'"'; ?>
}
</script>
<?php } ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
</head>
<body>
<div class="main_content">
	<div class="main_content_nav">后台管理系统 >> 我的资料</div>
	<div style="clear:both"></div>
	<div class="search_content detailMember">
		<form method="post" action="index.php">
		<input type="hidden" name="action" value="member">
		<?php $this->_tpl_vars["staff"]=runFunc('getStaffInfoByNo',array($this->_tpl_vars["name"])); ?>
		<input type="hidden" name="method" value="editUser">
		<input type="hidden" class="edit" name="staffId" value="<?php echo $this->_tpl_vars["staff"]["0"]["staffId"];?>" >
		<div class="detailMember_nav">基本信息</div>
			<div class="detailMember_txt">帐号</div>
				<?php if ($this->_tpl_vars["staff"]["0"]["staffNo"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["staffNo"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["staffNo"];?></div><br>
			    <?php } ?>
			<div class="detailMember_txt">昵称</div>
				<?php if ($this->_tpl_vars["staff"]["0"]["staffName"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["staffName"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["staffName"];?></div><br>
			    <?php } ?>   
			 <div class="detailMember_txt">用户性别</div>
			 	<?php if ($this->_tpl_vars["staff"]["0"]["sex"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["sex"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["sex"];?></div><br>
			    <?php } ?> 
			<div class="detailMember_txt">出生日期</div>
				<?php if ($this->_tpl_vars["staff"]["0"]["birthDay"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["birthDay"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["birthDay"];?></div><br>
			    <?php } ?>
		<div class="detailMember_nav">联系信息</div>
			<div class="detailMember_txt">QQ号</div>
				<?php if ($this->_tpl_vars["staff"]["0"]["qq"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["qq"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["qq"];?></div><br>
			    <?php } ?>
			<div class="detailMember_txt">邮箱地址</div>
				<?php if ($this->_tpl_vars["staff"]["0"]["email"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["email"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["email"];?></div><br>
			    <?php } ?>     
			 <div class="detailMember_txt">MSN</div>
			 	<?php if ($this->_tpl_vars["staff"]["0"]["msn"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["msn"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["msn"];?></div><br>
			    <?php } ?>
			<div class="detailMember_txt">主页</div>
				<?php if ($this->_tpl_vars["staff"]["0"]["homepage"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["homepage"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["homepage"];?></div><br>
			    <?php } ?>          
		<div class="detailMember_nav">安全信息</div>        
		    <div class="detailMember_txt">安全问题</div>
		    	<?php if ($this->_tpl_vars["staff"]["0"]["safetyQuestion"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["safetyQuestion"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["safetyQuestion"];?></div><br>
			    <?php } ?>         
		    <div class="detailMember_txt">问题答案</div>
		    	<?php if ($this->_tpl_vars["staff"]["0"]["questionResult"]!=''){?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["questionResult"];?></div>
			    <?php }else{ ?>
			    	<div class="detailMember_info"><?php echo $this->_tpl_vars["staff"]["0"]["questionResult"];?></div><br>
			    <?php } ?>
				<input type="submit" value="编辑我的资料" />    
	</div>
	    </form> 
	    <br>
	  <div style="clear:both"></div>
	  <div class="copyright"></div>
    </div>
</body>
</html>
