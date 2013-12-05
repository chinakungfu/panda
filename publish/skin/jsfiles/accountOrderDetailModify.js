// JavaScript Document
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
	});	
})
	/***普通商品******/
	function changeItemQTY(o,value,cartId,goodsShopId,itemPrice,userId,cartType,orderID)
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
		call_tpl('shop','changeOrderQTY','backDataItemQTY()','return',cartId,value,userId,cartType,goodsShopId,orderID,'');
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
			//税价
			var orderTax = document.getElementById("orderTax");
			orderTax.innerHTML = responseArr[9];			
			//积分
			var orderCredit = document.getElementById("orderCredit");
			orderCredit.innerHTML = responseArr[10];		
		}else{
			alert('error');
		}
	}
	function addItemQTY(type,o,cartId,goodsShopId,itemPrice,userId,cartType,orderID){
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
		call_tpl('shop','changeOrderQTY','backDataItemQTY()','return',cartId,value,userId,cartType,goodsShopId,orderID,'');
	}
	
	
	function deleteItem(o,goodsShopId){
		var hreflink = $(o).attr("address");

		var shopCount = $("#orderItemCon").find(".goodsShop").size();
		var itemCount = $("#"+goodsShopId).children("td").children("table:visible").size();
		if(shopCount == 1 && itemCount == 1){
			if(confirm('This is the last goods do you want to delete this order?')){
				window.location.href=hreflink;
			}
		}else{
			if(confirm('Are you sure you want to delete this product?')){
				window.location.href=hreflink;
			}
		}
		//$("#all_"+goodsShopId).hide();
		//alert(cont);
/*		$(o).parent().parent().prev().prev().prev().prev().children("td:eq(0)").children(".selectCheckBox").removeAttr("checked");
		var cartIdStr = itemCart();
		$("#submit_cart > input:[name='goodsitem']").val(cartIdStr);*/
/*		if(!cartIdStr){
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
		}	*/	
		//call_tpl('shop','cancelItemQTY','backDataCancelItem()','return',cartId,userId,cartType,cartIdStr,goodsShopId,itemPrice,dataType,'');
		
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
	
	/**********end***************/