document.write("<scr"+"ipt language=javascript  src=calendar.js></scr"+"ipt>");
function sqlcondition(tableId)
{
	var table=document.getElementById(tableId);
	//字段列表
	var fieldList=new Array();
	//查询数据字典
	var dictList=new Array();	
	//左边括号
	var leftBracketValue=new Array(new Array("",""),new Array("(","("),new Array("((","(("),new Array("(((","((("));
	//右边括号数组
	var rightBracketValue=new Array(new Array("",""),new Array(")",")"),new Array("))","))"),new Array(")))",")))"));
	//预算符
	var operationValue=new Array(new Array("=","等于"),new Array(">=","大于等于"),new Array(">","大于"),
	new Array("<=","小于等于"),new Array("<","小于"),new Array("<>","不等于"),new Array("like","包含"),
	new Array(" not like ","不包含"),new Array("is null","值为空"),new Array("is not null","值不为空"));
	//逻辑运算值
	var logicValue=new Array(new Array("",""),new Array("and","并且"),new Array("or","或者"));
	//已经选中值
	var leftValues=new Array();
	var rightValues=new Array();
	var operationValues=new Array();
	var logicValues=new Array();
	var fieldValues=new Array();
	var contentValues=new Array();	
	//根据字段名称取字段类型
	this.getDataType=function(fieldId)
	{		
		for (j=0;j<this.fieldList.length;j++)
		{
			if (this.fieldList[j][0]==fieldId)
			{
				return this.fieldList[j];
				break;
			}
		}		
	}
	//检查左右括号是否匹配
	this.checkBracket=function()
	{
				
		var leftbracket="";
		var rightbracket="";
		
		for(iloop=0;iloop<leftValues.length;iloop++)
		{
			leftbracket=leftbracket+leftValues[iloop];
		}	
		for(jloop=0;jloop<rightValues.length;jloop++) 
		{
			rightbracket=rightbracket+rightValues[jloop];
		}  
		if (leftbracket.length==rightbracket.length)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//创建单行的SQL语句
	this.buildOneSQLs=function(leftvalue,fieldbean,operationvalue,fieldcontext,rightvalue,logicvalue)
	{
		var rtnValue="";
		var fieldvalue="";		
		if (leftvalue!="")
		{
			rtnValue=rtnValue+" "+leftvalue;
		}	  
		if (fieldbean[4]!="")//需要处理子查询
		{
			var replacetext="";
			if (operationvalue=="is null")
			{
				replacetext=" is null";
			}
			else if (operationvalue=="is not null")
			{
				replacetext=" is not null";
			}
			else if (operationvalue="like")
			{
				replacetext=" like '%"+fieldcontext+"%'";
			}
			else if (operationvalue=" not like ")
			{
				replacetext=" not like '%"+fieldcontext+"%'";
			}
			else
			{
				if (fieldbean[2]=="varchar")
	  		{
	  			replacetext=operationvalue+"'"+fieldcontext+"'";
	  	  }
	  	  else if (fieldbean[2]=="date")
	  	  {
	  	  	replacetext=operationvalue+"'"+fieldcontext+"'";
	  	  }
	  	  else
	  	  {
	  	  	replacetext=operationvalue+fieldcontext;
	  	  }	  	  
			}
			var temp=fieldbean[4];
			temp.replace(":VAR_VALUE",replacetext);
			rtnValue=rtnValue+" ( "+temp+" ) "
		}
		else //不需要子查询的处理
		{
			if (operationvalue=="is null")
	  	{
	  		if (fieldbean[2]=="varchar")//对字符需要添加为空的判断
	  		{
	  			rtnValue=rtnValue+"(("+fieldbean[0]+" is null) or ("+fieldbean[0]+"=''))";	  			
	  		}
	  		else
	  		{
	  			rtnValue=rtnValue+" "+fieldbean[0]+" is null ";
	  		}	  		
	  		
	  	}
	  	else if (operationvalue=="is not null")//对值不为空的处理
	  	{
	  		if (fieldbean[2]=="varchar")
	  		{
	  			rtnValue=rtnValue+" (("+fieldbean[0]+" is not null) and ("+fieldbean[0]+"<>''))";	  			
	  		}
	  		else
	  		{
	  			rtnValue=rtnValue+" "+fieldbean[0]+" is not null ";
	  		}
	  	}
	  	else
	  	{	  	
	  		
	  		if (fieldcontext=="")//没有字段内容不参与生成SQL语句的运算
	  		{	
	  			alert("字段内容为空");  			
	  			return "";
	  		}
	  		else
	  		{	
	  			if (operationvalue=="like")//包含的处理
	  			{
	  				rtnValue=rtnValue+" "+fieldbean[0]+" like '%"+fieldcontext+"%'";	  		
	  			}
	  			else if (operationvalue==" not like ")//包含的处理
	  			{
	  				rtnValue=rtnValue+" "+fieldbean[0]+" not like '%"+fieldcontext+"%'";	  		
	  			}
	  			else
	  			{
	  				if (fieldbean[2]=="varchar")
	  				{
	  					rtnValue=rtnValue+" "+fieldbean[0]+operationvalue+"'"+fieldcontext+"'";
	  	  		}
	  	  		else if (fieldbean[2]=="date")
	  	  		{
	  	  			rtnValue=rtnValue+" "+fieldbean[0]+operationvalue+"'"+fieldcontext+"'";
	  	  		}
	  	  		else
	  	  		{
	  	  			rtnValue=rtnValue+" "+fieldbean[0]+operationvalue+fieldcontext;
	  	  		}
	  	  	}	  	  
	  		}
	  	}
	  	if (rightvalue!="")
	  	{
	  		rtnValue=rtnValue+rightvalue;
	  	}
	  	if (logicvalue!="")
	  	{
	  		rtnValue=rtnValue+logicvalue;
	  	}
		}
		return rtnValue;
	}	
	//构建SQL语句方法
	this.generateStatement=function()
	{

		var sqlStatement="";	
		if (!this.checkBracket())
		{
			alert("左右括号不匹配，请检查括号的输入！");
			return "";
		}	
		
		for (i=0;i<fieldValues.length;i++)
		{
		  
			if (fieldValues[i]!=""&&operationValues[i]!="")//字段名称不为空时开始处理
			{			
				fieldBean=this.getDataType(fieldValues[i]);
	
				contentValues[i]=document.getElementById('content'+i).value;
				sqlStatement=sqlStatement+
				this.buildOneSQLs(leftValues[i],fieldBean,operationValues[i],contentValues[i],rightValues[i],logicValues[i]);	
			}
			
		}
		//alert(sqlStatement);
		return sqlStatement;
	}
	
	
	//窗口刷新事件
	window.onresize =function()
	{
			
		for (i=1;i<table.rows.length;i++)
		{
			var currentrow=table.rows[i];
			for (j=0;j<currentrow.cells.length;j++)
			{
				var obj=currentrow.cells[j].children[0];	
					var elementwidth=table.rows[i].cells[j].clientWidth -4;						
					 obj.style.width=elementwidth;				
			}			
		}
		table.refresh();
		
	}
	//设置字段列表
	this.setFieldList=function(fieldList)
	{	
		this.fieldList=fieldList;	
	}
	//创建新的字段bean;
	this.newFieldbean=function(engName,chinaName,fieldType,dicttype,condition)
	{
		var fieldBean=new Array(5);		
		fieldBean[0]=engName;		
		fieldBean[1]=chinaName;		
		fieldBean[2]=fieldType;	
		fieldBean[3]=dicttype;		
		fieldBean[4]=condition;
		return fieldBean;
	}
	//创建新的字典bean
	this.newDictBean=function(dicttype,codeValue,codeName)
	{
		var dictBean=new Array(3);
		dictBean[0]=dicttype;
		dictBean[1]=codeValue;
		dictBean[2]=codeName;
		return dictBean;
				
	}
	//添加单个字段
	this.appendField=function(fieldBean)
	{
		this.fieldList[this.fieldList.length]=fieldBean;	
	}
	//设置字典数据列表
	this.setDictList=function(dictList)
	{
		this.dictList=dictList;		
	}
	//添加单个数据字典
	this.appendDict=function(dictBean)
	{
		this.dictList[this.dictList.length]=dictBean;
	}	

	//删除所有行
	this.deleteAllRows=function()
	{
		var rowcount=table.rows.length;
		if (rowcount>0)
		{		
			for (i=rowcount -1;i>=0;i--)
			{
				table.deleteRow(i)
			}
		}
	}
	//删除指定索引的行
	this.deleteRow=function(rowIndex)
	{
		if (rowIndex==-1)
			return ;
		var rowcount=table.rows.length;
		if (rowcount>rowIndex)
		{
			table.deleteRow(rowIndex);			
		}
		else
		{
			alert("传入错误的行索引号")
		}
	}
		//初始化标题,第一样条件
	this.initHeader=function()
	{
		table.style.borderColor="#9FD6FF";
		var header=table.insertRow(0);
		//标题背景图片
		header.style.backgroundImage="url(images/title_04.gif)";
		header.height=23;		
		var leftBracketHeader=header.insertCell(header.cells.length);
		leftBracketHeader.ALIGN="center";
		leftBracketHeader.width="10%";				
		leftBracketHeader.innerText="左括号";
		leftBracketHeader.style.borderColor="#9FD6FF";		
		var fieldNameHeader=header.insertCell(header.cells.length);
		fieldNameHeader.ALIGN="center";
		fieldNameHeader.width="25%";	
		fieldNameHeader.innerText="字段名称";
		fieldNameHeader.style.borderColor="#9FD6FF";
	  var operationHeader=header.insertCell(header.cells.length);
		operationHeader.ALIGN="center";
		operationHeader.width="15%";		
		operationHeader.innerText="运算符";		
		operationHeader.style.borderColor="#9FD6FF";
		var fieldContextHeader=header.insertCell(header.cells.length);
		fieldContextHeader.ALIGN="center";
		fieldContextHeader.width="30%";		
		fieldContextHeader.innerText="字段内容";	
		fieldContextHeader.style.borderColor="#9FD6FF";
		var rightBracketHeader=header.insertCell(header.cells.length);
		rightBracketHeader.ALIGN="center";
		rightBracketHeader.width="10%";		
		rightBracketHeader.innerText="右括号";
		rightBracketHeader.style.borderColor="#9FD6FF";
		var logicHeader=header.insertCell(header.cells.length);
		logicHeader.ALIGN="center";
		logicHeader.width="10%";		
		logicHeader.innerText="逻辑";	
		logicHeader.style.borderColor="#9FD6FF";
		this.insertRow();	
		
		
	}
	this.insertRow=function()
	{
		var row=table.insertRow(table.rows.length);
		row.height=20;
		//新增左括号
		var leftBracket=row.insertCell(row.cells.length);
		leftBracket.ALIGN="center";
		leftBracket.width="10%";
		leftBracket.setAttribute("class",this.titleStyle);			
		leftBracket.appendChild(this.newLeftSelect());
		leftBracket.style.borderColor="#9FD6FF";
		//新增字段列表
		var fieldsSelect=row.insertCell(row.cells.length);
		fieldsSelect.ALIGN="center";
		fieldsSelect.width="10%";
		fieldsSelect.setAttribute("class",this.titleStyle);			
		fieldsSelect.appendChild(this.newFieldSelect(this.fieldList,this));				
		fieldsSelect.style.borderColor="#9FD6FF";
		//新增运算符
		var operationSelect=row.insertCell(row.cells.length);
		operationSelect.ALIGN="center";
		operationSelect.width="15%";
		operationSelect.setAttribute("class",this.titleStyle);		
		operationSelect.appendChild(this.newOperationSelect());		
		operationSelect.style.borderColor="#9FD6FF";		
		//新增字段内容输入
		var contextInput=row.insertCell(row.cells.length);
		contextInput.ALIGN="center";
		contextInput.width="10%";
		contextInput.setAttribute("class",this.titleStyle);			
		contextInput.appendChild(this.newContentInput(this.dictList,this.fieldList,table.rows.length -2));				
		contextInput.style.borderColor="#9FD6FF";	
				
		//新增右括号
		var rightBracket=row.insertCell(row.cells.length);
		rightBracket.Align="center";
		rightBracket.width="10%";
		rightBracket.setAttribute("class",this.titleStyle);	
		rightBracket.appendChild(this.newRightSelect());
		rightBracket.style.borderColor="#9FD6FF";		
		//新增逻辑关系
		var logicSelect=row.insertCell(row.cells.length);
		logicSelect.Align="center";
		logicSelect.width="10%";
		logicSelect.setAttribute("class",this.titleStyle);	
		logicSelect.appendChild(this.newLogicSelect(this));
		logicSelect.style.borderColor="#9FD6FF";		
		//alert(table.innerHTML);
		//设置输入框的宽度
		for (i=1;i<table.rows.length;i++)
		{
			var currentrow=table.rows[i];
			for (j=0;j<currentrow.cells.length;j++)
			{
				var obj=currentrow.cells[j].children[0];	
					var elementwidth=table.rows[i].cells[j].clientWidth -4;						
	
					  obj.style.width=elementwidth;				
			}			
		}
		table.refresh();		
	}

	//创建字段内容输入框
	this.newContentInput=function(dictList,fieldList,rowIndex)	
	{		
		if (fieldValues.length<rowIndex)
		{			
			return;				
		}	
		fieldId=fieldValues[rowIndex];		
		var dictType="";
		var dataType="";
		for (i=0;i<fieldList.length;i++)
		{
			if (fieldList[i][0]==fieldId)
			{
				dictType=fieldList[i][3];
				dataType=fieldList[i][2];
			}
		}
		//有数据字典指定的，需要创建下拉类表框
		if (dictType!="")
		{			
			var dictSelect=document.createElement("Select");
		  dictSelect.id="content"+rowIndex;
		  /*新增一个空的值*/
		  var nulloption=document.createElement("Option");
		  dictSelect.options.add(nulloption);		
		  nulloption.innerText="";
		  nulloption.value="";	
		  for (j=0;j<dictList.length;j++)
		  {
		  	if (dictList[j][0]==dictType)
		  	{		  		
		  		var ooption=document.createElement("Option");
					dictSelect.options.add(ooption);			
					ooption.innerText=dictList[j][2];
					ooption.value=dictList[j][1];		
					if (j==0)
					{
						if (contentValues.length<rowIndex)
						{
							contentValues[rowIndex]=ooption.value;
						}
						else
						{
							contentValues[rowIndex]=ooption.value;
						}
					}
		  	}	
		  }		 
		  //给查询内容数组设置值
		  dictSelect.onchange=function()
		  {
		  	if (contentValues.length<rowIndex)
				{
					contentValues[rowIndex]=dictSelect.value;								
				}
				else
				{
					contentValues[rowIndex]=dictSelect.value;								
				}
		  }		  
		  return dictSelect;
		}
		else
		{
			var inputBox=document.createElement("Input");
			inputBox.id="content"+(rowIndex);
			inputBox.type="text";		
			if (dataType=="date")//日期输入框
			{				
				inputBox.onfocus=function()
				{					
					calendar();					
				}					
			}
			else if (dataType=="integer")//整数输入框
			{				
				inputBox.onkeypress=function()
				{
					if(event.keyCode<45||event.keyCode>57)
					{
						 event.returnValue=false;
					} 
					else
					{
						if (event.keyCode==46||event.keyCode==47)
						{
							event.returnValue=false;
						}
					}
				}				
			}
			else if (dataType=="float")//浮点数据输入
			{
				inputBox.onkeypress=function()
				{
					if(event.keyCode<45||event.keyCode>57)
					{
						 event.returnValue=false;
					} 
					else
					{
						if (event.keyCode==47)
						{
							event.returnValue=false;
						}
					}
				}				
			}
			else
			{
				inputBox.onkeypress=function()
				{
					event.returnValue=true;
				}
			}
			//在焦点失去事件中，设置值数组
			inputBox.onblur=function()
			{
			
				if (contentValues.length<rowIndex)
				{
					contentValues[rowIndex]=inputBox.value;					
				}
				else
				{
					contentValues[rowIndex]=inputBox.value;					
				}
				
			}
		
			return inputBox;
		}			
	}
	//创建字段
	this.newFieldSelect=function(fieldList,obj)
	{
		var fieldSelect=document.createElement("Select");
		fieldSelect.id="fields"+(table.rows.length -1);	
		for (i=0;i<fieldList.length;i++)
		{
			var ooption=document.createElement("Option");
			fieldSelect.options.add(ooption);			
			ooption.innerText=fieldList[i][1];
			ooption.value=fieldList[i][0];
			if (i==0)
			{
				fieldValues[table.rows.length -2]=fieldList[i][0];
				leftValues[table.rows.length -2]="";
				operationValues[table.rows.length -2]="=";
				rightValues[table.rows.length -2]="";
				logicValues[table.rows.length -2]="";
				contentValues[table.rows.length -2]="";
			}			
		}	
		fieldSelect.onchange=function()
		{
			str=fieldSelect.id;
			rowIndex=str.substring(6,8);
			rownum=parseInt(rowIndex -1,10);
			if (fieldValues.length<rownum+1)
			{
				fieldValues[rownum]=fieldSelect.value;				
			}
			else
			{
				fieldValues[rownum]=fieldSelect.value;		
			}					
			table.rows[rownum+1].cells[3].removeChild(table.rows[rownum+1].cells[3].children[0]);
			table.rows[rownum+1].cells[3].appendChild(obj.newContentInput(obj.dictList,fieldList,rownum));			
			var elementwidth=table.rows[rownum+1].cells[3].clientWidth -4;			
			table.rows[rownum+1].cells[3].children[0].style.cssText="width:"+elementwidth
		}
		return fieldSelect;
	}
	
	//创建左括号
	this.newLeftSelect=function()
	{				
		var leftSelect=document.createElement("Select");		  			
		leftSelect.id="leftselect"+(table.rows.length -1);	
		for (i=0;i<leftBracketValue.length ;i++)
		{					
			var ooption=document.createElement("Option");
			leftSelect.options.add(ooption);
			ooption.innerText =leftBracketValue[i][0];
			ooption.value = leftBracketValue[i][1];			
		}
		leftSelect.onchange=function()
		{
			str=leftSelect.id;			
			rowindex=str.substring(10,13);
			rownum=parseInt(rowindex -1,10);			
			if (leftValues.length<rownum+1)
			{
				leftValues[rownum]=leftSelect.value;					
			}	
			else
			{
				leftValues[rownum]=leftSelect.value;												
			}	
		}
		return leftSelect;		
	}
	//创建右括号
	this.newRightSelect=function()
	{
		var rightSelect=document.createElement("Select");
		rightSelect.id="rightselect"+(table.rows.length -1);
		for (i=0;i<rightBracketValue.length;i++)
		{
			var ooption=document.createElement("Option");
			rightSelect.options.add(ooption);
			ooption.innerText=rightBracketValue[i][0];
			ooption.value=rightBracketValue[i][1];
		}		
		rightSelect.onchange=function()
		{			
			str=rightSelect.id;			
			rowindex=str.substring(11,13);
			rownum=parseInt(rowindex -1,10);			
			if (rightValues.length<rownum+1)
			{
				rightValues[rownum]=rightSelect.value;	
			}	
			else
			{
				rightValues[rownum]=rightSelect.value;	
			}	
		}
		return rightSelect;				
	}
//创建运算符
	this.newOperationSelect=function()
	{
		var operationSelect=document.createElement("Select");
		operationSelect.id="operation"+(table.rows.length -1);
		for (i=0;i<operationValue.length;i++)
		{
			var ooption=document.createElement("Option");
			operationSelect.options.add(ooption);
			ooption.innerText=operationValue[i][1];
			ooption.value=operationValue[i][0];
		}
		//运算符的选中时间
		operationSelect.onchange=function()
		{
			str=operationSelect.id;			
			rowindex=str.substring(9,11);
			rownum=parseInt(rowindex -1,10);		
			if (operationValue.length<rownum+1)
			{
				operationValues[rownum]=operationSelect.value;				
			}
			else
			{
				operationValues[rownum]=operationSelect.value;				
			}
			
		}
		return operationSelect;				
	}	
//创建逻辑运算符
	this.newLogicSelect=function(obj)
	{
		var logicSelect=document.createElement("Select");
		logicSelect.id="logic"+(table.rows.length -1);
		for (i=0;i<logicValue.length;i++)
		{
			var ooption=document.createElement("Option");
			logicSelect.options.add(ooption);
			ooption.innerText=logicValue[i][1];
			ooption.value=logicValue[i][0];
		}
		//逻辑运算符号的选中事件
		logicSelect.onchange=function()
		{
			str=logicSelect.id;			
			rowindex=str.substring(5,7);
			rownum=parseInt(rowindex -1,10);			
			if (logicValues.length<rownum+1)
			{
				logicValues[rownum]=logicSelect.value;							
			}	
			else
			{
				logicValues[rownum]=logicSelect.value;								
			}			
			if (table.rows.length<=rownum+2)
			{
				obj.insertRow();	
			}			
		}
		return logicSelect;				
	}		
}
