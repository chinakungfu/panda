<?php
/**
 * <loop name="ContentList" key="key" var="var"><loop name="ContentList" var="var" key="key"></pp:loop></loop>'
 */
import('core.tags.ParentTag');
class LoopTag extends ParentTag
{
	/**
	 * 处理标签，并将替换的内容返回
	 *
	 * @param unknown_type $val
	 */
	public function processShortTag($val)
	{
		$reg='/\<loop\s*?\n?name\=[\|"](.*?)[\|"]\s*?\n?var\=[\'|"](.*?)[\'|"]\s*?\n?key\=[\'|"](.*?)[\'|"]\s*?\n?\>/i';
		$sourceText;
		$repalceText;
		if (preg_match_all($reg, $val, $matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$arrayName=$this->generateArrayName($matches[1][$key]);
				$str = '<?php if(!empty('.$arrayName.")){ \n foreach (".$arrayName.' as $this->_tpl_vars[\''.$matches[3][$key].'\']=>$this->_tpl_vars[\''.$matches[2][$key]."']){ ?>";
				$val = parent::replaceTags($var , $str, $val);
			}
		}
		//处理endloop
		$reg="/\<\/loop\>/siU";
		if (preg_match_all($reg, $val, $matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$data = "<?php  }\n} ?>";
				$val=parent::replaceTags($var ,$data, $val);
			}
		}
		return $val;
	}

	/**
 * 处理标签的缩写
 *
 * @param unknown_type $val
 */
	public function processTag($val)
	{
		$reg='/\<pp:loop\s*?\n?name\=[\|"](.*?)[\|"]\s*?\n?var\=[\'|"](.*?)[\'|"]\s*?\n?key\=[\'|"](.*?)[\'|"]\s*?\n?\>/i';
		$sourceText;
		$repalceText;
		if (preg_match_all($reg, $val, $matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$arrayName=$this->generateArrayName($matches[1][$key]);
				$str = '<?php if(!empty('.$arrayName.")){ \n foreach (".$arrayName.' as $this->_tpl_vars[\''.$matches[3][$key].'\']=>$this->_tpl_vars[\''.$matches[2][$key]."']){ ?>";
				$val = parent::replaceTags($var , $str, $val);
			}
		}
		//处理endloop
		$reg="/\<\/pp:loop\>/siU";
		if (preg_match_all($reg, $val, $matches))
		{
			foreach($matches[0] as $key=>$var)
			{
				$data = "<?php  }\n} ?>";
				$val=parent::replaceTags($var ,$data, $val);
			}
		}
		return $val;
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
			$iftag='/\<pp:loop\s*?\n?name\=[\|"](.*?)[\|"]\s*?\n?var\=[\'|"](.*?)[\'|"]\s*?\n?key\=[\'|"](.*?)[\'|"]\s*?\n?\>/i';
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
			$iftag='/\<loop\s*?\n?name\=[\|"](.*?)[\|"]\s*?\n?var\=[\'|"](.*?)[\'|"]\s*?\n?key\=[\'|"](.*?)[\'|"]\s*?\n?\>/i';
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
	/**
	 * 根据变量名称来取模板变量
	 *
	 * @param unknown_type $arrayName
	 */
	protected function generateArrayName($arrayName)
	{
		try
		{
			$text="";
			//echo $arrayName.substr($arrayName,0,1);
			if (substr($arrayName,0,1)!="{")//说明没有使用替换，需要进行处理
			{
				if (strpos($arrayName,'.'))
				{
					$data=explode('.',$arrayName);
					foreach ($data as $key=>$var)
					{

						//如果后面的有宏替换出现则进行特殊处理
						$reg="/".preg_quote($GLOBALS['currentApp']['varprefix'])."[a-zA-Z0-9\_\$\>\-\[\]\'\{\}\"\+\-\*\/]*".preg_quote($GLOBALS['currentApp']['varprefix'])."/i";
						//存在宏替换内容需要进行宏替换
						if (preg_match_all($reg,$var,$matches))
						{
							$text.="[".$var."]";
						}
						else //不需要进行宏替换
						{
							$text.="[\"".$var."\"]";
						}

					}
				}
				else
				{
					$text = "['".$arrayName."']";
				}
				return "\$this->_tpl_vars".$text;

			}
			else
			{
				return $arrayName;
			}

		}
		catch (Exception $e)
		{
			throw $e;
		}

	}

}
?>