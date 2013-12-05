<?php

/**
 * CMS标签执行类
 *
 */
import('core.apprun.cmsware.CmswareNode');
import('core.datasource.TStaticQuery');


class CMS
{
	/**
	 * <CMS　action="SQL" return="list" query="select * from Table where Filed =''"  /> 
	 *
	 * @param unknown_type $mParam
	 * @return unknown
	 */
	public static function CMS_SQL($mParam)
	{
		try {
			$PageMode = false;
			extract($mParam,EXTR_PREFIX_SAME,$GLOBALS['currentApp']['table_pre']);
			$cache = empty($cache)? 0 : 2;
			if (empty($num))
			{
				$list_limit = "";
			}
			elseif (preg_match("/^[0-9]+,[0-9]+$/",$num))
			{
				list($start,$end) = explode(",",$num);
				$list_limit = "Limit $start,$end ";
			}
			elseif (preg_match("/^[0-9]+$/",$num))
			{
				$list_limit = "Limit 0,$num";
			}
			elseif (preg_match("/^page-\d+(,\d+)?$/",$num))
			{
				$offset = explode(',',str_replace("page-","",$num));
				$pages=$offset[1];
				$offset = (int)$offset[0];
				$PageMode = true;
			}
			else
			{
				throw "error: parameter Num error, Please check Num! ";
			}
			$sql_query = &$query;
			if ($PageMode == true)
			{
				if($GLOBALS['IN']['currentPage']!=''){
					$params['currentPage'] = $GLOBALS['IN']['currentPage'];
				}
				else
				{
					$params['currentPage'] = 1;
				}
				$params['pageSize'] = $offset;
				$params['returnPages']=$pages;

				//echo $sql_query;
				$data = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql_query,$params);
			}
			else
			{
				$data = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql_query.' '.$list_limit);
				$data = array('data'=>$data,'state'=>array());
			}
			
		}
		catch (Exception $e)
		{
			throw $e;
		}

		return $data;
	}

	/**
	 * <CMS　action="TABLE" return="list" name=""  num=""  order="asc" orderby ="hit"  where="" returnkey=""/> 
	 *
	 * name：表名
	 * num：条数
	 * orderby：排序方式
	 * order：升序OR降序
	 * where:查询条件
	 * returnkey：查询字段
	 * 
	 * 
	 * @param unknown_type $mParam
	 * @return unknown
	 */


	public static function CMS_TABLE($mParam)
	{
		try {
			$PageMode = false;
			extract($mParam,EXTR_PREFIX_SAME,$GLOBALS['currentApp']['table_pre']);
			$cache = empty($cache)? 0 : 2;
			//判断表明

			if (empty($name))
			{
				echo "error: table error, Please check! ";exit;
			}

			//判断条数

			if (empty($num))
			{
				$list_limit = "Limit 0,10";
			}
			elseif (preg_match("/^[0-9]+,[0-9]+$/",$num))
			{
				list($start,$end) = explode(",",$num);
				$list_limit = "Limit $start,$end ";
			}
			elseif (preg_match("/^[0-9]+$/",$num))
			{
				$list_limit = "Limit 0,$num";
			}
			elseif (preg_match("/^page-[0-9]+$/",$num))
			{
				$offset = str_replace("page-","",$num);
				$offset = (int)$offset;
				$PageMode = true;
			}
			else
			{
				echo "error: parameter Num error, Please check Num! ";exit;
			}
			

			//判断排序

			$where_orderby = empty($orderby) ? 'Order By ContentID ' : ' Order By ' . $orderby;
			if(!empty($where_orderby)) $where_order = empty($order) ? ' DESC ' :  $order;
			
			//按组排序
			$where_groupby = empty($groupby) ? '' : ' group By ' . $groupby;

			//附加条件

			if(!empty($where))
			{
				$where = "where ".$where;
			}
			else
			{
				$where = "";
			}

			//查询的字段

			if(!empty($returnkey))
			{
				foreach(explode(',', $returnkey) as $key=>$var)
				{
					if($key==0) $c_return = $var;
					else $c_return .= ",".$var;
				}
			}
			else
			{
				$c_return .= "*";
			}



			if ($PageMode == true)
			{
				if($GLOBALS['IN']['currentPage']!=''){
					$params['currentPage'] = $GLOBALS['IN']['currentPage'];
				}
				else
				{
					$params['currentPage'] = 1;
				}
				$params['pageSize'] = $offset;

				$sql_query = "SELECT $c_return FROM $name  $where  $where_groupby $where_orderby  $where_order ";
				//echo $sql_query;
				$data = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql_query,$params);
			}
			else
			{
				$sql_query = "SELECT $c_return FROM $name  $where  $where_orderby  $where_order $list_limit";
				
				$data = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql_query);
			}

		}
		catch (Exception $e)
		{
			throw $e;
		}
		return $data;
	}
	
	/*
	* 模板函数名称: 节点信息调用函数(标签调用)
	*
	* 用途: 获取指定NodeID的节点名称+节点首页的URL，返回一个2维数组
	* array(
	*		[0] => array(
	*				'Title'=> "节点名称"
	*				'URL'  => "节点首页URL"
	*		...
	*		..
	*		.
	*				)
	*	);

	<CMS action="NODELIST" return="List" Type="" NodeID="" OrderBy="" returnKey="" num="" />

	*/


	public static function CMS_NODELIST($params){
		$node = new Node();
		extract ($params, EXTR_PREFIX_SAME, $GLOBALS['currentApp']['table_pre']);

		$return = array();
		$isIgnore = false;

		if(!empty($ignore)) {
			$ignoreNodes=explode(',', $ignore);
			foreach($ignoreNodes as $val){
				$sql_ignore=" and nodeGuid<>'$val'";
			}
		}

		if (empty($num)){
			$list_limit = "Limit 0,10";
		}elseif (preg_match("/^[0-9]+,[0-9]+$/",$num)){
			list($start,$end) = explode(",",$num);
			$list_limit = "Limit $start,$end ";
		}elseif (preg_match("/^[0-9]+$/",$num)){
			$list_limit = "Limit 0,$num";
		}


		//查询的字段

		if(!empty($returnkey)){
			foreach(explode(',', $returnkey) as $key=>$var){
				if($key==0) $c_return = $var;
				else $c_return .= ",".$var;
			}
		}else{
			$c_return .= "*";
		}

		if(!empty($orderby)) {
			$list_orderby = " ORDER BY $orderby ";

		} else {
			$list_orderby = " ";
		}

		switch($type) {
			case 'son':
			case 'sub': //子节点
				if($nodeid == '') throw new Exception("Miss node id.");
				$nodes = $node->getSubNodes($nodeid,$returnkey);
//				foreach($nodes as $key=>$val){
//					if(in_array($val['nodeGuid'],$ignoreNodes)) unset($nodes[$key]);
//				}
				return $nodes;
			break;
			case 'brother': //兄节点
				if($nodeid == '') throw new Exception("Miss node id.");
				$currentNode=$node->getNodeInfo($nodeid);

				if(!empty($parentNode)){
					throw new Exception("The node \"$nodeid\" is not exists.");
				}else{
					$sql="select $c_return from {$node->nodeTableName} where parentId='{$currentNode["parentId"]}' and nodeGuid<>'{$currentNode["nodeGuid"]}' $sql_ignore order by  isOrder desc, nodeId";
					return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
				}

			break;
			case 'parent':
				if($nodeid == '') throw new Exception("Miss node id.");
				return $node->getParentNode($nodeid,$returnkey);
			break;
			case 'set':
			default:
				if($nodeid != '') {
					$NodeIDs = explode(',', $nodeid);
					foreach($NodeIDs as $key=>$var) {

						$sql = "SELECT $c_return FROM {$node->nodeTableName} WHERE nodeGuid='$var' ";

						$NodeInfo = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
						$return[] = $NodeInfo['0'];

					}
					return $return;
				}
			break;
		}

	}
	
	/**
	 * <CMS action="CONTENT" return="Var" indexId="" contentId="" nodeId="" table="" LoopMode="" returnKey="" />
	 *
	 * 只能取一个表的内容
	 * returnKey中，内容表字段用c作别名,发布表用i作另名
	 *
	 */

	public static function CMS_CONTENT($mParam){
		extract ($mParam);
		$dbinfo=$GLOBALS['currentApp']['dbaccess'];
		$node=new Node();
		
		//如果没有设置索引ID,则启用nodeId和contentId来确定内容
		if(empty($indexid)){
			$sql="select publishId from {$GLOBALS['table']['cms']['app_publish_state']} where nodeId='$nodeid' and contentId='$contentid'";
			$tmp=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
			if($tmp[0]){
				$indexid=$tmp[0]['publishId'];
			}else{
				return array();
			}
		}
		
		$publishIds=explode(',',$indexid);
		
		if(empty($table)){
			$sql="select nodeId from {$GLOBALS['table']['cms']['app_publish_state']} where publishId={$publishIds[0]}";
			$nodeId = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
			if(empty($nodeId)){
				return array();
			}else{
				$nodeId=$nodeId[0]['nodeId'];
				$currentNode=$node->getNodeInfo($nodeId);
				$table=$currentNode['appTableName'];
			}
		}
		

		if((empty($loopmode)||$loopmode==0||$loopmode=='false') && sizeof($publishIds)==1){
			$mode=false;
		}else{
			$mode=true;
		}
		
		if(!empty($returnkey)){
			foreach(explode(',', $returnkey) as $key=>$var){
				if($key==0) $c_return = $var;
				else $c_return .= ",".$var;
			}
		}else{
			$c_return .= "*";
		}
		
		$sql="select $c_return from $table c, {$GLOBALS['table']['cms']['app_publish_state']} i where c.nodeId=i.nodeId and c.{$currentNode['appTableKeyName']}=i.contentId and i.state='1' and i.isDel='0' and i.publishId in($indexid)";
		$ret=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		if(!$mode){
			$ret=$ret[0];
		}

		return $ret;
		
	}

	/**
	 * <CMS action="LIST" return="List" NodeID="" Num="" Orderby="" where="" ignore="" returnKey="" />
	 *
	 * @param unknown_type $mParam
	 */
	public static function CMS_LIST($mParam){
		extract ($mParam);
		$dbinfo=$GLOBALS['currentApp']['dbaccess'];
		$node=new Node();
		
		if(empty($indexid)){
			if(preg_match('/^all-([0-9a-zA-Z]+)$/i',$nodeid,$match)){
				$nodes=$node->getAllSubNodes($match[1],'nodeGuid');
				$firstNodeName=$nodes[0]['nodeGuid'];
				$sql_nodeid="and (";
				foreach($node->getAllSubNodes($match[1],'nodeGuid') as $subNode){
					$sql_nodeid .= " i.nodeId='{$subNode['nodeGuid']}' or";
				}
				$sql_nodeid.=" i.nodeId='{$match[1]}' )";
			}elseif(!empty($nodeid)){
				$nodesName=explode(',',$nodeid);
				$firstNodeName=$nodesName[0];
				$sql_nodeid="and (";
				foreach($nodesName as $id){
					$sql_nodeid .= " i.nodeId='$id' or";
				}
				$sql_nodeid=preg_replace('/or\s*$/i','',$sql_nodeid) .')';
			}

		}else{

			$sql_publishId="and (";
			foreach(explode(',',$indexid) as $publishId){
				$sql_publishId .= " i.publishId=$publishId or";
			}
			$sql_publishId=preg_replace('/\s+or$/i','',$sql_publishId) . ')';
			
			$sql="select nodeId from {$GLOBALS['table']['cms']['app_publish_state']} where publishId=$publishId";
			$firstNodeName=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
			$firstNodeName=$firstNodeName[0]['nodeId'];
			
		}
		
		$firstNode=$node->getNodeInfo($firstNodeName,'appTableName,appTableKeyName');
		$table=$firstNode['appTableName'];
		$appTableKeyName=$firstNode['appTableKeyName'];		
		
		if($ignore){
			$sql_ignore="and (";
			foreach(explode(',',$ignore) as $id){
				$sql_ignore .= " i.nodeId<>'$id' or";
			}
			$sql_ignore=preg_replace('/or\s*$/i','',$sql_ignore) .')';
		}

		if(!empty($returnkey)){
			foreach(explode(',', $returnkey) as $key=>$var){
				if($key==0) $c_return = "c.".$var;
				else $c_return .= ",c.".$var;
			}
		}else{
			$c_return .= "c.*";
		}

		if($orderby){
			$sql_orderby=$orderby;
		}else{
			$sql_orderby="i.top desc, i.pink desc, i.sort desc, i.publishDate DESC";
		}
		
		if(!empty($where))
		{
			$where = "and ( $where )";
		}else{
			$where = "";
		}
		
		if (empty($num)){
			$list_limit = "";
		}elseif (preg_match("/^[0-9]+,[0-9]+$/",$num)){
			list($start,$end) = explode(",",$num);
			$list_limit = "Limit $start,$end ";
		}elseif (preg_match("/^[0-9]+$/",$num)){
			$list_limit = "Limit 0,$num";
		}elseif (preg_match("/^page-\d+(,\d+)?$/",$num)){
			$offset = explode(',',str_replace("page-","",$num));
			$pages=$offset[1];
			$offset = (int)$offset[0];
			$PageMode = true;
		}else{
			throw new Exception("error: parameter Num error, Please check Num! ");
		}
		
		$sql="select i.*, $c_return from {$GLOBALS['table']['cms']['app_publish_state']} i, $table c where i.nodeId=c.nodeId and i.state='1' and i.isDel='0' and i.contentId=c.$appTableKeyName $sql_publishId $sql_nodeid $sql_table $sql_ignore $sql_table $where order by $sql_orderby $list_limit";

		
		//if($sql_orderby!="i.publishDate DESC") echo $sql;

		if ($PageMode){
			if($GLOBALS['IN']['currentPage']!=''){
				$params['currentPage'] = $GLOBALS['IN']['currentPage'];
			}else{
				$params['currentPage'] = 1;
			}
			$params['pageSize'] = $offset;
			$params['returnPages']=$pages;
			$data = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}else{
			$data = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
			$data = array('data'=>$data,'state'=>array());
		}
		
		return $data;

	}

	/*
	 * <CMS action="NODE" return="NodeVar" NodeID="" returnKey="" />
	 *
	 * 获取结点信息
	 * 返回一维数组
	 */
	public static function CMS_NODE($mParam){
		extract ($mParam);
		$node=new Node();
		$ret=array();
		
		switch(strtolower($nodeid)){
			case '':
			case 'self':
			
			break;
			case 'parent':
			
			break;
			default:
				$ret=$node->getNodeInfo($nodeid);

			break;
		}
		
		$ret['navigation']=$node->getParentNode($nodeid);
		//$ret['subNodes']=$node->getSubNodes($nodeid);
		
		return $ret;
	}
	
	
	/*
	 * <CMS action="SEARCH" return="List" NodeID="" Num="" Field="" Keywords="" Separator="" IgnoreContentID="" where="" Orderby="" TableID="" Exact="" returnKey="" />
	 *
	 */
	public static function CMS_SEARCH($mParams){
		extract ($mParams, EXTR_PREFIX_SAME, $GLOBALS['currentApp']['table_pre']);

		//返回列名
		if(!empty($returnkey)) {
			foreach(explode(',', $returnkey) as $key=>$var) {
				if($key==0) $c_return = "c.".$var;
				else $c_return .= ",c.".$var;
			}
		}else{
			$c_return .= "c.*";
		}
		
		//初始化关键字
		if(empty($Separator)) $Separator=',';
		$keywords=explode(',',$keywords);

		//初始化查询字段
		if($exact==1||$exact=='true'){
			//精确查找
			foreach(explode(',',$field) as $val){
				foreach($keywords as $keyword){
					$sql_field .= " or c.$val='$keyword'";
				}
			}
		}else{
			//模糊查找
			foreach(explode(',',$field) as $val){
				foreach($keywords as $keyword){
					$sql_field .= " or c.$val like '%$keyword%'";
				}
			}
		}
		
		if(!empty($sql_field)){
			$sql_field=preg_replace('/^\s*or\s*/i','',$sql_field);
			$sql_field="and ( $sql_field )";
		}
		
		//初始化结点
		$node=new Node;
		if(preg_match('/^all-([\w\d]+)$/i',$nodeid,$match)){
			//某个结点下的所有结点
			$sql_node="i.nodeId='{$match[1]}'";
			$nodes=$node->getAllSubNodes($match[1],"nodeGuid,appTableName,appTableKeyName");
			$table=$nodes[0]["appTableName"];
			$appTableKeyName=$nodes[0]["appTableKeyName"];
			foreach($nodes as $subNode){
				$sql_node .= " or i.nodeId='{$subNode["nodeGuid"]}'";
			}
		}else{
			//查找所有给出的结点列表
			$nodes=explode(',',$nodeid);
			$table=$node->getNodeInfo($nodes[0],"appTableName,appTableKeyName");
			$table=$table["appTableName"];
			$appTableKeyName=$table["appTableKeyName"];
			foreach($nodes as $key=>$subNode){
				if($key==0){
					$sql_node .= "i.nodeId='{$subNode["nodeGuid"]}'";
				}else{
					$sql_node .= " or i.nodeId='{$subNode["nodeGuid"]}'";
				}
			}
		}
		
		if(!empty($sql_node)) $sql_node = "and ( $sql_node )";
		
		//忽略某些文章ID
		if(!empty($ignorecontentid)){
			foreach(explode(',',$ignorecontentid) as $key=>$contentId){
				if($key==0){
					$sql_ignore="i.contentId<>$contentId";
				}else{
					$sql_ignore=" and i.contentId<>$contentId";
				}
			}
		}
		
		if(!empty($sql_ignore)) $sql_ignore = "and ( $sql_ignore )";
		
		//条件
		if(!empty($where)) $sql_where=" and $where";
		
		//排序
		if(empty($orderby)){
			$sql_order="i.top DESC, i.sort DESC, i.publishDate DESC";
		}else{
			$sql_order=$orderby;
		}
		
		$sql="select $c_return, i.nodeId, i.contentId, i.state, i.url, i.publishId indexId, i.publishDate, i.sort, i.pink from {$GLOBALS['table']['cms']['app_publish_state']} i, $table c where i.nodeId=c.nodeId and i.state='1' and i.isDel='0' and i.contentId=c.$appTableKeyName $sql_field $sql_node $sql_where $sql_ignore order by $sql_order";

		//echo $sql;
		if (empty($num)){
			$list_limit = "";
		}elseif (preg_match("/^[0-9]+,[0-9]+$/",$num)){
			list($start,$end) = explode(",",$num);
			$list_limit = "Limit $start,$end ";
		}elseif (preg_match("/^[0-9]+$/",$num)){
			$list_limit = "Limit 0,$num";
		}elseif (preg_match("/^page-\d+(,\d+)?$/",$num)){
			$offset = explode(',',str_replace("page-","",$num));
			$pages=$offset[1];
			$offset = (int)$offset[0];
			$PageMode = true;
		}else{
			throw new Exception("error: parameter Num error, Please check Num! ");
		}
		
		if ($PageMode){
			if($GLOBALS['IN']['currentPage']!=''){
				$params['currentPage'] = $GLOBALS['IN']['currentPage'];
			}else{
				$params['currentPage'] = 1;
			}
			$params['pageSize'] = $offset;
			$params['returnPages']=$pages;
			$data = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}else{
			$data = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql.' '.$list_limit);
			$data = array('data'=>$data,'state'=>array());
		}
		
		// print_r($data);
		return $data;
	}	

}


?>