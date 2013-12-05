<?php
import('core.util.io.Reader');
class StringReader extends Reader
{
	var $pos = 0;
	var $length = null;

	function StringReader($string)
	{
		$this->handle = $string;
		$this->length = strlen($string);
	}

	function read(&$buffer, $offset = 0, $len = -1)
	{
		if ($len == 0)
		{
			return 0;
		}
		elseif ($len == -1)
		{
			$data = substr($this->handle, $this->pos);
		}
		else
		{
			$data = substr($this->handle, $this->pos, $len);
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

	function readChar()
	{
		$char = $this->handle{$this->pos++};
		return is_null($char) ? -1 : ord($char);
	}

	function mark()
	{
		$this->mark = $this->pos;
	}

	function close()
	{
		$this->handle = null;
	}

	function reset()
	{
		$this->pos = $this->mark;
	}

	function skip($length)
	{
		$this->pos += $length;
		if ($this->pos >= $this->length)
		{
			$length = $length - ($this->pos - $this->length);
			$this->pos = $this->length;
		}
		else
		{
			return $length;
		}
	}

	function ready()
	{
		if (is_null($this->handle) || $this->pos >= $this->length)
		{
			return false;
		}

		return true;
	}
}
?>
