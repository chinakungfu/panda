<?php
/**
 * 参数列表数据对象
 */
class extendedParameterList
{
	var $arrayList;
	function __construct()
	{
		$this->arrayList=array();
	}
	/**
	 * 添加参数到参数列表
	 *
	 * @param unknown_type $parameter
	 * @return unknown
	 */
	function add($parameter)
	{
		if (array_push($this->arrayList,$parameter))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/**
	 * 计算参数的总数
	 *
	 * @return unknown
	 */
	function length(){
		return count($this->arrayList);
	}
	/**
	 *判断参数列表是否为空
	 *
	 * @return unknown
	 */
	function isEmpty(){
		if( count($this->arrayList) == 0 )
		return true;
		else
		return false;
	}
	/**
	 * 是否已经包含该参数
	 *
	 * @param unknown_type $object
	 * @return unknown
	 */
	function contains($object){
		for($i = 0; $i < count($this->arrayList); $i++){
			if($this->arraylist[$i] == $object)
			return true;
		}
		return false;
	}
	/**
	 *根据索引来取对象
	 *
	 * @param unknown_type $index
	 * @return unknown
	 */
	function get($index){
		if($index >= count($this->arrayList) || $index < 0){
			echo "index out of bounds";
			return;
		}
		return $this->arrayList[$index];
	}
	/*
	计算一个参数对象的索引
	*/
	function indexOf($object){
		for($i = 0; $i < count($this->arrayList); $i++){
			if($this->arrayList[$i] == $object)
			return $i;
		}
		return -1;
	}
	/**
	 * 最后一次出现的索引值
	 *
	 * @param unknown_type $object
	 * @return unknown
	 */
	function lastIndexOf($object){
		for(($i = $this->size() - 1),$j = 0;$i >= 0; $i--,$j++){
			if($object == $this->arrayList[$i])
			return  $j;
		}
		return -1;
	}
	/**
	 * 转换到参数列表到数组
	 *
	 * @return unknown
	 */
	function toArray(){
		return $this->arrayList;
	}
	/**
	 * 清空参数列表
	 *
	 */
	function clear(){
		$this->arrayList = null;
		$this->arrayList = array();
	}
	/**
	 * 输出参数列表
	 *
	 */
	function printParameterList(){
		print_r($this->arrayList);
	}
}
?>