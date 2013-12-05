$(function(){
	$('#login_btn').click(doLogin);
});

//登录
function doLogin(){
	var args = $('#form_login').serialize();
	var staffNo = $('#staffNo');
	var password = $('#password');	
	if(staffNo.val().length > 0 && password.val().length > 0){
		call_tpl('website','CheckUser','backData1(\'StaffNoMessage\')','return',staffNo.val(),password.val(),'admin','');
	}else{
		alert('请输入用户名或密码');
	}
}

function backData1(response){

	if(response === 0){
		alert('用户名或密码错误');
	}else if(response === 2){
		alert('对不起，用户名还未激活');
	}else{
		var logout = 
		'<div class="logout fr">'+
             '<dl class="welcome fr">'+
                 '<dt>'+
                     '<span>Welcome !<br></span>'+
                               '<a href="###">'+ response.staffName +'</a>'+
                           '</dt>'+
                           '<dd class="loginBtn">'+
                               '<input type="button" value="Log out">'+
                           '</dd>'+
                '</dl>'+
        '</div>';
        $('#login_form').html(logout);
	}
}

//添加购物车
//$('#addShoppingBag').click(function(){
//	var args = $('#goodsInfo').serialize();
//	alert(args);
//	call_tpl('shop','addCart','backData2(\'StaffNoMessage\')','return',args,'');
//})
//function backData2(response){
//	if(response>0)
//	{
//		alert("Add TO SHOPING BAG SUCCESS");
//		$('#headerNewCartCount').html(response);
//		loadCart();	
//		alert("dfdsf");
//	}
//}