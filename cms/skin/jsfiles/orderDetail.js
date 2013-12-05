// JavaScript Document
$(function(){
	$(".saveas_box").hover(function(){
		$(".saveas").stop(true,true).show();
	},function(){
		$(".saveas").stop(true,true).hide();
	});

	$(".editOrder_box").hover(function(){
		$(this).children(".editOrder").stop(true,true).show();
	},function(){
		$(this).children(".editOrder").stop(true,true).hide();
	});
	$("#showOrderItemCon").click(function(){
		$("#orderItemCon").show();
	});
	$("#hideOrderItemCon").click(function(){
		$("#orderItemCon").hide();
	});	
	$(".viewOperator").hover(
		function(){
			var operator = $(this).attr("operator");
			if(operator){
				$("#orderOperator").text(operator);
				$("#orderOperator").show();
			}
		},
		function(){
			$("#orderOperator").hide();
		}
	);
	$(".saveHover ul>li").hover(
	  function () {
		$(this).css("background-color","#dfb4b3");
		$(this).find("a").css("color","#fff");
		$(this).find("span").css("color","#fff");
	  },
	  function () {
		$(this).css("background-color","#fff");
		$(this).find("a").css("color","#a10000");
		$(this).find("span").css("color","#b2b2b2");
	  }
	);	
	//保存商品信息
	$(".save_modify_item").click(function(){
		var cartID = $(this).attr("cartid");
		var orderID = $(this).attr("orderid");
		var isOpen = $(this).attr("isOpen");
		var item_price = '';
		var purchaseTotal = '';
		var purchaseInfo = '';
		var serviceRemark = '';
		var refundPrice = '';
		var expressNum = '';
		var expressUrl = '';
		var pay_back_message = '';
		if(!cartID || !orderID){
			return false;
		}
		if(isOpen == 1){//modify
			item_price = $("#"+cartID+" input:[name='item_price']").val();
			if(item_price && (!isfloat(item_price) || item_price <= 0)){
				alert("单价必须是大于0的数字!");
				return false;
			}
			purchaseInfo = $("#"+cartID+" textarea:[name='purchaseInfo']").val();
			serviceRemark = $("#"+cartID+" textarea:[name='serviceRemark']").val();
			var dataType = 'modify';
		}else if(isOpen == 2){//purchase
			purchaseTotal = $("#"+cartID+" input:[name='purchaseTotal']").val();
			if(purchaseTotal && purchaseTotal >= 0){
				if(purchaseTotal > 0 ){
					if(!isfloat(purchaseTotal)){
						alert("purchaseTotal必须是数字!");
						return false;
					}
				}
			}else{
				alert("purchaseTotal必须是数字!");
				return false;
			}
			var dataType = 'purchase';
		}else if(isOpen == 3){//refund
			refundPrice = $("#"+cartID+" input:[name='refundPrice']").val();
			if(refundPrice && !isfloat(refundPrice)){
				alert("refundPrice必须是数字!");
				return false;
			}
			pay_back_message = $("#"+cartID+" select:[name='pay_back_message']").val();	
			if(!pay_back_message || pay_back_message == 0){
				alert('Refund reason 不能为空!');
				return false;
			}
			var dataType = 'refund';
		}else if(isOpen == 4){//delivery
			expressNum = $("#"+cartID+" input:[name='expressNum']").val();
			expressUrl = $("#"+cartID+" input:[name='expressUrl']").val();	
			var dataType = 'delivery';
		}else{
			alert("请选择要编辑的项目!");
			return false;
		}
			call_tpl('cms','updateItemInfo','backItemInfo()','return',cartID,orderID,item_price,purchaseTotal,purchaseInfo,serviceRemark,refundPrice,expressNum,expressUrl,pay_back_message,dataType,'');
			$(".admin_ajaxjump_box").dialog("open");		
	});
		
});
	function backItemInfo(response){
		if(response){
			//$(".admin_ajaxjump_box").dialog("close");
			location.reload();
		}else{
			$(".admin_ajaxjump_box").dialog("close");
			alert('更新失败');
		}
		
	}
  	 function showShop(shopId){
		 $("#"+shopId).show('normal');
	 }
  	 function hideShop(shopId){
		 $("#"+shopId).hide('normal');
	 }
function openEdit(shopID,type){
	switch(type){
		case "modify":
			$("#"+shopID+" input:[name='item_price']").removeAttr("disabled");
			$("#"+shopID+" input:[name='item_price']").removeClass("bghui2");
			$("#"+shopID+" textarea:[name='purchaseInfo']").removeAttr("disabled");
			$("#"+shopID+" textarea:[name='purchaseInfo']").removeClass("bghui2");
			$("#"+shopID+" textarea:[name='serviceRemark']").removeAttr("disabled");
			$("#"+shopID+" textarea:[name='serviceRemark']").removeClass("bghui2");	
			$("#"+shopID+" .save_modify_item").attr("isOpen","1");			
		break;
		case "purchase":
			$("#"+shopID+" input:[name='purchaseTotal']").removeAttr("disabled");
			$("#"+shopID+" input:[name='purchaseTotal']").removeClass("bghui2");
			$("#"+shopID+" .save_modify_item").attr("isOpen","2");							
		break;
		case "refund":
			$("#"+shopID+" input:[name='refundPrice']").removeAttr("disabled");
			$("#"+shopID+" input:[name='refundPrice']").removeClass("bghui2");	
			$("#"+shopID+" select:[name='pay_back_message']").removeAttr("disabled");
			$("#"+shopID+" select:[name='pay_back_message']").removeClass("bghui2");
			$("#"+shopID+" .save_modify_item").attr("isOpen","3");			
		break;
		case "delivery":
			$("#"+shopID+" input:[name='expressNum']").removeAttr("disabled");
			$("#"+shopID+" input:[name='expressNum']").removeClass("bghui2");	
			$("#"+shopID+" input:[name='expressUrl']").removeAttr("disabled");
			$("#"+shopID+" input:[name='expressUrl']").removeClass("bghui2");
			$("#"+shopID+" .save_modify_item").attr("isOpen","4");		
		break;
		case "address":
			$("#"+shopID+" input").removeAttr("disabled");
			$("#"+shopID+" input").removeClass("bghui2");	
			$("#"+shopID+" select").removeAttr("disabled");
			$("#"+shopID+" select").removeClass("bghui2");	
			$("#saveAddress").attr("isOpen","1");	
		break;				
	}
}
function saveAddressCN(addressId){
	var isOpen = $("#saveAddress").attr("isOpen");
	if(isOpen != 1){
		alert("请选编辑地址!");;
		return false;
	}
	if(addressId){
		var addressCN1 = $("#addressCN1").val();
		var addressCN2 = $("#addressCN2").val();
		var country = $("#country").val();
		var province = $("#province").val();
		var city = $("#city").val();
		if((country != "" && country != "国家") && (province != "" && province != "省份、州") && (city != "" && city != "地级市、县") && addressCN1 != "" && addressCN2 != ""){
			call_tpl('cms','updateAddressCN','backAddressInfo()','return',addressId,addressCN1,addressCN2,country,province,city,'');		
			$(".admin_ajaxjump_box").dialog("open");
		}else{
			alert("地址每一项都不能为空!");
		}
	}
	//alert(addressCN1 + addressCN2 + country + province + city);
}
function backAddressInfo(response){
	if(response){
		//$(".admin_ajaxjump_box").dialog("close");
		location.reload();
	}else{
		$(".admin_ajaxjump_box").dialog("close");
		alert('更新失败');
	}
}
function refundToCustomer(orderID,changeType){
	if(orderID){
		call_tpl('cms','changeOrderStatus','backBatchRefund()','return',orderID,changeType,'one','');
		$(".admin_ajaxjump_box").dialog("open");
	}
}
function backBatchRefund(response){
	if(response){
		location.reload();
	}else{
		$(".admin_ajaxjump_box").dialog("close");
		alert('更新失败');
	}
}