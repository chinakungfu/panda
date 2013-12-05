<?php
import('core.tpl.TplTemplate');
import('core.apprun.member.Session');
import('core.apprun.resourceManage.ascll');
import('core.apprun.resourceManage.dirOperation');
function getResourceUpLoadPath($serverName)
{
	try {
		$resourceArray = $GLOBALS['currentApp']['resourceconfig'];

		foreach($resourceArray as $key => $val)
		{
			if($key==$serverName)
			{
				//$arrayLocate['locate'] = $val['locate'];
				//$arrayLocate['locateurl'] = $val['locateurl'];
				return $val['locate'];
			}
		}
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 上传资源到本地机上
 * $uploadFileo为上传的源文件
 * $newFolder用户是否要新建文件夹
 * $serverName为存放资源的服务器
 * */
function upload($upLoadFile,$newFolder,$serverName)
{
	try {
		@header("Content-Type:text/html;charset=utf-8");
		//$TimeLimit=0; /*设置超时限制时间 缺省时间为30秒 设置为0时为不限时 */
		//set_time_limit($TimeLimit);

		
		if($upLoadFile)
		{
			foreach ($upLoadFile as $k=>$v)
			{
				//$arrayLocate = getResourceUpLoadPath($serverName);
				//$upLoadPath = getResourceUpLoadPath($serverName);
				//$upLoadPath = $GLOBALS['currentApp']['apppath'].'/'.$arrayLocate['locate'].'/'.readSession()."/";//以会员的账户创建一个文件夹
				$relPath = '/upfiles/'.'/'.readSession()."/";
				$upLoadPath = $GLOBALS['currentApp']['domainpath'].'/resource/upfiles/'.readSession()."/";//以会员的账户创建一个文件夹
				//$relPath = $arrayLocate['locateurl'].readSession()."/";//服务器上的相对路径
				if($newFolder)//会员新建的文件夹
				{
					$upLoadPath .= $newFolder."/";
					$relPath .=$newFolder."/";//服务器上的相对路径
				}
				//$dirClass = new TplTemplate();
				$dirClass = new Html();
				//文件夹转码
				$upLoadPath = iconv('gb2312','utf-8',$upLoadPath);
				$relPath = iconv('gb2312','utf-8',$relPath);
				//$dirClass->makeDir($upLoadPath);//创建会员要上传资源的文件夹
				$dirClass->createdir($upLoadPath);
				$ascllClass = new ascii();
				//$fileName=$upLoadPath.$v['name']; //上传文件
				$getPathInfo = pathinfo($v['name']);
				$md5fileName = md5(date("Ymd His").random2(4));
				$v['name'] = $md5fileName.'.'.$getPathInfo['extension'];
				$fileName=$upLoadPath.$v['name']; //上传文件
				$relPath = $relPath.$v['name'];
				if(!file_exists($fileName))
				{
					if(move_uploaded_file($v['tmp_name'],$fileName))
					{
						//$path['relPath'] = $relPath;
						//$path['relPath'] = $relPath;
						$returnPathArray[$k]['relPath'] =  $relPath;
						$returnPathArray[$k]['relFileName'] =  $getPathInfo['filename'];
					}
					else
					{
						return false;
					}
					//unlink($fileName);
				}
				else
				{
					$returnPathArray[$k]['relPath'] =  $relPath;
					$returnPathArray[$k]['relFileName'] =  $getPathInfo['filename'];
				}
			}
		}

		else
		{
			return false;
		}
		return $returnPathArray;
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 上传资源到本地机上
 * $uploadFileo为上传的源文件
 * $newFolder用户是否要新建文件夹
 * $serverName为存放资源的服务器
 * */
function uploadMultFiles($upLoadFile,$newFolder,$serverName)
{
	try {
		@header("Content-Type:text/html;charset=utf-8");
		$TimeLimit=0; /*设置超时限制时间 缺省时间为30秒 设置为0时为不限时 */
		set_time_limit($TimeLimit);
		if($upLoadFile)
		{
			foreach ($upLoadFile['name'] as $k=>$v)
			{
				//$arrayLocate = getResourceUpLoadPath($serverName);
				$upLoadPath = getResourceUpLoadPath($serverName);
				//$upLoadPath = $GLOBALS['currentApp']['apppath'].'/'.$arrayLocate['locate'].'/'.readSession()."/";//以会员的账户创建一个文件夹
				$relPath = $upLoadPath.'/'.readSession()."/";
				$upLoadPath = $GLOBALS['currentApp']['apppath'].'/'.$upLoadPath.'/'.readSession()."/";//以会员的账户创建一个文件夹
				//$relPath = $arrayLocate['locateurl'].readSession()."/";//服务器上的相对路径
				if($newFolder)//会员新建的文件夹
				{
					$upLoadPath .= $newFolder."/";
					$relPath .=$newFolder."/";//服务器上的相对路径
				}
				//$dirClass = new TplTemplate();
				$dirClass = new Html();
				//文件夹转码
				$upLoadPath = iconv('gb2312','utf-8',$upLoadPath);
				$relPath = iconv('gb2312','utf-8',$relPath);
				//$dirClass->makeDir($upLoadPath);//创建会员要上传资源的文件夹
				$dirClass->createdir($upLoadPath);
				$ascllClass = new ascii();
				//$fileName=$upLoadPath.$v['name']; //上传文
				$getPathInfo = pathinfo($v);
				$md5fileName = md5(date("Ymd His").random2(4));
				$v = $md5fileName.'.'.$getPathInfo['extension'];
				$fileName=$upLoadPath.$v; //上传文件
				$relPath = $relPath.$v;
				if(!file_exists($fileName))
				{
					if(copy($upLoadFile['tmp_name'][$k],$fileName))
					{
						//$path['relPath'] = $relPath;
						//$path['relPath'] = $relPath;
						$returnPathArray[$k]['relPath'] =  $relPath;
						$returnPathArray[$k]['relFileName'] =  $getPathInfo['filename'];
					}
					else
					{
						return false;
					}
					//unlink($fileName);
				}
				else
				{
					$returnPathArray[$k]['relPath'] =  $relPath;
					$returnPathArray[$k]['relFileName'] =  $getPathInfo['filename'];
				}
			}
		}
		else
		{
			return false;
		}
		return $returnPathArray;
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 上传资源到FTP上
 * $ftpServer
 * $ftpUser
 * $ftpPass
 * $fileName
 * */

function ftpUpload($ftpServer,$ftpUser,$ftpPass,$fileName)
{
	try {
		$connId = ftp_connect($ftpServer) or die("Couldn't connect to $ftpServer");// 连接FTP服务器
		$loginResult = ftp_login($connId, $ftpUser, $ftpPass);
		if ((!$connId) || (!$loginResult)) {
			$destinationFile = getResourceUpLoadPath($serverName);
			print $destinationFile;exit;
			$destinationFile = $uploadPath.readSession()."/";//以会员的账户创建一个文件夹
			if($newFolder)//会员新建的文件夹
			{
				$destinationFile .= $newFolder."/";
			}
			$dirClass = new TplTemplate();
			$dirClass->makeDir($uploadPath);//创建会员要上传资源的文件夹
			$upload = ftp_put($connId, $destinationFile, $fileName, FTP_BINARY) or die("Couldn't connect to $ftp_server");
			ftp_quit($connId);
			ftp_close($connId);
			return $destinationFile;
		}else {
			return false;
		}
	}catch (Exception $e){
		throw $e;
	}
}
function random2($len)
{
	$srcstr="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$srcstr="0123456789";
	mt_srand();
	$strs="";
	for($i=0;$i<$len;$i++){
		$strs.=$srcstr[mt_rand(0,32)];
	}
	return $strs;
}
?>