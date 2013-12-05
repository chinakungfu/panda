var ajax = new Ajax( "POST", "index.php", false, true );
function call_method()
{
	//ajax.callMethod('staff','checkNo',call_method.arguments,"testdata()")
	var newArr = new Array();
	newArr = Array.prototype.slice.apply(call_tpl.arguments)
	newArr = newArr.slice(3);
	ajax.callMethod(call_tpl.arguments[0],call_tpl.arguments[1],newArr,call_tpl.arguments[2])
}
function call_func()
{
	//ajax.callFunction('staff','checkNo',call_method.arguments,"testdata()")
	var newArr = new Array();
	newArr = Array.prototype.slice.apply(call_tpl.arguments)
	newArr = newArr.slice(3);
	ajax.callFunction(call_tpl.arguments[0],call_tpl.arguments[1],newArr,call_tpl.arguments[2])
}
function call_tpl()
{
	//call_tpl('return/display','ActionID','methodID','callback(\'divID\')','callmode',call_method.arguments);
	var newArr = new Array();
	newArr = args2array(call_tpl.arguments);
	newArr = newArr.slice(4);
	ajax.callTpl(call_tpl.arguments[0],call_tpl.arguments[1],newArr,call_tpl.arguments[2],call_tpl.arguments[3])
}
//ajax回调函数
function backData(response)
{
	var div = document.getElementById(arguments[1]);
	if(response!='')
	{
		div.style.display = "";
		div.style.color = "red";
		div.innerHTML = response;
	}else
	{
		div.style.display = "none";
		div.innerHTML = "";
	}
}