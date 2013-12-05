<?php
/**
	 * 数据库异常处理类
	 */
class DBException extends Exception
{
	function DBException($message,$code = 0)
	{
		parent::__construct($message,$code);
	}
}
?>