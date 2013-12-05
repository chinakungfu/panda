// JavaScript Document
  	 function showShop(shopId){
		 $("#"+shopId).show('normal');
	 }
  	 function hideShop(shopId){
		 $("#"+shopId).hide('normal');
	 }

	$(function(){
		/*****普通商品*****/
		$(".numtextBag").blur(function(){
			var num =$(this).val();
			if(isNaN(num)){
				num=1;
				$(this).val(num);
			}else{
				if(!isNum(num) || num < 1){
					num=1;
					$(this).val(num);
				}
			}
			/*
			var kk = $(this).parent().prev().children(".itemPrice").children("span#item_price").text();
			var hh = kk.replace(',','');
			var total=setCurrency(hh*num);
			$(this).parent().next().children(".itemPrice").children("span#total_price").text(total);		
			*/
		});
		
		var cartIdStr = itemCart();
		$("#submit_cart > input:[name='goodsitem']").val(cartIdStr);
		
/*		$(".itemModifyPriceNo").click(function (){
			$(this).html('Price Modify Requested');
			$(this).addClass("itemModifyPriceYes");
			$(this).removeClass("itemModifyPriceNo");
		});*/
	})
	/***普通商品******/
	function changeItemQTY(o,value,cartId,goodsShopId,itemPrice,userId,cartType,cartIdStr)
	{
			if(isNaN(value)){
				alert("Please enter the Numbers");
				value=1;
				$(o).val(value);
			}else{
				if(!isNum(value) || value < 1){
					value=1;
					$(o).val(value);
					alert("Please enter whole number");
				}
			}
		$(o).parent().prev().prev().prev().prev().children(".selectCheckBox").attr("checked","checked");
		var cartIdStr = itemCart();
		$("#submit_cart > input:[name='goodsitem']").val(cartIdStr);
		call_tpl('shop','changeItemQTY','backDataItemQTY()','return',cartId,value,userId,cartType,cartIdStr,goodsShopId,itemPrice,'');
	}
	function backDataItemQTY(response)
	{
		if(response){
			var responseArr = response.split("-");
			var cartID = responseArr[0];
			var goodsShopId = responseArr[1];
			//商品总价
			var totalPrice = document.getElementById(cartID+"_total_price");
			totalPrice.innerHTML = responseArr[2];		
			//店铺总价
			var sellerTotalPrice = document.getElementById(goodsShopId+"_sellerTotalPrice");
			sellerTotalPrice.innerHTML = responseArr[3];
			//店铺运费
			var sellerFreightPrice = document.getElementById(goodsShopId+"_sellerFreightPrice");
			sellerFreightPrice.innerHTML = responseArr[4];		
			//所有商品总价
			var sellerSubTotalPrice = document.getElementById("sellerSubTotalPrice");
			sellerSubTotalPrice.innerHTML = responseArr[5];
			//所有商品总服务费
			var serviceFeePrice = document.getElementById("serviceFeePrice");
			serviceFeePrice.innerHTML = responseArr[6];
			//所有商品总运费
			var sellerSubFreightPrice = document.getElementById("sellerSubFreightPrice");
			sellerSubFreightPrice.innerHTML = responseArr[7];
			//所有商品总总价钱
			var sellerAllTotalPrice = document.getElementById("sellerAllTotalPrice");
			sellerAllTotalPrice.innerHTML = responseArr[8];	
			//所有商品总数
			var bagItemTatal = document.getElementById("bagItemTatal");
			bagItemTatal.innerHTML = responseArr[9];		
		}else{
			alert('error');
		}
	}
	function addItemQTY(type,o,cartId,goodsShopId,itemPrice,userId,cartType){
		if(type == "jia"){
			var value = $(o).prev().val();
			if(isNaN(value)){
				value =1;
				$(o).prev().val(value);
			}else{
				if(!isNum(value) || value < 1){
					value=1;
					$(o).prev().val(value);
				}else{
					value ++;
					$(o).prev().val(value);
				}
			}			
		}else if(type == "jian"){
			var value = $(o).next().val();
			if(isNaN(value)){
				value =1;
				$(o).next().val(value);
			}else{
				if(!isNum(value) || value < 2){
					value=1;
					$(o).next().val(value);
				}else{
					value --;
					$(o).next().val(value);
				}
			}	
		}
		$(o).parent().prev().prev().prev().prev().children(".selectCheckBox").attr("checked","checked");
		var cartIdStr = itemCart();
		$("#submit_cart > input:[name='goodsitem']").val(cartIdStr);
		call_tpl('shop','changeItemQTY','backDataItemQTY()','return',cartId,value,userId,cartType,cartIdStr,goodsShopId,itemPrice,'');	
	}
	
	
	 function changeModify(o,cartId,userId,dataType){
		 var requestVal = $(o).attr("requestVal");
		 if(requestVal == '1'){
			$(o).html('Price Modify Requested');
			$(o).addClass("itemModifyPriceYes");
			$(o).removeClass("itemModifyPriceNo");
			$(o).attr("requestVal","0");
		 }else{
			$(o).html('Request Price Modify');
			$(o).addClass("itemModifyPriceNo");
			$(o).removeClass("itemModifyPriceYes");
			$(o).attr("requestVal","1"); 
		 }
		changeItemNotes(requestVal,cartId,userId,dataType);	 
	 }	
	
	function changeItemNotes(value,cartId,userId,dataType){
		var value = $.trim(value);
		if(value != ''){
			call_tpl('shop','changeItemNotes','backItemNotes()','return',value,cartId,userId,dataType,'');			
		}
	}
	function backItemNotes(response){
		if(response){
			$("#result").html(response);
		}
	}	
	function changeProps(o,cartId,userId,dataType){
		var kk = $(o).val();
		var value = '';
		$("."+cartId+"_props").each(function(index, element) {
			var hh = $(this).attr("prop_name");	
			var jj = $(this).val();	
			if(value == ''){
				value += hh+":"+jj;
			}else{
				value += "|"+hh+":"+jj;
			}
        });
		call_tpl('shop','changeItemNotes','backItemNotes()','return',value,cartId,userId,dataType,'');		
	}	
	function deleteItem(o,cartId,userId,cartType,goodsShopId,itemPrice,dataType){
		var cont = $("#"+goodsShopId).children("td").children("table:visible").size();
		if(cont > 1){
			$("#"+cartId).hide("normal");
		}else{
			$("#all_"+goodsShopId).hide("normal");
		}
		//$("#all_"+goodsShopId).hide();
		//alert(cont);
		$(o).parent().parent().prev().prev().prev().prev().children("td:eq(0)").children(".selectCheckBox").removeAttr("checked");
		var cartIdStr = itemCart();
		$("#submit_cart > input:[name='goodsitem']").val(cartIdStr);
		if(!cartIdStr){
			//所有商品总价
			var sellerSubTotalPrice = document.getElementById("sellerSubTotalPrice");
			sellerSubTotalPrice.innerHTML = setCurrency(0);
			//所有商品总服务费
			var serviceFeePrice = document.getElementById("serviceFeePrice");
			serviceFeePrice.innerHTML = setCurrency(0);
			//所有商品总运费
			var sellerSubFreightPrice = document.getElementById("sellerSubFreightPrice");
			sellerSubFreightPrice.innerHTML = setCurrency(0);
			//所有商品总总价钱
			var sellerAllTotalPrice = document.getElementById("sellerAllTotalPrice");
			sellerAllTotalPrice.innerHTML = setCurrency(0);		
			//商品总数
			var bagItemTatal = document.getElementById("bagItemTatal");
			bagItemTatal.innerHTML = 0;					
		}		
		call_tpl('shop','cancelItemQTY','backDataCancelItem()','return',cartId,userId,cartType,cartIdStr,goodsShopId,itemPrice,dataType,'');
		
	}

	function cancelItemQTY(o,cartId,userId,cartType,cartIdStr)
	{
		var cartIdStr = itemCart();
		$("#submit_cart > input:[name='goodsitem']").val(cartIdStr);
		if(cartIdStr){
			var value = $(o).parent().next().next().children().children(".numtextBag").val();
			call_tpl('shop','cancelItemQTY','backDataCancelItem()','return',cartId,value,userId,cartType,cartIdStr,'');
		}else{
			var subTotalPriceObj = document.getElementById("subTotalPrice");
			var totalItemsObj = document.getElementById("subTotalFright");
			totalItemsObj.innerHTML ="0.00";
			subTotalPriceObj.innerHTML = "0.00";
		}

	}


	function backDataCancelItem(response)
	{
		if(response){
			var responseArr = response.split("-");
			var cartID = responseArr[0];
			var goodsShopId = responseArr[1];
			//商品总价
			var totalPrice = document.getElementById(cartID+"_total_price");
			totalPrice.innerHTML = responseArr[2];			
			//店铺总价
			var sellerTotalPrice = document.getElementById(goodsShopId+"_sellerTotalPrice");
			sellerTotalPrice.innerHTML = responseArr[3];
			//店铺运费
			var sellerFreightPrice = document.getElementById(goodsShopId+"_sellerFreightPrice");
			sellerFreightPrice.innerHTML = responseArr[4];		
			//所有商品总价
			var sellerSubTotalPrice = document.getElementById("sellerSubTotalPrice");
			sellerSubTotalPrice.innerHTML = responseArr[5];
			//所有商品总服务费
			var serviceFeePrice = document.getElementById("serviceFeePrice");
			serviceFeePrice.innerHTML = responseArr[6];
			//所有商品总运费
			var sellerSubFreightPrice = document.getElementById("sellerSubFreightPrice");
			sellerSubFreightPrice.innerHTML = responseArr[7];
			//所有商品总总价钱
			var sellerAllTotalPrice = document.getElementById("sellerAllTotalPrice");
			sellerAllTotalPrice.innerHTML = responseArr[8];			
			//所有商品总数
			var bagItemTatal = document.getElementById("bagItemTatal");
			bagItemTatal.innerHTML = responseArr[9];
		}else{
			location.reload();
		}
	}
	
	function submitCart(){
		var submitcartids = $("#submit_cart > input:[name='goodsitem']").val();
		if(!submitcartids || submitcartids == ''){
			alert("Please select an item!");
		}else{
			$("#submit_cart").submit();
		}
	}
	function itemCart(){
		var check = $("input:[name='selectgoodsitem']:checked");
		var selectgoodsitems;
		check.each(function(i){
			//alert(selectgoodsitems);
			if(selectgoodsitems == undefined){
				selectgoodsitems = $(this).val();
			}else{
				selectgoodsitems += ','+$(this).val();
			}
		})
		return selectgoodsitems;
	}

	/**********end***************/
	
	
	/******团购商品***************/

/*	function changeGroupBuyItemQTY(o,value,cartId,userId,cartType,cartIdStr)
	{
		if(isNaN(value)){
			alert("Please enter the Numbers");
			value=1;
			$(o).val(value);
		}else{
			if(!isNum(value) || value < 1){
				value=1;
				$(o).val(value);
				alert("Please enter whole number");
			}
		}
		$(o).parent().parent().prev().prev().children(".selectGroupCarts").attr("checked","checked");
		var cartIdStr = itemGroupCart();
		$("#submit_group_cart > input:[name='group_carts']").val(cartIdStr);
		call_tpl('shop','changeItemQTY','backGroupBuyDataItemQTY()','return',cartId,value,userId,cartType,cartIdStr,'');
	}
	function backGroupBuyDataItemQTY(response)
	{
		var responseArr = response.split("-");
		var GroupBuySubTotalPrice = document.getElementById("GroupBuySubTotalPrice");
		var totalItemsObj = document.getElementById("subGroupTotalFright");
		totalItemsObj.innerHTML =setCurrency(responseArr[0]);
		GroupBuySubTotalPrice.innerHTML = setCurrency(responseArr[1]);
	}
	function cancelGroupItemQTY(o,cartId,userId,cartType,cartIdStr)
	{
		var cartIdStr = itemGroupCart();
		$("#submit_group_cart > input:[name='group_carts']").val(cartIdStr);
		if(cartIdStr){
			var value = $(o).parent().next().next().children().children(".numtextGroupBag").val();
			call_tpl('shop','cancelItemQTY','backDataCancelGroupItem()','return',cartId,value,userId,cartType,cartIdStr,'');
		}else{
			var GroupBuySubTotalPrice = document.getElementById("GroupBuySubTotalPrice");
			var totalItemsObj = document.getElementById("subGroupTotalFright");
			totalItemsObj.innerHTML ="0.00";
			GroupBuySubTotalPrice.innerHTML = "0.00";
		}

	}
	function backDataCancelGroupItem(response)
	{
		var responseArr = response.split("-");
		var GroupBuySubTotalPrice = document.getElementById("GroupBuySubTotalPrice");
		var totalItemsObj = document.getElementById("subGroupTotalFright");
		totalItemsObj.innerHTML =setCurrency(responseArr[0]);
		GroupBuySubTotalPrice.innerHTML = setCurrency(responseArr[1]);
	}

	function submitGroupCart(){
		var submitcartids = $("#submit_group_cart > input:[name='group_carts']").val();
		if(!submitcartids || submitcartids == ''){
			alert("请选择一件团购商品!");
		}else{
			$("#submit_group_cart").submit();
		}
	}
	function itemGroupCart(){
		var check = $("input:[name='selectGroupCarts']:checked");
		var selectGroupCarts;
		check.each(function(i){
			//alert(selectgoodsitems);
			if(selectGroupCarts == undefined){
				selectGroupCarts = $(this).val();
			}else{
				selectGroupCarts += ','+$(this).val();
			}
		})
		return selectGroupCarts;
	}*/

	/********end****************/


