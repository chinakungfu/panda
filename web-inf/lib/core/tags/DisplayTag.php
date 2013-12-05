<?php
/**
 * 系统的显示标签
 * <pp:display file="" assign="" cachetime=""/>
 * \<pp\:display\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>
 */
import('core.tags.ParentTag');
class DisplayTag extends ParentTag
{
	/**
	 * 处理标签，并将替换的内容返回
	 *
	 * @param unknown_type $val
	 */
	public function processTag($val)
	{
		try
		{
			$reg="/\<pp\:display\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
			if (preg_match_all($reg,$val,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$source=$matches[0][$key];
					$propertyList=$this->processProperty($source);
					$replace=$this->generateReplace($propertyList);
					$val=parent::replaceTags($source,$replace,$val);
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
	 * 根据属性列表
	 * 来生成替换的php语句
	 *
	 * @param unknown_type $propertyList
	 */
	protected function generateReplace($propertyList)
	{
		try
		{
			$content="";
			if (is_array($propertyList))
			{
				$content.="<?php\n";
				$content.="import('core.tpl.TplRun');\n";
				$content.="import('core.tpl.TplTemplate');\n";
				$content.='$tpl=new TplRun();'."\n";
				//初始化赋值列表
				if (array_key_exists('assign',$propertyList))
				{
					if ($propertyList['assign']!="")
					{
						$content.='$tpl->assign(\''.$propertyList['assign'].'\',$'.$propertyList['assign'].");\n";
					}
				}
				/**
				 * 设置缓存
				 */
				if (array_key_exists('cachetime',$propertyList))
				{
					if (isset($propertyList['cachetime']))
					{
						if ($propertyList['cachetime']=="")
						{
							$content.='$tpl->cache_timeout=0'.";\n";
							$content.='$tpl->require_cache=false'.";\n";
						}
						elseif ($propertyList['cachetime']=="0")
						{
							$content.='$tpl->cache_timeout=0'.";\n";
							$content.='$tpl->require_cache=false'.";\n";
						}
						else
						{
							$content.='$tpl->cache_timeout='.$propertyList['cachetime'].";\n";
							$content.='$tpl->require_cache=true'.";\n";
						}
					}
				}

				if (array_key_exists('file',$propertyList))
				{
					$content.='$tpl->display("'.$propertyList['file']."\");\nexit();\n";
				}
				else
				{
					throw new Exception('display tag not tpl file set exception',311);
				}
			}
			else
			{
				throw new Exception('display tag set exception',311);
			}
			return $content."?>";
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
			$reg="/\<display\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
			if (preg_match_all($reg,$val,$matches))
			{
				foreach ($matches[0] as $key=>$var)
				{
					$source=$matches[0][$key];
					$propertyList=$this->processProperty($source);
					$replace=$this->generateReplace($propertyList);
					$val=parent::replaceTags($source,$replace,$val);
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
	 * 处理属性列表，并将属性解析到数组里面
	 *
	 * @param unknown_type $content
	 * @return unknown
	 */
	protected  function processProperty($content)
	{
		try
		{
			$rtnList=array();
			$regex="/(\w+)=['|\"](.*?)['|\"]\s{0,}\n{0,}/i";
			if (preg_match_all($regex,$content,$matches))
			{
				foreach ($matches[1] as $key=>$var)
				{
					$rtnList[$matches[1][$key]]=$matches[2][$key];
				}
			}
			return $rtnList;
		}
		catch (Exception $e)
		{
			throw $e;
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
			$iftag="/\<pp\:display\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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
			$iftag="/\<display\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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