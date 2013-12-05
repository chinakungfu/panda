<?php
/**
 * 节点处理类，主要获得节点信息
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
//import('core.apprun.cmsware.CmswareInit');
class Node
{
	var $NodeInfo;
	var $dbinfo;
	var $nodeTableName;
	
	public function Node(){
		$this->dbinfo=$GLOBALS['currentApp']['dbaccess'];
		$this->nodeTableName=$GLOBALS['table']['cms']['site'];
	}
	
	public function __contruct(){
		$this->Node();
	}

	/**
	 * 获得节点信息数组
	 *
	 * @param unknown_type $mNodeId
	 * @return unknown
	 */
	public function getNodeInfo($mNodeId,$returnkey="*"){
		if(empty($returnkey)) $returnkey="*";
		try {
			foreach(explode(',', $returnkey) as $key=>$var){
				if($key==0) $c_return = $var;
				else $c_return .= ",".$var;
			}
			$sqlStr = "select $c_return from {$this->nodeTableName} where nodeGuid = :nodeId ";
			$mNodeInfo = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlStr,array('nodeId'=>$mNodeId));
			//print_r($mNodeInfo);
			if (!empty($mNodeInfo)){
				return $mNodeInfo[0];
			}else{
				//echo "node \"$mNodeId\" is not exist!";
			}
		}catch (Exception $e){
			throw $e;
		}
	}
	/**
	 * getSubNodes array
	 *
	 * @param unknown_type $mNodeId
	 * @return unknown
	 */
	public function getSubNodes($mNodeId,$returnkey="*"){
		if(empty($returnkey)) $returnkey="*";
		try{
			foreach(explode(',', $returnkey) as $key=>$var){
				if($key==0) $c_return = $var;
				else $c_return .= ",".$var;
			}
			
			$sqlStr = "select $c_return from {$this->nodeTableName} where parentId = '$mNodeId' order by  isOrder desc, nodeId";
			$mSubNodeId = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlStr,array('nodeId'=>$mNodeId));
			
			if (!empty($mSubNodeId)) $subNodeIds = $mSubNodeId;

		}catch (Exception $e){
			throw $e;
		}
		return $subNodeIds;
	}
	
	public function getAllSubNodes($mNodeId,$returnkey="*"){
		if(empty($returnkey)) $returnkey="*";
		$ret=array();

		$node=$this->getNodeInfo($mNodeId,$returnkey);
		if($subNodes=$this->getSubNodes($node['nodeGuid'],$returnkey)){
			$ret=array_merge($ret,$subNodes);
			foreach($subNodes as $subNode){
				$ret=array_merge($ret,$this->getAllSubNodes($subNode['nodeGuid'],$returnkey));
			}
		}
		return $ret;
	}
	/**
	 * 获得父结点
	 *
	 * @param unknown_type $mNodeId
	 * @return unknown
	 */
	public  function getParentNode($mNodeId,$returnkey="*"){
		if(empty($returnkey)) $returnkey="*";
		try{
			foreach(explode(',', $returnkey) as $key=>$var){
				if($key==0) $c_return = "p.".$var;
				else $c_return .= ",p.".$var;
			}
			
			$oNode=new Node;
			$currentNode=$oNode->getNodeInfo($mNodeId,$returnkey="*");
			$i=0;
			do{
				$sqlStr = "select $c_return from {$this->nodeTableName} p,{$this->nodeTableName} n  where p.nodeGuid=n.parentId and n.nodeGuid='$mNodeId'";
				$node=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlStr);
				$ret[$i++]=$node[0];
			}while($mNodeId=$node[0]['parentId']);
		}catch (Exception $e){
			throw $e;
		}
		$ret=array_reverse($ret);
		$ret[$i]=$currentNode;
		return $ret;
	}
}

function getAllNodeForSelect($nodeId='0',$level=0){
	$sql="select nodeName, nodeGuid from {$GLOBALS['table']['cms']['site']} where parentId='$nodeId'";
	$html="";
	$levelStr="";
	for($i=0;$i<$level;$i++){
		$levelStr.="-";
	}
	$nodes=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	
	if(!empty($nodes)){
		foreach($nodes as $node){
			$html .="<option value='{$node['nodeGuid']}'>$levelStr{$node['nodeName']}</option>";
			$html .=getAllNodeForSelect($node['nodeGuid'],$level+1);
		}
	}
	return $html;
}


?>