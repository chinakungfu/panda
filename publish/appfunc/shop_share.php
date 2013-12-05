<?
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.member.dbsession');
import('core.incfunc');
include_once($GLOBALS['currentApp']['domainpath']."/web-inf/lib/coreconfig/public_res.ini.php");
function getShopShareInfo($getAjaxGoodsIndex,$getAjaxGoodsSize)
{
	try {
		$params['currentPage'] = $getAjaxGoodsIndex;
		$params['pageSize'] = $getAjaxGoodsSize;
		//print_r($params);
		$sql = "SELECT a.shareId,b.goodsImgURL,b.goodsTitleEn,b.goodsTitleCN,a.shareComment, c.staffName,a.shareTime, b.goodsType,b.goodsUnitPrice,c.headImageUrl FROM cms_publish_share a, cms_publish_goods b, cms_member_staff c WHERE a.shareStatus=1 and a.goodsId=b.goodsId and a.userId=c.staffId order by a.shareId desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		$json = array();
		foreach($result['data'] as $key=>$val)
		{
			//$val['goodsImgURL']=getUpFilePath($val['goodsImgURL']);
			if ($val['goodsType']=='inside'){
				$val['goodsImgURL']='../web-inf/lib/coreconfig/'.$val['goodsImgURL'];
			}
			if ($val['goodsType']=='outside'){
				$val['goodsImgURL']=$val['goodsImgURL'];
			}
			
			if (sizeof($val['goodsTitleEn'])==0){
				$val['goodsTitle']=$val['goodsTitleCN'];
			}else
			{
				$val['goodsTitle']=$val['goodsTitleEn'];
			}
			$val['shareTime']=date("Y-m-d H:i:s",$val['shareTime']);
			$val['goodsUnitPrice']=number_format($val['goodsUnitPrice'], 2, '.', ',');
			$val['urlStr']=encrypt_url("action=share&method=detail&shareID=".$val['shareId']);
			$val['headImgUrl']=getUpHeadImgPath($val['headImageUrl']);
			$val['favoriteQuantity']=favoriteCount($val['shareId']);
			$val['commentQuantity']=commentCount($val['shareId'])+1;
			$json[] = (object)$val;
		}
		return json_encode( $json );
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getMyShareInfo($getAjaxGoodsIndex,$getAjaxGoodsSize)
{
	try {
		$sessId = $_COOKIE['sesCoo'];		
		$dbSession = new dbSession();
		$userId= $dbSession->read($sessId);

		$params['currentPage'] = $getAjaxGoodsIndex;
		$params['pageSize'] = $getAjaxGoodsSize;
		//print_r($params);
		$sql = "SELECT a.shareId,b.goodsImgURL,b.goodsTitleEn,b.goodsTitleCN,a.shareComment, c.staffName,a.shareTime, b.goodsType ,b.goodsUnitPrice,c.headImageUrl FROM cms_publish_share a, cms_publish_goods b, cms_member_staff c WHERE a.shareStatus=1 and a.goodsId=b.goodsId and a.userId=c.staffId and a.userId=".$userId." order by a.shareId desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//echo $sql;
		$json = array();
		foreach($result['data'] as $key=>$val)
		{
			//$val['goodsImgURL']=getUpFilePath($val['goodsImgURL']);
			if ($val['goodsType']=='inside'){
				$val['goodsImgURL']='../web-inf/lib/coreconfig/'.$val['goodsImgURL'];
			}
			if ($val['goodsType']=='outside'){
				$val['goodsImgURL']=$val['goodsImgURL'];
			}
			
			if (sizeof($val['goodsTitleEn'])==0){
				$val['goodsTitle']=$val['goodsTitleCN'];
			}else
			{
				$val['goodsTitle']=$val['goodsTitleEn'];
			}
			$val['shareTime']=date("Y-m-d H:i:s",$val['shareTime']);
			$val['goodsUnitPrice']=number_format($val['goodsUnitPrice'], 2, '.', ',');
			$val['urlStr']=encrypt_url("action=share&method=detail&shareID=".$val['shareId']);
			$val['headImgUrl']=getUpHeadImgPath($val['headImageUrl']);
			$val['favoriteQuantity']=favoriteCount($val['shareId']);
			$val['commentQuantity']=commentCount($val['shareId'])+1;
			$json[] = (object)$val;
		}
		return json_encode( $json );
	}catch (Exception $e)
	{
		throw $e;
	}
}
function getMyShareLove($getAjaxGoodsIndex,$getAjaxGoodsSize)
{
	try {
		$sessId = $_COOKIE['sesCoo'];		
		$dbSession = new dbSession();
		$userId= $dbSession->read($sessId);

		$params['currentPage'] = $getAjaxGoodsIndex;
		$params['pageSize'] = $getAjaxGoodsSize;
		//print_r($params);
		$sql = "SELECT shareId from cms_publish_favorite where userid='".$userId."'";
		$result1 = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//echo $sql;
		$json = array();
		foreach($result1['data'] as $key=>$val)
		{
			$shareIdStr = $shareIdStr."'".$val['shareId']."',";
		}
		$str_field = substr($shareIdStr,0,-1);
		//echo $str_field;

		$sql = "SELECT a.shareId,b.goodsImgURL,b.goodsTitleEn,b.goodsTitleCN,a.shareComment, c.staffName,a.shareTime, b.goodsType ,b.goodsUnitPrice,c.headImageUrl FROM cms_publish_share a, cms_publish_goods b, cms_member_staff c WHERE a.shareStatus=1 and a.goodsId=b.goodsId and a.userId=c.staffId and a.shareId in (".$str_field.")   order by a.shareId desc";
		$result2 = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//echo $sql;
		$json = array();
		foreach($result2['data'] as $key=>$val)
		{
			//$val['goodsImgURL']=getUpFilePath($val['goodsImgURL']);
			if ($val['goodsType']=='inside'){
				$val['goodsImgURL']='../web-inf/lib/coreconfig/'.$val['goodsImgURL'];
			}
			if ($val['goodsType']=='outside'){
				$val['goodsImgURL']=$val['goodsImgURL'];
			}
			
			if (sizeof($val['goodsTitleEn'])==0){
				$val['goodsTitle']=$val['goodsTitleCN'];
			}else
			{
				$val['goodsTitle']=$val['goodsTitleEn'];
			}
			$val['shareTime']=date("Y-m-d H:i:s",$val['shareTime']);
			$val['goodsUnitPrice']=number_format($val['goodsUnitPrice'], 2, '.', ',');
			$val['urlStr']=encrypt_url("action=share&method=detail&shareID=".$val['shareId']);
			$val['headImgUrl']=getUpHeadImgPath($val['headImageUrl']);
			$val['favoriteQuantity']=favoriteCount($val['shareId']);
			$val['commentQuantity']=commentCount($val['shareId'])+1;
			$json[] = (object)$val;
		}

		return json_encode( $json );
	}catch (Exception $e)
	{
		throw $e;
	}
}


function getUpFilePath($filePath)
{
	try {
		$filePathArray = explode("PID=",$filePath);
		$params = base64_decode($filePathArray[1]);
		$params = explode('|',$params);
		$imagePath = $GLOBALS['currentApp']['resconfig']['url'].$params["1"].'/'.$params['2'];
		return $imagePath;
	}catch (Exception $e)
	{
		throw $e;
	}
}

function getUpHeadImgPath($filePath)
{
	try {
		if($filePath=='')
		{
			$imagePath="../skin/images/pic.jpg";
		}
		else
		{
			$filePathArray = explode("PID=",$filePath);
			$params = base64_decode($filePathArray[1]);
			$params = explode('|',$params);
			$imagePath = $GLOBALS['currentApp']['resconfig']['url'].$params["1"].'/'.$params['2'];
		}
		return $imagePath;
	}catch (Exception $e)
	{
		throw $e;
	}
}
function favoriteCount($shareId)
{
	try {		
		$sql = "SELECT COUNT(favoriteId) as favoriteCount FROM cms_publish_favorite where shareId='" . $shareId . "'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//print_r($result[0]['favoriteCount']);
		return $result[0]['favoriteCount'];
		//echo $val['favoriteCount'];
	}catch (Exception $e)
	{
		throw $e;
	}
}
function commentCount($shareId)
{
	try {		
		$sql = "SELECT count(commentId) as commentCount from cms_publish_sharecomment where shareId='" . $shareId . "'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		//print_r($result[0]['favoriteCount']);
		return $result[0]['commentCount'];
		//echo $val['favoriteCount'];
	}catch (Exception $e)
	{
		throw $e;
	}
}


?>