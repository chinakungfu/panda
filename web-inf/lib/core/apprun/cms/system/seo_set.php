<?
/**
 * add zxqer 20090304
 * 该文件主要用来设置通用ＣＭＳ的字段管理
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');

/**
 *用于显示SEO变量的基本信息 
 **/       
function listSeo()
{
	try
	{
		date_default_timezone_set('PRC');
		if($GLOBALS['IN']['currentPage']!=''){
			$seoArray['currentPage'] = $GLOBALS['IN']['currentPage'];
		}else 
		{
			$seoArray['currentPage'] = 1;
		}
		$seoArray['pageSize'] = 10;
		$sql = "select * from {$GLOBALS['table']['cms']['tpl_seo']} order by seoId desc";
		$result = TStaticQuery::queryForPage($GLOBALS['currentApp']['dbaccess'],$sql,$seoArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到SEO变量的基本信息 
 **/       
function getSeoInfoById($seoId)
{
	try
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['cms']['tpl_seo']} where seoId =:seoId";
		$seoArray['seoId'] = $seoId;
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$seoArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *根据ID得到SEO变量的基本信息 
 **/       
function editSeo($seoId,$seoArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($seoArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['cms']['tpl_seo']} set $sql where seoId=:seoId";
		$seoArray['seoId'] = $seoId;
		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$seoArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *添加SEO变量的基本信息 
 **/       
function addSeo($seoArray)
{
	try
	{
		date_default_timezone_set('PRC');
		foreach ($seoArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['cms']['tpl_seo']} (".$str_field.") values (".$str_value.")";
		$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$seoArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 *删除SEO变量的基本信息 
 **/       
function delSeo($seoId)
{
	try
	{
		$sql = "delete from {$GLOBALS['table']['cms']['tpl_seo']} where seoId=:seoId";
		$seoArray['seoId'] = $seoId;
		$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$seoArray);
		return $result;
	} catch (Exception $e)
	{
		throw $e;
	}
}

/**
 *取出cms所有的SEO变量
 **/       
function getSeoInfoBySeoName($tplSeo)
{
	try
	{
		$sql = "select * from {$GLOBALS['table']['cms']['tpl_seo']} where seoGuid='".$tplSeo."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$seoArray);
		if(!empty($result))
		{
			foreach ($result[0] as $key => $val)
			{
				if($key=='seoGenerator')
				{
					$str .='<meta name="Generator" content="'.$val.'">'."\n";
				}elseif ($key=='seoKeywords')
				{
					$str .='<meta name="Keywords" content="'.$val.'">'."\n";
				}elseif ($key=='seoDescription')
				{
					$str .='<meta name="Description" content="'.$val.'">'."\n";
				}elseif ($key=='seoAuthor')
				{
					$str .='<meta name="Author" content="'.$val.'">'."\n";
				}elseif ($key=='seoRobots')
				{
					$str .='<meta name="Robots" content="'.$val.'">'."\n";
				}
			}
		}
		return $str;
	} catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 
 * */
function selectSeoName()
{
	try {
		$sql = "select * from {$GLOBALS['table']['cms']['tpl_seo']} order by seoId desc";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$seoArray);
		if(!empty($result))
		{
			foreach ($result as $key => $val)
			{
				$str .="<option value='".$val['seoGuid']."'>".$val['seoName']."</option>";
			}
		}
		return $str;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>