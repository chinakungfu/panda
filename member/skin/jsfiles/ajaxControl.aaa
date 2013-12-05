var ajax = new Ajax( "POST", "index.php", false, true );
function call_method()
{
	//ajax.callMethod('staff','checkNo',call_method.arguments,"testdata()")
	var newArr = new Array();
	newArr = Array.prototype.slice.apply(call_method.arguments)
	newArr = newArr.slice(3);
	ajax.callMethod(call_method.arguments[0],call_method.arguments[1],newArr,call_method.arguments[2])
}
function call_func()
{
	//ajax.callFunction('staff','checkNo',call_method.arguments,"testdata()")
	var newArr = new Array();
	newArr = Array.prototype.slice.apply(call_func.arguments)
	newArr = newArr.slice(3);
	ajax.callFunction(call_func.arguments[0],call_func.arguments[1],newArr,call_func.arguments[2])
}
function call_tpl()
{
	//call_tpl('return/display','ActionID','methodID','callback(\'divID\')','callmode',call_method.arguments);
	//call_tpl('staff','checkData','backData(\'StaffNoMessage\')','return',document.forms[0].staffId.value,document.forms[0].StaffNo.value,'[$method]');
	var newArr = new Array();
	newArr = args2array(call_tpl.arguments);
	var newArrLen = newArr.length;
	newArr = newArr.slice(4);//页面传递的参数值
	//call_tpl.arguments[newArrLen-1]此参数以什么方式执行发送方式如：以PHPRPC发送
	ajax.callTpl(call_tpl.arguments[0],call_tpl.arguments[1],newArr,call_tpl.arguments[2],call_tpl.arguments[3],call_tpl.arguments[newArrLen-1])
	//ajax.callTpl(call_tpl.arguments[0],call_tpl.arguments[1],newArr,call_tpl.arguments[2],call_tpl.arguments[3],'')
}
//ajax回调函数
function backData(response)
{
	var div = document.getElementById(arguments[1]);
	if(response!='')
	{
		div.style.display = "";
		div.style.color = "red";
		response = response.substring(1,response.length-3);
		div.innerHTML = response;
	}else
	{
		div.style.display = "none";
		div.innerHTML = "";
	}
}
function backGetData(response)
{
	var div = document.getElementById(arguments[1]);
	if(response!='')
	{
		div.value = response;
	}else
	{
		div.value = "";
	}
}