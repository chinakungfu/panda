<?php
/**
 * 持久对象标签
 * <pp:persist name="name" class="TestAjax" file="./test" ds="dsid" dao="$dao" connection="connnection" action="insert" return="dddd"/>
 */
import('core.tags.ParentTag');


class PersistTag extends ParentTag
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
			$regex="/\<pp\:persist\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
			if (preg_match_all($regex,$val,$matches))
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
	 * 生成的替换的php代码
	 *
	 * @param unknown_type $list
	 */
	protected function generateReplace($list)
	{
		$content="";
		$name="";
		$className="";
		try
		{
			if (is_array($list))
			{
				$content.="<?php \n";
				$content.="import('core.datasource.persist.PersistDao');\n";
				$content.="import('core.datasource.DataAccess');\n";
				if (array_key_exists('file',$list))
				{
					$content.="require_once('\$GLOBALS['currentApp']['apppath']".$list['file']."');\n";
				}
				if (array_key_exists('name',$list)&&array_key_exists('class',$list))
				{
					$content.="$".$list['name']."=new ".$list['class']."(".");\n";
					$className=$list['class'];
					$name="$".$list['name'];
				}
				else
				{
					throw new Exception('persist tag declare exception',434);
				}
				$content.='$persistPropertys='.$name."->getPersistPropertys('".$list['class']."');\n";
				$content.='  foreach ($persistPropertys as $key=>$var){'."\n";
				$content.=' if (isset($GLOBALS[\'IN\'][$var])){'."\n";
				$content.='$method='.$name."->getWriteMethod(".$name.',$var);'."\n";
				
				$content.=$name."->invokeMethod(".$name.',$method,array($GLOBALS[\'IN\'][$var]));'."\n";
				$content.="}\n";
				$content.="}\n";
				$dao="";
				if (array_key_exists('dao',$list))
				{
					$dao=$list['dao'];
				}
				else
				{
					$dao='$persistDao';
					if (array_key_exists('connection',$list))
					{
						$content.=$dao."=new PersistDao(".$list['connection'].");\n";
					}
					else
					{

						$content.='$dbconfig=$GLOBALS[\'currentApp\'][\'dsconfig\'];'."\n";
						$content.='$dataAccess=DBFactory::getDataAccess($dbconfig);'."\n";
						$content.=$dao.'=new PersistDao($dataAccess);'."\n";
					}
				}
				if (array_key_exists('action',$list))
				{
					if ($list['action']=='findByCause') //根据条件来查询
					{
						$cause="";
						if (array_key_exists('wherecause',$list))
						{
							$cause=$list['wherecause'];
						}
						if (array_key_exists('return',$list))
						{
							$content.="$".$list['return']."=".$dao."->".$list['action']."(".$name.",'".$cause."');\n";
						}
						else
						{
							$content.=$dao."->".$list['action']."(".$name.",'".$cause."');\n";
						}


					}
					else
					{
						if (array_key_exists('return',$list))
						{
							$content.="$".$list['return']."=".$dao."->".$list['action']."(".$name.");\n";
						}
						else
						{
							$content.=$dao."->".$list['action']."(".$name.");\n";
						}
					}
				}
				$content.="?>";
				return $content;
			}
			else
			{
				throw new Exception('query tag not setting exception',422);
			}
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
			$regex="/\<pp\:persist\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
			if (preg_match_all($regex,$val,$matches))
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
			$iftag="/\<pp\:persist\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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
			$iftag="/\<pp\:persist\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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