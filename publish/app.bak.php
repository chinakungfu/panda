<?php
/**
 * 新增：
 * app.php?action=add&con=appApiTest&nodeId=LYGLQ6rM
 *
 * 修改：
 * app.php?action=edit&con=appApiTest&nodeId=LYGLQ6rM&contentId=2
 *
 * 删除：
 * app.php?action=del&con=appApiTest&nodeId=LYGLQ6rM&contentId=2
 *
 * add by jcode @2011-11-25
 */


if(!defined('apppath')) define('apppath',str_replace('\\','/',realpath(dirname(__FILE__))));
if(!defined('corepath')) define('corepath',substr(apppath,0,strripos(apppath,'/')).'/web-inf/lib');

try{
	// 加载全局配置、数据库配置及常用函数
	require_once('publish_applparam.php');
	require_once(corepath.'/coreconfig/public_dbconfig.php');
	require_once(corepath.'/core/incfunc.php');
	
	//默认把各种调用放在appfunc/api/目录下
	$base_dir='appfunc/api/';
	
	// 加载配置文件
	// 调用的文件放在提交参数con下
	// 可用“/”包含子目录
	// 在linux系统下区分对大小写敏感
	if(is_file($filename=$base_dir .$_GET['con'].'.php')){
		include $filename;
	}else{
		$current_dir=realpath(dirname(__FILE__));
		throw new Exception("The file \"$current_dir/$filename\" is not exists.");
	}
	
	// 加载默认的函数配置
	if(is_file($filename=$base_dir .'/appApiDefault.php')) include $filename;
	
	// 加载数据源
	loadDS();
	$db=$GLOBALS['currentApp']['dbaccess'];
	//print_r($db);
	//$db->insertData('insert into test(title, content) values("test", "test content")');
	
	switch($_GET['action']){
		case 'add':
			$var=$_POST;

			try{
				
				// 开始事务
				// PdataAccess类的回滚方法出错。。。。
				//$db->beginTrans();
				
				// 操作前执行
				// 如果返回值为false，则不进行正常的插入和后续的插入事件，注意，这false是严格检查
				if(function_exists('start_add') && start_add($var, $publish)!==false){
				
					// 开始插入操作
					// 检查结点，并获取结点信息
					$var['nodeId']=$_GET['nodeId'];
					if(!preg_match('/^\w+$/',$var['nodeId'])) throw new Exception('结点号参数出错', 1);
					if($node=$db->QueryForList("select * from cms_cms_site where nodeGuid='{$var['nodeId']}'")){
						$node=$node[0];
					}else{
						throw new Exception("找不到结点“{$var['nodeId']}”", 1);
					}
					
					if(!$node['appTableName']) throw new Exception("结点“{$var['nodeId']}”没有绑内容表", 2); 
					
					// 构造插入数据表SQL
					// 插入内容表
					$sql="insert into {$node['appTableName']} set";
					foreach($var as $key=>$val) $sql.=" $key=:$key,";
					$sql=trim($sql,',');
					if(!$contentId=$db->insertData($sql, $var)) throw new Exception("插入数据表“{$node['appTableName']}”时出错，插入语句：$sql", 3);
					
					// 构造插入发布表语句
					// 并插入发布表
					$sql="insert into cms_cms_app_publish_state set appTableName='{$node['appTableName']}', nodeId='{$var['nodeId']}', contentId=$contentId";
					if($publish && is_arrray($publish)){
						foreach($publish as $key=>$val) $sql.=", $key=:$key";
					}
					if(!$indexId=$db->insertData($sql, $publish)) throw new Exception("插入发布表出错，插入语句：$sql", 3);
					
					// 操作后执行
					$var[$node['appTableKeyName']]=$contentId;
					if(function_exists('end_add')) end_add($var, $indexId);
				
				}
				
				// 提交事务
				//$db->commitTrans();
				
			}catch(Exception $e){
				// 回滚事务
				//$db->rollBackTrans();
				
				// 执行预定义的出错处理
				function_exists('error_add') && error_add($var, $e);
			}
		break;
		case 'edit':
			$var=$_POST;

			try{
				
				// 开始事务
				// PdataAccess类的回滚方法出错。。。。
				//$db->beginTrans();
				
				// 操作前执行
				// 如果返回值为false，则不进行正常的插入和后续的插入事件，注意，这false是严格检查
				if(function_exists('start_edit') && start_edit($var)!==false){
					// 检查内容ID
					$contentId=intval($_GET['contentId']);
					$nodeId=trim($_GET['nodeId']);
					if($contentId<=0) throw new Exception('参数出错',1);
					
					// 开始插入操作
					// 检查结点，并获取结点信息
					if(!preg_match('/^\w+$/',$nodeId)) throw new Exception('结点号参数出错', 1);
					if($node=$db->QueryForList("select * from cms_cms_site where nodeGuid='$nodeId'")){
						$node=$node[0];
					}else{
						throw new Exception("找不到结点“{$nodeId}”", 1);
					}
					
					if(!$node['appTableName']) throw new Exception("结点“{$nodeId}”没有绑内容表", 2); 
					
					// 构造插入数据表SQL
					// 插入内容表
					$sql="update {$node['appTableName']} set";
					foreach($var as $key=>$val) $sql.=" $key=:$key,";
					$sql=trim($sql,',');
					$sql.=" where nodeId='$nodeId' and {$node['appTableKeyName']}=$contentId";
					if(!$db->updateData($sql, $var)) throw new Exception("更新数据表“{$node['appTableName']}”时出错，插入语句：$sql", 3);

					// 操作后执行
					if(function_exists('end_edit')) end_edit($var);
				
				}
				
				// 提交事务
				//$db->commitTrans();
				
			}catch(Exception $e){
				// 回滚事务
				//$db->rollBackTrans();
				
				// 执行预定义的出错处理
				function_exists('error_edit') && error_edit($var, $e);
			}
		break;
		case 'del':
			try{
				
				// 开始事务
				// PdataAccess类的回滚方法出错。。。。
				//$db->beginTrans();
				
				// 操作前执行
				// 如果返回值为false，则不进行正常的插入和后续的插入事件，注意，这false是严格检查
				if(function_exists('start_del') && start_del()!==false){
					// 检查内容ID
					$contentId=intval($_GET['contentId']);
					$nodeId=trim($_GET['nodeId']);
					if($contentId<=0) throw new Exception('参数出错',1);
					
					// 开始插入操作
					// 检查结点，并获取结点信息
					if(!preg_match('/^\w+$/',$nodeId)) throw new Exception('结点号参数出错', 1);
					if($node=$db->QueryForList("select * from cms_cms_site where nodeGuid='$nodeId'")){
						$node=$node[0];
					}else{
						throw new Exception("找不到结点“{$nodeId}”", 1);
					}
					
					if(!$node['appTableName']) throw new Exception("结点“{$nodeId}”没有绑内容表", 2); 
					
					// 构造插入数据表SQL
					// 插入内容表
					// 这里采用多表删除方法，在MySQL5.0以上版本可以使用另名，为了兼容低版本，最好表名不要用别名
					//$sql="delete c,i from {$node['appTableName']} c, cms_cms_app_publish_state i where c.nodeId=i.nodeId and c.nodeId='$nodeId' and c.{$node['appTableKeyName']}=$contentId";
					$sql="delete {$node['appTableName']}, cms_cms_app_publish_state from {$node['appTableName']}, cms_cms_app_publish_state where {$node['appTableName']}.nodeId=cms_cms_app_publish_state.nodeId and {$node['appTableName']}.nodeId='$nodeId' and {$node['appTableName']}.{$node['appTableKeyName']}=$contentId";
					echo $sql;
					if(!$db->updateData($sql, $var)) throw new Exception("删除数据时出错，查询语句：$sql", 3);

					// 操作后执行
					if(function_exists('end_del')) end_del();
				
				}
				
				// 提交事务
				//$db->commitTrans();
				
			}catch(Exception $e){
				// 回滚事务
				//$db->rollBackTrans();
				
				// 执行预定义的出错处理
				function_exists('error_del') && error_del($var, $e);
			}
		break;
	}

}catch(Exception $e){
	_halt($e);
}

function smsg($msg,$referer="",$delay='3'){
	global $_PUBAPI;
	if (empty($referer)) $referer=$_PUBAPI['DefaultReferer'];
	if (empty($referer)) $referer=$_SERVER['HTTP_REFERER'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="<?php echo $delay; ?>;URL=<?php echo $referer; ?>" />
<title><?php echo $_PUBAPI['SiteName']; ?></title>
<style type="text/css">
<!--
body {
	margin: 0px;
}
#msg {
	border: 1px dashed #333333;
}
h1 {
	font-family: "宋体", Arial;
	color: #333333;
	font-size: 12px;
	line-height: 16px;
	font-style: normal;
	font-weight: normal;
} 
h1 a {
	color: #333333;
	text-decoration: none;
}
h1 a:hover {
	color: #0000FF;
	text-decoration: underline;
}
-->
</style>
</head>
<body>
<table width="300px" align="center" cellpadding="0" cellspacing="0" id="msg">
<tr><td><br />
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><h1><?php echo $msg; ?></h1></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><h1><a href="<?php echo $referer; ?>">如果您的浏览器不支持跳转，请点此处</a></h1></td>
  </tr>
</table>
</td>
</tr>
</table>
</body>
</html>
<?php die(); }
function gback($msg){
	global $_PUBAPI;	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $_PUBAPI['SiteName']; ?></title>
<script language="javascript">
alert("<?php echo $msg; ?>");
history.go(-1);
</script>
</head>
</html>
<?php die(); } 

function _halt($e){
	print_r($e);
}