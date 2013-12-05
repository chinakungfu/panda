<?php
//header('content-Type: text/html; charset=utf-8');
if(!defined('apppath')) define('apppath',str_replace('\\','/',realpath(dirname(__FILE__))));
if(!defined('corepath')) define('corepath',substr(apppath,0,strripos(apppath,'/')).'/web-inf/lib');
define('NOW_TIME', time());
try{
	$IN=array_merge($_POST, $_GET);

	if(!$IN['nodeId'] || !preg_match('/^\w+$/', $IN['nodeId'])) throw new Exception('参数出错');
	
	// 加载全局配置、数据库配置及常用函数
	require_once('publish_applparam.php');
	require_once(corepath.'/coreconfig/public_dbconfig.php');
	require_once(corepath.'/coreconfig/public_tableconfig.php');
	require_once(corepath.'/coreconfig/public_appconfig.php');
	require_once(corepath.'/coreconfig/public_func.php');
	require_once(corepath.'/core/incfunc.php');
	import('core.apprun.member.Session');
	

	// 加载数据源
	loadDS();
	$db=$GLOBALS['currentApp']['dbaccess'];
	//print_r($db);
	//$db->insertData('insert into test(title, content) values("test", "test content")');
	
	// 查找结点信息
	$sql="select * from cms_cms_site where nodeGuid='{$IN['nodeId']}' limit 1";
	if(!$node=$db->QueryForList($sql)) throw new Exception('找不到指定结点');
	$node=$node[0];
	if(!$node['appTableName']) throw new Exception("结点“{$node['nodeName']}({$node['nodeGuid']})”没有绑定数据表。");
	if(!$node['appTableKeyName']) throw new Exception("结点“{$node['nodeName']}({$node['nodeGuid']})”没有绑定内容模型键值名。");
	$loginName = readsession();
	/*$sql = "select * from cms_member_staff where LENGTH(staffNo)=18";
	$ret = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'], $sql, $para);
	foreach($ret as $key => $val)
	{
		$sqlSel = "select * from cms_member_group_roles where roleId='QTHYZXYBRY5XTj' and groupId='".$val['staffNo']."' and relationType=1";
		$ret1 = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'], $sqlSel, $para);
		if(empty($ret1))
		{
			$sqlInsert = "insert into cms_member_group_roles (groupId,roleId,relationType) values ('".$val['staffNo']."','QTHYZXYBRY5XTj','1')";
			TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'], $sqlInsert, $para);
		}
	}
	exit;*/
	if($node['appTableName']=='commoncms.cms_publish_resident')
	{
		if($loginName!='admin')
		{
			$tempSql = " and c.idNumber='".$loginName."'";
			$sql="select * from cms_cms_app_publish_state i, {$node['appTableName']} c where c.nodeId=i.nodeId and i.contentId=c.{$node['appTableKeyName']} and i.nodeId='{$node['nodeGuid']}' and i.isDel=0 and i.state=1".$tempSql;
			$ret = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'], $sql, $para);
			if($ret)
			{
				$tempSqlCon = " and c.householdName='".$ret[0]['householdName']."' and c.householdId='".$ret[0]['householdId']."'";
			}else
			{
				$tempSqlCon = $tempSql;
			}
		}
		
	}else if($node['appTableName']=='commoncms.cms_publish_house')
	{
		if($loginName!='admin')
		{
			$tempSqlCon = " and c.idNumber='".$loginName."'";
		}
	}
	$sql="select * from cms_cms_app_publish_state i, {$node['appTableName']} c where c.nodeId=i.nodeId and i.contentId=c.{$node['appTableKeyName']} and i.nodeId='{$node['nodeGuid']}' and i.isDel=0 and i.state=1".$tempSqlCon;
	$para=array();
	foreach($IN as $key=>$var){
		if($var===''){
			unset($IN[$key]);
			continue;
		}
		if(!is_array($var)||!$var['v']) continue;
		
		if(!$var['o']) $var['o']='=';
		
		//if(strtolower($var['o'])=='like'){
		//	$sql.=" and $key like '%:$key%'";
		//}else{
		//	$sql.=" and $key {$var['o']} :$key";
		//}
		if(strtolower($var['o'])=='like'){
			$sql.=" and $key like '%{$var['v']}%'";
		}else{
			$sql.=" and $key {$var['o']} '{$var['v']}'";
		}
		
		$para[$key]=$var['v'];
	}
	
	if($IN['groupby']) $sql.=' group by '.$IN['groupby'];
	if($IN['orderby']) $sql.=' order by '.$IN['orderby'];

	if(!$IN['currentPage']) $IN['currentPage']=1;
	if(!$IN['pageSize']) $IN['pageSize']=10;
	$para['currentPage']=$IN['currentPage'];
	$para['pageSize']=$IN['pageSize'];
	$searchData=TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'], $sql, $para);
	
	//print_r($searchData);
	
	import('core.tpl.TplTemplate');
	import('core.tpl.TplRun');
	import('core.ajax.AjaxService');
	import('core.ajax.phprpc.bcmath');
	import('core.ajax.phprpc.keypair');
	import('core.ajax.phprpc.xxtea');
	import('core.power.popedom');
	
	unset($IN['currentPage']);
	$page=$searchData['pageinfo'];
	$queryString=http_build_query($IN, '', '&');
	if($page['hasprior']) $page['url_prior']='?'.$queryString.'&currentPage='.($para['currentPage']-1);
	if($page['hasnext']) $page['url_next']='?'.$queryString.'&currentPage='.($para['currentPage']+1);
	
	$i=1;
	while($i+10<=$page['currentPage']){$i+=10;}

	$j=0;
	while($j<10){
		$p=$i+$j;
		if($p>$page['pagecount']) break;
		$page['url'][$p]='?'.$queryString.'&currentPage='.$p;
		$j++;
	}
	//echo '<!-- ';
	//echo $sql;
	//echo ' -->';
	$tpl=new TplRun();
	$tpl->require_cache = false;
	$tpl->assign_by_ref('IN',$IN);
	$tpl->assign_by_ref('data',$searchData['data']);
	$tpl->assign_by_ref('page',$page);
	$tpl->assign('queryString', $queryString);
	
	$tpl->run($IN['tpl']);
	
}catch(Exception $e){
	halt($e);
}


function halt($e){
	print_r($e);
}
