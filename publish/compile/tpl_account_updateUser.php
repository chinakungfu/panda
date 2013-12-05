<?php import('core.util.RunFunc'); ?>
<?php if ($this->_tpl_vars["method"]=='updateUser'){?>
	<?php $this->_tpl_vars["checkData"]=runFunc('checkChangeData',array($this->_tpl_vars["IN"]["para"],'username')); ?>
	<?php if ($this->_tpl_vars["checkData"]==1){?>
		<?php $this->_tpl_vars["changePara"]["staffNo"]=$this->_tpl_vars["IN"]["para"]["staffNo"]; ?>
		<?php $this->_tpl_vars["changePara"]["groupName"]='NoValidation'; ?>
		<?php $this->_tpl_vars["changePara"]["email"]=$this->_tpl_vars["IN"]["para"]["staffNo"]; ?>

		<?php $this->_tpl_vars["result"]=runFunc('editStaff',array($this->_tpl_vars["IN"]["para"]["staffId"],$this->_tpl_vars["changePara"])); ?>
		<?php if ($this->_tpl_vars["result"]=='1'){?>
			<?php $this->_tpl_vars["siteNmae"]= runFunc('getGlobalModelVar',array('Site_Domain')); ?>
			<?php $this->_tpl_vars["mailArr"]["verifyLink"]= $this->_tpl_vars["siteNmae"] . '/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateChangeUser&staffId=' . $this->_tpl_vars["IN"]["para"]["staffId"])); ?>
			<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["IN"]["para"]["staffId"]; ?>
			<?php $this->_tpl_vars["mailArr"]["reStaffNo"]=$this->_tpl_vars["IN"]["para"]["staffNo"]; ?>
			<?php $this->_tpl_vars["Mailresult"]=runFunc('sendMail',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"])); ?>

			<?php if ($this->_tpl_vars["Mailresult"]){?>
				<script>alert("Edit Successfully!");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
			<?php }else{ ?>
				<script>alert('Mail Fail');location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>"</script>
			<?php } ?>
		<?php } ?>

	<?php }else{ ?>

		<?php $this->_tpl_vars["backData"]=runFunc('backChangeData',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["checkData"],'username')); ?>

		<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . $this->_tpl_vars["backData"] ));?>"</script>

	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='updatePassword'){ ?>
	<?php $this->_tpl_vars["checkData"]=runFunc('checkChangeData',array($this->_tpl_vars["IN"]["para"],'password'));//检测密码 ?>
	<?php if ($this->_tpl_vars["checkData"]==1){?>
		<?php $this->_tpl_vars["changePara"]["password"]=$this->_tpl_vars["IN"]["para"]["newPassword"]; ?>

		<?php $this->_tpl_vars["result"]=runFunc('editStaff',array($this->_tpl_vars["IN"]["para"]["staffId"],$this->_tpl_vars["changePara"])); //更新用户资料?>

		<?php if ($this->_tpl_vars["result"]=='1'){?>
			<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["IN"]["para"]["staffId"]; ?>
			<?php $this->_tpl_vars["mailArr"]["newPwd"]=$this->_tpl_vars["IN"]["para"]["newPassword"]; ?>
			<?php $this->_tpl_vars["resultMail"]=runFunc('sendMail',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"])); //发送EMAIL?>

			<?php if (resultMail){?>
				<?php runFunc("notice_newpage",array("WELCOME TO WOWshopping", "CHANGE PASSWORD SUCCESSFULLY", "You will receive a confirmation email, if no problem, please ignore.

If not,  please contact customer service.", "website","account"));?>
			<?php }else{ ?>
				<script>alert('Mail Fail');location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=index'));?>"</script>
			<?php } ?>

		<?php }else{ ?>
			<script>alert("Edit failed!");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
		<?php } ?>

	<?php }else{ ?>

		<?php $this->_tpl_vars["backData"]=runFunc('backChangeData',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["checkData"],'password')); ?>
		<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . $this->_tpl_vars["backData"] ));?>"</script>


	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='updateNickname'){ ?>
	<?php $this->_tpl_vars["checkData"]=runFunc('checkChangeData',array($this->_tpl_vars["IN"]["para"],'nickname')); ?>
	<?php if ($this->_tpl_vars["checkData"]==1){?>
		<?php $this->_tpl_vars["changePara"]["staffName"]=$this->_tpl_vars["IN"]["para"]["staffName"]; ?>

		<?php $this->_tpl_vars["result"]=runFunc('editStaff',array($this->_tpl_vars["IN"]["para"]["staffId"],$this->_tpl_vars["changePara"])); ?>

		<?php if ($this->_tpl_vars["result"]=='1'){?>
		<?php runFunc("notice_page",array("Update success", "Update success", "You nick name was changed successfully.", "website","account"));?>
		<?php }else{ ?>
			<script>alert("Edit failed!");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
		<?php } ?>

	<?php }else{ ?>

		<?php $this->_tpl_vars["backData"]=runFunc('backChangeData',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["checkData"],'nickname')); ?>

		<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . $this->_tpl_vars["backData"] ));?>"</script>

	<?php } ?>
<?php } ?>