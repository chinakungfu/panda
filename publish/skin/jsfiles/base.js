	//四舍五入保留两位小数
	function changeTwoDecimal(x)
	{
		var f_x = parseFloat(x);
		if (isNaN(f_x))
		{
			alert('function:changeTwoDecimal->parameter error');
			return false;
		}
		var f_x = Math.round(x*100)/100;
		return f_x;
	}
	function setCurrency(s){
		s = String(s);
		if(s.indexOf('-')==0){
			//计算负数
			s= s.substring(1,s.lenght);
			alert("ddddd"+s);
			if(/[^0-9\.\-]/.test(s)) return "invalid value";
			s=s.replace(/^(\d*)$/,"$1.");

			s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
			s=s.replace(".",",");
			var re=/(\d)(\d{3},)/;
			while(re.test(s))
			s=s.replace(re,"$1,$2");
			s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

			return '-'+s.replace(/^\./,"0.")
		}else{
			//计算正数
			if(/[^0-9\.\-]/.test(s)) return "invalid value";
			s=s.replace(/^(\d*)$/,"$1.");

			s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
			s=s.replace(".",",");
			var re=/(\d)(\d{3},)/;
			while(re.test(s))
			s=s.replace(re,"$1,$2");
			s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

			return s.replace(/^\./,"0.")
		}
	}
function number_format (number, decimals, dec_point, thousands_sep) {

    number = (number + '').replace(/[^0-9+-Ee.]/g, '');

    var n = !isFinite(+number) ? 0 : +number,

        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),

        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,

        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,

        s = '',

        toFixedFix = function (n, prec) {

            var k = Math.pow(10, prec);

            return '' + Math.round(n * k) / k;

        };

    // Fix for IE parseFloat(0.55).toFixed(0) = 0;

    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

    if (s[0].length > 3) {

        s[0] = s[0].replace(/B(?=(?:d{3})+(?!d))/g, sep);

    }

    if ((s[1] || '').length < prec) {

        s[1] = s[1] || '';

        s[1] += new Array(prec - s[1].length + 1).join('0');

    }

    return s.join(dec);

}
function isNum(s){
	var r,reg;
	reg=/\d*/;
	r=s.match(reg);
	if(r==s)
	  return true;
	else
	  return false;
}
function isfloat(oNum){

	  if(!oNum) return false;

	  var strP=/^\d+(\.\d+)?$/;

	  if(!strP.test(oNum)) return false;

	  try{

	  	if(parseFloat(oNum)!=oNum) return false;

	  }catch(ex){

	    return false;

	  }

	  return true;

	}
function checkEndTime(fromTime,endTime){  
 
	var start=new Date(fromTime.replace("-", "/").replace("-", "/"));  
	
	var end=new Date(endTime.replace("-", "/").replace("-", "/"));  
	
	if(end < start){  
		return false;  
	}  
	return true;  
}  

function DBC2SBC(str) 
{ 
	var result=""; 
	for(var i=0;i<str.length;i++) 
	{ 
		code = str.charCodeAt(i);//获取当前字符的unicode编码 
		if (code >= 65281 && code <= 65373)//在这个unicode编码范围中的是所有的英文字母已经各种字符 
		{ 
			var d=str.charCodeAt(i)-65248; 
			result += String.fromCharCode(d);//把全角字符的unicode编码转换为对应半角字符的unicode码 
		} 
		else if (code == 12288)//空格 
		{ 
			var d=str.charCodeAt(i)-12288+32; 
			result += String.fromCharCode(d); 
		} 
		else 
		{ 
			result += str.charAt(i); 
		} 
	} 
	return result; 
}