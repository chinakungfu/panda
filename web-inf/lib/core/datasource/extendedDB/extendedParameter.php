<?php
class extendedParameter
{
	var $name;//参数名称
	var $size ;//参数长度；
	var $type;//参数类型
	var $value;//参数的值ֵ
	public function setName($name)
	{
		$this->name=$name;
	}
	public function setSize($size)
	{
		$this->size=$size;
	}
	public function setType($type)
	{
		$this->type=$type;
	}
	public function setValue($value)
	{
		$this->value=$value;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getType()
	{
		return $this->type;
	}
	public function getSize()
	{
		return $this->size;
	}
	public function getValue()
	{
		return $this->value;
	}


}
?>