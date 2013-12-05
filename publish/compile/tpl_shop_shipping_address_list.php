<div id="cartTwoContent" class="<?php if(!$list_addresses){echo 'hide';}?>">
	<div id="addressList">
    <?php if($list_addresses):?>
		<?php $defaultAddressId = '';?>
        <?php foreach ($list_addresses as $list_address){ ?>
            <?php if($list_address["set_default"]){$defaultAddressId = $list_address["addressId"];}?>
            <table onclick="address_booking_select(this);" id="<?php echo $list_address["addressId"];?>" class="address_booking_table <?php if($list_address["set_default"]):?>isSelect<?php else:?>noSelect<?php endif;?>">
                <tr><td class="addressTitle"><?php echo $list_address["firstName"]." ".$list_address["lastName"];?></td></tr>
                <tr><td><?php echo $list_address["telephone"];?>&nbsp;&nbsp;<?php echo $list_address["cellphone"];?></td></tr>
                <tr><td><?php echo $list_address["address1"];?>&nbsp;&nbsp;<?php echo $list_address["address2"];?></td></tr>
    
                <tr><td><?php echo $list_address["city"];?>&nbsp;&nbsp;<?php echo $list_address["province"];?>&nbsp;&nbsp;<?php echo $list_address["country"];?></td></tr>
              
                <tr><td align="right">           
                <span class="addressDefault <?php if(!$list_address["set_default"]):?>hide<?php endif;?>">Default</span>
                <span class="addressSetDefault <?php if($list_address["set_default"]):?>hide<?php endif;?>" onclick="setDefaultAddress('<?php echo $list_address["addressId"];?>','<?php echo $userid;?>');">Set Default</span>
                <span class="addressEdit" onclick="addressEdit(this);">Edit</span>          
                </td></tr>
                <tr><td><input name="addressListArr" value="<?php echo implode('|',$list_address);?>" type="hidden" id="<?php echo $list_address["addressId"]?>_addressDataArr" /></td></tr>
             </table>
        <?php }?>
    <?php endif;?>
	</div>
	<div class="clb"></div>
    <div class="cartToConfirm" id="cartToConfirmBtn">
        <a class="cartContinue" href="#addressBackEdit" name="cartToConfirm" id="cartToConfirm">Continue</a>
    </div> 
</div>