



	function add_attr(el){
		
		var html = '<div class="add_input"><input class="dark_border input_bar_long" type="text" name="attr[]"> <a onClick="add_attr(this)" class="add_input cp">添加</a> | <a onClick="del_attr(this)" class="del_attr cp">删除</a></div>';
		
		$(el).parent().parent().append(html);
	}
	
	function del_attr(el){
		
		
		$(el).parent().remove();
	}
	
	var props_num = 1;
	var current_prop = 1;
	
	function getCurrentProp(el){
		
		
		current_prop  = $(el).attr("id");
	}
	
	function add_props(el){
		props_num = props_num + 1;
		var html = '<div class="add_input">名称：<input onblur="getCurrentProp(this)" id="'+ props_num +'" class="prop_titles_input prop_titles_input_'+props_num+' input_bar_md dark_border" type="text" name="prop_title[]" /> 属性：<input onblur="getCurrentProp(this)" id="'+ props_num +'" class="prop_values_input prop_values_input_'+props_num+' input_bar_long dark_border"  type="text" name="prop_value[]"/> <a onClick="add_props(this)" class="add_props cp">增加规格</a> <a class="cp" onClick="del_attr(this)">删除</a></div>';
		$(el).parent().parent().append(html);
	}
	
$(function(){
	
	$("#send_search_request").click(function(){
		
		$("#search_goods_url_form").submit();
		
	});
	
	$(".prop_titles").click(function(){
		$(".prop_titles").removeClass("add_item_active");
		$(this).addClass("add_item_active");
		var prop_id =  $(this).attr("id");
		$(".prop_titles_input_"+current_prop).val($(this).text());
		$(".prop_titles_input_"+current_prop).focus();
		$.ajax({
			url : 'index.php',
			type : 'POST',
			dataType : "json",
			data:{
				action	: "cms",
				method	: "ajax_get_prop_value",
				prop_id : prop_id
			},
			success: function(data){
				$(".props_value_box").children().remove();
				for(var i=0;i<data.length;i++){

					var prop_value = $(document.createElement("div")).addClass("value_item fl add_item_sm_box").attr("id",data[i].id).text(data[i].value);

					prop_value.click(function(){
						
						prop_value_current = $(".prop_values_input_"+current_prop).val();
						
						if(prop_value_current!=""){
							
							$(".prop_values_input_"+current_prop).val(prop_value_current+';'+$(this).text());
						}else{
							$(".prop_values_input_"+current_prop).val($(this).text());
						}
						$(".prop_values_input_"+current_prop).focus();
						
					});
					
					$(".props_value_box").append(prop_value);
				}
			}
			
		});
		
		
	});
	
$("#add_brand_tag_ajax").click(function(){
		
		
		var current_new_title = $("#new_brand_tag_title").val();
		if(current_new_title == ""){
			
			alert("请输入标签名！");
			return false;
		}
		
		$.ajax({
			url : 'index.php',
			type : 'POST',
			dataType : "json",
			data:{
				action	: "cms",
				method	: "ajax_add_brand_tag",
				title : current_new_title,
			},
			success: function(data){

					var tag = $(document.createElement("div")).addClass("tag_item fl add_item_sm_box").attr("id",data.id).text(data.title);
					tag.click(function(){
						
						var id = $(this).attr("id");
						if($(".tag_add_box #"+id).length >0){
							
							alert("请勿重复添加标签！");
							return false;
						}
						
						var add_tag = $(this).clone();
						
						var input = '<input type="hidden" name="tags[]" value="'+ id +'"/>';
						add_tag.append(input);
						
						add_tag.click(function(){
							
							$(this).remove();
						});
						add_tag.appendTo(".tag_add_box");
					});
					$(".tag_select_box").append(tag);
					 $("#new_brand_tag_title").val("");
				
			}
			,complete: function(){
				
			}
		});
		
	});
	
	$("#add_tag_ajax").click(function(){
		
		var current_cat_id = $("#tag_cats").val();
		if(current_cat_id==0){
			
			current_cat_id = "99";
		}
		
		var current_new_title = $("#new_tag_title").val();
		if(current_new_title == ""){
			
			alert("请输入标签名！");
			return false;
		}
		
		$.ajax({
			url : 'index.php',
			type : 'POST',
			dataType : "json",
			data:{
				action	: "cms",
				method	: "ajax_add_tag",
				cat_id : current_cat_id,
				title : current_new_title,
			},
			success: function(data){

					var tag = $(document.createElement("div")).addClass("tag_item fl add_item_sm_box").attr("id",data.id).text(data.title);
					tag.click(function(){
						
						var id = $(this).attr("id");
						if($(".tag_add_box #"+id).length >0){
							
							alert("请勿重复添加标签！");
							return false;
						}
						
						var add_tag = $(this).clone();
						
						var input = '<input type="hidden" name="tags[]" value="'+ id +'"/>';
						add_tag.append(input);
						
						add_tag.click(function(){
							
							$(this).remove();
						});
						add_tag.appendTo(".tag_add_box");
					});
					$(".tag_select_box").append(tag);
					 $("#new_tag_title").val("");
				
			}
			,complete: function(){
				
			}
		});
		
	});
	
	$("#tag_cats").change(function(){
		
		var cat_id = $(this).val();
		
		$.ajax({
			url : 'index.php',
			type : 'POST',
			dataType : "json",
			data:{
				action	: "cms",
				method	: "ajax_get_tags",
				cat_id : cat_id
			},
			success: function(data){
				$(".tag_select_box").children().remove();
				
				for(i=0;i<data.length;i++){
					
					var tag = $(document.createElement("div")).addClass("tag_item fl add_item_sm_box").attr("id",data[i].id).text(data[i].title);
					tag.click(function(){
						
						var id = $(this).attr("id");
						if($(".tag_add_box #"+id).length >0){
							
							alert("请勿重复添加标签！");
							return false;
						}
						
						var add_tag = $(this).clone();
						
						var input = '<input type="hidden" name="tags[]" value="'+ id +'"/>';
						add_tag.append(input);
						
						add_tag.click(function(){
							
							$(this).remove();
						});
						add_tag.appendTo(".tag_add_box");
					});
					$(".tag_select_box").append(tag);
				}
				
			}
			,complete: function(){
				
			}
		});
		
	});
	
	$(".tag_item").click(function(){
		
		var id = $(this).attr("id");
		if($(".tag_add_box #"+id).length >0){
			
			alert("请勿重复添加标签！");
			return false;
		}
		
		var add_tag = $(this).clone();
		var input = '<input type="hidden" name="tags[]" value="'+ id +'"/>';
		add_tag.append(input);
		add_tag.click(function(){
			
			$(this).remove();
		});
		add_tag.appendTo(".tag_add_box");
		
	});
	
	$(".ex_tag_item").click(function(){
		
		$(this).remove();
	});
	
	$("#search_filter").change(function(){
		
		$(".admin_filter_form").submit();
		
	});
	
	$(".save").click(function(){
		
		$(".admin_form").submit();
		
	});
	
	$(".save_send").click(function(){
		$("#send").val(1);
		$(".admin_form").submit();
		
	});
	
	$(".save_and_group_buy").click(function(){
		
		$("#group_buy").val(1);
		$(".admin_form").submit();
		
	});
	
	$(".save_group_buy").click(function(){
		
		if($(this).text()=="保存修改"){
			
			if(!confirm("是否确认对该团购信息进行修改？")){
				
				
				return false;
			}
			
		}
		if($(this).text()=="通过审核并发布"){
			
				if(!confirm("是否确认该团购信息，并发布？")){
				
				
				return false;
			}
		}
		$(".admin_form").submit();
	});
	
	$(".admin_form_check_all").click(function(){
			
			$(".admin_form_check_box").attr('checked', this.checked);
	
	
	});
	
	$(".batch_delete").click(function(){
		
		if($(this).text()=="批量删除"){
			
			if(confirm("是否确认此批量删除操作？")){
				
				
			}else{
				
				return false;
			}
		}
		
		if($(this).text()=="批量恢复"){
					
					if(confirm("是否确认此批量恢复操作？")){
						
						
					}else{
						
						return false;
					}
				}
		
		
		var del_vals = new Array();
		var file = new Array();
		
		$(".admin_form_check_box:checked").each(function(){
			
			del_vals.push($(this).val());
			file.push($(this).attr("file"));
		});
		
		if(del_vals.length == 0){
			
			alert("请选择至少选择一项！");
			return false;
		}
		$.ajax({
			url : 'index.php',
			type : 'POST',
			dataType : "json",
			data:{
				action	: "cms",
				method	: "product_delete",
				delete_type : $(this).attr("delete"),
				id : del_vals.join(),
				file : file.join()
			},complete: function(){
				
				
				location.reload();
			}
		});
		
	});
	
});