<?php
/**
 * 模板的编译类
 *
 */
import('core.tpl.TplTemplate');
import('core.util.VarProcess');
import('core.tags.VarTag');

class TplCompile extends TplTemplate
{
	/**
	 * 根据模板的名称读取模板文件的内容
	 *
	 * @param unknown_type $file_name
	 * @return unknown
	 */
	public function readTemplate($file_name)
	{
		if(empty($this->source))
		{

			if($this->templateExists($file_name))
			{
				$fp = fopen($file_name, 'r');
				$contents = fread($fp, filesize($file_name));
				fclose($fp);
				return $contents;
			}
			else
			{
				$dir = pathinfo($file_name);
				if($this->autoRepair)
				{
					if(@opendir($dir["dirname"]))
					{
						die('<b>TplTemplate error:</b>template file does not exits: <b>'.$file_name .'</b>');
					}
					else
					{
						if($this->makeDir($dir["dirname"]))
						{
							die('<b>kTemplate error:</b>template_dir does not exits, kTemplate engine  repair the template_dir: <b>'.$dir["dirname"] . '</b> successfully, please refresh your page');
						}
						else
						{
							die('<b>kTemplate error:</b>template_dir does not exits, but kTemplate engine fail to  repair the template_dir: <b>'.$dir["dirname"] .'</b>,please connect to your administrator to solve the problem');
						}
					}
				}
				else
				{
					die('<b>kTemplate error:</b> Unable to read template file: <b>' . $file_name .'</b>');
				}
			}
		}
		else
		{
			$source = &$this->source;
			return $this->$source($file_name);
		}
	}
	/**
 * 编译模板文件
 *
 * @param unknown_type $file_name
 * @param unknown_type $compile_name
 */
	public function compile($file_name)
	{
		try
		{
			//判断过滤器是否存在
			if ($GLOBALS['currentApp']['tpl_compile_filter']!='')
			{
				//需要加载过滤器
				if (file_exists($GLOBALS['currentApp']['tpl_compile_filter']))
				{
					include_once($GLOBALS['currentApp']['tpl_compile_filter']);
				}
				else
				{
					$GLOBALS['currentApp']['tpl_compile_filter']='';
				}
			}
			$source_fileName="";
			
			/**AT edit at 2007.08.22：去掉编译时对apppath常量的引用
			if ((apppath!=null)&&(apppath!=""))
			{
				$source_fileName=apppath.$file_name;
			}
			else
			{
				$source_fileName=$file_name;
			}
			**/			
			$source_fileName = $file_name;
			/****************edit end******************/
			
			$compileFileName="";
			if (!$this->templateExists($source_fileName))
			{
				throw new Exception('template file'.$file_name.' not exists exception',222);
			}
			else //模板文件存在
			{
				$compileFileName=$this->generateCompileFileName($source_fileName);

			}
			//读取模板内容
			$content = $this->readTemplate($source_fileName);
			//处理过滤起问题
			if ($GLOBALS['currentApp']['tpl_compile_filter']!='')
			{
				if (function_exists('begin_filter'))
				{
					begin_filter();//加载编译过滤起的begin
				}
			}
			//处理函数
			$content=checkFuncExists($content);
			//对模型中使用的变量{$var}进行预处理
			//$content =addPreFix($content,$GLOBALS['currentApp']['varprefix']);
			$contentArray = $this->replaceBrackets($content);
			$content = $contentArray["string"];
			$replaceArray = $contentArray["replaceArray"];
			//echo $content;
			while ($this->_check_compile_file($content))
			{
				//开始编译，替换模板中的标签
				$content = $this->_compile_file($content);
				if (is_array($content))
				{
					$content=$content['content'];
				}
			}
			$content = $this->backBrackets($content,$replaceArray);
			$content = $this->replace_vartag($content);
			//处理宏替换的问题
			//$content=processMacro($content);
			//将参数预处理内容$varPrefix替换成空
			//$content=replacePreFix($content,$GLOBALS['currentApp']['varprefix']);
			//处理过滤器的
			
			if ($GLOBALS['currentApp']['tpl_compile_filter']!='')
			{
				if (function_exists('end_filter'))
				{
					end_filter();//加载编译过滤起的begin
				}
			}
			//将编译的内容写入到编译文件中
			$this->writeContentToFile($content,$compileFileName);
			echo "模板文件　".$file_name." ------------------　编译成功！"."<br>";//add zxq 20110730

		}
		catch (Exception $e)
		{
			die($e->getMessage());
		}

	}

	/**
	 * 替换模板中的标签
	 *
	 * @param unknown_type $content
	 */
	protected function _compile_file($content)
	{
		try
		{
			$content=$this->_compile_file_html($content);
			$content=$this->_compile_file_logic($content);
			return $content;
		}
		catch (Exception $e)
		{
			throw $e;
		}


	}
	/**
 * 编译html标签
 *
 * @param unknown_type $content
 */
	protected  function _compile_file_html($content)
	{
		try
		{
			if (is_array($this->htmlTags))
			{
				foreach ($this->htmlTags as $key=>$var)
				{
					require_once($this->htmlTags[$key]['filename']);
					$class=new $this->htmlTags[$key]['classname'];
					$content=$class->process($content);
					unset($class);//释放变量
				}
			}
			return $content;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 编译逻辑标签
	 *
	 * @param unknown_type $content
	 */
	protected   function _compile_file_logic($content)
	{
		try
		{
			if (is_array($this->logicTags))
			{
				foreach ($this->logicTags as $key=>$var)
				{
        			require_once($this->logicTags[$key]['filename']);
					$class=new $this->logicTags[$key]['classname'];
					$content=$class->process($content,$replaceArray);
					unset($class);//释放变量
				}
			}
			return $content;
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	 * 检测标签是否编译完成
	 * 编译逻辑标签
	 *
	 * @param unknown_type $content
	 */
	protected   function _check_compile_file($content)
	{
		try
		{
			$bool =false;
			if (is_array($this->logicTags))
			{
				foreach ($this->logicTags as $key=>$var)
				{
					require_once($this->logicTags[$key]['filename']);
					$class=new $this->logicTags[$key]['classname'];
					$bool=$class->checkExists($content);
					unset($class);//释放变量
					if ($bool)
					{
						return $bool;
					}
					unset($class);//释放变量
				}
			}
			return $bool;
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	 * 将编译的内容写入到文件
	 *
	 * @param unknown_type $content
	 */
	protected function writeContentToFile($content,$fileName)
	{
		try
		{
			if($fp =fopen($fileName, 'w'))
			{
				fwrite($fp, $content);
				fclose($fp);				//touch($this->$fileName, filemtime($file_name));
				return true;
			}


		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	 * 宏替换花括号如：{$aaa} replace __replace__0
	 * {$aaa.bbb} replace __replace__1
	 * */
	protected function replaceBrackets($string)
	{
		try {
			$patt='/\{\$(.*)\}/siU';
			$replaceArray=array();
			//先将宏替换的处理成一般字符
			
			if (preg_match_all($patt,$string,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					if(strlen($key)<2)
					{
						$key = "0".$key;
					}
					$replacename='__replace__'.$key;
					$string=str_replace($var,$replacename,$string);
					$replaceArray[$replacename]=$var;
				}
			}
			$returnString["string"] = $string;
			$returnString["replaceArray"] = $replaceArray;
			return 	$returnString;			
		}catch (Exception $e){
			throw $e;
		}
	}	
	/**
	 * 还原花括号如：__replace__0 replace {$aaa}  
	 *  __replace__1 replace {$aaa.bbb} 
	 * */
	protected function backBrackets($string,$replaceArray)
	{
		try {
			//$patt='/\{\$(.*)\}/siU';
			$patt = '/\_\_replace\_\_([0-9])*/i';
			//先将宏替换的处理成一般字符
			
			if (preg_match_all($patt,$string,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					if (array_key_exists($var,$replaceArray))//存在宏替换
					{
						$string=str_replace($var,$replaceArray[$var],$string);
					}
				}
			}
			return 	$string;			
		}catch (Exception $e){
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
		// {$var}模板预定义变量赋值处理
		$patt = "/".preg_quote('{')."\\$(.*)" . preg_quote('}') . "/siU";
		if (preg_match_all($patt, $contents, $matches))
		{
			foreach($matches[1] as $key=>$var)
			{
				if(strpos($matches[0][$key], "this->_tpl_vars"))
				continue;
				$contents = str_replace($matches[0][$key], "{".$this->parse_tag_format_var($var)."}",  $contents);
			}
		}
		return $contents;
	}
	protected function parse_tag_format_var($string)
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
}
?>