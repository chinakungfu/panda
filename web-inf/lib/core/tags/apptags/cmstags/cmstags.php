<?php
/**
 * cms系统函数标签
 */
import('core.tags.ParentTag');
class cmstags extends ParentTag 
{
	/**
	 * 生成变量的名称
	 *
	 * @param unknown_type $string
	 */
	protected  function  generateVarName($string)
	{
		try
		{
			$text="";
			if (strpos($string,'.'))//[var.data]解析成$this->_tpl_vars['var']['data']
			{
				$data=explode('.',$string);
				foreach ($data as $key=>$var)
				{
					$reg="/".preg_quote($GLOBALS['currentApp']['varprefix'])."[a-zA-Z0-9\_\$\>\-\[\]\'\{\}\"\+\-\*\/]*".preg_quote($GLOBALS['currentApp']['varprefix'])."/i";
					if (preg_match_all($reg,$var,$matches))//存在宏替换
					{
						$text.="[".$var."]";
					}
					else //没有宏替换
					{
						$text.="[\"".$var."\"]";
					}
				}
			}
			else //[var]解析成$this->_tpl_vars['var'];
			{
				$reg="/".preg_quote($GLOBALS['currentApp']['varprefix'])."[a-zA-Z0-9\_\$\>\-\[\]\'\{\}\"\+\-\*\/]*".preg_quote($GLOBALS['currentApp']['varprefix'])."/i";
				if (preg_match_all($reg,$string,$matches))//存在宏替换
				{
					$text="[".$string."]";
				}
				else //没有宏替换
				{
					$text="[\"".$string."\"]";
				}
			}
			return "\$this->_tpl_vars".$text;

		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 处理标签，并将替换的内容返回
	 *
	 * @param unknown_type $val
	 */
	public function processTag($val)
	{
		$replaceText;
		$appFuncTag = "/\<pp:appfunc\s*?\n?app\=[\'|\"](.*)[\'|\"]\s*?\n*?file\=[\'|\"](.*)[\'|\"]\s*?\n*?return\=[\'|\"](.*)[\'|\"]\s*?\n*?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		//显示函数
		if(preg_match_all($appFuncTag,$val,$matches))
		{
		//print_r($matches);
			foreach($matches[0] as $key=>$var)
			{
				$startPhp = "<?php \n";
				$repalceText = "include_once('".$matches[2][$key].".php');\n";
				$repalceText .= '$appName ="'.$matches[1][$key].'";'."\n";
				$params = parent::generateReplaceTextVar($matches[5][$key],$replaceArray);
				$repalceText.= $this->generateVarName($matches[3][$key]).'='.$matches[4][$key]."(".$params.");\n";
				$endPhp = " ?>";
				$val=parent::replaceTags($var,$startPhp.$repalceText.$endPhp,$val);
			}
		}
		$appFuncTag = "/\<pp:echoappfunc\s*?\n?app\=[\'|\"](.*)[\'|\"]\s*?\n*?file\=[\'|\"](.*)[\'|\"]\s*?\n*?return\=[\'|\"](.*)[\'|\"]\s*?\n*?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		//输出函数
		if(preg_match_all($appFuncTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$startPhp = "<?php \n";
				$repalceText = "include_once('./appfunc/".$matches[2][$key].".php');\n";
				$repalceText .= '$appName ="'.$matches[1][$key].'";'."\n";
				$params = parent::generateReplaceTextVar($matches[5][$key],$replaceArray);
				$repalceText.= "echo ".$this->generateVarName($matches[3][$key]).'='.$matches[4][$key]."(".$params.");\n";
				$endPhp = " ?>";
				$val=parent::replaceTags($var,$startPhp.$repalceText.$endPhp,$val);
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
		$appFuncTag = "/\<appfunc\s*?\n?app\=[\'|\"](.*)[\'|\"]\s*?\n*?file\=[\'|\"](.*)[\'|\"]\s*?\n*?return\=[\'|\"](.*)[\'|\"]\s*?\n*?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		//显示函数
		if(preg_match_all($appFuncTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$startPhp = "<?php \n";
				$repalceText = "include_once('".$matches[2][$key]."');\n";
				$repalceText .= '$appName ="'.$matches[1][$key].'";'."\n";
				$params = parent::generateReplaceTextVar($matches[5][$key],$replaceArray);
				$repalceText.= $this->generateVarName($matches[3][$key]).'='.$matches[4][$key]."(".$params.");\n";
				$endPhp = " ?>";
				$val=parent::replaceTags($var,$startPhp.$repalceText.$endPhp,$val);
			}
		}
		$appFuncTag = "/\<echoappfunc\s*?\n?app\=[\'|\"](.*)[\'|\"]\s*?\n*?file\=[\'|\"](.*)[\'|\"]\s*?\n*?return\=[\'|\"](.*)[\'|\"]\s*?\n*?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
		//输出函数
		if(preg_match_all($appFuncTag,$val,$matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$startPhp = "<?php \n";
				$repalceText = "include_once('".$matches[2][$key]."');\n";
				$repalceText .= '$appName ="'.$matches[1][$key].'";'."\n";
				$params = parent::generateReplaceTextVar($matches[5][$key],$replaceArray);
				$repalceText.= "echo ".$this->generateVarName($matches[3][$key]).'='.$matches[4][$key]."(".$params.");\n";
				$endPhp = " ?>";
				$val=parent::replaceTags($var,$startPhp.$repalceText.$endPhp,$val);
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
			$appFuncTag = "/\<pp:appfunc\s*?\n?app\=[\'|\"](.*)[\'|\"]\s*?\n*?file\=[\'|\"](.*)[\'|\"]\s*?\n*?return\=[\'|\"](.*)[\'|\"]\s*?\n*?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
			preg_match_all($appFuncTag,$var,$matches);
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
			$appFuncTag = "/\<pp:echoappfunc\s*?\n?app\=[\'|\"](.*)[\'|\"]\s*?\n*?file\=[\'|\"](.*)[\'|\"]\s*?\n*?return\=[\'|\"](.*)[\'|\"]\s*?\n*?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
			preg_match_all($appFuncTag,$var,$matches);
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
			$appFuncTag = "/\<appfunc\s*?\n?app\=[\'|\"](.*)[\'|\"]\s*?\n*?file\=[\'|\"](.*)[\'|\"]\s*?\n*?return\=[\'|\"](.*)[\'|\"]\s*?\n*?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
			preg_match_all($appFuncTag,$var,$matches);
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
			$appFuncTag = "/\<echoappfunc\s*?\n?app\=[\'|\"](.*)[\'|\"]\s*?\n*?file\=[\'|\"](.*)[\'|\"]\s*?\n*?return\=[\'|\"](.*)[\'|\"]\s*?\n*?funcname\=['|\"](.*)\((.*)\)['|\"]\s*?\n?\/\>/i";
			preg_match_all($appFuncTag,$var,$matches);
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