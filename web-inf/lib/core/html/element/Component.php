<?php
/**
 * 所有HTML组件的父类
 *
 */
import('core.ajax.AjaxService');
abstract class Component
{
	var $allregex;//正则表达式
	var $content;//模板的内容
	var $jscontent;//生成的js文本
	var $includecontent;//生成包含的php文本
	public function setAllregex($allregex)
	{
		$this->allregex=$allregex;
	}
	public function getAllregex()
	{
		return $this->allregex;
	}
	/**
	 * 处理模板文件内容，替换模板中对应额HTML标签内容
	 * 返回替换以后的模板内容
	 * @param unknown_type $fileContent
	 */
	public function process($contentarray)
	{
		if (is_array($contentarray))
		{
			if (array_key_exists('content',$contentarray))
			{
				$this->content=$contentarray['content'];
			}
			else
			{
				$this->content="";
			}
			if (array_key_exists('jscontent',$contentarray))
			{
				$this->jscontent=$contentarray['jscontent'];
			}
			else
			{
				$this->jscontent="";
			}
			if (array_key_exists('include',$contentarray))
			{
				$this->includecontent=$contentarray['include'];
			}
			else
			{
				$this->includecontent="";
			}
		}
		else
		{
			$this->content=$contentarray;
			$this->jscontent="";
			$this->includecontent="";
		}
		preg_match_all($this->allregex,$this->content,$matches); //匹配模板中的所有按钮
		$count=count($matches[0]);
		for ($i=0;$i<$count;$i++)
		{
			$rtnList=$this->processProperty($matches[0][$i]); //分解按钮的属性
			$allValue=$this->generateHtmls($rtnList);
			$this->content=$this->replaceTags($matches[0][$i],$allValue['html'],$this->content);//生成标准的Html标签，同时替换模板中的声明
			$this->jscontent.=$allValue['js'];
			$this->includecontent.=$allValue['include'];
		}
		return array('content'=>$this->content,'jscontent'=>$this->jscontent,'include'=>$this->includecontent);
	}

	/**
    * 分解函数
    * functionType:javascript javascript的函数
    *              php     php函数
    * method :normal   正常提交
    *         ajax     异步调用方法   
    * args  : 该函数的参数列表
    * functionName:函数的名称
    * className   :类函数的名称
    * 函数调用样式  
    * php:method:className.functionName(arg1,arg2,arg3)
    * @param unknown_type $property
    * 返回类型数组
    */
	public function processEvent($property)
	{
		list($type,$service,$value) =split(":",$property);
		$funcid=null;
		$params=null;
		preg_match('/\w*/i',$value,$mathes);
		$funcid=$mathes[0];
		$params=str_replace($mathes[0],'',$value);
		$params=substr($params,1);
		if (strlen($params)>=1)
		{
			$params=substr($params,0,strlen($params)-1);
		}
		else
		{
			$params="";
		}
		$parameterList=split(",",$params);
		return array('type'=>$type,'service'=>$service,'id'=>$funcid,
		'args'=>$parameterList);
	}
	/**
	 * 生成js的函数调用
	 *
	 * @param unknown_type $eventList
	 */
	public function generateJsFunction($eventList)
	{
		$content="";
		$name='call_'.$eventList['service'].'_'.$eventList['id'];
		$js=null;
		if ($eventList['type']=='func') //函数调运的生成
		{
			$js=" function $name()\n{\n"." ajax.callFunction('".$eventList['service'].
			"','".$eventList['id']."',$name.arguments \n}\n";


		}
		elseif ($eventList['type']=='cls') //生成类方法的调用过程
		{
			$js=" function $name()\n{\n"." ajax.callMethod('".$eventList['service'].
			"','".$eventList['id']."',$name.arguments \n}\n";
		}
		else//模板调用
		{
			$js=" function $name()\n{\n"." ajax.callTpl('".$eventList['service'].
			"','".$eventList['id']."',$name.arguments \n}\n";
		}
		$callvalue="$name(";
		$paramscount=count($eventList["args"]);
		for ($j=0;$j<$paramscount;$j++) //构建事件的参数
		{
			if ($j==0)
			{
				$callvalue.=$eventList["args"][$j];
			}
			else
			{
				$callvalue.=",".$eventList["args"][$j];
			}
		}
		$callvalue.=");";
		return array ('jsfunc'=>$js,'call'=>$callvalue);
	}

	/**
	 * 取Html组件的属性
	 * 其中“和空格必须是处理过的，返回String类型
	 *
	 * @param unknown_type $property
	 */
	public function getPropertyValue($property)
	{
		$regex="/(\w+)\=/i";
		return preg_replace($regex,"",$property);
	}
	/**
	 * 生成Html的内容
	 *
	 * @param unknown_type $arrayList
	 */
	public abstract  function generateHtmls($arrayList);
	/**
	 * 分解模板中定义的属性
	 *
	 * @param unknown_type $content
	 */
	public abstract function processProperty($content);

	/**
	 * 替换原来的标签
	 *
	 * @param unknown_type $tags
	 * @param unknown_type $aims
	 */
	public function replaceTags($tags,$aims,$content)
	{
		return str_ireplace($tags,$aims,$content);
	}

}
?>