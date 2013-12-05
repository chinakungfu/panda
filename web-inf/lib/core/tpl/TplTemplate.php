<?php
import('core.lang.Object');
class TplTemplate extends Object
{
	var $template_dir    =  'templates';
	var $compile_dir     =  'templates_c';
	var $compile_check   =  true;
	var $force_compile   =  false;
	var $registerParseFunArray = array();
	var $regPreFilterArray = array();
	var $_tpl_vars = array();
	var $forceCompile = false;
	var $autoRepair = false;
	var $source = NULL;
	var $require_cache=false;
	var $brower_cache=false;
	var $cache_dir="cache";
	var $compilefile_prefix="tpl_";
	var $cache_timeout="3600";
	var $htmlTags=null;//html标签列表
	var $logicTags=null;//逻辑标签
	var $request;//请求参数,所有请求的参数全部放置在数组中
	var $staticLanguage=false;//是否静态加入语言
	var $_language=array();//语言列表
	public  function TplTemplate($iscompile=false)
	{
		if (isset($GLOBALS['currentApp']['tpl_source_path'])) $this->template_dir = $GLOBALS['currentApp']['tpl_source_path'];
		if (isset($GLOBALS['currentApp']['tpl_complie_path'])) $this->compile_dir = $GLOBALS['currentApp']['tpl_complie_path'];
		if (isset($GLOBALS['currentApp']['tpl_cache_path'])) $this->cache_dir = $GLOBALS['currentApp']['tpl_cache_path'];
		if (isset($GLOBALS['currentApp']['tpl_request_cache'])) $this->require_cache = $GLOBALS['currentApp']['tpl_request_cache'];
		if (isset($GLOBALS['currentApp']['tpl_compilefile_prefix'])) $this->compilefile_prefix = $GLOBALS['currentApp']['tpl_compilefile_prefix'];
		if (isset($GLOBALS['currentApp']['cache_timeout'])) $this->cache_timeout=$GLOBALS['currentApp']['cache_timeout'];
		if (isset($GLOBALS['currentApp']['cache_path'])) $this->cache_dir=$GLOBALS['currentApp']['cache_path'];
		if (isset($GLOBALS['currentApp']['tpl_language']))//加载语言
		{
			
		}
		//if (isset($GLOBALS['IN'])) $this->assign($GLOBALS['IN']);
	}
	/**
	 * 设置html标签类
	 *
	 * @param unknown_type $htmlTags
	 */
	public function setHtmlTags($htmlTags)
	{
		$this->htmlTags=$htmlTags;
	}
	/**
	 * 逻辑标签的设置
	 *
	 * @param unknown_type $logicTags
	 */
	public function setLogicTags($logicTags)
	{
		$this->logicTags=$logicTags;
	}
	//设置数组下标的值
	public function setValue($key,$value)
	{
		$this->_tpl_vars[$key]=$value;		
	}
	/**
	 * 合并数组
	 *
	 * @param unknown_type $tpl_var
	 */
	function assignParams($tpl_var)
	{
	}
	/**
	 * 给模板内使用的变量进行赋值
	 *
	 * @param unknown_type $tpl_var
	 * @param unknown_type $value
	 */
	function assign($tpl_var, $value = null)
	{
		if (is_array($tpl_var))
		{
			foreach ($tpl_var as $key => $val) {
				if ($key != '') {
					$this->_tpl_vars[$key] = $val;
				}
			}
		} else {

			if ($tpl_var != "")
			$this->_tpl_vars[$tpl_var] = $value;
			//print_r($tpl_var);
			//print_r($value);
		}
	}
	//设置请求对象
	function setRequest($request)
	{
		try
		{
			$this->_tpl_vars['request']=$request;
			$this->request=$request;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 变量的地址引用的复制
	 *
	 * @param unknown_type $tpl_var
	 * @param unknown_type $value
	 */
	function assign_by_ref($tpl_var, &$value)
	{
		if ($tpl_var != '')
		$this->_tpl_vars[$tpl_var] = &$value;
	}
	/**
	 * 清空所有的变量复制
	 *
	 */
	function clear_all_assign()
	{
		$this->_tpl_vars = array();
	}
	/**
	 * 创建目录
	 *
	 * @param unknown_type $directory
	 * @param unknown_type $mode
	 * @return unknown
	 */
	public function makeDir($directory,$mode = 0777)
	{
		if(@opendir($directory)) return true;
		if (@mkdir($directory,$mode))
		{
			@chmod($directory,$mode);
			return true;
		}
		else
		{
			$pathInfo = explode("/",$directory);
			$basedir="";
			foreach($pathInfo as $var)
			{
				if ($var == ".")
				{
					$basedir=$basedir."./";
					$begin = false;
				}
				elseif ($var == "..")
				{
					$basedir=$basedir."../";
					$begin = false;
				}
				else
				{
					if (!$begin)
					{
						$var = $var;
						$begin = true;
					}
					else
					$var = '/'.$var;
					if ($this->makeDir($basedir.$var,$mode))
					{
						//echo "Repair ${basedir}${var} <br>";
						$repair = true;
						$basedir = $basedir.$var;
					}
					else
					{
						$repair = false;
					}
				}
			}
			@chmod($basedir,$mode);
			return $basedir;
		}



	}
	/**
	 * 模板文件是否存在
	 *
	 * @param unknown_type $file_name
	 * @return unknown
	 */
	function templateExists($file_name)
	{
		if(file_exists($file_name)) return true;
		else return false;
	}
	/**
	 * 根据模板的文件名称来创建编译后的模板文件的名称
	 * 包含路径
	 *
	 * @param unknown_type $fileName
	 * 
	 */
	public function generateCompileFileName($fileName)
	{
		try
		{
			//modify zxq 20110708 把模板文件编译成tpl目录下的路径名加入下划线再加入文件名
			$fileName = str_replace($this->template_dir,'',$fileName);
			$data = pathinfo($fileName);
			if($data['dirname']=='.')
			{
				$pathStr = '';
			}else 
			{
				$pathStr = str_replace('/','_',$data['dirname'])."_";
			}
			
			if (!isset($data['extension']))
			{
				return $this->compile_dir.$this->compilefile_prefix.$pathStr.$data['basename'].".php";
				//return $runTimeDir.$this->compilefile_prefix.$data['basename'].".php";
			}
			else
			{
				if ($data['extension']=="")
				{
					return $this->compile_dir.$this->compilefile_prefix.$pathStr.$data['basename'].".php";
					//return $runTimeDir.$this->compilefile_prefix.$data['basename'].".php";
				}
				else
				{
					$name=$data['basename'];
					$name=str_replace('.'.$data['extension'],'',$name);
					return $this->compile_dir.$this->compilefile_prefix.$pathStr.$name.".php";
					//return $runTimeDir.$this->compilefile_prefix.$name.".php";
				}
			}

		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	 * include标签专用
	 * 根据模板的文件名称来创建编译后的模板文件的名称
	 * 包含路径
	 *
	 * @param unknown_type $fileName
	 * modfiy 张小权 20110708
	 */
	public function generateCompileFileNameByInclude($fileName)
	{
		try
		{
			//modify zxq 20110708 把模板文件编译成tpl目录下的路径名加入下划线再加入文件名
			$fileName = str_replace($this->template_dir,'',$fileName);
			$data = pathinfo($fileName);
			if($data['dirname']=='.')
			{
				$pathStr = '';
			}else 
			{
				$pathStr = str_replace('/','_',$data['dirname'])."_";
			}
			if (!isset($data['extension']))
			{
				return $this->compilefile_prefix.$pathStr.$data['basename'].".php";
				//return $runTimeDir.$this->compilefile_prefix.$data['basename'].".php";
			}
			else
			{
				if ($data['extension']=="")
				{
					return $this->compilefile_prefix.$pathStr.$data['basename'].".php";
					//return $runTimeDir.$this->compilefile_prefix.$data['basename'].".php";
				}
				else
				{
					$name=$data['basename'];
					$name=str_replace('.'.$data['extension'],'',$name);
					return $this->compilefile_prefix.$pathStr.$name.".php";
					//return $runTimeDir.$this->compilefile_prefix.$name.".php";
				}
			}

		}
		catch (Exception $e)
		{
			throw $e;
		}

	}

}
?>