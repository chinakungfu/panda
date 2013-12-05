<?php
import('core.lang.Object');
class HashMap extends Object
{
	/**
	 * @var array
	 * @access private
	 */
	var $_entries;

	function HashMap($map = array())
	{
		$this->_entries = $map;
	}

	function clear()
	{
		$this->entries = array();
	}

	function contains($value)
	{
		return in_array($value, $this->_entries);
	}

	function containsKey($key)
	{
		return array_key_exists($key, $this->_entries);
	}

	function elements()
	{
		return array_values($this->_entries);
	}

	function &get($key)
	{
		if (!array_key_exists($key, $this->_entries))
		{
			$nil = ref(null);
			return $nil;
		}

		return $this->_entries[$key];
	}

	function isEmpty()
	{
		return count($this->_entries) == 0;
	}

	function keys()
	{
		return array_keys($this->_entries);
	}

	// NOTE: be sure to note, not putting by reference!!
	function put($name, $value)
	{
		$this->_entries[$name] = $value;
	}

	function remove($name)
	{
		if (array_key_exists($name, $this->_entries))
		{
			unset($this->_entries[$name]);
		}
	}

	function size()
	{
		return count($this->_entries);
	}
}
?>
