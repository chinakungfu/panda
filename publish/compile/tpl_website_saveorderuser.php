<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>
<?php $settings[0]["is_validate"] = false;?>
<?php //***************one start*********************************?>
<?php if ($this->_tpl_vars["method"]=='addOrderUser'){ ?>

	<?php $this->_tpl_vars["checkData"]=runFunc('checkSignupData',array($this->_tpl_vars["IN"]["para"]));?>
	<?php if ($this->_tpl_vars["checkData"]==1){?>
		<?php //如果检查注册信息通过则将用户写入数据表******************?>
		<?php $this->_tpl_vars["signPara"]["staffNo"]=$this->_tpl_vars["IN"]["para"]["staffNo"]; ?>
		<?php $this->_tpl_vars["signPara"]["password"]=$this->_tpl_vars["IN"]["para"]["password"]; ?>
		<?php $this->_tpl_vars["signPara"]["safetyQuestion"]=$this->_tpl_vars["IN"]["para"]["safetyQuestion"]; ?>
		<?php $this->_tpl_vars["signPara"]["questionResult"]=$this->_tpl_vars["IN"]["para"]["questionResult"];?>
		<?php $this->_tpl_vars["result1"]=runFunc('addStaff',array($this->_tpl_vars["signPara"]));?>
			<?php if ($this->_tpl_vars["result1"]){?>
				<?php //添加用户成功则 ?>
				<?php $this->_tpl_vars["siteName"]= runFunc('getGlobalModelVar',array('Site_Domain')); ?>
				<?php if ($this->_tpl_vars["IN"]["signUpType"]=='order'){?>
					<?php //如果是订单用户?>
					<?php $tmpUser = runFunc('readCookie',array());?>
					<?php
						import('core.apprun.cmsware.CmswareNode');
						import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
						$params = array (
						'action' => "sql",
						'return' => "updateOrderUser",
						'query' => "update cms_publish_order SET orderUser= '{$this->_tpl_vars["result1"]}' WHERE orderID= '{$this->_tpl_vars["IN"]["orderID"]}'",
						);

						$this->_tpl_vars['updateOrderUser'] = CMS::CMS_sql($params);
						$this->_tpl_vars['PageInfo'] = &$PageInfo;
					?>

				<?php }?>
			<?php //发送邮件?>
			<?php if(!$settings[0]["is_validate"]){?>
				<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["result1"];?>
				<?php $this->_tpl_vars["mailArr"]["userName"]=$this->_tpl_vars["IN"]["para"]["staffNo"];?>
				<?php $this->_tpl_vars["mailArr"]["passWord"]=$this->_tpl_vars["IN"]["para"]["password"];?>
				<?php $this->_tpl_vars["mailArr"]["fullName"]=$this->_tpl_vars["IN"]["fullName"];?>
				<?php if($this->_tpl_vars["IN"]["para"]["SSIS"]):?>
					<?php $this->_tpl_vars["method"] = "SSISOrderPay";?>
				<?php else:?>
					<?php $this->_tpl_vars["method"] = "guestOrderPay";?>
				<?php endif;?>
				<?php $this->_tpl_vars["result"]=runFunc('sendMail',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"]));?>

			<?php }else{?>
				<?php $this->_tpl_vars["method"] = "orderPay";?>
				<?php $this->_tpl_vars["mailArr"]["verifyLink"]= $this->_tpl_vars["siteName"] . '/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateUser&staffId=' . $this->_tpl_vars["result1"] . '&signUpType=' . $this->_tpl_vars["IN"]["signUpType"] . '&orderID=' . $this->_tpl_vars["IN"]["orderID"].'&tmpUser='.$tmpUser)); ?>
				<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["result1"];?>
				<?php $this->_tpl_vars["result"]=runFunc('sendMail',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"]));?>

			<?php }?>

			<?php if ($this->_tpl_vars["result"]){?>
				<?php if(!$settings[0]["is_validate"]){ ?>
					<?php $this->_tpl_vars["validate_result"]=runFunc('validateStaff',array($this->_tpl_vars["result1"]));?>
					<?php
					import('core.apprun.cmsware.CmswareNode');
					import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
					$params = array (
					'action' => "sql",
					'return' => "orderList",
					'query' => "select * from cms_publish_order  WHERE orderID= '{$this->_tpl_vars["IN"]["orderID"]}' limit 1",
					);

					$this->_tpl_vars['orderList'] = CMS::CMS_sql($params);
					$this->_tpl_vars['PageInfo'] = &$PageInfo;
					?>

					<?php
					import('core.apprun.cmsware.CmswareNode');
					import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
					$params = array (
					'action' => "sql",
					'return' => "updateOrderUser",
					'query' => "update cms_publish_order SET orderUser= '{$this->_tpl_vars["result1"]}' WHERE orderID= '{$this->_tpl_vars["IN"]["orderID"]}'",
					);

					$this->_tpl_vars['updateOrderUser'] = CMS::CMS_sql($params);
					$this->_tpl_vars['PageInfo'] = &$PageInfo;
					?>
					<?php
					import('core.apprun.cmsware.CmswareNode');
					import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
					$params = array (
					'action' => "sql",
					'return' => "updateAddressUser",
					'query' => "update cms_publish_address SET userId= '{$this->_tpl_vars["result1"]}' WHERE userId= '{$tmpUser}'",
					);

					$this->_tpl_vars['updateAddressUser'] = CMS::CMS_sql($params);
					$this->_tpl_vars['PageInfo'] = &$PageInfo;

					?>

					<?php
					 import('core.apprun.cmsware.CmswareNode');
					 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
					 $params = array (
						'action' => "sql",
						'return' => "updateCoupons",
						'query' => "update cms_member_coupons SET user_id= '{$this->_tpl_vars["result1"]}' WHERE user_id = '{$tmpUser}'",
					 );

						$this->_tpl_vars['updateCouponsUser'] = CMS::CMS_sql($params);
					    $this->_tpl_vars['PageInfo'] = &$PageInfo;
					?>

					<?php
					import('core.apprun.cmsware.CmswareNode');
					import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
					$params = array (
					'action' => "sql",
					'return' => "updateCartUser",
					'query' => "update cms_publish_cart SET UserName= '{$this->_tpl_vars["result1"]}' WHERE cartID in ('{$this->_tpl_vars["orderList"]["data"]["0"]["cartIDstr"]}')",
					);

					$this->_tpl_vars['updateCartUser'] = CMS::CMS_sql($params);
					$this->_tpl_vars['PageInfo'] = &$PageInfo;
					?>
					<?php if($this->_tpl_vars["validate_result"]){?>
						<?php //echo $this->_tpl_vars["IN"]["orderID"]."</br>".$this->_tpl_vars["orderList"]["data"]["0"]["cartIDstr"]."</br>".$this->_tpl_vars["result1"]."</br>".$tmpUser;?>
						<?php runFunc('writeSession',array($this->_tpl_vars["result1"]))?>
						<?php header("Location:index.php".runFunc('encrypt_url',array('action=shop&method=payment&guestOrder=1&orderID='.$this->_tpl_vars["IN"]["orderID"])));?>
					<?php }?>
				<?php }else{?>
						<script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerOk&email=' . $this->_tpl_vars["IN"]["para"]["staffNo"]));?>"</script>
					<?php //echo "跳转到注册成功页面";?>
				<?php }?>
			<?php }else{ ?>
				<?php //echo "发送邮件失败";?>
				<script>alert('Mail Fail');location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=index'));?>"</script>
			<?php } ?>

		  <?php } ?>
		<?php //查测注册信息成功代码结束********************?>
	<?php }else{ ?>
		<?php //如果检测注册信息失败************?>
		<?php $this->_tpl_vars["backData"]=runFunc('backSignupData',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["checkData"])); ?>
		<?php //echo "检测用户信息出错";?>
		<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . $this->_tpl_vars["backData"] ));?>"</script>
	<?php } ?>
<?php //***************one  end*********************************?>
<?php }?>