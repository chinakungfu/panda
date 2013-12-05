<?
import('core.tpl.TplTemplate');
import('core.tpl.TplRun');
import('core.ajax.AjaxService');

global $IN;
//防止传入全局变量
isset($_REQUEST['GLOBALS']) && exit('Access Error');
$IN=oas_parse_incoming();
define('NOW_TIME',time());
loadDS(); //判断是否加载数据源
if (array_key_exists('ajax',$IN)||array_key_exists('phprpc_args',$IN)) //进行ajax调用
{
	$controller=new Controller('ajax');
	$controller->ajaxCall();
}
function ajaxCall()
{
	try
	{

		$ajax = new AjaxService();
		echo $ajax->handleRequest();
		exit();

	}
	catch (Exception $e)
	{
		echo "erros :".$e->getMessage();

	}
}
?>