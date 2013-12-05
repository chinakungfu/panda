<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
 if ($this->_tpl_vars["name"]){?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
$order_list = runFunc('getOrderList',array($this->_tpl_vars["name"],1,18));
$listCategory = runFunc('getStyleListCategory');
?>
</head>
<body>
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	
	
	<div class="content">
	<form id="list_submit_form" action="/publish/index.php" method="post" onSubmit="return formCheck()">
    	<div class="collection_top_bar oh">
            <div class="collection_title" style="margin-bottom:10px;">
                <span>Create a New Collection!</span>
            </div>
        </div>
		<div class="narrow_box">
			<div class="narrow_left fl">
				<div class="narrow_left_bar oh">
					<h3 class="narrow_box_title fl">Editor</h3>
					<input type="submit" id="submit_share_list" class="blue_button_large fr" value="Save" />
					<a style="margin-right:10px" href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$this->_tpl_vars["name"]));?>" class="blue_button_large fr">Cancel</a>
				</div>
				<div class="gray_line_box narrow_line_box">
						<table class="list_editor_table">
							<tr>
								<th style="line-height: 46px;vertical-align: top;">Category</th>
								<td>
                                	<select name="categoryID" id="categoryID" style="color: #777777;width:160px;height:24px;line-height:24px; vertical-align:middle;font-size:13px;">
                                    	<option value="0" selected>Choose a Category</option>
                                        <?php foreach($listCategory as $cate => $cateVal):?>
                                        	<option value="<?php echo $cateVal['id'];?>"><?php echo $cateVal['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
								</td>
							</tr>                        
							<tr>
								<th style="line-height: 46px;vertical-align: top;">List Name</th>
								<td>
									<input class="list_editor_input big_input" type="text" id="list_name" maxlength="80" name="list_name"/>
									<br/>
									<font style="font-style:italic">( Required ) Maximum of 80 characters</font>
								</td>
							</tr>
							<tr>
								<th style="line-height: 32px;vertical-align: top;">Description</th>
								<td>
									<textarea onkeyup="checkWordLen(this);" name="description" class="list_editor_input list_editor_textarea"></textarea>
									<br/>
									<font style="font-style:italic">( Optional ) Maximum of 450 characters</font>
								</td>
							</tr>
							<tr>
								<th>Privacy</>
								<td>
									<input type="radio" checked="checked" id="public" name="privacy" value="0"/> <label style="color:#4e4c4c;font-size:12px;" for="public">Public</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" id="private" name="privacy" value="1"/> <label style="color:#4e4c4c;font-size:12px;" for="private">Private</label>
								</td>
								<td>
									
								</td>
							</tr>
							<tr>
								<th style="color:#8d0000;font-weight:bold;">Status</th>
								<td>
								
									<input type="radio" checked="checked" id="publish" name="published" value="1"/> <label style="color:#4e4c4c;font-size:12px;" for="publish">Publish</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" id="unpublish" name="published" value="0" /> <label style="color:#4e4c4c;font-size:12px;" for="unpublish">Unpublish</label>
								</td>
							</tr>
                            <tr><td colspan="2"><span style="color:#a10000; position:relative;top:3px;">*</span> You list will not show on main page if items are less than 9 in the list.</td></tr>
						</table>
				</div>
				<div class="narrow_msg_bar gray_msg_bar">
					You can change item's name to English and write your own description bellow.
				</div>
				<div class="list_item_contain gray_line_box narrow_line_box">
					
					<?php if($this->_tpl_vars["IN"]["add_item_id"] != ""):?>
					<?php $item = runFunc("getMemberShareListItemById",array($this->_tpl_vars["IN"]["add_item_id"]));?>
					<div class="added_items">
						<div class="added_item_img fl">
							<img src="<?php echo $item[0]["goodsImgURL"];?>" alt=""/>
						</div>
						<div class="added_info_desc_box fl">
							<input class="added_item_info fl" type="text" name="added_item_title[<?php echo $item[0]["goodsid"];?>]" value="<?php echo $item[0]["list_item_title"];?>" maxlength="80">
							<textarea class="added_item_desc" name="added_item_desc[<?php echo $item[0]["goodsid"];?>]"><?php if(trim($item[0]["list_item_desc"])==""){echo "Maximum of 300 characters";}else{ echo $item[0]["list_item_desc"];}?></textarea>
						</div>
						<div class="del_added_item fr">X</div>
						<input type="hidden" name="add_item_id[<?php echo $item[0]["goodsid"];?>]" value="<?php echo $item[0]["goodsid"];?>">
					</div>
					<?php endif;?>
					
					<?php if($this->_tpl_vars["IN"]["add_good_id"] != ""):?>
					<?php $item = runFunc("getCartGoodsItem",array($this->_tpl_vars["IN"]["add_good_id"]));?>
					<div class="added_items">
						<div class="added_item_img fl">
							<img src="<?php echo $item[0]["goodsImgURL"];?>" alt=""/>
						</div>
						<div class="added_info_desc_box fl">
							<input class="added_item_info fl" type="text" name="added_item_title[<?php echo $item[0]["goodsid"];?>]" value="<?php echo $item[0]["goodsTitleCN"];?>" maxlength="80">
							<textarea class="added_item_desc" name="added_item_desc[<?php echo $item[0]["goodsid"];?>]"><?php if(trim($item[0]["list_item_desc"])==""){echo "Maximum of 300 characters";}else{ echo $item[0]["list_item_desc"];}?></textarea>
						</div>
						<div class="del_added_item fr">X</div>
						<input type="hidden" name="add_item_id[<?php echo $item[0]["goodsid"];?>]" value="<?php echo $item[0]["goodsid"];?>">
					</div>
					<?php endif;?>
					<div class="no_list_item">
						Drag items from the right to your list
						<br/>
						<font style="font-size: 11px">You can choose from your order list and wish list</font>
					</div>
				</div>
			</div>
			<div class="narrow_right fr">
				<div class="item_select_box">
					<div class="item_select_tab oh">
						<ul>
							<li id="orderlist_tab" class="active">Orderlist</li>
							<li id="wishlist_tab">Wishlist</li>
							<li id="url_tab">Input Url</li>
						</ul>
					</div>
					<div class="list_nav">
						<a class="prev fl">Prev</a>
						<a class="next fr">Next</a>
					</div>
					<div id="order_list" class="item_list_box">
						<?php foreach($order_list as $order):?>
						<?php if(trim($order["cartIDstr"])!=""):?>
						<?php $good = runFunc('getOrderListGoods',array($order["cartIDstr"]));?>
						<?php if($good["goodsImgURL"] != ""):?>
						<div id="<?php echo $good["goodsid"];?>" class="fl order_list_img_box">
							<img src="<?php echo $good["goodsImgURL"]."_310x310.jpg";?>" alt="" />
							<span id="good_name" class="hide"><?php echo $good["goodsTitleCN"];?></span>
						</div>
						<?php endif;?>
						<?php endif;?>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</div>
				<input type="hidden" name="action" value="share" /> 
				<input type="hidden" name="method" value="saveList">
				<input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars["name"];?>" />
		</form>
	</div>
	
	
	<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
	</div>
	<script type="text/javascript">
	function formCheck(){

		if($("#list_name").val()==""){			
			alert("Please input list name!");
			return false
		}else if($("#categoryID").val()==0){
			alert("Please Choose a Category!");
			return false			
		}else if($(".added_items").length <1){

				alert("Please at least drag one item from the right to your list!")
				return false
			}else{

			return true;
		}	
			
		}
	
	function checkWordLen(e,limit){
		var limit = 450 - $(e).val().length;
	
		if($(e).val().length >=450){
			$(e).val($(e).val().substring(0, 450));
		}
	}
	
		$(function(){

			
			function checkWordLen(e){
				var limit = 300 - $(e).val().length;
			
				if($(e).val().length >=300){
					$(e).val($(e).val().substring(0, 300));
				}
			}
			
			function get_item_list(action,method,id,type){
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
						id : id,
						page: page,
						size: 18,
						tab: tab
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
						$(".item_list_box").children().remove();
						for(var i=0;i<json.length;i++)
						{
							var item = $(document.createElement("div")).attr("id",json[i].goodsid).addClass("order_list_img_box fl").draggable({cursor: 'move',containment: 'document',helper: myHelper});
							var img = $(document.createElement("img")).attr("src",json[i].goodsImgURL +"_310x310.jpg");
							var name = $(document.createElement("span")).addClass("hide").attr("id","good_name").text(json[i].goodsTitleCN);
							item.append(img);
							item.append(name);
							$(".item_list_box").append(item);
						}
						
					},complete: function(){
						loading_icon.remove();
						searching = 0;
						}
				});
				}


			var tab = 1;
			var page = 1;
			var searching = 0;

			
				$("#wishlist_tab").click(function(){
					if(tab == 2 || searching == 1){
							return false;
						}
						$("#order_list").children().remove();
						$(".loading_box").remove();
						$(".list_nav").show();
						$(".active").removeClass("active");
						$(this).addClass("active");
						tab = 2;
						page = 0;
						get_item_list("share","getAjaxShareList",<?php echo $this->_tpl_vars["name"];?>,"next");
					});

				$("#orderlist_tab").click(function(){
					if(tab == 1 || searching == 1){
						return false;
					}
					$("#order_list").children().remove();
					$(".loading_box").remove();
					$(".list_nav").show();
					$(".active").removeClass("active");
					$(this).addClass("active");
					tab = 1;
					page = 0;
					get_item_list("share","getAjaxShareList",<?php echo $this->_tpl_vars["name"];?>,"next");
				});


				$("#url_tab").click(function(){
					tab = 3;
					if($(this).hasClass("active") || searching == 1){
							return false;
						}
						$(".active").removeClass("active");
						$(this).addClass("active");
						$("#order_list").children().remove();
						$(".list_nav").hide();
						var loading_box = $(document.createElement("div")).addClass("loading_box");
						var search_box = $(document.createElement("div")).addClass("search_box");
						var search_url_input = $(document.createElement("input")).attr("type","text").addClass("search_url_input").val("Input the item link from tmall or taobao");
						var search_url_submit = $(document.createElement("input")).attr("type","button").addClass("search_url_submit");
						search_url_input.click(function(){
								if($(this).val()=="Input the item link from tmall or taobao"){
									$(this).val("");
								}
							});
						search_url_input.blur(function(){
							if($(this).val()==""){
								$(this).val("Input the item link from tmall or taobao");
							}
						});
						
						search_url_submit.click(function(){
							if(searching == 0){
									searching=1;
								}else{
										return false;
									}
							var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
							$("#search_failed").remove();
							$(".loading_box").append(loading_icon);
							search_url = $(".search_url_input").val();
							$.ajax({
								url : 'index.php',
								type : 'POST',
								dataType : "json",
								data:{
									action	: "share",
									method	: "getAjaxShareList",
									url : search_url,
									tab : 3,
									id: <?php echo $this->_tpl_vars["name"];?>
								},
								success : function(json)
								{if(json == null || json.length == 0){
										$(".loading_sm").hide();
										$(".loading_box").append("<span id='search_failed'>Search failed,Please check your url !</span>");
										return false;
									}
									var item = $(document.createElement("div")).attr("id",json.goods_id).addClass("order_list_img_box fl").draggable({cursor: 'move',containment: 'document',helper: myHelper});
									var img = $(document.createElement("img")).attr("src",json.img +"_310x310.jpg");
									var name = $(document.createElement("span")).addClass("hide").attr("id","good_name").text(json.title);
									item.append(img);
									item.append(name);
									$(".item_list_box").append(item);
								}
								,complete :function(){
										searching=0;
										$(".loading_sm").hide();
										$(".search_url_input").val("");
									}
							});

							});
						loading_box.append(search_box);
						search_box.append(search_url_input);
						search_box.append(search_url_submit);
						loading_box.insertBefore("#order_list");
					
						
					});
			
				$(".list_nav .next").click(function(){
					if(searching == 1){
						return false;
					}
					get_item_list("share","getAjaxShareList",<?php echo $this->_tpl_vars["name"];?>,"next");
				});

				$(".list_nav .prev").click(function(){
					if(searching == 1){
						return false;
					}
					get_item_list("share","getAjaxShareList",<?php echo $this->_tpl_vars["name"];?>,"prev");
				});

				$(".order_list_img_box").draggable({
						cursor: 'move',
					    containment: 'document',
					    helper: myHelper
					});

				function myHelper( event ) {
				var img = $(event.currentTarget).children("img");
				var name = $(event.currentTarget).children("#good_name");
				  return '<div class="drag_box"><div class="fl order_list_img_box in_drag_img_box"><img width="65px" src="'+ $(img).attr("src") +'" alt="" /></div><div class="drag_item_name">'+ $(name).text()  +'</div></div>';
				}

				$(".list_item_contain ").droppable({
						 drop: handleDropEvent
				});

				function handleDropEvent( event, ui ) {
				  var draggable = ui.draggable;
					var added_item = $(document.createElement("div")).addClass("added_items");
					var img_box = $(document.createElement("div")).addClass("added_item_img fl");
					var added_item_info = $(document.createElement("input")).attr("type","text").attr("name","added_item_title["+ui.draggable.attr("id")+"]").addClass("added_item_info fl").val(ui.draggable.children("#good_name").text()).attr("maxlength","80");
					var added_img = $(document.createElement("img")).attr("src",ui.draggable.children("img").attr("src"));
					var del_added_button = $(document.createElement("div")).addClass("del_added_item fr").text("X");
					var added_item_desc = $(document.createElement("textarea")).attr("name","added_item_desc["+ui.draggable.attr("id")+"]").addClass("added_item_desc").val("Maximum of 300 characters");
					var added_info_desc_box = $(document.createElement("div")).addClass("added_info_desc_box fl");
					var added_item_id = $(document.createElement("input")).attr("type","hidden").attr("name","add_item_id["+ui.draggable.attr("id")+"]").val(ui.draggable.attr("id"));
					added_item_desc.blur(function(){
							if($(this).val()==""){
								$(this).val("Maximum of 300 characters");
							}
						});

					added_item_desc.click(function(){
						if($(this).val()=="Maximum of 300 characters"){
							$(this).val("");
						}
						});
					added_item_desc.keyup(function(){
							
							checkWordLen(this);
						});

					$(".no_list_item").remove();
					img_box.append(added_img);
					added_info_desc_box.append(added_item_info);
					added_info_desc_box.append(added_item_desc);
					added_item.append(img_box);
					added_item.append(added_info_desc_box);
					added_item.append(del_added_button);
					added_item.append(added_item_id);
					del_added_button.click(function(){
							$(this).parent().remove();
						});
					$(".list_item_contain").prepend(added_item);
				}



				$(".del_added_item").click(function(){
					$(this).parent().remove();
				});
				
				$(".added_item_desc").keyup(function(){
							
						checkWordLen(this);
					});
				$(".added_item_desc").blur(function(){
					if($(this).val()==""){
						$(this).val("Maximum of 300 characters");
					}
				});

				$(".added_item_desc").click(function(){
					if($(this).val()=="Maximum of 300 characters"){
						$(this).val("");
					}
					});
			});

	</script>
<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

<?php } ?>