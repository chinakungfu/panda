(function(window){
	var DOM = {
		//根据id取元素
		id:function(id){
			return document.getElementById(id);
		},
		//根据ClassName取元素集合
		getElementsByClassName:function(n){
			var el = [], 
	        _el = document.getElementsByTagName('*'); 
		    for (var i=0; i<_el.length; i++ ) { 
		       if (_el[i].className == n ) { 
		           el[el.length] = _el[i]; 
		        } 
		   } 
		   return el; 
		},
		//获取上一个同级节点
		getPrevChild:function(obj){
			var result = obj.previousSibling;
			while (!result.tagName) {
				result = result.previousSibling;
			}
			return result;
		},
		//获取下一个同级节点
		getNextChild:function(obj){
			var result = obj.nextSibling;
			while (!result.tagName) {
				result = result.nextSibling;
			}
			return result;
		},
		//显示隐藏元素
		show:function(id,className){
			if(className){
				var elems = DOM.getElementsByClassName(className);
				for(var i=0, len = elems.length; i<len; i++){
					elems[i].style.display = 'none';
				}
			}
			var elem = document.getElementById(id);
			if(!elem.style.display || elem.style.display == 'none'){
				elem.style.display = 'block';
			}else{
				elem.style.display = 'none';
			}	
		},
		//清空文本
		empty:function(obj,val){
			if(obj.value == val || val == undefined){
				obj.value = '';
			}
		},
		//恢复文本
		restore:function(obj,val){
			if(obj.value == ''){
				obj.value = val;
			}
		},
		//全选
		checkAll:function(obj,name){
			var items = document.getElementsByName(name);
			for (var i = 0, len = items.length; i < len; i++) {
				if(obj.checked){
					items[i].checked = true;
				}else{
					items[i].checked = false;
				}
			}
		}
	}
	window.DOM = DOM;
})(window);

//计算总价
function getTotalPrice(obj,price){
	var n = obj.value;
	var p,m = 1;
	if(n < 1 && n){
		obj.value = m;
		p = m * price;
	}else{
		p = n * price;
	}
	DOM.id('totalPrice').innerHTML = '￥' + p.toFixed(2);
}

DOM.id('app').onclick = function(){
	DOM.id('viewShoppingBag').style.cssText = 'display:block;position: absolute;top: 40px;right: 230px;';
}

function closeDialog(){
	DOM.id('viewShoppingBag').style.display = 'none';
}
