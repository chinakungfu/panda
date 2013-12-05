<?php
/**
 *  <pp:query name="query1" type="page" statement="select * from dyn_app" connection="" ds="" currentpage="" pagesize="" return="dddd"/>
 */
import('core.tags.ParentTag');
class TQueryTag extends ParentTag
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
			$reg="/\<pp\:query\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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
	 * 生成替换字符串
	 *
	 * @param unknown_type $list
	 * @return unknown
	 */
	protected function generateReplace($list)
	{
		$content="";
		$name="";
		try
		{
			if (is_array($list))
			{
				$content.="<?php \n";
				$content.="import('core.datasource.TQuery');\n";
				if (array_key_exists('name',$list))
				{
					$name="$".$list['name'];
					$content.=$name."= new TQuery();\n";
				}
				foreach ($list as $key=>$var)
				{
					if ($key=="name") continue;
					if ($key=="return") continue;
					$content.=$name."->".$key."='".$var."';\n";
				}
				if (array_key_exists('return',$list))
				{
					$content.="$".$list['return']."=".$name."->execute();\n";
				}
				$content.="unset(".$name.");\n";
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
 * 处理标签的缩写
 *
 * @param unknown_type $val
 */
	public function processShortTag($val)
	{
		try
		{
			$reg="/\<query\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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
			$iftag="/\<pp\:query\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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
			$iftag="/\<query\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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