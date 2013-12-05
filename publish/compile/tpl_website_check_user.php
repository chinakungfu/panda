<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if ($this->_tpl_vars["method"]=='CheckUser'){?>
	<?php $this->_tpl_vars["result"]=runFunc('newCheckLogin',array($this->_tpl_vars["staffNo"],$this->_tpl_vars["password"])); ?>

	<?php if ($this->_tpl_vars["result"]["status"]){?>
 
 			<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>
            <?php if ($this->_tpl_vars["CookieUser"]){?>   
						<?php
                         import('core.apprun.cmsware.CmswareNode');
                         import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
                         $params = array (
                            'action' => "sql",
                            'return' => "updateCoupons",
                            'query' => "update cms_member_coupons SET user_id= '{$this->_tpl_vars["result"]["staffId"]}' WHERE `user_id`= '{$this->_tpl_vars["CookieUser"]}'",
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
                            'query' => "update cms_publish_cart SET UserName= '{$this->_tpl_vars["result"]["staffId"]}' WHERE `UserName`= '{$this->_tpl_vars["CookieUser"]}'",
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
                            'query' => "update cms_publish_order SET orderUser= '{$this->_tpl_vars["result"]["staffId"]}' WHERE orderUser= '{$this->_tpl_vars["CookieUser"]}'",
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
                            'query' => "update cms_publish_address SET userId= '{$this->_tpl_vars["result"]["staffId"]}' WHERE userId= '{$this->_tpl_vars["CookieUser"]}'",
                         );
                        
                            $this->_tpl_vars['updateAddressUser'] = CMS::CMS_sql($params);
                            $this->_tpl_vars['PageInfo'] = &$PageInfo;
                        ?>
                        <?php $this->_tpl_vars["clearCookie"]=runFunc('deleteCookie',array()); ?>
    
           		<?php } ?>
				 <?php runFunc('writeSession',array($this->_tpl_vars["result"]["staffId"]))?>
                <?php if ($this->_tpl_vars["method"]=='CheckUser'){?>
    
                    <?php if ($this->_tpl_vars["IN"]["backUrl"]!=''){?>
                        <?php $this->_tpl_vars["tempUrl"]=$this->_tpl_vars["IN"]["backUrl"]; ?>
                    <?php }else{ ?>
                        <?php $this->_tpl_vars["tempUrl"]='action=website&method=index'; ?>
                    <?php } ?>
    
                    <script>location.href="/publish/index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>";</script>
                <?php } ?>       

	<?php }else{ ?>

			<script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&alertStr='.$this->_tpl_vars["result"]["error"]));?>"</script>

	<?php } ?>
<?php } ?>