<?php
/**
 * *****
 * 资源增删改以及查询资源信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.resourceManage.upload');
import('core.apprun.member.Session');
//验证是否存在
//resourceManageIsExists('username','artfantasy')
//存在返回true
function resourceIsExists($resourceManageNo)
{
	try{
		$sql = "SELECT * FROM {$GLOBALS['table']['resource']['resources']} WHERE resourceNo= :resourceNo LIMIT 1";
		$params['resourceNo'] = $resourceManageNo;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return (boolean)$result[0]['id'];
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
//
//
function listResource($sqlCon)
{
	try {
		$memberId = readSession();//获得用户的ID
		if($sqlCon!=null)
		{
			$paramStr = "'".$sqlCon."'";
			$sqlCon ='and'.$sqlCon;
		}
		$sql = "select * from {$GLOBALS['table']['resource']['resource']} where memberId='".$memberId."'".$sqlCon;
		if($GLOBALS['IN']['currentPage']!=''){
			$params['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$params['currentPage'] = 1;
		}
		if($GLOBALS['IN']['isText'])
		{
			$isText = "&isText=".$GLOBALS['IN']['isText'];
		}		
		$params['pageSize'] = 10;
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$result['pageinfo']['isText'] = $isText;
		$result['pageinfo']['wherestr'] = $paramStr;
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function std_class_object_to_array($stdclassobject)
{
    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

    foreach ($_array as $key => $value) {
        $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
        print $value;
        $array[$key] = $value;
    }

    return $array;
}
//新增一资源
//
//新增成功则返回新建资源的uid,失败则返回false;
function addResource($resourceManageArray,$fileFolder,$ajaxFlag=0,$maxFileSise=0)
{
	try
	{
		date_default_timezone_set('PRC');
		$mameberId = readSession();//获得用户的ID
		$checkData = pathinfo($GLOBALS["_FILES"]['resourceUrl']['name']);//判断文件名
		$upFileMaxSize = 0;
		if($GLOBALS["_FILES"])
		{
			foreach ($GLOBALS["_FILES"] as $key=>$val)
			{
				$upFileMaxSize = $val['size'];
			}
		}
		if($maxFileSise!=0)
		{
			if($upFileMaxSize>$maxFileSise)
			{
				return "tooMax";
			}
		}
		if($checkData['extension']=='php')
		{
			return 'disableFile';
		}
		if($ajaxFlag==1)
		{
			$upLoadFile = upload($GLOBALS["_FILES"],$fileFolder,'local');
		}else 
		{
			if(isLocalOrFtp($resourceManageArray['serverName'])=='local')
			{
				//将$_FILES数据传入函数 by yanghuan
				$upLoadFile = upload($GLOBALS["_FILES"],$fileFolder,$resourceManageArray['serverName']);
				//$upLoadFile = upload($resourceManageArray['resourceUrl'],$fileFolder,$resourceManageArray['serverName']);
			}else {
				$upLoadFile = ftpUpload($resourceManageArray['resourceUrl'],$fileFolder,$resourceManageArray['serverName']);
			}
		}
		if($upLoadFile)
		{
			foreach ($upLoadFile as $k => $v)
			{
				$data = pathinfo($v['relPath']);
				$upLoadPath = $data['dirname'];
				$upLoadFileName = $data['basename'];
				if(!$v['relPath'])
				{
					return 'noFile';
				}else {
					$resourceManageArrayNew['memberId'] = $mameberId;
					$resourceManageArrayNew['resourceUrl'] = $upLoadPath;
					$resourceManageArrayNew['fileName'] = $upLoadFileName;
					$resourceManageArrayNew['resourceDate'] = date("Y-m-d H:i:s");
					$resourceManageArrayNew['realFileName'] = $v['relFileName'];
					foreach ($resourceManageArrayNew as $key => $val)
					{
						$str_field .= $key.",";
						$str_value .= ":".$key.",";
					}
					$str_field = substr($str_field,0,-1);
					$str_value = substr($str_value,0,-1);
					$sql = "insert into {$GLOBALS['table']['resource']['resource']} (".$str_field.") values (".$str_value.")";
					$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArrayNew);
					$returnArray[] = $result;
				}
			}
		}
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function addMultFiles($resourceManageArray,$fileFolder)
{
	try
	{
		date_default_timezone_set('PRC');
		$mameberId = readSession();//获得用户的ID
		//$checkData = pathinfo($GLOBALS["_FILES"]['resourceUrl']['name']);//判断文件名
//		if($checkData['extension']=='php')
//		{
//			return 'disableFile';
//		}
		if(isLocalOrFtp($resourceManageArray['serverName'])=='local')
		{
			//将$_FILES数据传入函数 by yanghuan
			$upLoadFile = uploadMultFiles($GLOBALS["_FILES"]['resourceUrl'],$fileFolder,$resourceManageArray['serverName']);
		}else {
			$upLoadFile = ftpUpload($resourceManageArray['resourceUrl'],$fileFolder,$resourceManageArray['serverName']);
		}
		foreach ($upLoadFile as $k => $v)
		{
			$str_field = "";
			$str_value = "";
			$data = pathinfo($v['relPath']);
			$upLoadPath = $data['dirname'];
			$upLoadFileName = $data['basename'];
			if(!$v['relPath'])
			{
				return 'noFile';
			}else {
				$resourceManageArray['memberId'] = $mameberId;
				$resourceManageArray['resourceUrl'] = $upLoadPath;
				$resourceManageArray['fileName'] = $upLoadFileName;
				$resourceManageArray['resourceDate'] = date("Y-m-d H:i:s");
				$resourceManageArray['realFileName'] = $v['relFileName'];
				foreach ($resourceManageArray as $key => $val)
				{
					$str_field .= $key.",";
					$str_value .= ":".$key.",";
				}
				$str_field = substr($str_field,0,-1);
				$str_value = substr($str_value,0,-1);
				$sql = "insert into {$GLOBALS['table']['resource']['resource']} (".$str_field.") values (".$str_value.")";
				$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArray);
				$returnArray[] = $result;
			}
		}
		return $returnArray;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//远程图片保存到本地$url为远程图片地址
function addImageToResource($url,$folder,$picName='')
{
	try {
		//@header("Content-Type:text/html;charset=utf-8");
		//$TimeLimit=3600; /*设置超时限制时间 缺省时间为30秒 设置为0时为不限时 */
		//set_time_limit($TimeLimit);
		$getPathInfo = pathinfo($url);
		$mameberId = readSession();//获得用户的ID
		if(!$mameberId)
		{
			$mameberId = "anonymous";
		}
		if($picName=='')
		{
			$picName = md5(date("Ymd His").random2(4)).".".$getPathInfo['extension'];
		}
		if($folder!='')
		{
			$relPath = '/upfiles/'.$folder.'/'.$mameberId."/".date("Y-m-d")."/";//以会员的账户创建一个文件夹
			$destination_folder = $GLOBALS['currentApp']['domainpath'].'/resource/upfiles/'.$folder.'/'.$mameberId."/".date("Y-m-d")."/";//以会员的账户创建一个文件夹
		}else 
		{
			$relPath = '/upfiles/'.$mameberId."/".date("Y-m-d")."/";//以会员的账户创建一个文件夹
			$destination_folder = $GLOBALS['currentApp']['domainpath'].'/resource/upfiles/'.$mameberId."/".date("Y-m-d")."/";//以会员的账户创建一个文件夹
		}
		$dirClass = new Html();
		$dirClass->createdir($destination_folder);
		$newfname = $destination_folder .$picName;
		
		$file = fopen ($url, "rb");
		if ($file) {
			$newf = fopen ($newfname, "wb");
			if ($newf)
			while(!feof($file)) {
				fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
			}
		}
		if ($file) {
			fclose($file);
		}
		if ($newf) {
			fclose($newf);
		}
		$data = pathinfo($newfname);
		$upLoadPath = $data['dirname'];
		$upLoadFileName = $data['basename'];
		if(!$newfname)
		{
			return 'noFile';
		}else {
			$resourceManageArray['memberId'] = $mameberId;
			$resourceManageArray['resourceUrl'] = $relPath;
			$resourceManageArray['fileName'] = $upLoadFileName;
			$resourceManageArray['resourceDate'] = date("Y-m-d H:i:s");
			$resourceManageArray['realFileName'] = "taobao.jpg";
			foreach ($resourceManageArray as $key => $val)
			{
				$str_field .= $key.",";
				$str_value .= ":".$key.",";
			}
			$str_field = substr($str_field,0,-1);
			$str_value = substr($str_value,0,-1);
			$sql = "insert into {$GLOBALS['table']['resource']['resource']} (".$str_field.") values (".$str_value.")";
			$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArray);
			$url = selectResource($result);
		}
		return $url;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//修改指定uid的资源信息,传入变量请按照会员信息的字段组成数组传入
//
//失败返回false, 成功返回影响行数
function editResource($resourceManageId,$resourceManageArray)
{
	try
	{
		if(!is_int($resourceManageId)) return false;
		foreach ($resourceManageArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['resource']['resource']} set $sql where resourceId=".$resourceManageId;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}

//根据某资源属性删除资源,比如根据uid,email
function delResource($resourceManageId)
{
	try
	{
		$delUrl = getResourceInfoById($resourceManageId);
		//print $delUrl;
		$delUrl = $GLOBALS['attachapp']['resource']['path'].$delUrl;
		//print $delUrl;exit;
		$sql = "DELETE FROM {$GLOBALS['table']['resource']['resource']} WHERE `resourceId`=:resourceId";
		$params['resourceId'] = $resourceManageId;
		unlink("$delUrl");
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//传入资源ID，查询资源所有信息
function getResourceInfoById($resourceManageId)
{
	try
	{
		$sql = "select * from {$GLOBALS['table']['resource']['resource']} where resourceId= {$resourceManageId}";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if(!empty($result))
		{
			$strPID = $resourceManageId."|".$result[0]['resourceUrl'].'|'.$result[0]['fileName']."|".$result[0]['serverName'];
			$strPID = base64_encode($strPID);
			$returnUrlStr = "/web-inf/lib/coreconfig/res.php?PID=".$strPID.",";
			$result[0]['pageUrl'] = $returnUrlStr;
			$result[0]['downUrl'] = $result[0]['resourceUrl'].'/'.$result[0]['fileName'];
			$fileData = pathinfo($result[0]['fileName']);
			$result[0]['extension'] = $fileData['extension'];
		}
		return $result;
		//return $result[0]['resourceUrl'].'/'.$result[0]['fileName'];
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 选择资源服务器
 * */
function serverSelect()
{
	try
	{	$str = "<select name='para[serverName]'>";
	//$str .="<option value=''></option>";
	//print_r($GLOBALS['app']);
	$resourceArray = $GLOBALS['currentApp']['resourceconfig'];
	
	foreach ($resourceArray as $key => $val){
		if($val['servername'])
		{
			$str .="<option value='".$key."'>".$val['servername']."</option>";
		}
	}
	$str .= "</select>";
	return $str;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * 
 * 判断上传资源的方式是LOCAL还是FTP
 * **/
function isLocalOrFtp($serverName)
{
	try {
		$resourceArray = $GLOBALS['currentApp']['resourceconfig'];
		foreach($resourceArray as $key => $val)
		{
			if($key==$serverName)
			{
				return $val['servermode'];
			}
		}
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 
 * 添加会员信息到resource中
 * **/
function addMember($memberArray)
{
	try {
		foreach ($resourceManageArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['resource']['resource']} (".$str_field.") values (".$str_value.")";
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArray);
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 
 * 获得会员信息到resource中
 * **/
function getMemberInfo($memberId)
{
	try {
		
		$sql = "select * from {$GLOBALS['table']['resource']['resource']} where resourceId= {$resourceManageId}";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e){
		throw $e;
	}
}

/**
 * 选择资源上传资源类型函数
 * */
function selectResourceType()
{
	try
	{	
		$str = "<select id='resourceType' name='para[resourceType]' onChange='selectTypeValue(this.value);'>";
		$str .="<option value=''>请选择</option>";
		$resourceArray = explode('|',$GLOBALS['app']['resourcetype']);
		$resourceOptionName = explode(',',$resourceArray[0]);
		$resourceOptionValue = explode(',',$resourceArray[1]);
		for($i=0;$i<count($resourceOptionName);$i++)
		{
			$str .="<option value='".$resourceOptionValue[$i]."'>".$resourceOptionName[$i]."</option>";
		}
		$str .= "</select>";
		return $str;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 选择资源上传的资源属于哪个应用函数
 * */
function selectResourceApp()
{
	try
	{	
		$str = "<select id='appId' name='para[appId]' onChange='selectAppValue(this.value);'>";
		$str .="<option value=''>请选择</option>";
		$resourceArray = explode('|',$GLOBALS['app']['resourceOfApp']);
		$resourceOptionName = explode(',',$resourceArray[0]);
		$resourceOptionValue = explode(',',$resourceArray[1]);
		for($i=0;$i<count($resourceOptionName);$i++)
		{
			$str .="<option value='".$resourceOptionValue[$i]."'>".$resourceOptionName[$i]."</option>";
		}
		$str .= "</select>";
		return $str;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 上传资源日期路径
 * */
function selectDateUrl()
{
	try
	{	
		$Ymd = date("Ymd");
		$Year = date("Y");
		$Ym = date("Ym");
		$ymd = date("Y/md");
		$definition = '自定义目录';
		$str = "<input type='radio' name='radio' value='".$Year."' onClick='setPath(this.value)'>".$Year;
		$str .= "<input type='radio' name='radio' value='".$Ym."' onClick='setPath(this.value)'> ".$Ym;
		$str .= "<input type='radio' name='radio' value='".$Ymd."' onClick='setPath(this.value)'>".$Ymd;
		$str .= "<input type='radio' name='radio' value='".$ymd."' onClick='setPath(this.value)'> ".$ymd;
		$str .= "<input type='radio' name='radio' value='".$definition."'onClick='setPath(this.value)'>".$definition;
		return $str;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 其它应用获得已有资源的URL
 * */
function selectResource($resourceManageIdArray)
{
	try
	{
		if(is_array($resourceManageIdArray))
		{
			for($i=0;$i<count($resourceManageIdArray);$i++)
			{
				$sql = "select * from {$GLOBALS['table']['resource']['resource']} where resourceId= {$resourceManageIdArray[$i]}";
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				//print $result[0]['resourceUrl'].'/'.$result[0]['fileName'];
				//return $result[0]['resourceUrl'].'/'.$result[0]['fileName'];
				$strPID = $resourceManageId."|".$result[0]['resourceUrl'].'|'.$result[0]['fileName']."|".$result[0]['serverName'];
				$strPID = base64_encode($strPID);
				$returnUrlStr .= "res.php?PID=".$strPID.",";
			}
		}else
		{
			$sql = "select * from {$GLOBALS['table']['resource']['resource']} where resourceId= {$resourceManageIdArray}";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			//print $result[0]['resourceUrl'].'/'.$result[0]['fileName'];
			//return $result[0]['resourceUrl'].'/'.$result[0]['fileName'];
			$strPID = $resourceManageId."|".$result[0]['resourceUrl'].'|'.$result[0]['fileName']."|".$result[0]['serverName'];
			$strPID = base64_encode($strPID);
			$returnUrlStr .= "res.php?PID=".$strPID.",";
		}
		
		$returnUrlStr = substr($returnUrlStr,0,-1);
		return $returnUrlStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 新上传的资源文件存入到资源的关联表中
 * */
function addResourceAsApp($resourceManageArray,$appId,$type)
{
	try
	{
		$resourceManageArray['memberId'] = readSession();
		$resourceManageArray['appId'] = $appId;
		$resourceManageArray['type'] = $type;
		$isCheckParams = isCheckResourceAsApp($resourceManageArray);
		if($isCheckParams)
		{
			$resourceManageArray['relationId'] = $isCheckParams[0]['relationId'];
			if($isCheckParams[0]['resourceId'])
			{
				delResource($isCheckParams[0]['resourceId']);
			}
			foreach ($resourceManageArray as $key => $val)
			{
				$updateStr .= $key."=:".$key.",";
			}
			$updateStr = substr($updateStr,0,-1);
			$sql = "update {$GLOBALS['table']['resource']['resource_app']} set ".$updateStr." where relationId=:relationId";
			//print $sql;exit;
			return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArray);
		}else 
		{
			foreach ($resourceManageArray as $key => $val)
			{
				$str_field .= $key.",";
				$str_value .= ":".$key.",";
			}
			$str_field = substr($str_field,0,-1);
			$str_value = substr($str_value,0,-1);
			$sql = "insert into {$GLOBALS['table']['resource']['resource_app']} (".$str_field.") values (".$str_value.")";
			return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArray);
		}
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

/**
 * 检测关联表中是否有某个应用的资源记录
 * */

function isCheckResourceAsApp($resourceManageArray)
{
	try
	{
		$con = "where ";
		$i = 0;
		foreach ($resourceManageArray as $key => $val)
		{
			if($key!='resourceId')
			{
				$i++;
				if($i!=1)
				{
					$con .= " and ".$key."='".$val."'";
				}else {
					$con .= $key."='".$val."'";
				}
			}
		}
		$sql = "select * from {$GLOBALS['table']['resource']['resource_app']} ".$con;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArray);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 删除关联表中某个应用的资源记录
 * */
function delResourceAsApp($resourceManageArray,$appId,$type)
{
	try
	{
		$resourceManageArray['memberId'] = readSession();
		$resourceManageArray['appId'] = $appId;
		$resourceManageArray['type'] = $type;
		$con = "where ";
		$i = 0;
		foreach ($resourceManageArray as $key => $val)
		{
			if($key!='resourceId')
			{
				$i++;
				if($i!=1)
				{
					$con .= " and ".$key."='".$val."'";
				}else {
					$con .= $key."='".$val."'";
				}
			}
		}
		$sql = "delete from {$GLOBALS['table']['resource']['resource_app']} ".$con;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$resourceManageArray);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
?>