<?php
import('core.util.io.Reader');
import('core.util.io.FileLock');
import('core.lang.FileException');
/**
 * 读文件类
 *
 */
class FileReader extends Reader
{
	var $_filePath = null;

	/**
	 * @throws FileNotFoundException
	 */
	function FileReader(&$file)
	{
		try {
			if (is_resource($file))
			{
				$this->_handle =& $file;
			}
			elseif (is_object($file) && $file->getPhpClassName() == 'File')
			{
				$this->_filePath = $file->getPath();
				$this->_handle = @fopen($this->_filePath, 'rb');
			}
			else
			{
				$this->_filePath = $file;
				$this->_handle = @fopen($this->_filePath, 'rb');
			}

			if (!$this->_handle)
			{
				throw new FileException('File could not be found \'' . $file . '\'');
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	/**
	 * Lock the file using a shared lock (since the operation is read)
	 *
	 * @param boolean $shared Whether the lock should be shared
	 * @param boolean $blocking Whether or not to block operations natively
	 */
	function &lock($shared = true, $blocking = false)
	{
		$lock =& new FileLock($this->_handle, $shared, $blocking);
		if (!$lock->isValid())
		{
			return ref(null);
		}

		return $lock;
	}

	/**
	 * Reads up to len bytes of data from the file pointer into a string
	 * reference An attempt is made to read as many as len bytes, but a smaller
	 * number may be read, possibly zero (if end of file). The number of bytes
	 * actually read is returned as an integer.  The offset is the position in
	 * the buffer string which the characters should be stored.
	 */
	function read(&$buffer, $offset = 0, $len = -1)
	{
		try {
			$pos = ftell($this->_handle);

			if ($len == 0)
			{
				return 0;
			}
			// @todo make sure the file is not locked too
			elseif ($len == -1 && $pos == 0 && !is_null($this->_filePath))
			{
				$data = file_get_contents($this->_filePath);
				@fseek($this->_handle, 0, SEEK_END);
			}
			elseif ($len == 1)
			{
				$data = fgetc($this->_handle);
			}
			else
			{
				$data = fread($this->_handle, $len);
			}

			$dataSize = strlen($data);
			if ($dataSize == 0)
			{
				return -1;
			}
			elseif ($offset == 0)
			{
				$buffer = $data;
			}
			else
			{
				$buffer = substr($buffer, 0, $offset) . $data . substr($buffer, $dataSize + 1);
			}

			return $dataSize;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	function readChar()
	{
		try {
			$char = fgetc($this->_handle);
			return $char === false ? -1 : ord($char);
		}
		catch (Exception $e)
		{
			throw new FileException($e->getMessage(),$e->getCode());
		}
	}

	function skip($len)
	{
		try{
			$data = fread($this->_handle, $len);
			return strlen($data);
		}
		catch (Exception $e)
		{
			throw new FileException($e->getMessage(),$e->getCode());
		}
	}

	function mark()
	{
		$this->_mark = ftell($this->_handle);
	}

	function ready()
	{
		if (!$this->_handle || feof($this->_handle))
		{
			return false;
		}

		return true;
	}

	function reset()
	{
		try
		{
			fseek($this->_handle, $this->_mark);
		}
		catch (Exception $e)
		{
			throw new FileException($e->getMessage(),$e->getCode());
		}
	}

	/**
	 * Closes this file input stream and releases any system resources associated with the stream.
	 *
	 * @return void
	 * @throws IOException
	 */
	function close()
	{
		if ($this->_handle)
		{
			if (!@fclose($this->_handle))
			{
				// throw_exception(new IOException());
			}
		}
	}
}
?>