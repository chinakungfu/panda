<?php
/**
 * 默认的函数定义
 * 默认的函数可以没有，甚至这个文件可以不存在
 * 
 * add by jcode @2011-11-25
 */

/**
 * 新增前执行函数
 * start_add(&$var, &$publish=array())
 *
 * @params $var		插入的数据，键名对应字段名，如果前台不给定个nodeId的值的话，请在这里赋值，否则会出错
 * @params $publish	插入到发布表的数组，更改这个数据可以操作发布表
 *
 * @return 返回false时则不进行正常的插入和后续的插入事件，但这个函数处对数据库进行的操作仍然有效
 */
if(!function_exists('start_add')){
	function start_add(&$var, &$publish){
		// 要操作数据库，可以用全局函数$db
		//global $db;
	
		// 对参数$var,$publish修改将影响到插入时的数据
		//$var['fieldname'].=' QQ尾巴是这样生成的。';
		
		// 发布时间改成一天以后的
		//$publish['publishDate']=time()+3600*24;
	}
}

/**
 * 新增出错时执行函数
 * error_add($var, $throw)
 *
 * @params $var		插入的数据，可能已经不是前台提交的数据了（在start_add中修改过）
 * @params $throw	异常抛出标准对象,可以用getmessage方法获取异常信息
 */
if(!function_exists('error_add')){
	function error_add($var, $throw){
	
	}
}

/**
 * 新增后置事件
 * end_add($var, $indexId)
 *
 * @params $var		插入数据表的数据，这时可以获得插入内容表的ID值
 * @params $indexId	插入索引表的ID
 */
if(!function_exists('end_add')){
	function end_add($var, $indexId){
	
	}
}

if(!function_exists('start_edit')){
	function start_edit(&$var){
	
	}
}

if(!function_exists('error_edit')){
	function error_edit($var, $throw){
	
	}
}

if(!function_exists('end_edit')){
	function end_edit($var){
	
	}
}

if(!function_exists('start_del')){
	function start_del(){
	
	}
}

if(!function_exists('error_del')){
	function error_del($throw){
	
	}
}

if(!function_exists('end_del')){
	function end_del(){
	
	}
}

