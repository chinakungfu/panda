<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
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
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php
	$countries = runFunc("getShippingCountries");
	//获取用户的所有地址
	$list_addresses = runFunc("getUserAddressByUserId",array($this->_tpl_vars["name"]));
?>
<div class="content">
        <div class="notic_content">
            <div class="notic_header">
                <h1>Update Shipping Address</h1>
                <h2>Choose a shipping address and modify</h2>
                <div id="cartTwoTitleAll" style="float:right;">
                <a class="newAddress" href="<?php echo "/publish/index.php".runFunc('encrypt_url',array("action=account&method=addressCreate"));?>">Add new address</a>
           	    </div>
            </div>
        </div> 
		<div class="address_manage">
		<?php if($list_addresses):?>
	
            <div id="addressList">
                <?php $defaultAddressId = '';?>
                <?php foreach ($list_addresses as $k => $list_address){ ?>
                    <?php if($list_address["set_default"]){$defaultAddressId = $list_address["addressId"];}?>
                    <table id="<?php echo $list_address["addressId"];?>" class="address_booking_table <?php if(fmod($k+1,2)){echo 'leftStyle';}?> <?php if($list_address["set_default"]):?>isSelect<?php endif;?>">
                        <tr><td class="addressTitle"><?php echo $list_address["firstName"]." ".$list_address["lastName"];?></td></tr>
                        <tr><td><?php echo $list_address["telephone"];?>&nbsp;&nbsp;<?php echo $list_address["cellphone"];?></td></tr>
                        <tr><td><?php echo $list_address["address1"];?>&nbsp;&nbsp;<?php echo $list_address["address2"];?></td></tr>
            
                        <tr><td><?php echo $list_address["city"];?>&nbsp;&nbsp;<?php echo $list_address["province"];?>&nbsp;&nbsp;<?php echo $list_address["country"];?></td></tr>                      
                        <tr><td align="right" valign="middle">                                  
                        <span class="addressDefault <?php if(!$list_address["set_default"]):?>hide<?php endif;?>">Default</span>                        
                        <a class="addressSetDefault <?php if($list_address["set_default"]):?>hide<?php endif;?>" href="/publish/index.php<?php echo runFunc('encrypt_url',array("action=account&method=addressSave&type=setDufault&addressID=".$list_address["addressId"]));?>">Set Default</a>
                        <a class="addressDelete" href="/publish/index.php<?php echo runFunc('encrypt_url',array("action=account&method=addressSave&type=delete&addressID=".$list_address["addressId"]));?>">Delete</a>                         
                        <a class="addressEdit" href="/publish/index.php<?php echo runFunc('encrypt_url',array("action=account&method=addressEdit&addressID=".$list_address["addressId"]));?>">Edit</a>          
                        </td></tr>
                     </table>
                <?php }?>
            </div>
            <div class="clb"></div>
		<?php else:?>
        	<?php header("Location: ".runFunc('encrypt_url',array("action=account&method=addressCreate")));?>
        <?php endif;?>
		<div style="width:976px;height:150px;"></div>		  
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
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>