<?php


import('core.util.io.FileLock');
import('core.util.io.Writer');
import('core.lang.FileException');

/**
 * @package  写文件类
 * @access public
 */
class FileWriter extends Writer
{
	function FileWriter(&$file, $append = false)
	{
		try {
			if ($append)
			{
				$mode = 'a';
			}
			else
			{
				$mode = 'w';
			}

			// try {
			if (is_resource($file))
			{
				$this->_handle =& $file;
			}
			elseif (is_object($file) && is_a($file, 'File'))
			{
				$path = $file->getPath();
				$this->_handle = fopen($path, $mode);
			}
			else
			{
				$this->_handle = fopen($file, $mode);
			}

		}
		catch (Exception $e)
		{
			throw new FileException($e->getMessage(),$e->getCode());
		}
		// }
	}

	/**
	 * Lock the file using an exclusive lock (since the operation is write)
	 *
	 * @param boolean $blocking Whether or not to block operations natively
	 */
	function &lock($blocking = true)
	{
		$lock =& new FileLock($this->_handle, false, $blocking);
		if (!$lock->isValid())
		{
			return ref(null);
		}

		return $lock;
	}

	// @todo implement offset and length
	function write($data, $offset = 0, $length = null)
	{
		fwrite($this->_handle, $data);
	}

	function ready()
	{
		return $this->_handle ? true : false;
	}

	/**
	 * Truncate the file to 0 length.
	 * This method is provided so that a FileWriter can be created
	 * and then locked before the file is truncated.
	 */
	function truncate()
	{
		ftruncate($this->_handle, 0);
	}

	function close()
	{
		@fclose($this->_handle);
		$this->_handle = null;
	}
}
?>