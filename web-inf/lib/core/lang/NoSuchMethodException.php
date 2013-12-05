<?php
/**
 * 没有发现方法异常
 *
 */
class NoSuchMethodException extends Exception
{
	function NoSuchMethodException($message,$code=0)
	{
		parent::__construct($message,$code);
	}
}
?>