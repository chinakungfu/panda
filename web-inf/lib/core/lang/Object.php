<?php
/**
 * 系统中所有的类的父类
 *
 */
import('core.lang.NoSuchMethodException');
class Object
{
	// simulate clone() in a compatible way
	function makeCopy()
	{
		return $this;
	}

	function equals(&$o)
	{
		return $this === $o;
	}
	/**
	 * For whatever its worth, this method will return the PHP provided
	 * class name for an object.
	 */
	function getPhpClassName()
	{
		return get_class($this);
	}

	function hashCode()
	{
		return md5(serialize($this));
	}
	/**
	 * Give a string representation of the object.
	 *
	 * @return string
	 */
	function toString()
	{
		ob_start();
		var_dump($this);
		return ob_get_clean();
	}
	//返回类的所有方法
	function getMethods()
	{
		return get_class_methods($this);
	}
	/**
	 * 取类的所有的属性
	 *
	 */
	function getPropertys()
	{
		return get_class_vars(get_class($this));
	}
	function getPersistPropertys($className)
	{
		$array=array_keys(get_class_vars($className));
		return array_diff($array,array('sqlinsert','sqlupdate','sqldelete','sqlselect','sqlprimarykey','sqlref'));

	}
	/**
	 *  取类属性对应的属性的读数据方法
	 *
	 * @param unknown_type $bean
	 * @param unknown_type $property
	 * @return unknown
	 */
	function getReadMethod(&$bean, $property)
	{
		$method = 'get' . ucfirst($property);
		if (!method_exists($bean, $method))
		{
			$method = 'is' . ucfirst($property);
		}

		if (!method_exists($bean, $method))
		{
			$method = null;
		}
		return $method;
	}
	/**
	 * 读取数据bean的写数据方法
	 *
	 * @param unknown_type $bean
	 * @param unknown_type $property
	 * @return unknown
	 */
	function getWriteMethod(&$bean, $property)
	{
		$method = 'set' . ucfirst($property);
		return method_exists($bean, $method) ? $method : null;
	}
	/**
	 * 调用方法
	 *
	 * @param unknown_type $bean
	 * @param unknown_type $methodName
	 * @param unknown_type $args
	 * @return unknown
	 */
	function &invokeMethod(&$bean, $methodName, $args = array())
	{
		if (!method_exists($bean, $methodName))
		{
			throw new NoSuchMethodException('No method ' . $methodName . '() on class ' . get_class($bean));
			return;
		}

		// FIXME: catch an invocation exception here
		switch (count($args))
		{
			case 0:
				$return =& ref($bean->$methodName());
				break;

			case 1:
				$return =& ref($bean->$methodName($args[0]));
				break;

			default:
				$return =& ref(call_user_func_array(array(&$bean, $methodName), $args));
		}

		return $return;
	}


}
?>