<?php
/**
 * 复杂赋值表达式语法
 * -------------------
 * <op exp="赋值表达式" />
 * 例：
 * <op exp="$varname = '标题。。。' " />
 * <op exp="$varname = $varvalue . '加个后缀'" />
 * <op exp="$datetime = date('Y-m-d').time()" />
 */
import('core.tags.ParentTag');
class OpExprTag extends ParentTag
{
	//根据客户端声明的表达式生成php的表达式
	protected function generateExpr($string)
	{
		try
		{
			$tempdata=$string;
			$patt='/\s*?'.preg_quote($GLOBALS['currentApp']['varprefix']).'([a-zA-Z0-9\_\$\$\{\}\[\]\'\"\+\>\-\*\/])*'.preg_quote($GLOBALS['currentApp']['varprefix']).'/i';
			$replaceArray=array();
			//先将宏替换的处理成一般字符
			if (preg_match_all($patt,$tempdata,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$replacename='##replace##'.$key;
					$tempdata=str_replace($var,$replacename,$tempdata);
					$replaceArray[$replacename]=$var;
				}
			}
			//分解成数组
			$patt='/[\-\+\/\*\.]/i';
			$datas=preg_split($patt,$tempdata);
			//print_r($datas);
			$replaceText="";
			foreach ($datas as $key=>$var)
			{

				//取数组后面的一个字符
				$temp="";
				if ($key!=0)
				{
					$ipos=strpos($tempdata,$datas[$key -1]);
					$temp=substr($tempdata,$ipos+strlen($datas[$key -1]),1);
				}
				//还原成宏替换处理

				if (array_key_exists($var,$replaceArray))
				{
					$var=$replaceArray[str_replace(' ','',$var)];
				}
				//处理.运算符，看是否是字符传运算还是数组下标

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
						$replaceText='\''.$var.'\'';
					}
				}
				else
				{
					if ($temp=='.')
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
						elseif (substr($var,0,2)==' "'||substr($var,0,2)==' \'' )//字符连接
						{
							$replaceText.='.'.$var;
						}
						else //数组下标
						{
							$replaceText.='[\''.$var.'\']';
						}
					}
					else//其他运算符
					{
						if (substr($var,0,1)=='$')//需要处理成变量
						{
							$replaceText.=$temp.'$this->_tpl_vars[\''.substr($var,1).'\']';
						}
						elseif  (preg_match('/\s*?'.preg_quote($GLOBALS['currentApp']['varprefix']).'([a-zA-Z0-9\_\$\$\{\}\+\-\*\/])*'.preg_quote($GLOBALS['currentApp']['varprefix']).'/i',$var)) //处理宏替换
						{
							$replaceText.=$temp.$var;
						}
					}
				}
			}
			return $replaceText;
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
	public  function processTag($val)
	{
		try
		{
			//处理表达式中的变量问题
			$patt='/\<pp:op\s*?\n*?exp=[\'|"](.*)[\'|"]\s*?\n*?\/\>/i';
			if (preg_match_all($patt,$val,$matches))
			{
				$replaceText='';
				foreach ($matches[0] as $key=>$var)
				{
					$reg='/(.*)=(.*)/i';
					if (preg_match_all($reg,$matches[1][$key],$machs))
					{
						
						foreach ($machs[1] as $childKey=>$childVar)
						{
							//$replaceText=parent::processExprVar($machs[1][$childKey]).'='.$this->generateExpr($machs[2][$childKey]);
							$replaceText=parent::processExprVar($machs[1][$childKey]).'='.parent::generateReplaceTextVar($machs[2][$childKey]);
						}
						$val=str_replace($matches[0][$key],'<?php '.$replaceText.'; ?>',$val);
					}

				}
			}
			$patt='/\<pp:op\s*?\n*?expr=[\'|"](.*)[\'|"]\s*?\n*?\/\>/i';
			if (preg_match_all($patt,$val,$matches))
			{
				$replaceText='';
				foreach ($matches[0] as $key=>$var)
				{
					$reg='/(.*)=(.*)/i';
					if (preg_match_all($reg,$matches[1][$key],$machs))
					{
						
						foreach ($machs[1] as $childKey=>$childVar)
						{
							//$replaceText=parent::processExprVar($machs[1][$childKey]).'='.$this->generateExpr($machs[2][$childKey]);
							$replaceText=parent::processExprVar($machs[1][$childKey]).'='.parent::generateReplaceTextVar($machs[2][$childKey]);
						}
						$val=str_replace($matches[0][$key],'<?php '.$replaceText.'; ?>',$val);
					}

				}
			}
			return $val;
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}

	/**
 * 处理标签的缩写
 *
 * @param unknown_type $val
 */
	public  function processShortTag($val)
	{
		try
		{
			//处理表达式中的变量问题
			$patt='/\<op\s*?\n*?exp=[\'|"](.*)[\'|"]\s*?\n*?\/\>/i';
			if (preg_match_all($patt,$val,$matches))
			{
				$replaceText='';
				foreach ($matches[0] as $key=>$var)
				{
					$reg='/(.*)=(.*)/i';
					if (preg_match_all($reg,$matches[1][$key],$machs))
					{
						foreach ($machs[1] as $childKey=>$childVar)
						{
							$replaceText=parent::processExprVar($machs[1][$childKey]).'='.parent::generateReplaceTextVar($machs[2][$childKey]);
						}
						$val=str_replace($matches[0][$key],'<?php '.$replaceText.'; ?>',$val);
					}

				}
			}
			$patt='/\<op\s*?\n*?expr=[\'|"](.*)[\'|"]\s*?\n*?\/\>/i';
			if (preg_match_all($patt,$val,$matches))
			{
				$replaceText='';
				foreach ($matches[0] as $key=>$var)
				{
					$reg='/(.*)=(.*)/i';
					if (preg_match_all($reg,$matches[1][$key],$machs))
					{
						
						foreach ($machs[1] as $childKey=>$childVar)
						{
							//$replaceText=parent::processExprVar($machs[1][$childKey]).'='.$this->generateExpr($machs[2][$childKey]);
							$replaceText=parent::processExprVar($machs[1][$childKey]).'='.parent::generateReplaceTextVar($machs[2][$childKey]);
						}
						$val=str_replace($matches[0][$key],'<?php '.$replaceText.'; ?>',$val);
					}

				}
			}
			return $val;
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	 * 检查文件是否是否完全编译完成
	 *
	 * @param unknown_type $var
	 */
	public function checkExists($var)
	{
		$rtn=false;
		try
		{
			//处理标签
			$iftag='/\<pp:op\s*?\n*?exp=[\'|"](.*)[\'|"]\s*?\n*?\/\>/i';
			preg_match_all($iftag,$var,$matches);
			$count=count($matches[0]);
			if ($count>0)
			{
				$rtn=true;
			}
			else
			{
				$rtn=false;
			}
			$iftag='/\<op\s*?\n*?exp=[\'|"](.*)[\'|"]\s*?\n*?\/\>/i';
			preg_match_all($iftag,$var,$matches);
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