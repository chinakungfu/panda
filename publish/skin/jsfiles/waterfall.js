/*
@版本日期: 版本日期: 2012年4月11日
@著作权所有: 1024 intelligence ( http://www.1024i.com )
//Download by http://www.codefans.net
获得使用本类库的许可, 您必须保留著作权声明信息.
报告漏洞，意见或建议, 请联系 Lou Barnes(iua1024@gmail.com)
*/


function loadMore(action,method,dataTypeStr,getAjaxGoodsIndex,getAjaxGoodsSize)
{
	$.ajax({
		url : 'index.php',
		type : 'POST',
		dataType : dataTypeStr,
		data:{
			action	: action,
			method	: method,
			pageIndex:getAjaxGoodsIndex,
			pageSize:getAjaxGoodsSize
		},
		success : function(json)
		{
			//alert(json);
			if(typeof json == 'object')
			{
				var oShare, $row, iHeight, iTempHeight;
				var str;
				for(var i=0, l=json.length; i<l; i++)
				{
					oShare = json[i];
					
					// 找出当前高度最小的列, 新内容添加到该列
					iHeight = -1;
					$('#stage li').each(function(){
						iTempHeight = Number( $(this).height() );
						if(iHeight==-1 || iHeight>iTempHeight)
						{
							iHeight = iTempHeight;
							$row = $(this);
						}
					});
					str = '<div><dl><dt class="imglistSharemainImg"><a href="/publish/index.php'+oShare.urlStr+'"><img src="'+oShare.goodsImgURL+'" alt="'+oShare.goodsTitle+'" /></a><span class="rmbShare">￥ '+oShare.goodsUnitPrice+'</span></dt><dd><span class="loveIt">('+oShare.favoriteQuantity
					+') Love it</span><span class="comments">Comments ('+oShare.commentQuantity+')</span></dd><dd class="imglistSharemainUser"><img src="'+oShare.headImgUrl+'" alt="userPic"><span>Shared by </span><em>'+oShare.staffName+'</em><br />at '+oShare.shareTime+'</dd><dd class="imglistSharemainInfo"><strong>'+oShare.goodsTitle+'</strong>'+oShare.shareComment+'</dd></dl></div>';
					//alert(str);
					$item = $(str).hide();
					//$item = $('<div><img src="'+oShare.goodsImgURL+'" border="0" ><br />'+oShare.goodsTitleCN+'</div>').hide();
					$row.append($item);
					$item.fadeIn();
				}
			}
		}
	});
}
var json_data_current;
function loadMoreShopList(word,cid,getAjaxGoodsIndex,getAjaxGoodsSize)
{

if(cid == ""){
	cid = 0;
}
	//$(".loading_box").fadeIn(500);
	$.ajax({
		url : 'index.php',
		type : 'POST',
		dataType : "json",
		data:{
			word : word,
			cid : cid,
			action	: "shop",
			method	: "getAjaxShopList",
			pageIndex:getAjaxGoodsIndex,
			pageSize:getAjaxGoodsSize
		},
		success : function(json)
		{
		json_data_current = json;
		if(typeof json == 'object')
			var item;
			var html = "";
			{if(json.length==0){
				$(".loading_box").fadeIn();
				return false;
			}
				for(var i=0;i<json.length;i++)
				{
					item = json[i];
					if(json[i].price){
					html+= '<li class="new_unit"><div class="tmall_product"><div onClick="show_qucik_look_box(this)" onMouseout="hide_quick_look()" onMouseover="show_quick_look(this)" class="tmall_img" style="overflow:hidden">';
					html+= '<div class="tmall_box_price">￥'+ item.price +'</div>';
					html+= '<img  class="tmall_product_img" width="214px;" height="211px" src="'+ item.pic_url+'_310x310.jpg"/>';
					html+= '<div class="quick_look hide"></div></div>';
					html+= '<div class="tmall_product_imformation">';
					html+= '<span class="tmall_from">www.taobao.com</span>';
					html+= '<div class="tmall_view fr">';
					html+= '<form name="formAddress" id="formAddress" class="ov search_box" action="/publish/index.php" method="post">';
					html+= '<input type="hidden" name="action" value="shop"> <input type="hidden" name="type" value="tmall"><input type="hidden" name="method" value="addGoods">';	
					html+= '<input name="GoodsURL" type="hidden" value="http://item.taobao.com/item.htm?id='+ item.num_iid +'">';
					html+= '<input class="submit_view" type="submit" value="View"/>'
					html+= '</form>';
					html+= '</div>';
					html+= '</div>';
					html+= '</div>';					
					html+= '<div class="quick_look_out hide">';
					html+= '<div class="quick_look_bar">';
					html+= '<span class="quick_look_cl" onClick="hide_quick_look_box()">x</span>'
					html+= '</div>';
					html+= '<table class="quick_look_table">';
					html+= '<tr><td><img class="tmall_product_img" width="275px;" src="'+ item.pic_url+'_460x460.jpg"/></td>';
					html+= '<td>';
					html+= '<table class="quick_look_detail_table">';
					html+= '<tr>';
					html+= '<td colspan=2>The link of item <br/><input type="text" value="'+ item.click_url +'"/></td>';
					html+= '</tr>';
					html+= '<tr>';
					html+= '<td colspan=2>Name&Description <br/><input style="margin-bottom:20px;" type="text" value="'+ item.title +'"/></td>';
					html+= '</tr>';
					html+= '<tr>';
					html+= '<td width="77px"><span>Price (single)</td><td><sup style="vertical-align: top; font-size: 19px;color:#F89606">￥</sup><span class="quick_look_price">'+ item.price +'</span></td>';
					html+= '</tr>';
					html+= '<tr>';
					html+= '<td><span>Freight</span></td><td> <span class="quick_freight">￥15.00</span></td>';
					html+= '</tr>';
					html+= '<tr>';
					html+= '<td colspan=2>';
					html+= '<a target="_blank" class="quick_more" href="'+ item.click_url +'"></a>';
					html+= '<form name="formAddress" id="formAddress" class="ov search_box" action="/publish/index.php" method="post">';
					html+= '<input type="hidden" name="action" value="shop"> <input type="hidden" name="type" value="tmall"><input type="hidden" name="method" value="addGoods">';	
					html+= '<input name="GoodsURL"  type="hidden" value="http://item.taobao.com/item.htm?id='+ item.num_iid +'">';
					html+= '<input class="quick_buy" type="submit" value=""/>';
					html+= '</form></td>';
					html+= '</tr>';
					html+= '</table>';
					html+= '</td>';
					html+= '</tr>';
					html+= '</table>';
					html+= '</div></li>';
					}
				}
				
				$(".tmallUl").append(html);
				
				$(".new_unit").fadeIn(1000);
			}
			
		}
		,complete:function(json){
			loading = 0;
		}
	});
}

function loadMoreHotItems(page,size,cat_id,tag_id){

	$.ajax({
		url : 'index.php',
		type : 'POST',
		dataType : "text",
		data:{
			action	: "surprise",
			method	: "ajax_get_hot_items",
			page:page,
			cat_id:cat_id,
			tag_id:tag_id,
		},success : function(data)
		{
			var new_hot_items = $(document.createElement("div")).addClass("load_hot_items hide fl");
			new_hot_items.append(data);
			$(".surprise_box_left").append(new_hot_items);
			new_hot_items.fadeIn(1000);
		},complete :function(){
			
			loading = 0;
		}
	});
	
}

function loadMoreStyleList(page,size,sort,ctg,shareUserID){
	
	$.ajax({
		url : 'index.php',
		type : 'POST',
		dataType : "json",
		data:{
			sort: sort,
			ctg: ctg,
			shareUserID: shareUserID,
			action	: "share",
			method	: "ajaxGetStyleList",
			pageIndex:page,
			pageSize:size
		},
		success : function(json)
		{	var html ="";
			if(json.collections.length==0){
				$(".loading_box img").fadeOut();
				return false;
			}
			if(json.shareUserID){
				for(var i=0;i<json.collections.length;i++)
				{				
						if((i+1)%3){
							html += '<div class="member_list_item fl new_unit styleListBox" style="display:none">'
						}else{
							html += '<div class="member_list_item fl new_unit" style="display:none">'
						}
						html += '<div class="member_list_item_header oh"><a title="'+ json.collections[i].title +'" class="member_list_title fl" href="'+ json.collections[i].list_link +'">'+ json.collections[i].shorttitle +'</a><div class="fr member_list_count">('+ json.collections[i].itemNum +')</div>';
													
						if(json.collections[i].list_editlink && json.collections[i].list_dellink){
							html += '<div class="member_list_ctrl fr"><a class="member_list_editor" href="'+ json.collections[i].list_editlink +'"></a>';
							html += '<a onClick="javascript:return confirm(\'confirm to delete this list?\')" class="member_list_delete" href="'+ json.collections[i].list_dellink +'"></a></div>';											
						}
						
						html += '</div>';
						
						html += '<a class="member_list_item_body oh" href="'+ json.collections[i].list_link +'">';
						for(var j=0;j<json.collections[i].list_items.length;j++){
							
							html +='<div class="main_item_img_box fl"><img src="'+ json.collections[i].list_items[j].goodsImgURL +'_310x310.jpg" alt="" /></div>';
						}
						html += ''
						html +=	'</a>';	
						html += '<div class="member_list_item_footer"><div class="created_box fl">';
						html += '<div class="member_list_avatar_box fl"><a href="'+ json.collections[i].avatar_link +'"><img alt="" src="'+ json.collections[i].avatar +'" style="width: 30px;"></a></div>';
						html += '<div class="created_member fl"><span>Created by</span> <br>';
						var show_user_name ="";
						if(json.collections[i].staffName){
							show_user_name = json.collections[i].staffName;
						}
						else{
							show_user_name = json.collections[i].staffNo;
						}
						html +=	'<a href="'+ json.collections[i].avatar_link +'"><span style="color:#e85eed">'+ show_user_name +'</span></a></div>';
						html += '</div>';
						html += '<div class="list_message_box fr">';
						html += '<div class="list_message_content"><span style="color:#5e97ed">'+ json.collections[i].count_love +'</span> <img alt="" src="/skin/images/heart.png"></div>';
						//html += '<div class="list_message_content"><span style="color: #5e97ed">0</span> comments</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';	
				}
			}else{
				for(var i=0;i<json.collections.length;i++)
				{
						if((i+1)%3){
							html += '<div class="member_list_item fl new_unit styleListBox" style="display:none">'
						}else{
							html += '<div class="member_list_item fl new_unit" style="display:none">'
						}
						html += '<div class="member_list_item_header oh"><a title="'+ json.collections[i].title +'" class="allmember_list_title fl" href="'+ json.collections[i].list_link +'">'+ json.collections[i].shorttitle +'</a><div class="fr member_list_count">('+ json.collections[i].itemNum +')</div></div>';
						html += '<a class="member_list_item_body oh" href="'+ json.collections[i].list_link +'">';
						for(var j=0;j<json.collections[i].list_items.length;j++){
							
							html +='<div class="main_item_img_box fl"><img src="'+ json.collections[i].list_items[j].goodsImgURL +'_310x310.jpg" alt="" /></div>';
						}
						html += ''
						html +=	'</a>';	
						html += '<div class="member_list_item_footer"><div class="created_box fl">';
						html += '<div class="member_list_avatar_box fl"><a href="'+ json.collections[i].avatar_link +'"><img alt="" src="'+ json.collections[i].avatar +'" style="width: 30px;"></a></div>';
						html += '<div class="created_member fl"><span>Created by</span> <br>';
						var show_user_name ="";
						var show_user_name ="";
						if(json.collections[i].staffName){
							show_user_name = json.collections[i].staffName;
						}
						else{
							show_user_name = json.collections[i].staffNo;
						}
						html +=	'<a href="'+ json.collections[i].avatar_link +'"><span style="color:#e85eed">'+ show_user_name +'</span></a></div>';
						html += '</div>';
						html += '<div class="list_message_box fr">';
						html += '<div class="list_message_content"><span style="color:#5e97ed">'+ json.collections[i].count_love +'</span> <img alt="" src="/skin/images/heart.png"></div>';
						//html += '<div class="list_message_content"><span style="color: #5e97ed">0</span> comments</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
				}
			}
			$(".style_list_main").append(html);
			
			$(".new_unit").fadeIn(1000);
			
		},complete :function(){
			
			loading = 0;
		}
	});
}

function loadMoreCircles(page,size){
	
	
	
}