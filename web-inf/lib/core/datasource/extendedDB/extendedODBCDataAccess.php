<?php
/**
 * pdo的数据访问类
 */
import('core.datasource.extendedDB.extendedDataAccess');
import('core.lang.DBException');
class extendedODBCDataAccess extends extendedDataAccess
{
	var $connection;//数据库连接
	public function getConnection()
	{
		try
		{
			$connstring=$this->getConnectionString();
			$this->connection=odbc_connect($connstring,$this->loginName,$this->loginPassword);
			//$this->connection->exec("SET NAMES ".$this->dbcharacter);
		}
		catch (DBException  $ex)
		{
			echo "连接数据库异常：\n", $ex;
			throw $ex;
		}
	}
	public  function getConnectionString()
	{
		$connectionString='';
		if ($this->dbtype=='mysql')//mysql数据
		{
			$connectionString='mysql:host='.$this->serverName.';dbname='.$this->dbName;
		}else if($this->dbtype=='mssql')
		{
			//$connectionString = 'Driver={SQL Server};Server='.$this->serverName.';Database='.$this->dbName;
			$connectionString = $this->serverName;
		}
		elseif ($this->dbtype=='pgsql')//pgsql数据库
		{
			$connectionString='pgsql:host='.$this->serverName.'port='.$this->port.
			'dbname='.$this->dbName.' user='.$this->loginName.' password='.$this->loginPassword;
		}
		elseif ($this->dbtype=='oci')//oracle
		{
			$connectionString='oci:dbname=//'.$this->serverName.':'+$this->port.'/'.$this->dbName;
		}
		return $connectionString;
	}
	/**
	 * ִ执行sql语句查询并且返回结果集
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 */
	public function executeWithReturn($statement,$parameterList=null)
	{
		try
		{
			//取数据连接
			if ($this->connection==null)
			{
				$this->getConnection();
			}
//			$stmt=$this->connection->prepare($statement);
//			//开始处理参数
//			if ($parameterList!=null)
//			{
//				$count=$parameterList->length();
//				for ($i=0;$i<$count;$i++)
//				{
//					$parameter=$parameterList->get($i);
//					$stmt->bindValue(':'.$parameter->getName(),$parameter->getValue());
//				}
//
//			}
//			$r=$stmt->execute();
//			return $stmt->fetchAll();
			return @odbc_exec($this->connection,$statement);

		}
		catch (DBException $e)
		{
			echo "执行查询错误：\n", $e;
			throw $e;
		}

	}


	/**
	 * ִ执行sql查询不返回结果集
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 */
	public function executeNoReturn($statement,$parameterList=null)
	{
		try
		{
			//取数据连接
			if ($this->connection==null)
			{
				$this->getConnection();
			}
//			$stmt=$this->connection->prepare($statement);
//
//			//处理参数
//			if ($parameterList!=null)
//			{
//				$count=$parameterList->length();
//				for ($i=0;$i<$count;$i++)
//				{
//					$parameter=$parameterList->get($i);
//					$stmt->bindValue(':'.$parameter->getName(),$parameter->getValue());
//				}
//			}
//			$result =$stmt->execute();
			$result = @odbc_exec($this->connection,$statement);
			return (boolean)$result;
		}
		catch (DBException  $ex)
		{
			echo "execute sql error\n", $ex;
			throw ex;
		}

	}
	/**
	 * ִ执行存储过程并返回结果集
	 *
	 * @param unknown_type $procName
	 * @param unknown_type $parameterList
	 */
	public function callWithReturn ($procName,$parameterList=null)
	{

	}
	/**
	 * ִ执行存储过程不返回结果�
	 *
	 * @param unknown_type $procName
	 * @param unknown_type $parameterList
	 */
	public function callNoReturn ($procName,$parameterList=null)
	{

	}
	/**
	 *  分页查询
	 *
	 * @param unknown_type $statement
	 * @param unknown_type $parameterList
	 * @param unknown_type $currentPage
	 * @param unknown_type $pageSize
	 */
	public function queryForPage($statement,$parameterList=null,$currentPage,$pageSize)
	{
		$page=array();
		try
		{
			$sqlstatement =$statement." limit ".($currentPage -1).",".$pageSize;
			$page['data']=$this->executeWithReturn($sqlstatement,$parameterList);
			unset($sqlstatement);
			$sqlstatement='select count(1) as rowcount from ('.$statement.") tt";
			$tempdata=$this->executeWithReturn($sqlstatement,$parameterList);
			$page['rowcount']=$tempdata['rowcount'];
			unset($tempdata);
			$page['pagecount']=ceil($page['rowcount']/$pageSize);
			$page['currentPage']=$currentPage;
			$page['pagesize']=$pageSize;
			if ($currentPage==$page['pagecount'])
			{
				$page['nextpage']=$currentPage;
				$page['hasnext']=false;
			}
			else
			{
				$page['nextpage']=$currentPage+1;
				$page['hasnext']=true;
			}
			if ($currentPage==1)
			{
				$page['priorpage']=1;
				$page['hasprior']=false;
			}
			else
			{
				$page['priorpage']=$currentPage -1;
				$page['hasprior']=true;
			}
			return $page;
		}


		catch (Exception $e)
		{

		}
	}
	/**
     *启动事务
     *
     */
	public  function beginTrans()
	{
		if ($this->connection!=null)
		{
			$this->connection->beginTransaction();
		}
	}
	/**
	 * 提交事务
	 *
	 */
	public function commitTrans()
	{
		if ($this->connection!=null)
		{
			$this->connection->commit();
		}
	}
	/**
	 * 回滚事务
	 */
	public function rollBackTrans()
	{
		if ($this->connection!=null)
		{
			$this->connection->rollBack();
		}

	}
	//查询返回数据列表不分页
	public function QueryForList($sqls,$params=null)
	{
		try
		{
			//取数据连接
			if ($this->connection==null)
			{
				$this->getConnection();
			}
			//print $sqls;
//			$stmt=$this->connection->prepare($sqls);
//			//开始处理参数
//			$pamsg = '';
//			if ($params!=null)
//			{
//				if (is_array($params))
//				{
//					foreach ($params as $key =>$value)
//					{
//						$stmt->bindValue(':'.$key,$value);
//						$pamsg .= "$key:($value) "; //调试用
//					}
//				}
//			}
			$query =@odbc_exec($this->connection,$sqls);
			if (!$query)
			{
				//$pe = & $stmt->errorInfo();
				//$pemsg = 'SQL State:'.$pe[0] .'\n<br>Error Code:'. $pe[1] .'\n<br>Error Message:'. $pe[2];
				throw new Exception('Query Data Error:'.$pemsg . '||\n\s<br>SQL: ' . $sqls . '||\n\s<br>Params: ' .$pamsg, '334');
			}
			$i=0;
			while ($myRow = odbc_fetch_array($query))
			{
				$result[$i]=$myRow;
				$i++;
			}
			//$result = odbc_fetch_array($query);
			//$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $result;
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
	//插入数据，并返回自增字段的值
	public function insertdata($sqls,$params=null,$keyFileds=null)
	{
		try
		{
			//取数据连接
			if ($this->connection==null)
			{
				$this->getConnection();
			}
//			$stmt=$this->connection->prepare($sqls);
//			//处理参数
//			if ($params!=null)
//			{
//				if (is_array($params))
//				{
//					foreach($params as $key=>$value)
//					{
//						$stmt->bindValue(':'.$key,$value);
//						$pamsg .= "$key:($value) "; //调试用
//					}
//				}
//			}
			$result =@odbc_exec($this->connection,$sqls);
			if (!$result)
			{
				//$pe = & $stmt->errorInfo();
				//$pemsg = 'SQL State:'.$pe[0] .'\n<br>Error Code:'. $pe[1] .'\n<br>Error Message:'. $pe[2];
				throw new Exception('Query Data Error:'.$pemsg . '||\n\s<br>SQL: ' . $sqls . '||\n\s<br>Params: ' .$pamsg, '334');
			}
			else
			{
				return $result;
				//return $this->connection->lastInsertId();
			}
		}
		catch (DBException  $ex)
		{
			echo "execute sql error\n", $ex;
			throw ex;
		}
	}
	//更新或者删除数据
	public function updatedata($sqls,$params=null)
	{
		try
		{
			//取数据连接
			if ($this->connection==null)
			{
				$this->getConnection();
			}
//			$stmt=$this->connection->prepare($sqls);
//			//处理参数
//			if ($params!=null)
//			{
//				if (is_array($params))
//				{
//					foreach($params as $key=>$value)
//					{
//						$stmt->bindValue(':'.$key,$value);
//					}
//				}
//			}
//			$result =$stmt->execute();
			//print $sqls;
			$result =@odbc_exec($this->connection,$sqls);
			if (!$result)
			{
				return  false;
			}
			else
			{
				return $result;
			}
		}
		catch (DBException  $ex)
		{
			echo "execute sql error\n", $ex;
			throw ex;
		}
	}
	// 数据的分页查询，分页查询
	public  function queryForPageList($sqls,$params=null,$currentPage,$pageSize)
	{
		$page=array();
		try
		{
			$sqlstatement =$sqls;
			//print $sqlstatement;
			$page['data']=$this->QueryForList($sqlstatement,$params);
			$rs=$this->connection->query($sqls);
			$page['pageinfo']['rowcount']=$rs->rowCount();
			if(!empty($params['returnPages'])){
				if($params['returnPages']*$pageSize<$page['pageinfo']['rowcount']){
					$page['pageinfo']['rowcount']=$params['returnPages']*$pageSize;
				}
			}
			unset($sqlstatement);
			/*
			$reg = "/(select|SELECT)(.*?)(from|FROM)(.*?)$/U";
			if (preg_match_all($reg,$sqls,$matches))
			{
				$sqlstatement='select count(1) as rowcount from '.$matches[4][0];
			}
			$tempdata=$this->QueryForList($sqlstatement,$params);
			$page['pageinfo']['rowcount']=$tempdata[0]['rowcount'];
			unset($tempdata);
			*/
			$page['pageinfo']['pagecount']=ceil($page['pageinfo']['rowcount']/$pageSize);
			$page['pageinfo']['currentPage']=$currentPage;
			$page['pageinfo']['pagesize']=$pageSize;
			if ($currentPage==$page['pageinfo']['pagecount'])//判断翻页是否最后一页
			{
				$page['pageinfo']['nextpage']=$currentPage;
				$page['pageinfo']['hasnext']=false;
			}
			else
			{
				$page['pageinfo']['nextpage']=$currentPage+1;
				$page['pageinfo']['hasnext']=true;
			}
			if ($currentPage==1)//判断翻页是否为第一页
			{
				$page['pageinfo']['priorpage']=1;
				$page['pageinfo']['hasprior']=false;
			}
			else
			{
				$page['pageinfo']['priorpage']=$currentPage -1;
				$page['pageinfo']['hasprior']=true;
			}
			//print_r($page);
			return $page;
		}
		catch (Exception $e)
		{
			die($e->getMessage());
			throw $e;

		}

	}

}
?>