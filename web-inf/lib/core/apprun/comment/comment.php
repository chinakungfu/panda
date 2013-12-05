<?php
/**
 * *****
 * 评论增删改以及查询评论信息函数
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */


import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.tpl.TplTemplate');


//
function commentList($indexId,$appName)
{

	try
	{
		$sql = "select * from {$GLOBALS['table']['comment']['content']} where indexId=:indexId and  appName=:appName order by commentId desc";
		
		$params['indexId'] = $indexId;
		$params['appName'] = $appName;
		
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);

	}catch (Exception $e)
	{
		throw $e;
	}
}
//新增一条，传入变量请按照评论信息的字段组成数组传入
//比如array('title'=>'test','content'=>'test')
//新增成功则返回新插入的id,失败则返回false;
function saveInsert($commentArray)
{
	try
	{	

		$commentArray['state'] = 0;
		$commentArray['publishDate'] = date('Y-m-d h:i:s');
		$commentArray['isAdminView'] = 0;

		foreach ($commentArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}



		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into {$GLOBALS['table']['comment']['content']} (" . $str_field . ") values (".$str_value.")";
		return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$commentArray);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//修改记录，传入变量请按照评论信息的字段组成数组传入
//比如array('title'=>'test','content'=>'test')
//失败返回false, 成功返回影响行数

function saveEdit($commentId,$commentArray)
{

	try
	{
		/*		print_r($commentArray);
		echo '<hr>';
		print_r($commentId);*/
		foreach ($commentArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);
		$sql = "update {$GLOBALS['table']['comment']['content']} set $sql where commentId={$commentId}";
		return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$commentArray);
	} catch (Exception $e)
	{
		throw $e;
	}
}

//根据评论ID删除对应的记录
function delComment($commentId)
{
	try
	{
		$sql = "DELETE FROM {$GLOBALS['table']['comment']['content']} WHERE `commentId`=:commentId";
		$params['commentId'] = $commentId;
		return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//根据评论ID得到对应的信息，用于修改或者独立查看
function getCommentInfoById($commentId)
{
	try
	{
		$sql = "select * from {$GLOBALS['table']['comment']['content']} where commentId= :commentId";
		$params['commentId'] = $commentId;
		return TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}

//批量审核
function verify($commentId){

	try
	{

		if(is_array($commentId))
		{
			
			$INcommentId = implode(",", $commentId);

			$sql = "update {$GLOBALS['table']['comment']['content']} set state=:state where commentId IN ({$INcommentId})";
			$params['state'] = 1;

			return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			
		}
		else
		{
			$sql = "update {$GLOBALS['table']['comment']['content']} set state=:state where commentId=:commentId";
			$params['state'] = 1;
			$params['commentId'] = $commentId;
			
			return TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}

}


//批量删除
function deldata($commentId)
{
	try
	{
		
		if(is_array($commentId))
		{
			
			$INcommentId = implode(",", $commentId);
			$sql = "DELETE FROM {$GLOBALS['table']['comment']['content']} where commentId IN ({$INcommentId})";
		
			return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			
		}
		else
		{
			$sql = "DELETE FROM {$GLOBALS['table']['comment']['content']} where commentId=:commentId";
			$params['commentId'] = $commentId;
			return TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		}

	}
	catch (Exception $e)
	{
		throw $e;
	}
}


function returnVar($var){

	try
	{
		return $var;
	}
	catch (Exception $e)
	{
		throw $e;
	}


}
?>