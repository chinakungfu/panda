<?php
/**
 * 使用openid登陆的标签
 * 
 *
 */
import('core.tags.ParentTag');
class OpenIdTag extends ParentTag
{
	/**
	 * 处理标签，并将替换的内容返回
	 *
	 * @param unknown_type $val
	 */
	public function processTag($val)
	{
		try {
			$reg="/\<pp:login\s*?\n?((\w+)\=['|\"](.*?)['|\"]\s{0,}\n{0,})*\/>/i";
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
 * 处理标签的缩写
 *
 * @param unknown_type $val
 */
	public function processShortTag($val)
	{
		return $val;
	}
	public function generateReplace($list)
	{
		//<pp:login type="openid" scuess="" failure=""/>
		$content="";
		$scuess="";
		$failure="";
		try
		{
			if (is_array($list))
			{
				$content.="<?php \n";
				$content.="include_package('core.easyopenid.openidutils');\n";
				if (array_key_exists('type',$list))
				{
						
				}
				if (array_key_exists('scuess',$list))//返回成功页面
				{
					
				}
				if (array_key_exists('failure',$list))
				{
					
				}
				

			}

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
		return false;

	}
}
?>