<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

$item = runFunc("getMemberHelpMessage",array($this->_tpl_vars["IN"]["id"]));

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
<table style="margin:auto;margin-top:15px;width:560px;">
	<tr>
		<td style="font-size:14px;">Dear <font style="color:#bad782;"><span class="reply_name"></span></font><br /><br /></td>
	</tr>
</table>
<table style="margin:auto;width:540px;">
	<tr>
		<td>
			<table style="line-height: 20px;">
				<tr>
					<td id="reply" style="font-size:12px;">

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table style="margin:auto;width:540px;text-align:center;font-size:12px;" id="items_preview_table">

</table>
<table style="margin:auto;width:540px;font-size:12px;">
	<tr>
		<td style="font-size:12px;"><br/>Sincerely, <br/>

The WOWSHOPPING SERVICE TEAM<br/>

Online Order Procedure</td>
		</tr>
</table>

<table style="border-top:1px solid black;width:600px;margin:auto;text-align:right;font-size:11px;margin-top:50px;">
	<tr>
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
			直接回复咨询
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">发送</a></li>
			<li id="ctrl_3"><a id="mail_preview" href="#">预览</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=newsletter_list&type=media'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">

		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="admin_help_mail_save" />
		<input type="hidden" id="send" name="send" value="0" />
		<div class="request_items">

		</div>
			<table class="admin_edit_table">
				<tr>
					<th>回复称谓：</th>
					<td><input type="text" name="reply_name" id="reply_name" class="dark_border input_bar_long required"/></td>
				</tr>
				<tr>
					<th>回复email地址：</th>
					<td><input type="text" name="email" id="email" class="dark_border input_bar_long required email"/></td>
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
						<?php $CKEditor->editor("description");?>
					</td>
				</tr>
			</table>

		</form>

	</div>
</div>
</div>
<script type="text/javascript">

	function remove_item(el){

			$(el).parent().parent().parent().remove();

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
								html += '<td><a><img style="border: 1px solid #777777" width="150px;" src="'+ $(this).attr("src")+'"><div style="width:150px;margin:auto"><a style="color:#D54D4D;text-decoration:none">'+ $(".request_item_title").eq(index).val() +'</a></div><br/>'+ $(".item_price").eq(index).text() +'</td>';

						});
					html += "</tr>";
				$(".reply_name").text($("#reply_name").val());
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
										html +="<td width='20%'><img class='item_img' width='100px' src='"+ json["goodsImgURL"] +"_310x310.jpg' /></td><td width='60%'><input class='request_item_title' name='request_item_title[]' value='"+ json["goodsTitleCN"] +"'></td><td width='10%' class='item_price'>￥"+ json["goodsUnitPrice"] +"</td>";
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