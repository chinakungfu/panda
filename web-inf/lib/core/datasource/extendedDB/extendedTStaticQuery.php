<?php
/**
 * 数据操作的，标签实现类
 *
 */
import('core.datasource.extendedDB.extendedDataAccess');
class  extendedTStaticQuery
{
	/**
	 * 查询返回结果
	 *
	 * @param unknown_type $access
	 * @param unknown_type $sqls
	 * @param unknown_type $params
	 */
	public static function queryList($access,$sqls,$params=null)
	{
		try {
			return $access->QueryForList($sqls,$params);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 新增数据，执行insert的sql语句
	 *
	 * @param unknown_type $access
	 * @param unknown_type $sqls
	 * @param unknown_type $params
	 */
	public static function insertdata($access,$sqls,$params=null)
	{
		try {
			return $access->insertdata($sqls,$params,null);
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	/**
	 * 执行修改的sql语句，update
	 *
	 * @param unknown_type $access
	 * @param unknown_type $sqls
	 * @param unknown_type $params
	 */
	public static function updatedata($access,$sqls,$params=null)
	{
		try {
			return $access->updatedata($sqls,$params);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 执行删除的sql语句,delete
	 *
	 * @param unknown_type $access
	 * @param unknown_type $sqls
	 * @param unknown_type $params
	 */
	public static function deletedata($access,$sqls,$params=null)
	{
		try {
			return $access->updatedata($sqls,$params);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	
	/**
	 * 执行语句,并不返回操作结果，比如"OPTIMIZE TABLE"
	 *
	 * @param unknown_type $access
	 * @param unknown_type $sqls
	 * @param unknown_type $params
	 */
	public static function execute($access,$sqls,$params=null)
	{
		try {
			return $access->executeNoReturn($sqls,$params);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 执行分页查询
	 *
	 * @param unknown_type $access
	 * @param unknown_type $sqls
	 * @param unknown_type $params
	 * @param unknown_type $currentpage
	 * @param unknown_type $pageSize
	 */
	public static function queryForPage($access,$sqls,$params=null)
	{
		try {
			if (array_key_exists('currentPage',$params))
			{
				$currentpage=$params['currentPage'];
				$params = array_diff($params,array('currentPage',0));				
			}
			else 
			{
				$currentpage=1;
			}
			if (array_key_exists('pageSize',$params))
			{
				$pageSize=$params['pageSize'];	
				$params = array_diff($params,array('pageSize',0));			
			}
			else 
			{
				$pageSize=100;
			}
			return $access->queryForPageList($sqls,$params,$currentpage,$pageSize);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 取数据库的所有的表
	 *
	 * @param unknown_type $access
	 * @param unknown_type $dbNames
	 * @return unknown
	 */
	public static function getAllTable($access,$dbNames)
	{
		try
		{
			$sqls="SHOW TABLES";
			return $access->QueryForList($sqls,null);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 查看表的字段名称
	 *
	 * @param unknown_type $access
	 * @param unknown_type $tableNames
	 * @return unknown
	 */
	public static function getFields($access,$tableNames)
	{
		try
		{
			$sqls='SHOW COLUMNS FROM \''.$tableNames.'\'';
			return $access->QueryForList($sqls,null);

		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
}
?>