// JavaScript Document
$(function(){
	//添加新地址
	$("#newAddress").click(function(){
		$("#addressList").hide("normal");
		$("#dataTypeInput").val("insert");
		$("#addressCreate").show("normal");
		$("#cartToConfirmBtn").hide();
		$(this).hide();
		$(".addresstab").find(":text").val("");
	});
	//取消编辑
	$("#addressCancel").click(function(){
		$("#addressList").show();
		$("#cartToConfirmBtn").show();
		$("#addressCreate").hide();	
		$("#cartTwoContent").show();
		$("#newAddress").show();			
	});
	//是否选中默认
	$("#isdefaultCheckBox").click(function (){
		if($(this).val() == 0){
			$(this).attr("checked","checked");
			$(this).val("1");
		}else{
		   $(this).removeAttr("checked");
		   $(this).val("0");
		}
	});
	//第一步到第二步
	$("#cartToAddress").click(function(){
		$(this).hide();
		$("#cartTwoTitleAll").show();
		$("#cartTwoContentAll").show();		
	});
	//第二步到第三步
	$("#cartToConfirm").click(function(){

		//获取被选中的地址数据
		var addressID = $(".isSelect").attr("id");
		if(addressID){
			$("#cartTwoContent").hide();
			$("#newAddress").hide();
			$("#cartThreeContent").show();
			$("#addressBackEdit").show();			
			var addressArr = $("#"+ addressID +"_addressDataArr").val();
			var addressData = addressArr.split("|");//获得数据
			//附加数据到第三步中的控件
			$("#cartThreeAddressId").val(addressID);
			$("#cartThreeFirstName").text(addressData[2] + ' ' + addressData[3]);
			$("#cartThreeEmail").text(addressData[12]);
			$("#cartThreeTelephone").text(addressData[10] + ' ' + addressData[11]);
			$("#cartThreeAddress1").text(addressData[4]);
			$("#cartThreeAddress2").text(addressData[5]);
			$("#cartThreeCity").text(addressData[6] + ' ' + addressData[7] + ' ' + addressData[8]);
			if(addressData[14]){
				$("#addressCN").show();
				$("#cartThreeCNAddress1").text(addressData[14]);
				$("#cartThreeCNAddress2").text(addressData[15]);
				$("#cartThreeCNCity").text(addressData[18] + '   ' + addressData[17] + '   ' + addressData[16]);
				
			}
		}else{
			alert("Please select an address!");
		}
	});	
	//再次编辑地址
	$("#addressBackEdit").click(function(){
		$("#cartTwoContent").show();
		$("#cartThreeContent").hide();
		$(this).hide();
		$("#newAddress").show();
	});
	//提交订单
	$("#cartThree_submit").click(function(){
		if($("#cartIdStr").val() == '' || $("#cartThreeAddressId").val() == ''){
			alert("Please edit shopping cart again!");
			return false;
		}else{
			var invoiceTitle = $(".cartThreeInvoiceTitle input:[name='invoiceTitle']").val();
			var defaultTitle = $(".cartThreeInvoiceTitle input:[name='invoiceTitle']").attr("defaultValue");
			var invoiceNum = $(".cartThreeInvoiceTitle input:[name='invoiceNum']").val();
			var defaultNum = $(".cartThreeInvoiceTitle input:[name='invoiceNum']").attr("defaultValue");
			if(invoiceTitle == defaultTitle){$(".cartThreeInvoiceTitle input:[name='invoiceTitle']").val('')};
			if(invoiceNum == defaultNum){$(".cartThreeInvoiceTitle input:[name='invoiceNum']").val('')};
			$("#confirmCart").submit();
		}
	});
	//发票
	$(".order_invoice").click(function(){
		if($(this).val() == 1){
			$(".invoiceinput").show();
		}else{
			$(".invoiceinput").hide();
		}
	});
})

//选择地址
function address_booking_select(o){
	$(".address_booking_table").each(function(index, element) {
		$(this).removeClass("isSelect");	
		$(this).addClass("noSelect");	
	});
	$(o).removeClass("noSelect");	
	$(o).addClass("isSelect");
}
//设置默认地址
function setDefaultAddress(addressID,userID){
	var fromData = "addressId=" +addressID +"&user_id=" +userID+"&type=setDufault";	
	$(".addressDefault").each(function(index, element) {
        $(this).next().removeClass("hide");
		$(this).addClass("hide");
    });
	$("#" + addressID +" .addressSetDefault").addClass("hide");
	$("#" + addressID +" .addressSetDefault").prev().removeClass("hide");
	call_tpl('shop','addAddress','','return',fromData,'');
}
//编辑地址
function addressEdit(o){
	var addressID = $(o).parent().parent().parent().parent().attr("id");
	var addressArr = $("#"+addressID + "_addressDataArr").val();
	var addressData = addressArr.split("|");//获得数据
	//隐藏地址列表
	$("#addressList").hide("slow");
	$("#cartToConfirmBtn").hide();
	//显示原有数据
	$(".addressRadio input").each(function(index, element) {
        if($(this).val() == addressData[1]){
			$(this).attr("checked","checked");
		}
    });
	$("#firstName").val(addressData[2]);
	$("#lastName").val(addressData[3]);
	$("#address1").val(addressData[4]);
	$("#address2").val(addressData[5]);
	$("#city").val(addressData[6]);
	$("#province").val(addressData[7]);	
	$("#country").val(addressData[8]);
	$("#zipcode").val(addressData[9]);
	
	$("#phone1").val(addressData[10]);
	$("#phone2").val(addressData[11]);	
	$("#email").val(addressData[12]);
	

	$("#addressIdInput").val(addressID);
	//是否是默认
	var isdufault = addressData[13];
	if(isdufault != 0){
		$("#isdefaultCheckBox").attr("checked","checked");
		$("#isdefaultCheckBox").val(1);
	}else{
		$("#isdefaultCheckBox").removeAttr("checked");
		$("#isdefaultCheckBox").val(0);		
	}
	
	$("#dataTypeInput").val('update');
	//显示创建地址页面
	$("#addressCreate").show();
}
	//提交添加地址
	function submitAddress(){
		
		var validator = $.formValidator.pageIsValid();
		var fromData = $("#addressForm").serialize();
		if(validator){
			if($("#dataTypeInput").val() == 'insert'){
				call_tpl('shop','addAddress','backAddAddress()','return',fromData,'');	
			}else if($("#dataTypeInput").val() == 'update'){
				call_tpl('shop','addAddress','backUpdateAddress()','return',fromData,'');
			}
		}
	}
	function backAddAddress(response){
		
		if(response['addressId']){
			var resultHtml = '';
			resultHtml += '<table onclick="address_booking_select(this);" id="' + response['addressId'] +'" class="address_booking_table isSelect">';
            resultHtml += '<tr><td class="addressTitle">'+response["firstName"]+ ' ' + response["lastName"]+'</td></tr>';
            resultHtml += '<tr><td>'+response["telephone"]+' '+response["cellphone"]+'</td></tr>';
			resultHtml += '<tr><td>'+response["address1"]+' '+response["address2"]+'</td></tr>';
			resultHtml += '<tr><td>'+response["city"]+' '+response["province"]+' '+response["country"]+'</td></tr>';
			resultHtml += '<tr><td align="right">';
			if(response["isdefault"]){
				resultHtml += '<span class="addressDefault">Default</span>';
				resultHtml += '<span class="addressSetDefault hide" onclick="setDefaultAddress(\''+ response['addressId'] +'\',\''+ response['userId'] +'\');">Set Default</span>';			
			}else{
				resultHtml += '<span class="addressDefault hide">Default</span>';
				resultHtml += '<span class="addressSetDefault" onclick="setDefaultAddress(\''+ response['addressId'] +'\',\''+ response['userId'] +'\');">Set Default</span>';
			}
			resultHtml += '<span class="addressEdit" onclick="addressEdit(this);">Edit</span></td></tr>';
			resultHtml += '<input type="hidden" value="' + response['addressListArr'] + '" id="'+response['addressId']+'_addressDataArr" />';

			resultHtml += '</table>';
			//清除所有默认
			$("#addressList table").each(function(index, element) {
				$(this).removeClass("isSelect");
				$(this).addClass("noSelect");
			});
			$(".addressDefault").each(function(index, element) {
				$(this).next().removeClass("hide");
				$(this).addClass("hide");
			});	
			$("#addressList").append(resultHtml);	
			$("#addressList").show();
			$("#cartToConfirmBtn").show();
			$("#addressCreate").hide();	
			$("#cartTwoContent").show();
			$("#newAddress").show();	
		}
	}
	
	function backUpdateAddress(response){
		if(response['addressId']){
			var resultHtml = '';		
			resultHtml += '<tr><td class="addressTitle">'+response["firstName"]+ ' ' + response["lastName"]+'</td></tr>';
			resultHtml += '<tr><td>'+response["telephone"]+' '+response["cellphone"]+'</td></tr>';
			resultHtml += '<tr><td>'+response["address1"]+' '+response["address2"]+'</td></tr>';
			resultHtml += '<tr><td>'+response["city"]+' '+response["province"]+' '+response["country"]+'</td></tr>';
			resultHtml += '<tr><td align="right">';
			if(response["isdefault"]){
				resultHtml += '<span class="addressDefault">Default</span>';
				resultHtml += '<span class="addressSetDefault hide" onclick="setDefaultAddress(\''+ response['addressId'] +'\',\''+ response['userId'] +'\');">Set Default</span>';					
			}else{
				resultHtml += '<span class="addressDefault hide">Default</span>';
				resultHtml += '<span class="addressSetDefault" onclick="setDefaultAddress(\''+ response['addressId'] +'\',\''+ response['userId'] +'\');">Set Default</span>';
			}
			resultHtml += '<span class="addressEdit" onclick="addressEdit(this);">Edit</span></td></tr>';
			resultHtml += '<input type="hidden" value="' + response['addressListArr'] + '" id="'+response['addressId']+'_addressDataArr" />';	
			
			//清除所有默认
			$("#addressList table").each(function(index, element) {
				$(this).removeClass("isSelect");
				$(this).addClass("noSelect");
			});	
			if(response['isdefault']){
				$(".addressDefault").each(function(index, element) {
					$(this).next().removeClass("hide");
					$(this).addClass("hide");
				});		
			}		
				
			$("#"+response['addressId']).html(resultHtml);
			$("#"+response['addressId']).removeClass("noSelect");
			$("#"+response['addressId']).addClass("isSelect");
			$("#addressList").show();
			$("#cartToConfirmBtn").show();
			$("#addressCreate").hide();	
			$("#newAddress").show();
			
			//处理后事
			$("#addressCreate input:text").each(function(index, element) {
				$(this).val("");
			});							
		}else{
			alert("no");
		}
	}
