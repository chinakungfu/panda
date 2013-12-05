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
<link href="/publish/skin/jsfiles/jquery-ui-1.8.24.custom.css" rel="stylesheet" type="text/css"/>
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
			Create a Poll
		</h2>
		<div class="narrow_box">
			<div class="narrow_left fl">
				<div class="narrow_left_bar oh">
				<h3 class="narrow_box_title fl">Editor</h3>
				<input type="submit" id="submit_share_list" class="blue_button_large fr" value="Save" />
					<a style="margin-right:10px" href="<?php echo runFunc('encrypt_url',array('action=share&method=PollList'));?>" class="blue_button_large fr">Cancel</a>
				</div>
				<div class="poll_item_contain gray_line_box narrow_line_box">
						<table class="list_editor_table">
							<tr>
								<th style="line-height: 46px;vertical-align: top;">Poll Name</th>
								<td>
									<input class="list_editor_input big_input required" type="text" id="poll_name" maxlength="255" name="poll_name"/>
									<br/>
									<font style="font-style:italic">( Required ) Maximum of 255 characters</font>
								</td>
							</tr>
							<tr>
								<th style="line-height: 46px;vertical-align: top;">Close Date</th>
								<td>
									<input class="list_editor_input big_input datePicker required" style="width: 104px;" type="text" value="<?php echo date("Y-m-d");?>" name="close_date"/>
									<br/>
									<font style="font-style:italic">( Required )</font>
								</td>
							</tr>
						</table>
						<div class="poll_item_main_box oh">
							
							<div class="poll_item_box fl">
								<div class="remove_poll_item_box">
									<a class="remove_poll_item hide">Remove</a>
								</div>
								<div class="poll_img_content">
									<div class="no_poll_item">
										<div class="no_poll_text">
											Drag and drop item <br />from the list on right <br /> here
										</div>
									</div>
								</div>
							</div>
							<div class="poll_item_box fl">
								<div class="remove_poll_item_box">
									<a class="remove_poll_item hide">Remove</a>
								</div>
								<div class="poll_img_content">
									<div class="no_poll_item">
										<div class="no_poll_text">
											Drag and drop item <br />from the list on right <br /> here
										</div>
									</div>
								</div>
							</div>
							<div class="poll_item_box fl">
								<div class="remove_poll_item_box">
									<a class="remove_poll_item hide">Remove</a>
								</div>
								<div class="poll_img_content">
									<div class="no_poll_item">
										<div class="no_poll_text">
											Drag and drop item <br />from the list on right <br /> here
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<input type="hidden" name="poll_item_num" id="poll_item_num" value="0"/>
				</div>
				<div class="poll_notice">Note: You need at least choose 2 items</div>
				
				
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
				<input type="hidden" name="method" value="savePoll">
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

			$(".datePicker").datepicker({ dateFormat: "yy-mm-dd" });
			
			$("#list_submit_form").validate({
				rules: {
					poll_item_num:{
							required : true,
							range: [2,3]
						}
				},
				messages: {
					poll_item_num: {

							required: "Please drag items from the right to your list",
							range: "You need at least choose 2 items"
						}
				}
				,errorPlacement: function(error, element) {
		         // console.info(element.parent().prev("th").append(error));

					if(element.is("#poll_item_num")){
						error.appendTo(element.parent());
						}
			         
		        },
		        ignore:".ignore",
		        invalidHandler: function(form,validator){
						

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
				  return '<div class="poll_drag_box"><img width="100px" src="'+ $(img).attr("src") +'" alt="" /><br />'+$(name).text()+'</div>';
				}

				$(".remove_poll_item").click(function(){

						$(this).hide();
						$(this).parent().siblings(".poll_img_content").children().remove();
						var no_poll_item = $(document.createElement("div")).addClass("no_poll_item");
						var no_poll_html = " Drag and drop item<br>from the list on right<br>here";
						var no_poll_text = $(document.createElement("div")).addClass("no_poll_text");
						no_poll_text.append(no_poll_html);
						no_poll_item.append(no_poll_text);
		
						
						$(this).parent().siblings(".poll_img_content").append(no_poll_item);

						$("#poll_item_num").val(Number($("#poll_item_num").val()) - 1);

					});
				
				$(".poll_item_box ").droppable({
						 drop: function(event,ui){

							  var draggable = ui.draggable;
							  var poll_item_img = $(document.createElement("img")).attr("src",ui.draggable.children("img").attr("src")).addClass("fl");
							  var poll_item_title = ui.draggable.children("#good_name").text();
							  var poll_item_price = ui.draggable.children("#good_price").text();

							  var poll_hidden_input = $(document.createElement("input")).attr("type","hidden").attr("name","poll_items[]").val(ui.draggable.attr("id"));
							  
							  var poll_img_box = $(document.createElement("div")).addClass("poll_img_box");
							  var poll_item_detail = $(document.createElement("div")).addClass("poll_item_detail"); 

							  var title_input = $(document.createElement("textarea")).addClass("poll_diy_title").attr("name","poll_diy_title[]").val(poll_item_title);
						      var detail_html = poll_item_price;
							  
							  poll_img_box.append(poll_item_img);
							  poll_item_detail.append(detail_html);
							  poll_item_detail.append(poll_hidden_input);

							  $(this).children(".poll_img_content").children().remove();
							  $(this).children(".poll_img_content").append(poll_img_box);
							  $(this).children(".poll_img_content").append(title_input);
							  $(this).children(".poll_img_content").append(poll_item_detail);
							  $(this).children(".remove_poll_item_box").children(".remove_poll_item").show();

							  $("#poll_item_num").val(Number($("#poll_item_num").val()) + 1);

								if(Number($("#poll_item_num").val())>=2){

										$("label.error").remove();
									}
							  
							 }
				});




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