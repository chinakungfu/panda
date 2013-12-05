/*
****************************
*** http://www.hansir.cn ***
****************************
*/
String.prototype.ltrim = function(){
	return this.replace(/^\s*(.+?)$/,'$1');
}
//这里引用prototype的五个方法
function $(){return document.getElementById(arguments[0]);}
Object.extend = function(destination, source){
	for(property in source) destination[property] = source[property];
	return destination;
}
function $A(iterable) {
	var results = [];
	for (var i = 0; i < iterable.length; i++)results.push(iterable[i]);
	return results;
}
Function.prototype.bindAsEventListener = function(object) {
	var __method = this;
	return function(event) {
		return __method.call(object, event || window.event);
	}
}
Function.prototype.bind = function() {
	var __method = this, args = $A(arguments), object = args.shift();
	return function() {
		return __method.apply(object, args.concat($A(arguments)));
	}
}
var hansir = {
	url: 'http://www.hansir.cn'
}
hansir.AjAx = function(){this.initialize.apply(this, arguments);}
hansir.AjAx.prototype = {
	initialize: function(complete, method, url){
		this.complete = complete;
		this.method = method || 'post';
		this.url = url;
		if (this.method == 'get') this.url += (this.url.match(/\?/) ? '&' : '?');
	},
	xmlHttp: function(){
		var xmlHttp;
		if(window.XMLHttpRequest) xmlHttp = new XMLHttpRequest();
		else if(window.ActiveXObject)
		try{
			xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
		}catch(errr){
			xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		return xmlHttp;
	},
	request: function(parameters){
		var xmlHttp = this.xmlHttp();
		var send_val = null;
		this.method=='get' ? this.url += parameters : send_val = parameters;
		xmlHttp.open(this.method, this.url, true);
		xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=utf-8');
		xmlHttp.onreadystatechange = this.ready_handler.bind(this, xmlHttp);
		xmlHttp.send(send_val);
	},
	ready_handler: function(xmlHttp){
		if(xmlHttp.readyState == 4){
			//alert(xmlHttp.responseText);
			if(this.success(xmlHttp)){
				this.complete.load_data(xmlHttp);
			}
		}
	},
	success: function(xmlHttp){return xmlHttp.status == 0 || xmlHttp.status >= 200 && xmlHttp.status < 300}
}
hansir.TextSuggest = function(){this.initialize.apply(this, arguments);}

hansir.TextSuggest.prototype = {
	initialize: function(){},
	add_suggest: function(inp, url, method, defer, defer2){
		var inp = $(inp);
		inp.defer = defer || null;
		inp.defer2 = defer2 || 200;
		var sw = inp.offsetWidth, sh = inp.offsetHeight;
		inp.suggest_list = this.create_list(sw, sh);
		inp.suggest_list.par = inp;
		inp.xmlHttp = new hansir.AjAx(inp.suggest_list, method, url);
		Object.extend(inp, {
			requesting : false,
			last_result : true,
			previous_value : null,
			last_value : null,
			kt : null,
			rt : null,
			load_event: function(){
				if(this.addEventListener){
					this.addEventListener('input', this.keyup_handler.bindAsEventListener(this),false);
				}else if(this.attachEvent){
					this.attachEvent('onkeyup', this.keyup_handler.bindAsEventListener(this));
				}
			},
			keyup_handler:function(e){
				var intKey;
				window.event ? intKey = event.keyCode : intKey = e.which;
				if(intKey == 38 || intKey == 40 || intKey == 13 || intKey == 37) return;
				if(this.requesting) return;
				var val = this.value.ltrim();
				this.last_value = val;
				if(val == this.previous_value) return;
				if(val==''){
					this.previous_value = '';
					this.last_value='';
					this.suggest_list.hidden();
					this.suggest_list.clear_data();
					return;
				}
				if(new RegExp('^'+this.last_result,'i').test(val)) return;
				this.last_result = true;
				this.previous_value = val;
				if(this.kt) clearTimeout(this.kt);
				this.defer?this.kt = setTimeout(this.send_request.bind(this), this.defer):this.send_request();
			},
			onblur: function(){
				setTimeout(this.suggest_list.hidden.bind(this.suggest_list), 100);
			},
			onkeydown: function(e){ // 上下、回车键事件
				if(!this.suggest_list.rows.length) return;
				var intKey;
				window.event ? intKey = event.keyCode : intKey = e.which;
				switch(intKey){
					case 38:
					if(this.suggest_list.style.visibility=='hidden'){
						this.suggest_list.visible();
						return;
					}
					var val = this.suggest_list.select_index(1);
					val?this.value=val : this.value = this.last_value;
					break;
					case 40:
					if(this.suggest_list.style.visibility=='hidden'){
						this.suggest_list.visible();
						return;
					}
					var val=this.suggest_list.select_index(0);
					val?this.value=val : this.value = this.last_value;
					break;
					case 13:
					if(this.suggest_list.cur_tr!=-1){
						this.suggest_list.hidden();
						break;
					}
					case 39:
					this.suggest_list.hidden();
					this.keyup_handler('o');
				}
			},
			send_request: function(){ // 请求数据
				this.requesting = true;
				var val = this.value;
				var parameters = 'keyword=' + val.ltrim();
				this.xmlHttp.request(parameters);
				this.start_hidden_time();
			},
			start_hidden_time: function(){
				if(this.rt) clearTimeout(this.rt);
				this.rt = setTimeout(this.list_hidden.bind(this), this.defer2);
			},
			list_hidden: function(){
				if(this.requesting) this.suggest_list.hidden();
			}
		});
		inp.load_event();
	},
	create_list: function(w, h){ //创建列表
		var table = document.createElement('table');
		table.cellSpacing = 0;
		document.body.appendChild(table);
		table.className = 'tab_suggest';
		table.style.width = w + 'px';
		table.parh = h-1;

		Object.extend(table,{
			cur_tr: -1,
			set_pos: function(){ // 下垃框位置
				var x=0, y=0, inp = this.par;
				while(inp != null){x += inp.offsetLeft;y += inp.offsetTop;inp = inp.offsetParent;}
				inp = null;
				table.style.left = x + 'px';
				table.style.top = y+this.parh+ 'px';
			},
			add: function(str, num){
				var n=0;
				this.rows.length ? n=this.rows.length : n = 0;
				var tr = this.insertRow(n);
				var th = document.createElement('th');
				var td = document.createElement('td');
				th.innerHTML = str, td.innerHTML = num;
				tr.appendChild(th), tr.appendChild(td);
				tr.num = this.rows.length-1;
				tr.par = this;
				tr.onmouseover = function(){
					var par = this.par;
					if(par.cur_tr!=-1 && par.cur_tr!=this.num){
						par.rows[par.cur_tr].className='';
						this.className = 'cur';
						par.cur_tr = this.num;
					}else{
						this.className = 'cur';
						par.cur_tr = this.num;
					}
				}
				tr.onclick = function(){
					var par = this.par.par;
					par.value = this.cells[0].innerHTML;
				}
				tr = null, th = null, td = null;
			},
			load_data: function(xmlHttp){ // 加载列表
				var inp = this.par;
				if(inp.previous_value != inp.value){
					inp.requesting = false;
					this.clear_data();
					inp.keyup_handler('o');
					return;
				}
				var arr = xmlHttp.responseText;
				if(arr.ltrim() == 'null'){
					inp.last_result = inp.value;
					inp.requesting = false;
					inp.suggest_list.hidden();
					this.clear_data();
					return;
				}
				var cur_data = eval(arr);
				this.clear_data();
				for(var i=0; i<cur_data.length; i++)
				this.add(cur_data[i][0],cur_data[i][1]);
				this.cur_tr = -1;
				this.visible();
				inp.requesting = false;
			},
			clear_data: function(){while(this.rows.length)this.deleteRow(this.rows[0])}, // 清空列表
			select_index: function(n){ // 移动选项
				if(n){
					if(this.cur_tr==0){
						this.rows[0].className = '';
						this.cur_tr = -1;
						return false;
					}else{
						this.cur_tr==-1?this.cur_tr=this.rows.length : this.rows[this.cur_tr].className = '';
						this.cur_tr = this.cur_tr-1;
						this.rows[this.cur_tr].className = 'cur';
						return this.rows[this.cur_tr].cells[0].innerHTML;
					}
				}else{
					if(this.cur_tr == (this.rows.length-1)){
						this.rows[this.cur_tr].className= '';
						this.cur_tr = -1;
						return false;
					}else{
						if(this.cur_tr!=-1)this.rows[this.cur_tr].className = '';
						this.cur_tr = this.cur_tr+1;
						this.rows[this.cur_tr].className = 'cur';
						return this.rows[this.cur_tr].cells[0].innerHTML;
					}
				}
			},
			hidden: function(){this.style.visibility = 'hidden';}, // 隐
			visible: function(){this.set_pos(); this.style.visibility = 'visible';} // 显
		});
		return table;
	}
}
