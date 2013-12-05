<?php
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
/*
*
*分页函数
*/
function listPage($page,$url,$listsize,$param ='')
{
try {
	    
		$url = $_SERVER['PHP_SELF'];
		$params = geturl($_REQUEST['LCMSPID']);
		$cou = 0;
		foreach ($params as $key => $val)
		{
			if($cou == '0')
			{
				$strPar .= $key."=".$val; 
			}else 
			{
				$strPar .= "&".$key."=".$val;
			}
			$cou++;
		}
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
		$listSizeStart = $GLOBALS['IN']['listSizeStart'];
		if($listSizeStart=='')
		{
			$listSizeStart = 1;
		}
		if($page['currentPage']<=$page['pagecount'])
		{
			if($listsize)
			{
				if(($page['currentPage']-1)%$listsize==0)//判断是不是在当前几页
				{
					$listSizeStart = $page['currentPage'];
				}
			}
			//$url = $url.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param;
			//$url = $url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param);
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
							$n = "<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param."&currentPage=$i")."'>".$i."&nbsp;&nbsp;&nbsp;&nbsp;</a>";
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
							$n = "<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param."&currentPage=$i")."'>".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
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
						$n = "<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param."&currentPage=$i")."'>".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
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
				$prePageStr .= "<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param."&currentPage=".($listSizeStart-$listsize))."'>前 ".$listsize."页</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
		if($page['hasnext'])
		{
			if(($page['pagecount']-$page['currentPage'])>$listsize)
			{
				$nextPageStr .= "<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param."&currentPage=".($listSizeStart+$listsize))."'>后 ".$listsize."页</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
		$pageStr .='共:'.$page['rowcount'].'条记录&nbsp;&nbsp;&nbsp;&nbsp;';
		$pageStr .='页数:'.$page['currentPage'].'/'.$page['pagecount'].'&nbsp;&nbsp;&nbsp;&nbsp;';
		if($page['currentPage']!=1)
		{
			$pageStr .="<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param."&currentPage=1")."'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($page['currentPage']>1)
		{
			$pageStr .= "<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param."&currentPage=".($page['currentPage']-1))."'> 前一页</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$pageStr .= $prePageStr;
		$pageStr .= $str;
		$pageStr .= $nextPageStr;
		if($page['currentPage']<$page['pagecount'])
		{
			$pageStr .="<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$listSizeStart ."&".$param."&currentPage=".($page['currentPage']+1))."'>下一页 </a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($listsize)
		{
			$s = $page['pagecount']/$listsize;
			$s = floor($s);
			$s = $s*$listsize+1;
		}	
		//$url = $url.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$s."&".$param;
		if($page['currentPage']!=$page['pagecount'])
		{
			$pageStr .= "<a href='".$url.encrypt_url($strPar.$page['isText']."&keywords=".$GLOBALS['IN']['keywords']."&Field=".$GLOBALS['IN']['Field']."&listSizeStart=".$s ."&".$param."&currentPage=".$page['pagecount']."&residue=".($page['pagecount']+1))."'>末页</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$pageStr .= '';
		echo $pageStr;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>