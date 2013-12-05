//指定页面区域内容导入Excel
function AllAreaExcel(id)
{
	var oXL = new ActiveXObject("Excel.Application");
	var oWB = oXL.Workbooks.Add();
	var oSheet = oWB.ActiveSheet;
	var sel=document.body.createTextRange();
	sel.moveToElementText(id);
	sel.select();
	sel.execCommand("Copy");
	oSheet.Paste();
	oXL.Visible = true;
}
//指定页面区域“单元格”内容导入Excel
function CellAreaExcel(tbID)
{
	var oXL = new ActiveXObject("Excel.Application");
	var oWB = oXL.Workbooks.Add();
	var oSheet = oWB.ActiveSheet;
	var Lenr = tbID.rows.length;
	for (i=0;i<Lenr;i++)
	{
		var Lenc = tbID.rows(i).cells.length;
		for (j=0;j<Lenc;j++)
		{
			oSheet.Cells(i+1,j+1).value = tbID.rows(i).cells(j).innerText;
		}
	}
	oXL.Visible = true;
}
//指定页面区域内容导入Word
function AllAreaWord(id)
{
	var oWD = new ActiveXObject("Word.Application");
	var oDC = oWD.Documents.Add("",0,1);
	var oRange =oDC.Range(0,1);
	var sel = document.body.createTextRange();
	sel.moveToElementText(id);
	sel.select();
	sel.execCommand("Copy");
	oRange.Paste();
	oWD.Application.Visible = true;
	//window.close();
}
function printme(printId)
{
	var print = this.document.getElementById(printId).innerHTML;
	print = print +"<link rel=\"stylesheet\" type=\"text/css\" href=\"css/css.css\" />";
	print = print +'<SCRIPT language=javascript> function printView(){hidden();document.all.WebBrowser.ExecWB(7,1); } ';
	print = print +' function print(){hidden();document.all.WebBrowser.ExecWB(6,6);}';
	print = print +' function pageSetup(){hidden();document.all.WebBrowser.ExecWB(8,1);}';
	print = print + 'function hidden(){document.all("printView").style.display="none"; document.all("print").style.display="none";  document.all("pageSetup").style.display="none";}<\/script>';
	print = print + "<OBJECT   classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2   height=21   id=WebBrowser   width=87></OBJECT> <input  id=printView name=Button   onClick=printView()   type=button   value=打印预览> <input  id = print name=Button   onClick=print()   type=button   value=直接打印>   <input  id = pageSetup name=Button   onClick= pageSetup()  type=button   value=页面设置>";
	var newWindow = window.open();
	newWindow.document.open("text/html");
	newWindow.document.write(print);
	newWindow.document.close();
}