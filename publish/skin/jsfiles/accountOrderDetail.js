// JavaScript Document
	$(function(){
		$("#showOrderItemCon").click(function(){
			$("#orderItemCon").show();
		});
		$("#hideOrderItemCon").click(function(){
			$("#orderItemCon").hide();
		});	
		$(".searchHide").click(function(){
			$("#orderAdvSearch").hide();
		});
		$(".searchShow").click(function(){
			$("#orderAdvSearch").show();
		});		
			
		$("#searchClear").click(function(){
			$("#advSearch_form input:text").each(function(index, element) {
				$(this).val("");
			});
		});
		$(".refundInfo").hover(
			function(){
				$(this).prev(".refundReason").show();
			},
			function(){
				$(this).prev(".refundReason").hide();
			}
		);
		//正常模式
		$("#searchMode").change(function(){
			if($(this).val() > 0){
				$("#normalOrderSearch").submit();
			}
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
		//退货效果
		$(".returnItems_box").dialog({
			autoOpen: false,
			show: { effect: 'drop', direction: "up" },
			hide: { effect: 'drop', direction: "up" },
			width: 810,
			modal: true
		});

				

		$(".returnItems_box_close").click(function(){
			$(".returnItems_box").dialog( "close" );
		});
		
		
		$("#uploadPhotos").click(function(){
			var fileName = $(this).prev("input").val();
			var photoNum = $("#upload_file").attr("photoNum");
			//var maxFileSize = $(this).prev().prev("input").val();
			if(fileName && checkFile(fileName)){
				if(photoNum <= 3){
					ajaxFileUpload();
				}else{
					alert("最多只能传三张!");
				}				
			}else{
				alert("请选择正确的图片文件!");
			}
		});
		/*******提交表单***********/
		$(".returnItems_box_submit").click(function(){
			//取得名项参数
			var instructions = $("#instructions").val();
			
			var returnCartID = $("#returnCartID").val();
			var returnOrderID = $("#returnOrderID").val();	
			if(instructions == ''){
				alert('请填写说明?');
				return false;
			}			
			var lengNum = $('#returnPhotoShow').children(".returnimgshow").length;
			if(lengNum < 1){
				alert('请上传照片!');
				return false;				
			}else{
				imgsrcArr = '';
				$('#returnPhotoShow').children(".returnimgshow").each(function(index, element) {
                    var imgsrc = $(this).children("img").attr("src");
					if(imgsrcArr == ''){
						imgsrcArr += imgsrc;
					}else{
						imgsrcArr += "|"+imgsrc;
					}
                });
				$("#returnPhoto").val(imgsrcArr);
			}
			var returnPhoto = $("#returnPhoto").val();
			if(returnPhoto == ''){
				alert('请上传照片!');
				return false;
			}
			if(returnCartID && returnOrderID){
				$("#return_form").submit();
			}
		});
	});

	function returnItems(cartID,orderID,orderNO){
		$(".returnItems_box").dialog("open");
		$("#returnItem_ID").text(cartID);
		$("#returnCartID").val(cartID);
		$("#returnOrderID").val(orderID);
	}
	 function showShop(shopId){
		 $("#"+shopId).show('normal');
	 }
	 function hideShop(shopId){
		 $("#"+shopId).hide('normal');
	 }
	 //删除商品或者订单
	function removeOrderQTY(cartId,cartType,cartIdStr,orderId){

		var cartids = ","+cartId;
		var s = cartIdStr.indexOf(cartids);
		if(s < 0){
			var cartids2 = cartId+",";
			var newcartIdStr  = cartIdStr.replace(cartids2,"");
			//alert(newcartIdStr);
		}else{
			var newcartIdStr  = cartIdStr.replace(cartids,"");
			//alert(newcartIdStr);
		}
		//alert(cartId+'-'+cartType+'-'+cartIdStr+'-'+orderId);
		call_tpl('shop','changeRemoveQTY','backDataRemoveQTY()','return',cartId,cartType,newcartIdStr,orderId,'');

	}
	function backDataRemoveQTY(response)
	{
		if(response){
			window.location.reload();
		}else{
			alert('删除失败!');
		}	
	}	 
	function changeItemStatus(o,cartId,dataType){
		if(cartId){
			$(o).replaceWith('<img class="loading_sm" src="../skin/images/loading_sm.gif" />');
			call_tpl('shop','changeItemStatus','backDataItemStatus()','return',cartId,dataType,'');
		}

	}
	function backDataItemStatus(response){
		if(response){
			$("#"+response).find(".loading_sm").replaceWith('<div class="bghui confirmed">Confirmed</div>');
		}
	}	 
	function checkFile(val1, val2){
		//获得文件后缀 
		val1 = val1.substring(val1.lastIndexOf("."), val1.length) 
		val1 = val1.toLowerCase(); 
		if (typeof val2 !== 'string' || val2 === "") { val2 = "gif|jpg|jpeg|png|bmp"; } 
		return new RegExp("\.(" + val2 + ")$").test(val1); 		
	}
	
	var str = '';
	function ajaxFileUpload(){ 
	
		$("#msg").ajaxStart(function(){
		   $(this).show();
		});
		var photoNum = $("#upload_file").attr("photoNum");
		/*
		.ajaxComplete(function(){
		   $(this).hide();
		});
		*/
		$.ajaxFileUpload(
		{
		   url:'/publish/index.php',  //需要链接到服务器地址  
		   secureuri:false,  
		   fileElementId:'upload_file',  
		   dataType: 'text',
		   data:{action:'account', method:'uploadPhotos',photoNum:photoNum},
		   success: function(data){
				  if(data != 'error'){
					  $('#returnPhotoShow').append(data); 
					  var lengNum = $('#returnPhotoShow').children(".returnimgshow").length;
					  /*var imgsrc = $("#img"+lengNum).attr("src");*/
					  $("#returnPhoto"+lengNum).val(imgsrc);
					  $("#upload_file").attr("photoNum",lengNum + 1);    
				  }else{
					  $('#msg').html("<span style='color:red'>上传失败</span>");
				  }
			   }
		   }
		);
		return false;
	}	

	function delimg(o,num){
		/*$("#returnPhoto"+num).val('');*/
		var lengNum = $("#upload_file").attr("photoNum");
		if(lengNum > 1){
			$("#upload_file").attr("photoNum",lengNum - 1); 
		}
		$(o).parents(".returnimgshow").remove();
	
	}	