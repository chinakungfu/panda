<?php
import('core.tags.ParentTag');
class DbActionTag extends ParentTag
{
	//处理字符串成数组
	protected  function generateText($string)
	{
		try
		{
			/*
			$patt='/'.preg_quote($GLOBALS['currentApp']['varprefix']).'([a-zA-Z0-9\_\$\$\{\}\[\]\'\"\+\>\-\*\/])*'.preg_quote($GLOBALS['currentApp']['varprefix']).'/i';
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
			//开始处理
			$array=array();
			//将dbaction的属性修改成数组
			$reg="/(\w+)=[\"](.*?)[\"]\s{0,}\n{0,}/i";
			if (preg_match_all($reg,$string,$mathes))
			{
				foreach ($mathes[0] as $childKey=>$childVar)
				{
					$array[$mathes[1][$childKey]]=$mathes[2][$childKey];
				}
			}
			*/
			//生成数组结束
			$array = parent::getParamsList($string);
			$rtn="";
			$begin="";
			if (array_key_exists('action',$array))
			{
				$begin="<?php import('core.datasource.TStaticQuery');\n";
				$rtn.='TStaticQuery::'.$this->getMethodName($array['action'])."(";
			}
			if (array_key_exists('dsid',$array))
			{
				$begin.="import('core.datasource.DataAccess');\n";
				$begin.="import('core.datasource.DBFactory');\n";
				$rtn.="DBFactory::getDataAccessByDsId('".$array['dsid']."')";

			}
			else
			{
				$begin.="import('core.datasource.DataAccess');\n";
				$rtn.='$GLOBALS[\'currentApp\'][\'dbaccess\']';
			}
			if (array_key_exists('sql',$array))
			{
				$begin.='$this->_tpl_vars[\'sqlstatement\']=\''.$array['sql'].'\';'."\n";

				$begin.=$this->processsqls($array['sql']);
				$rtn.=',$this->_tpl_vars[\'sqlstatement\']';
			}
			//处理参数
			if (array_key_exists('params',$array))
			{
				$begin.='$params=array();'."\n";
				if ($array['params']=='')
				{

				}
				else
				{
					if (strpos($array['params'],','))//有多个参数需要处理
					{
						$datas=explode(',',$array['params']);
						foreach ($datas as $key=>$var)
						{
							if (strpos($var,'='))
							{
								$childdata=explode("=",$var);
								$begin.='$params[\''.$childdata[0].'\']='.$childdata[1].";\n";
							}
						}
					}
					else //只有一个参数
					{
						if (strpos($array['params'],'='))//进行处理
						{
							$childdata=explode("=",$var);
							$begin.='$params[\''.$childdata[0].'\']='.$childdata[1].";\n";
						}

					}
				}
				$rtn.=',$params);'."\n";

			}
			else 
			{
				$rtn.=');'."\n";
			}
			if (array_key_exists('return',$array))
			{
				$rtn='$this->_tpl_vars[\''.$array['return'].'\']='.$rtn;
			}
			$rtn=$begin.$rtn.'?>';
			
			/*
			//将替换的内容替换成宏替换
			foreach ($replaceArray as $key=>$var)
			{
				if (strpos($rtn,$key))
				{
					$rtn=str_replace($key,$var,$rtn);
				}
			}
			*/
			return $rtn;
			


		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	
	/**
	 * 处理sql语句中的变量，
	 * select $data=>
	 * str_replace(select $data,$this->tpl_vars[data])
	 *
	 * @param unknown_type $sqls
	 */

	function processsqls($sql)
	{
		//print "<br>sql=";
		//print $sql;
		//print "<br><br>";
		try {
			$rtn="";
			$patt='/'.preg_quote($GLOBALS['currentApp']['varprefix']).'([a-zA-Z0-9\_\$\$\{\}\[\]\'\"\+\>\-\*\/])*'.preg_quote($GLOBALS['currentApp']['varprefix']).'/i';
			if (preg_match_all($patt,$sql,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$rtn.='$this->_tpl_vars[\'sqlstatement\']=str_replace(\''.$var.'\','.$var.',$this->_tpl_vars[\'sqlstatement\']);'."\n";
				}		
			}
			return $rtn;
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
		try
		{
			/*$enter = preg_match('/\<pp:db(.*)/n/i',$val,$arr_enter);
			if(count($arr_enter)!=0)
			{
				$patt="/\<pp:db(.*)/n(.*)\/>/i";
			}else
			{
				$patt="/\<pp:db(.*)\/>/i";	
			}*/
			$patt="/\<pp:db(.*)\/>/i";
			if (preg_match_all($patt,$val,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$source=$matches[1][$key];
					$replaceText=$this->generateText($source);
					$val=parent::replaceTags($matches[0][$key],$replaceText,$val);
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
	public function processShortTag($val)
	{
		return $val;

	}
	/**
	 * 分解属性
	 *
	 * @param unknown_type $content
	 * @return unknown
	 */
	protected  function processProperty($content,$arr)
	{
		try
		{
			foreach ($arr as $key=>$var)
			{
				$reg='/'.preg_quote($key).'/i';
				if (preg_match_all($reg,$content,$matches))
				{
					foreach ($matches as $mkey =>$mvar)
					{
						$content=parent::replaceTags($key,$var,$content);
					}
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
	 * 生成替换的ｐｈｐ语句
	 *
	 * @param unknown_type $list
	 */
	protected function generateReplace($list)
	{
		try
		{
			$content ="";
			if (is_array($list))
			{
				$content.="<?php \n";
				$content.="import('core.datasource.TStaticQuery');\n";
				$method="";
				$sqls="";
				$return ="";
				$params="";
				if (array_key_exists('action',$list))
				{
					$method=$list['action'];
				}
				else
				{
					throw new Exception('db tag set exception',333);
				}
				if (array_key_exists('sqls',$list))
				{
					$sqls=$list['sqls'];
				}
				if (array_key_exists('params',$list))
				{
					$params=$list['params'];
				}
				if (array_key_exists('return',$list))
				{
					$return=$list['return'];
				}
				//处理ｓｑｌ语句
				$sqls=parent::processExprVar($sqls);
				if ($method!='page')
				{
					$content.="TStaticQuery::".$this->getMethodName($method).'($GLOBALS[\'currentApp\'][\'access\'],'.
					"'".$sqls."'".$params.");";
				}


			}
			return $content;

		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	protected function getMethodName($method)
	{
		if (strtoupper($method)=='INSERT')
		{
			return 'insertdata';
		}
		else if (strtoupper($method)=='UPDATE')
		{
			return 'updatedata';
		}
		else if (strtoupper($method)=="DELETE")
		{
			return "deletedata";
		}
		else if (strtolower($method)=="list")
		{
			return 'queryList';
		}
		else if (strtolower($method)=="page")
		{
			return "queryForPage";
		}
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
			$iftag="/\<pp\:db\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/siU";
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
			$iftag="/\<db\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/siU";
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