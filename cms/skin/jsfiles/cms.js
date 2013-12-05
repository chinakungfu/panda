/**
用于选择某一结点为另一结点的父结点
**/
function selectNodeId(value)
{
	document.all.parentId.value = value;
}
/**
弹出权重窗口
**/
function openSortNode(url)
{
	window.open (url, '结点排序', 'height=150, width=300, top=300, left=300, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=n o, status=no');
}
/**
弹出移动结点窗口
**/
function openMoveNode(url)
{
	window.open (url, '结点操作', 'height=300, width=400, top=300, left=300, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=n o, status=no');
}
/**
对select默认选中的操作
**/
function jsSelectValue(selectId,objItemValue)
{
	//判断是否存在
	var selectObj = document.getElementById(selectId);
	var isExit = false;
	for(var i=0;i<selectObj.options.length;i++)
	{
		if(selectObj.options[i].value == objItemValue)
		{
			selectObj.options[i].selected = true;
			isExit = true;
			break;
		}
	}
}
/**
对radio默认选中的操作
**/
function radioIsSelected(radioId,radioValue) {
	var i,myObj;
	var myObj= document.getElementsByTagName("input");

	for(i=0;i<myObj.length;i++)
	{
		if(myObj[i].type=='radio'&&myObj[i].id==radioId)
		{
			if(myObj[i].value==radioValue)
			{
				myObj[i].checked = true;
				break;
			}
		}
	}
}
/**
对checkBox默认选中的操作
**/
function checkBoxIsSelected(checkboxName,checkboxValue)
{
	var i,ckbObj;
	ckbObj=document.getElementsByName(checkboxName);
	for(i=0;i<ckbObj.length;i++)
	{
		if(checkboxValue.indexOf(ckbObj[i].value)>=0)
		{
			ckbObj[i].checked = true;
		}
	}
}
/**
对checkBox选取操作
**/
function selectCheckBox(obj)
{
	var i,hidObj,value;
	value = obj.value;
	hidObj=document.getElementById(obj.name);
	if(hidObj.value.indexOf(value)<0)
	{
		if(obj.checked){
			hidObj.value = hidObj.value+','+value;
		}else{
			hidObj.value = hidObj.value.replace((new RegExp("^"+value+",")),'');
			hidObj.value = hidObj.value.replace((new RegExp(","+value+",")),',');
		}
	}else
	{
		hidObj.value = hidObj.value.replace(value,"");
	}
	hidObj.value = hidObj.value.replace(",,",",");
}
/**
弹出颜色对话框函数
**/
function callColorDlg(objId,sInitColor){
	if ((sInitColor == null)&&(sInitColor.indexOf('#')<1)) {
		var sColor = dlgHelper.ChooseColorDlg();
	}else{
		var sColor = dlgHelper.ChooseColorDlg(sInitColor);
	}
	sColor = sColor.toString(16);
	if (sColor.length < 6) {
		var sTempString = "000000".substring(0,6-sColor.length);
		sColor = sTempString.concat(sColor);
	}
	sColor = "#" + sColor
	document.getElementById(objId).value=sColor;//颜色应用
}

/**
改select值时，把选中的值输入到一个text框中
**/
function changeSelect(name,value)
{
	var txt = document.getElementById(name);
	txt.value = value;
}
/**
checkbox选择
*/
function checkBoxSelect(cheId,chksName,inputSel){
	var chkall= document.getElementById(cheId);
	var chkother= document.getElementsByTagName("input");
	var inputSelObj = document.getElementById(inputSel);
	var value = '';
	for (var i=0;i<chkother.length;i++)
	{
		if( chkother[i].type=='checkbox'&&chkother[i].name==chksName)
		{
			if(chkall.checked==true)
			{
				value = chkother[i].value+','+value
				chkother[i].checked=chkall.checked;
			}else
			{
				chkother[i].checked="";
			}
		}
	}
	inputSelObj.value = value;
}
/**
当前列表全选操作
**/
function selectAll(objId,cheId,chksName)
{	
	var obj = document.getElementById(objId);//文本
	var objAll = document.getElementById(cheId);//全选或反选
	//var chks=document.getElementsByName(chksName);
	var con = '';
	var browsType = getOs();
	if(browsType=='Firefox')
	{
		var allText = obj.textContent;
		if(obj.textContent == '反选')
		{
			obj.textContent = '全选';
			objAll.checked = false;
			checkBoxSelect(cheId,chksName,'selectConId')
		}else
		{
			obj.textContent = '反选';
			objAll.checked = true;
			checkBoxSelect(cheId,chksName,'selectConId')
		}
	}else
	{
		if(obj.innerText == '反选')
		{
			obj.innerText = '全选';
			objAll.checked = false;
			checkBoxSelect(cheId,chksName,'selectConId')
		}else
		{
			obj.innerText = '反选';
			objAll.checked = true;
			checkBoxSelect(cheId,chksName,'selectConId')
		}
	}
}
/**
当前列表单选
**/
function selectConCheck(chksName)
{
	var chkother= document.getElementsByTagName("input");
	var inputSelObj = document.getElementById('selectConId');
	var value = '';
	for (var i=0;i<chkother.length;i++)
	{
		if( chkother[i].type=='checkbox'&&chkother[i].name==chksName)
		{
			if(chkother[i].checked==true)
			{
				value = chkother[i].value+','+value
			}else
			{
				chkother[i].checked="";
			}
		}
	}
	inputSelObj.value = value;
}
/**
上传资源是用的
**/
function submitHead(url,id)
{
	window.open(url+'&resourceUrl='+id, '上传资源', 'height=400, width=500, top=100, left=100, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=n o, status=no');
}
/**
提取宏变量
**/
function getMacroVar(value)
{
	var textAreaObj = document.getElementById('fileFormat');
	textAreaObj.focus();
	value = "{"+value+"}";
	if(navigator.userAgent.indexOf("Mozilla/5.")>-1)//判断是ff
	{
		var oValue = textAreaObj.value;
		var iStart = textAreaObj.selectionStart;
		var fValue = oValue.substring(0,iStart);
		var eValue = oValue.substr(textAreaObj.selectionStart);
		textAreaObj.value = fValue + value + eValue;
		textAreaObj.selectionStart = iStart;
		textAreaObj.selectionEnd = iStart;
	}
	if(navigator.userAgent.search("MSIE")>0)//判断是IE
	{
		document.selection.createRange().text += value;
		textAreaObj.blur();
		textAreaObj.focus();
	}
	if(navigator.userAgent.search("Opera")>-1)
	{
		return "Opera";
	}
}
/**
取得格式化的文件名
**/
function getFileFormat(id)
{
	var backObj = opener.document.getElementById(id);
	var textAreaObj = document.getElementById('fileFormat');
	if(textAreaObj.value.indexOf('.html')<0)
	{
		var value = textAreaObj.value+".html";
	}else
	{
		var value = textAreaObj.value;
	}
	backObj.value = value;
	window.close();

}
function insetSymbol(elementId,Symbol)
{
	oTextarea = document.getElementById(elementId);
	oTextarea.focus();

	if(cb == "IE")
	{
		document.selection.createRange().text += Symbol;
		oTextarea.blur();
		oTextarea.focus();
	}
	else if(cb == "FF")
	{
		var oValue = oTextarea.value;
		var iStart = oTextarea.selectionStart;
		var fValue = oValue.substring(0,iStart);
		var eValue = oValue.substr(oTextarea.selectionStart);
		oTextarea.value = fValue + Symbol + eValue;
		oTextarea.selectionStart = iStart;
		oTextarea.selectionEnd = iStart;
	}
}
//获取要导出的结点的ID号
function selectExportNode(nodeId,value)
{
	var multNodeId = document.getElementById('multNodeId');
	var nodeId = document.getElementById('checkbox'+value);
	if(nodeId.checked)
	{
		if(multNodeId.value!='')
		{
			multNodeId.value = multNodeId.value+nodeId.value+',';
		}else
		{
			multNodeId.value = nodeId.value+',';
		}
	}else
	{
		multNodeId.value = replaceAll(multNodeId.value, nodeId.value+',', '')
	}
}
//替换字符串
function replaceAll(str, sptr, sptr1)
{
	while (str.indexOf(sptr) >= 0)
	{
		str = str.replace(sptr, sptr1);
	}
	return str;
}
function checkStatus(no,chkBox){
	checkPar(chkBox);//当子目录选中时,父目录也选中
	var chks = document.getElementsByTagName('input');//得到所有input
	for(var i=0;i <chks.length;i++){
		if(chks[i].name.toLowerCase() == 'check'){//得到所名为check的input
			if(chks[i].className == no){//ID等于传进父目录ID时
				chks[i].checked = chkBox.checked;//保持选中状态和父目录一致
				checkStatus(chks[i].value,chks[i]);//递归保持所有的子目录选中
			}
		}
	}
}

function checkPar(chkBox) {
	if(chkBox.name.toLowerCase() == 'check' && chkBox.checked && chkBox.className != 0) {//判断本单击为选中,并且不是根目录,则选中父目录
		var chkObject = document.getElementById("checkbox"+chkBox.className);//得到父目录对象
		chkObject.checked=true;
		checkPar(chkObject);
	}
}

function checkBox()
{
	var chks=document.getElementsByName("check");
	var con = '';
	for(i=0;i<chks.length;i++)
	{
		if(chks[i].checked)
		{
			con = con+chks[i].value+",";
		}
	}
	document.getElementById('multNodeId').value=con;
}
function searchNode(type)
{
	var field = document.all.field.value;
	var con = document.all.con.value;
	var method = document.all.method.value;
	var sqlCon = field+" like '%"+con+"%'";
	if(con!='')
	{
		call_tpl('cms','searchNode','searchBackNodeInfo(\'searchResult\')','return',sqlCon,method,type,'');
		//	call_tpl('staff','checkData','backData(\'StaffNoMessage\')','return',document.forms[0].staffId.value,document.forms[0].StaffNo.value,'[$method]','');
	}else
	{
		var div = document.getElementById('searchResult');
		div.style.display = "none";
		div.innerHTML = "";
	}
}
//查看首页
function viewIndex(url)
{
	window.open (url, '查看首页', 'height=600, width=800, top=200, left=200, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=n o, status=no');
}
//新建文档函数
function openNewDoc(url)
{
	window.open (url, '新建文档', 'height=600, width=800, top=200, left=200, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=n o, status=no');
}
//结点更新函数
function openNodeUpdate(url)
{
	window.open (url, '结点更新', 'height=300, width=400, top=300, left=300, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=n o, status=no');
}
//结点发布函数
function openNodePublish(url)
{
	window.open (url, '结点发布', 'height=300, width=400, top=300, left=300, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=n o, status=no');
}
function changeDisplayData(value)
{
	var staticPublish = document.getElementById('staticPublish');
	var dynamicPublish = document.getElementById('dynamicPublish');

	if(value=='1')
	{
		staticPublish.style.display = "";
		dynamicPublish.style.display = "none";
	}else if(value=='2')
	{
		staticPublish.style.display = "none";
		dynamicPublish.style.display = "";
	}else
	{
		staticPublish.style.display = "none";
		dynamicPublish.style.display = "none";
	}
}
/*
* 预提交处理
*
* FormName:表单名
* SelectElement:源select框
* SubmitElement:待提交的表单框
*/
function select_submit(FormName, SelectElement, SubmitElement) {
	//eval("var iSelectElement= document." + FormName+ "." + SelectElement);
	//eval("var iSubmitElement = document." + FormName+ "." + SubmitElement);
	var iSelectElement= document.getElementById(SelectElement);
	var iSubmitElement= document.getElementById(SubmitElement);
	var returnValue = "";
	for (var i=0; i<iSelectElement.options.length; i++)  {
		if(i==0) {
			returnValue = iSelectElement.options[i].value;
		} else {
			returnValue += "," + iSelectElement.options[i].value;

		}
	}
	iSubmitElement.value = returnValue;
}
/*
* 移动某个选项
*
* FormName:表单名
* ElementFrom:源select框
* ElementTo:目标select框
*/
function select_move_to(FormName, ElementFrom, ElementTo) {
	//eval("var sFrom = FormName." + ElementFrom);
	//eval("var sTo = FormName." + ElementTo);
	var sFrom = document.getElementById(ElementFrom);
	var sTo = document.getElementById(ElementTo);

	if(sFrom.selectedIndex >= 0) {
		sTo.options.add(new Option(sFrom.options[sFrom.selectedIndex].text, sFrom.options[sFrom.selectedIndex].value));
		//sFrom.options[sFrom.selectedIndex].removeNode(true);
		sFrom.remove(sFrom.selectedIndex);//ie ff
	}
}


/*
* 移动所有选项
*
* FormName:表单名
* ElementFrom:源select框
* ElementTo:目标select框
*/
function select_move_all_to(FormName, ElementFrom, ElementTo) {
	//eval("var sFrom = FormName." + ElementFrom);
	//eval("var sTo = FormName." + ElementTo);
	var sFrom = document.getElementById(ElementFrom);
	var sTo = document.getElementById(ElementTo);
	for (var i=0; i<sFrom.options.length; i++)
	sTo.options.add(new Option(sFrom.options[i].text, sFrom.options[i].value));
	sFrom.options.length = 0;
}

//判断浏览器
function getOs() 
{ 
    var OsObject = ""; 
   if(navigator.userAgent.indexOf("MSIE")>0) { 
        return "MSIE"; 
   } 
   if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){ 
        return "Firefox"; 
   } 
   if(isSafari=navigator.userAgent.indexOf("Safari")>0) { 
        return "Safari"; 
   }  
   if(isCamino=navigator.userAgent.indexOf("Camino")>0){ 
        return "Camino"; 
   } 
   if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){ 
        return "Gecko"; 
   } 
   
}
//结点相关字段
function fieldRelMoveUp(objId)
{
	var obj = document.getElementById(objId);
	with (obj){
		try {
			if(selectedIndex==0){
				options[length]=new Option(options[0].text,options[0].value)
				options[0]=null
				selectedIndex=length-1
				}
			else if(selectedIndex>0) fieldRelMoveG(obj,-1)		
		}catch(e) {
		
		}
		
	}
}
function fieldRelMoveDown(objId)
{
	var obj = document.getElementById(objId);
	with (obj){
		try {
			if(selectedIndex==length-1){
				var otext=options[selectedIndex].text
				var ovalue=options[selectedIndex].value
				for(i=selectedIndex; i>0; i--){
					options[i].text=options[i-1].text
					options[i].value=options[i-1].value
				}
				options[i].text=otext
				options[i].value=ovalue
				selectedIndex=0
				}
			else if(selectedIndex<length-1) fieldRelMoveG(obj,+1)		
		} catch(e) {
		
		}
 
	}
}
function fieldRelMoveG(obj,offset)
{
	with (obj){
		desIndex=selectedIndex+offset
		var otext=options[desIndex].text
		var ovalue=options[desIndex].value
		options[desIndex].text=options[selectedIndex].text
		options[desIndex].value=options[selectedIndex].value
		options[selectedIndex].text=otext
		options[selectedIndex].value=ovalue
		selectedIndex=desIndex
	}
}

function fieldRelDel(objId) 
{
	var obj = document.getElementById(objId);
	with(obj) {
		try {
			options[selectedIndex]=null
			selectedIndex=length-1		
		} catch(e) {
		
		}
 
 
	}
 
}
function fieldRelAdd(fieldName, param_index_id,param_title) {
	eval("obj = document.FM.data_" + fieldName);
	with(obj) {
		length=obj.length
		/*if(data.length > 24) {
			var data1 = "..." + data.substr(data.length-24 ,24)
		} else {
			var data1 = data
		}*/
 
		options[length]=new Option(param_title,param_index_id)
		
	}
	
}

function fieldRelEditContentLink(url)
{
 
 		var leftPos = screen.availWidth / 2 
		var topPos = screen.availHeight / 2 
		var MyWIN = window.open(url,'','width=650,height=380,scrollbars=no,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
		//window.open("admin_publish.php?sId=" + sId + "&o=editContentLink&extra=ui_init&IndexID=" + IndexID + "&fieldName=" + fieldName + "&NodeID=" + NodeID);
 
 
}

function fieldRelGoSelect(obj)
{
	try {
		with (obj){
			var IndexID = options[selectedIndex].value;
			window.open("admin_publish.php?sId=" + sId + "&o=viewpublish&IndexID=" + IndexID + "&NodeID=" + NodeID,'')
			
		}	
	} catch(e) {
	
	}
 
 
}

function addCustomLinks(fieldName,value,text){

	var oField=document.getElementById(fieldName);
	if((new RegExp(','+value+',')).test(','+oField.value+',')) return;
	
	var oSelect=document.getElementById('CustomLinks_'+fieldName);
	if(oField.value){
		oField.value += ','+value;
	}else{
		oField.value  = value;
	}
	
	oSelect.options[oSelect.options.length]=new Option(text,value);
}

function fieldRelDel(oStr){
	var oSelect=document.getElementById(oStr);
	if(oSelect.selectedIndex<0){
		alert("Select item when your delete.");
		return;
	}
	var fieldName=oStr.replace(/^CustomLinks_/,'');
	var oField=document.getElementById(fieldName);
	
	if(/,/.test(oField.value)){
		oField.value=oField.value.replace(new RegExp('(^'+oSelect.value+',)|(,'+oSelect.value+'$)'),'');
		oField.value=oField.value.replace(new RegExp(','+oSelect.value+','),',');
		oSelect.options[oSelect.selectedIndex] = null;
	}else{
		oField.value="";
		oSelect.options[oSelect.selectedIndex] = null;
	}

}

