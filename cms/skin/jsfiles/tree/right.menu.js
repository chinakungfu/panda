//定义菜单显示的外观，可以从上面定义的2种格式中选择其一   
var menuskin = "skin0";    
//是否在浏览器窗口的状态行中显示菜单项目条对应的链接字符串   
var display_url = false;    
  
function getEvent(){     //同时兼容ie和ff的写法   
       if(document.all)    return window.event;           
       func=getEvent.caller;               
       while(func!=null){       
           var arg0=func.arguments[0];   
           if(arg0){   
               if((arg0.constructor==Event || arg0.constructor ==MouseEvent)   
                   || (typeof(arg0)=="object" && arg0.preventDefault && arg0.stopPropagation)){       
                   return arg0;   
               }   
           }   
           func=func.caller;   
       }   
      return null;   
}   
  
function showRightMenu(nodeType,menuId,nodeId) {  
	//获取当前鼠标右键按下后的位置，据此定义菜单显示的位置  
	var event=getEvent(); 
	var menuIdObj = document.getElementById(menuId);
	var rightedge = document.body.clientWidth-event.clientX;   
	var bottomedge = document.body.clientHeight-event.clientY;
	if(nodeType=='node')
	{
		if(menuId=='menu')
		{
			addCNode.name=nodeId;
			addCNode.name=nodeId;
			nodeBase.name=nodeId;
			sortNode.name=nodeId;
			moveNode.name=nodeId;
			setDefaultNode.name=nodeId;
			delNode.name=nodeId;
			contentPublish.name=nodeId;
		}else
		{
			addPNode.name=nodeId;
		}
	}else if(nodeType=='publish')
	{
		if(menuId=='menu')
		{
			refeshIndex.name=nodeId;
			newDoc.name=nodeId;
			nodeUpdate.name=nodeId;
			nodePublsh.name=nodeId;
			viewNodeIndex.name=nodeId;
			//testDDD.name = nodeId;
			//alert(viewIndex.name);
			parmaSet.name=nodeId;
		}else
		{
			allSitUpdate.name=nodeId;
			allSitePublish.name=nodeId;
		}
	}else if(nodeType=='contentRightMenu')
	{
		if(menuId=='contentRightMenu')
		{
			copy.name=nodeId;
			move.name=nodeId;
			batchTop.name=nodeId;
			batchBest.name=nodeId;
			batchSort.name=nodeId;
			createVoidLink.name=nodeId;
			createIndexLink.name=nodeId;
			viewLinkState.name=nodeId;
		}	
	} 
	//如果从鼠标位置到窗口右边的空间小于菜单的宽度，就定位菜单的左坐标（Left）为当前鼠标位置向左一个菜单宽度   
	if (rightedge <menuIdObj.offsetWidth)
	{  
		menuIdObj.style.left = (document.body.scrollLeft + event.clientX - menuIdObj.offsetWidth)+'px';  
	}else//否则，就定位菜单的左坐标为当前鼠标位置
	{   
		menuIdObj.style.left = (document.body.scrollLeft + event.clientX)+'px'; 
	} 
	//如果从鼠标位置到窗口下边的空间小于菜单的高度，就定位菜单的上坐标（Top）为当前鼠标位置向上一个菜单高度   
	if (bottomedge <menuIdObj.offsetHeight)
	{   
		//menuIdObj.style.top = (document.body.scrollTop + event.clientY - menuIdObj.offsetHeight)+'px'; 
		menuIdObj.style.top = (document.body.scrollTop + event.clientY)+'px'; 
	}else//否则，就定位菜单的上坐标为当前鼠标位置 
	{  
		menuIdObj.style.top = (document.body.scrollTop + event.clientY)+'px';  
	} 
	//设置菜单可见   
	menuIdObj.style.visibility = "visible";   
	return false;   
}   
function hideRightMenu() {   
	//隐藏菜单   
	//很简单，设置visibility为hidden就OK！
	var menuIdObj = document.getElementById('menu');
	var menuBaseIdObj = document.getElementById('menuBase');
	menuIdObj.style.visibility = "hidden";  
	menuBaseIdObj.style.visibility = "hidden"; 
}   

function hideContentRightMenu() {   
	//隐藏菜单   
	//很简单，设置visibility为hidden就OK！
	var contentRightMenuIdObj = document.getElementById('contentRightMenu');
	contentRightMenuIdObj.style.visibility = "hidden"; 
} 
function highRightMenu(evt) {   
	//高亮度鼠标经过的菜单条项目   
	  
	//如果鼠标经过的对象是menuitems，就重新设置背景色与前景色   
	//event.srcElement.className表示事件来自对象的名称，必须首先判断这个值，这很重要！   
	//var event=evt || window.event; 
	var event=getEvent();  
	var element=event.srcElement || event.target;   
	if (element.className == "menuitems") {   
	element.style.backgroundColor = "highlight";   
	element.style.color = "white";   
	  
	//将链接信息显示到状态行   
	//event.srcElement.url表示事件来自对象表示的链接URL   
	if (display_url)   
	window.status = event.srcElement.url;   
	   }   
}   
  
function lowRightMenu(evt) {   
	//恢复菜单条项目的正常显示   
	//var event=evt || window.event;
	var event=getEvent();   
	var element=event.srcElement || event.target; 
	if (element.className == "menuitems") {   
		element.style.backgroundColor = "";   
		element.style.color = "black";   
		//window.status = "";   
   }   
}   
  
//右键下拉菜单功能跳转   
function jumpRightMenu(evt) {   
	//转到新的链接位置   
	//var event=evt || window.event;
	var event=getEvent();   
	var element=event.srcElement || event.target;  
	//var seltext=window.document.selection.createRange().text  
	if (element.className == "menuitems") {   
		//如果存在打开链接的目标窗口，就在那个窗口中打开链接   
//		if (element.getAttribute("target") != null)   
//		{   
//			window.open(element.getAttribute("url"), element.getAttribute("target"));   
//		}   
//		else
//		{
			//否则，在当前窗口打开链接   
			//window.location = element.getAttribute("url");
		//}
		going(element.name,element.id,element.getAttribute("url"))
   }   
}
 
function going(name,id,url)
{
//	alert(name);
//	alert(id);
//	alert(url);
	//url = url+'&nodeId='+name;
	switch(id) {
		//站点右击菜单
		case 'addPNode': 
			url = url+'&nodeId='+name;
			window.open(url, 'mainFrame');
			break;
		case 'addCNode':
			url = url+'&nodeId='+name;
			window.open(url, 'mainFrame'); 
			break;
		case 'nodeBase':
			url = url+'&nodeId='+name;
			openMoveNode(url); 
			break;
		case 'sortNode':
			url = url+'&nodeId='+name;
			openMoveNode(url);  
			break;
		case 'moveNode': 
			url = url+'&nodeId='+name;
			openMoveNode(url); 
			break;
		case 'setDefaultNode':
			url = url+'&nodeId='+name;
			openMoveNode(url);  
			break;
		case 'delNode':
			url = url+'&nodeId='+name;
			if(window.confirm('您确定要删除该结点吗！')){location.href=url;} 
			break;
		case 'contentPublish':
			url = url+'&nodeId='+name;
			window.open(url, 'mainFrame'); 
			break;
		//发布管理右击菜单	
		case 'allSitUpdate':
			url = url+'&nodeId='+name;
			openNodeUpdate(url); 
			break;
		case 'allSitePublish':
			url = url+'&nodeId='+name;
			openNodePublish(url); 
			break;
		case 'refeshIndex':
			url = url+'&nodeId='+name;
			window.open(url, 'mainFrame'); 
			break;
		case 'newDoc':
			url = url+'&nodeId='+name;
			openNewDoc(url); 
			break;
		case 'nodeUpdate':
			url = url+'&nodeId='+name;
			openNodeUpdate(url); 
			break;
		case 'nodePublsh':
			url = url+'&nodeId='+name;
			openNodePublish(url); 
			break;
		case 'viewNodeIndex':
			url = url+'&nodeId='+name;
			window.open(url, '_blank'); 
			break;
		case 'parmaSet':
			url = url+'&nodeId='+name;
		 	window.open(url, 'mainFrame');
			break;
		//内容页右击菜单
		case 'copy':
			url = url+'&selectConId='+name+',';
			window.open(url, '复制', 'height=400, width=500, top=300, left=400, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
			break;
		case 'move':
			url = url+'&selectConId='+name+',';
		 	window.open(url, '移动', 'height=400, width=500, top=300, left=400, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
			break;
		case 'setBatchTop':
			url = url+'&selectConId='+name+',';
		 	window.open(url, '批量置顶设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
			break;
		case 'setBatchBest':
			url = url+'&selectConId='+name+',';
			window.open(url, '批量精华设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
			break;
		case 'setBatchSort':
			url = url+'&selectConId='+name+',';
		 	window.open(url, '批量权重设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
			break;
		case 'createVoidLink':
			url = url+'&selectConId='+name+',';
		 	window.open(url, 'mainFrame');
			break;
		case 'createIndexLink':
			url = url+'&selectConId='+name+',';
		 	window.open(url, 'mainFrame');
			break;
		case 'viewLinkState':
			url = url+'&selectConId='+name+',';
		 	window.open(url, 'mainFrame');
			break;
	}	
}