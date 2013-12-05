<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

$item = runFunc("getNewletter",array($this->_tpl_vars["IN"]["id"]));

$CKEditor->config['toolbar'] = "Full";
?>

<div class="help_mail_preview">
<table style="border-bottom:1px solid black;width:600px;margin:auto">
<tr>
	<td>
		<img style="margin-left: 20px" src="../skin/images/logo.jpg" width="190"/>
	</td>
	<td style="text-align:right"><a class="cp" id="close_preview">关闭</a></td>
</tr>
</table>
<table style="margin:auto;width:540px;">
	<tr>
		<td>
			<table style="line-height: 20px;width:100%">
				<tr>
					<td id="reply" style="font-size:12px;">
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table style="margin:auto;width:540px;text-align:center;font-size:12px;margin-top:15px;" id="items_preview_table">

</table>

<table style="border-top:1px solid black;width:600px;margin:auto;text-align:right;font-size:11px;margin-top:50px;">
	<tr>
		<td style="text-align:left;padding-left:10px;">If you do not wish to receive our newsletter, please send <font style="color:red">un-subscribed</font></td>
		<td style="padding-right:10px;">
			WOWSHOPPING &copy;2012 
		</td>
	</tr>
</table>
</div>
<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);


?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			newsletter编辑
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_3"><a class="save_send" href="#">保存并发送</a></li>
			<li id="ctrl_3"><a id="mail_preview" href="#">预览</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=newsletter_list&type=media'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="newsletter_save" />
		<input type="hidden" name="letter_id" value="<?php echo $this->_tpl_vars["IN"]["id"]?>" />		
		<input type="hidden" id="send" name="send" value="0" />
		<div class="request_items">
		<?php $message_items = runFunc("getNewsletterItem",array($this->_tpl_vars["IN"]["id"]))?>
			<?php foreach($message_items as $message_item):?>
			
			<table class='group_buy_item_table'>
				<tr>
					<td width='20%'><img class='item_img' width='100px' src='<?php echo $message_item["goodsImgURL"];?>_310x310.jpg' /></td>
					<td width='60%'>
						<input class="request_item_title" value="<?php echo $message_item["title"];?>" name="request_item_title[]">
						<br><br>
						<input class="request_item_url" value="<?php echo $message_item["item_url"];?>" name="request_item_url[]">
					</td>
					<td width='10%' class="item_price">
						原价:<input class='dark_border input_bar_long request_item_original_price' style='width:50px' name='request_item_original_price[]' value='<?php echo $message_item["original_price"]?>'><br />
						
						<br />售价:<input class='dark_border input_bar_long request_item_price' style='width:50px' name='request_item_price[]' value='<?php echo $message_item["price"]?>'>
					</td>
					<td width='10%' class="item_price"><a class="cp" onclick="javascript:remove_item(this)">删除</a><input type="hidden" value="<?php echo $message_item["goods_id"]?>" name="request_item_id[]"></td>
				</tr>
			</table>
			
			<?php endforeach;?>	
		</div>
			
			
			<table class="admin_edit_table">
				<tr>
					<th>标题</th>
					<td><input type="text" name="letter_title" id="letter_title" class="dark_border input_bar_long required" value="<?php echo $item[0]["title"]?>"/></td>
				</tr>
				<tr>
					<th>抓取商品URL</th>
					<td>
						<input type="text" name="search_url" id="search_url" class="dark_border input_bar_long"/>
						<a id="get_item_help" class="cp">点击抓取</a>
					</td>
				</tr>
				 <tr>
					<th>文字内容</th>
					<td>
						<?php $CKEditor->editor("description",$item[0]["content"]);?>
					</td>
				</tr> 
			</table>
	

	
		</form>
	
	</div>
</div>
</div>
<script type="text/javascript">

	function remove_item(el){

			$(el).parent().parent().remove();

		}

	$(function(){

			$("#close_preview").click(function(){
				$(".help_mail_preview").dialog("close");
				});
		
			$(".help_mail_preview").dialog({

				autoOpen: false,
				width: 620,
				resizable: false,
				});

		
			$("#mail_preview").click(function(){
				$("#items_preview_table").children().remove();
				<?php if($item[0]["reply_time"]==""):?>
				var reply_html = CKEDITOR.instances.description.getData();
				<?php else:?>
				var reply_html = $("#reply_content").html();
				<?php endif;?>
				var html = "<tr>";
					$(".item_img").each(function(index){

							if($(".item_img").length>3 && !(index%3)){
								html +="</tr><tr>"
								}
							html += '<td style="vertical-align: top;"><a><img style="border: 1px solid #777777" width="150px;" src="'+ $(this).attr("src")+'"><div style="width:150px;margin:auto;margin-top:10px;height: 32px; overflow: hidden;"><a style="color:#D54D4D;text-decoration:none">'+ $(".request_item_title").eq(index).val() +'</a></div><font style="text-decoration: line-through;color:gray">￥'+ $(".request_item_original_price").eq(index).val() +'</font><br/><font style="color:orange">￥'+$(".request_item_price").eq(index).val() +'</font><br><br></td>';
							
						});
					html += "</tr>";

				$("#items_preview_table").append(html);
				$("#reply").html("<br>"+reply_html);
				$(".help_mail_preview").dialog("open");
				});

		
			$("#get_item_help").click(function(){
				if($("#search_url").val()==""){
						alert("请需抓取的URL!");

						return false;
					}
				var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm loading_list_now");
				loading_icon.insertAfter($("#get_item_help"));
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "json",
					data:{
						action	: "cms",
						method	: "ajaxGetUrlSearch",
						search_url: $("#search_url").val(),
						other_get: 1
					},
					success : function(json)
					{			if(json==null){
										$("#search_url").val("");
										loading_icon.remove();
										searching = 0;
										alert("抓取失败，请检查URL!");
									}else{

									var html = "<table class='group_buy_item_table'><tr>";
									html +="<td width='20%'><img class='item_img' width='100px' src='"+ json["goodsImgURL"] +"_310x310.jpg' /></td><td width='60%'><input class='request_item_title' name='request_item_title[]' value='"+ json["goodsTitleCN"] +"'><br><br><input class='request_item_url' name='request_item_url[]' value='"+ json["id_link"] +"'/></td><td width='10%' class='item_price'>原价:<input class='dark_border input_bar_long request_item_original_price' style='width:50px' name='request_item_original_price[]' value='"+ json["goodsUnitPrice"] +"'><br /><br />售价:<input class='dark_border input_bar_long request_item_price' style='width:50px' name='request_item_price[]' value='"+ json["goodsUnitPrice"] +"'></td>";
									html += "<td width='10%'><a onClick='javascript:remove_item(this)' class='cp'>删除</a><input type='hidden' name='request_item_id[]' value='"+json['goodsid']+"'/></td></tr></table>";
									}
							
						$(".request_items").append(html);
						
						
					},complete: function(){
						$("#search_url").val("");
						loading_icon.remove();
						searching = 0;
						}
				});
				});
		})
</script>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
