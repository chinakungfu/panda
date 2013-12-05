<?php
/**
 * 处理CMS标签类
 * <CMS action="SQL" return="List" query="select * from Table" />
 */
import('core.tags.ParentTag');
class CMS_TAG extends ParentTag 
{
	/**
	 * 处理标签，并将替换的内容返回
	 * @param unknown_type $val
	 */
	public function processTag($val)
	{
		try 
		{
			$patt = "/<CMS[\s]+([^\n]*)[\/]>/iU";
			if (preg_match_all($patt,$val,$match))
			{
				foreach ($match[1] as $key=>$var)
				{
					$params = CMS_TAG::processParameter($match[1][$key]);
					$include_tpl = "";
					if (isset($params['tpl']))
					{
						$include_tpl = "\r\n<include file=\"".$params['tpl']."\" />\r\n";
						unset($params['tpl']);
					}
					$paramesStr = CMS_TAG::vars_export($params) ;
					$replace ="<?php\r\n import('core.apprun.cmsware.CmswareNode'); \r\n import('core.apprun.cmsware.CmswareRun'); global \$PageInfo,\$params; \r\n \$params = $paramesStr\r\n\$this->_tpl_vars['{$params['return']}'] = CMS::CMS_{$params['action']}(\$params); \r\n    \$this->_tpl_vars['PageInfo'] = &\$PageInfo;  \r\n?>".$include_tpl;
					$val = parent::replaceTags($match[0][$key],$replace,$val);
				}
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
		return $val;
	}
	/* *
	* 处理标签的缩写
	*
	* @param unknown_type $val
	*
	* */
	public function processShortTag($val)
	{
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

	}
	/**
	 * 处理参数
	 *
	 * @param unknown_type $mTplCore
	 * @return unknown
	 */
	public static function processParameter($mTplCore)
	{
		try 
		{
			$patt = "/([a-zA-Z0-9_]+)=[\"]([^\"]+)[\"]/isU";
			if (preg_match_all($patt,$mTplCore,$mecths))
			{
				foreach ($mecths[0] as $key=>$var)
				{
					$output[strtolower($mecths[1][$key])] = $mecths[2][$key];
				}
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
		return $output;
	}
	/**
	 * 处理参数成字符
	 *
	 * @param unknown_type $params
	 * @return unknown
	 */
	public static function vars_export($params) 
	{	
		$return = "array ( \r\n";
		foreach($params as $key=>$var) {
			$return .= "	'{$key}' => \"{$var}\",\r\n";	
		}
		$return .= " ); \r\n";
		return $return;
	}
}

?>