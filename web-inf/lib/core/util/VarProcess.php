<?php
/**
 * 对系统的变量进行预处理
 *
 * @param unknown_type $content
 * @param unknown_type $prefix
 * checkFuncExists modify 2008-03-31
 * $patt='/\@([a-zA-Z0-9\_\>]) changed to
 * $patt='/\funcname\=/i'
 */
function addPreFix($contents,$prefix=null)
{

	//处理变量{$var.data} 替换成_$${$var.data}_$$;
	$patt='/\{\$(.*)\}/siU';
	if (preg_match_all($patt, $contents, $matches))
	{
		foreach($matches[1] as $key=>$var)
		{
			//$reg='/\_\$\$\{\$(.*)\}\_\$\$/siU';
			$reg='/'.preg_quote($prefix).'\{\$(.*)\}'.preg_quote($prefix).'/i';
			if (!preg_match_all($reg,$matches[0][$key],$maths))
			{
				$contents = str_replace($matches[0][$key],$prefix.$matches[0][$key].$prefix, $contents);
			}
		}
	}
	return $contents;

}
/**
 * 讲预处理的变量去掉
 *
 * @param unknown_type $content
 * @param unknown_type $prefix
 */
function replacePreFix($contents,$prefix=null)
{
	$patt='/'.preg_quote($prefix).'/siU';
	if (preg_match_all($patt, $contents, $matches))
	{
		foreach($matches[0] as $key=>$var)
		{
			$contents = str_replace($matches[0][$key],'',  $contents);
		}
	}
	return $contents;

}
/**
 * 处理宏替换函数
 *
 * @param unknown_type $contents
 */
function processMacro($contents)
{
	try
	{
		$patt='/\macro_replace\(.*?\)\;/siU';
		if (preg_match_all($patt, $contents, $matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$reg='/\,[\'|"](.*?)[\'|"]/siU';
				if (preg_match_all($reg,$matches[0][$key],$maths))
				{
					foreach ($maths[0] as $childKey=>$childVar)
					{
						$contents=str_replace($maths[0][$childKey],','."\"".$maths[1][$childKey]."\"",$contents);
					}
				}

			}

		}
		return $contents;
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 处理函数调用的文件引用
 *
 * @param unknown_type $content
 */
function checkFuncExists($content)
{
	try
	{
		$patt='/\@([a-zA-Z0-9\_\>])*/i';
		$funcTag = "/\s*?\n?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		if (preg_match_all($patt,$content,$matches))//有函数调用，引入runfunc文件
		{
			if (!strpos($content,"import('core.util.RunFunc');"))
			{
				$content ="<?php import('core.util.RunFunc'); ?>".$content;
			}
		}elseif (preg_match_all($funcTag,$content,$matches))
		{
			if (!strpos($content,"import('core.util.RunFunc');"))
			{
				$content ="<?php import('core.util.RunFunc'); ?>".$content;
			}
		}
		return $content;
	}
	catch (Exception $e)
	{
		throw $e;
	}

}
function checkSessionExists($content)
{
	try {
		$reg = '/\session\s*?\n?/i';
		if (preg_match_all($reg,$content,$matches))//有函数调用，引入runfunc文件
		{
			if (!strpos($content,"session_start();"))
			{
				$content ="<?php session_start(); ?>".$content;
			}
		}
		return $content;
	}catch (Exception $e){
		throw $e;
	}
}
?>