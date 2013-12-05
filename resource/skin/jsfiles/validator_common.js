/*
  下列函数返回值说明：
  凡是“Is”开头的函数，如果是"Is"后指明的状态，则返回真，否则为假
  eg. IsNum 如果是数字，返回真
  某些“Check”开头的函数，如果是"Check"后指明的状态，返回假，否则为真
  某些则相反,请具体查看函数说明
  eg. CheckEmpty 如果是空，返回假

  函数名解释：
   当有重载出现时
   NP 表示没有参数（no parameter）
   3P,4P 等表示参数个数(3 parameter,4 parameter)

  ***************************************************************
  函数目录:
  -----------校验输入与工具类--------------------------------------------


  ReplaceDoubleQuotes(strValue) 替换双引号为&quot;
  CheckUnsafeMark(frm)  检查参数frm(form)对象里所有输入控件是否含有非法字符
  CheckKey(KeyCode)  检查输入键是否为0~9,a~z(A~Z),Del,-,.,
  CheckEmptyNP()  校验触发者的值是否为空
  CheckEmpty(CheckCtl,disptext) 校验输入值是否为空
  CheckCardNo(CheckCtl,disptext)  校验一个合法的身份证号码(15,18位)
  Trim(strSource) 清除左右两边空格
  IsEmail(CheckCtl, s) 判断是否是正确的电子邮件地址
  IsPhoneNumber(CheckCtl,s) 判断是否是正确的电话号码
  IsLetter(CheckCtl,s) 判断是否是字母组合
  IsCode(CheckCtl,s) 判断是否是数字编码组合 数字和数字编码的区别:
 数字编码允许  000000010 ,不允许诸如: -1290092 ,23.,.3456等类型的值,而数字则认为是真
  IsUserName(CheckCtl,s) 判断是否是正确的用户名 用户名只能由小写英文字母、阿拉伯数字和下划线组成!s=null or s="" 时有默认的提示信息
  IsImageFile(FilePath) 判断是否文件路径中文件是图像文件，路径可以是url或者file:\\

  ------------数字类-----------------------------------------
  Round(i,digit)   取整函数,digid为保留的小数位数
  CheckPositiveInt(CheckCtl,disptext,IsCanZero) 校验一个正整数
  CheckPositiveIntNP()  校验触发者的值是否为一个正整数
  CheckPositiveFloat(CheckCtl,disptext,floatcount) 校验一个合法的大于等于0的浮点数
  CheckPositiveFloatNP()  校验触发者的值是否一个合法的大于等于0的浮点数(2位小数)
  CheckPositiveFloat4P(CheckCtl,disptext,IsCanZero,floatcount) 校验一个合法的大于0的浮点数,是否可以等于零由参数IsCanZero决定
  IsCost(Costctrl) 检查费用输入，小数位为2位，且不能超过SQL Server中数据字段money最大值
  IsNum(txtctl,message,floatcount) 校验是否是数字
  CheckIntRange(CheckCtl,Min, Max,Msg) 校验一个合法的且在规定范围内的整数
  CheckFloatRange(CheckCtl,Min, Max,Msg) 校验一个合法的且在规定范围内的浮点数


  -----------日期类-------------------------------------------
  GetDateDiff(strStart,strEnd) 计算两个日期间隔天数
  CheckYear(strYearInput) 检查输入是否是个有效年份
  AddDay(dateObj,days) 把一个日期加上n天
  CheckDiffDate(BDateCtl,EDateCtl,Msg) 比较两个日期的大小，如果开始日期大于结束日期，返回false;
  DateToStr(dateObj) 将一个日期对象转化为格式yyyy-MM-dd字符串
  DateTimeToStr(dateObj) 将一个日期时间对象转化为形如  yyyy-MM-dd HH:mm:ss 的字符串
  StrToDate(str)  yyyy-MM-dd 的字符串转化为日期对象：
  StrToDateTime(str)   将一个yyyy-MM-dd HH:mm:ss 的字符串转化为日期时间对象
  StrToDateTime6P(year,month,day,hour,minute,second) 将一个参数构成的yyyy-MM-dd HH:mm:ss 的字符串转化为日期时间对象
  IsDate(str) 判断一个字符串是否为有效的日期并且格式是否正确 YYYY-MM-DD
  ----------------------------------------------------------




  *************************************************************
*/


var maxpn=999999999999;
var maxfn=999999999999.9;
var numerrormsg0="请输入0-999999999999之内的数字";
var numerrormsg1="请输入1-999999999999之内的数字";
var overerrormsg="数值超过最大值999999999999";




//替换双引号为&quot;//
function ReplaceDoubleQuotes(strValue){
  return strValue.replace('"','&quot;');
}

//
//检查FORM里所有输入控件是否含有非法字符//
function CheckUnsafeMark(frm)
{
 for(var i=0;i<frm.length;i++)
 {
  var edit = frm.item(i);

  var stag = edit.tagName;
  if (edit.type) {
   var stype = edit.type;
   if ( (stype.toLowerCase()!="password") && (stype.toLowerCase() != "text") )
   {
     continue;
   }
  } else{
    var stag = edit.tagName;
    if (stag.toLowerCase()!="textarea"){
       continue;
    }
  }
    var s = Trim(edit.value);
    if ((s.indexOf("\"")>=0)||(s.indexOf("\'")>=0)||(s.indexOf("<")>=0)||(s.indexOf(">")>=0))
    {
    alert("不能输入包含非法字符(如\", \', <, >)的文字!");
    edit.select();
    edit.focus();
    return false;
  }
    else
  continue;

 }//end of for
 return true;
}



//检查输入键是否为0~9,a~z(A~Z),Del,-,.,/
//KeyDown 有效
function CheckKey(KeyCode)
{
Zero=48;
Nine=57;
Delete=46;
Minus=189;
Dot=190;
Divide=191;
Key_a=65;
Key_z=90;
_Zero=96;
_Nine=105;
_Divide=111;
_Minus=109;
_Dot=110;
return ((KeyCode>=Key_a)&&(KeyCode<=Key_z))||((KeyCode>=Zero)&&(KeyCode<=Nine))||((KeyCode>=_Zero)&&(KeyCode<=_Nine))||(KeyCode==Delete)||(KeyCode==Dot)||(KeyCode==Minus)||(KeyCode==Divide)||(KeyCode==0)||(KeyCode==_Minus)||(KeyCode==_Divide)||(KeyCode==_Dot);
}

//取整函数
//eg. Round(132.123456) 为 132.12
//eg. Round(132.123456,4) 为 132.1234
//eg. Round(132.123456,0) 为 132
function Round(i,digit)
{
  if (isNaN(parseFloat(i)))
  {
  return '0';
   }
 if(digit==0)
  p=1;
 else
 {
  if(digit)
   p=Math.pow(10,digit);
  else
   p=100;
 }
 var mm = Math.round(i*p)/p;
 var strTmp = eval("'"+ mm +"'");
 var behind = '';
 if (strTmp.indexOf('.')>=0)
 {
    behind = strTmp.substring(strTmp.indexOf('.')+1,strTmp.length);
    while(digit-behind.length>0)
    {
   behind += '0';
    }
    strTmp = strTmp.substring(0,strTmp.indexOf('.')+1) + behind;

 }
 else
 {
    for(var j=0;j< digit;j++)
    {
    behind += '0';
    }
  if (digit >0)
  {
    strTmp = strTmp + '.' + behind;
  }
 }
 return strTmp;

}

/********************************************
功能:自动计算两个日期间隔天数
先要检查开始日期是否大于截止日期,如果大于,返回
参数: start 开始日期字符串 end 截止日期字符串
*/
function GetDateDiff(strStart,strEnd)
{
    var start = strStart;
 var end = strEnd;
 if (StrToDate(start) > StrToDate(end))
 {
  alert("起始日期必须小于截止日期!");return;
 }
 else
 {
  var startdate = new Date();
  startdate = StrToDate(start);

  var enddate = new Date();
  enddate =  StrToDate(end);
  var overdue = parseFloat(enddate) - parseFloat(startdate);
  overdue = overdue/(1000*24*60*60);
  return overdue;
  }
}




/*
功能： 得到两个日期相差的天数（每一个月按30天，一年360天计算） 该函数不精确
入口参数：
   datestartObj: 日期对象1
   dateendObj: 日期对象2
   返回 dateendObj - datestartObj相差的天数 */
/*function GetDayDiff(datestartObj,dateendObj)
{
 var year=dateendObj.getFullYear() - datestartObj.getFullYear();
 var month=dateendObj.getMonth() - datestartObj.getMonth();
 var day=dateendObj.getDate() - datestartObj.getDate();
 return year*12*30+month*30+day;
}*/

/*
 功能:检查输入是否是个有效年份   */
function CheckYear(strYearInput)
{

 var years = strYearInput;
 if ( years != ""  && !isNaN(parseInt(years)) )
 {
  if (parseInt(years)<=3000  && parseInt(years)>=1900)
  {
   return true;
  }
  else
  { alert('请输入合法年份!');return false;}
 }
 else
   return true;

}


/*  功能： 把一个日期加上n天
 入口参数：
   dateObj: 要计算的日期对象
   days: 增加的天数
 返回  增加后的新日期对象 */
function AddDay(dateObj,days)
{
    try
 {

   var lngDiff =  parseFloat(days);
   lngDiff = lngDiff*24*60*60*1000;
   dateObj = StrToDate(DateToStr(dateObj));
   var ret = new Date(dateObj.getTime()+lngDiff);
   return ret;
 }
 catch(x)
 {
    return dateObj;
 }

}


/* 功能： 校验一个正整数
入口参数：CheckCtl: 要校验的输入框  disptext: 出错显示的信息 IsCanZero : 是否可以为零
返回:  真: 是正整数 假: 不是*/
function CheckPositiveInt(CheckCtl,disptext,IsCanZero)
{
 var s=new String(Trim(CheckCtl.value));
 var temp=parseInt(s);
 var result=true;
 if (  (isNaN(temp)) || (temp<0) || ( s.indexOf(".")>=0 )||(temp!=s))
 {
  result=false;
 }
 else if ( (!IsCanZero)&&(temp==0) )
  {
  result=false;
  }
 if  (temp>maxpn)
 {
  result=false;
  disptext=overerrormsg;
 }
  if (!result)
  {
  DispMessage(CheckCtl, disptext);
  return false;
 }
  return true;

}

//
//不带参数的校验一个正整数
function CheckPositiveIntNP()
{
   var o = event.srcElement;
   if (o)
   {
   if (o.tagName == "INPUT"  && !isNaN(parseFloat(o.value)) )
  return CheckPositiveInt(o,'请输入正整数!',true)
   else
  return true;

   }
   else
  return true;
}





/*功能： 校验一个合法的大于等于0的浮点数
入口参数：
   CheckCtl: 要校验的输入框      disptext: 出错显示的信息
   floatcount: 小数的最高位数（如果没有该参数，则默认为4位）
   如果没有page参数，有floatcunt参数则：把page 置null
   如: CheckPositiveFloat(CheckCtl,"出错显示的信息",null,5)    */
function CheckPositiveFloat(CheckCtl,disptext,floatcount)
{
 var s=new String(Trim(CheckCtl.value));
 temp=parseFloat(s);
 var result=true;
 if( (isNaN(temp)) || (temp< 0)||(temp!=s) )
 {
  result=false;
 }
 else if (temp>maxfn)
 {
  result=false;
  disptext=overerrormsg;
 }
 else
 {
  limitcount=floatcount?floatcount:4;
  var array=s.split(".");
  if (array[1]==null)
  count=-1;
  else
  {
  var str=new String(array[1]);
  count=str.length;
  }
  if (count>limitcount)
  {

   b=confirm("小数位数超过"+limitcount+"位,是否继续?");
   if (b)
    {
     return true;
    }
    else
    {
   CheckCtl.select();
   CheckCtl.focus();
   return false;
    }
  }
  }
  if (!result)
  {
  DispMessage(CheckCtl,disptext);
  return false;
  }
  return true;

}

//不带参数校验一个合法的大于等于0的浮点数(2位小数)
function CheckPositiveFloatNP()
{
   var o = event.srcElement;
   if (o)
   {
   if (o.tagName == "INPUT"  && !isNaN(parseFloat(o.value)) )
   return CheckPositiveFloat(o,'请输入正确的数目!',2);
   else
   return true;
   }
   else
  return true;
}

/*
   校验一个合法的大于0的浮点数
   参数：CheckCtl: 要校验的输入框
        disptext: 出错显示的信息
  IsCanZero:是否可以等于零
  floatcount: 小数的最高位数（如果没有该参数，则默认为4位）
*/
function CheckPositiveFloat4P(CheckCtl,disptext,IsCanZero,floatcount)
{

 if ( CheckPositiveFloat(CheckCtl,disptext,floatcount) )
  {
  if ( (parseFloat(CheckCtl.value)==0) &&(!IsCanZero) )
   {
    DispMessage(CheckCtl,disptext);
    return false;
   }
  else return true;
  }
 else
  return false;
}

/*
检查费用输入，小数位为2位，且不能超过数据字段money最大值
true: 正确
*/
function IsCost(Costctrl)
{
if (Costctrl.value != "")
{
 if (IsNum(Costctrl,"费用请填入金额！",2))
 {
   if (!CheckFloatRange(Costctrl,0,900337203685477.5807,"费用金额超出范围！"))
   return false;
   else
   return true;

 }
  else
  return false;
}
else
return true;
}

/*判断是否是数字的函数
   输入：txtctl   输入的文本控件 message  显示的错误信息
     floatcount: 小数的最高位数（如果没有该参数，则默认为4位）
  返回值 :是数字返回true，不是返回false
 如: IsNum(txtctl,"出错显示的信息",5)  */
function IsNum(txtctl,message,floatcount)
{
 var s=new String(Trim(txtctl.value));
 var result=true;
 var num=Number(s);
 if ( (isNaN(num)) || (s=="") )
 {
  result=false;
 }
 else if (num>maxfn)
 {
  message=overerrormsg;
  result=false;
 }
 else
 {
  limitcount=floatcount?floatcount:4;
  var array=s.split(".");
  if (array[1]==null)
  count=-1;
  else
  {
  var str=new String(array[1]);
  count=str.length;
  }
  if (count>limitcount)
  {
   alert("小数位数超过"+limitcount+"位!");
   txtctl.select();
   txtctl.focus();
   return false;
  }
 }
 if (!result)
 {
  DispMessage(txtctl,message);
  return false;
 }
  return true;
}


/*
   功能:检查是否为空,不用任何参数,触发者为Text

*/
function CheckEmptyNP()
{
var CheckCtl = event.srcElement;
if (Trim(CheckCtl.value)=="" )
 {

 CheckCtl.focus();
 return false;
 }
 else
 return true;


}

/*功能： 校验一个值是否为空
入口参数：CheckCtl: 要校验的输入框 disptext: 出错显示的信息
false:为空
*/
function CheckEmpty(CheckCtl,disptext)
{
 if (Trim(CheckCtl.value)=="" )
 {
  DispMessage(CheckCtl,disptext);
  return false;
 }
 else
   return true;
}




/*功能： 校验一个合法的且在规定范围内的整数
入口参数：
   CheckCtl: 要校验的输入框      Min:  下限
   Max:  上限
   Msg: 出错显示的信息  */

function CheckIntRange(CheckCtl,Min, Max,Msg)
{
 if (!IsNum(CheckCtl,Msg))
 return false;
 var s=new String(Trim(CheckCtl.value));
 v=parseInt(s);
 if  ( (v<Min) || (v>Max) || (s.indexOf(".")>=0))
 {
  DispMessage(CheckCtl,Msg);
  return false;
 }
 return true;
}
/*功能： 校验一个合法的且在规定范围内的浮点数   入口参数：
   CheckCtl: 要校验的输入框      Min:  下限
   Max:  上限
   Msg: 出错显示的信息  */

function CheckFloatRange(CheckCtl,Min, Max,Msg)
{
 if (!IsNum(CheckCtl,Msg))
  return false;
 v=parseFloat(Trim(CheckCtl.value));
 if  ( (v<Min) || (v>Max) )
 {
  DispMessage(CheckCtl,Msg);
  return false;
 }
 return true;
}

/*功能： 校验一个合法的身份证号码(15,18位)
入口参数：
   CheckCtl: 要校验的输入框
   disptext: 出错显示的信息  */

function CheckCardNo(CheckCtl,disptext)
{
 var result=true;
 var strvalue=new String(Trim(CheckCtl.value));
 if ( strvalue!="" )
  {
   num=parseInt(strvalue);
   if (  ( isNaN(num) ) || (num<100000000000000)|| (strvalue.indexOf(".")>=0)||(num!=strvalue) )
    result=false;
   else
    if ( (num>999999999999999)&&(num<100000000000000000) )
      result=false;
    else
      if (num>999999999999999999)
    result=false;
  }
 if (!result)
  {
  DispMessage(CheckCtl,disptext);
  }
 return result;
}

//显示信息
function DispMessage(CheckCtl,Msg)
{
 if (Msg!="")
 {
  alert(Msg);
  //CheckCtl.select();
  CheckCtl.focus();
 }
}



/*
   去掉空格同VBSCRIPT中的trim
*/
function Trim(strSource)
{
 return  strSource.replace(/^\s*/,'').replace(/\s*$/,'');

}





 /*功能： 比较两个日期的大小，如果开始日期大于结束日期，返回false;
入口参数：
   BDate:开始日期输入框      EDate:结束日期输入框
   Msg: 出错显示的信息  */
function CheckDiffDate(BDate,EDate,Msg)
{
 if ( (!CheckEmpty(BDate,"请输入开始时间或日期！")) || (!CheckEmpty(EDate,"请输入结束时间或日期！")) )
  return false;
 str = BDate.value;
 if(!IsDate(str)){DispMessage(BDate,"开始时间或日期不是有效的日期");return false;}
 aa = str.split("-");
 BYear = parseInt(aa[0],10);
 BMonth = parseInt(aa[1],10);
 BDay = parseInt(aa[2],10);
 str = EDate.value;
 if(!IsDate(str)){DispMessage(EDate,"结束时间或日期不是有效的日期");return false;}
 bb = str.split("-");
 EYear = parseInt(bb[0],10);
 EMonth = parseInt(bb[1],10);
 EDay = parseInt(bb[2],10);
 if(BYear<1900)
 {
  DispMessage(BDate,"日期不能小于1900年！");
  return false;
 }
 if(EYear<1900)
 {
  DispMessage(EDate,"日期不能小于1900年！");
  return false;
 }

 b=(BYear*10000)+(BMonth*100)+BDay;
 e=(EYear*10000)+(EMonth*100)+EDay;
 if(e==b)
  return true;
 else
  if(e>b)
   return true;
  else
  {
   DispMessage(BDate,Msg);
   return false;
  }
}



/*
功能： 将一个日期对象转化为格式yyyy-MM-dd字符串：
dateObj 日期对象
*/
function DateToStr(dateObj)
{
  var im;
  var id;
  var paradate = new Date();
  paradate = dateObj;
  if ((paradate.getMonth()+1)<10)
  {
   im = paradate.getMonth()+1;
   im = '0' + im;
  }
  else
   im = paradate.getMonth()+1;
  if ((paradate.getDate())<10)
   id = "0"+paradate.getDate();
  else
   id = paradate.getDate();
  return  paradate.getFullYear() + "-" + im + "-"
       + id;
}

/*功能： 将一个日期时间对象转化为字符串：
  dateObj 日期对象
  返回：形如  yyyy-MM-dd HH:mm:ss 的字符串
*/
function DateTimeToStr(dateObj)
{

  var im;
  var id;
  var ih;
  var iminutes;
  var iseconds;
  var paradate = new Date();
  paradate = dateObj;
  if ((paradate.getMonth()+1)<10)
  {
   im = paradate.getMonth()+1;
   im = '0' + im;
  }
  else
   im = paradate.getMonth()+1;
  if ((paradate.getDate())<10)
   id = "0"+paradate.getDate();
  else
   id = paradate.getDate();

  if (paradate.getHours()< 10)
  {
  ih = "0" + paradate.getHours();
  }
  else
  ih = paradate.getHours();
   if (paradate.getMinutes()< 10)
  {
  iminutes = "0" + paradate.getMinutes();
  }
  else
  iminutes = paradate.getMinutes();

  if (paradate.getSeconds()< 10)
  {
  iseconds = "0" + paradate.getSeconds();
  }
  else
  iseconds = paradate.getSeconds();

  var ret =  paradate.getFullYear() + "-" + im + "-"
       + id + " " + ih + ":" + iminutes + ":" + iseconds;
   return ret;
}

/*功能： 字符串转化为日期对象：
  返回：  date 日期对象
 str yyyy-MM-dd 的字符串
*/
 function StrToDate(str)
 {
 var date = new Date();
 date = Date.parse(str);
   if (isNaN(date)) {
   date = Date.parse(str.replace(/-/g,"/")); // 识别日期格式：YYYY-MM-DD
   if (isNaN(date)) date = 0;
   }
 date = new Date(date);
 return(date);
  }

/*功能： 将一个字符串转化为日期时间对象：
  返回：  date 日期对象
 str yyyy-MM-dd HH:mm:ss 的字符串
*/
function StrToDateTime(str)
{
   var datTmp = new Date();
   try
   {

   var aryTmp = str.split(' ');
   var aryTmpBig = aryTmp[0].split('-');
   var year = aryTmpBig[0];
   var month = aryTmpBig[1];
   var day = aryTmpBig[2];

   var mm =  month;
   if (mm.indexOf('0') == 0)
   {

   mm = mm.substring(1,mm.length);
   }
   var dd = day;

   if (mm=="1"){mm="JAN";}
   if (mm=="2"){mm="FEB";}
   if (mm=="3"){mm="MAR";}
   if (mm=="4"){mm="APR";}
   if (mm=="5"){mm="MAY";}
   if (mm=="6"){mm="JUN";}
   if (mm=="7"){mm="JUL";}
   if (mm=="8"){mm="AUG";}
   if (mm=="9"){mm="SEP";}
   if (mm=="10"){mm="OCT";}
   if (mm=="11"){mm="NOV";}
   if (mm=="12"){mm="DEC";}
 var expdate_string=mm+" "+dd+","+year+" "+aryTmp[1];
 var mii = Date.parse(expdate_string);
 datTmp = new Date(mii);

   }
   catch(x)
   {alert('日期格式不正确！');}
   return datTmp;
}
/*功能： 将字符串转化为日期时间对象：
  返回：  date 日期对象
 yyyy-MM-dd HH:mm:ss 的字符串
*/
function StrToDateTime6P(year,month,day,hour,minute,second)
{
   var datTmp = new Date();
   var mm =  month;
   if (mm.indexOf('0') == 0)
   {

   mm = mm.substring(1,mm.length);
   }
   var dd = day;

   if (mm=="1"){mm="JAN";}
   if (mm=="2"){mm="FEB";}
   if (mm=="3"){mm="MAR";}
   if (mm=="4"){mm="APR";}
   if (mm=="5"){mm="MAY";}
   if (mm=="6"){mm="JUN";}
   if (mm=="7"){mm="JUL";}
   if (mm=="8"){mm="AUG";}
   if (mm=="9"){mm="SEP";}
   if (mm=="10"){mm="OCT";}
   if (mm=="11"){mm="NOV";}
   if (mm=="12"){mm="DEC";}

   var expdate_string=mm+" "+dd+","+year+" "+hour+":"+minute+":"+second;

   try
   {
  var mii = Date.parse(expdate_string);
  datTmp = new Date(mii);

   }
   catch(x)
   {alert('日期格式不正确！');}
   return datTmp;
}

/*
   判断一个字符串是否为有效的日期并且格式是否正确 YYYY-MM-DD
   参数 str:被检查的字串
   返回:真或假
*/
function IsDate(str)
{

   if (Trim(str)=="") return false;
   try
   {

  var year = str.substring(0,4);
  if (isNaN(parseInt(year,10)) || (parseInt(year,10)>3000 || parseInt(year,10)<1900) )
  {
  return false;
  }
  if (str.substring(4,5)!="-" || str.substring(7,8)!="-")
  {
  return false;
  }
  var MM = str.substring(5,7);
  var DD = str.substring(8,10);
  if (MM!="01" && MM!="02" && MM!="03" && MM!="04" && MM!="05" && MM!="06" && MM!="07" && MM!="08"&&MM!="09" && MM!="10"&&MM!="11" && MM!="12")
  {
  return false;
  }
  if (isNaN(parseInt(DD,10)))
  {
  return false;
  }
  var date = Date.parse(MM+'/'+DD+'/'+year);
   if (isNaN(date))
   {
    return false;//date = Date.parse(str.replace(/-/g,"/"));
   }

   return true;
   }
   catch(x)
   {

   return false;
   }
}

/*
  检验正则表达式是否符合
*/
function IsValid(p, t, s) {
if (p.test(t.value))
return true;

if (s != null) {
t.focus();
alert(s);
}
return false;
}

/*
 判断是否是正确的电子邮件地址
 参数: CheckCtl :要检验的输入框 s:出错时需要警告的信息
 true:是 false:否
*/
function IsEmail(CheckCtl, s) {
return IsValid(/^\s*\w+\@\w+(\.\w+)+\s*$/i, CheckCtl, s);
}

/*
 判断是否是正确的电话号码
 电话号码仅允许 数字, ( , ) , -  号
 参数: CheckCtl :要检验的输入框 s:出错时需要警告的信息
 true:是 false:否
*/
function IsPhoneNumber(CheckCtl,s)
{
 try
 {
  var t =  Trim(CheckCtl.value);
  if (t==null || t=="" )
  {
   return false;
  }
  t = t.replace("-","");
  t = t.replace("(","");
  t = t.replace(")","");

  if (t.indexOf(".")>=0)
  {
     CheckCtl.focus();
     alert(s);
     return false;
  }

  for(var i=0;i< t.length;i++)
  {
      var c = t.charAt(i);
   if (isNaN(parseInt(c,10)))
   {
      CheckCtl.focus();
      alert(s);
      return false;
   }
  }
  return true;
 }
 catch(x)
 {
    return false;
 }
}

/*
 判断是否是字母组合
 参数: CheckCtl :要检验的输入框 s:出错时需要警告的信息
 true:是 false:否
*/
function IsLetter(CheckCtl,s)
{
    try
 {
     var t =  Trim(CheckCtl.value);
  if (t==null || t=="")
  {
   return false;
  }

      for(var i=0;i<t.length;i++)
      {

        var sss = t.charCodeAt(i);
        if (! (sss>=65 && sss<=90 || sss>=97 && sss<=122) )
        {
           alert(s);
     CheckCtl.focus();
           return false;
        }
      }
      return true;
 }
 catch(x)
 {
    return false;
 }
}

/*
 判断是否是数字编码组合
 数字和数字编码的区别:
 数字编码允许  000000010 ,不允许诸如: -1290092 ,23.,.3456等类型的值,而数字则认为是真
 参数: CheckCtl :要检验的输入框 s:出错时需要警告的信息
 true:是 false:否
*/
function IsCode(CheckCtl,s)
{
    try
 {
     var t =  Trim(CheckCtl.value);
  if (t==null || t=="")
  {
   return false;
  }

      for(var i=0;i<t.length;i++)
      {

        var sss = t.charCodeAt(i);
        if (! (sss>=48 && sss<=57 ) )
        {
           alert(s);
     CheckCtl.focus();
           return false;
        }
      }
      return true;
 }
 catch(x)
 {
    return false;
 }
}
/*
 判断是否是正确的用户名
 用户名只能由小写英文字母、阿拉伯数字和下划线组成
  参数: CheckCtl :要检验的输入框
  s:出错时需要警告的信息 s=null or s="" 时有默认的提示信息
 true:是 false:否
*/
function IsUserName(CheckCtl,s)
{
    try
 {
     var t =  Trim(CheckCtl.value);
  if (t==null || t=="")
  {
   return false;
  }
     if (s=="" || s==null){
    s = "用户名只能由小写英文字母、阿拉伯数字和下划线组成!";
  }

       if (!IsValid(/[a-z]*|\d*|\_/,CheckCtl, s)){
      return false;
    }
      return true;
 }
 catch(x)
 {
    return false;
 }
}

/**********************************
 *功能  校验文本框输入内容的非法字符
 *入口参数 fld 要校验的输入框
 *   invlid 非法字符（串)
 *   msg 出错显示的信息
 *返回  true 包含非法字符（串)
 *   false 不包含
**********************************/
function CheckInvalidString(fld, invalid, msg) {
    if(fld.type == null || (fld.type != 'text' && fld.type != 'password'))
     return false;

 var src=fld.value;
 if(src == null || src.length == 0 ||
    invalid == null || invalid.length == 0 )
      return false;

 if(fld.value.indexOf(invalid) >= 0) {
     alert(msg);
  return true;
 }

 return false;
}


/**********************************
 *功能  判断是否文件路径中文件是图像文件，路径可以是url或者file:\\
 *入口参数 文件路径
 *返回  true 是
 *   false 否
**********************************/
function IsImageFile(FilePath) {
           var aryimg = new Array("ART","BMP","DJVU","EMF","GIF","ICN","ICO","IFF"
     ,"JPEG","JPG","KDC","LDF","LWF","MAG","PBM","PIC","PICT","PIX","PNG","PPM"
     ,"PSD","PSP","RAS","RS","SGI","TGA","TIFF","TTF","WMF","XBM","XPM");
     var  str=FilePath;
        var  i=str.lastIndexOf(".");
     var  str1=str.substring(i+1);
     for(var k=0;k< aryimg.length;k++){
        if(str1.toUpperCase()==aryimg[k])
        {
              return true;
     }

     }
     return false;
}

