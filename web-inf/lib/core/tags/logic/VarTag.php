<?php
/**
 * 变量声明标签
 * <pp:var name="username"     value="{$username.data}" /><var name="user_id"     value="{$user_id.data}" />
 */
/**
 * 变量的定义含义
 * [$var]模板预定义变量显示处理 ,显示模板_tpl_vars数组里面的变量 
*[$a.b]翻译成$tpl._tpl_vars['a']['b']
*｛$var｝变量赋值处理，
**如果该引用的变量在_tpl_vars中则不需要进行处理，直接翻译之$tpl._tpl_Vars['var'];
*将{$var.var}这样的标签解析为{$this->_tpl_vars['var']['var']}这样的标签
* [*var]外部变量显示  全局变量的显示  如：[*a]翻译的记过是<?php echo $global['a']?>;
*{*var}外部变量赋值处理
*全局变量的赋值处理  {*a}翻译成$Global['a']
 */
import('core.tags.ParentTag');
class VarTag extends ParentTag
{
	/**
	 * 处理标签，并将替换的内容返回
	 *
	 * @param unknown_type $val
	 */
	public function processTag($val)
	{
		$val=$this->replace_vartag($val);
		$reg="/\<pp\:var\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?value\=['|\"]?(.*?)?['|\"]\s*?\n?\/\>/i";
		if (preg_match_all($reg, $val, $matches))
		{
			foreach($matches[1] as $key=>$var)
			{
				$value="";
				if ($matches[2][$key]!="")
				{
					//print $matches[2][$key];
					if(!strpos($matches[2][$key],'array($'))
					{
						//print $matches[2][$key];
						//$value = $matches[2][$key];
						$value = parent::generateReplaceTextVar($matches[2][$key],$replaceArray);
					}else 
					{
						$value = $matches[2][$key];
						//$value = parent::generateReplaceTextVar($matches[2][$key],$replaceArray);
					}
				}
				$name=$this->generateVarName($matches[1][$key]);
				$val=str_replace($matches[0][$key],"<?php ".$name."=".$value."; ?>",$val);
			}
		}
		//<varlink name="newvar" to="oldvar" />
		$reg='/\<pp:varlink\s*?\n*?name=[\'|"](.*)[\'|"]\s*?\n*?to=[\'|"](.*)[\'|"]\s*?\n*?\/\>/i';
		if (preg_match_all($reg,$val,$matches))
		{
			foreach ($matches[0] as $key=>$var)
			{
				$strAim=$this->generateVarName($matches[1][$key]);
				$strSource=$this->generateVarName($matches[2][$key]);
				$strSource='@'.$strSource;
				$val=str_replace($matches[0][$key],'<?php '.$strAim.'='.$strSource.'; ?>',$val);
			}
		}
		$reg='/\<pp:varEOT\s*?\n*?name=[\'|"](.*)[\'|"]\s*?\n*?>(.*)/i';
		if (preg_match_all($reg,$val,$matches))
		{
			//print_r($matches);
			foreach ($matches[0] as $key=>$var)
			{
				$name = $this->generateVarName($matches[1][$key]);
				$value = "<<<EOT\n".$matches[2][$key];
				$val=str_replace($matches[0][$key],"<?php ".$name."=".$value."\n?>",$val);
			}
			$val=parent::replaceTags("</pp:varEOT>","\nEOT",$val);
		}
		return $val;
		//return $val;
	}
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
 * 处理标签的缩写
 *
 * @param unknown_type $val
 */
	public function processShortTag($val)
	{
		try
		{
			$val=$this->replace_vartag($val);
			$reg="/\<var\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?value\=['|\"]?(.*?)?['|\"]\s*?\n?\/\>/i";	
			if (preg_match_all($reg, $val, $matches))
			{
				foreach($matches[1] as $key=>$var)
				{
					$value="";
					if(!strpos($matches[2][$key],'array($'))
					{
						//print $matches[2][$key];
						//$value = $matches[2][$key];
						$value = parent::generateReplaceTextVar($matches[2][$key],$replaceArray);
					}else 
					{
						$value = $matches[2][$key];
						//$value = parent::generateReplaceTextVar($matches[2][$key],$replaceArray);
					}
					$name=$this->generateVarName($matches[1][$key]);
					$val=str_replace($matches[0][$key],"<?php ".$name."=".$value."; ?>",$val);
				}
			}
			//<varlink name="newvar" to="oldvar" />
			$reg='/\<varlink\s*?\n*?name=[\'|"](.*)[\'|"]\s*?\n*?to=[\'|"](.*)[\'|"]\s*?\n*?\/\>/i';
			if (preg_match_all($reg,$val,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$strAim=$this->generateVarName($matches[1][$key]);
					$strSource=$this->generateVarName($matches[2][$key]);
					$strSource='@'.$strSource;
					$val=str_replace($matches[0][$key],'<?php '.$strAim.'='.$strSource.'; ?>',$val);
				}
			}
			$reg='/\<varEOT\s*?\n*?name=[\'|"](.*)[\'|"]\s*?\n*?>(.*)/i';
			if (preg_match_all($reg,$val,$matches))
			{
				//print_r($matches);
				foreach ($matches[0] as $key=>$var)
				{
					$name = $this->generateVarName($matches[1][$key]);
					$value = "<<<EOT\n".$matches[2][$key];
					$val=str_replace($matches[0][$key],"<?php ".$name."=".$value."\n?>",$val);
				}
				$val=parent::replaceTags("</varEOT>","\nEOT;",$val);
			}
			return $val;
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	 * 解析整个模板,将{$var},[$var],{*var},[*var]这些标签替换为对应的php代码.
	 *
	 * @param unknown_type $content
	 */
	protected function replace_vartag($contents)
	{
		// [$var]模板预定义变量显示处理
		$patt = "/".preg_quote('[')."\\$([\S]+)" . preg_quote(']') . "/siU";
		if (preg_match_all($patt, $contents, $matches))
		{
			foreach($matches[1] as $key=>$var)
			{
				$contents = str_replace($matches[0][$key], $this->parse_tag_format_display($var),  $contents);
			}
		}
		// {$var}模板预定义变量赋值处理
		$patt = "/".preg_quote('{')."\\$(.*)" . preg_quote('}') . "/siU";
		if (preg_match_all($patt, $contents, $matches))
		{
			foreach($matches[1] as $key=>$var)
			{
				if(strpos($matches[0][$key], "this->_tpl_vars"))
				continue;
				$contents = str_replace($matches[0][$key], $this->parse_tag_format_var($var),  $contents);
			}
		}
		// [*var]外部变量显示
		$patt = "/".preg_quote('[')."\\*(.*)" . preg_quote(']') . "/i";
		if (preg_match_all($patt, $contents, $matches))
		{
			foreach($matches[1] as $key=>$var)
			{
				$contents = str_replace($matches[0][$key], $this->parse_tag_format_global_display($var),  $contents);
			}
		}
		// {*var}外部变量赋值处理

		$patt = "/".preg_quote('{')."\\*(.*)" . preg_quote('}') . "/siU";
		if (preg_match_all($patt, $contents, $matches))
		{
			foreach($matches[1] as $key=>$var)
			{
				if(strpos($matches[0][$key], "this->_tpl_vars")) continue;
				$contents = str_replace($matches[0][$key], $this->parse_tag_format_global_var($var),  $contents);
			}
		}
		return $contents;
	}
	/**

	 * 将模板变量标签替换为变量显示echo的php代码

	 */	

	function parse_tag_format_display($string)
	{
		$header = "<?php echo \$this->_tpl_vars";
		if(strpos($string, '.')) {
			$data = explode('.',$string);
			$string = '';
			foreach($data as $key=>$var)
			{

				$reg="/".preg_quote($GLOBALS['currentApp']['varprefix'])."[a-zA-Z0-9\_\$\>\-\[\]\'\{\}\"\+\-\*\/]*".preg_quote($GLOBALS['currentApp']['varprefix'])."/i";
				$var = $this->parse_tag_format_varIN($var);
				if (preg_match_all($reg,$var,$matches))
				{
					$string .= "[".$var."]";
				}
				else
				{
					$string .= "[\"".$var."\"]";
				}
			}
			$string = $header.$string.";?>";
		} else {
			$string = $header."[\"".$string."\"];?>";
		}
		return $string;
	}
	/**

	 * 处理key为变量时候的,多维数组

	 * 比如$var.varIn:FieldName.hello => {$this->_tpl_vars["var"]["{$this->_tpl_vars["varIn"]["FieldName"]}"]}

	 */

	function parse_tag_format_varIN($string)
	{
		$header = "{\$this->_tpl_vars";
		$substr = substr($string,0,1);
		if(strpos($string, ':') && $substr == '$')
		{
			$string = substr($string,1);
			$data = explode(':',$string);
			$string = '';
			foreach($data as $key=>$var)
			{
				$string .= "[\"".$var."\"]";
			}
			$string = $header.$string."}";
		}
		return $string;
	}

	function parse_tag_format_var($string)
	{

		try {

			$newString="";
			$header = "\$this->_tpl_vars";
			//分解成数组
			$patt='/[\-\+\/\*\.]/i';
			$datas=preg_split($patt,$string);
			foreach ($datas as $key=>$var)
			{
				//取数组后面的一个字符
				$temp="";
				if ($key!=0)
				{
					$ipos=strpos($string,$datas[$key -1]);
					$temp=substr($string,$ipos+strlen($datas[$key -1]),1);//取操作符
				}
				if ($key==0) //第一个必须是宏替换的值
				{
					$newString .= $header."[\"".$var."\"]";
				}
				else //需要判断操作符是是函数还是其他运算
				{
					if ($temp=='.')//有可能是下标也有可能是字符链接
					{
						if (substr($var,0,1)==' ')
						{
							$newString.='.'.$var;
						}
						else
						{
							$newString .= "[\"".$var."\"]";
						}
					}
					else//其他运算符
					{
						if (substr($var,0,1)=='$')//需要处理成变量
						{
							$newString.=$temp.'$this->_tpl_vars[\''.substr($var,1).'\']';
						}
						elseif (substr($var,0,1)=='@')//函数处理
						{
							$newString.=$temp.$this->generateFuncText($var);//处理函数调用问题
						}
					}
				}
			}
			return $newString;
		}catch (Exception $e)
		{
			throw $e;
		}
	}
	function generateFuncText($string)
	{
		try
		{
			$funId="";
			$params="";
			$patt='/(@(.*))\((.*)\)/i';
			if (preg_match_all($patt,$string,$mathes))
			{
				foreach ($mathes[0] as $key=>$var)
				{
					$funId=$mathes[2][$key];
					$params=$mathes[3][$key];					
				}
			}
			return "runFunc('".$funId."','$params')";			
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**

	 * 将外部变量标签替换为变量显示的php代码

	 */	
	function parse_tag_format_global_display($string)
	{
		$header = "<?php echo \$GLOBALS";
		if(strpos($string, '.'))
		{
			$data = explode('.',$string);
			$string = '';
			foreach($data as $key=>$var)
			{
				$reg="/".preg_quote($GLOBALS['currentApp']['varprefix'])."[a-zA-Z0-9\_\$\>\-\[\]\'\{\}\"\+\-\*\/]*".preg_quote($GLOBALS['currentApp']['varprefix'])."/i";
				if (preg_match_all($reg,$var,$matches))
				{
					$string .= "[".$var."]";
				}
				else
				{
					$string .= "[\"".$var."\"]";
				}
			}
			$string = $header.$string.";?>";
		} else
		{
			$string = $header."[\"".$string."\"];?>";
		}
		return $string;
	}
	/**
	 * 将外部变量标签替换为变量赋值的php代码
	 * 如：{*var.var} 输出为：$GLOBALS["var"]["var"]
	 * modify 2008-03-26
	 */	
	function parse_tag_format_global_var($string)
	{
		//$header = "{\$GLOBALS";
		$header = "\$GLOBALS";
		if(strpos($string, '.'))
		{
			$data = explode('.',$string);
			$string = '';
			foreach($data as $key=>$var)
			{
				$reg="/".preg_quote($GLOBALS['currentApp']['varprefix'])."[a-zA-Z0-9\_\$\>\-\[\]\'\{\}\"\+\-\*\/]*".preg_quote($GLOBALS['currentApp']['varprefix'])."/i";
				if (preg_match_all($reg,$var,$matches))
				{
					$string .= "[".$var."]";
				}
				else
				{
					$string .= "[\"".$var."\"]";
				}
			}
			/*$string = $header.$string.";?>";*/
			$string = $header.$string;
		} else
		{
			/*$string = $header."[\"".$string."\"];?>";*/
			$string = $header."[\"".$string."\"];";
		}
		//return $string."}";
		return $string;
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
			//处理标签
			$iftag="/\<pp\:var\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?value\=['|\"]\{?(.*?)\}?['|\"]\s*?\n?\/\>/i";
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
			$iftag="/\<var\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?value\=['|\"]\{?(.*?)\}?['|\"]\s*?\n?\/\>/i";
			preg_match_all($iftag,$var,$matches);
			$count=count($matches[0]);
			if ($count>0)
			{
				$rtn= $rtn||true;
			}
			else
			{
				$rtn= $rtn||false;
			}
			$iftag = "/".preg_quote('[')."\\$([\S]+)" . preg_quote(']') . "/siU";
			preg_match_all($iftag,$var,$matches);
			$count=count($matches[0]);
			if ($count>0)
			{
				$rtn= $rtn||true;
			}
			else
			{
				$rtn= $rtn||false;
			}	
			$iftag="/\<var\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?value\=['|\"]\{?(.*?)\}?['|\"]\s*?\n?\/\>/i";	
			preg_match_all($iftag,$var,$matches);
			$count=count($matches[0]);
			if ($count>0)
			{
				$rtn= $rtn||true;
			}
			else
			{
				$rtn =$rtn||false;
			}
			return $rtn;		
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
}
?>