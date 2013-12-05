<?php
/**
 * 用户自定义标签父类
 */

	$shorttag; //短标签的正则
	$tag;//标签的正则
	$a;
	$b;
import("core.tags.ParentTag");
class UserParentTag extends ParentTag
{
	public $shorttag; //短标签的正则
	public $tag;//标签的正则
	public $replaceText;//需要替换的字符串
	public $replaceFileName;//替换内容的文件名称


}
?>


