<?php
/**
 *用于处理系统各页的分页 
 **/
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
/**
 * 列表参数设置
 * */
function setSession($action,$method,$sqlCon)
{
	try
	{
		session_start();
		//		for($i=0;$i<count($conArray);$i++)
		//		{
		$_SESSION[$action][$method]["con"][$i] = $sqlCon;
		//		}
		return $_SESSION;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 查询列表参数
 * */
function querySession($action,$method)
{
	try
	{
		session_start();
		//		for($i=0;$i<count($_SESSION[$action][$method]['con']);$i++)
		//		{
		$strSESSION = $_SESSION[$action][$method]['con'][$i];
		//		}
		return $strSESSION;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 用来处理页面内容分页用的
 * **/
function list1ContentPage($str,$currentPage,$pageSize,$url,$param=null)
{
	try {
		if($currentPage==null)
		{
			$currentPage = 1;
		}
		$pageCount = ceil(strlen($str)/$pageSize);
		$pageStr = substr($str,($currentPage-1)*$pageSize,$pageSize)."<br>";
		//$url = $url."?action=".$GLOBALS['IN']['action']."&method=".$GLOBALS['IN']['method'];
		for($i=0;$i<$pageCount;$i++)
		{
			$pageStr .= "<a href='".$url."?currentPage=".($i+1)."'>".($i+1)."</a>&nbsp;&nbsp;";
		}
		return $pageStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}

/*
*
*分页函数
*/
function listssPage($page,$url,$listsize,$param ='',$language='0')
{
	try {
		$url = $_SERVER['REQUEST_URI'];
		$pageStr = "<style type=\"text/css\">
		<!--
		a:link {
			text-decoration: none;
		}
		a:visited {
			text-decoration: none;
		}
		a:hover {
			text-decoration: underline;
		}
		a:active {
			text-decoration: none;
		}
		-->
		</style>";
		if($language=='0')
		{
			$listSizeStart = $GLOBALS['IN']['listSizeStart'];
			if($listSizeStart=='')
			{
				$listSizeStart = 1;
			}
			if($page['currentPage']<=$page['pagecount'])
			{
				if(($page['currentPage']-1)%$listsize==0)//判断是不是在当前几页
				{
					$listSizeStart = $page['currentPage'];
				}
				$url = $url.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param;
				if($page['pagecount']>$listsize)
				{
					if($page['currentPage']<$listsize)
					{
						for($i=1;$i<=$listsize;$i++)
						{
							if($page['currentPage']==$i)
							{
								$n = "<font style='font-weight:bold;'>".$i."&nbsp;&nbsp;&nbsp;&nbsp;</font>";
							}else
							{
								$n = "<a href='".$url."&currentPage=".$i."'>".$i."&nbsp;&nbsp;&nbsp;&nbsp;</a>";
							}
							$str .="".$n."";
						}
					}else
					{
						if(($page['pagecount']-$page['currentPage'])<$listsize)
						{
							$residue = $GLOBALS['IN']['residue'];
							if($residue=='')
							{
								$count = $listSizeStart+$page['pagecount']-$page['currentPage']+1;
							}else
							{
								$count = $residue;
							}
						}else
						{
							$count = $listSizeStart + $listsize;
						}
						for($i=$listSizeStart;$i<$count;$i++)
						{
							if($page['currentPage']==$i)
							{
								$n = "<font style='font-weight:bold;'>".$i."</font>&nbsp;&nbsp;&nbsp;&nbsp;";
							}else
							{
								$n = "<a href='".$url."&currentPage=".$i."'>".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
							}
							$str .="".$n."";
						}
					}
	
				}else
				{
					for($i=1;$i<$page['pagecount']+1;$i++)
					{
						if($page['currentPage']==$i)
						{
							$n = "<font style='font-weight:bold;'>".$i."</font>&nbsp;&nbsp;&nbsp;&nbsp;";
						}else
						{
							$n = "<a href='".$url."&currentPage=".$i."'>".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						$str .="".$n."";
					}
					$isPage = false;
				}
			}
	
			if($page['hasprior'])
			{
				if($page['currentPage']>$listsize)
				{
					$prePageStr .= "<a href='".$url."&currentPage=".($listSizeStart-$listsize)."'>前 ".$listsize."页</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			}
			if($page['hasnext'])
			{
				if(($page['pagecount']-$page['currentPage'])>$listsize)
				{
					$nextPageStr .= "<a href='".$url."&currentPage=".($listSizeStart+$listsize)."'>后 ".$listsize."页</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			}
			$pageStr .='共:'.$page['rowcount'].'条记录&nbsp;&nbsp;&nbsp;&nbsp;';
			$pageStr .='页数:'.$page['currentPage'].'/'.$page['pagecount'].'&nbsp;&nbsp;&nbsp;&nbsp;';
			if($page['currentPage']!=1)
			{
				$pageStr .='<a href="'.$url.'&currentPage=1">首页</a>&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			if($page['currentPage']>1)
			{
				$pageStr .= '<a href="'.$url.'&currentPage='.($page['currentPage']-1).'"> 前一页</a>&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			$pageStr .= $prePageStr;
			$pageStr .= $str;
			$pageStr .= $nextPageStr;
			if($page['currentPage']<$page['pagecount'])
			{
				$pageStr .='<a href="'.$url.'&currentPage='.($page['currentPage']+1).'">下一页 </a>&nbsp;&nbsp;&nbsp;&nbsp;';
			}
	
			$s = $page['pagecount']/$listsize;
			$s = floor($s);
			$s = $s*$listsize+1;
			$url = $endUrl.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$s."&".$param;
			if($page['currentPage']!=$page['pagecount'])
			{
				$pageStr .= '<a href="'.$url.'&currentPage='.$page['pagecount'].'&residue='.($page['pagecount']+1).'">末页&nbsp;&nbsp;&nbsp;&nbsp;</a>';
			}
			$pageStr .= '';
		}else 
		{
			$listSizeStart = $GLOBALS['IN']['listSizeStart'];
			if($listSizeStart=='')
			{
				$listSizeStart = 1;
			}
			if($page['currentPage']<=$page['pagecount'])
			{
				if(($page['currentPage']-1)%$listsize==0)//判断是不是在当前几页
				{
					$listSizeStart = $page['currentPage'];
				}
				$url = $url.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param;
				if($page['pagecount']>$listsize)
				{
					if($page['currentPage']<$listsize)
					{
						for($i=1;$i<=$listsize;$i++)
						{
							if($page['currentPage']==$i)
							{
								$n = "<font style='font-weight:bold;'>".$i."&nbsp;&nbsp;&nbsp;&nbsp;</font>";
							}else
							{
								$n = "<a href='".$url."&currentPage=".$i."'>".$i."&nbsp;&nbsp;&nbsp;&nbsp;</a>";
							}
							$str .="".$n."";
						}
					}else
					{
						if(($page['pagecount']-$page['currentPage'])<$listsize)
						{
							$residue = $GLOBALS['IN']['residue'];
							if($residue=='')
							{
								$count = $listSizeStart+$page['pagecount']-$page['currentPage']+1;
							}else
							{
								$count = $residue;
							}
						}else
						{
							$count = $listSizeStart + $listsize;
						}
						for($i=$listSizeStart;$i<$count;$i++)
						{
							if($page['currentPage']==$i)
							{
								$n = "<font style='font-weight:bold;'>".$i."</font>&nbsp;&nbsp;&nbsp;&nbsp;";
							}else
							{
								$n = "<a href='".$url."&currentPage=".$i."'>".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
							}
							$str .="".$n."";
						}
					}
	
				}else
				{
					for($i=1;$i<$page['pagecount']+1;$i++)
					{
						if($page['currentPage']==$i)
						{
							$n = "<font style='font-weight:bold;'>".$i."</font>&nbsp;&nbsp;&nbsp;&nbsp;";
						}else
						{
							$n = "<a href='".$url."&currentPage=".$i."'>".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						$str .="".$n."";
					}
					$isPage = false;
				}
			}
	
			if($page['hasprior'])
			{
				if($page['currentPage']>$listsize)
				{
					$prePageStr .= "<a href='".$url."&currentPage=".($listSizeStart-$listsize)."'>Pre ".$listsize." pages</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			}
			if($page['hasnext'])
			{
				if(($page['pagecount']-$page['currentPage'])>$listsize)
				{
					$nextPageStr .= "<a href='".$url."&currentPage=".($listSizeStart+$listsize)."'>Next ".$listsize." pages</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			}
			$pageStr .='Total:'.$page['rowcount'].'records&nbsp;&nbsp;&nbsp;&nbsp;';
			$pageStr .='Pages:'.$page['currentPage'].'/'.$page['pagecount'].'&nbsp;&nbsp;&nbsp;&nbsp;';
			if($page['currentPage']!=1)
			{
				$pageStr .='<a href="'.$url.'&currentPage=1">First</a>&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			if($page['currentPage']>1)
			{
				$pageStr .= '<a href="'.$url.'&currentPage='.($page['currentPage']-1).'"> Pre</a>&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			$pageStr .= $prePageStr;
			$pageStr .= $str;
			$pageStr .= $nextPageStr;
			if($page['currentPage']<$page['pagecount'])
			{
				$pageStr .='<a href="'.$url.'&currentPage='.($page['currentPage']+1).'">Next </a>&nbsp;&nbsp;&nbsp;&nbsp;';
			}
	
			$s = $page['pagecount']/$listsize;
			$s = floor($s);
			$s = $s*$listsize+1;
			$url = $endUrl.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$s."&".$param;
			if($page['currentPage']!=$page['pagecount'])
			{
				$pageStr .= '<a href="'.$url.'&currentPage='.$page['pagecount'].'&residue='.($page['pagecount']+1).'">Last&nbsp;&nbsp;&nbsp;&nbsp;</a>';
			}
			$pageStr .= '';
		}
		return $pageStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}


function listPageUrl($page,$url,$listsize,$param =''){

	$ret=array(
		'pageInfo'=>array(
			'listSize'		=>$listsize,
			'recordCount'	=>$page['rowcount'],
			'currentPage'	=>$page['currentPage'],
			'pageCount'		=>ceil($page['rowcount']/$page['pagesize'])
		)
	);


	$baseurl="action=".$GLOBALS['IN']['action']."&method=".$GLOBALS['IN']['method'];
	if(!empty($param)) $baseurl .= "&$param";

	if($page['currentPage']<=$page['pagecount'])
	{
		$listSizeStart = floor(($page['currentPage']-1)/$listsize)*$listsize+1;
		
		for($i=0;$i<$listsize;$i++){
			$pageindex=$i+$listSizeStart;
			if($pageindex>$page['pagecount']) break;
			$ret['url']['list'][$pageindex] = $url.encrypt_url($baseurl.$page['isText']."&currentPage=".$pageindex);
		}
		/*
		if($page['pagecount']>$listsize)
		{
			if($page['currentPage']<$listsize) {
				for($i=1;$i<=$listsize;$i++) {
					$ret['url']['list'][$i] =$url.encrypt_url($baseurl.$page['isText']."&currentPage=".$i);
				}
			}else{
				if(($page['pagecount']-$page['currentPage'])<$listsize) {
					if($residue=='') {
						$count = $listSizeStart+$page['pagecount']-$page['currentPage']+1;
					}else {
						$count = $residue;
					}
				}else{
					$count = $listSizeStart + $listsize;
				}
				for($i=$listSizeStart;$i<$count;$i++){
					$ret['url']['list'][$i] = $url.encrypt_url($baseurl.$page['isText']."&currentPage=".$i);
				}
			}
			
		}else{
			for($i=1;$i<$page['pagecount']+1;$i++)
			{
				$ret['url']['list'][$i] = $url.encrypt_url($baseurl.$page['isText']."&currentPage=".$i);

			}
		}
		*/
	}
	
	if($page['hasprior'])
	{
		if($page['currentPage']>$listsize)
		{
			$ret['url']['prePages']=$url.encrypt_url($baseurl.$page['isText']."&currentPage=".$i."&currentPage=".($listSizeStart-$listsize));
		}
	}
	
	if($page['hasnext'])
	{
		if(($page['pagecount']-$page['currentPage'])>$listsize)
		{
			$ret['url']['nextPages']=$url.encrypt_url($baseurl.$page['isText']."&currentPage=".$i."&currentPage=".($listSizeStart+$listsize));
		}
	}
	
	if($page['currentPage']!=1)
	{
		$ret['url']['firstPage']=$url.encrypt_url($baseurl.$page['isText']."&currentPage=1");
	}
	if($page['currentPage']>1)
	{
		$ret['url']['prePage']=$url.encrypt_url($baseurl.$page['isText']."&currentPage=".($page['currentPage']-1));
	}
	

	if($page['currentPage']<$page['pagecount'])
	{
		$ret['url']['nextPage']=$url.encrypt_url($baseurl.$page['isText']."&currentPage=".($page['currentPage']+1));
	}

	if($page['currentPage']!=$page['pagecount'])
	{
		if($page['pagecount']!='0')
		{
			$ret['url']['lastPage']= $url.encrypt_url($baseurl.$page['isText']."&currentPage=".$page['pagecount']."&residue=".($page['pagecount']+1));
		}
	}
	
	return $ret;
}

function listContentPage($currentPage,$url,$contents,$param,$ptext = '#page#')
{
	$baseurl="action=".$GLOBALS['IN']['action']."&method=".$GLOBALS['IN']['method'];
	if(!empty($param)) $baseurl .= "&$param";
	$ret=array(
		'pageInfo'=>array()
	);
    //文章数组
    $arr = explode($ptext,$contents);
    //数组长度&总页数
    $total = count($arr);
    $ret['pageInfo']['total'] = $total;
    //当前页
    //$nowpage = $_GET['pages']?$_GET['pages']:1;
    $nowpage = $currentPage?$currentPage:1;
    //上页
    $prepage = $nowpage==1?1:$nowpage-1;
	if($currentPage==1)
	{
		$prepage = "";
	}else
	{
		$prepage = $url.encrypt_url($baseurl.$page['isText']."&currentPage=".$prepage);
	}
    //下页
    $nextpage = $nowpage>$total-1?$total:$nowpage+1;
    //最后一页
    $lastpage = $total;
    if($currentPage==$lastpage)
	{
		$nextpage = "";
	}else
	{
		$nextpage = $url.encrypt_url($baseurl.$page['isText']."&currentPage=".$nextpage);
	}
    $ret=array(
		'pageInfo'=>array(
			'currentPage'	=>$nowpage,
			'pageCount'		=>$total,
			'prePage' => $prepage,
			'nextPage' => $nextpage,
			'lastPage' => $lastpage,
			'content' => $arr[$nowpage-1]
		)
	);
	for($i=1;$i<$total+1;$i++){
			$ret['url']['list'][$i] = $url.encrypt_url($baseurl.$page['isText']."&currentPage=".$i);
			//$ret['url']['list'][$i] = $i;
		}
	//print_r($ret);
	return $ret;
}
?>