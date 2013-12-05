<?php
/**
 * 会员管理系统函数标签
 */
import('core.tags.ParentTag');
class MemFuncTag extends ParentTag 
{
	/**
	 * 处理标签，并将替换的内容返回
	 *
	 * @param unknown_type $val
	 */
	public function processTag($val)
	{
		$replaceText;
		$memberTag = "/\<pp:memfunc\s*?\n?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		//显示函数
		if(preg_match_all($memberTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$replaceText = '{@'.$matches[1][$key].'('.$matches[2][$key].')}';
				$val = parent::replaceTags($var, $replaceText, $val);
			}
		}
		$memberTag = "/\<pp:echomemfunc\s*?\n?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		//输出函数
		if(preg_match_all($memberTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				//print $matches[2][$key]."<br>";
				$replaceText = '[@'.$matches[1][$key].'('.$matches[2][$key].')]';
				//print $replaceText;
				$val = parent::replaceTags($var, $replaceText, $val);
			}
		}
		return $val;
	}
/*	
 * 处理标签的缩写
 *
 * @param unknown_type $val
 */
	public function processShortTag($val)
	{
		$replaceText;
		$memberTag = "/\<memfunc\s*?\n?funcname\=['|\"](.*)\((.*)\)?['|\"]\s*?\n?\/\>/i";
		//显示函数
		if(preg_match_all($memberTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$replaceText = '{@'.$matches[1][$key].'('.$matches[2][$key].')}';
				$val = parent::replaceTags($var , $replaceText, $val);
			}
		}
		$memberTag = "/\<echomemfunc\s*?\n?funcname\=['|\"](.*)\((.*)\)?['|\"]\s*?\n?\/\>/i";
		//输出函数
		if(preg_match_all($memberTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$replaceText = '[@'.$matches[1][$key].'('.$matches[2][$key].')]';
				$val = parent::replaceTags($var , $replaceText, $val);
			}
		}
		return $val;
	}
	/**
	 * 是否还需要继续编译
	 *
	 * @param unknown_type $var
	 * @return unknown
	 */
	public function checkExists($var)
	{
		$rtn=false;
		try
		{
			//处理显示函数标签
			$memberTag = "/\<pp:memfunc\s*?\n?funcname\=['|\"](.*)\((.*)\)?['|\"]\s*?\n?\/\>/i";
			preg_match_all($memberTag,$var,$matches);
			$count=count($matches[0]);
			if ($count>0)
			{
				$rtn=true;
			}
			else
			{
				$rtn=false;
			}
			//处理输出函数标签
			$memberTag = "/\<pp:echomemfunc\s*?\n?funcname\=['|\"](.*)\((.*)\)?['|\"]\s*?\n?\/\>/i";
			preg_match_all($memberTag,$var,$matches);
			$count=count($matches[0]);
			if ($count>0)
			{
				return $rtn||true;
			}
			else
			{
				return $rtn||false;
			}
			//处理显示函数标签
			$memberTag = "/\<memfunc\s*?\n?funcname\=/i";
			preg_match_all($memberTag,$var,$matches);
			$count=count($matches[0]);
			if ($count>0)
			{
				return $rtn||true;
			}
			else
			{
				return $rtn||false;
			}
			//处理显示函数标签
			$memberTag = "/\<echomemfunc\s*?\n?funcname\=/i";
			preg_match_all($memberTag,$var,$matches);
			$count=count($matches[0]);
			if ($count>0)
			{
				return $rtn||true;
			}
			else
			{
				return $rtn||false;
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	
}