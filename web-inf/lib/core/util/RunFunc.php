<?php
/*
**************
**************
**************
**************
//$pamams为数组
modify 2008-03-26
*/
function runFunc($funcId,$params=null)
{
	try
	{
		//print_r($params);exit;
		for($i=0;$i<count($params);$i++)
		{
				$data .= '$params['.$i.']'.",";
		}
		$data= substr($data,0,-1);		
		if (isset($GLOBALS['currentApp']['funcconfig']))
		{
			if (is_array($GLOBALS['currentApp']['funcconfig']))
			{
				//print $funcId;
				if (array_key_exists($funcId,$GLOBALS['currentApp']['funcconfig']))
				{
					$funset=$GLOBALS['currentApp']['funcconfig'][$funcId];
					
					$strCode="";//要执行的SQL语句
					if ($funset['type']=='php')//调用系统函数
					{
					   // include_once($funset['source']);
						$strCode=$funset['funcname'].'('.$data.')';	
						
						eval("\$rslt=".$strCode.";");
						return $rslt;
					}
					else //调用用户自定义函数
					{
						//加载原始文件
						include_once($funset['source']);
						$strCode=$funset['funcname'].'('.$data.')';
						//print $funset['source'];
						//print $strCode;exit;
						eval("\$rslt=".$strCode.";");
						return $rslt;
					}
				}
				else
				{
					throw new Exception('used function "'.$funcId.'" not set in funcconfig array Exception','330');
				}
			}
			else
			{
				throw new Exception('function "'.$funcId.'" set is not array exception','331');
			}
		}
		else
		{
			throw new Exception('"'.$funcId.'" is not function setting exception','333');
		}
	}
	catch (Exception $e)
	{
		throw $e;
	}

}
/**
 * 处理执行函数的参数问题
 *
 * @param unknown_type $declareParams
 * @param unknown_type $params
 */
function processFuncParams($declareParams,$params)
{
	try
	{
		if (!isset($declareParams))//声明的参数为空，说明没有参数
		{
			return "";
		}
		else
		{
			if (is_array($declareParams))//参数声明是数组，则处理处理数组成字符串
			{
				$rtn="";
				foreach ($declareParams as $key=>$value)
				{
					$paramName=$value['name'];
					$isRequired=$value['require'];
					$type=$value['type'];
					$paramValue="";
					if ($isRequired=='true')
					{
						if (!array_key_exists($paramName,$params))
						{
							throw new Exception('call function params not setting Exception',411);
						}
						else
						{
							if ($rtn=="")
							{
								$rtn =processParamsType($type,$params[$paramName]);
							}
							else
							{
								$rtn=$rtn.','.processParamsType($type,$params[$paramName]);
							}

						}
					}
					else
					{
						if (!array_key_exists($paramName,$params))
						{
							if ($rtn=='')
							{
								$rtn ='null';
							}
							else
							{
								$rtn=$rtn.',null';
							}
						}
						else
						{
							if ($rtn=="")
							{
								$rtn =processParamsType($type,$params[$paramName]);
							}
							else
							{
								$rtn=$rtn.','.processParamsType($type,$params[$paramName]);
							}

						}
					}
					return $rtn;


				}
			}
			else
			{
				return "";
			}

		}
	}
	catch (Exception $e)
	{
		throw $e;
	}

}
/**
 * 处理参数类型对应的值的引号问题
 * 如果不需要加引号，为I
 * 否则都需要加引号
 * 
 * @param unknown_type $type
 * @param unknown_type $value
 */
function processParamsType($type,$value)
{
	try
	{
		if ($type=='I')
		{
			return $value;
		}
		else
		{
			return '\''.$value.'\'';
		}
	}
	catch (Exception $e)
	{
		throw $e;
	}

}
?>