/*
  ���к�������ֵ˵����
  ���ǡ�Is����ͷ�ĺ����������"Is"��ָ����״̬���򷵻��棬����Ϊ��
  eg. IsNum ��������֣�������
  ĳЩ��Check����ͷ�ĺ����������"Check"��ָ����״̬�����ؼ٣�����Ϊ��
  ĳЩ���෴,�����鿴����˵��
  eg. CheckEmpty ����ǿգ����ؼ�

  ���������ͣ�
   �������س���ʱ
   NP ��ʾû�в�����no parameter��
   3P,4P �ȱ�ʾ��������(3 parameter,4 parameter)

  ***************************************************************
  ����Ŀ¼:
  -----------У�������빤����--------------------------------------------


  ReplaceDoubleQuotes(strValue) �滻˫����Ϊ&quot;
  CheckUnsafeMark(frm)  ������frm(form)��������������ؼ��Ƿ��зǷ��ַ�
  CheckKey(KeyCode)  ���������Ƿ�Ϊ0~9,a~z(A~Z),Del,-,.,
  CheckEmptyNP()  У�鴥���ߵ�ֵ�Ƿ�Ϊ��
  CheckEmpty(CheckCtl,disptext) У������ֵ�Ƿ�Ϊ��
  CheckCardNo(CheckCtl,disptext)  У��һ���Ϸ������֤����(15,18λ)
  Trim(strSource) ����������߿ո�
  IsEmail(CheckCtl, s) �ж��Ƿ�����ȷ�ĵ����ʼ���ַ
  IsPhoneNumber(CheckCtl,s) �ж��Ƿ�����ȷ�ĵ绰����
  IsLetter(CheckCtl,s) �ж��Ƿ�����ĸ���
  IsCode(CheckCtl,s) �ж��Ƿ������ֱ������ ���ֺ����ֱ��������:
 ���ֱ�������  000000010 ,����������: -1290092 ,23.,.3456�����͵�ֵ,����������Ϊ����
  IsUserName(CheckCtl,s) �ж��Ƿ�����ȷ���û��� �û���ֻ����СдӢ����ĸ�����������ֺ��»������!s=null or s="" ʱ��Ĭ�ϵ���ʾ��Ϣ
  IsImageFile(FilePath) �ж��Ƿ��ļ�·�����ļ���ͼ���ļ���·��������url����file:\\

  ------------������-----------------------------------------
  Round(i,digit)   ȡ������,digidΪ������С��λ��
  CheckPositiveInt(CheckCtl,disptext,IsCanZero) У��һ��������
  CheckPositiveIntNP()  У�鴥���ߵ�ֵ�Ƿ�Ϊһ��������
  CheckPositiveFloat(CheckCtl,disptext,floatcount) У��һ���Ϸ��Ĵ��ڵ���0�ĸ�����
  CheckPositiveFloatNP()  У�鴥���ߵ�ֵ�Ƿ�һ���Ϸ��Ĵ��ڵ���0�ĸ�����(2λС��)
  CheckPositiveFloat4P(CheckCtl,disptext,IsCanZero,floatcount) У��һ���Ϸ��Ĵ���0�ĸ�����,�Ƿ���Ե������ɲ���IsCanZero����
  IsCost(Costctrl) ���������룬С��λΪ2λ���Ҳ��ܳ���SQL Server�������ֶ�money���ֵ
  IsNum(txtctl,message,floatcount) У���Ƿ�������
  CheckIntRange(CheckCtl,Min, Max,Msg) У��һ���Ϸ������ڹ涨��Χ�ڵ�����
  CheckFloatRange(CheckCtl,Min, Max,Msg) У��һ���Ϸ������ڹ涨��Χ�ڵĸ�����


  -----------������-------------------------------------------
  GetDateDiff(strStart,strEnd) �����������ڼ������
  CheckYear(strYearInput) ��������Ƿ��Ǹ���Ч���
  AddDay(dateObj,days) ��һ�����ڼ���n��
  CheckDiffDate(BDateCtl,EDateCtl,Msg) �Ƚ��������ڵĴ�С�������ʼ���ڴ��ڽ������ڣ�����false;
  DateToStr(dateObj) ��һ�����ڶ���ת��Ϊ��ʽyyyy-MM-dd�ַ���
  DateTimeToStr(dateObj) ��һ������ʱ�����ת��Ϊ����  yyyy-MM-dd HH:mm:ss ���ַ���
  StrToDate(str)  yyyy-MM-dd ���ַ���ת��Ϊ���ڶ���
  StrToDateTime(str)   ��һ��yyyy-MM-dd HH:mm:ss ���ַ���ת��Ϊ����ʱ�����
  StrToDateTime6P(year,month,day,hour,minute,second) ��һ���������ɵ�yyyy-MM-dd HH:mm:ss ���ַ���ת��Ϊ����ʱ�����
  IsDate(str) �ж�һ���ַ����Ƿ�Ϊ��Ч�����ڲ��Ҹ�ʽ�Ƿ���ȷ YYYY-MM-DD
  ----------------------------------------------------------




  *************************************************************
*/


var maxpn=999999999999;
var maxfn=999999999999.9;
var numerrormsg0="������0-999999999999֮�ڵ�����";
var numerrormsg1="������1-999999999999֮�ڵ�����";
var overerrormsg="��ֵ�������ֵ999999999999";




//�滻˫����Ϊ&quot;//
function ReplaceDoubleQuotes(strValue){
  return strValue.replace('"','&quot;');
}

//
//���FORM����������ؼ��Ƿ��зǷ��ַ�//
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
    alert("������������Ƿ��ַ�(��\", \', <, >)������!");
    edit.select();
    edit.focus();
    return false;
  }
    else
  continue;

 }//end of for
 return true;
}



//���������Ƿ�Ϊ0~9,a~z(A~Z),Del,-,.,/
//KeyDown ��Ч
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

//ȡ������
//eg. Round(132.123456) Ϊ 132.12
//eg. Round(132.123456,4) Ϊ 132.1234
//eg. Round(132.123456,0) Ϊ 132
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
����:�Զ������������ڼ������
��Ҫ��鿪ʼ�����Ƿ���ڽ�ֹ����,�������,����
����: start ��ʼ�����ַ��� end ��ֹ�����ַ���
*/
function GetDateDiff(strStart,strEnd)
{
    var start = strStart;
 var end = strEnd;
 if (StrToDate(start) > StrToDate(end))
 {
  alert("��ʼ���ڱ���С�ڽ�ֹ����!");return;
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
���ܣ� �õ�������������������ÿһ���°�30�죬һ��360����㣩 �ú�������ȷ
��ڲ�����
   datestartObj: ���ڶ���1
   dateendObj: ���ڶ���2
   ���� dateendObj - datestartObj�������� */
/*function GetDayDiff(datestartObj,dateendObj)
{
 var year=dateendObj.getFullYear() - datestartObj.getFullYear();
 var month=dateendObj.getMonth() - datestartObj.getMonth();
 var day=dateendObj.getDate() - datestartObj.getDate();
 return year*12*30+month*30+day;
}*/

/*
 ����:��������Ƿ��Ǹ���Ч���   */
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
  { alert('������Ϸ����!');return false;}
 }
 else
   return true;

}


/*  ���ܣ� ��һ�����ڼ���n��
 ��ڲ�����
   dateObj: Ҫ��������ڶ���
   days: ���ӵ�����
 ����  ���Ӻ�������ڶ��� */
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


/* ���ܣ� У��һ��������
��ڲ�����CheckCtl: ҪУ��������  disptext: ������ʾ����Ϣ IsCanZero : �Ƿ����Ϊ��
����:  ��: �������� ��: ����*/
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
//����������У��һ��������
function CheckPositiveIntNP()
{
   var o = event.srcElement;
   if (o)
   {
   if (o.tagName == "INPUT"  && !isNaN(parseFloat(o.value)) )
  return CheckPositiveInt(o,'������������!',true)
   else
  return true;

   }
   else
  return true;
}





/*���ܣ� У��һ���Ϸ��Ĵ��ڵ���0�ĸ�����
��ڲ�����
   CheckCtl: ҪУ��������      disptext: ������ʾ����Ϣ
   floatcount: С�������λ�������û�иò�������Ĭ��Ϊ4λ��
   ���û��page��������floatcunt�����򣺰�page ��null
   ��: CheckPositiveFloat(CheckCtl,"������ʾ����Ϣ",null,5)    */
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

   b=confirm("С��λ������"+limitcount+"λ,�Ƿ����?");
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

//��������У��һ���Ϸ��Ĵ��ڵ���0�ĸ�����(2λС��)
function CheckPositiveFloatNP()
{
   var o = event.srcElement;
   if (o)
   {
   if (o.tagName == "INPUT"  && !isNaN(parseFloat(o.value)) )
   return CheckPositiveFloat(o,'��������ȷ����Ŀ!',2);
   else
   return true;
   }
   else
  return true;
}

/*
   У��һ���Ϸ��Ĵ���0�ĸ�����
   ������CheckCtl: ҪУ��������
        disptext: ������ʾ����Ϣ
  IsCanZero:�Ƿ���Ե�����
  floatcount: С�������λ�������û�иò�������Ĭ��Ϊ4λ��
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
���������룬С��λΪ2λ���Ҳ��ܳ��������ֶ�money���ֵ
true: ��ȷ
*/
function IsCost(Costctrl)
{
if (Costctrl.value != "")
{
 if (IsNum(Costctrl,"�����������",2))
 {
   if (!CheckFloatRange(Costctrl,0,900337203685477.5807,"���ý�����Χ��"))
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

/*�ж��Ƿ������ֵĺ���
   ���룺txtctl   ������ı��ؼ� message  ��ʾ�Ĵ�����Ϣ
     floatcount: С�������λ�������û�иò�������Ĭ��Ϊ4λ��
  ����ֵ :�����ַ���true�����Ƿ���false
 ��: IsNum(txtctl,"������ʾ����Ϣ",5)  */
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
   alert("С��λ������"+limitcount+"λ!");
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
   ����:����Ƿ�Ϊ��,�����κβ���,������ΪText

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

/*���ܣ� У��һ��ֵ�Ƿ�Ϊ��
��ڲ�����CheckCtl: ҪУ�������� disptext: ������ʾ����Ϣ
false:Ϊ��
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




/*���ܣ� У��һ���Ϸ������ڹ涨��Χ�ڵ�����
��ڲ�����
   CheckCtl: ҪУ��������      Min:  ����
   Max:  ����
   Msg: ������ʾ����Ϣ  */

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
/*���ܣ� У��һ���Ϸ������ڹ涨��Χ�ڵĸ�����   ��ڲ�����
   CheckCtl: ҪУ��������      Min:  ����
   Max:  ����
   Msg: ������ʾ����Ϣ  */

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

/*���ܣ� У��һ���Ϸ������֤����(15,18λ)
��ڲ�����
   CheckCtl: ҪУ��������
   disptext: ������ʾ����Ϣ  */

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

//��ʾ��Ϣ
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
   ȥ���ո�ͬVBSCRIPT�е�trim
*/
function Trim(strSource)
{
 return  strSource.replace(/^\s*/,'').replace(/\s*$/,'');

}





 /*���ܣ� �Ƚ��������ڵĴ�С�������ʼ���ڴ��ڽ������ڣ�����false;
��ڲ�����
   BDate:��ʼ���������      EDate:�������������
   Msg: ������ʾ����Ϣ  */
function CheckDiffDate(BDate,EDate,Msg)
{
 if ( (!CheckEmpty(BDate,"�����뿪ʼʱ������ڣ�")) || (!CheckEmpty(EDate,"���������ʱ������ڣ�")) )
  return false;
 str = BDate.value;
 if(!IsDate(str)){DispMessage(BDate,"��ʼʱ������ڲ�����Ч������");return false;}
 aa = str.split("-");
 BYear = parseInt(aa[0],10);
 BMonth = parseInt(aa[1],10);
 BDay = parseInt(aa[2],10);
 str = EDate.value;
 if(!IsDate(str)){DispMessage(EDate,"����ʱ������ڲ�����Ч������");return false;}
 bb = str.split("-");
 EYear = parseInt(bb[0],10);
 EMonth = parseInt(bb[1],10);
 EDay = parseInt(bb[2],10);
 if(BYear<1900)
 {
  DispMessage(BDate,"���ڲ���С��1900�꣡");
  return false;
 }
 if(EYear<1900)
 {
  DispMessage(EDate,"���ڲ���С��1900�꣡");
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
���ܣ� ��һ�����ڶ���ת��Ϊ��ʽyyyy-MM-dd�ַ�����
dateObj ���ڶ���
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

/*���ܣ� ��һ������ʱ�����ת��Ϊ�ַ�����
  dateObj ���ڶ���
  ���أ�����  yyyy-MM-dd HH:mm:ss ���ַ���
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

/*���ܣ� �ַ���ת��Ϊ���ڶ���
  ���أ�  date ���ڶ���
 str yyyy-MM-dd ���ַ���
*/
 function StrToDate(str)
 {
 var date = new Date();
 date = Date.parse(str);
   if (isNaN(date)) {
   date = Date.parse(str.replace(/-/g,"/")); // ʶ�����ڸ�ʽ��YYYY-MM-DD
   if (isNaN(date)) date = 0;
   }
 date = new Date(date);
 return(date);
  }

/*���ܣ� ��һ���ַ���ת��Ϊ����ʱ�����
  ���أ�  date ���ڶ���
 str yyyy-MM-dd HH:mm:ss ���ַ���
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
   {alert('���ڸ�ʽ����ȷ��');}
   return datTmp;
}
/*���ܣ� ���ַ���ת��Ϊ����ʱ�����
  ���أ�  date ���ڶ���
 yyyy-MM-dd HH:mm:ss ���ַ���
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
   {alert('���ڸ�ʽ����ȷ��');}
   return datTmp;
}

/*
   �ж�һ���ַ����Ƿ�Ϊ��Ч�����ڲ��Ҹ�ʽ�Ƿ���ȷ YYYY-MM-DD
   ���� str:�������ִ�
   ����:����
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
  ����������ʽ�Ƿ����
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
 �ж��Ƿ�����ȷ�ĵ����ʼ���ַ
 ����: CheckCtl :Ҫ���������� s:����ʱ��Ҫ�������Ϣ
 true:�� false:��
*/
function IsEmail(CheckCtl, s) {
return IsValid(/^\s*\w+\@\w+(\.\w+)+\s*$/i, CheckCtl, s);
}

/*
 �ж��Ƿ�����ȷ�ĵ绰����
 �绰��������� ����, ( , ) , -  ��
 ����: CheckCtl :Ҫ���������� s:����ʱ��Ҫ�������Ϣ
 true:�� false:��
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
 �ж��Ƿ�����ĸ���
 ����: CheckCtl :Ҫ���������� s:����ʱ��Ҫ�������Ϣ
 true:�� false:��
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
 �ж��Ƿ������ֱ������
 ���ֺ����ֱ��������:
 ���ֱ�������  000000010 ,����������: -1290092 ,23.,.3456�����͵�ֵ,����������Ϊ����
 ����: CheckCtl :Ҫ���������� s:����ʱ��Ҫ�������Ϣ
 true:�� false:��
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
 �ж��Ƿ�����ȷ���û���
 �û���ֻ����СдӢ����ĸ�����������ֺ��»������
  ����: CheckCtl :Ҫ����������
  s:����ʱ��Ҫ�������Ϣ s=null or s="" ʱ��Ĭ�ϵ���ʾ��Ϣ
 true:�� false:��
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
    s = "�û���ֻ����СдӢ����ĸ�����������ֺ��»������!";
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
 *����  У���ı����������ݵķǷ��ַ�
 *��ڲ��� fld ҪУ��������
 *   invlid �Ƿ��ַ�����)
 *   msg ������ʾ����Ϣ
 *����  true �����Ƿ��ַ�����)
 *   false ������
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
 *����  �ж��Ƿ��ļ�·�����ļ���ͼ���ļ���·��������url����file:\\
 *��ڲ��� �ļ�·��
 *����  true ��
 *   false ��
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

