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
	<script>
	function checkRadio(name)
	{
		
		var serviceName = $(':radio[name="'+name+'"]:checked').val();
		if(typeof(serviceName) == "undefined")
		{
			alert("Please select the order address and try");
			return false;
		}
	}
	</script>
	<body>	    
		<div class="box">		    
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

			
			
			<div class="content">
                <div class="shipping02">
                    <h2>SHIPPING<?php echo $this->_tpl_vars["IN"]["orderID"];?></h2>
                    <p>You are choosing<span>WOW Collect &amp; go</span></p>
                    <p>You pick up the goods at WOW ship to point.</p>
                </div>
                <form action="/publish/index.php" method="post"  onsubmit="return checkRadio('para[orderAddress]')">
		<input type="hidden" name="action" value="shop">
		<input type="hidden" name="method" value="updateAddress">
		<input type="hidden" name="para[orderID]" value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>">
			
			<table class="chooseTable">
			   <thead>
			       <tr>
				  <th colspan="3" class="chooseTableTitle">Choose the place near you</th>
			       </tr>
			   </thead>
			   <tbody>
			   <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "addressList",
	'query' => "SELECT * FROM a0222211743.cms_publish_address WHERE userId='0' and status='1' Order By addressId DESC",
 ); 

$this->_tpl_vars['addressList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
			   <?php $this->_tpl_vars["addressStr"]=''; ?>
			    <?php if(!empty($this->_tpl_vars["addressList"]["data"])){ 
 foreach ($this->_tpl_vars["addressList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php if ($this->_tpl_vars["var"]["address1"]){?>
					<?php $this->_tpl_vars["addressStr"]=$this->_tpl_vars["var"]["address1"]; ?>
				<?php } ?>				
				<?php if ($this->_tpl_vars["var"]["address2"]){?>
					<?php if ($this->_tpl_vars["addressStr"]){?>
						<?php $this->_tpl_vars["addressStr"]=$this->_tpl_vars["addressStr"] . ',' . $this->_tpl_vars["var"]["address2"]; ?>					
					<?php }else{ ?>
						<?php $this->_tpl_vars["addressStr"]=$this->_tpl_vars["var"]["address2"]; ?>
					<?php } ?>
				<?php } ?>
				
				<?php if ($this->_tpl_vars["var"]["city"]){?>
					<?php $this->_tpl_vars["addressStr"]=$this->_tpl_vars["addressStr"] . ',' . $this->_tpl_vars["var"]["city"]; ?>
				<?php } ?>
				<?php if ($this->_tpl_vars["var"]["province"]){?>
					<?php $this->_tpl_vars["addressStr"]=$this->_tpl_vars["addressStr"] . ',' . $this->_tpl_vars["var"]["province"]; ?>
				<?php } ?>
				<?php if ($this->_tpl_vars["var"]["country"]){?>
					<?php $this->_tpl_vars["addressStr"]=$this->_tpl_vars["addressStr"] . ',' . $this->_tpl_vars["var"]["country"]; ?>
				<?php } ?>
				<?php if ($this->_tpl_vars["var"]["zipcode"]){?>
					<?php $this->_tpl_vars["addressStr"]=$this->_tpl_vars["addressStr"] . '&nbsp; ' . $this->_tpl_vars["var"]["zipcode"]; ?>
				<?php } ?>

				
			       <tr>
				  <td width="339" class="shippingTableAdd"><?php echo $this->_tpl_vars["addressStr"];?><br /><?php if ($this->_tpl_vars["var"]["telephone"]){?>Tel:<?php echo $this->_tpl_vars["var"]["telephone"];?><br /><?php } ?><?php if ($this->_tpl_vars["var"]["cellphone"]){?>Cellphone:<?php echo $this->_tpl_vars["var"]["cellphone"];?><?php } ?></td>
				  <td width="40" class="map">MAP</td>
				  <td align="center"><input type="radio" name="para[orderAddress]" value='<?php echo $this->_tpl_vars["var"]["addressId"];?>'/></td>
			       </tr>			      
			   <?php  }
} ?>
			   </tbody>
			   <tfoot>
			       <tr>
				   <td colspan="3" class="weWil">we will open more office soon</td>
			       </tr>
			       <tr class="chooseTableTfoot">
				   <td colspan="3" class="chooseTableBtn"><input type="submit" value="BACK" class="contInueChose mr12 fl"/><input type="submit" value="CONTINUE" class="contInueChose fl"/></td>
			       </tr>
			   </tfoot>
			</table>
			</form>
		</form>
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