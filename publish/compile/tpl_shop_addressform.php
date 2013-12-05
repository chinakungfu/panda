<?php
$this->_tpl_vars["user_id"] = runFunc('readSession',array());
$this->_tpl_vars["tmpUser"] = runFunc('readCookie',array());
//获取国家列表
$countries = runFunc("getShippingCountries");
 if($this->_tpl_vars["user_id"]){
 	//获取用户的所有地址
  	$list_addresses = runFunc("getUserAddressByUserId",array($this->_tpl_vars["user_id"]));
	
	if($list_addresses){
		$inc_tpl_file=includeFunc('shop/shipping/address_list.tpl');
		include($inc_tpl_file);		
	}else{
		$inc_tpl_file=includeFunc('shop/shipping/address_create.tpl');
		include($inc_tpl_file);		
	}

  	//默认情况下显示列表
/*	if($this->_tpl_vars["IN"]["type"] == ""){
		$inc_tpl_file=includeFunc('shop/shipping/address_list.tpl');
		include($inc_tpl_file);
	}*/
?>
<!--    <div class="shopping_address">
    <?php 
        //获取默认地址
        $address = runFunc("getUserAddressByUserIdDefault",array($this->_tpl_vars["user_id"]));
        //如果是创建新的地址则
         if($this->_tpl_vars["IN"]["type"]=="create" or count($address)<1){
            $inc_tpl_file=includeFunc('shop/shipping/address_create.tpl');
            include($inc_tpl_file);
         }else if($this->_tpl_vars["IN"]["type"]=="edit"){
            $address = runFunc("getUserAddressById",array($this->_tpl_vars["IN"]["addressId"]));
            $inc_tpl_file=includeFunc('shop/shipping/address_edit.tpl');
            include($inc_tpl_file);
        }else{
            $inc_tpl_file=includeFunc('shop/shipping/address_show.tpl');
            include($inc_tpl_file);
        }
    ?>
    </div>-->


<?php }else{
	
	
}?>
