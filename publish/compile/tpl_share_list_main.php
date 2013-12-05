<?php import('core.util.RunFunc'); 
 $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc("common/header/common_header.tpl");
include($inc_tpl_file);

if($this->_tpl_vars["IN"]["sort"] == ""){
	$sort = "id";
}else{
	$sort = $this->_tpl_vars["IN"]["sort"];
}
/*	if($this->_tpl_vars["IN"]["page"]){
		$page=$this->_tpl_vars["IN"]["page"];
	}else{
		$page=1;
	}
	$rowsPerPage = 20;
	$pageStrat = $page * $rowsPerPage - $rowsPerPage;*/

	$querysql = "select c.staffName,c.staffNo,c.headImageUrl, a.*,(select count(*) from cms_member_love where love_id = a.id) as count_love from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId where publish = 1 and  privacy = 0 and a.status=1 and a.block =0 and c.block = 0 and a.itemNum >= 9";

/*	$sql = "select c.staffName,c.staffNo,d.real_name,d.first_name,d.last_name,d.show_nick,c.headImageUrl, a.*,(select count(*) from cms_member_love where love_id = a.id) as count_love from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId where publish = 1 and  privacy = 0 and a.status=1 and a.block =0 and c.block = 0 order by {$sort} desc limit {$page},{$size} ";*/
	
	$sumQuerysql = "select count(a.id) as totalNum from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId where publish = 1 and  privacy = 0 and a.status=1 and a.block =0 and c.block = 0 and a.itemNum >= 9";

		$ctg = $this->_tpl_vars["IN"]["ctg"];
		$shareUserID = $this->_tpl_vars["IN"]["userID"];

		if($ctg){
			$querysql .= " and a.categoryID = {$ctg}";
			$sumQuerysql .= " and a.categoryID = {$ctg}";
		}
		if($shareUserID){		
			$querysql .= " and a.user_id = {$shareUserID}";
			$sumQuerysql .= " and a.user_id = {$shareUserID}";
		}		
	
		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params,$PageInfo2,$params2,$params3;
		 $params = array (
					'action' => "sql",
					'return' => "lists",
					'query' => $querysql." order by a.updateTime desc,a.created desc limit 0,9",
		 );
		 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
		 $this->_tpl_vars['PageInfo'] = &$PageInfo;

		 $params2 = array (
					'action' => "sql",
					'return' => "totalNum",
					'query' => $sumQuerysql,
		 );
		 $this->_tpl_vars['totalNum'] = CMS::CMS_sql($params2);
		 $this->_tpl_vars['PageInfo'] = &$PageInfo2;
		 
		 
		$lists = $this->_tpl_vars['lists']['data'];

		$totalNum = $this->_tpl_vars['totalNum']['data'][0]['totalNum'];
		//$itmeTatal = $this->_tpl_vars['lists']['data'][0]['itemTatal'];
		
		
		if($ctg){
			 $params3 = array (
						'action' => "sql",
						'return' => "ctglists",
						'query' => "select * from cms_share_list_category where id = {$ctg}",
			 );
			 $this->_tpl_vars['ctglists'] = CMS::CMS_sql($params3);
			 $title = $this->_tpl_vars['ctglists']['data'][0]['name']." Collections";
		}else{
			$title = "All Collections";
		}
		
?>
<?php if($totalNum > 9):?>
<script type="text/javascript">
var getAjaxGoodsIndex = 1;
var getAjaxGoodsSize = 9;
var loading = 0;

$(window).scroll(function(){
	//$(".tmallmenu").stop().animate({"marginTop":$(this).scrollTop()});
	if (($(document).height() - $(this).height()) - $(this).scrollTop() < 250){
		if(loading == 0){
			loading = 1;
			getAjaxGoodsIndex++;
			loadMoreStyleList(getAjaxGoodsIndex,getAjaxGoodsSize,'<?php echo $sort;?>','<?php echo $ctg;?>','<?php echo $shareUserID;?>');
		}
	}
});
</script>
<?php endif;?>
</head>
<body>
<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<div class="content">
        <div class="collection_top_bar oh">
            <div class="collection_title fl">
            	<span><?php echo $title;?></span>
                <!--<a>()</a>-->
            </div>          
            <div class="collection_create fr">
                <?php if ($this->_tpl_vars["name"] and ($this->_tpl_vars["method"]=="listMain" or $this->_tpl_vars["method"]=="memberShareList" or $this->_tpl_vars["method"]=="showList" or $this->_tpl_vars["method"]=="editList" or $this->_tpl_vars["method"]=="memberShareList")):?>
                <a class="add_list_button_small" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=addList'));?>">Create Your Collections</a><?php endif;?>
            </div>
            <div class="clb"></div>
			<div class="collection_nav">
            	<ul class="collection_nav_img">
                	<li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=2&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="clothes"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=3&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Shoes"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=4&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Accessory"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=5&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Sport"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=6&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Kids"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=7&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Digital"></a></li>
                 	<li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=8&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Pets"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=9&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Beauty"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=10&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Baby"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=11&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Living"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=12&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Food"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain&ctg=1&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Other"></a></li>
                </ul>
            	<div class="clb"></div>
            	<ul class="collection_nav_text">
                	<li><a class="clothes">Clothes</a></li>
                    <li><a class="Shoes">Shoes</a></li>
                    <li><a class="Accessory">Accessory</a></li>
                    <li><a class="Sport">Sport</a></li>
                    <li><a class="Kids">Kids</a></li>
                    <li><a class="Digital">Digital</a></li>
                 	<li><a class="Pets">Pets</a></li>
                    <li><a class="Beauty">Beauty</a></li>
                    <li><a class="Baby">Baby</a></li>
                    <li><a class="Living">Living</a></li>
                    <li><a class="Food">Food</a></li>
                    <li><a class="Other">Other</a></li>
                </ul>                
            
            </div>
            <div class="collection_viewBtn"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$this->_tpl_vars["name"]));?>">View Your Own</a></div>
            <div class="collection_viewBtn" style="margin-bottom:20px;"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain'));?>">View All</a></div>
        </div>
		
		<div class="style_list_main">
			<?php foreach($lists as $k => $list):?>
			<?php $items = runFunc("getMemberShareListItem",array($list["id"]),9);?>
				<div class="member_list_item fl<?php if(fmod($k+1,3)){echo ' styleListBox';}?>">
						<div class="member_list_item_header oh">
							<a title="<?php echo $list["title"];?>" class="allmember_list_title fl" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$list["id"].'&user_id='.$list["user_id"]));?>">
								<?php if(strlen($list["title"])> 35){	
									echo mb_substr($list["title"],0,35,'utf-8')."...";
								}else{
									echo $list["title"];
								}?>								 
							</a>
                            <div class="fr member_list_count"> (<?php echo count($items);?>)</div>
						</div>
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$list["id"].'&user_id='.$list["user_id"]));?>" class="member_list_item_body oh">
							<?php foreach($items as $item):?>
								<div class="main_item_img_box fl">
									<img src="<?php echo $item["goodsImgURL"]?>_310x310.jpg" alt="" />
								</div>
							<?php endforeach;?>
						</a>
						<div class="member_list_item_footer">
							<div class="created_box fl">
								<div class="member_list_avatar_box fl">
								<?php $avatar = "../publish/avatar/".$list["user_id"]."_thumb.".$list["headImageUrl"];?>
								<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$list["user_id"].'&ctg='.$this->_tpl_vars["IN"]["ctg"]));?>">
								<?php if(file_exists($avatar)){?>
									<img style="width: 30px;" src="<?php echo $avatar;?>" alt="" />
								<?php }else{?>
									<img style="width: 30px;" src="../skin/images/pic.jpg" />
								<?php }?>
								</a>
								</div>
								<div class="created_member fl">
									<span>Created by</span> <br />
									<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$list["user_id"].'&ctg='.$this->_tpl_vars["IN"]["ctg"]));?>">
									<span style="color:#e85eed">
										<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($list["user_id"]));?>
										<?php if($user_info["0"]["staffName"]):?>
                                            <?php echo $user_info["0"]["staffName"];?>
                                        <?php else:?>
                                            <?php echo $user_info["0"]["staffNo"];?>
                                        <?php endif;?>
                                     </span>
									</a>
								</div>
							</div>
							<div class="list_message_box fr">
								<div class="list_message_content">
									<span style="color:#5e97ed"><?php echo $list["count_love"];?></span> <img class="love_heart" src="/skin/images/heart.png" alt="" />
								</div>
							</div>
						</div>	
					</div>
			<?php endforeach;?>
		</div>
        <?php if($totalNum > 9):?>
		<div class="loading_box fl" style="width: 100%; text-align: center;">
			<img src="../skin/images/loading_icon.gif" alt=""/>
		</div>
        <?php endif;?>
	</div>
	<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
</div>
<span id="back-top" class="gotoup" style="display: none; position: fixed; bottom: 50px; top: auto;"></span>
<script type="text/javascript">
/*	$(function(){
		$("#sort_by").change(function(){
			$("#main_page_ctr_form").submit();
		});
	});*/
</script>
</body>
</html>