/**
公共JS函数文件
**/

function trim(str){  //删除左右两端的空格
 return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str){  //删除左边的空格
 return str.replace(/(^\s*)/g,"");
}
function rtrim(str){  //删除右边的空格
 return str.replace(/(\s*$)/g,"");
}

function args2array() { //把传入参数中的arguments对象转换成数组返回
	return Array.prototype.slice.apply(arguments[0]);
}