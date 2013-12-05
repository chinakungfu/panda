<?php
/**
 * 文件读
 * @author Dan Allen
 */
import('core.lang.Object');
class Reader extends Object 
{
	var $_handle = null;

	var $_mark = 0;

	/**
	 * Read a set number of characters into the buffer
	 */
	function read(&$buffer, $offset = 0, $length = null) {}

	/**
	 * Read a single character in the stream
	 */
	function readChar() {}

	/**
	 * Close the stream
	 */
	function close() {}

	/**
	 * Skip a certain number of characters
	 */
	function skip($length) {}

	/**
	 * Mark the present position in the stream
	 */
	function mark() {}

	/**
	 * Reset the stream
	 */
	function reset() {}

	/**
	 * Tell whether the stream is ready to be read
	 */
	function ready() {}
}
?>
