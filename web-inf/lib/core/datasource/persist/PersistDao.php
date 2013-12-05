<?php
/**
 * 持久对象数据通用Dao
 */
import('core.datasource.Parameter');
import('core.datasource.ParameterList');
class PersistDao
{
	var $dataAccess;//数据访问接口
	public function PersistDao($dataAccess)
	{
		$this->dataAccess=$dataAccess;
	}

	/**
	 * 新增数据对象
	 *
	 * @param unknown_type $objs
	 */
	public function  insert($objs)
	{
		try {
			if ($objs==null)
			{
				throw new DBException('新增的数据对象为空异常！','800');
			}
			$statement=$objs->getSQLInsert();
			$paraList=new ParameterList();
			$propertyList=$objs->getPersistPropertys($objs->getPhpClassName());
			$count=count($propertyList);
			for ($i=0;$i<$count;$i++)
			{
				$para=new Parameter();
				$method=$objs->getReadMethod($objs,$propertyList[$i]);
				$para->setName($propertyList[$i]);
				$para->setSize(0);
				$para->setType('');
				$para->setValue($objs->invokeMethod($objs,$method));
				$paraList->add($para);
			}
			$this->dataAccess->executeNoReturn($statement,$paraList);
			$paraList=null;

		}
		catch (DBException $e)
		{
			throw new DBException('新增数据异常：'.$e->getMessage(),'800');
		}



	}
	/**
	 * 修改数据
	 *
	 * @param unknown_type $obj
	 */
	public function update($objs)
	{
		try {
			if ($objs==null)
			{
				throw new DBException('修改的数据对象为空异常','801');
			}
			$statement=$objs->getSQLupdate();
			$paraList=new ParameterList();
			$propertyList=$objs->getPersistPropertys($objs->getPhpClassName());
			$count=count($propertyList);
			for ($i=0;$i<$count;$i++)
			{
				$para=new Parameter();
				$method=$objs->getReadMethod($objs,$propertyList[$i]);
				$para->setName($propertyList[$i]);
				$para->setSize(0);
				$para->setType('');
				$para->setValue($objs->invokeMethod($objs,$method));
				$paraList->add($para);
			}
			$this->dataAccess->executeNoReturn($statement,$paraList);
			$paraList=null;
		}
		catch (DBException $e)
		{
			throw new DBException('修改数据异常：'.$e->getMessage(),'801');
		}

	}
	/**
	 * 删除数据
	 * 
	 * @param unknown_type $obj
	 */
	public function delete($objs)
	{
		try {
			if ($objs==null)
			{
				throw new DBException('删除的数据对象为空异常！','802');
			}
			$statement=$objs->getSQLdelete();
			$paraList=new ParameterList();
			$primaryList=$objs->getSQLPrimaryKey();
			$keyCount=count($primaryList);
			for ($j=0;$j<$keyCount;$j++)
			{
				$para=new Parameter();
				$method=$objs->getReadMethod($objs,$primaryList[$j]);
				$para->setName($primaryList[$j]);
				$para->setSize(0);
				$para->setType('');
				$para->setValue($objs->invokeMethod($objs,$method));
				$paraList->add($para);
			}
			$this->dataAccess->executeNoReturn($statement,$paraList);
			$paraList=null;
		}
		catch (DBException $e)
		{
			throw new DBException('删除数据异常：'.$e->getMessage(),'802');
		}
	}
	/**
	 * 根据主键查找对象的实例
	 * 返回对象
	 * @param unknown_type $obj
	 */
	public  function findByPrimaryKey($objs)
	{
		try {
			if ($objs==null)
			{
				throw new DBException('取对象实例的数据对象为空异常！','803');
			}
			$statement=$objs->getSQLselect();
			$paraList=new ParameterList();
			$primaryList=$objs->getSQLPrimaryKey();
			$keyCount=count($primaryList);
			for ($j=0;$j<$keyCount;$j++)
			{
				$whereCause=' and '.$primaryList[$j].'=:'.$primaryList[$j];
				$para=new Parameter();
				$method=$objs->getReadMethod($objs,$primaryList[$j]);
				$para->setName($primaryList[$j]);
				$para->setSize(0);
				$para->setType('');
				$para->setValue($objs->invokeMethod($objs,$method));
				$paraList->add($para);
			}
			$result=$this->dataAccess->executeWithReturn($statement.' where 1=1 '.$whereCause,$paraList);
			$paraList=null;
			if (count($result)==0)
			{
				return null;
			}
			else {
				print_r($result);
				$propertyList=$objs->getPersistPropertys($objs->getPhpClassName());
				$count=count($propertyList);
				for ($i=0;$i<$count;$i++)
				{
					$method=$objs->getWriteMethod($objs,$propertyList[$i]);
					$objs->invokeMethod($objs,$method,array($result[0][$propertyList[$i]]));
				}
				return $objs;
			}
		}
		catch (DBException $e)
		{
			throw new DBException('根据关键字查找数据异常：'.$e->getMessage(),'803');
		}
	}
	/**
	 * 根据主键查找对象的实例
	 * 返回对象
	 * @param unknown_type $obj
	 */
	public  function getInstance($objs)
	{
		$rtn=array();//返回结果集合
		try {
			if ($objs==null)
			{
				throw new DBException('取对象实例的数据对象为空异常！','803');
			}
			$statement=$objs->getSQLselect();
			$paraList=new ParameterList();
			$primaryList=$objs->getSQLPrimaryKey();
			$keyCount=count($primaryList);
			for ($j=0;$j<$keyCount;$j++)
			{
				$whereCause=' and '.$primaryList[$j].'=:'.$primaryList[$j];
				$para=new Parameter();
				$method=$objs->getReadMethod($objs,$primaryList[$j]);
				$para->setName($primaryList[$j]);
				$para->setSize(0);
				$para->setType('');
				$para->setValue($objs->invokeMethod($objs,$method));
				$paraList->add($para);
			}
			$result=$this->dataAccess->executeWithReturn($statement.' where 1=1 '.$whereCause,$paraList);
			$paraList=null;
			if (count($result)==0)
			{
				return $rtn;
			}
			else {
				$propertyList=$objs->getPersistPropertys($objs->getPhpClassName());
				$count=count($propertyList);
				
				for ($i=0;$i<$count;$i++)
				{
					$rtn[$propertyList[$i]]=$result[0][$propertyList[$i]];					
				}
				return $rtn;
			}
		}
		catch (DBException $e)
		{
			throw new DBException('根据关键字查找数据异常：'.$e->getMessage(),'803');
		}
	}
	/**
	 *查找父对象
	 *返回HashMap
	 * @param unknown_type $obj
	 */
	public function findByParent($objs)
	{
		try {
			if ($objs==null)
			{
				throw new DBException('取对象父对象的数据对象为空异常！','804');
			}			
			$statement=$objs->getSQLselect();
			$whereCause="";			
			$paraList=new ParameterList();
			$primaryList=$objs->getSQLref();
			$keyCount=count($primaryList);
			for ($j=0;$j<$keyCount;$j++)
			{
				$whereCause=' and '.$primaryList[$j].'=:'.$primaryList[$j];
				$para=new Parameter();
				$method=$objs->getReadMethod($objs,$primaryList[$j]);
				$para->setName($primaryList[$j]);
				$para->setSize(0);
				$para->setType('');
				$para->setValue($objs->invokeMethod($objs,$method));
				$paraList->add($para);
			}
			return $this->dataAccess->executeWithReturn($statement.' where 1=1 '.$whereCause,$paraList);
			$paraList=null;
		}
		catch (DBException $e)
		{
			throw new DBException('根据外键查找数据异常：'.$e->getMessage(),'804');
		}
	}
	/**
	 * 查找所有的对象
	 * 返回HashMap
	 */
	public function findAll($objs)
	{
		try {
			
			$statement=$objs->getSQLselect();			
			return $this->dataAccess->executeWithReturn($statement);
		}
		catch (DBException $e)
		{
			throw new DBException('查找数据异常：'.$e->getMessage(),'805');
		}
	}
	/**
	* 根据条件进行查找,前一个参数要查找的对象，
	 * $obj要查找对象
	 * $cause 查询条件
	 *  返回HashMap
	 * @param unknown_type $cause
	 */
	public function findByCause($objs,$cause)
	{
		try {
			
			$statement=$objs->getSQLselect();			
			return $this->dataAccess->executeWithReturn($statement.' where 1=1 '.$cause);
		}
		catch (DBException $e)
		{
			throw new DBException('查找数据异常：'.$e->getMessage(),'806');
		}
	}
}
?>