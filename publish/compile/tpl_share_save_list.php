<?php import('core.util.RunFunc'); 


$list_id = runFunc('saveShareList',array($this->_tpl_vars["IN"]["user_id"],$this->_tpl_vars["IN"]["categoryID"],$this->_tpl_vars["IN"]["list_name"],$this->_tpl_vars["IN"]["description"],$this->_tpl_vars["IN"]["privacy"],$this->_tpl_vars["IN"]["published"]));

$titles = $this->_tpl_vars["IN"]["added_item_title"];
$i = 0;
foreach($titles as $key=>$title){
	if($this->_tpl_vars["IN"]["added_item_desc"][$key]=="Maximum of 300 characters"){
		
		$desc = "";
	}else{
		
		$desc = $this->_tpl_vars["IN"]["added_item_desc"][$key];
	}
	
	$goods_id = $this->_tpl_vars["IN"]["add_item_id"][$key];
	
	$good_info = runFunc("getGoodsById",array($this->_tpl_vars["IN"]["add_item_id"][$key]));
	
	//$good_img[] = $good_info["goodsImgURL"];
	
	
	$itemResult = runFunc('saveShareListItem',array($title,$desc,$goods_id,$list_id));
	if($itemResult){
		$i++;
	}
	
}
if($i){
	$dataArray['itemNum'] = $i;
	runFunc('updateNewShareList',array($list_id,$this->_tpl_vars["IN"]["user_id"],$dataArray));
}
//runFunc("makeMergeListImage",array($list_id,$good_img));

if($this->_tpl_vars["IN"]["privacy"] == 0 and $this->_tpl_vars["IN"]["published"] == 1){

	runFunc("sendFriendNotice",array($this->_tpl_vars["IN"]["user_id"],"COLLECTION CREATE",$list_id));

}

header("Location: ".runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$this->_tpl_vars["IN"]["user_id"])));

?>