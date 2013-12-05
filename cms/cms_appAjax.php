<?php
$app['cms']['ajaxConfig']=array(
'cms'=>array(
'fullPublishFlag'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/full_publish_flag.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'extraPublishName','auth'=>''),
'fullActionFlag'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/full_action_flag.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'actionTitle','auth'=>''),
'searchNode'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/search_result.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'','params'=>'con,method,type','auth'=>''),
'isDefaultNode'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/set_default_node.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'','params'=>'nodeId','auth'=>''),
'checkNodeFlag'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/check_node_flag.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'nodeGuid','auth'=>''),
'changeOrderStatus'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/change_orderStatus.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'orderID,changeType,dataType','auth'=>''),
'changeOrderStatusPhone'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/change_orderStatusPhone.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'orderID,changeType,dataType','auth'=>''),
'changeOrderStatusBank'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/change_orderStatusBank.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'orderID,changeType,dataType','auth'=>''),
'batchSendMail'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/ajax_batchSendMail.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'orderID,sendType,dataType','auth'=>''),
'updateItemInfo'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/ajax_updateItemInfo.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'cartID,orderID,item_price,purchaseTotal,purchaseInfo,serviceRemark,refundPrice,expressNum,expressUrl,pay_back_message,dataType','auth'=>''),
'updateAddressCN'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/ajax_updateAddressCN.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'addressId,addressCN1,addressCN2,country,province,city','auth'=>''),
'fullNodeFlag'=>array('file'=>$GLOBALS['currentApp']['apppath'].'/tpl/full_node_flag.tpl','type'=>'tpl','func'=>'','className'=>'','language'=>'UTF-8','params'=>'nodeName','auth'=>'')));

?>
