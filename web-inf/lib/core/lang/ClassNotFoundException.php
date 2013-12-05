<?php
/**
 * 类没有查找到异常
 *
 */
class ClassNotFoundException extends Exception 
{
	function ClassNotFoundException($message,$code=0)
	{
		parent::__construct($message,$code);
	}
}
?>