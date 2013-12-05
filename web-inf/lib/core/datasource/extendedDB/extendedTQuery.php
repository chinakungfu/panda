<?php
/**
 * 数据查询对象
 * 
 *
 */
import('core.datasource.extendedDB.extendedDataAccess');
import('core.datasource.extendedDB.extendedParameter');
import('core.datasource.extendedDB.extendedParameterList');
class extendedTQuery
{
	var $dsid=null;//数据源Id
	var $connection=null;//数据访问对象dataAccess;
	var $params=null; //参数数组
	var $statement=null;//要执行的sql语句
	var $data;//执行的数据的结果
	/**
	 * 执行查询的类型
	 * Result －－执行查询返回结果
	 * NoResult --执行更新数据
	 * Page  --分页执行数据
	 * @var unknown_type
	 */
	var $type=null;
	var $currentPage=1;//当前页码
	var $pagesize=10;//每页显示的记录数
	//根据dsid从全局变量中取数据链接的配置信息
	public function getConnectionConfig($id)
	{
		try
		{
			$dsconfig=$GLOBALS['currentApp']['dbconfig'];
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
	//执行查询
	public function execute()
	{
		$dataAccess=null;
		try
		{
			if (($this->connection==null)&&($this->dsid==null))
			{
				throw new Exception('TQuery not connection setting exception',411);
			}
			else if (($this->connection!=null)&&($this->dsid!=null))
			{
				throw new Exception('TQuery connection setting exception ',411);
			}
			else
			{
				if ($this->connection!=null)
				{
					$dataAccess=$this->connection;
				}
				else
				{
					$dbconfig=$this->getConnectionConfig($this->dsid);
					$dataAccess=extendedDbFactory::getDataAccess($dbconfig);

				}
			}
			$paramList=$this->generateParamsList($this->params);
			if ($this->type=='result')//执行查询返回结果
			{
				//$dataAccess->executeWithReturn('select * from dyn_role',null);
				$this->data=$dataAccess->executeWithReturn($this->statement,$paramList);
				return $this->data;
			}
			else if ($this->type='notresult')//执行查询结果不返回结果
			{
				$dataAccess->executeNoReturn($this->statement,$paramList);
				return true;
			}
			else if ($this->type=='page')//执行分页查询
			{
				//queryForPage($statement,$parameterList=null,$currentPage,$pageSize)
				$data=$dataAccess->queryForPage($this->statement,$paramList,$this->currentPage,$this->pagesize);
				return $data;
			}
			else //执行查询不返回结果
			{
				$dataAccess->executeNoReturn($this->statement,$paramList);
			}

		}
		catch (Exception  $e)
		{
			throw $e;
		}

	}
	//生成参数列表
	protected function generateParamsList($params)
	{
		try
		{
			if ($params==null)
			{
				return null;
			}
			$paramlist=explode($params);
			$list=new ParameterList();
			foreach ($paramlist as $key=>$var)
			{
				$param=new Parameter();
				$param->setName($key);
				$param->setType("");
				$param->setValue($var);
				$param->setSize(0);
				$list->add($param);
			}
			return $list;

		}
		catch (Exception $e)
		{
			throw $e;

		}

	}

}
?>