<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
//************************select country***************************************
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); 
?>
<?php if($this->_tpl_vars["name"] && $this->_tpl_vars["IN"]["userID"]){?>
<?php if($this->_tpl_vars["name"] == $this->_tpl_vars["IN"]["userID"]){
	$isMyList = true;
}else{
	$isMyList = false;
}


?>
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
	if($isMyList){
		$querysql = "select c.staffName,c.staffNo,c.headImageUrl, a.*,(select count(*) from cms_member_love where love_id = a.id) as count_love from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId where a.status=1 and a.block =0 and c.block = 0";
		
		$sumQuerysql = "select count(a.id) as totalNum from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId where  a.status=1 and a.block =0 and c.block = 0";	
	}else{
		$querysql = "select c.staffName,c.staffNo,c.headImageUrl, a.*,(select count(*) from cms_member_love where love_id = a.id) as count_love from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId where publish = 1 and  privacy = 0 and a.status=1 and a.block =0 and c.block = 0";
		
		$sumQuerysql = "select count(a.id) as totalNum from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId where publish = 1 and  privacy = 0 and a.status=1 and a.block =0 and c.block = 0";		
	}


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
		if($shareUserID){
			$ctgName = "";
			if($ctg){			
				 $params3 = array (
							'action' => "sql",
							'return' => "ctglists",
							'query' => "select * from cms_share_list_category where id = {$ctg}",
				 );
				 $this->_tpl_vars['ctglists'] = CMS::CMS_sql($params3);	
				 $ctgName = $this->_tpl_vars['ctglists']['data'][0]['name'];		
			}
			
			
			if($shareUserID == $this->_tpl_vars["name"]){
				$title = "Your ".$ctgName." Collections";
			}else{
				$user = runFunc('getUser',array($shareUserID));
				if($user[0]['staffName']){
					$title = $user[0]['staffName']." ".$ctgName." Collections";
				}else{
					$title = $user[0]['staffNo']." ".$ctgName." Collections";
				}
			}			
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
                <?php if ($this->_tpl_vars["name"] and ($this->_tpl_vars["method"]=="memberShareList" or $this->_tpl_vars["method"]=="memberShareList" or $this->_tpl_vars["method"]=="showList" or $this->_tpl_vars["method"]=="editList" or $this->_tpl_vars["method"]=="memberShareList")):?>
                <a class="add_list_button_small" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=addList'));?>">Create Your Collections</a><?php endif;?>
            </div>
            <div class="clb"></div>
			<div class="collection_nav">
            	<ul class="collection_nav_img">
                	<li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=2&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="clothes"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=3&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Shoes"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=4&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Accessory"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=5&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Sport"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=6&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Kids"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=7&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Digital"></a></li>
                 	<li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=8&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Pets"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=9&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Beauty"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=10&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Baby"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=11&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Living"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=12&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Food"></a></li>
                    <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&ctg=1&userID='.$this->_tpl_vars["IN"]["userID"]));?>" class="Other"></a></li>
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
							<a title="<?php echo $list["title"];?>" class="member_list_title fl" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$list["id"].'&user_id='.$list["user_id"]));?>">
								<?php if(strlen($list["title"])> 20){	
                                    echo mb_substr($list["title"],0,20,'utf-8')."...";
                                }else{
                                    echo $list["title"];
                                }?>		
							</a>
                            <div class="fr member_list_count"> (<?php echo count($items);?>)</div> 
							<?php if($isMyList):?>
							<div class="member_list_ctrl fr">
								<a class="member_list_editor" href="<?php echo runFunc('encrypt_url',array('action=share&method=editList&id='.$list["id"]."&user_id=".$this->_tpl_vars["name"]));?>"></a>
								<a onClick="javascript:return confirm('confirm to delete this list?')" class="member_list_delete" href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareListDelete&id='.$list["id"]."&user_id=".$this->_tpl_vars["name"]));?>"></a>
							</div>							
							<?php endif;?>
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
<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc("common/account_passPara.tpl");
		include($inc_tpl_file);
		?>

<?php } ?>



<?php exit;?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>
</head>
<body>
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	?>
	
	<?php
	if($this->_tpl_vars["IN"]["user_id"] && $this->_tpl_vars["IN"]["user_id"] == $this->_tpl_vars["name"]){
		$inc_tpl_file=includeFunc("account/common/header.tpl");
	}else{
		$inc_tpl_file=includeFunc("share/common/header.tpl");
	}
	include($inc_tpl_file);
	
	
	$lists = runFunc('getMemberShareList',array($user_id,$this->_tpl_vars["IN"]["page"],4));
	$lists_count = runFunc('getMemberShareList',array($user_id,$this->_tpl_vars["IN"]["page"],4,true));
	
	?>
	
		<div class="content">
		<div class="full_width_box oh">
			<div class="box_inner_left fl">
				<div class="box_inner_bar oh">
					<h2 class="full_box_title fl">Style Lists (<?php echo $lists_count[0]["count"];?>)</h2>
					<?php if($user_id==$this->_tpl_vars["name"]):?>
					<a class="gray_link fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=addList'));?>">Create a list</a>
					<?php endif;?>
				</div>
				<div class="member_list_box oh">
				<?php if(count($lists)>0):?>
					<?php foreach($lists as $list):?>
					
					<?php $items = runFunc("getMemberShareListItem",array($list["id"]));?>
						<div class="member_list_item fl">
						<div class="member_list_item_header oh">
							<a class="member_list_title fl" title="<?php echo $list["title"];?>" href="<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$list["id"]));?>">
								<?php if(strlen($list["title"])> 35){	
									echo mb_substr($list["title"],0,35,'utf-8')."...";
								}else{
									echo $list["title"];
								}?>
								 (<?php echo count($items);?>)
							</a>
							<?php if($list["user_id"]==$this->_tpl_vars["name"]):?>
							<div class="member_list_ctrl fr">
								<a class="member_list_editor" href="<?php echo runFunc('encrypt_url',array('action=share&method=editList&id='.$list["id"]."&user_id=".$this->_tpl_vars["name"]));?>"></a>
								<a onClick="javascript:return confirm('confirm to delete this list?')" class="member_list_delete" href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareListDelete&id='.$list["id"]."&user_id=".$this->_tpl_vars["name"]));?>"></a>
							</div>
							
							<?php endif;?>
						</div>
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$list["id"].'&user_id='.$user_id));?>" class="member_list_item_body oh">
							<?php foreach($items as $key=>$item):?>
							<?php if($key>9)break;?>
								<div class="main_item_img_box fl">
									<img src="<?php echo $item["goodsImgURL"]?>_310x310.jpg" alt="" />
								</div>
							<?php endforeach;?>
						</a>
						<?php $staff = runFunc("getStaffInfoById",array($list["user_id"]));//print_r($staff);?>
						<div class="member_list_item_footer">
							<div class="created_box fl">
								<div class="member_list_avatar_box fl">
								<?php $avatar = "../publish/avatar/".$list["user_id"]."_thumb.".$staff[0]["headImageUrl"];?>
								<a href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userId='.$list["user_id"]));?>">
								<?php if(file_exists($avatar)){?>
									<img style="width: 30px;" src="<?php echo $avatar;?>" alt="" />
								<?php }else{?>
									<img style="width: 30px;" src="../skin/images/pic.jpg" />
								<?php }?>
								</a>
								</div>
								<div class="created_member fl">
									<span>Created by</span> <br />
									<a href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userId='.$list["user_id"]));?>">
									<span style="color:#e85eed">	
									<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($list["user_id"]));?>
											<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
												<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
											<?php elseif($user_info[0]["show_nick"]==1):?>
												<?php echo $user_info["0"]["staffName"];?>
											<?php else:?>
												<?php echo $user_info["0"]["staffNo"];?>
											<?php endif;?></span>
									</a>
								</div>
							</div>
							<?php $love_count = runFunc("getShareListLoveCount",array($list["id"],"STYLE LIST"));?>
							<div class="list_message_box fr" style="margin-top: 13px;">
								<div class="list_message_content">
									<span style="color:#5e97ed"><?php echo $love_count["count"];?></span> <img src="/skin/images/heart.png" alt="" />
								</div>
								<div class="list_message_content">
									<span style="color: #5e97ed">0</span> comments
								</div>
							</div>
						</div>	
					</div>
					<?php endforeach;?>
					<?php 
					$count = $lists_count[0]["count"];
					if($this->_tpl_vars["IN"]["page"]==""){
						
						$page = 1;
					}else{
						
						$page = $this->_tpl_vars["IN"]["page"];
					}
					echo runFunc("pageNavi",array($count,4,"share","memberShareList",$page));
					?>
				<?php else:?>	
				<div class="no_posts_word" style="text-align:center;">
					The quick brown fox jumps over the lazy dog ^_^
					</div>
				<?php endif;?>
				</div>
			</div>
			<?php $member_loves = runFunc("getMemberListLove",array($user_id,"STYLE LIST",1,4));?>
			<?php $member_loves_count = runFunc("getMemberListLove",array($user_id,"STYLE LIST",1,4,true));?>
			<div class="list_love_page box_inner_right fr">
				<div class="list_love_box">
					<div class="list_love_box_title">
						Lists I Loved <span style="font-size: 11px;">(<?php echo $member_loves_count[0]["count"];?>)</span>
					</div>
					<?php if($member_loves_count[0]["count"]>0):?>
					<?php foreach($member_loves as $member_love):?>
					<div class="list_love_box_item oh">
						<a class="list_love_box_img_box fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$member_love["id"].'&user_id='.$member_love["creater_id"]));?>">
								<?php $item = runFunc("getMemberShareListItem",array($member_love["id"]),1);?>
								<img src="<?php echo $item[0]["goodsImgURL"]?>_310x310.jpg" alt="" />
						</a>
						<div class="list_love_box_content fl">
							<div class="list_love_box_item_message">
							<a title="<?php echo $member_love["title"];?>" href="<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$member_love["id"].'&user_id='.$member_love["creater_id"]));?>">
							<?php if(strlen($member_love["title"])> 20){	
									echo mb_substr($member_love["title"],0,20,'utf-8')."...";
								}else{
									echo $member_love["title"];
								}?>
							</a>
							 <br />
							<font style="color:#7ba9f0">Latest Activity: <?php echo date("M d",strtotime($member_love["created"]));?></font></div>
							<div style="word-wrap: break-word;" id="list_love_box_item_created" class="list_love_box_item_message">
							<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userId='.$member_love["user_id"]));?>">
							<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($member_love["user_id"]));?>
								<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
												<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
											<?php elseif($user_info[0]["show_nick"]==1):?>
												<?php echo $user_info["0"]["staffName"];?>
											<?php else:?>
												<?php echo $user_info["0"]["staffNo"];?>
											<?php endif;?>
								</a>
							</div>
						</div>
					</div>
					<?php endforeach;?>
					<?php else:?>
					<br />
					<center>No Lists Temporarily</center>
					<?php endif;?>
					<?php if($member_loves_count[0]["count"] > 4):?>
					<div class="list_nav" style="margin-bottom: 0">
						<a class="prev fl">Prev</a>
						<a class="next fr">Next</a>
					</div>
					<?php endif;?>
				</div>
			
			</div>
		</div>
		
		
		
		
		</div>
		<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
</div>

<script type="text/javascript">
	$(function(){
		var searching = 0;
		var page = 1;
		$(".list_nav .next").click(function(){
			if(searching == 1){
				return false;
			}
			get_item_list("share","ajaxGetLoves",<?php echo $user_id;?>,"next");
		});

		$(".list_nav .prev").click(function(){
			if(searching == 1){
				return false;
			}
			get_item_list("share","ajaxGetLoves",<?php echo $user_id;?>,"prev");
		});


		function get_item_list(action,method,user_id,type){
			if(searching == 0){
				searching = 1;
				}else{
						return false;
					}
			if(type=="next"){
				page = page + 1;
			}else{
				page = page - 1;
				}
			if(page < 1){
					page = 1;
					searching = 0;
					return false;
				}
			$(".the_end_message").remove();
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm fl loading_list_now");
			loading_icon.insertBefore($(".next"));
			$.ajax({
				url : 'index.php',
				type : 'POST',
				dataType : "json",
				data:{
					action	: action,
					method	: method,
					user_id : user_id,
					page: page,
					size: 4,
					type: "STYLE LIST"
				},
				success : function(json)
				{
					if(json == null || json.length ==0){
						page = page -1;
						loading_icon.remove();
						var the_end = $(document.createElement("span")).text("The end!").addClass("the_end_message");
						the_end.insertBefore($(".next"));
						searching = 0;
						return false;
					}
					$(".list_love_box_item").remove();
					var love = "";
					for(var i=0;i<json.length;i++)
					{
						love += '<div class="list_love_box_item oh">';
						love += '<a class="list_love_box_img_box fl" href = "'+ json[i].link +'">';
						love += '<img src="'+ json[i].img +'" alt="" />';
						love += '</a>';
						love += '<div class="list_love_box_content fl">';
						love += '<div class="list_love_box_item_message"><a href = "'+ json[i].link +'">'+json[i].title+'</a>';
						love += '<br />';
						
						love += '<font style="color:#7ba9f0">Latest Activity: '+ json[i].created+'</font>';
						
						love += '</div>';
						love += '<div style="word-wrap: break-word;" id="list_love_box_item_created" class="list_love_box_item_message">';
						love += '<a href = "'+ json[i].avatar_link +'">';
						var show_user_name ="";
						if(json[i].real_name == 1 && json[i].first_name !="" && json[i].last_name !=""){
							if(json[i].first_name !=""){show_user_name = json[i].first_name + "&nbsp;" + json[i].last_name;}							
						}			
						else if(json[i].show_nick == 1){
							
							show_user_name = json[i].staffName;
						}
						else{
							
							show_user_name = json[i].staffNo;
						}
						love += show_user_name;
						love += '</a>';
						love += '</div>';
						love += '</div>';
						love += '</div>';
					}

					$(love).insertAfter(".list_love_box_title");
					
				},complete: function(){
					loading_icon.remove();
					searching = 0;
					}
			});
			}


		
		});

</script>
</body>
</html>
