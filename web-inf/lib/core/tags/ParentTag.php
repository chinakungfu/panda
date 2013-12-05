<?php
/**
 * 所有标签的父类
 *
 */
abstract class ParentTag
{
	var $regex="";//匹配标签的正则
	var $content=null;//模板引擎内容
	var $includecontent=null;//需要引入的php文件内容
	var $jscontent=null;
	/**
	 * 处理外部的参数到类的变脸变量中
	 *
	 * @param unknown_type $contentarray
	 * @return ParentTag
	 */
	public function setContentValue($contentarray)
	{
		if (is_array($contentarray))
		{
			if (array_key_exists('content',$contentarray))
			{
				$this->content=$contentarray['content'];
			}
			else
			{
				$this->content="";
			}
			if (array_key_exists('include',$contentarray))
			{
				$this->includecontent=$contentarray['include'];
			}
			else
			{
				$this->includecontent="";
			}
			if (array_key_exists('jscontent',$contentarray))
			{
				$this->jscontent=$contentarray['jscontent'];
			}
			else
			{
				$this->jscontent="";
			}

		}
		else
		{
			$this->jscontent="";
			$this->includecontent="";
			$this->content=$contentarray;
		}
	}


	/**
	 * 处理标签，全称和缩写
	 *
	 * @param unknown_type $content
	 * @return unknown
	 */

	public function process($contentarray)
	{
		$this->setContentValue($contentarray);
		$contentvalue=$this->processTag($this->content);
		if (is_array($contentvalue))
		{
			if (array_key_exists('content',$contentvalue))
			{
				$this->content=$contentvalue['content'];
			}
			if (array_key_exists('include',$contentvalue))
			{
				$this->includecontent .=$contentvalue['include'];
			}
			if (array_key_exists('jscontent',$contentvalue))
			{
				$this->jscontent.=$contentvalue['jscontent'];
			}
		}
		else//如果返回的结果不式数组，说明只返回了模板文件的内容
		{
			$this->content=$contentvalue;
		}
		unset($contentvalue);
		//处理标签的缩写
		$contentvalue=$this->processShortTag($this->content);
		if (is_array($contentvalue))
		{
			if (array_key_exists('content',$contentvalue))
			{
				$this->content=$contentvalue['content'];
			}
			if (array_key_exists('include',$contentvalue))
			{
				$this->includecontent .=$contentvalue['include'];
			}
			if (array_key_exists('jscontent',$contentvalue))
			{
				$this->jscontent.=$contentvalue['jscontent'];
			}
		}
		else//如果返回的结果不式数组，说明只返回了模板文件的内容
		{
			$this->content=$contentvalue;
		}
		return array('content'=>$this->content,'jscontent'=>$this->jscontent,
		'include'=>$this->includecontent);
	}
	/**
	 * 处理标签，并将替换的内容返回
	 *
	 * @param unknown_type $val
	 */
	public abstract  function processTag($val);

	/**
 * 处理标签的缩写
 *
 * @param unknown_type $val
 */
	public abstract  function processShortTag($val);
	/**
	 * 检查文件是否是否完全编译完成
	 *
	 * @param unknown_type $var
	 */
	public abstract function checkExists($var);


	/**
	 * 替换原来的标签
	 *
	 * @param unknown_type $tags
	 * @param unknown_type $aims
	 */
	public function replaceTags($tags,$aims,$content)
	{
		return str_ireplace($tags,$aims,$content);
	}
	/**
	 * 取标签的属性
	 * 其中“和空格必须是处理过的，返回String类型
	 *
	 * @param unknown_type $property
	 */
	public function getPropertyValue($property)
	{
		$regex="/(\w+)\=/i";
		return preg_replace($regex,"",$property);
	}
	/**
	 * 处理表达式的变量问题
	 *
	 * @param unknown_type $str
	 */
	public function processExprVar($str)
	{
		try
		{
			$patt='/\$([a-zA-Z0-9_\.\$\{\}\-\+\*\/\>\[\]\'\"])*/i';
			if (preg_match_all($patt,$str,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$str=$this->replaceTags($var,$this->processVars($var),$str);
				}
			}
			return $str;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 处理变量到模板数组[var.data]=>$this->tpl_vars['var']['data'] 
	 *
	 * @param unknown_type $str
	 */
	public function processVars($str)
	{
		try
		{
			$text="";
			$str=substr($str,1);

			if (strpos($str,'.'))
			{
				$datas=explode('.',$str);
				foreach ($datas as $key=>$var)
				{
					$reg="/".preg_quote($GLOBALS['currentApp']['varprefix'])."[a-zA-Z0-9\_\$\>\-\[\]\'\{\}\"\+\-\*\/]*".preg_quote($GLOBALS['currentApp']['varprefix'])."/i";
					//存在宏替换内容需要进行宏替换
					if (preg_match_all($reg,$var,$matches))
					{
						$text.="[".$var."]";
					}
					else //不需要进行宏替换
					{
						$text.="[\"".$var."\"]";
					}
				}
			}
			else
			{
				$reg="/".preg_quote($GLOBALS['currentApp']['varprefix'])."[a-zA-Z0-9\_\$\>\-\[\]\'\{\}\"\+\-\*\/]*".preg_quote($GLOBALS['currentApp']['varprefix'])."/i";
				//存在宏替换内容需要进行宏替换
				if (preg_match_all($reg,$str,$matches))
				{
					$text.="[".$str."]";
				}
				else //不需要进行宏替换
				{
					$text.="[\"".$str."\"]";
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
	 * 处理表达式，如if表达式，和case表达式
	 *
	 * @param unknown_type $string
	 */
	public function generateVarExpr($string)
	{
		try
		{
			$patt='/\s*?'.preg_quote($GLOBALS['currentApp']['varprefix']).'([a-zA-Z0-9\_\$\$\{\}\[\]\'\"\+\>\-\*\/])*'.preg_quote($GLOBALS['currentApp']['varprefix']).'/i';
			$replaceArray=array();
			//先将宏替换的处理成一般字符
			if (preg_match_all($patt,$string,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$replacename='##replace##'.$key;
					$string=str_replace($var,$replacename,$string);
					$replaceArray[$replacename]=$var;
				}
			}
			$patt='/[\-\+\/\*\.\>\<\=!]/i';//分割表达式
			$datas=preg_split($patt,$string);
			$replaceText="";
			foreach ($datas as $key=>$var)
			{
				//取数组后面的一个字符
				$temp="";
				if ($key!=0)
				{
					$ipos=strpos($string,$datas[$key -1]);
					$temp=substr($string,$ipos+strlen($datas[$key -1]),1);
				}
				//将宏替换的内容返回原来的表达式
				if (array_key_exists($var,$replaceArray))
				{
					$var=$replaceArray[str_replace(' ','',$var)];
				}
				if ($key==0) //第一个变量，只需要考虑
				{
					if (substr($var,0,1)=='$')//需要处理成变量
					{
						$replaceText='$this->_tpl_vars[\''.substr($var,1).'\']';
					}
					else if (strpos($var,'_$$')) //处理宏替换
					{
						$replaceText='$this->_tpl_vars['.$var.']';
					}
					else //字符传处理
					{
						$replaceText=$var;
					}
				}
				else //第二个及以后的变量的处理
				{
					if ($temp=='.')//有可能是数组下标也有可能是字符传链接
					{
						if (substr($var,0,1)=='$')//需要处理成变量
						{
							$replaceText.='.$this->_tpl_vars[\''.substr($var,1).'\']';
						}
						elseif  (preg_match('/\s*?'.preg_quote($GLOBALS['currentApp']['varprefix']).'([a-zA-Z0-9\_\$\$\{\}\+\-\*\/])*'.preg_quote($GLOBALS['currentApp']['varprefix']).'/i',$var)) //处理宏替换
						{
							if (substr($var,0,1)==' ')
							{
								$replaceText.='.'.$var;
							}
							else
							{
								$replaceText.='['.$var.']';
							}
						}					
					}
					else 
					{
						
					}

				}

			}

		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	
	/**
	 * 分解参数到数组，将参数名设为键名，参数值设为键值
	 * Add by AT 2007.08.22
	 * @param unknown_type $string
	 */
	
	function getParamsList($string) 
	{
		$string = str_replace("'","\'",$string);
		//print $string;
		$patt='/'.preg_quote($GLOBALS['currentApp']['varprefix']).'([a-zA-Z0-9\_\$\$\{\}\[\]\'\"\+\>\-\*\/])*'.preg_quote($GLOBALS['currentApp']['varprefix']).'/i';
		$replaceArray=array();
		//先将宏替换的处理成一般字符,以免造成下面分解参数数组时出错
		if (preg_match_all($patt,$string,$matches))
		{
			foreach ($matches[0] as $key=>$var)
			{
				if($key<10)
				{
					$key="0".$key;
				}
				//print $var."<br>";
				$replacename='##replace##'.$key;
				$string=str_replace($var,$replacename,$string);
				//print $string."<br>";
				$replaceArray[$replacename]=$var;
			}
		}
		$array=array();
		$reg="/(\w+)=[\"](.*?)[\"]\s{0,}\n{0,}/i";
		if (preg_match_all($reg,$string,$mathes))
		{
			foreach ($mathes[0] as $childKey=>$childVar)
			{
				$array[$mathes[1][$childKey]]=$mathes[2][$childKey];
			}
		}

		//将宏替换还原
		//print count($array)."<br>";
		//print count($replaceArray)."<br>";
		foreach ($replaceArray as $key=>$var)
		{
			foreach ($array as $key1=>&$var1)
			{
				//print $key;
				//print $var."<br>";
				$var1 = str_replace($key,$var,$var1);
				//print $var1."<br>";
			}
		}
		return $array;
	}
	/**
	 * 处理各参数标签
	 * */
	function format_var($string)
	{

		$rtn="";
		if (strpos($string,'.'))
		{
			$datas=explode('.',$string);
			foreach ($datas as $childKey=>$childvar)
			{
				if ($rtn=='')
				{
						$rtn='$this->_tpl_vars["'.$childvar.'"]';
				}
				else
				{
						$rtn.='["'.$childvar.'"]';
				}
			}
			return $rtn;
		}
		else
		{
			return '$this->_tpl_vars["'.$string.'"]';
		}
	}
	//生成替换的字符串
	function generateReplaceTextVar($string)
	{
		try {
			$patt='/\$([{a-zA-Z0-9_}\.]+)/i';
			if (preg_match_all($patt,$string,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$replaceText=$this->format_var($matches[1][$key]);
					$string=str_replace($var,$replaceText,$string);
				}
			}
			$funcPatt = '/\@(.*)\((.*)\)/i';
			if (preg_match_all($funcPatt,$string,$matches))
			{
				$arr_parms = "array(";//把标签中函带的参数($params)转换成数组的形式，返回到页面中
				$arr_parms .=$matches[2][0];
				$arr_parms .=")";
				$exprString="runFunc('".$matches[1][0]."',$arr_parms)";
				$string = str_replace($matches[0][0],$exprString,$string);
			}
			return $string;
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
}
?>