<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>

<?php if ($this->_tpl_vars["method"]=='addUser'){
	//注册页面提交数据特殊处理
	if($this->_tpl_vars["IN"]["userName"] && $this->_tpl_vars["IN"]["userEmail"] && $this->_tpl_vars["IN"]["password"] && $this->_tpl_vars["IN"]["safetyQuestion"] && $this->_tpl_vars["IN"]["questionResult"]){
		$this->_tpl_vars["IN"]["para"]["staffNo"] = $this->_tpl_vars["IN"]["userName"];
		$this->_tpl_vars["IN"]["para"]["email"] = $this->_tpl_vars["IN"]["userEmail"];
		$this->_tpl_vars["IN"]["para"]["password"] = $this->_tpl_vars["IN"]["password"];
		$this->_tpl_vars["IN"]["para"]["safetyQuestion"] = $this->_tpl_vars["IN"]["safetyQuestion"];
		$this->_tpl_vars["IN"]["para"]["questionResult"] = $this->_tpl_vars["IN"]["questionResult"];		
	}

/*	if($this->_tpl_vars['signUpType']=="message_request"){
		$this->_tpl_vars["checkData"]=runFunc('checkSignupDataAndMessage',array($this->_tpl_vars["IN"]["para"]));
	}else{
		$this->_tpl_vars["checkData"]=runFunc('checkSignupData',array($this->_tpl_vars["IN"]["para"]));
	}*/
/*	echo $this->_tpl_vars["checkData"];
	exit();*/
?>
	<?php if ($this->_tpl_vars["checkData"]==1){?>

		<?php $this->_tpl_vars["signPara"]["staffNo"]=$this->_tpl_vars["IN"]["para"]["staffNo"]; ?>
        <?php $this->_tpl_vars["signPara"]["password"]=$this->_tpl_vars["IN"]["para"]["password"]; ?>
        <?php $this->_tpl_vars["signPara"]["safetyQuestion"]=$this->_tpl_vars["IN"]["para"]["safetyQuestion"]; ?>
        <?php $this->_tpl_vars["signPara"]["questionResult"]=$this->_tpl_vars["IN"]["para"]["questionResult"]; ?>
        <?php $this->_tpl_vars["result1"]=runFunc('addStaff',array($this->_tpl_vars["signPara"]));?>

	<?php if ($this->_tpl_vars["result1"]){?>
		<?php $this->_tpl_vars["siteName"]= runFunc('getGlobalModelVar',array('Site_Domain')); ?>
		<?php if ($this->_tpl_vars["IN"]["signUpType"]=='order'){?>
			<?php $this->_tpl_vars["method"] = "orderPay";?>
       		<?php $tmpUser = runFunc('readCookie',array());?>
        	<?php $this->_tpl_vars["mailArr"]["verifyLink"]= $this->_tpl_vars["siteName"] . '/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateUser&staffId=' . $this->_tpl_vars["result1"] . '&signUpType=' . $this->_tpl_vars["IN"]["signUpType"] . '&orderID=' . $this->_tpl_vars["IN"]["orderID"].'&tmpUser='.$tmpUser)); ?>

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

		<?php }elseif ($this->_tpl_vars["IN"]["signUpType"]=='message_request'){

			runFunc('saveMessages',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["result1"]));

			$this->_tpl_vars["mailArr"]["verifyLink"]= $this->_tpl_vars["siteName"] . '/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateUser&staffId=' . $this->_tpl_vars["result1"]));
			}elseif ($this->_tpl_vars["IN"]["signUpType"]=='signUp'){ ?>
				<?php $this->_tpl_vars["mailArr"]["verifyLink"]= $this->_tpl_vars["siteName"] . '/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateUser&staffId=' . $this->_tpl_vars["result1"])); ?>
		<?php } ?>

		<?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["result1"]; ?>
        <?php $this->_tpl_vars["result"]=runFunc('sendMail',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"])); ?>
		<?php if ($this->_tpl_vars["result"]){?>
    <script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerOk&email=' . $this->_tpl_vars["IN"]["para"]["staffNo"]));?>"</script>
        <?php }else{ ?>
    <script>alert('Mail Fail');location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=index'));?>"</script>
        <?php } ?>

	<?php  }//result1判断结束 ?>

	<?php }else{ //不checkData时?>

			<?php $this->_tpl_vars["backData"]=runFunc('backSignupData',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["checkData"])); ?>

<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . $this->_tpl_vars["backData"] ));?>"</script>
	<?php } //checkData结束 ?>

	<?php } elseif ($this->_tpl_vars["method"]=='validateUser'){ ?>
		<?php $this->_tpl_vars["result"]=runFunc('validateStaff',array($this->_tpl_vars["IN"]["staffId"])); ?>

		<?php if ($this->_tpl_vars["IN"]["signUpType"]=='order'){?>
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
            'query' => "update cms_publish_order SET orderUser= '{$this->_tpl_vars["IN"]["staffId"]}' WHERE orderID= '{$this->_tpl_vars["IN"]["orderID"]}'",
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
            'query' => "update cms_publish_address SET userId= '{$this->_tpl_vars["IN"]["staffId"]}' WHERE userId= '{$this->_tpl_vars["IN"]["tmpUser"]}'",
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
                    'query' => "update cms_member_coupons SET user_id= '{$this->_tpl_vars["IN"]["staffId"]}' WHERE user_id = '{$this->_tpl_vars["IN"]["tmpUser"]}'",
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
            'query' => "update cms_publish_cart SET UserName= '{$this->_tpl_vars["IN"]["staffId"]}' WHERE cartID in ('{$this->_tpl_vars["orderList"]["data"]["0"]["cartIDstr"]}')",
            );
        
            $this->_tpl_vars['updateCartUser'] = CMS::CMS_sql($params);
            $this->_tpl_vars['PageInfo'] = &$PageInfo;
            ?>
	<?php } ?>
	<?php if ($this->_tpl_vars["result"]){?>
	<?php runFunc('writeSession',array($this->_tpl_vars["IN"]["staffId"]))?>
	<?php if($this->_tpl_vars["IN"]["signUpType"]=='order'):?>
	<?php header("Location:index.php".runFunc('encrypt_url',array('action=shop&method=payment&orderID='.$this->_tpl_vars["IN"]["orderID"])));?>
	<?php else:?>
	<?php header("Location:index.php".runFunc('encrypt_url',array('action=share&method=editProfile')));?>
	<?php endif;?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=verificationOk&staffId=' . $this->_tpl_vars["IN"]["staffId"]));?>"</script>
	<?php } ?>
	<?php } elseif ($this->_tpl_vars["method"]=='validateChangeUser'){ ?>
	<?php $this->_tpl_vars["result"]=runFunc('validateStaff',array($this->_tpl_vars["IN"]["staffId"])); ?>

	<?php if ($this->_tpl_vars["IN"]["signUpType"]=='order'){?>
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
	'query' => "update cms_publish_order SET orderUser= '{$this->_tpl_vars["IN"]["staffId"]}' WHERE orderID= '{$this->_tpl_vars["IN"]["orderID"]}'",
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
	'query' => "update cms_publish_address SET userId= '{$this->_tpl_vars["IN"]["staffId"]}' WHERE userId= '{$this->_tpl_vars["IN"]["tmpUser"]}'",
	);

	$this->_tpl_vars['updateAddressUser'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	?>
	<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "updateCartUser",
	'query' => "update cms_publish_cart SET UserName= '{$this->_tpl_vars["IN"]["staffId"]}' WHERE cartID in ('{$this->_tpl_vars["orderList"]["data"]["0"]["cartIDstr"]}')",
	);

	$this->_tpl_vars['updateCartUser'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	?>
	<?php } ?>
	<?php if ($this->_tpl_vars["result"]){?>
	<?php runFunc('writeSession',array($this->_tpl_vars["IN"]["staffId"]))?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=verificationOk&staffId=' . $this->_tpl_vars["IN"]["staffId"]));?>"</script>
	<?php } ?>
	<?php } elseif ($this->_tpl_vars["method"]=='delData'){ ?>
	<?php runFunc('delStaff',array($this->_tpl_vars["selectConId"]))?>
	<?php } elseif ($this->_tpl_vars["method"]=='resetPassword'){ ?>
		<?php if ($this->_tpl_vars["IN"]["answer"]==''){?>
    			<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . '&alertStr=2' ));?>"</script>
        <?php }else{ ?>
                <?php $this->_tpl_vars["checkData"]=runFunc('verifySafty',array($this->_tpl_vars["IN"]["userId"],$this->_tpl_vars["IN"]["safetyQuestion"],$this->_tpl_vars["IN"]["answer"])); ?>
                <?php if ($this->_tpl_vars["checkData"]){?>
                        <?php $this->_tpl_vars["randomPassword"]=runFunc('generate_rand',array('8')); ?>
                        <?php $this->_tpl_vars["changePara"]["password"]=$this->_tpl_vars["randomPassword"]; ?>
                        <?php $this->_tpl_vars["result"]=runFunc('editStaff',array($this->_tpl_vars["IN"]["userId"],$this->_tpl_vars["changePara"])); ?>
					<?php if ($this->_tpl_vars["result"]=='1'){?>
                
                            <?php $this->_tpl_vars["mailArr"]["userId"]=$this->_tpl_vars["IN"]["userId"]; ?>
                            <?php $this->_tpl_vars["mailArr"]["newPwd"]=$this->_tpl_vars["randomPassword"]; ?>
                            <?php $this->_tpl_vars["mailArr"]["RESET_LINK"]="/publish/index.php".runFunc('encrypt_url',array('action=website&method=reset_password_login&userId='.$this->_tpl_vars["IN"]["userId"]));?>
            
                            <?php $this->_tpl_vars["resultMail"]=runFunc('sendMail',array($this->_tpl_vars["mailArr"],$this->_tpl_vars["method"])); ?>
            
                            <?php if ($this->_tpl_vars["resultMail"]){
                        
                                header("location:index.php".runFunc('encrypt_url',array('action=website&method=resetPwdOk&staffId=' . $this->_tpl_vars["IN"]["userId"])));
                        
                             }else{ ?>
                                    <!--<script>alert('Mail Fail');location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"]));?>"</script>-->
                            <?php 
								header("location:index.php".runFunc('encrypt_url',array('action=website&method=resetPwdOk&staffId=' . $this->_tpl_vars["IN"]["userId"])));
							 } ?>
                
                    <?php }else{ ?>
                				<script>alert("Edit failed!");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"]));?>'</script>
                    <?php } ?>
                <?php }else{ ?>
            <script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . '&alertStr=1' ));?>"</script>
                <?php } ?>
        <?php } ?>

<?php }?>