<?php import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());

	$querysql = "select c.staffName,c.staffNo,c.headImageUrl, a.*,(select count(*) from cms_member_love where love_id = a.id) as count_love from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId where publish = 1 and  privacy = 0 and a.status=1 and a.block =0 and c.block = 0";
	$page = $this->_tpl_vars["IN"]["pageIndex"];
	$size = $this->_tpl_vars["IN"]["pageSize"];
	if($page <=0){
		$page = 1;
	}
	$page = $page * $size - $size;
	$sort = $this->_tpl_vars["IN"]["sort"];
//$lists = runFunc("getStyleListAll",array($this->_tpl_vars["IN"]["pageIndex"],$this->_tpl_vars["IN"]["pageSize"],$this->_tpl_vars["IN"]["sort"]));
	$ctg = $this->_tpl_vars["IN"]["ctg"];
	$shareUserID = $this->_tpl_vars["IN"]["shareUserID"];
	if($ctg){
		$querysql .= " and a.categoryID = {$ctg}";
		
	}
	if($shareUserID){		
		$querysql .= " and a.user_id = {$shareUserID}";
		$stylelists["shareUserID"] = $shareUserID;
	}else{
		$querysql .= " and a.itemNum >= 9";
	}
	 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun');		
	 global $PageInfo,$params;
	 $params = array (
				'action' => "sql",
				'return' => "lists",
				'query' => $querysql." order by a.updateTime desc,a.created desc limit {$page},{$size}",
	 );
	 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
	 $this->_tpl_vars['PageInfo'] = &$PageInfo;

	 		
	 $lists = $this->_tpl_vars['lists']['data'];	
	 $stylelists["collections"] = $lists;
	 
		
for($i=0;$i<count($lists);$i++){
	$avatar_link = runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$lists[$i]["user_id"]));
	$avatar = '../publish/avatar/'.$lists[$i]["user_id"].'_thumb.'.$lists[$i]["headImageUrl"];
	
	$list_items = runFunc("getMemberShareListItem",array($lists[$i]['id'],9));
	
	if(file_exists($avatar)){
		
		$stylelists["collections"][$i]["avatar"] = $avatar;
	}else{
		
		$stylelists["collections"][$i]["avatar"] = "../skin/images/pic.jpg";
	}
	$list_link = runFunc('encrypt_url',array('action=share&method=showList&id='.$lists[$i]["id"].'&user_id='.$lists[$i]["user_id"]));
	if($shareUserID == $this->_tpl_vars["name"]){		
		$list_editlink = runFunc('encrypt_url',array('action=share&method=editList&id='.$lists[$i]["id"].'&user_id='.$lists[$i]["user_id"]));
		$list_dellink = runFunc('encrypt_url',array('action=share&method=memberShareListDelete&id='.$lists[$i]["id"].'&user_id='.$lists[$i]["user_id"]));
		$stylelists["collections"][$i]["list_editlink"] = $list_editlink;
		$stylelists["collections"][$i]["list_dellink"] = $list_dellink;	
		if(strlen($lists[$i]["title"])> 20){	
			$stylelists["collections"][$i]["shorttitle"] =  mb_substr($lists[$i]["title"],0,20,'utf-8')."...";
		}else{
			$stylelists["collections"][$i]["shorttitle"] =  $lists[$i]["title"];
		}			
	}else{
		if(strlen($lists[$i]["title"])> 35){	
			$stylelists["collections"][$i]["shorttitle"] =  mb_substr($lists[$i]["title"],0,35,'utf-8')."...";
		}else{
			$stylelists["collections"][$i]["shorttitle"] =  $lists[$i]["title"];
		}			
	}
	$stylelists["collections"][$i]["list_link"] = $list_link;

	$stylelists["collections"][$i]["list_items"] = $list_items;
	$stylelists["collections"][$i]["avatar_link"] = $avatar_link;
}
$json = json_encode($stylelists);
?>
<?php echo $json;?>
