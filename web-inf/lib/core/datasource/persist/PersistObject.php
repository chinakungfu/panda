<?php
import('core.lang.Object');
abstract class PersistObject extends Object
{
	var $sqlinsert; //插入数据的SQL语句
	var $sqlupdate;////修改数据SQL语句
	var $sqldelete;//删除数据的SQL语句
	var $sqlselect;//查询的SQL语句
	var $sqlprimarykey;//主键关键Id，字段名称以，分割
	var $sqlref;//外键关键Id，字段名称以，分割
	public function getSQLInsert()
	{
		return $this->sqlinsert;
	}
	public function getSQLupdate()
	{
		return $this->sqlupdate;
	}
	public function getSQLdelete()
	{
		return $this->sqldelete;
	}
	public function getSQLselect()
	{
		return $this->sqlselect;
	}
	/**
	  *取表的关键字，返回数组
	  *
	  */
	public function getSQLPrimaryKey()
	{
		return explode(',',$this->sqlprimarykey);
	}
	/**
	  * 取对象的外键，返回数组
	  *
	  */
	public function getSQLref()
	{
		return explode(',',$this->sqlref);
	}
	public function setSQLInsert($statement)
	{
		$this->sqlinsert=$statement;
	}
	public function setSQLupdate($statement)
	{
		$this->sqlupdate=$statement;
	}
	public function setSQLdelete($statement)
	{
		$this->sqldelete=$statement;
	}
	public function setSQLselect($statement)
	{
		$this->sqlselect=$statement;
	}
	public function setSQLPrimaryKey($statement)
	{
		$this->sqlprimarykey=$statement;
	}
	public function setSQLref($statement)
	{
		$this->sqlref=$statement;
	}	
}
?>