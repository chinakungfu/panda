<?php
/**
 * <pp:connection name="connection1" ds="testmysql"/>
 */
import('core.tags.ParentTag');
class Connection extends ParentTag
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
			$reg="/\<pp\:connection\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?ds\=['|\"](.*?)['|\"]\/>/i";
			if (preg_match_all($reg,$val,$matches))
			{
				foreach ($matches[1] as $key=>$var)
				{
					$replace="";
	
					$replace.="<?php\n import('core.datasource.DataAccess');\n";
					$replace.="import('core.datasource.DbFactory');\n";
					$replace.="$".$matches[1][$key]."=DBFactory::getDataAccessByDsId('".$matches[2][$key]."');\n";
					$replace.="?>\n";
					$val=parent::replaceTags($matches[0][$key],$replace,$val);
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
		try
		{
			$reg="/\<connection\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?ds\=['|\"](.*?)['|\"]\/>/i";
			if (preg_match_all($reg,$val,$matches))
			{
				foreach ($matches[1] as $key=>$var)
				{
					$replace="";
					//$dbconfig=$this->getConnectionConfig($matches[2][$key]);
					$replace.="<?php\n import('core.datasource.DataAccess');\n";
					$replace.="import('core.datasource.DbFactory');\n";
					$replace.="$".$matches[1][$key]."=DBFactory::getDataAccessByDsId('".$matches[2][$key]."');\n";
					$replace.="?>\n";
					$val=parent::replaceTags($matches[0][$key],$replace,$val);
				}

			}
			return $val;
		}
		catch (Exception $e)
		{
			throw $e;
		}


	}
	//根据dsid从全局变量中取数据链接的配置信息
	public function getConnectionConfig($id)
	{
		try
		{
			$dsconfig=$GLOBALS['currentApp']['dsconfig'];
			if (is_array($dsconfig))
			{
				if (array_key_exists($id,$dsconfig))
				{
					return $dsconfig[$id];
				}
				else
				{
					throw new Exception('datasource config not id find exception',444);
				}
			}
			else
			{
				throw new Exception('get connection config exception',444);
			}
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
			$iftag="/\<pp\:connection\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?ds\=['|\"](.*?)['|\"]\/>/i";
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
			$iftag="/\<connection\s*?\n?name\=['|\"](.*?)['|\"]\s*?\n?ds\=['|\"](.*?)['|\"]\/>/i";
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