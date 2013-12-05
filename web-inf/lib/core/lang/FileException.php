<?php
/**
 * 文件处理异常类
 *
 */
class FileException extends Exception
{
	function FileException($message,$code=0)
	{
		parent::__construct($message,$code);
	}
}
?>