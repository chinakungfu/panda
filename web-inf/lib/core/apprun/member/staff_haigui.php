<?php
/**
 * *****
 * 会员增删改以及查询用户信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.membercenter.Mail');
import('core.apprun.member.encode');
import('core.tpl.TplTemplate');
import('core.apprun.resourceManage.resource');
import('core.apprun.page.Page');
import('core.apprun.yellowpages.yellowpages');
//验证用户是否存在
//memberIsExists('username','artfantasy')
//存在返回true
function StaffIsExists($memberNo)
{
	try{
		$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo='".$memberNo."'";
		//print $sql;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//
//
//
function listStaff($sqlCon,$isFlag=0)
{
	try {
		if($isFlag==1)
		{
			$sql = "select a.* from  {$GLOBALS['table']['member']['staff']} a,{$GLOBALS['table']['member']['staff_groups']} b  where a.staffNo !='admin'
			and a.staffNo=b.staffId and (b.groupId='02' or b.groupId='03' or b.groupId='04')";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return $result;
		}else
		{
			if($sqlCon!=null)
			{
				$Con = substr($sqlCon,strpos($sqlCon,'%')+1,-2);
				setSession($GLOBALS['IN']['action'],$GLOBALS['IN']['method'],$Con);
				//setSession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con",$sqlCon);
				$paramStr = "'".$sqlCon."'";
				$sqlCon ="and ".$sqlCon;
				$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo !='admin' ".$sqlCon." order by staffId desc";
				if(strpos($sqlCon,'isCompanyMember')=='')
				{
					print "您查找的是：".querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
				}
			}
	//		}elseif(querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con")!='')
	//		{
	//			$sqlCon = querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con");
	//			$sqlCon ="where ".$sqlCon;
	//			$sql = "select * from {$GLOBALS['table']['member']['staff']} ".$sqlCon;
	//		}
			else
			{
				$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo !='admin' order by staffId desc";
			}
			//print $sql;
			//$sql = "select * from {$GLOBALS['table']['member']['staff']}".$sqlCon;
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
			if(!$GLOBALS["pageconfig"]['member']['pagesize'])
			{
				$GLOBALS["pageconfig"]['member']['pagesize'] = 10;
			}
			$params['pageSize'] = $GLOBALS["pageconfig"]['member']['pagesize'];
			$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			$result['pageinfo']['isText'] = $isText;
			$result['pageinfo']['wherestr'] = $paramStr;
			return $result;
		}
		//$sql = "select * from {$GLOBALS['table']['member']['staff']} order by staffId";
		//return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e)
	{
		throw $e;
	}
}
//新增一用户，传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//新增成功则返回新建用户的uid,失败则返回false;
function addStaff($memberArray)
{
	global $bindGroupArr;
	date_default_timezone_set('PRC');
	try
	{
		
		//判断用户昵称是否为空，否则和用户名一样
		if(empty($memberArray['staffName'])){

			$memberArray['staffName'] = $memberArray['staffNo'];
		}

		if(empty($memberArray['groupName'])){

			$memberArray['groupName'] = 'NoValidation';
		}
		if(empty($memberArray['email '])){

			$memberArray['email'] = $memberArray['staffNo'];
		}

		//加密密码
		if(empty($memberArray['password']))
		{
			$memberArray['password'] = md5(888888);
			//$memberArray['memberState'] = 1;
		}else 
		{
			$memberArray['password'] = md5($memberArray['password']);
			//$memberArray['memberState'] = 0;
		}
		//判断用户是否存在
		if(@StaffIsExists($memberArray['staffNo'])){
			return $memberArray['staffNo'];
		}
		//向流量系统中插入用户数据
		//insertPiwikData($memberArray['staffNo'],$memberArray['password'],$memberArray['staffName'],$memberArray['email']);
		//insertShopData($memberArray['staffNo'],$memberArray['password'],$memberArray['staffName'],$memberArray['sex'],$memberArray['email'],$memberArray['safetyQuestion'],$memberArray['questionResult']);
		$memberArray["registerDate"] = date("Y-m-d H:i:s");
		foreach ($memberArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['member']['staff']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
		staffBindGroup($result,$bindGroupArr["groupId"]);
		return $result;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
function batchRegister($staffNoStr)
{
	try {
		$reg = '/(.*?)[;|:|,|\s*?)](.*?)/i';
		if (preg_match_all($reg,$staffNoStr,$matches))
		{
			for($i=0;$i<count($matches[1]);$i++)
			{
				if($matches[1][$i]!=null)
				{
					$staffArray['staffNo'] = $matches[1][$i];
					$result = addStaff($staffArray);
					if($result!='1')
					{
						$str .=$result." ";
						addMemberOfYollowPages($matches[1][$i]);
					}					
				}
			}
		}
	return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//修改指定uid的用户信息,传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//失败返回false, 成功返回影响行数
function editStaff($memberId,$memberArray)
{
	try
	{
		
		//判断密码是否有变动..

//		if(md5($memberArray['password']) !='fddd21b9d7ce17da93c30fa5a653a1df'){
//			$memberArray['password'] = md5($memberArray['password']);
//		}
//		else
//		{
//			unset($memberArray['password']);
//		}
		if($memberArray['password']!=null)
		{	
			$memberArray['password'] = md5($memberArray['password']);
		}
		//$memberArray['memberState'] = 0;
		foreach ($memberArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['member']['staff']} set $sql where staffId=:staffId";
		$memberArray['staffId'] = $memberId;
//		print_r($memberArray);
//		print $sql;exit;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);

	} catch (Exception $e)
	{
		throw $e;
	}
}
//修改指定staffNo的用户信息,传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//失败返回false, 成功返回影响行数
function validateStaff($staffNo)
{
	try
	{
		
		//判断密码是否有变动..

//		if(md5($memberArray['password']) !='fddd21b9d7ce17da93c30fa5a653a1df'){
//			$memberArray['password'] = md5($memberArray['password']);
//		}
//		else
//		{
//			unset($memberArray['password']);
//		}
		
			
		$memberArray['groupName'] = 'Verified Member';
		
		//$memberArray['memberState'] = 0;
		$memberArray["verifyDate"] = date("Y-m-d H:i:s");
		foreach ($memberArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['member']['staff']} set $sql where staffId=:staffNo";
		$memberArray['staffNo'] = $staffNo;
//		print_r($memberArray);
//		print $sql;exit;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);

	} catch (Exception $e)
	{
		throw $e;
	}
}

//根据某用户属性删除用户,比如根据uid,email
function delStaff($memberId)
{
	try
	{
		$infoIdArray = explode(',',$memberId);
		for($i=0;$i<count($infoIdArray)-1;$i++)
		{
			$sql = "select * from {$GLOBALS['table']['member']['staff']}  WHERE `staffId`=:staffId";
			$params['staffId'] = $infoIdArray[$i];
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			if($result[0]['staffNo']!='admin')
			{
				delPiwikData($result[0]['staffNo']);
				delShopData($result[0]['staffNo']);
				$sql = "DELETE FROM {$GLOBALS['table']['member']['staff']} WHERE `staffId`=:staffId";
				//$params['staffId'] = $infoIdArray[$i];
				TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			}
		}
		return true;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//传入用户ID，查询用户所有信息
function getStaffInfoById($memberId)
{
	try
	{
		$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffId= ".$memberId;
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function getStaffInfoByStr($staffIdStr)
{
	try {
		if($staffIdStr!='')
		{
			$staffIdStr = "'".str_replace(',',"','",$staffIdStr)."'";
			$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo in (".$staffIdStr.")";
			return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		
	}catch (Exception $e)
	{
		throw $e;
	}
}
//传入用户账户，查询用户所有信息
function getStaffInfoByNo($memberNo)
{

	try
	{
		$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffId= '".$memberNo."'";
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//
//
//用户绑定用户组
function staffBindGroup($staffId,$groupId)
{
	try {
		$sql = "insert into {$GLOBALS['table']['member']['staff_groups']} (staffId,groupId) values ('".$staffId."','".$groupId."')";
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 删除绑定的用户组
 * */
function delStaffBindGroup($staffId)
{
	try {
		$sql = "delete from {$GLOBALS['table']['member']['staff_groups']} where staffId='".$staffId."'";
		//print $sql;
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 判断用户绑定了哪些用户组
 * */
function checkGroup($staffId,$groupId)
{
	try {
		$staffId = trim($staffId);
		$groupId = trim($groupId);
		$sql = "select * from {$GLOBALS['table']['member']['staff_groups']} where staffId='".$staffId."' and groupId='".$groupId."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if($result!=null)
		{
			return true;
		}else {
			return false;
		}
	}catch (Exception $e){
		throw $e;
	}
}
/**
 * 
 * 验证会员登录
 * */
function checkLogin($userId,$password)
{
	ob_start();
	session_start();
	$password = md5($password);
	$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo='".$userId."' and password='".$password."'";
	//echo $sql;
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
//	if(empty($result))
//	{
//		$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffName='".$userId."' and password='".$password."' and memberState='0'";
//		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
//	}
	if($result!=null)
	{
		unset($_SESSION['LoginErrNum']);
		return $result;
	}else
	{
		$sql = "select staffNo from {$GLOBALS['table']['member']['staff']} where staffNo='".$userId."' and password='".$password."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if(!empty($result))
		{
			return 'noAction';
		}else 
		{
			$_SESSION['LoginErrNum'] ++;
			return false;
		}
	}
	ob_end_flush();
}
/**
 * 
 * 修改会员密码
 * */
function changePassword($userId,$oldpassword,$newpassword,$identify)
{
	//加密密码
	$oldpassword = md5($oldpassword);
	$newpassword = md5($newpassword);

	$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo='".$userId."' and password='".$oldpassword."'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

	$pastTime = strtotime($result[0]['pastTime'])+$GLOBALS['mail']['membercenter']['pasttime']*24*60*60;
	$pastTime = date("Y-m-d H:i:s",$pastTime);
	$nowTime = date("Y-m-d H:i:s");

	if($result){

		if(empty($identify))
		{
			$sql = "update {$GLOBALS['table']['member']['staff']} set password='".$newpassword."',pastTime='',identifying='' where staffNo='".$userId."'";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return true;
		}else {


			if($pastTime>=$nowTime)
			{
				$sql = "update {$GLOBALS['table']['member']['staff']} set password='".$newpassword."',pastTime='',identifying='' where staffNo='".$userId."'";
				$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
				return true;

			}
			else
			{
				return false;
			}
		}


	}else
	{
		return false;
	}
}

//找回密码

function findPassword($userId,$newpassword,$identify){

	$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffNo='".$userId."' and identifying ='".$identify."'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

	$pastTime = strtotime($result[0]['pastTime'])+$GLOBALS['mail']['membercenter']['pasttime']*24*60*60;
	$nowTime = date("Y-m-d H:i:s");
	
	$newpassword = md5($newpassword);
	if($pastTime>=$nowTime)
	{
		$sql = "update {$GLOBALS['table']['member']['staff']} set password='".$newpassword."',pastTime='',identifying='' where staffNo='".$userId."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return true;

	}
	else
	{
		return false;
	}
}

/**
 * 
 * 校验安全问题
 * */
function verifySafty($userId,$safetyQuestion,$questionResult)
{

	$sql = " select * from {$GLOBALS['table']['member']['staff']} where staffNo='".$userId."' and safetyQuestion='".$safetyQuestion."' and questionResult='".$questionResult."'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

	if(!empty($result))
	{
		return $result;
	}else {
		return false;
	}
}
/**
 * 
 * 插入校验成功的字串
 * */
function insertIdentify($userId)
{
	$sql = " select * from {$GLOBALS['table']['member']['staff']} where staffNo='".$userId."'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	date_default_timezone_set('PRC');
	$ideStr = $result[0][password].date("Y-m-d H:i:s");
	$ideStr = md5($ideStr);
	$pastTime = date("Y-m-d H:i:s");
	$sql = " update {$GLOBALS['table']['member']['staff']} set pastTime ='".$pastTime."',identifying ='".$ideStr."' where staffNo='".$userId."'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
}
/**
 * 
 * 注销会员账户
 * */
function logoutStaff($userNo)
{
	$sql = "delete from {$GLOBALS['table']['member']['staff']} where staffNo='".$userNo."'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	return $result;
}
/**
 * 
 * 修改会员头像的URL
 * */
function modifyUrl($resourceId)
{
	$Url = selectResource($resourceId);
	$memberId = readSession();
	$sql = "update {$GLOBALS['table']['member']['staff']} set headImageUrl='".$Url."' where staffNo='".$memberId."'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	return $result;
}
/**
 * 
 * 向会员发送注册验证邮件
 * */

function sendVerifyMail($userId,$link)
{
	
	$result = getStaffInfoByNo($userId);

	$smtpemailto = $result[0]['email'];
	$smtpserver = $GLOBALS['mail']['member']['smtpserver'];//SMTP服务器
	$smtpserverport =$GLOBALS['mail']['member']['smtpserverport'];//SMTP服务器端口
	$smtpusermail = $GLOBALS['mail']['member']['smtpusermail'];//SMTP服务器的用户邮箱
	$smtpuser = $GLOBALS['mail']['member']['smtpuser'];//SMTP服务器的用户帐号
	$smtppass = $GLOBALS['mail']['member']['smtppass'];//SMTP服务器的用户密码
	$mailsubject = "Confirm Mail From WOWTAOBAO(please don't reply this mail)";//邮件主题
	$mailsubject = "=?UTF-8?B?".base64_encode($mailsubject)."?=";
	//$mailbody = readMailCon($result[0]['staffName'],$result[0]['identifying']);//邮件内容
	
	//echo $smtpemailto;
	//echo "<br>";
	//echo $smtpuser;
	//echo "<br>";
	//echo $smtppass;
	
	$mailbody ="<table border='0'  cellspacing='0'  cellpadding='40'  width='300'>
<tbody>
<tr>
<td style='FONT-FAMILY: &#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif'  bgcolor='#f7f7f7'  width='100%'>
<table border='0'  cellspacing='0'  cellpadding='0'  width='620'>
<tbody>
<tr>
<td style='TEXT-ALIGN: left; PADDING-BOTTOM: 4px; PADDING-LEFT: 8px; PADDING-RIGHT: 8px; FONT-FAMILY: &#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif; BACKGROUND: #3b5998; LETTER-SPACING: -0.03em; COLOR: #ffffff; FONT-SIZE: 16px; VERTICAL-ALIGN: middle; FONT-WEIGHT: bold; PADDING-TOP: 4px'>facebook</td>
<td style='TEXT-ALIGN: right; PADDING-BOTTOM: 4px; PADDING-LEFT: 8px; PADDING-RIGHT: 8px; FONT-FAMILY: &#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif; BACKGROUND: #3b5998; COLOR: #ffffff; FONT-SIZE: 11px; VERTICAL-ALIGN: middle; FONT-WEIGHT: bold; PADDING-TOP: 4px'></td></tr>
<tr>
<td style='BORDER-BOTTOM: #3b5998 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 15px; BACKGROUND-COLOR: #ffffff; PADDING-LEFT: 15px; PADDING-RIGHT: 15px; FONT-FAMILY: &#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 15px'  valign='top'  colspan='2'>
<table width='100%'>
<tbody>
<tr>
<td style='FONT-SIZE: 12px'  valign='top'  width='470'  align='left'>
<div style='MARGIN-BOTTOM: 15px; FONT-SIZE: 12px'>Hi Vironique,</div>
<div style='MARGIN-BOTTOM: 15px'>
<div>
<div style='MARGIN-BOTTOM: 10px; FONT-WEIGHT: bold'>To complete the sign-up process, please follow this link:</div>
<div>
<table cellspacing='0'  cellpadding='0'  width='100%'>
<tbody>
<tr>
<td style='WIDTH: 40px'><img style='WIDTH: 30px; HEIGHT: 30px'  src='javascript:;' /></td>
<td><a href='".$link."'>".$link."</a></td></tr></tbody></table></div>
<div style='MARGIN-TOP: 10px'>You may be asked to enter this confirmation code: 513273830</div></div></div>
<div style='MARGIN-BOTTOM: 15px'>Welcome to Facebook!</div>
<div style='MARGIN: 0px'>The Facebook Team</div></td>
<td style='PADDING-LEFT: 15px'  valign='top'  width='150'  align='left'>
<table style='BORDER-COLLAPSE: collapse'  cellspacing='0'  cellpadding='0'>
<tbody>
<tr>
<td style='BORDER-BOTTOM: #e2c822 1px solid; BORDER-LEFT: #e2c822 1px solid; PADDING-BOTTOM: 10px; BACKGROUND-COLOR: #fff9d7; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BORDER-TOP: #e2c822 1px solid; BORDER-RIGHT: #e2c822 1px solid; PADDING-TOP: 10px'>
<div style='MARGIN-BOTTOM: 15px; FONT-SIZE: 12px'>Get started:</div>
<table style='BORDER-COLLAPSE: collapse'  cellspacing='0'  cellpadding='0'>
<tbody>
<tr>
<td style='BORDER-BOTTOM: #2c5115 1px solid; BORDER-LEFT: #3b6e22 1px solid; BACKGROUND-COLOR: #69a74e; BORDER-TOP: #3b6e22 1px solid; BORDER-RIGHT: #3b6e22 1px solid'>
<table style='BORDER-COLLAPSE: collapse'  cellspacing='0'  cellpadding='0'>
<tbody>
<tr>
<td style='FONT-SIZE: 11px'><a style='COLOR: #3b5998; TEXT-DECORATION: none'  href='http://www.facebook.com/confirmemail.php?e=147250890%40qq.com&amp;c=513273830'><span style='COLOR: #fff; FONT-SIZE: 13px; FONT-WEIGHT: bold'>Complete Sign-up</span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><span><img style='BORDER-RIGHT-WIDTH: 0px; WIDTH: 1px; BORDER-TOP-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; HEIGHT: 1px; BORDER-LEFT-WIDTH: 0px'  src='javascript:;' /></span></td></tr>
<tr>
<td style='PADDING-BOTTOM: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; FONT-FAMILY: &#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif; COLOR: #999999; FONT-SIZE: 12px; PADDING-TOP: 10px'  colspan='2'>Didn't sign up for Facebook? <a style='COLOR: #3b5998; TEXT-DECORATION: none'  href='http://www.facebook.com/confirmemail.php?e=147250890%40qq.com&amp;c=513273830&amp;report=1'>Please let us know.</a> </td></tr></tbody></table></td></tr></tbody></table>";//邮件内容

	//print '"'.$GLOBALS['mail']['membercenter']['mailtype'].'"';
	//$mailtype = $GLOBALS['mail']['member']['mailtype'];//邮件格式（HTML/TXT）,TXT为文本邮件
	$mailtype = 'HTML';//邮件格式（HTML/TXT）,TXT为文本邮件
	$smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = 0;//是否显示发送的调试信息
	$result = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

	if($result)
	{
		return $result;

	}else {
		return false;
	}
}
function sendMail($userId)
{
	
	$result = getStaffInfoByNo($userId);

	$smtpemailto = $result[0]['email'];
	$smtpserver = $GLOBALS['mail']['member']['smtpserver'];//SMTP服务器
	$smtpserverport =$GLOBALS['mail']['member']['smtpserverport'];//SMTP服务器端口
	$smtpusermail = $GLOBALS['mail']['member']['smtpusermail'];//SMTP服务器的用户邮箱
	$smtpuser = $GLOBALS['mail']['member']['smtpuser'];//SMTP服务器的用户帐号
	$smtppass = $GLOBALS['mail']['member']['smtppass'];//SMTP服务器的用户密码
	$mailsubject = "重设密码（请勿回复此邮件）";//邮件主题
	$mailsubject = "=?UTF-8?B?".base64_encode($mailsubject)."?=";
	$mailbody = readMailCon($result[0]['staffName'],$result[0]['identifying']);//邮件内容

	//print '"'.$GLOBALS['mail']['membercenter']['mailtype'].'"';
	$mailtype = $GLOBALS['mail']['member']['mailtype'];//邮件格式（HTML/TXT）,TXT为文本邮件
	//$mailtype = 'HTML';//邮件格式（HTML/TXT）,TXT为文本邮件
	$smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = ture;//是否显示发送的调试信息
	$result = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

	if($result)
	{
		return true;

	}else {
		return false;
	}
}
/**
 * 
 * 读取发送给会员邮件内容
 * */
function readMailCon($name,$identify)
{
	date_default_timezone_set('PRC');
	$mailconfile = apppath."/mailtpl/mailcon.html";
	if($fp = @fopen($mailconfile, 'r'))
	{
		$pastTime = date("Y-m-d H:i:s");
		$contents = fread($fp, filesize($mailconfile));
		fclose($fp);
		$changePassUrl = $GLOBALS['mail']['member']['memebercenterpath']."index.php?action=member&method=modifyPassword&staffNo=".$name."&identify=".$identify;
		$memberCenterUrl = $GLOBALS['mail']['member']['memebercenterpath']."index.php?action=member&method=login";
		if(strpos($contents,'[submitTime]'))
		{
			$contents = str_replace('[submitTime]',$pastTime,$contents);
		}
		if(strpos($contents,'[staffNo]'))
		{
			$contents = str_replace('[staffNo]',$name,$contents);
		}
		if(strpos($contents,'[changePassUrl]'))
		{
			$contents = str_replace('[changePassUrl]',$changePassUrl,$contents);
		}
		if(strpos($contents,'[memberCenterUrl]'))
		{
			$contents = str_replace('[memberCenterUrl]',$memberCenterUrl,$contents);
		}
		if(strpos($contents,'[mailAdrr]'))
		{
			$contents = str_replace('[mailAdrr]',$GLOBALS['mail']['member']['smtpusermail'],$contents);
		}
		return $contents;
	}
}
/**
 * 
 * 加密FRAMERIGHT的URL
 * */
function encodeFrameRightURL($url)
{
	if(empty($url))
	{
		return false;
	}else
	{
		return base64_encode($url);
	}
}
/**
 * 
 * 解密FRAMERIGHT的URL
 * */
function decodeFrameRightURL($url)
{
	//echo base64_decode($url);
	if(empty($url))
	{
		return false;
	}else
	{
		return base64_decode($url);
	}
}
///**
// * 统计系统中的会员数
// * */
//function statisticsStaff($staffNo,$startTime,$endTime,$group,$role)
//{
//	try {
//		if($staffNo!='')
//		{
//			$staffNoSql = " and a.staffNo like '%".$staffNo."%'";
//		}
//		if(($startTime!='')&($endTime!='')&($group!='')&($role!=''))//
//		{
//			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,d.groupName from ".
//		"{$GLOBALS['table']['member']['staff']} a,".
//		"{$GLOBALS['table']['member']['staff_groups']} b,".
//		"{$GLOBALS['table']['member']['group_roles']} c,".
//		"{$GLOBALS['table']['member']['group']} d".
//		" where a.staffId=b.staffId and b.groupId = c.groupId ".
//		" and b.groupId = d.groupId and b.groupId=".$group." and c.roleId=".$role.
//		" and a.registerDate between '".$startTime."' and '".$endTime."' $staffNoSql group by a.staffNo";
//		}
//		if(($startTime=='')&($endTime=='')&($group=='')&($role==''))
//		{
//			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.groupName from ". 
//			"{$GLOBALS['table']['member']['staff']} a,".
//			"{$GLOBALS['table']['member']['staff_groups']} b,".
//			"{$GLOBALS['table']['member']['group']} c".
//			" where a.staffId = b.staffId and b.groupId = c.groupId $staffNoSql group by a.staffNo";
//		}
//		if(($startTime!='')&($endTime!='')&($group=='')&($role==''))
//		{
//			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.groupName from ".
//		"{$GLOBALS['table']['member']['staff']} a,".
//		"{$GLOBALS['table']['member']['staff_groups']} b,".
//		"{$GLOBALS['table']['member']['group']} c where a.staffId = b.staffId and b.groupId = c.groupId and a.registerDate between '".$startTime."' and '".$endTime."' $staffNoSql group by a.staffNo";
//		}
//		if(($startTime!='')&($endTime!='')&($group!='')&($role==''))//
//		{
//			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,d.groupName from ".
//		"{$GLOBALS['table']['member']['staff']} a,".
//		"{$GLOBALS['table']['member']['staff_groups']} b,".
//		"{$GLOBALS['table']['member']['group_roles']} c,".
//		"{$GLOBALS['table']['member']['group']} d".
//		" where a.staffId=b.staffId and b.groupId = c.groupId ".
//		" and b.groupId=d.groupId and b.groupId=".$group;
//		" and a.registerDate between '".$startTime."' and '".$endTime."' $staffNoSql group by a.staffNo";
//		}
//		if(($startTime!='')&($endTime!='')&($group=='')&($role!=''))//
//		{
//			$sql = "select a.staffId,a.staffNo,a.staffName,a.password,a.email,a.safetyQuestion,a.questionResult,a.sex,a.birthDay,a.homepage,a.qq,a.msn,a.registerDate,a.pastTime from ".
//		"{$GLOBALS['table']['member']['staff']} a,".
//		"{$GLOBALS['table']['member']['staff_groups']} b,".
//		"{$GLOBALS['table']['member']['group_roles']} c,".
//		"{$GLOBALS['table']['member']['group']} d".
//		" where a.staffId=b.staffId and b.groupId = c.groupId ".
//		" and b.groupId = d.groupId and c.roleId=".$role.
//		" and a.registerDate between '".$startTime."' and '".$endTime."' $staffNoSql group by a.staffNo";
//		}
//		if(($startTime=='')&($endTime=='')&($group!='')&($role==''))
//		{
//			$sql = "select a.staffId,a.staffNo,a.staffName,a.password,a.email,a.safetyQuestion,a.questionResult,a.sex,a.birthDay,a.homepage,a.qq,a.msn,a.registerDate,a.pastTime from ".
//		"{$GLOBALS['table']['member']['staff']} a,".
//		"{$GLOBALS['table']['member']['staff_groups']} b,".
//		"{$GLOBALS['table']['member']['group']} c".
//		" where a.staffId=b.staffId and  b.groupId=c.groupId".
//		" and b.groupId=".$group." $staffNoSql  group by a.staffNo";
//		}
//		if(($startTime=='')&($endTime=='')&($group=='')&($role!=''))
//		{
//			$sql = "select a.staffId,a.staffNo,a.staffName,a.password,a.email,a.safetyQuestion,a.questionResult,a.sex,a.birthDay,a.homepage,a.qq,a.msn,a.registerDate,a.pastTime from ".
//		"{$GLOBALS['table']['member']['staff']} a,".
//		"{$GLOBALS['table']['member']['staff_groups']} b,".
//		"{$GLOBALS['table']['member']['group_roles']} c,".
//		"{$GLOBALS['table']['member']['group']} d".
//		" where a.staffId=b.staffId and b.groupId = c.groupId".
//		" and b.groupId=d.groupId and c.roleId=".$role." $staffNoSql  group by a.staffNo";
//		}
//		//print $sql;
//		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
//		$total = 0;
//		foreach ($result as $key => $val)
//		{
//			$sqlCountLog = "select count(*) as rowCount from {$GLOBALS['table']['log']['log']} where logType='登录日志' and memberId='".$val['staffNo']."'";
//			$resultCountLog = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlCountLog,'');
//			$result[$key]['countLogin'] =  $resultCountLog[0]['rowCount'];
//			$total = $total + $resultCountLog[0]['rowCount'];
//			$sqlDateLog = "select logDate from {$GLOBALS['table']['log']['log']} where logDate =  (select MAX(logDate) from {$GLOBALS['table']['log']['log']} where memberId='".$val['staffNo']."')";
//			$resultDateLog = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlDateLog,'');
//			
//			$sqlTimeLog = "select logTime  from {$GLOBALS['table']['log']['log']} where logDate='".$resultDateLog[0]['logDate']."' and logTime = (select MAX(logTime ) from {$GLOBALS['table']['log']['log']} where logDate='".$resultDateLog[0]['logDate']."' and memberId='".$val['staffNo']."')";
//
//			$resultTimeLog = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlTimeLog,'');
//			$result[$key]['lastLogin'] =  $resultDateLog[0]['logDate']." ".$resultTimeLog[0]['logTime'];
//		}
//		$result[$key+1]['staffNo'] = count($result);
//		$result[$key+1]['countLogin'] = $total;
//		return $result;
//	}catch (Exception $e)
//	{
//		throw $e;
//	}
//}
/**
 * 统计系统中的会员数
 * */
function statisticsStaff($staffNo,$startTime,$endTime,$role)
{
	try {
		if(($startTime!='')&&($endTime!='')&&($staffNo!='')&&($role!=''))
		{
			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.roleName from ".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['group_roles']} b,".
		"{$GLOBALS['table']['member']['role']} c".
		" where a.staffId=b.groupId and b.roleId = c.roleId ".
		" and c.roleId=".$role.
		" and a.registerDate between '".$startTime."' and '".$endTime."'".
		" and a.staffNo like '%".$staffNo."%' group by a.staffNo";
		}
		if(($startTime=='')&&($endTime=='')&&($staffNo=='')&&($role==''))
		{
			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.roleName from ". 
			"{$GLOBALS['table']['member']['staff']} a,".
			"{$GLOBALS['table']['member']['group_roles']} b,".
			"{$GLOBALS['table']['member']['role']} c".
			" where a.staffId = b.groupId and b.roleId = c.roleId group by a.staffNo";
		}
		if(($startTime!='')&($endTime!='')&($staffNo=='')&($role==''))
		{
			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.roleName from ".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['group_roles']} b,".
		"{$GLOBALS['table']['member']['role']} c where a.staffId = b.groupId and b.roleId = c.roleId and a.registerDate between '".$startTime."' and '".$endTime."' group by a.staffNo";
		}
		if(($startTime!='')&&($endTime!='')&&($staffNo!='')&&($role==''))//
		{
			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.roleName from ".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['group_roles']} b,".
		"{$GLOBALS['table']['member']['role']} c".
		" where a.staffId=b.groupId and b.roleId = c.roleId ".
		" and a.registerDate between '".$startTime."' and '".$endTime."'".
		"  and a.staffNo like '%".$staffNo."%' group by a.staffNo";
		}
		if(($startTime!='')&&($endTime!='')&&($staffNo=='')&&($role!=''))//
		{
			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.roleName from ".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['group_roles']} b,".
		"{$GLOBALS['table']['member']['role']} c".
		" where a.staffId=b.groupId and b.roleId = c.roleId ".
		" and c.roleId=".$role.
		" and a.registerDate between '".$startTime."' and '".$endTime."' group by a.staffNo";
		}
		if(($startTime=='')&&($endTime=='')&&($staffNo!='')&&($role==''))
		{
			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.roleName from ".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['group_roles']} b,".
		"{$GLOBALS['table']['member']['role']} c".
		" where a.staffId=b.groupId and  b.roleId=c.roleId".
		" and a.staffNo like '%".$staffNo."%'  group by a.staffNo";
		}
		if(($startTime=='')&&($endTime=='')&&($staffNo=='')&&($role!=''))
		{
			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.roleName from ".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['group_roles']} b,".
		"{$GLOBALS['table']['member']['role']} c".
		" where a.staffId=b.groupId and b.roleId = c.roleId".
		" and c.roleId=".$role."  group by a.staffNo";
		}
		if(($startTime=='')&&($endTime=='')&&($staffNo!='')&&($role!=''))
		{
			$sql = "select a.staffId,a.staffNo,a.registerDate,a.pastTime,c.roleName from ".
		"{$GLOBALS['table']['member']['staff']} a,".
		"{$GLOBALS['table']['member']['group_roles']} b,".
		"{$GLOBALS['table']['member']['role']} c".
		" where a.staffId=b.groupId and b.roleId = c.roleId".
		" and c.roleId=".$role." and a.staffNo like '%".$staffNo."%'  group by a.staffNo";
		}
		//print $sql;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$total = 0;
		foreach ($result as $key => $val)
		{
			$sqlCountLog = "select count(*) as rowCount from {$GLOBALS['table']['log']['log']} where logType='登录日志' and memberId='".$val['staffNo']."'";
			$resultCountLog = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlCountLog,'');
			$result[$key]['countLogin'] =  $resultCountLog[0]['rowCount'];
			$total = $total + $resultCountLog[0]['rowCount'];
			$sqlDateLog = "select logDate from {$GLOBALS['table']['log']['log']} where logDate =  (select MAX(logDate) from {$GLOBALS['table']['log']['log']} where memberId='".$val['staffNo']."')";
			$resultDateLog = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlDateLog,'');
			
			$sqlTimeLog = "select logTime  from {$GLOBALS['table']['log']['log']} where logDate='".$resultDateLog[0]['logDate']."' and logTime = (select MAX(logTime ) from {$GLOBALS['table']['log']['log']} where logDate='".$resultDateLog[0]['logDate']."' and memberId='".$val['staffNo']."')";

			$resultTimeLog = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sqlTimeLog,'');
			$result[$key]['lastLogin'] =  $resultDateLog[0]['logDate']." ".$resultTimeLog[0]['logTime'];
		}
		$result[$key+1]['staffNo'] = count($result);
		$result[$key+1]['countLogin'] = $total;
		return $result;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 从库中取用户组的数据，组合成select
 * */
function displaySelectGroup()
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['member']['group']} order by groupId";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$selectStr = "<select id='group' name='group' style=\"width:125px;height:20px\"><option value=''>用户组</option>";
		for ($i=0;$i<count($result);$i++)
		{
			$selectStr .= "<option value='".$result[$i]["groupId"]."'>".$result[$i]["groupName"]."</option>";
		}
		$selectStr .= "</select>";
		return $selectStr;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 从库中取用户角色的数据，组合成select
 * */
function displaySelectRole()
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['member']['role']} order by roleId";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$selectStr = "<select id='role' name='role' style=\"width:125px;height:20px\"><option value=''>选择角色</option>";
		for ($i=0;$i<count($result);$i++)
		{
			$selectStr .= "<option value='".$result[$i]["roleId"]."'>".$result[$i]["roleName"]."</option>";
		}
		$selectStr .= "</select>";
		return $selectStr;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//向piwik应用的会员中插入数据
function insertPiwikData($userNo,$password,$userName,$email)
{
	try {
		$auth = md5($userNo.$password);
		$sql = "insert into piwik_user (login,password,alias,email,token_auth) values('".$userNo."','".$password."','".$userName."','".$email."','".$auth."')";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$sql = "insert into piwik_access (login,idsite,access) values ('".$userNo."','1','view')";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//向商城应用的会员中插入数据
function insertShopData($userNo,$password,$userName,$sex,$email,$pw_question,$pw_answer)
{
	try {
		$sql = "insert into sdb_members (member_lv_id,uname,password,name,sex,email,pw_question,pw_answer) 
		values('14','".$userNo."','".$password."','".$userName."','".$sex."','".$email."','".$pw_question."','".$pw_answer."')";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//删除piwik账户
function delPiwikData($userNo)
{
	try {
		$sql = "delete from piwik_user where login='".$userNo."'";
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$sql = "delete from piwik_access where login='".$userNo."'";
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}
//删除商城账户
function delShopData($userNo)
{
	try {
		$sql = "delete from sdb_members where uname='".$userNo."'";
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		return true;
	}catch (Exception $e)
	{
		throw $e;
	}
}

function checkSignupData($signAarray){
	//检查staffNo参数是否为空以及格式是否正确
	
	if(empty($signAarray['name'])){
		
		$checkArr['name']	=	"* Name can't be empty.";	
	}else
	{
		$checkArr['name']	=	1;
	}
	
	if(empty($signAarray['staffNo']))
	{				
		$checkArr['staffNo']	=	"* E-mail Address can't be empty.";						//为空
	}else 
	{
		if(is_email($signAarray['staffNo']))				
		{
			if(StaffIsExists($signAarray['staffNo']))
			{
				$checkArr['staffNo']	=	"* E-mail Address is exist.";
			}else
			{
				$checkArr['staffNo']	=	1;
			}
		}else
		{
			$checkArr['staffNo']	=	"* E-mail Address format is incorrect.";
		}		
	}	
	//检查重复输入的stffno参数是否正确
	if(empty($signAarray['reStaffNo']))
	{				
		$checkArr['reStaffNo']	=	"* Retype E-mail Address can't be empty.";
	}else 
	{
		if(is_email($signAarray['reStaffNo']))
		{
			if($checkArr['staffNo']	==	1)
			{
				if(strcmp($signAarray['staffNo'], $signAarray['reStaffNo'])==0)
				{
					$checkArr['reStaffNo']	=	1;
				}else
				{
					$checkArr['reStaffNo']	=	"* Retype E-mail Address must be as same as E-mail address.";
				}
			}else
			{
				if(StaffIsExists($signAarray['reStaffNo']))
				{
					$checkArr['reStaffNo']	=	"* Retype E-mail Address is exist.";
				}else
				{
					$checkArr['reStaffNo']	=	"* Retype E-mail Address is OK, but E-mail Address is incorrect.";
				}				
			}
		}else
		{
			$checkArr['reStaffNo']	=	"* E-mail Address format is incorrect.";
		}		
	}
	//检查输入的密码是否正确
	$checkArr['password']	=	1;
	if(empty($signAarray['password']))
	{
		$checkArr['password']	=	"* password Address can't be empty.";
	}else
	{
		if(strlen($signAarray['password'])<6)
		{
			$checkArr['password']	=	"* password must be at least six characters in length.";
		}
		if(!preg_match('/\d+/',$signAarray['password']))
		{
			$checkArr['password']	=	"* password must contain at least one number (ex.1_togo).";
		}
		$strArr1	=	explode(" ", $signAarray['password']);
		if(count($strArr1)>1)
		{
			$checkArr['password']	=	"* password Cannot contain spaces.";
		}
		$strArr2	=	explode($signAarray['staffNo'], $signAarray['password']);
		if(count($strArr2)>1)
		{
			$checkArr['password']	=	"* password Cannot contain your e-mail address.";
		}
	}
	//检查重复输入的密码是否正确
	if(empty($signAarray['rePassword']))
	{
		$checkArr['rePassword']	=	"* Retype password can't be empty.";
	}else
	{
		if(strcmp($signAarray['password'], $signAarray['rePassword'])==0)
		{
				$checkArr['rePassword']	=	1;
		}else
		{
				$checkArr['rePassword']	=	"* Retype password must be as same as password.";
		}
	}
	if(empty($signAarray['safetyQuestion']))
	{
		$checkArr['safetyQuestion']	=	"* Security Question can't be empty.";
	}else
	{
		$checkArr['safetyQuestion']	=	1;
	}
	if(empty($signAarray['questionResult']))
	{
		$checkArr['questionResult']	=	"* Security Answer can't be empty.";

	}else
	{
		$checkArr['questionResult']	=	1;
	}
	print_r($checkArr);
	exit;
	if($checkArr['name']==1 and $checkArr['staffNo']==1 and $checkArr['reStaffNo']==1 and $checkArr['password']==1 and $checkArr['rePassword']==1 and $checkArr['safetyQuestion']==1 and $checkArr['questionResult']==1)
	{
		return 1;
	}else
	{
		foreach ($checkArr as $key => $val)
		{	
			if($val!=1)
			{
				$str_field .= $val."<br>";
			}
			
		}
		$str_field = substr($str_field,0,-4);
		
		return $str_field;
	}	
}

function is_email($user_email) 
{ 
        $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i"; 
        if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false) 
     { 
        if (preg_match($chars, $user_email)) 
        { 
            return true; 
        } else 
        { 
            return false; 
        } 
    } else 
        { 
            return false; 
        } 
}


function getGoodInfo($url)
{
    $good = new goods($url);
    $info = $good->getResult();
    if (!$info) {
        return $good->getError();
    }
    return $info;
}


/**
 * 该类实现商品信息的采集
 */
class goods
{
    /**
     * 网页HTML源文件
     */
    private $html;
    /**
     * 解析后得到的数据信息
     */
    private $data;
    /**
     * 需要采集的URL
     */
    private $url;
    /**
     * 允许采集的站点列表
     */
    private $siteList;
    /**
     * 最后一次出现的错误
     */
    private $lastError;

    public function __construct($url = '')
    {
        $this->siteList = array('taobao' => 'taobao.com', 'tmall' => 'tmall.com');
        $this->url = $url;
    }

    /**
     * 获取结果
     * 返回false:抓取失败 -1:商品已下架 array:商品信息
     */
    public function getResult()
    {
        if (!in_array($this->getMainDomain($this->url), $this->siteList)) {
            $this->lastError = '您输入的URL暂无法采集，你核对URL！';
            return false;
        }
        $this->html = $this->getContents($this->url);
        if (!$this->html) {
            $this->lastError = '没有获取到网页内容或网页内容过少！';
            return false;
        }
        $fun = array_pop(array_keys($this->siteList, $this->getMainDomain($this->url)));
        return $this->$fun($this->html);
    }

    /**
     * 淘宝商品信息解析
     */
    public function taobao($html)
    {
        if (preg_match("/点此查看最新宝贝详情/Ui", $html, $matches)) { //已下架商品判断
            return '-1';
        }
        if (preg_match("/<title>(.*)<\/title>/Ui", $html, $matches)) { //获取商品名称
            $this->data['title'] = str_replace('-淘宝网', '', $matches[1]);
        } else {
            $this->data['title'] = '-2';
        }
        if (preg_match("/id=(\'|\")?J_StrPrice(\'|\")?(.*)?>(.*)<\/strong>/Ui", $html, $matches)) { //获取商品价格
            $price = trim($matches[4]);
            if(strpos($price,'-')!==false){
                $price = trim(array_pop(split('-',$price)));
            }
            $this->data['price'] = $price;
        } else {
            $this->data['price'] = '-3';
        }
        if (preg_match("/所在地区(.*)30天售出/Ui", $html, $matches)) { //获取商品运费
            if (preg_match("/卖家承担运费/Ui", $matches[1], $matches1)) { //判断是否为卖家承担运费
                $this->data['postage'] = 0;
            } else {
                if (preg_match("/快递:(.*)?元/Ui", $matches[1], $matches1)) { //判断是否为卖家承担运费
                    $this->data['postage'] = $matches1[1];
                } else {
                    $this->data['postage'] = '-44';
                }
            }
        } else {
            $this->data['postage'] = '-45';
        }
        if (preg_match_all("/src=(.*)40x40.jpg\"/Ui", $html, $matches)) { //获取商品图片
        	//$this->data['img'] = trim($matches[5]);

            for($i=0;$i<count($matches[0]);$i++)
            {
            	$table_change = array('40x40'=>'310x310');
            	$matches[0][$i]=strtr($matches[0][$i],$table_change);
            }
        	$this->data['img'] = $matches[0];

        } else {
            $this->data['img'] = '-5';
        }
        return $this->data;
    }

    /**
     * 天猫商品信息解析
     */
    public function tmall($html)
    {
        if (preg_match("/点此查看最新宝贝详情/Ui", $html, $matches)) { //已下架商品判断
            return '-1';
        }
        if (preg_match("/<title>(.*)<\/title>/Ui", $html, $matches)) { //获取商品名称
            $this->data['title'] = str_replace('-tmall.com天猫', '', $matches[1]);
        } else {
            $this->data['title'] = '-2';
        }
        if (preg_match("/id=(\'|\")?J_StrPrice(\'|\")?(.*)?>(.*)<\//Ui", $html, $matches)) { //获取商品价格
            $price = trim($matches[4]);
            if(strpos($price,'-')!==false){
                $price = trim(array_pop(split('-',$price)));
            }
            $this->data['price'] = $price;
        } else {
            $this->data['price'] = '-3';
        }
        
       if (preg_match("/所在地区(.*)30天售出/Ui", $html, $matches)) { //获取商品运费
            if (preg_match("/卖家承担运费/Ui", $matches[1], $matches1)) { //判断是否为卖家承担运费
                $this->data['postage'] = 0;
            } else {
                if (preg_match("/快递:(.*)?元/Ui", $matches[1], $matches1)) { //判断是否为卖家承担运费
                    $this->data['postage'] = $matches1[1];
                } else {
                    $this->data['postage'] = '-4';
                }
            }
        } else {
            $this->data['postage'] = '-4';
        }
        
        if (preg_match_all("/src=(.*)40x40.jpg\"/Ui", $html, $matches)) { //获取商品图片
            //$this->data['img'] = trim($matches[5]);
            for($i=0;$i<count($matches[0]);$i++)
            {
            	$table_change = array('40x40'=>'310x310');
            	$matches[0][$i]=strtr($matches[0][$i],$table_change);
            }
        	$this->data['img'] = $matches[0];

        } else {
            $this->data['img'] = '-5';
        }
        return $this->data;
    }

    public function getError()
    {
        return $this->lastError;
    }

    /**
     * 获取网页内容
     */
    public function getContents($url)
    {
        for ($i = 0; $i < 3; $i++) {
            $c = @file_get_contents($url);
            if (strlen($c) > 1000)
                break;
        }
        return $this->html = iconv("gbk", "utf-8",$c);
    }

    /**
     * 获取网站的主域名
     */
    public function getMainDomain($url)
    {
        $strUrl = trim($url);
        $intReturn = strpos($strUrl, "/", 7);
        $strUrl = substr($strUrl, 7, strlen($strUrl) - 1);
        if ($intReturn == false) {
            $fchar = substr($strUrl, 0, 1);
            if (is_numeric($fchar)) {
                $dealDoain = $strUrl;
            } else {
                $arrayUrl = explode(".", $strUrl);
                $dealDoain = $arrayUrl[sizeof($arrayUrl) - 2] . "." . $arrayUrl[sizeof($arrayUrl) -
                    1];
            }
        } else {
            $arrayUrl = explode("/", $strUrl);
            $strUrl = $arrayUrl[0];
            $fchar = substr($strUrl, 0, 1);
            if (is_numeric($fchar)) {
                $dealDoain = $strUrl;
            } else {
                $arraydomain = explode(".", $strUrl);
                $dealDoain = $arraydomain[sizeof($arraydomain) - 2] . "." . $arraydomain[sizeof($arraydomain) -
                    1];
            }
        }
        return $dealDoain;
    }

}


?>