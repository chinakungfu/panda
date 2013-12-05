<?php
/**
 * ADODB 的通用数据访问类
 */
import('core.datasource.extendedDB.extendedDataAccess');
class extendedADataAccess extends extendedDataAccess
{
	/**
	 * 取数据库连接
	 *
	 */
	public function getConnection()
	{

	}
	/**
	 * ִ执行sql语句查询并且返回结果集
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 */
	public function executeWithReturn($statement,$parameterList=null)
	{

	}
	/**
	 * ִ执行sql查询不返回结果集
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 */
	public function executeNoReturn($statement,$parameterList=null)
	{

	}
	/**
	 * 执行存储过程并返回结果集
	 *
	 * @param unknown_type $procName
	 * @param unknown_type $parameterList
	 */
	public function callWithReturn ($procName,$parameterList=null)
	{

	}
	/**
	 * ִ执行存储过程不返回结果
	 *
	 * @param unknown_type $procName
	 * @param unknown_type $parameterList
	 */
	public function callNoReturn ($procName,$parameterList=null)
	{

	}

	/**
	 * 取连接字符串
	 *
	 */
	public function getConnectionString()
	{

	}
	/**
     * 启动事务
     *
     */
	public  function beginTrans()
	{

	}
	/**
	 * 提交事务
	 *
	 */
	public function commitTrans()
	{

	}
	/**
	 *回滚事务
	 */
	public function rollBackTrans()
	{

	}
	/**
	 * 数据分页查询
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 * @param unknown_type $currentPage
	 * @param unknown_type $pageSize
	 */
	public function queryForPage($statement,$parameterList=null,$currentPage,$pageSize)
	{

	}
	//查询返回数据列表
	public function QueryForList($sqls,$params=null)
	{
		
	}
	//插入数据，并返回自增字段的值
	public function insertdata($sqls,$params=null,$keyFileds=null)
	{
		
	}
	//更新或者删除数据
	public function updatedata($sqls,$params=null)
	{
		
	}
	// 数据的分页查询
	public   function queryForPageList($sqls,$params=null,$currentpage,$pageSize)
	{
		
	}	
}
?>