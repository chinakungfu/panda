<?php
/**
 *
 * 新增：
 * app.php?action=add&con=appApiTest&nodeId=LYGLQ6rM
 *
 * 修改：
 * app.php?action=edit&con=appApiTest&nodeId=LYGLQ6rM&contentId=2
 *
 * 删除：
 * app.php?action=del&con=appApiTest&nodeId=LYGLQ6rM&contentId=2
 *
 * add, edit, del对应action中的add(添加)，edit(编辑)和del(删除)三种操作
 * start函数是在操作前执行，end函数在成功操作后执行，如果执行过程中出错，转入执行error函数，而忽略后面end函数
 * 当start函数返回特殊的值false时则不进行正常的插入和后续的插入事件，但这个函数处对数据库进行的操作仍然有效，如果遇到错，仍能执行error函数
 * 这九个函数出不一定都要，当函数不存在时执行默认行为(start默认什么都不做,error默认提示，end函数提示后跳转)
 *
 * 这几个函数中，如果要对数据库进行操作，使用全局变量$db，这个变量是个数据库操作类，实现了抽象类DataAccess，使用前请记得先: global $db;
 * 可以使用apppath、corepath两个常量，其中一个是应用目录，一个是核心目录
 * 更多的环境变量见$GLOBALS数组
 *
 * 启用了事务处理，如果遇到错误就回滚数据，但是在error函数里对数据库的操作将不回滚
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
function start_add(&$var, &$publish){
	// 要操作数据库，可以用全局函数$db
	//global $db;

	// 对参数$var,$publish修改将影响到插入时的数据
	//$var['fieldname'].=' QQ尾巴是这样生成的。';
	
	// 发布时间改成一天以后的
	//$publish['publishDate']=time()+3600*24;
	
	//多记录发布，$var是一个二维数组
	$snId=uniqid();
	$time=$_SERVER['REQUEST_TIME'];
	$ip=ip2long($_SERVER['REMOTE_ADDR']);
	$data_len=count(current($var));
	for($i=0; $i<$data_len; $i++){
		$var['action'][$i]=$snId;
		$var['actionTime'][$i]=$time;
		$var['actionIP'][$i]=$ip;
		
		if(is_array($var['resultValue'][$i])) $var['resultValue'][$i]=array_sum($var['resultValue'][$i]);
	}
}

/**
 * 新增出错时执行函数
 * error_add($var, $throw)
 *
 * @params $var		插入的数据，可能已经不是前台提交的数据了（在start_add中修改过）
 * @params $throw	异常抛出标准对象,可以用getmessage方法获取异常信息
 */
function error_add($var, $throw){
	print_r($throw);
}

/**
 * 新增后置事件
 * end_add($var, $indexId)
 *
 * @params $var		插入数据表的数据，这时可以获得插入内容表的ID值
 * @params $indexId	插入索引表的ID
 */
function end_add($var, $indexId){
	//echo '留言成功，留言内容：', $var['content'];
	smsg("<font color='#ff0000'>您的留言已提交成功,页面正在跳转中...</font>",$_GET['referer']);  //显示新增成功,并返回,至此,新增操作已成功执行完成
}

function start_edit(&$var){

}

function error_edit($var, $throw){

}

function end_edit($var){

}

function start_del(){
	//要用参数，请直接使用$_GET
}


function error_del($throw){

}

function end_del(){

}