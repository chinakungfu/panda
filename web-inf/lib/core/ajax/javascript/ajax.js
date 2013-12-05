/* AJASON* Bringing AJAX and JSON together** This file is part of AJASON.** AJASON is a PHP 5 library and JavaScript client for the upcoming* Web technology called AJAX. AJAX permits data to be fetched* asynchronously without the need for reloading the Web page and* thus allows the development of interactive GUI-like Web applications.* JSON is a lightweight data interchange format which is used by AJASON* to exchange data between server and client.** AJASON is free software; you can redistribute it and/or modify* it under the terms of the GNU General Public License as published by* the Free Software Foundation; either version 2 of the License, or* (at your option) any later version.** AJASON is distributed in the hope that it will be useful,* but WITHOUT ANY WARRANTY; without even the implied warranty of* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the* GNU General Public License for more details.** You should have received a copy of the GNU General Public License* along with Foobar; if not, write to the Free Software* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA** AJASON has been developed by Sven Jacobs <sven.jacobs@web.de>.* For more details visit sven-jacobs.de/wiki/AJASON** Some parts of this project are contributed by other projects, namely* JSON (json.org) and JSON-PHP (mike.teczno.com/json.html) which are* copyrighted by their respective authors.*//*** Ajax JavaScript class** Contains methods to create the XMLHttpRequest object and to call remote* functions and object methods.** @author Sven Jacobs <sven.jacobs@web.de>**/function Ajax( mtd, handler, debug, displayErrors){	var _method        = mtd;	var _handler       = handler;	var _debug         = debug;	var _displayErrors = displayErrors;	var _clientVersion = "0.9";	/*** Private methods ***/	/**	* Return instance of XMLHttpRequest class	*	* @return Object of XMLHttpRequest	**/	function getXmlHttpRequestObject()	{		var xmlHttpRequest = false;		if ( window.XMLHttpRequest )		{			try			{				xmlHttpRequest = new XMLHttpRequest();			}			catch (e)			{				xmlHttpRequest = false;			}		}		else if ( window.ActiveXObject )		{			try			{				xmlHttpRequest = new ActiveXObject( "Msxml2.XMLHTTP" );			}			catch (e)			{				try				{					xmlHttpRequest = new ActiveXObject( "Microsoft.XMLHTTP" );				}				catch (e)				{					xmlHttpRequest = false;				}			}		}		// Override mime type if browser supports it (like Mozilla)		if ( xmlHttpRequest.overrideMimeType )		{			xmlHttpRequest.overrideMimeType( "text/xml" );		}		return xmlHttpRequest;	}	function prepareRespnoseText(responseText)	{					}	/**	* Prepare XMLHttpRequest object	*	* @param[in] xmlHttpRequest XMLHttpRequest object	* @param[in] params Parameters of function or method which has been called	* @param[in] data Data which will be send	* @return Final data which will be send	**/	function prepareXmlHttpRequest( xmlHttpRequest, params, data,callback )	{		//var callbackFunction = getCallbackFunction(params);		if ((callback==null)||(callback=="undefined"))		{			callbackFunction = getCallbackFunction(params);		}		else		{			callbackFunction = callback;		}		var handler;		var finalData;		if ( _method == "GET" )		{			handler   = _handler + "?" + data;			finalData = null;		}		else		{			handler   = _handler;			finalData = data;		}		xmlHttpRequest.open( _method, handler, true );		if ( _method == "POST" )		{			xmlHttpRequest.setRequestHeader( "Method",        "POST " + _handler + " HTTP/1.1" );			xmlHttpRequest.setRequestHeader( "Content-Type",  "application/x-www-form-urlencoded" );			xmlHttpRequest.setRequestHeader( "Content-Length", finalData.length );		}		xmlHttpRequest.onreadystatechange = function()		{			if ( xmlHttpRequest.readyState == 4 )			{				try				{					//该处处理处理，模板调用的问题					var responseText=xmlHttpRequest.responseText;					var index=responseText.indexOf('{"');//根据标示，把前面多余的参数去掉					responseText =responseText.substring(index,responseText.length);										//var response = JSON.parse( xmlHttpRequest.responseText);					var response = JSON.parse(responseText);				}				catch (e)				{					alert( "AJAX error:\nUnknown response from server!\n\n" + xmlHttpRequest.responseText );					return;				}				if ( response.errorCode == 0 && callbackFunction != null )				{					if ( _debug )					{						// Show client/server versions and whole server response before executing callback function						alert( "AJAX debug info:\n\nServer version: " + response.serverVersion + "\nClient version: " + _clientVersion + "\nServer response: " + xmlHttpRequest.responseText );					}					if ((callback==null)||(callback=="undefined"))					{						callbackFunction( response.response);					}					else					{						// 正则表达式对象						var re = new RegExp("(\\w+)", "");						// 验证是否刚好匹配						var yesorno = re.exec(callbackFunction);						var params=getCallBackParams(yesorno[0],callbackFunction);						var temp="";						if (params.length==1)						{							temp=yesorno[0]+"(response.response"+params+";";						}						else						{											temp=yesorno[0]+"(response.response,"+params+";";													}						eval(temp); //执行动态生成的javascript					}				}				else if ( response.errorCode != 0 && _displayErrors )				{					alert( "AJAX error:\n" + response.errorMessage );				}			}		}		return finalData;	}	/**	*取callback方法的参数	*/	function getCallBackParams(funcName,callbackFunction)	{		var funcLength=funcName.length;		if (checkHasParams(callbackFunction))		{			var params=callbackFunction.substring(funcLength+1,callbackFunction.length);			return params;		}		else		{			return ")";		}	}	/**	*检测回调函数是否带参数	*/	function checkHasParams(callbackFunction)	{		//替换空字符；		// 正则表达式对象		var re = new RegExp("\\s+", "");			var newstring=callbackFunction.replace(re,"");		var beginpos=newstring.indexOf("(",0);				var ilength=newstring.length;		if ((ilength-beginpos)<3)		{			return false;		}		else		{			return true;		}	}	/**	* Do params include callback function?	*	* @param[in] params Parameters of function or method which has been called	* @return Returns true if params contain callback function	**/	function paramsHaveCallbackFunction( params )	{		if ( typeof( params ) == "object" && params.length > 0 )		{			return ( typeof( params[ params.length - 1 ] ) == "function" );		}		else		{			return false;		}	}	/**	* Return callback function from params	*	* @param[in] params Parameters of function or method which has been called	* @return Callback function	**/	function getCallbackFunction( params )	{		if ( paramsHaveCallbackFunction( params ) )		{			return params[ params.length - 1 ];		}		else		{			return null;		}	}	/**	* Prepare parameters	*	* @param[in] params Parameters of function or method which has been called	* @return Prepared parameters	**/	function prepareParams( params )	{		var preparedParams = new Array();		if ( typeof( params ) == "object" && params.length > 0 )		{			var end;			if ( paramsHaveCallbackFunction( params ) )			{				end = 1;			}			else			{				end = 0;			}			for( var i = 0; i < params.length - end ; i++ )			{				preparedParams.push( params[ i ] );			}		}		return preparedParams;	}	/**	* Prepare data	*	* @param[in] cls Class name or null	* @param[in] funcOrMtd Function name (if cls == null) or method name	* @param[in] params Parameters of function or method which has been called	* @return Prepared data	**/	function prepareData(serviceid,methodid, params )	{		var data = new Object();		data[ "clientVersion" ] = _clientVersion;		data[ "params" ]        = prepareParams( params );		data[ "methodid" ] = methodid;		data["serviceid"]=serviceid;		return "ajax=" + escape( JSON.stringify( data ) );	}	/**	* Finally send request	*	* @param[in] params Parameters of function or method which has been called	* @param[in] data Data to be send	**/	function call( params, data ,callback)	{		var xmlHttpRequest = getXmlHttpRequestObject();		var finalData      = prepareXmlHttpRequest( xmlHttpRequest, params, data,callback );		xmlHttpRequest.send( finalData);	}	/*** Public methods ***/	/**	* Call remote method	*	* @param[in] cls Name of remote class	* @param[in] mtd Name of remote method	* @param[in] params Parameters of local method which has been called	**/	this.callMethod = function(serviceid,methodid, params,callback )	{		var data = prepareData(serviceid,methodid, params );		call( params, data,callback );	}	/**	* Call remote function	*	* @param[in] func Name of remote function	* @param[in] params Parameters of local function which has been called	**/	this.callFunction = function(serviceid,funcid, params,callback)	{		var data = prepareData(serviceid,funcid, params);		call( params, data,callback );	}	this.callTpl=function(serviceid,tplid,params)	{		var data=prepareData(serviceid,funcid, params )	}}