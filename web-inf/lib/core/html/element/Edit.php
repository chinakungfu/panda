<?php
import('core.html.element.Component');
class Edit extends Component
{
	var $allregex="/<(html)\:(edit)\s*\n*?(\w+(=('|\").*?('|\")\s{0,}\n{0,}))*\n*?>.*?\n*?</(html)\:(edit)>/i";
	
	/**
	 * 分解输入框的声明的属性，
	 *
	 * @param unknown_type $content
	 */
	public function processProperty($content)
	{

	}
	public function generateHtmls($arrayList)
	{

	}

	
}
?>