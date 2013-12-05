<?php
abstract  class extendedDataAccess
{
	var  $dbName;//数据库的名称
	var $dbtype;//数据库类型
	var $serverName;//数据库服务器名称
	var $loginName;//登陆名称
	var $loginPassword;//登陆密码
	var $appId;//系统Id
	var $drivertype;//数据库驱动类型
	var $port;//端口号
	var $dbcharacter;
	function __construct($dbConfig)
	{
		$this->dbName=$dbConfig['dbName'];
		$this->appId=$dbConfig['appId'];
		$this->dbtype=$dbConfig['dbtype'];
		$this->loginName=$dbConfig['loginName'];
		$this->loginPassword=$dbConfig['loginPassword'];
		$this->serverName=$dbConfig['serverName'];
		$this->drivertype=$dbConfig['drivertype'];
		$this->port=$dbConfig['port'];
		$this->dbcharacter=$dbConfig['dbcharset'];
	}
	/**
	 *取数据库连接
	 *
	 */
	public abstract function getConnection();
	/**
	 * ִ执行sql语句查询并且返回结果集
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 */
	public abstract function executeWithReturn($statement,$parameterList=null);
	/**
	 * ִ执行sql查询不返回结果集
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 */
	public abstract function executeNoReturn($statement,$parameterList=null);
	/**
	 * 执行存储过程并返回结果集
	 *
	 * @param unknown_type $procName
	 * @param unknown_type $parameterList
	 */
	public abstract function callWithReturn ($procName,$parameterList=null);
	/**
	 * ִ执行存储过程不返回结果
	 *
	 * @param unknown_type $procName
	 * @param unknown_type $parameterList
	 */
	public abstract  function callNoReturn ($procName,$parameterList=null);
	/**
	 * 分页查询，
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 * @param unknown_type $currentPage
	 * @param unknown_type $pageSize
	 */
	public abstract  function queryForPage($statement,$parameterList=null,$currentPage,$pageSize);
	

	/**
	 * 取连接字符串
	 *
	 */
	public abstract function getConnectionString();
	/**
     * 启动事务
     *
     */
	public abstract function beginTrans();
	/**
	 * 提交事务
	 *
	 */
	public abstract function commitTrans();
	/**
	 * 回滚事务
	 */
	public abstract function rollBackTrans();
	//查询返回数据列表
	public abstract function QueryForList($sqls,$params=null);
	//插入数据，并返回自增字段的值
	public abstract function insertdata($sqls,$params=null,$keyFileds=null);
	//更新或者删除数据
	public abstract function updatedata($sqls,$params=null);
	// 数据的分页查询
	public abstract  function queryForPageList($sqls,$params=null,$currentpage,$pageSize);
	
}
?>