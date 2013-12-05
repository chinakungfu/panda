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

		if(empty($memberArray['staffName'])){

			$memberArray['staffName'] = $memberArray['staffNo'];
		}

		if(empty($memberArray['groupName'])){

			$memberArray['groupName'] = 'NoValidation';
		}
		if(empty($memberArray['email'])){

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
		if(@StaffIsExists($memberArray['staffNo'])){
			return $memberArray['staffNo'];
		}
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
		staffBindProfile($result);
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
		//print_r($memberArray);
		//print $sql;
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
		$userInfo = runFunc('getUser',array($staffNo));
		if($userInfo){
			if($userInfo[0]['groupName'] != 'NoValidation'){
				$result['status'] = -2;
			}else{
				$memberArray['groupName'] = 'Verified Member';
				$memberArray["verifyDate"] = date("Y-m-d H:i:s");
				foreach ($memberArray as $key => $var)
				{
					$sql .= "$key =:$key,";
				}
				$sql = substr($sql,0,-1);
				$sql = "update {$GLOBALS['table']['member']['staff']} set $sql where staffId=:staffNo";
				$memberArray['staffNo'] = $staffNo;
				TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
				$result['status'] = 1;
			}
		}else{
			$result['status'] = -1;
		}
		return $result;

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
		$sql = "select * from {$GLOBALS['table']['member']['staff']} where staffId= '{$memberId}'";
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

function getStaffNoSe($memberNo){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "select * from cms_member_staff where staffId = '{$memberNo}'";

	$result = mysql_query($sql);

	$row = mysql_fetch_array($result);

	$array[0] = $row;
	return $array;
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


function staffBindProfile($staffId){
	try {

		$user_data = getStaffInfoById($staffId);
		$mail = $user_data[0]["email"];
		$sql = "INSERT INTO cms_profile (user_id,mail) values('{$staffId}','{$mail}')";
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
 * 新验证会员登录
 * */
function newCheckLogin($staffNo,$password)
{
	ob_start();
	session_start();
	$password = md5($password);
	$sql = "select staffId,password,groupName,block from {$GLOBALS['table']['member']['staff']} where staffNo='".$staffNo."' or email='".$staffNo."'";
	$checkResult = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	if($checkResult){
		if($password === $checkResult[0]['password']){
			if($checkResult[0]['groupName'] == "NoValidation"){
				$result['status'] = false;
				$result['error'] = 4;
				$_SESSION['LoginErrNum'] ++;
			}else if($checkResult[0]['block']){
				$result['status'] = false;
				$result['error'] = 5;
				$_SESSION['LoginErrNum'] ++;
			}else{
				$result['status'] = true;
				$result['staffId'] = $checkResult[0]['staffId'];
				unset($_SESSION['LoginErrNum']);
			}
		}else{
			$result['status'] = false;
			$result['error'] = 3;
			$_SESSION['LoginErrNum'] ++;
		}
	}else{
		$result['status'] = false;
		$result['error'] = 2;
		$_SESSION['LoginErrNum'] ++;
	}
	return $result;
	ob_end_flush();
}
/**
 *
 * 修改会员密码
 * */
function changePassword1($userId,$oldpassword,$newpassword,$identify)
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
function changePassword($userId,$newpassword)
{
	//加密密码
	$newpassword = md5($newpassword);

	$sql = "update {$GLOBALS['table']['member']['staff']} set password='".$newpassword."' where staffId='".$userId."'";
	echo $sql;
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	if($result)
	{
		return true;
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

	$sql = " select * from {$GLOBALS['table']['member']['staff']} where staffId='".$userId."' and safetyQuestion='".$safetyQuestion."' and questionResult='".$questionResult."'";
	//echo $sql;
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
/*************
 *@l - length of random string
*/
function generate_rand($l){
	$c= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789,.@#$%^&*()";
	srand((double)microtime()*1000000);
	for($i=0; $i<$l; $i++) {
		$rand.= $c[rand()%strlen($c)];
	}
	return $rand;
}
/**
 *
 * 向会员发送注册验证邮件
 * */

function sendMailTest($mailArr,$type)
{
	//echo $mailArr['userId'];
	$result = getStaffInfoByNo($mailArr['userId']);
	$mailArr['staffName'] = $result[0]['staffName'];
	$mailArr['staffNo'] = $result[0]['staffNo'];
	//print_r($mailArr);

	$smtpemailto = $result[0]['email'];
	$smtpserver = $GLOBALS['mail']['member']['smtpserver'];
	$smtpserverport =$GLOBALS['mail']['member']['smtpserverport'];
	$smtpusermail = $GLOBALS['mail']['member']['smtpusermail'];
	$smtpuser = $GLOBALS['mail']['member']['smtpuser'];
	$smtppass = $GLOBALS['mail']['member']['smtppass'];
	switch($type){
		case 'signup':
			$mailsubject="WOWSHOPPING Account Email Verification - Action Required‏";
			break;
		case 'addUser':
			$mailsubject="WOWSHOPPING Account Email Verification - Action Required‏";
			break;
		case 'orderSubmit':
			$mailsubject="WOWSHOPPING Order Confirmation‏";
			break;
		case 'changeMail':
			$mailsubject="WOWSHOPPING Order Confirmation‏";
			break;
		case 'shippingInform':
			$mailsubject="WOWSHOPPING Shipping Information‏";
			break;
		case 'updateFreight':
			$mailsubject="WOWSHOPPING Freight Modified";
			break;
		case 'resetPassword':
			$mailsubject="WOWSHOPPING Account - Password Change Notice";
			break;
		case 'orderPay':
			$mailsubject="WOWSHOPPING Account Email Verification - Action Required‏";
			break;
	}
	$mailsubject = "=?UTF-8?B?".base64_encode($mailsubject)."?=";
	$mailbody = readMailCon($mailArr,$type);//邮件内容


	echo $mailbody;
	/**
	 //print '"'.$GLOBALS['mail']['membercenter']['mailtype'].'"';
	 $mailtype = $GLOBALS['mail']['member']['mailtype'];//邮件格式（HTML/TXT）,TXT为文本邮件
	 //$mailtype = 'HTML';//邮件格式（HTML/TXT）,TXT为文本邮件
	 $smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	 $smtp->debug = 0;//是否显示发送的调试信息
	 $result = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

	 if($result)
	 {
	 return true;

	 }else {
	 return false;
	 }
	 * */
}


function getglobalsettingNoSe($tplVar){


	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "select * from cms_cms_tpl_vars where varName='".$tplVar."'";

	$result = mysql_query($sql);

	while ($row = mysql_fetch_array($result)){

		$value = $row['varValue'];
	}

	return $value;

}

function staffGetGlobalSetting(){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($db_config['a0222211743']["dbName"], $con);

    $sql = "select * from cms_website_global_setting";

	$result = mysql_query($sql);

	$setting = array();

	$row = mysql_fetch_array($result);
	mysql_close($con);
	return $row;
}

function sendMail($mailArr,$type)
{
	$site_name = getglobalsettingNoSe('Site_Domain');
	$mailArr["HELP_LINK"] = $site_name . '/publish/index.php' .runFunc('encrypt_url',array("action=help&method=main"));
	$mailArr["SITE_NAME"] = $site_name;
	$mailArr["SITE_LINK"] = $site_name;
	$mailArr["REFUND_HELP_LINK"] = $site_name . '/publish/index.php' .runFunc('encrypt_url',array('action=help&method=refunds'));
	$mailArr["order_history"] = $site_name . '/publish/index.php' .runFunc('encrypt_url',array('action=account&method=orderList'));
	$mailArr["FAQ_HELP_LINK"] = $site_name . '/publish/index.php' .runFunc('encrypt_url',array('action=help&method=faq'));
	$mailArr["POINTS_EXCHANGE"] = $site_name . '/publish/index.php' .runFunc('encrypt_url',array('action=shop&method=recharge_with_credits'));
	$mailArr["ACCOUNT_HOME"] = $site_name . '/publish/index.php' .runFunc('encrypt_url',array('action=website&method=account'));

	if(is_numeric($mailArr['userId']))
	{
		$result = getStaffInfoByNo($mailArr['userId']);
		$mailArr['staffName'] = $result[0]['staffName'];
		$mailArr['staffNo'] = $result[0]['staffNo'];
		$smtpemailto = $result[0]['email'];
		if(empty($mailArr['staffName']))
		{
			$mailArr['staffName'] = $result[0]['staffNo'];
		}
	}

	if($type == "submitOrder")
	{
		$smtpemailto = $mailArr['email'];
		if(empty($mailArr['staffName']))
		{
			$mailArr['staffName'] = $mailArr['email'];
		}
	}
	$smtpserver = $GLOBALS['mail']['member']['smtpserver'];
	$smtpserverport =$GLOBALS['mail']['member']['smtpserverport'];
	$smtpusermail = $GLOBALS['mail']['member']['smtpusermail'];
	$smtpuser = $GLOBALS['mail']['member']['smtpuser'];
	$smtppass = $GLOBALS['mail']['member']['smtppass'];
	switch($type){
		case 'signup':
			$mailsubject="WOWSHOPPING Account Email Verification - Action Required‏";
			break;
		case 'adminsignup':
			$mailsubject="Welcome to WOWshopping, You have 50 RMB gift in your account now!";
			break;
		case 'addUser':
			$mailsubject="WOWSHOPPING Account Email Verification - Action Required‏";
			break;
		case 'submitOrder':
			$mailsubject="WOWSHOPPING Order Confirmation‏";
			break;
		case 'updateUser':
			$mailsubject="WOWSHOPPING Account Email Verification - Action Required";
			break;
		case 'shippingInform':
			$mailsubject="WOWSHOPPING Shipping Information‏";
			break;
		case 'confirmOrder':
			$mailsubject="WOWSHOPPING Freight Modified";
			break;
		case 'resetPassword':
			$mailsubject="WOWSHOPPING Account - Password Change Notice";
			break;
		case 'updatePassword':
			$mailsubject="WOWSHOPPING Account - Password Change Notice";
			break;
		case 'orderPay':
			$mailsubject="WOWSHOPPING Account Email Verification - Action Required‏";
			break;
		case 'guestOrderPay':
			$mailsubject="WOWSHOPPING Account Information Notice";
			break;
		case 'SSISOrderPay':
			$mailsubject="WOWSHOPPING Account Information Notice For SSIS";
			break;
		case 'order_remind':
			$mailsubject="WOWSHOPPING Order Pay Remind‏";
			break;
		case 'payment_finished':
			$mailsubject="WOWSHOPPING Payment Finished";
			break;
		case 'shipping_confirm':
			$mailsubject="WOWSHOPPING Shipping Notice";
			$smtpemailto = $mailArr["mailto"];
			break;
		case 'order_shipped':
			$mailsubject="WOWshopping Parcel Arrived Notice";
			break;
		case 'order_refund':
			$mailsubject="WOWshopping Parcel refund Notice";
			break;
		case 'phone_order_refund':
			$mailsubject="WOWshopping refund Notice";
			break;
		case 'order_purchase':
			$mailsubject="WOWshopping Purchasing Notice";
			$smtpemailto = $mailArr["mailto"];
			break;
		case 'invite_mail' :
			$mailsubject="Come join me on WOWSHOPPING!";
			$smtpemailto = $mailArr["mail_address"];
			$mailArr["usermail"] = $result[0]['email'];
			break;
		case 'invited_successfully' :
			$mailsubject="Invited Successfully ";
			break;
		case 'friend_request':
			$mailsubject="WOWshopping: ".$mailArr['my_name']." would like to meet you!";
			$smtpemailto = $mailArr["friend_mail"];
			break;
		case 'recharge_success':
			$mailsubject="WOWSHOPPING Recharge Successful";
			break;
		case 'gift_card':
			$mailsubject="WOWSHOPPING Gift card received";
			$smtpemailto = $mailArr["give_email"];
			break;
		case 'comment_notice':
			$mailsubject="WOWSHOPPING ".$mailArr["from"]." ".$mailArr["sub"];
			break;
		case 'gift_card_maker' :
			$mailsubject="WOWSHOPPING Send gift card to your friend";
			break;
		case 'member_group_buy' :
			$mailsubject="WOWSHOPPING Group Buy information";
			$smtpemailto = $mailArr["MAIL_QUEUE"].",".$result[0]['email'];
			break;

		case 'member_group_buy_refuse' :

			$mailsubject="WOWSHOPPING Group Buy information";
			break;
		case 'request_answer' :

			$mailsubject="WOWSHOPPING Products recommended";
			break;
		case 'block_warning' :

			$mailsubject="WOWshopping Warning!";
			break;
		case 'order_admin_notice' :
			$settings = staffGetGlobalSetting();
			$smtpemailto = $settings["order_notice_mail"];
			$mailsubject="WOWSHOPPING 恭喜你！有新的已付款订单 !";
			break;
		case 'phone_order_admin_notice' :
			$settings = staffGetGlobalSetting();
			$smtpemailto = $settings["order_notice_mail"];
			$mailsubject="WOWSHOPPING 有新的已付款电话充值订单 !";
			break;
		case 'user_verify':
			$mailsubject="WOWshopping Account Activated";
			break;

		case 'user_block':
			$mailsubject="WOWshopping Your Account Banned Temporarily";
			break;

		case 'user_lifed':
			$mailsubject="WOWshopping Account Lift The Ban";
			break;

		case 'order_refund':
			$mailsubject="WOWshopping Refund Notice";
			break;

		case 'newsletter_send':

			$settings = staffGetGlobalSetting();

			$mailsubject=$mailArr["MAIL_TITLE"];

			$smtpemailto = $settings["admin_mail"];

			break;

		case 'request_answer_by_admin':
			$mailsubject="WOWshopping Customer Help Request";
			$smtpemailto = $mailArr["reply_email"];
			break;

		case 'message_help':
			$settings = staffGetGlobalSetting();
			$mailsubject="WOWshopping Customer Help Request";
			if($mailArr["send_mail"]==1){
				$smtpemailto = $smtpemailto.",".$settings["admin_mail"];
			}
			else{
				$smtpemailto = $settings["admin_mail"];
			}
			break;
	}
	$mailsubject = "=?UTF-8?B?".base64_encode($mailsubject)."?=";
	$mailbody = readMailCon($mailArr,$type);//邮件内容

	//print '"'.$GLOBALS['mail']['membercenter']['mailtype'].'"';
	$mailtype = $GLOBALS['mail']['member']['mailtype'];//邮件格式（HTML/TXT）,TXT为文本邮件
	//$mailtype = 'HTML';//邮件格式（HTML/TXT）,TXT为文本邮件
	$smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = 0;//是否显示发送的调试信息
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
function readMailCon($mailArray,$filename)
{
	date_default_timezone_set('PRC');

	$mailconfile = apppath."/mailtpl/".$filename.".html";

	//echo $mailconfile;

	if($fp = @fopen($mailconfile, 'r'))
	{
		$contents = fread($fp, filesize($mailconfile));
		fclose($fp);
		foreach ($mailArray as $key => $val)
		{
			$str='['.$key.']';
			if(strpos($contents,$str))
			{
				$contents = str_replace($str,$val,$contents);
			}
			//$str_field .= $key.",";
			//$str_value .= ":".$key.",";
		}
		//$str_field = substr($str_field,0,-1);
		//$str_value = substr($str_value,0,-1);

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

function checkSignupDataAndMessage($signAarray){


	//检查staffNo参数是否为空以及格式是否正确
	if(empty($signAarray['phone']))
	{
		$checkArr['phone']="*Phone can't be empty.";
	}
	else
	{
		$match="/13[0-9]{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|5|6|7|8|9]\d{8}/";
		if (!preg_match($match,$signAarray['phone'])){

			$checkArr['phone']="*Phone must match.";
		}else {
			$checkArr['phone']	=	1;
		}
	}
	if(empty($signAarray['staffName']))
	{
		$checkArr['staffName']="*Name can't be empty.";
	}
	else
	{
		$checkArr['staffName']	=	1;
	}
	if(empty($signAarray['staffNo']))
	{
		$checkArr['staffNo']	=	"* E-mail address can't be empty.";						//为空
	}else
	{
		if(is_email($signAarray['staffNo']))
		{
			if(StaffIsExists($signAarray['staffNo']))
			{
				$checkArr['staffNo']	=	"* E-mail address exists already.";
			}else
			{
				$checkArr['staffNo']	=	1;
			}
		}else
		{
			$checkArr['staffNo']	=	"* Not a valid e-mail address..";
		}
	}
	//检查重复输入的stffno参数是否正确
	if(empty($signAarray['reStaffNo']))
	{
		$checkArr['reStaffNo']	=	"* Retype e-mail address can't be empty.";
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
					$checkArr['reStaffNo']	=	"* E-mail addresses must match.";
				}
			}else
			{
				if(StaffIsExists($signAarray['reStaffNo']))
				{
					$checkArr['reStaffNo']	=	"* Retype e-mail address exists already.";
				}else
				{
					$checkArr['reStaffNo']	=	"* Retype e-mail address is ok, but e-mail address is incorrect.";
				}
			}
		}else
		{
			$checkArr['reStaffNo']	=	"* Not a valid e-mail address..";
		}
	}
	//检查输入的密码是否正确
	$checkArr['password']	=	1;
	if(empty($signAarray['password']))
	{
		$checkArr['password']	=	"* Password can't be empty.";
	}else
	{

		if(strlen($signAarray['password'])<6)
		{
			$checkArr['password']	=	"* Password must be at least six characters in length.";
		}
		if(!preg_match('/\d+/',$signAarray['password']))
		{
			$checkArr['password']	=	"* Password must contain at least one number (ex.1_togo).";
		}
		$strArr1	=	explode(" ", $signAarray['password']);
		if(count($strArr1)>1)
		{
			$checkArr['password']	=	"* Password cannot contain spaces.";
		}
		$strArr2	=	explode($signAarray['staffNo'], $signAarray['password']);
		if(count($strArr2)>1)
		{
			$checkArr['password']	=	"* Password cannot contain your e-mail address.";
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
		$checkArr['safetyQuestion']	=	"* Security question can't be empty.";
	}else
	{
		$checkArr['safetyQuestion']	=	1;
	}
	if(empty($signAarray['questionResult']))
	{
		$checkArr['questionResult']	=	"* Security answer can't be empty.";
	}else
	{
		$checkArr['questionResult']	=	1;
	}

	if($checkArr['staffName']==1 and $checkArr['phone']==1 and $checkArr['staffNo']==1 and $checkArr['reStaffNo']==1 and $checkArr['password']==1 and $checkArr['rePassword']==1 and $checkArr['safetyQuestion']==1 and $checkArr['questionResult']==1)
	{
		return 1;

	}else
	{
		//foreach ($checkArr as $key => $val)
		//{
		//	if($val!=1)
		//	{
		//		$str_field .= $val."<br>";
		//	}

		//}
		//$str_field = substr($str_field,0,-4);

		return $checkArr;
	}
}

function checkSignupData($signAarray){
	//检查staffNo参数是否为空以及格式是否正确


	if(empty($signAarray['staffNo']))
	{
		$checkArr['staffNo']	=	"* E-mail address can't be empty.";						//为空
	}else
	{
		if(is_email($signAarray['staffNo']))
		{
			if(StaffIsExists($signAarray['staffNo']))
			{
				$checkArr['staffNo']	=	"* E-mail address exists already.";
			}else
			{
				$checkArr['staffNo']	=	1;
			}
		}else
		{
			$checkArr['staffNo']	=	"* Not a valid e-mail address..";
		}
	}
	//检查重复输入的stffno参数是否正确
	if(empty($signAarray['reStaffNo']))
	{
		$checkArr['reStaffNo']	=	"* Retype e-mail address can't be empty.";
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
					$checkArr['reStaffNo']	=	"* E-mail addresses must match.";
				}
			}else
			{
				if(StaffIsExists($signAarray['reStaffNo']))
				{
					$checkArr['reStaffNo']	=	"* Retype e-mail address exists already.";
				}else
				{
					$checkArr['reStaffNo']	=	"* Retype e-mail address is ok, but e-mail address is incorrect.";
				}
			}
		}else
		{
			$checkArr['reStaffNo']	=	"* Not a valid e-mail address..";
		}
	}
	//检查输入的密码是否正确
	$checkArr['password']	=	1;
	if(empty($signAarray['password']))
	{
		$checkArr['password']	=	"* Password can't be empty.";
	}else
	{

		if(strlen($signAarray['password'])<6)
		{
			$checkArr['password']	=	"* Password must be at least six characters in length.";
		}
		if(!preg_match('/\d+/',$signAarray['password']))
		{
			$checkArr['password']	=	"* Password must contain at least one number (ex.1_togo).";
		}
		$strArr1	=	explode(" ", $signAarray['password']);
		if(count($strArr1)>1)
		{
			$checkArr['password']	=	"* Password cannot contain spaces.";
		}
		$strArr2	=	explode($signAarray['staffNo'], $signAarray['password']);
		if(count($strArr2)>1)
		{
			$checkArr['password']	=	"* Password cannot contain your e-mail address.";
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
		$checkArr['safetyQuestion']	=	"* Security question can't be empty.";
	}else
	{
		$checkArr['safetyQuestion']	=	1;
	}
	if(empty($signAarray['questionResult']))
	{
		$checkArr['questionResult']	=	"* Security answer can't be empty.";
	}else
	{
		$checkArr['questionResult']	=	1;
	}

	if($checkArr['staffNo']==1 and $checkArr['reStaffNo']==1 and $checkArr['password']==1 and $checkArr['rePassword']==1 and $checkArr['safetyQuestion']==1 and $checkArr['questionResult']==1)
	{
		return 1;
	}else
	{
		//foreach ($checkArr as $key => $val)
		//{
		//	if($val!=1)
		//	{
		//		$str_field .= $val."<br>";
		//	}

		//}
		//$str_field = substr($str_field,0,-4);

		return $checkArr;
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

function backSignupData($in_Arr, $checked_Arr)
{
	foreach ($checked_Arr as $key => $val)
	{
		if($val!=1)
		{
			$str_field .= $val."<br>";
		}

	}
	$str_field = substr($str_field,0,-4);
	if($checked_Arr['name']==1)
	{
		$userDataStr.=	"name=" . $in_Arr['name'] . "&";
	}
	if($checked_Arr['staffNo']==1)
	{
		$userDataStr.=	"staffNo=" . $in_Arr['staffNo'] . "&";
	}
	if($checked_Arr['reStaffNo']==1)
	{
		$userDataStr.=	"reStaffNo=" . $in_Arr['reStaffNo'] . "&";
	}
	if($checked_Arr['password']==1)
	{
		$userDataStr.=	"password=" . $in_Arr['password'] . "&";
	}
	if($checked_Arr['rePassword']==1)
	{
		$userDataStr.=	"rePassword=" . $in_Arr['rePassword'] . "&";
	}
	if($checked_Arr['safetyQuestion']==1)
	{
		$safetyQuestion_tmp=substr($in_Arr['safetyQuestion'],0,-1);
		$userDataStr.=	"safetyQuestion=" . $safetyQuestion_tmp . "&";
	}
	if($checked_Arr['questionResult']==1)
	{
		$userDataStr.=	"questionResult=" . $in_Arr['questionResult'] . "&";
	}

	$userDataStr = substr($userDataStr,0,-1);
	$back_str="&alertStr=" . $str_field . "&" . $userDataStr;
	return $back_str;

}

function checkChangeData($signAarray,$changeType)
{
	if($changeType=='username')
	{
		//检查staffNo参数是否为空以及格式是否正确
		if(empty($signAarray['staffNo']))
		{
			$checkArr['staffNo']	=	"* E-mail address can't be empty.";						//为空
		}else
		{
			if(is_email($signAarray['staffNo']))
			{
				if(StaffIsExists($signAarray['staffNo']))
				{
					$checkArr['staffNo']	=	"* E-mail address is exist.";
				}else
				{
					$checkArr['staffNo']	=	1;
				}
			}else
			{
				$checkArr['staffNo']	=	"* Not a valid e-mail address..";
			}
		}
		//检查重复输入的stffno参数是否正确
		if(empty($signAarray['reStaffNo']))
		{
			$checkArr['reStaffNo']	=	"* Retype e-mail address can't be empty.";
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
						$checkArr['reStaffNo']	=	"* E-mail addresses must match.";
					}
				}else
				{
					if(StaffIsExists($signAarray['reStaffNo']))
					{
						$checkArr['reStaffNo']	=	"* Retype e-mail address is exist.";
					}else
					{
						$checkArr['reStaffNo']	=	"* Retype e-mail address is ok, but e-mail address is incorrect.";
					}
				}
			}else
			{
				$checkArr['reStaffNo']	=	"* Not a valid e-mail address..";
			}
		}
		//检查安全问题回答是否正确
		if(empty($signAarray['questionResult']))
		{
			$checkArr['questionResult']	=	"* Security answer can't be empty.";
		}else
		{
			if(verifySafty($signAarray['staffId'],$signAarray['safetyQuestion'],$signAarray['questionResult']))
			{
				$checkArr['questionResult']	=	1;
			}else
			{
				$checkArr['questionResult']	=	"* Security answer is wrong.";
			}
		}
		if($checkArr['staffNo']==1 and $checkArr['reStaffNo']==1 and $checkArr['questionResult']==1)
		{
			return 1;
		}else
		{
			//foreach ($checkArr as $key => $val)
			//{
			//	if($val!=1)
			//	{
			//		$str_field .= $val."<br>";
			//	}

			//}
			//$str_field = substr($str_field,0,-4);

			return $checkArr;
		}
	}
	if($changeType=='password')
	{
		//检查输入的旧密码是否正确
		$checkArr['oldPassword']	=	1;
		if(empty($signAarray['oldPassword']))
		{
			$checkArr['oldPassword']	=	"* Old password can't be empty.";
		}else
		{
			$password = md5($signAarray['oldPassword']);
			//$password = $checkArr['oldPassword'];
			$sql = "select password from {$GLOBALS['table']['member']['staff']} where staffId='".$signAarray['staffId']."'";
			//echo $sql;
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			if($result[0]['password'] === $password)
			{
				$checkArr['oldPassword']	=	1;
			}else
			{
				$checkArr['oldPassword']	=	"* Old Password is wrong.";
			}
		}
		//检查输入的密码是否正确
		$checkArr['newPassword']	=	1;
		if(empty($signAarray['newPassword']))
		{
			$checkArr['newPassword']	=	"* New Password can't be empty.";
		}else
		{
			if(strlen($signAarray['newPassword'])<6)
			{
				$checkArr['newPassword']	=	"* New Password must be at least six characters in length.";
			}
/*			if(!preg_match('/\d+/',$signAarray['newPassword']))
			{
				$checkArr['newPassword']	=	"* New Password must contain at least one number (ex.1_togo).";
			}*/
			$strArr1	=	explode(" ", $signAarray['newPassword']);
			if(count($strArr1)>1)
			{
				$checkArr['newPassword']	=	"* New Password cannot contain spaces.";
			}
			$strArr2	=	explode($signAarray['staffNo'], $signAarray['newPassword']);
			if(count($strArr2)>1)
			{
				$checkArr['newPassword']	=	"* New Password cannot contain your e-mail address.";
			}
		}
		//检查重复输入的密码是否正确
		if(empty($signAarray['rePassword']))
		{
			$checkArr['rePassword']	=	"* Retype password can't be empty.";
		}else
		{
			if(strcmp($signAarray['newPassword'], $signAarray['rePassword'])==0)
			{
				$checkArr['rePassword']	=	1;
			}else
			{
				$checkArr['rePassword']	=	"* Retype password must be as same as password.";
			}
		}

		//检查安全问题回答是否正确
		if(empty($signAarray['questionResult']))
		{
			$checkArr['questionResult']	=	"* Security answer can't be empty.";
		}else
		{
			if(verifySafty($signAarray['staffId'],$signAarray['safetyQuestion'],$signAarray['questionResult']))
			{
				$checkArr['questionResult']	=	1;
			}else
			{
				$checkArr['questionResult']	=	"* Security answer is wrong.";
			}
		}
		if($checkArr['oldPassword']==1 and $checkArr['newPassword']==1 and $checkArr['rePassword']==1 and $checkArr['questionResult']==1)
		{
			return 1;
		}else
		{
			return $checkArr;
		}
	}
	if($changeType=='nickname')
	{
		//检查输入的旧密码是否正确
		$checkArr['staffName']	=	1;
		if(empty($signAarray['staffName']))
		{
			$checkArr['staffName']	=	"* Nickname can't be empty.";
		}else
		{
			$checkArr['staffName']	=	1;
		}


		//检查安全问题回答是否正确
		if(empty($signAarray['questionResult']))
		{
			$checkArr['questionResult']	=	"* Security answer can't be empty.";
		}else
		{
			if(verifySafty($signAarray['staffId'],$signAarray['safetyQuestion'],$signAarray['questionResult']))
			{
				$checkArr['questionResult']	=	1;
			}else
			{
				$checkArr['questionResult']	=	"* Security answer is wrong.";
			}
		}
		if($checkArr['staffName']==1 and $checkArr['questionResult']==1)
		{
			return 1;
		}else
		{
			return $checkArr;
		}
	}
}
function backChangeData($in_Arr, $checked_Arr,$changeType)
{
	foreach ($checked_Arr as $key => $val)
	{
		if($val!=1)
		{
			$str_field .= $val."<br>";
		}

	}
	$str_field = substr($str_field,0,-4);
	if($changeType=='username')
	{
		if($checked_Arr['staffNo']==1)
		{
			$userDataStr.=	"staffNo=" . $in_Arr['staffNo'] . "&";
		}
		if($checked_Arr['reStaffNo']==1)
		{
			$userDataStr.=	"reStaffNo=" . $in_Arr['reStaffNo'] . "&";
		}
		if($checked_Arr['questionResult']==1)
		{
			$userDataStr.=	"questionResult1=" . $in_Arr['questionResult'] . "&";
		}
		$back_str="&alertStr=";
	}
	if($changeType=='password')
	{
		if($checked_Arr['questionResult']==1)
		{
			$userDataStr.=	"questionResult2=" . $in_Arr['questionResult'] . "&";
		}
		$back_str="&alertStr1=";
	}
	if($changeType=='nickname')
	{
		if($checked_Arr['staffName']==1)
		{
			$userDataStr.=	"staffName=" . $in_Arr['staffName'] . "&";
		}
		if($checked_Arr['questionResult']==1)
		{
			$userDataStr.=	"questionResult3=" . $in_Arr['questionResult'] . "&";
		}
		$back_str="&alertStr2=";
	}

	$userDataStr = substr($userDataStr,0,-1);
	$back_str=$back_str . $str_field . "&" . $userDataStr;
	return $back_str;

}

function checkAddressData($signAarray)
{
	if(empty($signAarray['fullName']))
	{
		$checkArr['fullName']	=	"* Full name can't be empty.";						//为空
	}else
	{
		$checkArr['fullName']	=	1;
	}
	if(empty($signAarray['address1']))
	{
		$checkArr['address1']	=	"* address1 can't be empty.";						//为空
	}else
	{
		$checkArr['address1']	=	1;
	}
	if(empty($signAarray['address2']))
	{
		$checkArr['address2']	=	"* address2 can't be empty.";						//为空
	}else
	{
		$checkArr['address2']	=	1;
	}
	if(empty($signAarray['country']))
	{
		$checkArr['country']	=	"* country can't be empty.";						//为空
	}else
	{
		$checkArr['country']	=	1;
	}
	if(empty($signAarray['province']))
	{
		$checkArr['province']	=	"* province can't be empty.";						//为空
	}else
	{
		$checkArr['province']	=	1;
	}
	if(empty($signAarray['city']))
	{
		$checkArr['city']	=	"* city can't be empty.";						//为空
	}else
	{
		$checkArr['city']	=	1;
	}
	if(empty($signAarray['cellphone']))
	{
		$checkArr['cellphone']	=	"* cellphone can't be empty.";						//为空
	}else
	{
		$checkArr['cellphone']	=	1;
	}
	if($signAarray['emailFlag']	==	1)
	{
		//echo "111";
		if(empty($signAarray['email']))
		{
			$checkArr['email']	=	"* E-mail address can't be empty.";						//为空
		}else
		{
			if(is_email($signAarray['email']))
			{
				if(StaffIsExists($signAarray['email']))
				{
					$checkArr['email']	=	"* E-mail address is exist, please log in or change another e-mail";
				}else
				{
					$checkArr['email']	=	1;
				}
			}else
			{
				$checkArr['email']	=	"* Not a valid e-mail address..";
			}
		}
	}
	if($signAarray['emailFlag']	==	1)
	{
		if($checkArr['fullName']==1 and $checkArr['address1']==1 and $checkArr['address2']==1 and $checkArr['country']==1 and $checkArr['province']==1 and $checkArr['city']==1 and $checkArr['cellphone']==1 and $checkArr['email']==1)
		{
			return 1;
		}else
		{
			return $checkArr;
		}
	}elseif($signAarray['emailFlag']	==	0)
	{
		if($checkArr['fullName']==1 and $checkArr['address1']==1 and $checkArr['address2']==1 and $checkArr['country']==1 and $checkArr['province']==1 and $checkArr['city']==1 and $checkArr['cellphone']==1)
		{
			return 1;
		}else
		{
			return $checkArr;
		}
	}
}
function backAddressData($in_Arr, $checked_Arr)
{
	foreach ($checked_Arr as $key => $val)
	{
		if($val!=1)
		{
			$str_field .= $val."<br>";
		}

	}
	$str_field = substr($str_field,0,-4);

	if($checked_Arr['fullName']==1)
	{
		$userDataStr.=	"fullName=" . $in_Arr['fullName'] . "&";
	}
	if($checked_Arr['address1']==1)
	{
		$userDataStr.=	"address1=" . $in_Arr['address1'] . "&";
	}
	if($checked_Arr['address2']==1)
	{
		$userDataStr.=	"address2=" . $in_Arr['address2'] . "&";
	}
	if($checked_Arr['country']==1)
	{
		$userDataStr.=	"country=" . $in_Arr['country'] . "&";
	}

	if($checked_Arr['province']==1)
	{
		$userDataStr.=	"province=" . $in_Arr['province'] . "&";
	}
	if($checked_Arr['city']==1)
	{
		$userDataStr.=	"city=" . $in_Arr['city'] . "&";
	}
	if($checked_Arr['cellphone']==1)
	{
		$userDataStr.=	"cellphone=" . $in_Arr['cellphone'] . "&";
	}
	if($signAarray['emailFlag']	=	1)
	{
		if($checked_Arr['email']==1)
		{
			$userDataStr.=	"email=" . $in_Arr['email'] . "&";
		}
	}
	$userDataStr = substr($userDataStr,0,-1);
	//echo $userDataStr;
	$back_str="&alertStr=" . $str_field . "&" . $userDataStr;
	return $back_str;

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
