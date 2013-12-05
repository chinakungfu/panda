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

$my_lists = runFunc('getMyStyleList',array($this->_tpl_vars["name"]));

?>
</head>
<body onload="window.location.hash = 'here'">
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	?>


	<div class="content">
	<form id="list_submit_form" action="/publish/index.php" method="post" onSubmit="">
		<h2 class="cp_title">
			Request a Group Buy
		</h2>
		<div class="narrow_box">
			<div class="narrow_left fl group_page_narrow">
				<div class="narrow_left_bar oh">
					<h3 class="narrow_box_title fl" style="width:100%">Please Note</h3>
					<div class="narrow_box_article fl">
						If initiate a group buy, minimum of 3 buyers required; a successful group buy can get

a 20% service charge discount. When we receive your demand, the system will send an email to all

group buy members, and gives the shopping link. When we receive all of your orders and payment,

the group buy is established. If the member cancel this group buy order or this group buy is not

established due to any problem, the money will be returned to the your own customer account.

					</div>
				</div>
				<div class="narrow_left_bar oh">
					<h3 class="narrow_box_title fl">Editor</h3>
				</div>
				<?php if($this->_tpl_vars["IN"]["goodsid"]):?>
				<?php $group_item = runFunc("getGoodsById",array($this->_tpl_vars["IN"]["goodsid"]));?>
				<input type="hidden" name="group_item_id" id="group_item_id" value="<?php if($this->_tpl_vars["IN"]["goodsid"]){echo $group_item["goodsid"];}?>">
				<div class="group_item_contain gray_line_box narrow_line_box">



				<div class="group_item_preview oh">
					<img src="<?php echo $group_item["goodsImgURL"]?>_310x310.jpg" class="fl">
					<div class="gruop_item_desc_box fr">
					<div class="gruop_item_title_notice">please input items english name if you can</div>
					<textarea class="gruop_item_title_box" name="group_buy_item_name"><?php echo $group_item["goodsTitleCN"];?></textarea>
					<div class="gruop_item_intro_box"></div><div class="gruop_item_price_box">￥<?php echo number_format($group_item["goodsUnitPrice"], 2, '.', ',');?></div>
					</div>
				</div>
				<?php else:?>
				<input type="hidden" name="group_item_id" id="group_item_id" value="">
				<div class="group_item_contain gray_line_box narrow_line_box">
				<div class="no_list_item">

						Drag items from the right to your list
						<br/>
						<font style="font-size: 11px">You can choose from your style list and wish list</font>
						<br />
					</div>
				<?php endif;?>

				</div>
				<div class="group_buy_detail_box">
					<span class="group_buy_detail_box_title">Input your friend’s name and email adress who agree join this group buy</span>
					<div class="group_buy_mail_box">
						<input type="text" name="buyer_mail[]" class="list_editor_input big_input email required" value="your friend's email"/>
					</div>
					<div class="group_buy_mail_box">
						<input type="text" name="buyer_mail[]" class="list_editor_input big_input email required" value="your friend's email"/>
					</div>
					<div class="group_buy_mail_box">
						<input type="text" name="buyer_mail[]" class="list_editor_input big_input email required" value="your friend's email"/>
					</div>
					<span id="add_button">Add</span>
				</div>
				<div class="group_buy_detail_box">
					<span class="group_buy_detail_box_title">Your own description about this group buy</span> <span class="group_buy_description_limit" style="font-style:italic">(Maximum of 500 characters)</span>
					<textarea name="group_buy_description" id="group_buy_description" cols="30" rows="10"></textarea>
				</div>
				<div class="group_buy_detail_box" style="padding-left:10px;line-height:28px;margin-top: 12px">
					<input type="checkbox" value="1" name="only_friend_can_see" id="only_friend_can_see"/> <label for="only_friend_can_see">Only my friends can see</label>
				</div>
				<div class="group_buy_detail_box">
					<input type="submit" id="submit_share_list" class="blue_button_large fr" value="Save" />
					<a style="margin-right:10px" href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList'));?>" class="blue_button_large fr">Cancel</a>
				</div>
			</div>


			<div class="narrow_right fr">
				<div class="item_select_box">
					<div class="item_select_tab oh">
						<ul>
							<li id="orderlist_tab" class="active">Yourlist</li>
							<li id="wishlist_tab">Wishlist</li>
							<li id="url_tab">Input Url</li>
						</ul>
					</div>

					<select name="" id="my_list_select" class="my_list_select">

					<option value="">select your style list</option>
						<?php foreach($my_lists as $my_list):?>
						<?php  if(strlen($my_list["title"])> 30){
								$title =  mb_substr($my_list["title"],0,20,'utf-8')."...";
							}else{
								$title = $my_list["title"];
							}?>
						<option value="<?php echo $my_list["id"]?>"><?php echo $title;?></option>
						<?php endforeach;?>
					</select>
					<div class="list_nav hide">
						<a class="prev fl">Prev</a>
						<a class="next fr">Next</a>
					</div>
					<div class="list_loading_box">

					</div>
					<div id="order_list" class="item_list_box">

					</div>
				</div>
			</div>
		</div>
				<input type="hidden" name="action" value="share" />
				<input type="hidden" name="method" value="saveGroupBuy">
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
				}
			else if($(".added_items").length <1){

				alert("Please at least drag one item from the right to your list!")
				return false
				}
			else{

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

			$("#list_submit_form").validate({
				rules: {
					group_item_id:{
							required : true
						}
				},
				messages: {
					group_item_id: {

							required: "Please drag items from the right to your list"
						}
				}
				,errorPlacement: function(error, element) {
		         // console.info(element.parent().prev("th").append(error));

					if(element.is("#group_item_id")){
						error.appendTo(element.next().children(".no_list_item"));
						}

		        },
		        ignore:".ignore",
		        invalidHandler: function(form,validator){


			      }
			});

			$("#group_buy_description").keyup(function(){
				var limit = 500 - $(this).val().length;
				var limit_word = "Maximum of "+ limit +" characters";

				if($(this).val().length >=500){
					$(this).val($(this).val().substring(0, 500));
					limit_word = "Maximum of 0 characters";
				}
				$(".group_buy_description_limit").text(limit_word);
			});

			$("#add_button").click(function(){
					var group_buy_mail_box =  $(document.createElement("div")).addClass("group_buy_mail_box");
					//var small_input = $(document.createElement("input")).addClass("small_input").attr({name:"buyer_name[]",type:"text"}).val("your friend's name");
					var big_input = $(document.createElement("input")).addClass("list_editor_input big_input").attr({name:"buyer_mail[]",type:"text"}).val("your friend's email");
					var close_button = $(document.createElement("span")).addClass("close_button").text("X");
					//group_buy_mail_box.append(small_input);
					group_buy_mail_box.append(big_input);
					group_buy_mail_box.append(close_button);
					group_buy_mail_box.insertBefore($("#add_button"));

					close_button.click(function(){

							$(this).parent().remove();
						})

					small_input.focus(function(){
						if($(this).val() == "your friend's name"){
								$(this).val("");
							}
					});

					small_input.blur(function(){
						if($(this).val() == ""){
								$(this).val("your friend's name");
							}
					});

					big_input.focus(function(){
						if($(this).val() == "your friend's email"){
								$(this).val("");
							}
					});

					big_input.blur(function(){
						if($(this).val() == ""){
								$(this).val("your friend's email");
							}
					});
				});

			$(".group_buy_mail_box .small_input").focus(function(){
				if($(this).val() == "your friend's name"){
						$(this).val("");
					}
			});

			$(".group_buy_mail_box .small_input").blur(function(){
				if($(this).val() == ""){
						$(this).val("your friend's name");
					}
			});

			$(".group_buy_mail_box .list_editor_input").focus(function(){
				if($(this).val() == "your friend's email"){
						$(this).val("");
					}
			});

			$(".group_buy_mail_box .list_editor_input").blur(function(){
				if($(this).val() == ""){
						$(this).val("your friend's email");
					}
			});


			function toDecimal2(x) {
	            var f = parseFloat(x);
	            if (isNaN(f)) {
	                return false;
	            }
	            var f = Math.round(x*100)/100;
	            var s = f.toString();
	            var rs = s.indexOf('.');
	            if (rs < 0) {
	                rs = s.length;
	                s += '.';
	            }
	            while (s.length <= rs + 2) {
	                s += '0';
	            }
	            return s;
	        }

	        function fomatFloat(src,pos){
	             return Math.round(src*Math.pow(10, pos))/Math.pow(10, pos);
	        }


			$("#my_list_select").change(function(){

					get_list_item($(this).val());
				});

			function get_list_item(list_id){

				if(searching == 0){
					searching = 1;
					}else{
							return false;
						}
				$(".the_end_message").remove();
				var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm fl loading_list_now");
				loading_icon.appendTo($(".list_loading_box"));
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "json",
					data:{
						action	: "share",
						method	: "get_style_list_item_ajax",
						list_id : list_id
					},
					success : function(json)
					{

						$(".item_list_box").children().remove();
						for(var i=0;i<json.length;i++)
						{
							var item = $(document.createElement("div")).attr("id",json[i].goodsid).addClass("order_list_img_box fl").draggable({cursor: 'move',containment: 'document',helper: myHelper});
							var img = $(document.createElement("img")).attr("src",json[i].goodsImgURL +"_310x310.jpg");
							var name = $(document.createElement("span")).addClass("hide").attr("id","good_name").text(json[i].list_item_title);
							var intro = $(document.createElement("span")).addClass("hide").attr("id","good_intro").text(json[i].goodsIntro);
							var price = $(document.createElement("span")).addClass("hide").attr("id","good_price").text("￥"+toDecimal2(json[i].goodsUnitPrice));
							item.append(img);
							item.append(name);
							item.append(intro);
							item.append(price);
							$(".item_list_box").append(item);
						}

					},complete: function(){
						loading_icon.remove();
						searching = 0;
						}
				});
				}





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
							var intro = $(document.createElement("span")).addClass("hide").attr("id","good_intro").text(json[i].goodsIntro);
							var price = $(document.createElement("span")).addClass("hide").attr("id","good_price").text("￥"+toDecimal2(json[i].goodsUnitPrice));
							item.append(img);
							item.append(name);
							item.append(intro);
							item.append(price);
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
						$("#my_list_select").hide();
						$("#my_list_select").children("option:first").attr("selected","selected");
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
					$(".list_nav").hide();
					$(".active").removeClass("active");
					$(this).addClass("active");
					tab = 1;
					$("#my_list_select").show();
					$("#my_list_select").children("option:first").attr("selected","selected");
				});


				$("#url_tab").click(function(){
					tab = 3;

					$("#my_list_select").hide();
					$("#my_list_select").children("option:first").attr("selected","selected");
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
									var intro = $(document.createElement("span")).addClass("hide").attr("id","good_intro").text(json.goodsIntro);
									var price = $(document.createElement("span")).addClass("hide").attr("id","good_price").text("￥"+toDecimal2(json.price));
									item.append(img);
									item.append(name);
									item.append(intro);
									item.append(price);
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

				$(".group_item_contain ").droppable({
						 drop: handleDropEvent
				});

				function handleDropEvent( event, ui ) {

					  var draggable = ui.draggable;
					  var group_buy_item_preview = $(document.createElement("div")).addClass("group_item_preview oh");
					  var group_buy_img = $(document.createElement("img")).attr("src",ui.draggable.children("img").attr("src")).addClass("fl");

					  var group_buy_title_notice = $(document.createElement("div")).addClass("gruop_item_title_notice").text("please input items english name if you can");


					  var group_buy_title_box = $(document.createElement("textarea")).addClass("gruop_item_title_box").attr("name","group_buy_item_name");
					  var group_buy_title = ui.draggable.children("#good_name").text();
					  group_buy_title_box.append(group_buy_title);

					  var group_buy_intro_box = $(document.createElement("div")).addClass("gruop_item_intro_box");
					  var group_buy_intro = ui.draggable.children("#good_intro").text();
					  group_buy_intro_box.append(group_buy_intro);

					  var group_buy_price_box = $(document.createElement("div")).addClass("gruop_item_price_box");
					  var group_buy_price = ui.draggable.children("#good_price").text();
					  group_buy_price_box.append(group_buy_price);

					  var group_buy_item_desc_box = $(document.createElement("div")).addClass("gruop_item_desc_box fr");
					  group_buy_item_desc_box.append(group_buy_title_notice);
					  group_buy_item_desc_box.append(group_buy_title_box);
					  group_buy_item_desc_box.append(group_buy_intro_box);
					  group_buy_item_desc_box.append(group_buy_price_box);


						$("#group_item_id").val(ui.draggable.attr("id"));


					  group_buy_item_preview.append(group_buy_img);
					  group_buy_item_preview.append(group_buy_item_desc_box);




					  $(".group_item_contain").children().remove();
					  $(".group_item_contain").prepend(group_buy_item_preview);
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