// JavaScript Document
$(function(){
	$(".she_list_box").hover(function(){
		$(".she_list").stop(true,true).show();
	},function(){
		$(".she_list").stop(true,true).hide();
	});

	$("#searchClear").click(function(){
		$("#advSearch_form input:text").each(function(index, element) {
			$(this).val("");
		});
	});
	$(".itemShopHide").click(function(){
		$("#advSearch_form").hide("normal");
	});
	$(".itemShopShow").click(function(){
		$("#advSearch_form").show("normal");
	});	
	//高级模式
	$("#search_submit").click(function(){
		var searchOrderNo = $("#advSearch_form input[name='searchOrderNo']").val();
		var fromTime = $("#advSearch_form input[name='fromTime']").val();
		var endTime = $("#advSearch_form input[name='endTime']").val();
		checkEndTime(fromTime,endTime);
		var submitFromTime = $("#advSearch_form input[name='submitFromTime']").val();
		var submitEndTime = $("#advSearch_form input[name='submitEndTime']").val();
		checkEndTime(submitFromTime,submitEndTime);				
		var searchOrderStatus = $("#searchOrderStatus").val();
		var searchServiceStatus = $("#searchServiceStatus").val();
		var searchOrderPayment = $("#searchOrderPayment").val();
		
		var searchOrderLocation = $("#searchOrderLocation").val();
		var searchOrderDepartment = $("#searchOrderDepartment").val();
		var searchOrderOperator = $("#searchOrderOperator").val();			
		
		if(searchOrderNo || searchOrderLocation || searchOrderOperator || (searchOrderStatus && searchOrderStatus != 0) || (searchOrderPayment && searchOrderPayment != 0) || (searchServiceStatus && searchServiceStatus != 0) || (fromTime && endTime && checkEndTime(fromTime,endTime)) || (submitFromTime && submitEndTime && checkEndTime(submitFromTime,submitEndTime))){
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
	
	$("#allStatus").click(function(){
		var fastVal = 100;
		$("#fastOrderStatus").val(fastVal);
		$(".orderAdvSearchNav ul>li").each(function(index, element) {
			$(this).removeClass("nan");
		});
		$("#fastSearch_form").submit();
	});
	
	$("#allOrderSelect").click(function(){
		if($(this).val() == 0){
			$(".orderSelect").each(function(index, element) {
				$(this).attr("checked","checked");
			});
			$(this).val(1);
		}else{
			$(".orderSelect").each(function(index, element) {
				$(this).removeAttr("checked");
			});
			$(this).val(0);
		}
	});
});
	//批量移到垃圾桶
	function batchDeleteOrder(changeType,dataType){
		var orderIDs = getOrdersID();
		//alert(orderIDs);
		if(orderIDs){
			if(changeType == 'trash'){
				if(confirm("Do you want to order batch will be moved to the trash can?")){			
					var orderArr = orderIDs.split(",");
					for(var i=0;i<orderArr.length;i++){
						$("#"+orderArr[i]).hide("normal");
					}
					//alert(changeType+dataType);
					call_tpl('cms','changeOrderStatus','backBatchDelete()','return',orderIDs,changeType,dataType,'');
					$(".admin_ajaxjump_box").dialog("open");
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
			$(".admin_ajaxjump_box").dialog("close");
		}else{
			alert("删除失败!");
			$(".admin_ajaxjump_box").dialog("close");
		}
	}
	//批量发邮件
	function batchSendMail(sendType,dataType){
		var orderIDs = getOrdersID();
		if(orderIDs){
			switch(sendType){
				case 'payment':
					if(confirm("Do you send payment reminder?")){
						call_tpl('cms','changeOrderStatus','backBatchSendMail()','return',orderIDs,sendType,dataType,'');
					}
				break;
				case 'confirmation':
					if(confirm("Do you send confirmation reminder?")){
						call_tpl('cms','changeOrderStatus','backBatchSendMail()','return',orderIDs,sendType,dataType,'');
					}				
				break;
				case 'refund':
					if(confirm("Do you send refund notice?")){
						call_tpl('cms','changeOrderStatus','backBatchSendMail()','return',orderIDs,sendType,dataType,'');
					}				
				break;
			}
			//alert(changeType+dataType);
			
		}else{
			alert('please select order');
		}
	}
	function backBatchSendMail(response){
		if(response){
			$(".orderSelect").each(function(index, element) {
				$(this).removeAttr("checked");
			});
			alert("发送成功!");
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
function checkEndTime(fromTime,endTime){  
 
	var start=new Date(fromTime.replace("-", "/").replace("-", "/"));  
	
	var end=new Date(endTime.replace("-", "/").replace("-", "/"));  
	
	if(end < start){  
		return false;  
	}  
	return true;  
}  