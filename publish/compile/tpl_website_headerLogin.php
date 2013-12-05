<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if ($this->_tpl_vars["method"]=='headerLogin'){?>
	<?php if ($this->_tpl_vars["staffNo"]!='' and $this->_tpl_vars["password"]!=''){?>
		<?php $this->_tpl_vars["staffExist"]=runFunc('StaffIsExists',array($this->_tpl_vars["staffNo"])); ?>
		<?php if ($this->_tpl_vars["staffExist"]){?>	
			<?php $this->_tpl_vars["result"]=runFunc('checkLogin',array($this->_tpl_vars["staffNo"],$this->_tpl_vars["password"])); ?>	
			<?php if ($this->_tpl_vars["result"]){?>	
			<?php if($this->_tpl_vars["result"][0]["block"] == 1){
				?>
				
				<script>alert("Your account has been blocked by WOWSHOPPING,please contact our services.");history.back()</script>
			<?php 	
				exit;
			}?>		
				<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>
				<?php if ($this->_tpl_vars["CookieUser"]){?>	
				
									<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateCoupons",
	'query' => "update cms_member_coupons SET user_id= '{$this->_tpl_vars["result"]["0"]["staffId"]}' WHERE `user_id`= '{$this->_tpl_vars["CookieUser"]}'",
 ); 

$this->_tpl_vars['updateCoupons'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
   
?>		
					<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateCart",
	'query' => "update cms_publish_cart SET UserName= '{$this->_tpl_vars["result"]["0"]["staffId"]}' WHERE `UserName`= '{$this->_tpl_vars["CookieUser"]}'",
 ); 

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
					<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "update cms_publish_order SET orderUser= '{$this->_tpl_vars["result"]["0"]["staffId"]}' WHERE orderUser= '{$this->_tpl_vars["CookieUser"]}'",
 ); 

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>								
					<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateAddressUser",
	'query' => "update cms_publish_address SET userId= '{$this->_tpl_vars["result"]["0"]["staffId"]}',set_default = 0 WHERE userId= '{$this->_tpl_vars["CookieUser"]}'",
 ); 
$this->_tpl_vars['updateAddressUser'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
					<?php $this->_tpl_vars["clearCookie"]=runFunc('deleteCookie',array()); ?>					
				<?php } ?>	
				<?php if ($this->_tpl_vars["result"]["0"]["groupName"]=='NoValidation'){?>
					<script>alert("Sorry,You are waiting for validation of sign up, please go to your mail box and finish all steps of verification");history.back()</script>
				<?php }else{ ?>
					<?php runFunc('writeSession',array($this->_tpl_vars["result"]["0"]["staffId"]))?>
					<?php if ($this->_tpl_vars["method"]=='headerLogin'){?>
					
					<script>
					//alert("Log in successfully!");
					location.href="<?php echo $this->_tpl_vars["IN"]["url"];?>"||"index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"]));?>";</script>
					<?php } ?>
				<?php } ?>
			<?php }else{ ?>				
				<script>alert("Password is incorrect. Please input again.");history.back()</script>	
			<?php } ?>
		<?php }else{ ?>
			<script>alert("Not a valid e-mail address.");history.back()</script>
		<?php } ?>
	<?php }else{ ?>		
		<script>alert("Please input E-mail and Password.");history.back()</script>		
	<?php } ?>
<?php } ?>
