$(function(){
	$(".she_list_box").hover(function(){
		$(".she_list").stop(true,true).show();
	},function(){
		$(".she_list").stop(true,true).hide();
	});
	
	$(".orderName").blur(function(){
		var defaultOrderName = $(this).attr("defaultValue");
		var orderName = $(this).val();
		var orderID = $(this).attr("orderID");
		if(defaultOrderName == orderName || orderName == ''){
			$(this).val(defaultOrderName);
			$(this).css("text-align","center");
			$(this).css("color","#777");			
		}else{
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
			$(this).hide();
			$(this).parent().append(loading_icon);
						
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "json",
					data:{
						action	: "account",
						method	: "orderUpdate",
						orderID	: orderID,
						orderName : orderName
					},
					success : function(result){
						if(result.status == 1){
							//alert('OK');
							$("#"+ orderID).find(".orderNameView").text(orderName).show();
							loading_icon.remove();
						}else{
							//alert('失败');
							$("#"+ orderID).find(".orderName").val(orderName).show();
							loading_icon.remove();
						}
					}

				});			
			
		}
	});
	$(".orderName").focus(function(){
		var defaultOrderName = $(this).attr("defaultValue");
		var orderName = $(this).val();
		if(defaultOrderName == orderName){
			$(this).val('');
			$(this).css("text-align","left");
			$(this).css("color","#333");
		}
	});
	$(".orderNameView").click(function(){
		$(this).hide();
		$(this).next("input").show();
	});
		$("#searchClear").click(function(){
			$("#advSearch_form input:text").each(function(index, element) {
				$(this).val("");
			});
		});

		//高级模式
		$("#search_submit").click(function(){
			var searchOrderNo = $("#advSearch_form input[name='searchOrderNo']").val();
			var fromTime = $("#advSearch_form input[name='fromTime']").val();
			var endTime = $("#advSearch_form input[name='endTime']").val();
			checkEndTime(fromTime,endTime);
			var searchOrderStatus = $("#searchOrderStatus").val();
			var searchServiceStatus = $("#searchServiceStatus").val();
			if(searchOrderNo || (searchOrderStatus && searchOrderStatus != 0) || (searchServiceStatus && searchServiceStatus != 0) || (fromTime && endTime && checkEndTime(fromTime,endTime))){
				$("#advSearch_form").submit();
			}
		});
		//快速模式
		$(".orderAdvSearchNav ul>li").click(function(){
			var fastVal = $(this).attr("statusValue");
			$("#fastOrderStatus").val(fastVal);
			$(".orderAdvSearchNav ul>li").each(function(index, element) {
                $(this).removeClass("nan");
            });
			$(this).addClass("nan");
			$("#fastSearch_form").submit();
		});
		$("#allOrderSelect").click(function(){
			if($(this).val() == 0){
				$("input:[name='orderSelect']").each(function(index, element) {
                    $(this).attr("checked","checked");
                });
				$(this).val(1);
			}else{
				$("input:[name='orderSelect']").each(function(index, element) {
                    $(this).removeAttr("checked");
                });
				$(this).val(0);
			}
		});
});

	function batchDeleteOrder(changeType,dataType){
		var orderIDs = getOrdersID();
		if(orderIDs){
			if(changeType == 'trash'){
				if(confirm("Do you want to order batch will be moved to the trash can?")){
					var orderArr = orderIDs.split(",");
					for(var i=0;i<orderArr.length;i++){
						$("#"+orderArr[i]).hide("5000");
					}
					call_tpl('shop','changeOrderStatus','backBatchDelete()','return',orderIDs,changeType,dataType,'');
				}
			}else if(changeType == 'delete'){
				if(confirm("Do you want to delete order batch?")){
					var orderArr = orderIDs.split(",");
					for(var i=0;i<orderArr.length;i++){
						$("#"+orderArr[i]).hide("5000");
					}
					call_tpl('shop','changeOrderStatus','backBatchDelete()','return',orderIDs,changeType,dataType,'');
				}				
			}
		}else{
			alert('please select order');
		}
	}
	function backBatchDelete(response){
		if(response){
			if(response.indexOf(',')){
				var orderArr = response.split(",");
				for(var i=0;i<orderArr.length;i++){
					$("#"+orderArr[i]).remove();
				}
			}else{
				$("#"+response).remove();
			}
		}
	}
	function deleteOrder(orderID,changeType,dataType){
		
		if(orderID && changeType && dataType){
			switch(changeType){
				case 'delete':
					if(confirm("Are you sure you want to delete this order?")){
						$("#"+orderID).hide("5000");
						call_tpl('shop','changeOrderStatus','backDataDeleteOrder()','return',orderID,changeType,dataType,'');
					}
				break;
				case 'trash':
					if(confirm("Are you sure you want this order will be moved to the trash can?")){
						$("#"+orderID).hide("5000");
						call_tpl('shop','changeOrderStatus','backDataDeleteOrder()','return',orderID,changeType,dataType,'');
					}
				break;
				case 'cancel':
					if(confirm("Are you sure you want to cancel this order?")){
						$("#"+orderID).hide("5000");
						call_tpl('shop','changeOrderStatus','backDataDeleteOrder()','return',orderID,changeType,dataType,'');
					}
				break;	
				case 'confirm':
						call_tpl('shop','changeOrderStatus','backDataDeleteOrder()','return',orderID,changeType,dataType,'');
				break;											
			}
		}
	}
	function backDataDeleteOrder(response){
		if(response){
			$("#"+response).remove();
		}
	}
	function confirmOrder(o,orderID,changeType,dataType){
			switch(changeType){
				case 'confirm':
					$(o).replaceWith('<img class="loading_sm" src="../skin/images/loading_sm.gif" />');
					call_tpl('shop','changeOrderStatus','backDataConfirmOrder()','return',orderID,changeType,dataType,'');
				break;											
			}		
	}
	function backDataConfirmOrder(response){
		if(response){
			$("#"+response).find(".loading_sm").replaceWith('<div class="bghui confirmed">Confirmed</div>');
		}
	}
	function getOrdersID(){
		var check = $("input:[name='orderSelect']:checked");
		var selectOrderItems;
		check.each(function(i){
			//alert(selectgoodsitems);
			if(selectOrderItems == undefined){
				selectOrderItems = $(this).val();
			}else{
				selectOrderItems += ','+$(this).val();
			}
		})
		return selectOrderItems;
	}