<?php
/**
 * 系统的初始化的入库函数类
 */
define('PATHSEPARATOR','/');
import('core.xml.XMLDoc');
import('core.xml.XMLTag');
import('core.lang.FileException');
import('core.param.param');
//引入php类文件方法
function import($name)
{
	$filename=str_replace('.', PATHSEPARATOR, $name) . '.php';
	$filename=$GLOBALS['currentApp']['corepath'].PATHSEPARATOR.$filename;
	//print $GLOBALS['currentApp']['corepath'];
	//print $filename."<br>";
	if (file_exists($filename))
	{
		require_once($filename);
	}

}
//include 标签处理函数
//add zxq 20110708
function includeFunc($tplFile)
{
	try {
		$tpl=new TplRun();
		$fileName=$tpl->generateCompileFileNameByInclude($tplFile);
		return $GLOBALS['currentApp']['tpl_complie_path'].$fileName;
	}catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 引入php的函数方法及类方法
 *
 * @param unknown_type $name
 */
function include_package($name)
{
	$filename=str_replace('.', PATHSEPARATOR, $name) . '.php';
	$filename=$GLOBALS['currentApp']['corepath'].PATHSEPARATOR.$filename;
	include_once($filename);
}

/**
 * 根据数据源xml的配置文件生成数据源的php配置信息
 *
 * @param unknown_type $fileName
 */
function generateDsConfig($fileName,$currentAppName)
{

	if (($fileName=='')||($fileName==null))
	{
		return "";
	}
	$content="";
	try {
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName=='datasources')
		{
			$dsList=$tree->GetElementsByTagName('datasource');
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{
				$dbConfig=array();
				$childList=$dsList[$i]->GetChild();
				$listCount=count($childList);
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=='appid')
					{
						$dbConfig['appId']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='servername')
					{
						$dbConfig['serverName']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='dbtype')
					{
						$dbConfig['dbtype']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='loginname')
					{
						$dbConfig['loginName']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='loginpassword')
					{
						$dbConfig['loginPassword']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='drivertype')
					{
						$dbConfig['drivertype']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='port')
					{
						$dbConfig['port']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='dbname')
					{
						$dbConfig['dbName']=$childList[$j]->data;
					}elseif ($childList[$j]->TagName=='dbcharset')
					{
						$dbConfig['dbcharset']=$childList[$j]->data;
					}

				}
				if ($content=="")
				{
					$content='\''.$dbConfig['appId'].'\'=>array('."\n".
					'\'appId\'=>\''.$dbConfig['appId'].'\','."\n".
					'\'serverName\'=>\''.$dbConfig['serverName'].'\','."\n".
					'\'dbtype\'=>\''.$dbConfig['dbtype'].'\','."\n".
					'\'loginName\'=>\''.$dbConfig['loginName'].'\','."\n".
					'\'loginPassword\'=>\''.$dbConfig['loginPassword'].'\','."\n".
					'\'drivertype\'=>\''.$dbConfig['drivertype'].'\','."\n".
					'\'port\'=>\''.$dbConfig['port'].'\','."\n".
					'\'dbName\'=>\''.$dbConfig['dbName'].'\','."\n".
					'\'dbcharset\'=>\''.$dbConfig['dbcharset'].'\''."\n".')';
				}
				else
				{
					$content=$content.',\''.$dbConfig['appId'].'\'=>array('."\n".
					'\'appId\'=>\''.$dbConfig['appId'].'\','."\n".
					'\'serverName\'=>\''.$dbConfig['serverName'].'\','."\n".
					'\'dbtype\'=>\''.$dbConfig['dbtype'].'\','."\n".
					'\'loginName\'=>\''.$dbConfig['loginName'].'\','."\n".
					'\'loginPassword\'=>\''.$dbConfig['loginPassword'].'\','."\n".
					'\'drivertype\'=>\''.$dbConfig['drivertype'].'\','."\n".
					'\'port\'=>\''.$dbConfig['port'].'\','."\n".
					'\'dbName\'=>\''.$dbConfig['dbName'].'\','."\n".
					'\'dbcharset\'=>\''.$dbConfig['dbcharset'].'\''."\n".')';
				}
				unset($dbConfig);

			}
			unset($dsList);

			return '$app[\''.$currentAppName.'\']'.'[\'dbconfig\']=array('.$content.');'."\n";
		}

	}
	catch (FileException $e)
	{
		throw $e;
	}

}
/**
 * 生成持久对象的php配置信息
 *
 * @param unknown_type $fileName
 */
function generatePersist($fileName,$currentAppName)
{
	if (($fileName=='')||($fileName==null))
	{
		return "";
	}
	$content="";
	try {
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName=='objects')
		{
			$dsList=$tree->GetElementsByTagName('persistent');
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{
				$config=array();
				$childList=$dsList[$i]->GetChild();
				$presistid=$dsList[$i]->GetProperty('id');
				$listCount=count($childList);
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=='classname')
					{
						$config['classname']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='filename')
					{
						$config['filename']=apppath.$childList[$j]->data;
					}
				}
				if ($content=="")
				{
					$content.='\''.$presistid.'\''.'=>array(\'classname\'=>\''.$config['classname']
					.'\','."\n".'\'filename\'=>\''.$config['filename'].'\')'."\n";
				}
				else
				{
					$content.=',\''.$presistid.'\''.'=>array(\'classname\'=>\''.$config['classname']
					.'\','."\n".'\'filename\'=>\''.$config['filename'].'\')'."\n";
				}
			}
			return '$app[\''.$currentAppName.'\']'.'[\'persistconfig\']=array('.$content.');'."\n";
		}

	}
	catch (FileException $e)
	{
		throw new FileException('<b>parser persist object exception</b>');
	}
}
/**
 * 生成函数配置文件
 * 
 * @param unknown_type $filename
 */
function generateFuncConfig($corefile,$appfile,$currentAppName)
{
	try {
		$content="";
		if ($corefile!="")
		{
			$content=generateFuncArray(corepath,$corefile);
		}
		if ($appfile!="")
		{
			if ($content=="")
			{
				$content.=generateFuncArray(apppath,$appfile);
			}
			else
			{
				$content.=','.generateFuncArray(apppath,$appfile);
			}
		}
		return '$app[\''.$currentAppName.'\']'.'[\'funcconfig\']=array('.$content.');'."\n";
	}
	catch (FileException $e)
	{
		throw $e;
	}

}
/**
 * 生成一个文件的函数配置
 *
 * @param unknown_type $fileName
 * @param unknown_type $fileName
 * @return unknown
 */
function generateFuncArray($pathinfo='',$fileName)
{
	if (($fileName=='')||($fileName==null))
	{
		return "";
	}
	$funccontent="";
	try {
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName=='functions')
		{
			$dsList=$tree->GetElementsByTagName('function');
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{
				$type="";
				$funcname="";
				$source="";
				$paramscontent="";
				$childList=$dsList[$i]->GetChild();
				$funcId=$dsList[$i]->GetProperty('id');
				$listCount=count($childList);

				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=='type')
					{
						$type=$childList[$j]->data;
					}
					if ($childList[$j]->TagName=='funcname')
					{
						$funcname=$childList[$j]->data;
					}
					if ($childList[$j]->TagName=='source')
					{
						$source=$pathinfo.$childList[$j]->data;
					}
					if ($childList[$j]->TagName=='params') 	//参数列表
					{
						$paramsList=$childList[$j]->GetChild();
						$paramscount=count($paramsList);
						for ($x=0;$x<$paramscount;$x++)//参数解析
						{
							$paramname=null;
							$paramtype=null;//
							$paramrequire=null;//
							$paramId=$paramsList[$x]->GetProperty('id');//参数的属性解析
							$propertyList=$paramsList[$x]->GetChild();
							$propertycount=count($propertyList);
							for ($y=0;$y<$propertycount;$y++)
							{
								if ($propertyList[$y]->TagName=='name')
								{
									$paramname=$propertyList[$y]->data;
								}
								if ($propertyList[$y]->TagName=='datatype')
								{
									$paramtype=$propertyList[$y]->data;
								}
								if ($propertyList[$y]->TagName=='require')
								{
									$paramrequire=$propertyList[$y]->data;
								}
							}
							if ($paramscontent=="")
							{
								$paramscontent.='\''.$paramId.'\'=>array(\'name\'=>\''.$paramname.'\','."\n".
								'\'type\'=>\''.$paramtype.'\','."\n".
								'\'require\'=>\''.$paramrequire.'\')'."\n";
							}
							else
							{
								$paramscontent.=',\''.$paramId.'\'=>array(\'name\'=>\''.$name.'\','."\n".
								'\'type\'=>\''.$paramtype.'\','."\n".
								'\'require\'=>\''.$paramrequire.'\')'."\n";
							}


						}
						$paramscontent ='\'params\'=>array('.$paramscontent.')'."\n";
					}


				}
				//生成函数
				if ($funccontent=="")
				{
					$funccontent.='\''.$funcId.'\'=>array(\'type\'=>\''.$type.'\','."\n".
					'\'funcname\'=>\''.$funcname.'\','."\n".
					'\'source\'=>\''.$source.'\','."\n".
					$paramscontent.')'."\n";

				}
				else
				{
					$funccontent.=',\''.$funcId.'\'=>array(\'type\'=>\''.$type.'\','."\n".
					'\'funcname\'=>\''.$funcname.'\','."\n".
					'\'source\'=>\''.$source.'\','."\n".
					$paramscontent.')'."\n";
				}
				unset($funcId);
				unset($funcname);
				unset($source);
				unset($paramscontent);
				unset($type);

			}
			return $funccontent;
		}
	}
	catch (FileException $e)
	{
		throw new FileException('<b>parser function '.$fileName.' exception</b>');

	}

}

/**
 * 生成Html标签的配置
 *
 * @param unknown_type $fileName
 */
function generateHtmlConfig($corefile,$appfile,$currentAppName)
{
	try {
		$content="";
		if ($corefile!="")
		{
			$content.=generateHtmlArray(corepath,$corefile);
		}
		if ($appfile!="")
		{
			if ($content=="")
			{
				$content.=generateHtmlArray(apppath,$appfile);
			}
			else
			{
				$content.=','.generateHtmlArray(apppath,$appfile);
			}
		}

		return '$app[\''.$currentAppName.'\']'.'[\'htmltags\']=array('.$content.');'."\n";
	}
	catch (FileException $e)
	{
		throw $e;
	}
}
function generateHtmlArray($pathinfo='',$fileName)
{
	if (($fileName=='')||($fileName==null))
	{
		return "";
	}
	$content="";
	try
	{
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName=='tags')
		{
			$dsList=$tree->GetElementsByTagName('tag');
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{
				$config=array();
				$childList=$dsList[$i]->GetChild();
				$htmltagid=$dsList[$i]->GetProperty('id');
				$listCount=count($childList);
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=='classname')
					{
						$config['classname']=$childList[$j]->data;
					}
					if ($childList[$j]->TagName=='sourcefile')
					{
						$config['sourcefile']=$pathinfo.$childList[$j]->data;
					}
					if ($childList[$j]->TagName=='version')
					{
						$config['version']=$childList[$j]->data;
					}

				}
				if ($content=="")
				{
					$content.='\''.$htmltagid.'\''.'=>array(\'classname\'=>\''.$config['classname']
					.'\','."\n".'\'filename\'=>\''.$config['sourcefile'].'\''
					.','."\n".'\'version\'=>\''.$config['version'].'\')'."\n";
				}
				else
				{
					$content.=',\''.$htmltagid.'\''.'=>array(\'classname\'=>\''.$config['classname']
					.'\','."\n".'\'filename\'=>\''.$config['sourcefile'].'\''
					.','."\n".'\'version\'=>\''.$config['version'].'\')'."\n";
				}

			}
			return $content;
		}

	}
	catch (FileException $e)
	{
		throw new FileException('<b> parser html tag config'.$fileName.' Exception </b>');
	}
}

/**
 * 生成标签的配置文件
 *
 * @param unknown_type $fileName
 */
function generateTagConfig($corefile,$appfile,$currentAppName)
{
	try {


		$content="";
		if ($corefile!="")
		{
			$content.=generateHtmlArray(corepath,$corefile);
		}
		if ($appfile!="")
		{
			if ($content=="")
			{
				$content.=generateHtmlArray(apppath,$appfile);
			}
			else
			{
				$content.=','.generateHtmlArray(apppath,$appfile);
			}
		}

		return '$app[\''.$currentAppName.'\']'.'[\'logictags\']=array('.$content.');'."\n";
	}
	catch (FileException $e)
	{
		throw $e;
	}
}
/**
 * 生成配置文件的总入库
 *
 * @param unknown_type $fileName
 */
function generateAllConfig($fileName)
{
	$content=null;
	$corepath="";
	$apppath="";
	try {
		$parser=new XMLDoc();
		$rtnBool=$parser->LoadFromFile($fileName);
		if (!$rtnBool)
		{
			throw new FileException($parser->GetError());
		}
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);//释放内存
		try {
			if ($tree->TagName=='web-inf')
			{
				//取得应用名
				$nodedata = $tree->GetChildByTagName('appname');
				if($nodedata != null)
				{
					if($nodedata->data!='')
					{
						$currentAppName = $nodedata->data;
					}
					else
					{
						throw new FileException('AppName is empty!');
					}
				}
				else
				{
					throw new FileException('AppName is not set!');
				}

				//取数据库的配置连接信息
				$nodedata=$tree->GetChildByTagName('dsconfig');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$content.=generateDsConfig(apppath.$nodedata->data,$currentAppName);
					}
				}
				//取ajax的配置信息
				$nodedata=$tree->GetChildByTagName('ajaxconfig');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$content.=generateAjaxConfig(apppath.$nodedata->data,$currentAppName);
					}
				}
				//取应用的持久对象配置
				$nodedata=$tree->GetChildByTagName('persistentconfig');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$content.=generatePersist(apppath.$nodedata->data,$currentAppName);
					}
				}
				//取系统核心的函数的配置
				$nodedata=$tree->GetChildByTagName('corefuncconfig');
				$corefuncconfig='';
				$appfuncconfig='';
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$corefuncconfig=corepath.$nodedata->data;
					}

				}
				//取应用自定义函数的配置
				$nodedata=$tree->GetChildByTagName('appfuncconfig');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$appfuncconfig=apppath.$nodedata->data;
					}
				}
				$content.=generateFuncConfig($corefuncconfig,$appfuncconfig,$currentAppName);
				//生成html标签的配置信息
				$corehtmltag="";
				$apphtmltag="";
				$nodedata=$tree->GetChildByTagName('apphtmltag');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$apphtmltag=apppath.$nodedata->data;
					}
					else
					{
						$apphtmltag=$nodedata->data;
					}

				}
				$nodedata=$tree->GetChildByTagName('corehtmltag');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$corehtmltag=corepath.$nodedata->data;
					}
					else
					{
						$corehtmltag=$nodedata->data;
					}
				}

				$content.=generateHtmlConfig($corehtmltag,$apphtmltag,$currentAppName);


				//生成逻辑标签的配置信息
				$corelogictag="";
				$applogictag="";
				$nodedata=$tree->GetChildByTagName('apptpltag');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$applogictag=apppath.$nodedata->data;
					}
					else
					{
						$applogictag=$nodedata->data;
					}
				}
				$nodedata=$tree->GetChildByTagName('coretpltag');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$corelogictag=corepath.$nodedata->data;
					}
					else
					{
						$corelogictag=$nodedata->data;
					}
				}
				$content.=generateTagConfig($corelogictag,$applogictag,$currentAppName);
				//生成mvc控制配置
				$nodedata=$tree->GetChildByTagName('mvcconfig');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$content.=generateMvcConfig(apppath.$nodedata->data,$currentAppName);
					}
					else
					{
						$content.=generateMvcConfig($nodedata->data,$currentAppName);
					}
				}
				//生成resource配置
				$nodedata=$tree->GetChildByTagName('resourceconfig');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$content.=generateResourceConfig(apppath.$nodedata->data,$currentAppName);
					}
				}
				//取得资源类型
				$nodedata = $tree->GetChildByTagName('resourcetype');
				if($nodedata != null)
				{
					if($nodedata->data!='')
					{
						$resourcetype = $nodedata->data;
						$content .= "\$app['resourcetype'] ='".$resourcetype."';\n";
					}
					
				}
				//取得哪些应用可以使用资源
				$nodedata = $tree->GetChildByTagName('resourceOfApp');
				if($nodedata != null)
				{
					if($nodedata->data!='')
					{
						$resourceOfApp = $nodedata->data;
						$content .= "\$app['resourceOfApp'] ='".$resourceOfApp."';\n";
					}
					
				}
				//生成apptree配置
				$nodedata=$tree->GetChildByTagName('apptreeconfig');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$content.=generateAppTreeConfig(apppath.$nodedata->data,$currentAppName);
					}
					else
					{
						$content.=generateAppTreeConfig($nodedata->data,$currentAppName);
					}
				}
				//生成默认数据源的配置信息
				$nodedata=$tree->GetChildByTagName('defaultds');
				if ($nodedata!=null)
				{
					$content.='$app[\''.$currentAppName.'\'][\'defaultDataSourceId\']=\''.$nodedata->data.'\';'."\n";
				}
				//生成模板文件的配置信息

				$dsList=$tree->GetElementsByTagName('tplconfig');
				if (is_array($dsList))
				{
					$childList=$dsList[0]->GetChild();
					$listCount=count($childList);
					for ($j=0;$j<$listCount;$j++)
					{
						if ($childList[$j]->TagName=='sourceroot')
						{
							if (apppath!="")
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_source_path\']=\''.apppath.$childList[$j]->data.'\';'."\n";
							}
							else
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_source_path\']=\''.$childList[$j]->data.'\';'."\n";
							}
						}
						if ($childList[$j]->TagName=='complieroot')
						{
							if (apppath!="")
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_complie_path\']=\''.apppath.$childList[$j]->data.'\';'."\n";
							}
							else
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_complie_path\']=\''.$childList[$j]->data.'\';'."\n";
							}
						}
						if ($childList[$j]->TagName=='cachedir')
						{
							if ($apppath!="")
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_cache_path\']=\''.apppath.$childList[$j]->data.'\';'."\n";
							}
							else
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_cache_path\']=\''.$childList[$j]->data.'\';'."\n";
							}
						}
						if ($childList[$j]->TagName=='requestcache')
						{
							$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_request_cache\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='compilefile_prefix')
						{
							$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_compilefile_prefix\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='compile_filter') //编译过滤器
						{
							if ($childList[$j]->data!="")
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_compile_filter\']=\''.apppath.$childList[$j]->data.'\';'."\n";
							}
							else
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_compile_filter\']=\'\';'."\n";
							}
						}
						if ($childList[$j]->TagName=='lang') //语言
						{
							$content.='$app[\''.$currentAppName.'\']'.'[\'tpl_language\']=\''.$childList[$j]->data.'\';'."\n";
						}

					}
					unset($childList);//释放变量
				}
				unset($dsList);
				//生成变量的预处理变量
				$nodedata=$tree->GetChildByTagName('var');
				if ($nodedata!=null)
				{
					$content.='$app[\''.$currentAppName.'\']'.'[\'varprefix\']=\''.$nodedata->data.'\';'."\n";
				}
				else
				{
					$content.='$app[\''.$currentAppName.'\']'.'[\'varprefix\']=\'_$$\';'."\n";
				}
				//生成cache的配置信息
				$dsList=$tree->GetElementsByTagName('cachesetting');
				if (is_array($dsList))
				{
					$childList=$dsList[0]->GetChild();
					$listCount=count($childList);
					for ($j=0;$j<$listCount;$j++)
					{
						if ($childList[$j]->TagName=='timeout')
						{
							$content.='$app[\''.$currentAppName.'\']'.'[\'cache_timeout\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='cacheroot')
						{
							if (apppath!="")
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'cache_path\']=\''.apppath.$childList[$j]->data.'\';'."\n";
							}
							else
							{
								$content.='$app[\''.$currentAppName.'\']'.'[\'cache_path\']=\''.$childList[$j]->data.'\';'."\n";
							}
						}

					}
					unset($childList);
				}
				unset($dsList);
				//生成openid的配置
				$dsList=$tree->GetElementsByTagName("openidconfig");
				if (is_array($dsList))
				{
					$childList=$dsList[0]->GetChild();
					$listCount=count($childList);
					for ($j=0;$j<$listCount;$j++)
					{
						if ($childList[$j]->TagName=='tmp_path')
						{
							$content.='$app[\''.$currentAppName.'\']'.'[\'openid_tmp_path\']=\''.apppath.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='required_fields')
						{
							$content.='$app[\''.$currentAppName.'\']'.'[\'openid_required_fields\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='options_fields')
						{
							$content.='$app[\''.$currentAppName.'\']'.'[\'openid_options_fields\']=\''.$childList[$j]->data.'\';'."\n";
						}
					}
					unset($childList);
				}
				unset($dsList);
				//会员机制应用采用的dsid
				$dsList=$tree->GetElementsByTagName('mechanism');
				if(is_array($dsList))
				{
					$childList=$dsList[0]->GetChild();
					$listCount=count($childList);
					for ($j=0;$j<$listCount;$j++)
					{
						if ($childList[$j]->TagName=='dsid')
						{
							$content .= '$mechanism[\''.$currentAppName.'\'][\'dsid\']=\''.$childList[$j]->data.'\';'."\n";
						}else 
						//if ($childList[$j]->TagName=='apppath')
						{
							$content .= '$mechanism[\''.$currentAppName.'\'][\'apppath\']=\''.$childList[$j]->data.'\';'."\n";
						}
						
					}
					unset($childList);
				}
				unset($dsList);
				//生成mail的配置
				$dsList=$tree->GetElementsByTagName("mailconfig");
				if (is_array($dsList))
				{
					$childList=$dsList[0]->GetChild();
					$listCount=count($childList);
					for ($j=0;$j<$listCount;$j++)
					{
						if ($childList[$j]->TagName=='smtpserver')
						{
							$content.='$mail[\''.$currentAppName.'\']'.'[\'smtpserver\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='smtpserverport')
						{
							$content.='$mail[\''.$currentAppName.'\']'.'[\'smtpserverport\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='smtpusermail')
						{
							$content.='$mail[\''.$currentAppName.'\']'.'[\'smtpusermail\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='smtpuser')
						{
							$content.='$mail[\''.$currentAppName.'\']'.'[\'smtpuser\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='smtppass')
						{
							$content.='$mail[\''.$currentAppName.'\']'.'[\'smtppass\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='mailtype')
						{
							$content.='$mail[\''.$currentAppName.'\']'.'[\'mailtype\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='pasttime')
						{
							$content.='$mail[\''.$currentAppName.'\']'.'[\'pasttime\']=\''.$childList[$j]->data.'\';'."\n";
						}
						if ($childList[$j]->TagName=='memebercenterpath')
						{
							$content.='$mail[\''.$currentAppName.'\']'.'[\'memebercenterpath\']=\''.$childList[$j]->data.'\';'."\n";
						}
					}
					unset($childList);
				}
				unset($dsList);
				//生成分页的配置
				//print $content;
				$dsList=$tree->GetElementsByTagName("pageconfig");
				if (is_array($dsList))
				{
					$childList=$dsList[0]->GetChild();
					$listCount=count($childList);
					for ($j=0;$j<$listCount;$j++)
					{
						if ($childList[$j]->TagName=='pagesize')
						{
							$content.='$pageconfig[\''.$currentAppName.'\']'.'[\'pagesize\']=\''.$childList[$j]->data.'\';'."\n";
						}
					}
					unset($childList);
				}
				unset($dsList);
				//生成用户所要用到的表
				$nodedata=$tree->GetChildByTagName('apptableconfig');
				if ($nodedata!=null)
				{
					if ($nodedata->data!="")
					{
						$content.=generateAppTableConfig(apppath.$nodedata->data,$currentAppName);
					}
					else
					{
						$content.=generateAppTableConfig($nodedata->data,$currentAppName);
					}
				}
				//生成黄页关键字的配置信息
				$nodedata=$tree->GetChildByTagName('keywordcountconfig');
				if ($nodedata!=null)
				{
					$content.='$app[\''.$currentAppName.'\'][\'keywordCount\']=\''.$nodedata->data.'\';'."\n";
				}
			}
			unset($tree);//释放整个xml文件的内容
			$content = "\$app['{$currentAppName}']['corepath'] = '".corepath."';\n".$content;
			$content = "\$app['{$currentAppName}']['apppath'] = '".apppath."';\n".$content;
			$content .= "\$currentAppName='{$currentAppName}';\n";
			$content .= "\$currentApp=&\$GLOBALS['app']['$currentAppName'];\n";
			return '<?php'."\n".$content."\n".'?>';
		}
		catch (FileException $ex)
		{
			throw $ex;
		}


	}
	catch (FileException $ex)
	{
		echo '<b>'.$ex->getMessage().'</b>';
		throw $ex;
	}

}
/**
 * 将内容写入到文件
 *
 * @param unknown_type $fileName
 * @param unknown_type $content
 */
function writeToFile($fileName,$content)
{
	try {
		$fp=fopen($fileName,'w');
		fwrite($fp,$content);
		fclose($fp);
	}
	catch (FileException $e)
	{
		throw new FileException('<b>write data to file exception</b>');
	}
}
/**
 * 将所有数据合并到数组
 *
 * @return unknown
 */

function oas_parse_incoming()
{
	
	global $_GET, $_POST, $HTTP_CLIENT_IP, $REQUEST_METHOD, $REMOTE_ADDR, $HTTP_PROXY_USER, $HTTP_X_FORWARDED_FOR;
	$return = array();
	reset($_GET); //把传入的参数数组指针重置到第一个元素
	reset($_POST);
	if( is_array($_GET) )
	{
		if(!array_key_exists("specilContentType",$_GET))
		{
			if(array_key_exists("sqlCon",$_GET))
			{
				$sqlCon['sqlCon'] = $_GET['sqlCon'];
				$_GET = geturl($_GET['LCMSPID']);//add 20090812 zxqer
				$_GET = array_merge($sqlCon,$_GET);
				
			}elseif(array_key_exists("selectConId",$_GET))
			{
				$sqlCon['selectConId'] = $_GET['selectConId'];
				$_GET = geturl($_GET['LCMSPID']);//add 20090812 zxqer
				$_GET = array_merge($sqlCon,$_GET);
			}elseif (array_key_exists("nodeId",$_GET))
			{
				$sqlCon['nodeId'] = $_GET['nodeId'];
				$_GET = geturl($_GET['LCMSPID']);//add 20090812 zxqer
				$_GET = array_merge($sqlCon,$_GET);
			}elseif(array_key_exists("resourceUrl",$_GET))
			{
				$sqlCon['resourceUrl'] = $_GET['resourceUrl'];
				$_GET = geturl($_GET['LCMSPID']);//add 20090812 zxqer
				$_GET = array_merge($sqlCon,$_GET);
			}
			else
			{
				$_GET = geturl($_GET['LCMSPID']);//add 20090812 zxqer
				
			}
		}
		unset($_GET["LCMSPID"]);
		while( list($k, $v) = each($_GET) )
		{
			if( is_array($_GET[$k]) )
			{
				while( list($k2, $v2) = each($_GET[$k]) )
				{
					$return[$k][ oas_clean_key($k2) ] = oas_clean_value($v2);
				}
			}
			else
			{
				$return[$k] = oas_clean_value($v);
			}
		}
	}
	// Overwrite GET data with post data
	//print_r($_GET)."<br>";
	//print_r($_POST);
	if( is_array($_POST) )
	{
		while( list($k, $v) = each($_POST) )
		{
			if ( is_array($_POST[$k]) )
			{
				while( list($k2, $v2) = each($_POST[$k]) )
				{
					$return[$k][ oas_clean_key($k2) ] = oas_clean_value($v2);
				}
			}
			else
			{
				$return[$k] = oas_clean_value($v);
			}
		}
	}

	//----------------------------------------
	// Sort out the accessing IP
	// (Thanks to Cosmos and schickb)
	//----------------------------------------

	$addrs = array();

	foreach( array_reverse( explode( ',', $HTTP_X_FORWARDED_FOR ) ) as $x_f )
	{
		$x_f = trim($x_f);

		if ( preg_match( '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $x_f ) )
		{
			$addrs[] = $x_f;
		}
	}

	$addrs[] = $_SERVER['REMOTE_ADDR'];
	$addrs[] = $HTTP_PROXY_USER;
	$addrs[] = $REMOTE_ADDR;
	//header("Content-type: text/plain"); print_r($addrs); print $_SERVER['HTTP_X_FORWARDED_FOR']; exit();

	$return['IP_ADDRESS'] = oas_select_var( $addrs );

	// Make sure we take a valid IP address

	$return['IP_ADDRESS'] = preg_replace( "/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/", "\\1.\\2.\\3.\\4", $return['IP_ADDRESS'] );

	$return['request_method'] = ( $_SERVER['REQUEST_METHOD'] != "" ) ? strtolower($_SERVER['REQUEST_METHOD']) : strtolower($REQUEST_METHOD);
	/*$data = explode(';',$return[op]);
	foreach($data as $key=>$var) {
	$data1 = explode('::', $var);
	$return["{$data1[0]}"] = $data1[1];
	}
	*/
	//debug($return);
	
	//处理path_info参数
	//add by jcode
	if ( !empty($_SERVER["PATH_INFO"]) && strrpos($_SERVER["PATH_INFO"],'php?')===false ) {
		$PATH_INFO=substr($_SERVER["PATH_INFO"],1);
		foreach(explode('--',$PATH_INFO) as $params){
			$para=explode('-',$params);
			if(array_key_exists($para[0],$GLOBALS['currentApp']['urlParams'])){
				$return[$GLOBALS['currentApp']['urlParams'][$para[0]]]=$para[1];
			}else{
				$return[$para[0]]=$para[1];
			}
		}
	}
	

	return $return;
}

/*-------------------------------------------------------------------------*/
// Key Cleaner - ensures no funny business with form elements
/*-------------------------------------------------------------------------*/

function oas_clean_key($key) {

	if ($key == "")
	{
		return "";
	}
	$key = preg_replace( "/\.\./"           , ""  , $key );
	$key = preg_replace( "/\_\_(.+?)\_\_/"  , ""  , $key );
	$key = preg_replace( "/^([\w\.\-\_]+)$/", "$1", $key );
	return $key;
}

function oas_clean_value($val) {

	if ($val == "")
	{
		return "";
	}

	/*$val = str_replace( "&#032;", " ", $val );

	if ( $ibforums->vars['strip_space_chr'] )
	{
	$val = str_replace( chr(0xCA), "", $val );  //Remove sneaky spaces
	}
	*/
	/*
	$val = str_replace( "&"            , "&amp;"         , $val );
	$val = str_replace( "<!--"         , "&#60;&#33;--"  , $val );
	$val = str_replace( "-->"          , "--&#62;"       , $val );
	$val = preg_replace( "/<script/i"  , "&#60;script"   , $val );
	$val = str_replace( ">"            , "&gt;"          , $val );
	$val = str_replace( "<"            , "&lt;"          , $val );
	$val = str_replace( "\""           , "&quot;"        , $val );
	$val = preg_replace( "/\n/"        , "<br>"          , $val ); // Convert literal newlines
	$val = preg_replace( "/\\\$/"      , "&#036;"        , $val );
	$val = preg_replace( "/\r/"        , ""              , $val ); // Remove literal carriage returns
	$val = str_replace( "!"            , "&#33;"         , $val );
	$val = str_replace( "'"            , "&#39;"         , $val ); // IMPORTANT: It helps to increase sql query safety.*/

	// Ensure unicode chars are OK

	/*if ( $this->allow_unicode )
	{
	$val = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $val );
	}
	*/
	// Strip slashes if not already done so.

	if ( get_magic_quotes_gpc() )
	{
		$val = stripslashes($val);
	}

	// Swop user inputted backslashes

	//	$val = preg_replace( "/\\\(?!&amp;#|\?#)/", "&#092;", $val );

	return $val;
}

/*-------------------------------------------------------------------------*/
// Variable chooser
/*-------------------------------------------------------------------------*/

function oas_select_var($array) {

	if ( !is_array($array) ) return -1;

	ksort($array);


	$chosen = -1;  // Ensure that we return zero if nothing else is available

	foreach ($array as $k => $v)
	{
		if (isset($v))
		{
			$chosen = $v;
			break;
		}
	}

	return $chosen;
}

function oas__addslashes($string) {
	if(!$GLOBALS['magic_quotes_gpc']) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = _addslashes($val);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}

/**
 * 生成php控制器中转的mvc配置
 * 到php文件
 *
 * @param unknown_type $fileName
 */
function generateMvcConfig($fileName,$currentAppName)
{
	try
	{
		if (($fileName=='')||($fileName==null))
		{
			return "";
		}
		$content="";
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName="actions")
		{
			$acitonContent="";
			$dsList=$tree->GetElementsByTagName('action');//开始actin的循环
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{

				$actionId=$dsList[$i]->GetProperty('id');
				$paramName="";
				$childList=$dsList[$i]->GetChild();
				$listCount=count($childList);
				$methodContent="";
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=="parameter")
					{
						$paramName=$childList[$j]->data;
					}
					if ($childList[$j]->TagName=="method")
					{
						$tpl="";
						$auth="";
						$lang="";
						$cache="";

						$methodId=$childList[$j]->GetProperty("id");
						$nextList=$childList[$j]->GetChild();
						$nextCount=count($nextList);
						for ($x=0;$x<$nextCount;$x++)
						{
							if ($nextList[$x]->TagName=="tpl")//调用模板名称
							{
								if (($nextList[$x]->data!=null)&&($nextList[$x]->data!=""))
								{
									$tpl=apppath.$nextList[$x]->data;
								}
							}
							if ($nextList[$x]->TagName=="cache")//是否需要缓存
							{
								$cache=$nextList[$x]->data;
							}
							if ($nextList[$x]->TagName=="language")//语言
							{
								$lang=$nextList[$x]->data;
							}
							if ($nextList[$x]->TagName=="isJsOut")//语言
							{
								$isJsOut=$nextList[$x]->data;
								
							}
							if ($nextList[$x]->TagName=="auth")//验证类文件
							{
								if (($nextList[$x]->data!=null)&&($nextList[$x]->data!=""))
								{
									$auth=apppath.$nextList[$x]->data;
								}
							}

						}//结束方法属性的设置
						if ($methodContent=="")
						{
							$methodContent='\''.$methodId.'\'=>array(\'tpl\'=>\''.$tpl.'\''.','."\n".
							'\'cache\'=>\''.$cache.'\''.','."\n".
							'\'language\'=>\''.$lang.'\''.','."\n".
							'\'isJsOut\'=>\''.$isJsOut.'\''.','."\n".
							'\'auth\'=>\''.$auth.'\''.')';
						}
						else
						{
							$methodContent.=',\''.$methodId.'\'=>array(\'tpl\'=>\''.$tpl.'\''.','."\n".
							'\'cache\'=>\''.$cache.'\''.','."\n".
							'\'language\'=>\''.$lang.'\''.','."\n".
							'\'isJsOut\'=>\''.$isJsOut.'\''.','."\n".
							'\'auth\'=>\''.$auth.'\''.')';
						}
					}


				}
				//开始生成action的数组
				if ($acitonContent=="")
				{
					$acitonContent='\''.$actionId.'\'=>array(\'parameter\'=>\''.$paramName.'\''."\n".
					',\'action\'=>array('.$methodContent."))\n";
				}
				else
				{
					$acitonContent.=',\''.$actionId.'\'=>array(\'parameter\'=>\''.$paramName.'\''."\n".
					',\'action\'=>array('.$methodContent."))\n";
				}
			}
			return '$app[\''.$currentAppName.'\']'.'[\'mvcconfig\']=array('.$acitonContent.');'."\n";
		}
	}
	catch (Exception $e)
	{
		throw $e;
	}

}
/**
 * 根据数据源xml的配置文件生成数据源的php配置信息
 *
 * @param unknown_type $fileName
 */
function generateResourceConfig($fileName,$currentAppName)
{

	if (($fileName=='')||($fileName==null))
	{
		return "";
	}
	$content="";
	try {
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName=='resources')
		{
			$dsList=$tree->GetElementsByTagName('server');
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{
				$resourceConfig=array();
				$serverId=$dsList[$i]->GetProperty('id');
				$childList=$dsList[$i]->GetChild();
				$listCount=count($childList);
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=='servername')
					{
						$resourceConfig['servername']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='servermode')
					{
						$resourceConfig['servermode']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='serverftp')
					{
						$resourceConfig['serverftp']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='serverftpname')
					{
						$resourceConfig['serverftpname']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='serverftppass')
					{
						$resourceConfig['serverftppass']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='locate')
					{
						$resourceConfig['locate']=$childList[$j]->data;
					}
					else if  ($childList[$j]->TagName=='locateurl')
					{
						$resourceConfig['locateurl']=$childList[$j]->data;
					}
				}
				if ($content=="")
				{
					$content='\''.$serverId.'\'=>array('."\n".
					'\'servername\'=>\''.$resourceConfig['servername'].'\','."\n".
					'\'servermode\'=>\''.$resourceConfig['servermode'].'\','."\n".
					'\'serverftp\'=>\''.$resourceConfig['serverftp'].'\','."\n".
					'\'serverftpname\'=>\''.$resourceConfig['serverftpname'].'\','."\n".
					'\'serverftppass\'=>\''.$resourceConfig['serverftppass'].'\','."\n".
					'\'locate\'=>\''.$resourceConfig['locate'].'\','."\n".
					'\'locateurl\'=>\''.$resourceConfig['locateurl'].'\''."\n".')';
				}
				else
				{
					$content=$content.',\''.$serverId.'\'=>array('."\n".
					'\'servername\'=>\''.$resourceConfig['servername'].'\','."\n".
					'\'servermode\'=>\''.$resourceConfig['servermode'].'\','."\n".
					'\'serverftp\'=>\''.$resourceConfig['serverftp'].'\','."\n".
					'\'serverftpname\'=>\''.$resourceConfig['serverftpname'].'\','."\n".
					'\'serverftppass\'=>\''.$resourceConfig['serverftppass'].'\','."\n".
					'\'locate\'=>\''.$resourceConfig['locate'].'\','."\n".
					'\'locateurl\'=>\''.$resourceConfig['locateurl'].'\''."\n".')';
				}
				unset($resourceConfig);

			}
			unset($dsList);

			return '$app[\''.$currentAppName.'\']'.'[\'resourceconfig\']=array('.$content.');'."\n";
		}

	}
	catch (FileException $e)
	{
		throw $e;
	}

}
/**
 * 生成php控制器中转的AppTree配置
 * 到php文件
 *
 * @param unknown_type $fileName
 */
function generateAppTreeConfig($fileName,$currentAppName)
{
	try
	{
		if (($fileName=='')||($fileName==null))
		{
			return "";
		}
		$content="";
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName="nodes")
		{
			$apptreeContent="";
			$dsList=$tree->GetElementsByTagName('node');//开始node的循环
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{

				$apptreeId=$dsList[$i]->GetProperty('id');
				$apptreeName="";
				$childList=$dsList[$i]->GetChild();
				$listCount=count($childList);
				$sonnodeContent="";
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=="appname")//取应用名称
					{
						$apptreeName=$childList[$j]->data;
					}
					if ($childList[$j]->TagName=="sonnode")
					{
						$sonnodename='';
						$sonnodeId=$childList[$j]->GetProperty("id");
						$sonList=$childList[$j]->GetChild();
						$sonListCount=count($sonList);
						$leafnodeContent = '';
						for ($x=0;$x<$sonListCount;$x++)
						{
							if ($sonList[$x]->TagName=="sonnodename")//取子结点
							{
								$sonnodename=$sonList[$x]->data;
							}
							if($sonList[$x]->TagName=="leafnode")
							{
								$leafnodename = "";
								$actionname = "";
								$methodname = "";
								$leafnodeId = $sonList[$x]->GetProperty("id");
								$leafList = $sonList[$x]->GetChild();
								$leafCount = count($leafList);
								for ($m=0;$m<$leafCount;$m++)
								{
									if($leafList[$m]->TagName=="leafnodename")//取叶结点
									{
										$leafnodename = $leafList[$m]->data;
									}
									if($leafList[$m]->TagName=="urlname")
									{
										$urlname = $leafList[$m]->data;
									}
									if($leafList[$m]->TagName=="actionname")
									{
										$actionname = $leafList[$m]->data;
									}
									if($leafList[$m]->TagName=="methodname")
									{
										$methodname = $leafList[$m]->data;
									}
								}
								//叶结点的属性
								if($leafnodeContent=='')
								{
									$leafnodeContent = '\''.$leafnodeId.'\'=>array(\'leafnodename\'=>\''.$leafnodename.'\',\'urlname\'=>\''.$urlname.'\',\'actionname\'=>\''.$actionname.'\',\'methodname\'=>\''.$methodname.'\''.')';
								}else {
									$leafnodeContent .= ',\''.$leafnodeId.'\'=>array(\'leafnodename\'=>\''.$leafnodename.'\',\'urlname\'=>\''.$urlname.'\',\'actionname\'=>\''.$actionname.'\',\'methodname\'=>\''.$methodname.'\''.')';
								}
							}

						}//结束方法属性的设置
						if ($sonnodeContent=="")
						{
							$sonnodeContent = '\''.$sonnodeId.'\'=>array(\'sonnodename\'=>\''.$sonnodename.'\''."\n".
							',\'leafnodename\'=>array('.$leafnodeContent.'))';
						}
						else
						{
							$sonnodeContent .= ',\''.$sonnodeId.'\'=>array(\'sonnodename\'=>\''.$sonnodename.'\''."\n".
							',\'leafnodename\'=>array('.$leafnodeContent.'))';
						}
					}


				}
				//开始生成node的数组
				if ($apptreeContent=="")
				{
					$apptreeContent='\''.$apptreeId.'\'=>array(\'apptreename\'=>\''.$apptreeName.'\''."\n".
					',\'sonnodename\'=>array('.$sonnodeContent."))\n";
				}
				else
				{
					$apptreeContent.=',\''.$apptreeId.'\'=>array(\'apptreename\'=>\''.$apptreeName.'\''."\n".
					',\'sonnodename\'=>array('.$sonnodeContent."))\n";
				}
			}
			return '$app[\''.$currentAppName.'\']'.'[\'apptreeconfig\']=array('.$apptreeContent.');'."\n";
		}
	}
	catch (Exception $e)
	{
		throw $e;
	}

}

/**
 * 生成php控制器中转的table配置
 * 到php文件
 *
 * @param unknown_type $fileName
 */
function generateAppTableConfig($fileName,$currentAppName)
{
	try
	{
		if (($fileName=='')||($fileName==null))
		{
			return "";
		}
		$content="";
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName="database")
		{
			$dsList=$tree->GetElementsByTagName('database');//开始actin的循环
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{
				$databaseId=$dsList[$i]->GetProperty('id');
				$childList=$dsList[$i]->GetChild();
				$listCount=count($childList);
				$tableNameContent="";
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=="tablename")
					{
						$prefixion="";
						$name="";
						$tablenameId=$childList[$j]->GetProperty("id");
						$nextList=$childList[$j]->GetChild();
						$nextCount=count($nextList);
						for ($x=0;$x<$nextCount;$x++)
						{
							if ($nextList[$x]->TagName=="prefixion")//表前缀
							{
								$prefixion=$nextList[$x]->data;
							}
							if ($nextList[$x]->TagName=="name")//表名
							{
								$name=$nextList[$x]->data;
							}
						}
						$tableNameContent .= '$table[\''.$currentAppName.'\']'.'[\''.$tablenameId.'\']=\''.$databaseId.'.'.$prefixion.$currentAppName.'_'.$name.'\';'."\n";
					}
				}
				$content = $tableNameContent;
			}
		}
		return $content;
	}catch (Exception  $e)
	{
		throw $e;
	}
}

/**
 * 生成ajax配置类
 *
 * @param unknown_type $fileName
 * @return unknown
 */
function generateAjaxConfig($fileName,$currentAppName)
{
	try
	{
		if (($fileName=='')||($fileName==null))
		{
			return "";
		}
		$content="";
		$parser=new XMLDoc();
		$parser->LoadFromFile($fileName);
		$parser->parse();
		$tree=$parser->GetDocumentElement();
		unset($parser);
		if ($tree->TagName="ajax")
		{
			$acitonContent="";
			$dsList=$tree->GetElementsByTagName('action');//开始actin的循环
			$total=count($dsList);
			for ($i=0;$i<$total;$i++)
			{

				$actionId=$dsList[$i]->GetProperty('id');
				$paramName="";
				$childList=$dsList[$i]->GetChild();
				$listCount=count($childList);
				$methodContent="";
				for ($j=0;$j<$listCount;$j++)
				{
					if ($childList[$j]->TagName=="method")
					{
						$file="";
						$auth="";
						$lang="";
						$type="";
						$className="";
						$func="";
						$params="";
						$methodId=$childList[$j]->GetProperty("id");
						$nextList=$childList[$j]->GetChild();
						$nextCount=count($nextList);
						for ($x=0;$x<$nextCount;$x++)
						{
							if ($nextList[$x]->TagName=="file")//ajax调用的文件名称，或者是模板文件名称
							{
								if (($nextList[$x]->data!=null)&&($nextList[$x]->data!=""))
								{
									$file=apppath.$nextList[$x]->data;
								}
								continue;
							}
							if ($nextList[$x]->TagName=="type")//ajax调用的文件的类型，tpl 模板,cls 类文件，func 函数文件
							{
								$type=$nextList[$x]->data;
								continue;
							}
							if ($nextList[$x]->TagName=="language")//语言
							{
								$lang=$nextList[$x]->data;
								continue;
							}
							if ($nextList[$x]->TagName=="class")//类文件，如果调用的是类文件，该处执行类名称
							{
								$className=$nextList[$x]->data;
								continue;
							}
							if ($nextList[$x]->TagName=="func")//调用的函数的名称
							{
								$func=$nextList[$x]->data;
								continue;
							}
							if ($nextList[$x]->TagName=="cache")//调用cache
							{
								$cache=$nextList[$x]->data;
								continue;
							}
							if ($nextList[$x]->TagName=="cacheTime")//调用cacheTime
							{
								$cacheTime=$nextList[$x]->data;
								continue;
							}
							if ($nextList[$x]->TagName=="auth")//验证类文件
							{
								if (($nextList[$x]->data!=null)&&($nextList[$x]->data!=""))
								{
									$auth=apppath.$nextList[$x]->data;
								}
								continue;
							}
							if ($nextList[$x]->TagName='params')
							{
								if (($nextList[$x]->data!=null)&&($nextList[$x]->data!=""))
								{
									$params=$nextList[$x]->data;
								}
								continue;
							}
							else
							{
								$params='';
							}

						}//结束方法属性的设置
						if ($methodContent=="")
						{
							$methodContent='\''.$methodId.'\'=>array(\'file\'=>\''.$file.'\''.','."\n".
							'\'type\'=>\''.$type.'\''.','."\n".
							'\'func\'=>\''.$func.'\''.','."\n".
							'\'className\'=>\''.$className.'\''.','."\n".
							'\'cache\'=>\''.$cache.'\''.','."\n".
							'\'cacheTime\'=>\''.$cacheTime.'\''.','."\n".
							'\'language\'=>\''.$lang.'\''.','."\n".
							'\'params\'=>\''.$params.'\''.','."\n".
							'\'auth\'=>\''.$auth.'\''.')';
						}
						else
						{
							$methodContent.=',\''.$methodId.'\'=>array(\'file\'=>\''.$file.'\''.','."\n".
							'\'type\'=>\''.$type.'\''.','."\n".
							'\'func\'=>\''.$func.'\''.','."\n".
							'\'className\'=>\''.$className.'\''.','."\n".
							'\'language\'=>\''.$lang.'\''.','."\n".
							'\'params\'=>\''.$params.'\''.','."\n".
							'\'auth\'=>\''.$auth.'\''.')';
						}
					}


				}
				//开始生成action的数组
				if ($acitonContent=="")
				{
					$acitonContent='\''.$actionId.'\'=>array('.$methodContent.")\n";
				}
				else
				{
					$acitonContent=',\''.$actionId.'\'=>array('.$methodContent.")\n";
				}
			}
			return '$app[\''.$currentAppName.'\']'.'[\'ajaxConfig\']=array('.$acitonContent.');'."\n";
		}
	}
	catch (Exception $e)
	{
		throw $e;
	}

}

//用函数实现魔术引号功能
function daddslashes($string, $force = 0) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc()); //Discuz程序员惯用简单if写法
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}

//将环境转移至其它应用环境
function goApp($appName) {
	try
	{
		//保存当前应用名
		$GLOBALS['saveCurrentAppName'][] = $GLOBALS['currentAppName'];
		$saveCurrentAppName = $GLOBALS['currentAppName'];
		if(array_key_exists($appName,$GLOBALS['app']))
		{
			$GLOBALS['currentApp'] = &$GLOBALS['app'][$appName];
			$GLOBALS['currentAppName'] = $appName;
		}
		else
		{
			if(array_key_exists($appName,$GLOBALS['core']['app']))
			{
				$newApp = $GLOBALS['core']['app'][$appName];
				if($newApp['localapp'] && file_exists($newApp['apppath'].'config.php'))
				{
					include_once($newApp['apppath'].'config.php');

					//将包含进来的变量处理为全局变量,因为在函数中include的文件中的变量作用范围仍然只在函数中
					$GLOBALS['app'][$appName] = $app[$appName];
					$GLOBALS['currentApp'] = &$GLOBALS['app'][$appName];
					$GLOBALS['currentAppName'] = $currentAppName;
					if($GLOBALS['app']["{$saveCurrentAppName}"]['defaultDataSourceId'] != $GLOBALS['currentApp']['defaultDataSourceId'])
					{
						loadDS();
					}
					elseif(!empty($GLOBALS['currentApp']['defaultDataSourceId']))
					{
						$GLOBALS['currentApp']['dbaccess']=$GLOBALS['app']["{$saveCurrentAppName}"]['dbaccess'];
					}
				}
				else
				{
					throw new Exception($appName.' have Errors or is not local app!');
				}
			}
			else
			{
				throw new Exception($appName.' is not set!');
			}
		}
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//将环境恢复到当前主应用环境
function resumeApp()
{
	$PrevAppName = array_pop($GLOBALS['saveCurrentAppName']);
	if($PrevAppName != NULL) {
		$GLOBALS['currentApp'] = &$GLOBALS['app']["{$PrevAppName}"];
		$GLOBALS['currentAppName'] = $PrevAppName;
	}
}

//加载数据库操作对象
function loadDS()
{
	//检测默认的数据源，如果默认数据源不等于空，则创建默认数据源，同时置为全局变量
	if(!empty($GLOBALS['currentApp']['defaultDataSourceId']))
	{
		import('core.datasource.DbFactory');
		import('core.datasource.DataAccess');
		import('core.datasource.TStaticQuery');
		$GLOBALS['currentApp']['dbaccess']=DbFactory::getDataAccessByDsId($GLOBALS['currentApp']['defaultDataSourceId']);
		$GLOBALS['memberDs'] = &$GLOBALS['currentApp']['dbaccess'];
	}
	if(!empty($GLOBALS['currentApp']['extendedDefaultDataSourceId']))
	{
		import('core.datasource.extendedDB.extendedDbFactory');
		import('core.datasource.extendedDB.extendedDataAccess');
		import('core.datasource.extendedDB.extendedTStaticQuery');
		$GLOBALS['currentApp']['extendeddbaccess']=extendedDbFactory::getDataAccessByDsId($GLOBALS['currentApp']['extendedDefaultDataSourceId']);
		$GLOBALS['memberDs'] = &$GLOBALS['currentApp']['extendeddbaccess'];
	}
}

function &ref($value)
{
	return $value;
}

function passport_encode($array) {
	$arrayenc = array();
	foreach($array as $key => $val) {
		$arrayenc[] = $key.'='.urlencode($val);
	}
	return implode('&', $arrayenc);
}

function passport_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';

	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}

function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}

function StrCodeCWPS($string,$action='ENCODE'){
		global $SYS_ENV;
		$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].$SYS_ENV['passport_key']),8,18);
		$string	= $action == 'ENCODE' ? $string : base64_decode($string);
		$len	= strlen($key);
		$code	= '';
		for($i=0; $i<strlen($string); $i++){
			$k		= $i % $len;
			$code  .= $string[$i] ^ $key[$k];
		}
		$code = $action == 'DECODE' ? $code : base64_encode($code);
		return $code;
}





function CsubStr($str,$start,$len,$suffix='...') { 

	preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $str, $info);
	$len*=2;
	$i=0;
	$tmpstr = '';
	while($i < $len && array_key_exists($start,$info[0])) {
		if (strlen($info[0][$start]) > 1) {
			$i+=2;
			if ($i <= $len)  $tmpstr .= $info[0][$start];
			else break;
		}
		else {
			$i++;
			if ($i <= $len)  $tmpstr .= $info[0][$start];
			else break;
		}
		$start++;
	}
	return array_key_exists($start,$info[0]) ? $tmpstr.=$suffix : $tmpstr;

}

function list_page($page_num,$current_page,$send_var)
	{
		
		if($page_num == '')
		return false;
		
		$header = floor(($current_page - 1)/10);

		$start = $header*10 + 1;
		//$send_var = str_replace("{ChannelID}", $ChannelID,$send_var);

		for($i= $start;$i<=$start + 9;$i++)
		{
			$link = str_replace("{Page}", $i,$send_var);

			if($current_page == $i)
			{
				$page.= "<a href='".$link."'><b>".$i."</b></a>&nbsp;&nbsp;";
			}
			else
			{
				$page.= "<a href='".$link."'>".$i."</a>&nbsp;&nbsp;";
			}
	
			if($i==$page_num) break;
		}

		if ($current_page < $page_num)
		{
			$link1= str_replace("{Page}", $current_page+1 ,$send_var);
			$page = $page . "<a href='".$link1."' >下一页</a>";
		}

		if($current_page > 1) {
			if(($current_page-1) == 0)
			$link1 = str_replace("{Page}", 0,$send_var);
			else
			$link1= str_replace("{Page}" , $current_page-1 ,$send_var);
			$page= "<a href='".$link1."' >上一页</a>".$page;
		}



		if((($start + 10)) <= $page_num) {
			$i =  $start + 10;
			$link = str_replace("{Page}", $i,$send_var);
			$page= $page."&nbsp;&nbsp;<a href='".$link."' >下十页</a>";
		}
		
		if(($start - 1) > 0)
		{
			$i =  $start - 10;
			$link = str_replace("{Page}", $i,$send_var);
			$page= "<a href='".$link."' >上十页</a>&nbsp;&nbsp;".$page;
		}
		
		return $page;

	}
	
function isEmpty($str)
{
	$str = trim($str);
	if(empty($str))
	{
		$content = '<script language="javascript">';
		$content .= 'alert(\'The variable is wrong!\');';
		$content .= 'top.location="index.php"';
		$content .= '</script>';
	
		return $content; 
	}
}

function debug($param, $exit=false){
	print_r($param);
	if($exit) exit;
}
?>