// JavaScript Document
$(function(){
	$(".select_box").hover(function(){
		$(".selectas").stop(true,true).show();
	},function(){
		$(".selectas").stop(true,true).hide();
	});
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
})
function changePhoneOrderStatus(orderID,changeType){
	if(orderID){
		if(changeType == 'finish'){
			if(confirm("Did you confirm the success?")){
				call_tpl('cms','changeOrderStatusPhone','backResult()','return',orderID,changeType,'one','');
				$(".admin_ajaxjump_box").dialog("open");
			}
		}else if(changeType == 'refund'){
			if(confirm("Are you sure you want a refund?")){
				call_tpl('cms','changeOrderStatusPhone','backResult()','return',orderID,changeType,'one','');
				$(".admin_ajaxjump_box").dialog("open");
			}			
		}
	}else{
		alert('error');
	}
}
function backResult(response){
	if(response){
		//alert(response);
		location.reload();
		$(".admin_ajaxjump_box").dialog("close");
	}else{
		alert("删除失败!");
		$(".admin_ajaxjump_box").dialog("close");
	}
}