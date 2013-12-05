<?php
import('core.datasource.extendedDB.extendedPDataAccess');
import('core.datasource.extendedDB.extendedODBCDataAccess');
import('core.datasource.extendedDB.extendedADataAccess');
class extendedDbFactory
{
	/**
	 * 静态方法，取连接持久对象
	 *
	 * @param unknown_type $dbConfig
	 * @return unknown
	 */
	public static function getDataAccess($dbConfig)
	{
		try
		{
			print_r($dbConfig);
			if($dbConfig==null)
			{
				return null;
			}
			else
			{
				if ($dbConfig['drivertype']=='pdo')//pdo访问接口
				{
					return new extendedPDataAccess($dbConfig);
				}else if($dbConfig['drivertype']=='odbc') //odbc数据访问接口
				{
					return new extendedODBCDataAccess($dbConfig);
				}
				else if($dbConfig['drivertype']=='adodb') //adodb数据访问接口
				{
					return new extendedADataAccess($dbConfig);
				}
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	/**
	 * 根据数据源Id来取数据链接信息
	 *
	 * @param unknown_type $dsId
	 */
	public static  function getDataAccessByDsId($dsId)
	{
		try
		{
			$dbConfig=extendedDbFactory::getConnectionConfig($dsId);
			if($dbConfig==null)
			{
				return null;
			}
			else
			{
				if ($dbConfig['drivertype']=='pdo')//pdo访问接口
				{
					return new extendedPDataAccess($dbConfig);
				}
				else if($dbConfig['drivertype']=='odbc') //odbc数据访问接口
				{
					return new extendedODBCDataAccess($dbConfig);
				}
				else if($dbConfig['drivertype']=='adodb') //adodb数据访问接口
				{
					return new extendedADataAccess($dbConfig);
				}
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	//根据dsid从全局变量中取数据链接的配置信息
	public static function getConnectionConfig($id)
	{
		try
		{
			$dsconfig=$GLOBALS['currentApp']['extendedDB']['dbconfig'];
			if (is_array($dsconfig))
			{
				if (array_key_exists($id,$dsconfig))
				{
					return $dsconfig[$id];
				}
				else
				{
					throw new Exception('datasource config not id find exception',444);
				}
			}
			else
			{
				throw new Exception('get connection config exception',444);
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}

}
?>