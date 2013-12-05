<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
<?php $this->_tpl_vars["orderNodeId"]=runFunc('getGlobalModelVar',array('orderNode')); ?>
<?php $this->_tpl_vars["orderNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["orderNodeId"])); ?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "content",
	'return' => "orderDetail",
	'nodeid' => "{$this->_tpl_vars["orderNode"]["0"]["nodeGuid"]}",
	'contentid' => "{$this->_tpl_vars["IN"]["orderID"]}",
 ); 

$this->_tpl_vars['orderDetail'] = CMS::CMS_content($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>
   
	
	</head>
	<body>
	    
		<div class="box">
		    
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

			<?php if ($this->_tpl_vars["userInfo"]["0"]["groupName"]!='administrator'){?>
				<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login'));?>'</script>	
			<?php } ?>
			
    			<div class="contentCentSubmit">
    			    <div class="subMitBelow">
    			        <h2>Order Information
    			            <span>Orderlist<em>No:<?php echo $this->_tpl_vars["orderDetail"]["OrderNo"];?></em></span>
    			        </h2>
    			    </div>
			 
    			    
			
			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "orderList",
	'query' => "SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid  and a.cartID in ({$this->_tpl_vars["orderDetail"]["cartIDstr"]}) Order By a.cartid DESC",
 ); 

$this->_tpl_vars['orderList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
			

			<?php $this->_tpl_vars["goodsNum"]=sizeof($this->_tpl_vars["orderList"]["data"]); ?>				
    			    
			
			    

			<?php $this->_tpl_vars["SubTotalPrice"]=0; ?>
			<?php if ($this->_tpl_vars["orderDetail"]["serviceName"]=='1'){?>
				<?php $this->_tpl_vars["serviceStr"]='WOW Express'; ?>
			<?php } elseif ($this->_tpl_vars["orderDetail"]["serviceName"]=='2'){ ?>
				<?php $this->_tpl_vars["serviceStr"]='WOW Collect&go'; ?>
			<?php } elseif ($this->_tpl_vars["orderDetail"]["serviceName"]=='3'){ ?>
				<?php $this->_tpl_vars["serviceStr"]='WOW Premium Service'; ?>
			<?php } ?>
			    <div class="pageContentSubmit fl">
        			    <h2><span>You are choosing <em><?php echo $this->_tpl_vars["serviceStr"];?></em></span></h2>
        			    <h3><?php echo $this->_tpl_vars["goodsNum"];?> <?php if ($this->_tpl_vars["goodsNum"]==1){?>item <?php } elseif ($this->_tpl_vars["goodsNum"]>1){ ?> items <?php } ?> </h3>
        			    <table>
        			        <thead>
        			            <tr>
        			             <td><?php echo $this->_tpl_vars["goodsNum"];?> <?php if ($this->_tpl_vars["goodsNum"]==1){?>item <?php } elseif ($this->_tpl_vars["goodsNum"]>1){ ?> items <?php } ?> in your bag</td><td width="75px" align="center">QTY</td><td width="75px"  style="text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;UNIT&nbsp;PRICE</td><td style="text-align:center" width="75px">FREIGHT</td><td width="100px">&nbsp;</td>
        			            </tr>
        			        </thead>
        			        <tbody>
					<?php if(!empty($this->_tpl_vars["orderList"]["data"])){ 
 foreach ($this->_tpl_vars["orderList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
            			        <tr>
                                    <td class="bagItem">
                                        <dl>
                                            <dt>
					    <?php if ($this->_tpl_vars["var"]["goodsType"]=='inside'){?>
						    <img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt="bagImg" />
						<?php } elseif ($this->_tpl_vars["var"]["goodsType"]=='outside'){ ?>
						    <img src="<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt="bagImg" />
						<?php } ?>
						</dt>
                                            <dd><strong><?php echo $this->_tpl_vars["var"]["goodsTitleCN"];?><br /><?php echo $this->_tpl_vars["var"]["goodsTitleEn"];?> </strong></dd>
                                            <?php if ($this->_tpl_vars["var"]["goodsType"]=='inside'){?>
						<dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=goodsDetail&goodsID=' . $this->_tpl_vars["var"]["goodsid"] ));?>" target=_blank>Taobao Link</a></dd>
					    <?php } elseif ($this->_tpl_vars["var"]["goodsType"]=='outside'){ ?>
						<dd><a href="<?php echo $this->_tpl_vars["var"]["goodsURL"];?>" target=_blank>Taobao Link</a></dd>
					    <?php } ?>
					    
                                        </dl>
                                    </td>
				    <form action="/publish/index.php" method="post">
					<input type="hidden" name="action" value="admin">
					<input type="hidden" name="method" value="updateOrder">	
					<input type="hidden" name="cartID" value="<?php echo $this->_tpl_vars["var"]["cartID"];?>">
					<input type="hidden" name="orderID" value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>">
					<input type="hidden" name="goodsid" value="<?php echo $this->_tpl_vars["var"]["goodsid"];?>">

					    <td><input type="text"  name="para[ItemQTY]" value="<?php echo $this->_tpl_vars["var"]["ItemQTY"];?>" class="numtextBag"></td>
					    <?php $this->_tpl_vars["subItemPrice"]=number_format($this->_tpl_vars["var"]["itemPrice"], 2, '.', ','); ?>
					    <td align="center"><input name="para[goodsUnitPrice]" type="text" class="text3" value="<?php echo $this->_tpl_vars["subItemPrice"];?>"/></td>

					    <td align="center"><?php if ($this->_tpl_vars["var"]["itemFreight"]<=0){?><input name="para[Freight]" type="text" class="text3" value="<?php echo $this->_tpl_vars["Freight"];?>"/><?php }else{ ?><?php $this->_tpl_vars["Freight"]=number_format($this->_tpl_vars["var"]["itemFreight"], 2, '.', ','); ?><input  name="para[Freight]" type="text" class="text3" value="<?php echo $this->_tpl_vars["Freight"];?>"/><?php } ?></td>
					    <td class="bagEdit">
						
						<dl>
						    
						    <dd>
							<input type="submit" value="Update"/>						

								
							
						</dd>				
						</dl>
						
					    </td>
				    </form>
                                </tr>
				<?php $this->_tpl_vars["SubTotalPrice"]=$this->_tpl_vars["SubTotalPrice"]+$this->_tpl_vars["var"]["ItemQTY"]*$this->_tpl_vars["var"]["itemPrice"]+$this->_tpl_vars["var"]["itemFreight"]; ?>
                                <?php  }
} ?>
                                <?php $this->_tpl_vars["tempSubTotalPrice"]=$this->_tpl_vars["SubTotalPrice"]; ?>
                                <?php $this->_tpl_vars["SubTotalPriceF"]=number_format($this->_tpl_vars["SubTotalPrice"], 2, '.', ','); ?>
                                
                                <tr>
                                   
				    <td >
                                       Notes:&nbsp;&nbsp;<?php echo $this->_tpl_vars["var"]["itemNotes"];?>
						
					    </td>
				    
                                </tr>
                            </tbody>
        			    </table>
    			    </div>
    			    
    			    <div class="subMitRight fr">
			    <?php $this->_tpl_vars["AddressNodeId"]=runFunc('getGlobalModelVar',array('AddressNode')); ?>
			<?php $this->_tpl_vars["AddressNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["AddressNodeId"])); ?>
			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "content",
	'return' => "addressDetail",
	'nodeid' => "{$this->_tpl_vars["AddressNode"]["0"]["nodeGuid"]}",
	'contentid' => "{$this->_tpl_vars["orderDetail"]["orderAddress"]}",
 ); 

$this->_tpl_vars['addressDetail'] = CMS::CMS_content($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
                        <table class="subMitNameInfo">
                            <tr>
                                <td width="55">Name:</td><td><?php echo $this->_tpl_vars["addressDetail"]["fullName"];?></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top">Address:</td><td style="padding-bottom:5px; vertical-align:top"><?php echo $this->_tpl_vars["addressDetail"]["address1"];?> <br>
                                    <?php echo $this->_tpl_vars["addressDetail"]["address2"];?><br />
                                    <?php echo $this->_tpl_vars["addressDetail"]["city"];?>, <?php echo $this->_tpl_vars["addressDetail"]["province"];?>&nbsp;&nbsp;<?php echo $this->_tpl_vars["addressDetail"]["zipcode"];?><br>
                                    <?php echo $this->_tpl_vars["addressDetail"]["country"];?><br />
                                    Phone: <?php echo $this->_tpl_vars["addressDetail"]["cellphone"];?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:45px;">Email: </td><td valign="top"><?php echo $this->_tpl_vars["addressDetail"]["email"];?></td>
                            </tr>
                        </table>
                        
                        <table class="subMitNameSubTotal">
                            <tr>
                                <td  style="padding-bottom:45px;" width="133">Subtotal (<?php echo $this->_tpl_vars["goodsNum"];?> items ):</td><td  valign="top" width="133" align="right">￥<span id="subTotalPrice1"><?php echo $this->_tpl_vars["SubTotalPriceF"];?></span></td>
                            </tr>
                        </table>
                        
                        
                        <table class="subMitNameSubTotal">
			<?php $this->_tpl_vars["serviceFee"]=number_format($this->_tpl_vars["SubTotalPrice"]*0.1, 2, '.', ','); ?>
                            <tr>
                                <td  width="133">Service Fee:</td><td  width="133" align="right">￥<span id="serviceFree"><?php echo $this->_tpl_vars["serviceFee"];?></span></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:23px;" colspan="2"  class="subMitNameInfoText"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-bottom:12px;" class="subMitNameInfoText"></td>
                            </tr>
                        </table>
                        <?php $this->_tpl_vars["totalCharge"]=number_format($this->_tpl_vars["SubTotalPrice"]+$this->_tpl_vars["serviceFee"], 2, '.', ','); ?>
                        <table class="subMitNameSubTotal" style="border-bottom:0 none">
                            <tr>
                                <td  width="133"  style="padding-bottom:23px;">TOTAL</td><td  width="133" align="right" valign="top">￥<span id="totalPrice"><?php echo $this->_tpl_vars["totalCharge"];?></span></td>
                            </tr>
                        </table>
			   
                        <div style="height:23px;">
                            
			     
			     <form action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="admin">
				<input type="hidden" name="method" value="confirmOrder">
				<input type="hidden" name="orderID" value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>">
			     <input type="submit" value="Confirm and Mail" class="contInueChose fr" style="margin-top: -10px; margin-right: 12px;"/>
			     </form>
			      
                        </div>
			  </form>
                    </div>
		  
                    
			 </div>
			
			
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

			
		</div>
	</body>
</html>
<?php }else{ ?>	
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&backaction=website&backmethod=login&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
<?php } ?>