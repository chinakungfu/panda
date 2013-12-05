<?php
/**
 * *****
 * 会员增删改以及查询操作信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.member.popedom');
import('core.apprun.page.Page');
import('core.apprun.cms.system.data_operation');
//验证是否存在
//memberIsExists('username','artfantasy')
//存在返回true
function OperationIsExists($memberNo)
{
	try{
		$sql = "SELECT * FROM {$GLOBALS['table']['member']['operations']} WHERE operationNo= :operationNo LIMIT 1";
		$params['operationNo'] = $memberNo;
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
//function listOperation()
//{
//	try {
//		$sql = "select * from {$GLOBALS['table']['member']['operations']} order by operationId";
//		/*if($GLOBALS['IN']['currentPage']!=''){
//			$params['currentPage'] = $GLOBALS['IN']['currentPage'];
//		}else 
//		{
//			$params['currentPage'] = 1;
//		}		
//		$params['pageSize'] = 1;*/
//		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
//		return $result;
//	}catch (Exception $e)
//	{
//		throw $e;
//	}
//}
function listOperation($sqlCon,$bindFlag)
{
	try {
		//insertOperationData();
		if($bindFlag=='1'){
			$sql = "select * from {$GLOBALS['table']['member']['operations']}";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return $result;
		}else 
		{
			if($sqlCon!=null)
			{
				$Con = substr($sqlCon,strpos($sqlCon,'%')+1,-2);
				setSession($GLOBALS['IN']['action'],$GLOBALS['IN']['method'],$Con);
				setSession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con",$sqlCon);
				$paramStr = "'".$sqlCon."'";
				$sqlCon ="where ".$sqlCon;
				$sql = "select * from {$GLOBALS['table']['member']['operations']} ".$sqlCon." order by operationId DESC";
				print "您查找的是：".querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
			}
//elseif(querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con")!='')
//			{
//				$sqlCon = querySession($GLOBALS['IN']['action'],$GLOBALS['IN']['method']."con");
//				$sqlCon ="where ".$sqlCon;
//				$sql = "select * from {$GLOBALS['table']['member']['operations']} ".$sqlCon;
//			}
		else 
			{
				$sql = "select * from {$GLOBALS['table']['member']['operations']} order by operationId DESC";
			}
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
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * 
 * **/
function contentPage($url,$listPageCount)
{
	try {
		$url = "index.php?action=operation&method=listoperation";
		$page = listOperation();
		$pageStr = '<div>';
		$pageStr .= "共：".$page['rowcount']."条记录 共：".$page['pagecount']."页 当前页：".$page['currentPage']; 
		$pageStr .=  "<a href=''>首页</a>";
		if(!$page['hasprior'])
		{
			"index.php?action=operation&method=listoperation&currentPage=[$operations.priorpage]";
			$pageStr .= "<a href='".$url."currentPage'>上一页</a>";
		}
		if(!$page['hasnext'])
		{
			$pageStr .= "<a href=''>下一页</a>";
		}
		$pageStr .=  "<a href=''>末页</a>";
		$pageStr."</div>";
		$page['pageStr'] = $pageStr;
	}catch (Exception $e){
		throw $e;
	}
	
}
//新增一操作，传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//新增成功则返回新建操作的uid,失败则返回false;
function addOperation($memberArray)
{
	try
	{
		foreach ($memberArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['member']['operations']} (".$str_field.") values (".$str_value.")";
		/*$birthDay = '0000-00-00';
		$operationNo = $operationName = $password = $email = $safetyQuestion = $questionResult = $sex = $homepage = $qq = $rowId = $msn='';
		extract($memberArray);
		!preg_match("/^(((19)|(20))[0-9][0-9])-(1[0-2]|0[1-9])-(3[0,1]|[1,2][0-9]|0[1-9])$/i",$birthdate) && $birthdate = '0000-00-00';
		
		
		//$sql = "insert into {$GLOBALS['table']['member']['operations']}
				//(operationNo,operationName,password,email,safetyQuestion,questionResult,sex,birthDay,homepage,qq,rowId,msn)
				//values (:operationNo,:operationName,:password,:email,:safetyQuestion,:questionResult,:sex,:birthDay,:homepage,:qq,:rowId,:msn)";
		$params = array(
				'operationNo' => $operationNo,
				'operationName' => $operationName,
				'password' => $password,
				'email' => $email,
				'safetyQuestion' => $safetyQuestion,
				'questionResult' => $questionResult,
				'sex' => $sex,
				'birthDay' => $birthDay,
				'homepage' => $homepage,
				'qq' => $qq,
				'rowId' => $rowId,
				'msn' => $msn,
			);*/
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
	} 
	catch (Exception $e)
	{
		throw $e;
	}
}

//修改指定uid的操作信息,传入变量请按照会员信息的字段组成数组传入
//比如array('username'=>'artfantasy','email'=>'artfantasy@gmail.com')
//失败返回false, 成功返回影响行数
function editOperation($memberId,$memberArray)
{
	try
	{
		foreach ($memberArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['member']['operations']} set $sql where operationId=".$memberId;
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$memberArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}

//根据某操作属性删除操作,比如根据uid,email
function delOperation($memberId)
{
	try
	{
		$infoIdArray = explode(',',$memberId);
		for($i=0;$i<count($infoIdArray)-1;$i++)
		{
			$sql = "DELETE FROM {$GLOBALS['table']['member']['operations']} WHERE `operationId`=:operationId";
			$params['operationId'] = $infoIdArray[$i];
			TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}
		return true;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//传入操作ID，查询操作所有信息
function getOperationInfoById($memberId)
{
	try
	{	
		$sql = "select * from {$GLOBALS['table']['member']['operations']} where operationId= {$memberId}";
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
//=============================================
//自动生成操作标识
//=============================================
function fullOperationFlag($operationName)
{
	try {
		$spell = new spell_class();
		$str = $spell->sStr2py($operationName);
		$str .= random(4);
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function insertOperationData()
{
	$Str = "menu 菜单管理,frameListMenu 菜单frame,addMenu 新增菜单,editMenu 修改菜单,saveAddMenu 新增保存菜单,saveEditMenu 修改保存菜单,delMenu 删除菜单,listCustomer 客户管理,frameListCustomer 客户frame,addCustomer 新增客户,editCustomer 编辑客户,saveAddCustomer 新增保存客户,saveEditCustomer 编辑保存客户,delCustomer 删除客户,detailCustomer 客户明细,listSupplier 供应商管理,frameListSupplier 供应商frame,addSupplier 新增供应商,editSupplier 修改供应商,saveAddSupplier 新增保存供应商,saveEditSupplier 修改保存供应商,delSupplier 删除供应商,detailSupplier 供应商明细,purchaseOrder 采购单管理,framePurchaseOrder 采购单明细,addPurchaseOrder 新增采购单,editPurchaseOrder 修改采购单,saveAddPurchaseOrder 新增保存采购单,saveEditPurchaseOrder 修改保存采购单,delPurchaseOrder 删除采购单,detailPurchaseOrder 采购单明细,maintenanceOrder 维护单管理,frameMaintenanceOrder 维护单frame,addMaintenanceOrder 新增维护单,editMaintenanceOrder 修改维护单,saveAddMaintenanceOrder 新增保存维护单,saveEditMaintenanceOrder 修改保存维护单,delMaintenanceOrder 删除维护单,detailMaintenanceOrder 维护单明细,bussinessLog 业务日志,frameBussinessLog 业务日志frame,detailLog 业务日志明细";
	$StrArray = explode(",",$Str);
	foreach ($StrArray as $key => $val)
	{
		$newArray = explode(" ",$val);
		$operArray['operationName'] = $newArray[1];
		$operArray['operationNo'] = fullOperationFlag($newArray[1]);
		$operArray['appId'] = "publish";
		$operArray['moduleId'] = "publish";
		$operArray['actionId'] = $newArray[0];
		$operArray['distinctionNo'] = 0;
		$operArray['contentFlag'] = 0;
		$operArray['isSecondAuth'] = 1;
		//addOperation($operArray);
	}
}
?>

