<?php

$app['publish']['ajaxConfig']=array(
'website'=>array(
'CheckUser'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/login_check.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'StaffNo,password,method','auth'=>''),
'checkUserExist'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/check_user_exist.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'staffNo','auth'=>''),
'ajaxLogin'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/ajax_login.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'staffNo,password','auth'=>''),
'ajaxLogout'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/ajax_logout.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'staffNo,password','auth'=>''),
'writeSession'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/writeSession.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'StaffNo,password,method','auth'=>'')),
'shop'=>array(
'addCart'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/shop_addCart.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'paraStr,addFlag','auth'=>''),
'changeItemQTY'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/change_item_qty.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'cartID,itemQTY,userId,cartType,cartIdStr,goodsShopId,itemPrice','auth'=>''),
'cancelItemQTY'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/cancel_item_qty.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'cartID,userId,cartType,cartIdStr,goodsShopId,itemPrice,dataType','auth'=>''),
'changeItemNotes'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/ajax_cartNotes.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'data,cartID,userId,dataType','auth'=>''),
'changeOrderStatus'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/change_orderStatus.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'orderID,changeType,dataType','auth'=>''),
'changeItemStatus'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/change_itemStatus.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'cartID,dataType','auth'=>''),
'addAddress'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/ajax_addAddress.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'data','auth'=>''),
'checkmail'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/checkmail.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'email','auth'=>''),
'changeOrderQTY'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/change_order_qty.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'cartID,itemQTY,userId,cartType,goodsShopId,orderID','auth'=>''),
'changeRemoveQTY'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/change_remove_qty.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'cartID,cartType,newcartIdStr,orderId','auth'=>''),

)
);
?>
