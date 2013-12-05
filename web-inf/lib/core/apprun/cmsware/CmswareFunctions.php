<?php
/**
 * 一些基础的函数和类
 * 类 iWPC
 */
class iWPC{
	var $nodeInfo_cached = array();
	var $nodeInfo_savePath = '';
	var $CacheFileHeader = "<?php\n//CMS cache file, DO NOT modify me!\n//Created on " ;
	var $CacheFileFooter = "\n?>";

	// load the cagegory cache info from filesystem
	function iWPC()
	{
		$this->nodeInfo_savePath = SYS_PATH."sysdata/sysinfo";
	}

	function loadNodeInfo($NodeID,$field='*',$isSave = true) 
	{
		global $db, $table;
		
		if(isset($this->nodeInfo_cached[$NodeID])) {
			if ($field == '*') return $this->nodeInfo_cached[$NodeID];
			else return $this->nodeInfo_cached[$NodeID][$field];
		}
		
		$nodeInfoPath = $this->_makeNodeInfoSavePath($NodeID);
		
		
		if(file_exists($nodeInfoPath['fullpath'])) {
			@include($nodeInfoPath['fullpath']);
			AutoGetTpl($NodeInfo);
			$returnInfo = $NodeInfo;
			
			unset($NodeInfo);
			if ($isSave) {
				$this->nodeInfo_cached[$NodeID] = $returnInfo;
			}

			if ($field == '*') {
				return $returnInfo;
			} elseif($field != '') {
				return $returnInfo[$field];
			} else {
				return $returnInfo;
			}
		} else {
			if($this->makeNodeInfo($NodeID)) {
				return $this->loadNodeInfo($NodeID,$field,$isSave);
			} else {
				$result = $db->Execute("select $field from $table->site where NodeID='".$NodeID."'  AND Disabled=0");
				if($result->fields == '') {
					return false;
				}
				AutoGetTpl($result->fields);
				if ($isSave) {
					$this->nodeInfo_cached[$NodeID] = $result->fields;
				}
				if ($field == '*') {
					return $result->fields;
				} elseif($field != '') {
					return $result->fields[$field];
				} else {
					return $result->fields;
				}
			}
		}
	}
	
	
	// make the category cache  save path info
	function _makeNodeInfoSavePath($NodeID)
	{
		
		global $is_safe_mode;
		if($NodeID < 10) {
			$strNodeID = '000'.strval($NodeID);
		} elseif($NodeID < 100) {
			$strNodeID = '00'.strval($NodeID);
		} elseif($NodeID < 1000) {
			$strNodeID = '0'.strval($NodeID);
		} else {
			$strNodeID = strval($NodeID);
		}
		
		$thousandDirName = "c".substr($strNodeID, 0, strlen($strNodeID)-3);
		$hundredDirName = "c".substr($strNodeID, -3,1);

		if($is_safe_mode) {
			$saveInfo['path'] = $this->nodeInfo_savePath;
			$saveInfo['filename'] = 'node'.$strNodeID.'.php';
			$saveInfo['fullpath'] = $saveInfo['path'].'/'.$saveInfo['filename'];
		
			return $saveInfo;
		
		} else {
			//$saveInfo['path'] = $this->nodeInfo_savePath.'/'.$thousandDirName.'/'.$hundredDirName;
			//$saveInfo['filename'] = 'node'.$strNodeID.'.php';
			//$saveInfo['fullpath'] = $saveInfo['path'].'/'.$saveInfo['filename'];
		
			//return $saveInfo;
			$saveInfo['path'] = $this->nodeInfo_savePath;
			$saveInfo['filename'] = 'node'.$strNodeID.'.php';
			$saveInfo['fullpath'] = $saveInfo['path'].'/'.$saveInfo['filename'];
		
			return $saveInfo;

		}

	}
	
	
	//if the category cache info does not exit ,we can creat it
	function makeNodeInfo($NodeID)
	{
		if(empty($NodeID))	return false;
		global $db,$db_config, $table;
		
		if(is_null ($db)) {
			require_once KDB_DIR.'kDB.php';
			$db = new kDB($db_config['db_driver']);
			$db->connect($db_config);
		}
		$result = $db->Execute("select * from $table->site where NodeID='".$NodeID."'  AND Disabled=0");
		if(empty($result->fields[NodeID]))	return false;

		
		$resultInfo = $result->fields;
		AutoGetTpl($resultInfo);
		$resultInfo[SubNodeID] = $this->getSubNodeID($resultInfo[NodeID],'%');
		$resultInfo[ParentNodeID] = $this->getParentNodeID($resultInfo[NodeID]);
		//---------------		
		$resultInfo[Nav] = $this->getParent($resultInfo[NodeID],$resultInfo[Name]);
		$data = $this->_parsePSN($resultInfo[publishPSN],$resultInfo[ParentID]);
		if(is_array($data)) {
			foreach($data as $key=>$var) {
				$resultInfo[$key] = $var; 
			}
		
		}

		if(preg_match("/\{TID:([0-9]+)\}/isU", $resultInfo['IndexTpl'], $matches)) { 
				require_once INCLUDE_PATH."admin/cate_tpl_admin.class.php";
				if(!isset($cate_tpl)) {
	 				$cate_tpl = new cate_tpl_admin();			
				}
 				$TID = $matches[1];
				$TInfo = $cate_tpl->getInfo($TID);
				$resultInfo['IndexTpl']="/ROOT/".$TInfo[TCID]."/".$TInfo[TID].".tpl";
				$resultInfo['IndexTplTID']= $TInfo[TID];
				$resultInfo['IndexTplTCID']= $TInfo[TCID];
		
		}

		if(preg_match("/\{TID:([0-9]+)\}/isU", $resultInfo['ContentTpl'], $matches)) { 
				require_once INCLUDE_PATH."admin/cate_tpl_admin.class.php";
				if(!isset($cate_tpl)) {
	 				$cate_tpl = new cate_tpl_admin();
				}
 				$TID = $matches[1];
				$TInfo = $cate_tpl->getInfo($TID);
				$resultInfo['ContentTpl']="/ROOT/".$TInfo[TCID]."/".$TInfo[TID].".tpl";
				$resultInfo['ContentTplTID']= $TInfo[TID];
				$resultInfo['ContentTplTCID']= $TInfo[TCID];
		
		}

		if(preg_match("/\{TID:([0-9]+)\}/isU", $resultInfo['ImageTpl'], $matches)) { 
				require_once INCLUDE_PATH."admin/cate_tpl_admin.class.php";
				if(!isset($cate_tpl)) {
	 				$cate_tpl = new cate_tpl_admin();			
				}

 				$TID = $matches[1];
				$TInfo = $cate_tpl->getInfo($TID);
				$resultInfo['ImageTpl']="/ROOT/".$TInfo[TCID]."/".$TInfo[TID].".tpl";
				$resultInfo['ImageTplTID']= $TInfo[TID];
				$resultInfo['ImageTplTCID']= $TInfo[TCID];
		
		}

		//---------------
		$resultInfo['ContentPSN'] = str_replace('{NodeID}', $NodeID, $resultInfo['ContentPSN']);
		$resultInfo['ContentURL'] = str_replace('{NodeID}', $NodeID, $resultInfo['ContentURL']);
		$resultInfo['ResourceURL'] = str_replace('{NodeID}', $NodeID, $resultInfo['ResourceURL']);
		$resultInfo['ResourcePSN'] = str_replace('{NodeID}', $NodeID, $resultInfo['ResourcePSN']);
		$resultInfo['URL'] = $this->getNodeUrl($resultInfo); 
		$resultInfo['Navigation'] = $this->getParentArray($resultInfo[NodeID],$resultInfo[Name]);
		if($resultInfo['NodeID'] == '') {
			return false;
		}
		$saveInfo = $this->_makeNodeInfoSavePath($NodeID);
		
		if(is_dir($saveInfo['path'])) {
			$cateInfo = var_export($resultInfo, true);
			$cateInfo = '$NodeInfo = '.$cateInfo.";";
			if($this->_writeCache($saveInfo['fullpath'],$cateInfo))
				return true;
			else
				return false;
		} else {
			if(CMSware_mkDir($saveInfo['path'], 0777)) {
				$cateInfo = var_export($resultInfo, true);
				$cateInfo = '$NodeInfo = '.$cateInfo.";";
				if($this->_writeCache($saveInfo['fullpath'],$cateInfo))
					return true;
				else
					return false;
			} else
				return false;
		}
			
		

		//CMSware_mkDir($directory,$mode = 0777)
	}
	
	function delNodeInfo($NodeID)
	{
		global $iWPC;
		$cInfo = $iWPC->loadNodeInfo($NodeID);
		$data = explode('%', $cInfo[SubNodeID]);
		foreach($data as $var) {
			if(empty($var)) continue;

			$saveInfo = $this->_makeNodeInfoSavePath($var);
			@unlink($saveInfo['fullpath']);


		}
				

	}
	function clearALLNodeInfo()
	{
		if($this->nodeInfo_savePath != '')	return clearDir($this->nodeInfo_savePath, 'index.html;.htaccess');
		
	}



	//write the data into the cache file
	function _writeCache($savePath,$cacheData)
	{	
		$cacheData = $this->CacheFileHeader.date("F j, Y, H:i")."\n\n".$cacheData.$this->CacheFileFooter;
		$handle = @fopen($savePath,'w');
		@flock($handle,3);  //这里可以改为 读写均锁?。
		if(@fwrite($handle,$cacheData)) {
			@fclose($handle);
			return true;
		} else {
			@fclose($handle);
			return false;
		}
		
	}

	function getSubNodeID($NodeID, $header)
	{

		$output = $NodeID.$this->_getSubNodeID($NodeID,$header);
		return $output;
	
		
	}

	function _getSubNodeID($NodeID = NULL, $header = NULL)
	{
		global $db,$table;


			$sql = "select * from $table->site where ParentID='".$NodeID."'  AND Disabled=0";
			$result = $db->Execute($sql);
			while (!$result->EOF) {	
 				$output .= $header.$result->fields[NodeID];


				$NUM= $db->Execute("SELECT COUNT(*) as nr  FROM $table->site where ParentID='".$result->fields[NodeID]."'  AND Disabled=0");
				if(!empty($NUM->fields[nr]))
					$output .= $this->_getSubNodeID($result->fields[NodeID],$header);

				$result->MoveNext();
			}
			
			return $output;
	
		
	}

	function getParentNodeID($NodeID)
	{
		$output = $this->_getParent($NodeID);
		$data = explode(',', $output);
		foreach($data as $key=>$var) {
			if(empty($var))	continue;
			
			$tmp = explode('=', $var);
			if($key == 0) {
				$return = $tmp[0];
			} else {
				$return .= '%'.$tmp[0];
			
			}
		}

		return $return;
	
	}

	function getParent($NodeID, $Name)
	{
		
		$output = $this->_getParent($NodeID);
		$data = explode(',', $output);

		foreach($data as $var) {
			if(empty($var))	continue;

			list($variable,$value) = explode('=', $var);

			$return[] = array(
				'NodeID'=>$variable,
				'Name'=>$value,

			);
		}
		//debug($output);
		return serialize($return);
	
		
	}

	function getParentArray($NodeID, $Name)
	{
		
		$output = $this->_getParent($NodeID);
		$data = explode(',', $output);

		foreach($data as $var) {
			if(empty($var))	continue;

			list($variable,$value) = explode('=', $var);
			$tmpInfo = $this->getNodeInfo($variable);
			$return[] = array(
				'NodeID'=>$variable,
				'Name'=>$value,
				'URL'=> $this->getNodeUrl($tmpInfo),
				'NodeName'=>$value,
				'NodeURL'=> $this->getNodeUrl($tmpInfo),

			);
		}
		//debug($output);
		return $return;
	
		
	}
/*
ftp://user:password@www.iwpcchina.com:21/724cn/aa/global
file:/www/html/iwpcchina.com/news/global
file:d:/php/iwpc/templates
parent:global
sys:hawking
*/
	function _parsePSN($psn,$ParentID)
	{	global $SYS_ENV,$iWPC;
		$patt = "/sys:(.*)/si";
		
		if (preg_match($patt, $psn, $matches)) 
		{	
			$data = substr($SYS_ENV[installPath],0, -1);
			if($data != '/')
				$output[publish_path] = $SYS_ENV[installPath].'/'.$matches[1].'/';
			else
				$output[publish_path] = $SYS_ENV[installPath].$matches[1].'/';
			
			$output[publish_type] = 'local';
			$output[publish_ftp_host] = '';
			$output[publish_ftp_port] = '';
			$output[publish_ftp_user] = '';
			$output[publish_ftp_pass] = '';
			

			return $output;

		} 

		$patt = "/file:(.*)/si";
		if (preg_match($patt, $psn, $matches)) 
		{	
			$output[publish_path] = $matches[1].'/';
			
			$output[publish_type] = 'local';
			$output[publish_ftp_host] = '';
			$output[publish_ftp_port] = '';
			$output[publish_ftp_user] = '';
			$output[publish_ftp_pass] = '';
			

			return $output;

		} 

		$patt = "/parent:(.*)/si";
		if (preg_match($patt, $psn, $matches)) 
		{	
			$cInfo = $iWPC->loadNodeInfo($ParentID);
			if($cInfo[publish_type] == 'local') {
				$output[publish_path] = $cInfo[publish_path].$matches[1].'/';
				
				$output[publish_type] = 'local';
				$output[publish_ftp_host] = '';
				$output[publish_ftp_port] = '';
				$output[publish_ftp_user] = '';
				$output[publish_ftp_pass] = '';
			
			} elseif($cInfo[publish_type] == 'remote') {
				$output[publish_path] = $cInfo[publish_path].$matches[1].'/';
				$output[publish_type] = 'remote';
				$output[publish_ftp_host] = $cInfo[publish_ftp_host];
				$output[publish_ftp_port] = $cInfo[publish_ftp_port];
				$output[publish_ftp_user] = $cInfo[publish_ftp_user];
				$output[publish_ftp_pass] = $cInfo[publish_ftp_pass];
			
			}

			return $output;

		} 
//ftp://user:password@www.iwpcchina.com:21/724cn/aa/global

		$patt = "/ftp:\/\/([a-zA-Z0-9-_]+):([a-zA-Z0-9-_]+)@([a-zA-Z0-9-_\.]+):([0-9]+)(.*)/si";
		if (preg_match($patt, $psn, $matches)) 
		{	
			$output[publish_path] = $matches[5].'/';
			
			$output[publish_type] = 'remote';
			$output[publish_ftp_host] = $matches[3];
			$output[publish_ftp_port] = $matches[4];
			$output[publish_ftp_user] = $matches[1];
			$output[publish_ftp_pass] = $matches[2];
			
			return $output;


		} 
		//debug($output);exit;

	}


	function _getParent($NodeID = '')
	{
		global $db,$table;

			if(empty($NodeID))	return false;
			$sql = "select NodeID,Name,ParentID from $table->site where NodeID='".$NodeID."'  AND Disabled=0";
			$result = $db->getRow($sql);
			$output = $result[NodeID].'='.$result[Name].',';
			if($result[ParentID] != 0) {
				$output = $this->_getParent($result[ParentID]).$output;
			} 

			return $output;
	
	}
	
	function getNodeInfo($NodeID)
	{
		global $table,$db;

		$sql  ="SELECT * FROM $table->site  WHERE NodeID='".$NodeID."' AND Disabled=0";
		$result = $db->getRow($sql);
		AutoGetTpl($result);
		return $result;
	}

	function getNodeUrl($NodeInfo) 
	{	
			global $SYS_ENV;
 			if($NodeInfo['PublishMode'] == 1) {
				$publishFileName = $NodeInfo['IndexName'];
				$publishFileName = str_replace('{NodeID}', $NodeInfo['NodeID'], $publishFileName);

				foreach($NodeInfo as $key=>$var) {
					$publishFileName = str_replace('{'.$key.'}', $var, $publishFileName);
				
				}
				if(preg_match("/\{(.*)\}/isU", $publishFileName , $match)) {
					eval("\$fun_string = $match[1];");
					$publishFileName = str_replace($match[0], $fun_string, $publishFileName );

				}

				//support {PSN:1}/software/{NodeID}
				$NodeInfo[ContentURL] = str_replace('{NodeID}', $NodeInfo['NodeID'], $NodeInfo[ContentURL]);
				$patt = "/{PSN-URL:([0-9]+)}([\S]*)/is";
				if(preg_match ($patt, $NodeInfo[ContentURL] ,$matches)) {
					$PSNID = $matches[1];
					$publish_path = $matches[2];
					if(!class_exists('psn_admin')) {
						include(INCLUDE_PATH.'admin/psn_admin.class.php');
					}
					$psnInfo = psn_admin::getPSNInfo($PSNID);

					$url = $psnInfo[URL].$publish_path.'/'.$publishFileName;


				} else {
					$url = $NodeInfo[ContentURL].'/'.$publishFileName;
				}			
			} elseif($NodeInfo['PublishMode'] == 2 || $NodeInfo['PublishMode'] == 3) {
				$url = str_replace('{NodeID}', $NodeInfo['NodeID'], $NodeInfo['IndexPortalURL']);
				$url = str_replace('{Page}', 0, $url);
			
			}


			$url = formatPublishFile($url);
			return $url;
	}

	function getDomain($NodeID)
	{
		global $SYS_ENV;
		if($NodeID == 0) {
			$cate_info[domain]=$SYS_ENV[hostname];
			return $cate_info;
		}
		$cate_info = $this->loadNodeInfo($NodeID);
		//debug($cate_info);
		if(!empty($cate_info[domain])) {		
			return	$cate_info;
		}elseif($cate_info[NodeID]==0) {
			$cate_info[domain]=$SYS_ENV[hostname]."/";
			//$cate_info[publish_path]="";
			return $cate_info;
		}else {
			//echo 'aaaaaaaaaa';
			return $this->getDomain($cate_info[ParentID]);
		}
	}
}

?>