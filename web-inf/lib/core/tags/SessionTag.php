<?php
/**
 * Session的管理标签
 */
import('core.tags.ParentTag');
class SessionTag extends ParentTag
{
	/**
	 * 处理标签，并将替换的内容返回
	 *
	 * @param unknown_type $val
	 */
	public function processTag($val)
	{
		$replaceText;
		$sessionTag = "/\<pp:session\s*?\n?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		//显示session函数
		if(preg_match_all($sessionTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				//print "ss";
				$replaceText = '{@'.$matches[1][$key].'('.$matches[2][$key].')}';
				$val = parent::replaceTags($var, $replaceText, $val);
			}
		}
		return $val;
	}

	/**
 * 处理标签的缩写
 *
 * @param unknown_type $val
 */
	public function processShortTag($val)
	{
		$replaceText;
		$sessionTag = "/\<session\s*?\n?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		//显示session函数
		if(preg_match_all($sessionTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$replaceText = '{@'.$matches[1][$key].'('.$matches[2][$key].')}';
				$val = parent::replaceTags($var, $replaceText, $val);
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
			$memberTag = "/\<pp:session\s*?\n?funcname\=['|\"](.*)\((.*)\)?['|\"]\s*?\n?\/\>/i";
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
			//处理显示函数标签
			$memberTag = "/\<session\s*?\n?funcname\=/i";
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
?>