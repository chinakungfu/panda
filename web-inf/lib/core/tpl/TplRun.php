<?php
import('core.tpl.TplTemplate');
import('core.tpl.TplCompile');
import('core.controller.controller');
import('core.apprun.cms.publish');
class TplRun extends TplTemplate
{
	/**
	 * 执行模板文件，并且要将模板文件的执行结果返回
	 *
	 * @param unknown_type $fileName
	 */
	public function callTplWithReturn($fileName)
	{
		try
		{
			//取模板对应的编译文件s
			$compileFileName=$this->generateCompileFileName($fileName);
			if (!file_exists($compileFileName))
			{
				throw new Exception('compile class not exists exception',322);
			}
			else
			{
				return include_once($compileFileName);//获取执行模板的内容
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 运行模板
	 * 参数是模板的名称
	 * @param unknown_type $fileName
	 */
	public function display($fileName)
	{
		try
		{
			//调用显示模板，
			$compileFileName=$this->generateCompileFileName($fileName);
			if (!file_exists($compileFileName))
			{
				throw new Exception('compile class not exists exception',322);
			}
			else
			{
				$contents=$this->runTplWithReturn($compileFileName);
				echo $contents;
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * Ajax运行模板流程，并且需要cache检验的
	 */
	public function runTplReturn($fileName,$cache=null)
	{
		try
		{
			/**
			 * 运行模板的时候是否需要指定缓存
			 * ，如果不设置，默认工程的换成级别，否则，
			 * 缓存使用设置的级别
			 */
			if ($cache!=null)
			{
				$this->require_cache=$cache;
			}
			//取模板对应的编译文件
			$compileFileName=$this->generateCompileFileName($fileName);
			if (!file_exists($compileFileName))
			{
				throw new Exception('compile class not exists exception',322);
			}
			else
			{
				if ($this->require_cache!='false')//需要缓存的处理
				{
					$cachefile=$this->buildCacheFile($compileFileName);//创建缓存文件名称
					if ($this->checkCacheEff($cachefile))//缓存文件有效，可以直接读取缓存文件返回
					{
						//读取缓存文件
						$contents=$this->readContentFromFile($cachefile);
						$ajaxNew = new AjaxService();
						$server = $ajaxNew->getAjaxByService($GLOBALS['currentApp']["mvcconfig"],$GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
						if($server['isJsOut']=='true')
						{
							$contents = $this->JsOutputFormat($contents);
							$contents = "document.write(\"".$contents."\");";
						}
						return $contents;
					}
					else//返回文件无效，需要重新生成缓存文件，并将结果返回客户端
					{
						$contents=$this->runTplWithReturn($compileFileName);
						$this->writeContentToFile($contents,$cachefile);//写入到缓存文件
						$ajaxNew = new AjaxService();
						$server = $ajaxNew->getAjaxByService($GLOBALS['currentApp']["mvcconfig"],$GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
						if($server['isJsOut']=='true')
						{
							$contents = $this->JsOutputFormat($contents);
							$contents = "document.write(\"".$contents."\");";
						}
						return $contents;
					}
				}
				else //不需要缓存
				{
					$contents=$this->runTplWithReturn($compileFileName);
					$ajaxNew = new AjaxService();
					$server = $ajaxNew->getAjaxByService($GLOBALS['currentApp']["mvcconfig"],$GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
					if($server['isJsOut']=='true')
					{
						$contents = $this->JsOutputFormat($contents);
						$contents = "document.write(\"".$contents."\");";
					}
					return $contents;
				}
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 运行模板流程，并且需要cache检验的
	 */
	public function run($fileName,$cache=null)
	{
		try
		{
			/**
			 * 运行模板的时候是否需要指定缓存
			 * ，如果不设置，默认工程的换成级别，否则，
			 * 缓存使用设置的级别
			 */
			if ($cache!=null)
			{
				$this->require_cache=$cache;
			}
			//取模板对应的编译文件
			$compileFileName=$this->generateCompileFileName($fileName);
			if (!file_exists($compileFileName))
			{
				throw new Exception('compile class not exists exception :'.$compileFileName ,322);
			}
			else
			{
				if ($this->require_cache!='false'&&$this->require_cache!='')//需要缓存的处理
				{
					$cachefile=$this->buildCacheFile($compileFileName);//创建缓存文件名称
					if ($this->checkCacheEff($cachefile))//缓存文件有效，可以直接读取缓存文件返回
					{
						//读取缓存文件
						$contents=$this->readContentFromFile($cachefile);
						$server = $this->getJsArray($GLOBALS['currentApp']["mvcconfig"],$GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
						if($server['isJsOut']=='true')
						{
							$contents = $this->JsOutputFormat($contents);
							$contents = "document.write(\"".$contents."\");";
						}
						echo $contents;
					}
					else//返回文件无效，需要重新生成缓存文件，并将结果返回客户端
					{
						$contents=$this->runTplWithReturn($compileFileName);
						$this->writeContentToFile($contents,$cachefile);//写入到缓存文件
						$server = $this->getJsArray($GLOBALS['currentApp']["mvcconfig"],$GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
						if($server['isJsOut']=='true')
						{
							$contents = $this->JsOutputFormat($contents);
							$contents = "document.write(\"".$contents."\");";
						}
						echo $contents;
					}
				}
				else //不需要缓存
				{
					$contents=$this->runTplWithReturn($compileFileName);
					$server = $this->getJsArray($GLOBALS['currentApp']["mvcconfig"],$GLOBALS['IN']['action'],$GLOBALS['IN']['method']);
					if($server['isJsOut']=='true')
					{
						$contents = $this->JsOutputFormat($contents);
						$contents = "document.write(\"".$contents."\");";
					}
					echo $contents;
				}
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
 * 检查cache的文件是否还是有效的
 *
 * @param unknown_type $cacheFile
 */
	protected function checkCacheEff($cacheFile)
	{
		try
		{
			$cacheFileCreatedTimes=$this->_GetFileCreatedTime($cacheFile);//取缓存文件的修改事件
			if (($cacheFileCreatedTimes+$this->cache_timeout)> time()) //缓存文件有效
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	 * 保存数据到文件
	 *
	 * @param unknown_type $fileName
	 */
	public function saveToFile($fileName,$tofileName)
	{
		try
		{
			//取模板对应的编译文件
			$compileFileName=$this->generateCompileFileName($fileName);
			if (!file_exists($compileFileName))
			{
				throw new Exception('compile class not exists exception',322);
			}
			else
			{
				$contents=$this->runTplWithReturn($compileFileName);//获取执行模板的内容
				$this->writeContentToFile($contents,$tofileName);//将文件写入到文件
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 创建缓存的文件 名称
	 *
	 * @param unknown_type $fileName
	 */
	protected function buildCacheFile($fileName)
	{
		try
		{
			$data=pathinfo($fileName);
			if ($data['extension']=="")
			{
				$prefix=$data['basename'];
			}
			else
			{
				$prefix=$data['basename'];
				$prefix=str_replace('.'.$data['extension'],'',$prefix);
			}
			return $this->cache_dir.$prefix.md5(serialize($GLOBALS['IN']));
			//return $this->cache_dir.$prefix.md5($GLOBALS['IN']['HTTP_HOST'].$GLOBALS['IN']['PHP_SELF'].$GLOBALS['IN']["REQUEST_URI"]);
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	* 获取文件创建时间
	* @param string $file 要获取创建时间的目标文件路径
	* @access private
	* @return datetime 文件创建时间
	*/
	protected function _GetFileCreatedTime( $file )
	{
		if ( @is_file( $file ) )
		return filemtime( $file );
		else
		return 0;
	}
	/**
	 * 执行编译的模板文件，并将文件返回
	 *
	 * @param unknown_type $compileFile
	 */
	protected function runTplWithReturn($compileFile)
	{
		try
		{
			// 捕获输出内容
			ob_start();
			include($compileFile);
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 执行编译文件但不返回结果
	 *
	 * @param unknown_type $compileFile
	 */
	protected function runTplNoReturn($compileFile)
	{
		try
		{
			// 捕获输出内容
			ob_start();
			include($compileFile);
			ob_flush();
			ob_end_clean();
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 将内容写入到文件
	 *
	 * @param unknown_type $contents
	 * @param unknown_type $fileName
	 */
	protected function writeContentToFile($contents,$fileName)
	{
		try
		{
			if ($fp = fopen($fileName,'w+'))
			{
				@flock( $fp, LOCK_EX );
				fwrite( $fp, $contents );
				@flock( $fp, LOCK_UN );
				fclose( $fp);
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 从文件中读取内容，并返回文件内容
	 *
	 * @param unknown_type $fileName
	 */
	protected function readContentFromFile($fileName)
	{
		try
		{
			if($fp = @fopen($fileName, 'r'))
			{
				$contents = fread($fp, filesize($fileName));
				fclose($fp);
				return $contents;
			}

		}
		catch (Exception $e)
		{
			throw $e;
		}

	}

	/**
	 * 删除目录下的所有文件
	 * $type=time   按事件清空目录
	 * $type=tpl    按模板文件的名称来清空
	 * @param unknown_type $dir
	 * @param unknown_type $file
	 */
	public function clearCache($dir,$type,$condition=null)
	{
		try
		{
			if ($dh=opendir($dir))
			{
				while ($file=readdir($dh))
				{
					if($file!="." && $file!="..") {
						$fullpath=$dir."/".$file;
						if(!is_dir($fullpath))
						{//如果不是目录，开始清理目录
							if ($type=="time")
							{
								if ($condition==null)
								{
									unlink($fullpath);
								}
								else
								{
									$cacheFileCreatedTimes=$this->_GetFileCreatedTime($fullpath);
									//如果cache文件的事件加上条件的事件间隔小于当前时间，则删除文件
									if (($cacheFileCreatedTimes+$condition)<=time())
									{
										unlink($fullpath);
									}
								}
							}
						}
						else
						{
							deldir($fullpath,$type,$condition);
						}
					}
				}
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	public function createStaticFile($contents,$publishArray,$type=1)
	{
		try
		{
			
			$fileName = $publishArray[0]['contentPSN'].$publishArray[0]['subDir'];
			if($type)
			{
				if(!TplCompile::makeDir($fileName))
				{
					$fileName = TplCompile::makeDir($fileName).$publishArray[0]['publishFileFormat'];
				}else 
				{
					$fileName = $fileName.$publishArray[0]['publishFileFormat'];
				}
				$portUrl = $publishArray[0]['contentURL'].$publishArray[0]['subDir'].$publishArray[0]['publishFileFormat'];
			}else 
			{
				if(!TplCompile::makeDir($fileName))
				{
					$fileName = TplCompile::makeDir($fileName).$publishArray[0]['indexName'];
				}else 
				{
					$fileName = $fileName.$publishArray[0]['indexName'];
				}
				$portUrl = $publishArray[0]['contentURL'].$publishArray[0]['subDir'].$publishArray[0]['indexName'];
			}
			if($fp =fopen($fileName, 'w'))
			{
				fwrite($fp, $contents);
				fclose($fp);				//touch($this->$fileName, filemtime($file_name));
			}
			
			$localPath = $fileName;
			$backUrlArray['portUrl'] = $portUrl;
			$backUrlArray['localPath'] = $localPath;
			return $backUrlArray;
		}catch (Exception $e)
		{
			throw $e;
		}
	}
	function getJsArray($ajaxconfig,$actionId,$methodId)
	{
		try
		{
			$currentservice=null;//当前服务类
			if(is_array($ajaxconfig)){
				if (array_key_exists($actionId,$ajaxconfig))
				{
					$currentservice=$ajaxconfig[$actionId];
					if (array_key_exists($methodId,$currentservice['action']))
					{
						return $currentservice['action'][$methodId];
					}
					else
					{
						return null;
					}
				}
				else
				{
					return null;
				}
			}else{
				return null;
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	function JsOutputFormat($str)
	{
		$str = trim($str);
		$str = str_replace("\s\s", "\s", $str);
		$str = str_replace("\r", '', $str);
		$str = str_replace("\n", '', $str);
		$str = str_replace("\t", '', $str);
		$str = str_replace("\\", "\\\\", $str);  //反斜杠处理
		$str = str_replace("\"", "\\\"", $str);  //双引号处理
		//$str = addslashes($str);
		$str = str_replace("\'", "\\\'", $str);  //单引号处理
		return $str;
	}

}
?>