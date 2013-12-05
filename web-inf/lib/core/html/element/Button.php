<?php
/**
 * 界面上的Button元素
 */
import('core.html.element.Component');
import('core.ajax.AjaxService');
class Button extends Component
{
	var $allregex="/<(html)\:(button)\s*\n*?(\w+(=('|\").*?('|\")\s{0,}\n{0,}))*\n*?>.*?\n*?<\/(html)\:(button)>/i";

	/**
	 *  处理单个按钮的替换字符生成,返回数组
	 * 分解属性
	 *
	 * @param unknown_type $content
	 */
	public function processProperty($content)
	{
		$rtnList=array();
		$rtnvalue="";
		$regex="/(\w+)=('|\").*?('|\")\s{0,}\n{0,}/i";
		preg_match_all($regex,$content,$matches);
		$count=count($matches[0]);
		for ($i=0;$i<$count;$i++)
		{
			$property=$matches[0][$i];
			$property=preg_replace("/\s*?/i","",$property);//替换行中的 空字符
			$property=preg_replace("/\"/i","",$property);
			preg_match('(\w+)',$property,$childMatches);
			if (strtolower($childMatches[0])=="type") //设置按钮属性
			{
				$rtnList["type"]=(parent::getPropertyValue($property));
			}
			elseif (strtolower($childMatches[0])=="name") //设置属性名称
			{
				$rtnList["name"]=(parent::getPropertyValue($property));
			}
			elseif (strtolower($childMatches[0])=="id") //设置属性Id
			{
				$rtnList["id"]=(parent::getPropertyValue($property));
			}
			elseif (strtolower($childMatches[0])=="styleclass") //设置样式属性
			{
				$rtnList["styleclass"]=(parent::getPropertyValue($property));
			}
			elseif (strtolower($childMatches[0])=="buttonclick") //设置按钮的php的ajaxClick事件
			{
				$rtnList["buttonclick"]=(parent::getPropertyValue($property));
			}
			elseif (strtolower($childMatches[0])=="buttonblur") //设置按钮的失去焦点事件
			{
				$rtnList["buttonblur"]=(parent::getPropertyValue($property));
			}
			elseif (strtolower($childMatches[0])=="caption") //设置按钮的名称
			{
				$rtnList["caption"]=(parent::getPropertyValue($property));
			}
			elseif (strtolower($childMatches[0])=="jsonclick") //设置按钮的javascript事件
			{
				$rtnList["jsonclick"]=(parent::getPropertyValue($property));
			}
			elseif (strtolower($childMatches[0])=="jsonblur") //设置按钮的失去javascript事件
			{
				$rtnList["jsonblur"]=(parent::getPropertyValue($property));
			}
		}
		return $rtnList;

	}
	/**
	 * 生成Html的内容
	 *
	 * @param unknown_type $arrayList
	 */
	public function generateHtmls($arrayList)
	{
		$js='';//处理过程中生成的js
		$rtnValue="<input ";
		$count=count($arrayList);
		if (array_key_exists("type",$arrayList))
		{
			$rtnValue.=" type=\"".$arrayList["type"]."\"";
		}
		else
		{
			$rtnValue.=" type=\"button\"";
		}
		if (array_key_exists("name",$arrayList))
		{
			$rtnValue.=" name=\"".$arrayList["name"]."\"";
		}
		if (array_key_exists("id",$arrayList))
		{
			$rtnValue.=" id=\"".$arrayList["id"]."\"";
		}
		if (array_key_exists("styleclass",$arrayList))
		{
			$rtnValue.=" class=\"".$arrayList["styleclass"]."\"";
		}
		if (array_key_exists("buttonclick",$arrayList))
		{
			$eventList=parent::processEvent($arrayList["buttonclick"]);
			$eventarray=null;
			$eventarray=parent::generateJsFunction($eventList);
			$rtnValue.=" onclick=\"".$eventarray['call']."\"";
			$js.=$eventarray['jsfunc'].'\n';
		}
		if (array_key_exists("buttonblur",$arrayList))
		{
			$eventList=parent::processEvent($arrayList["buttonblur"]);
			$eventarray=null;
			$eventarray=parent::generateJsFunction($eventList);
			$rtnValue.=" onblur=\"".$eventarray['call']."\"";
			$js.=$eventarray['jsfunc'].'\n';
		}
		if (array_key_exists("caption",$arrayList))
		{
			$rtnValue.=" value=\"".$arrayList["caption"]."\"></input>";
		}
		return array('html'=>$rtnValue,'js'=>$js,'include'=>'');
	}
	
}
?>