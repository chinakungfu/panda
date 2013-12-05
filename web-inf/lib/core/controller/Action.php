<?php
/**
 * 系统集中控制器
 */
import('core.tpl.TplTemplate');
import('core.tpl.TplRun');
class Action
{
	/**
	 * 控制器的构造事件
	 * 加载控制器的一些初始化信息	 *
	 */
	var $request;//处理以后的请求对象
	var $request_backup;//请求对象的备份
	var $source_tplName;//原始的模板文件名称
	var $compile_tplName;//编译以后的模板文件名称
	var $language;//使用的语言
	var $auth;//是否需要权限验证
	//执行模板流程
	/**public function execute($actionId,$moduleId,$tplId,)
	{
		
	}*/
	public function executeTpl($tplId,$cache=false,$cachePath='')
	{
		
	}
	
	
}
?>