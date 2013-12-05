<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>
<?php if ($this->_tpl_vars["method"]=='addAdminRegUser'){
		//注册页面提交数据特殊处理
		if($this->_tpl_vars["IN"]["userName"] && $this->_tpl_vars["IN"]["userEmail"] && $this->_tpl_vars["IN"]["password"] && $this->_tpl_vars["IN"]["safetyQuestion"] && $this->_tpl_vars["IN"]["questionResult"]){
			$this->_tpl_vars["IN"]["para"]["staffNo"] = $this->_tpl_vars["IN"]["userName"];
			$this->_tpl_vars["IN"]["para"]["email"] = $this->_tpl_vars["IN"]["userEmail"];
			$this->_tpl_vars["IN"]["para"]["password"] = $this->_tpl_vars["IN"]["password"];
			$this->_tpl_vars["IN"]["para"]["safetyQuestion"] = $this->_tpl_vars["IN"]["safetyQuestion"];
			$this->_tpl_vars["IN"]["para"]["questionResult"] = $this->_tpl_vars["IN"]["questionResult"];
		}
		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $params,$params2;
		$params = array (
		'action' => "sql",
		'return' => "reguser2",
		'query' => "select staffId from cms_member_staff WHERE email = '{$this->_tpl_vars["IN"]["para"]["email"]}' limit 1",
		);
		$this->_tpl_vars['reguser'] = CMS::CMS_sql($params);
		$params2 = array (
		'action' => "sql",
		'return' => "reguser",
		'query' => "select staffId from cms_member_staff WHERE staffName = '{$this->_tpl_vars["IN"]["para"]["staffNo"]}' limit 1",
		);
		$this->_tpl_vars['reguser2'] = CMS::CMS_sql($params2);
?>
		<?php if($this->_tpl_vars['reguser2']["data"]["0"]["staffId"] && $this->_tpl_vars['reguser']["data"]["0"]["staffId"]){ ?>
                <script>
                    location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"]));?>"
                </script>
		<?php }else{ ?>
				<?php $this->_tpl_vars["signPara"]["staffNo"]=$this->_tpl_vars["IN"]["para"]["staffNo"]; ?>
                <?php $this->_tpl_vars["signPara"]["email"]=$this->_tpl_vars["IN"]["para"]["email"]; ?>
                <?php $this->_tpl_vars["signPara"]["password"]=$this->_tpl_vars["IN"]["para"]["password"]; ?>
                <?php $this->_tpl_vars["signPara"]["safetyQuestion"]=$this->_tpl_vars["IN"]["para"]["safetyQuestion"]; ?>
                <?php $this->_tpl_vars["signPara"]["questionResult"]=$this->_tpl_vars["IN"]["para"]["questionResult"]; ?>
                <?php $this->_tpl_vars["signPara"]["IP_ADDRESS"]=$this->_tpl_vars["IN"]["IP_ADDRESS"]; ?>
                <?php //print_r($this->_tpl_vars["signPara"]);exit;?>
                <?php $this->_tpl_vars["result1"]=runFunc('addStaff',array($this->_tpl_vars["signPara"]));?>
				<?php if ($this->_tpl_vars["result1"]){?>
                        <?php $this->_tpl_vars["siteName"]= runFunc('getGlobalModelVar',array('Site_Domain')); ?>
                        <?php if ($this->_tpl_vars["IN"]["signUpType"]=='signUp'){ ?>
                            	<?php $this->_tpl_vars["mailArr"]["verifyLink"]= $this->_tpl_vars["siteName"] . '/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateRegUser&validateType=admin&staffId=' . $this->_tpl_vars["result1"])); ?>
                        <?php } ?>
                        	<?php $this->_tpl_vars["mailArr"]["userId"]= $this->_tpl_vars["result1"]; ?>
							<?php $this->_tpl_vars["result"]=runFunc('sendMail',array($this->_tpl_vars["mailArr"],'adminsignup')); ?>
                            <?php if ($this->_tpl_vars["result"]){?>
                        <script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerOk&email=' . $this->_tpl_vars["IN"]["para"]["email"]));?>"</script>
                            <?php }else{ //echo $this->_tpl_vars["mailArr"]["verifyLink"]; ?>
                        <script>alert('Mail Fail');location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=index'));?>"</script><script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerOk&email=' . $this->_tpl_vars["mailArr"]["verifyLink"]));?>"</script>
                            <?php } ?>
                <?php  }//result1判断结束 ?>
		<?php }?>
<?php }  ?>


