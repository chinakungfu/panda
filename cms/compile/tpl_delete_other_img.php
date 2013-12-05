<?php

import('core.util.RunFunc'); 

$id = $this->_tpl_vars["IN"]["id"];

$img_name = $this->_tpl_vars["IN"]["img_name"];

$img = runFunc("getGoodsAdminImg",array($img_name,$id));
if(file_exists($img[$img_name]."_70x70.jpg")){
	unlink($img[$img_name]."_70x70.jpg");
}

if(file_exists($img[$img_name]."_500x500.jpg")){
	unlink($img[$img_name]."_500x500.jpg");
}

runFunc("deleteGoodsImg",array($img_name,$id));

$sql = "select * from cms_publish_goods where goodsid in ({$id})";
$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

foreach($result as $good){


	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("删除商品简介图片 ".$good["goodsTitleCN"],$uid));

}

header("Location: ".runFunc('encrypt_url',array('action=cms&method=product_edit&type=products&id='.$id)));

