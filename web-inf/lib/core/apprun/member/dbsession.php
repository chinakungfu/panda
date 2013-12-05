<?php
/**
 * session控制类，
 * 主要控制多服务器共享session
 * 通过将sessionId保存到客户端的cookie
 * 然后再需要用到cookie的时候
 * 再从数据库里面进行访问
 *
 * 严重注意：必须在主运行环境将会员数据库的连接句柄创建好并赋给$GLOBALS['currentApp']['dbaccess']，否则不能正常工作
 */
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
class dbSession
{
	 
	static function init()
	{
		$domain = $GLOBALS['core']['cookie_domain'];
          
        //不使用 GET/POST 变量方式
        ini_set('session.use_trans_sid',    0);
        //设置垃圾回收最大生存时间
        ini_set('session.gc_maxlifetime',$GLOBALS['core']['cookie_lifetime']);

        //使用 COOKIE 保存 SESSION ID 的方式
        ini_set('session.use_cookies',1);
        ini_set('session.cookie_path','/');
        //多主机共享保存 SESSION ID 的 COOKIE
        
        ini_set('session.cookie_domain', $domain);

        //将 session.save_handler 设置为 user，而不是默认的 files
        session_module_name('user');
        //定义 SESSION 各项操作所对应的方法名：
		session_set_save_handler
		(
		array('dbSession', 'open'),   //对应于静态方法 dbSession::open()，下同。
		array('dbSession', 'close'),
		array('dbSession', 'read'),
		array('dbSession', 'write'),
		array('dbSession', 'destroy'),
		array('dbSession', 'gc')
		);
	}

	static function open($save_path, $session_name)
	{
		return true;
	}

	static function close()
	{
		//dbSession::gc();
		return true;
	}

	static function read($sesskey)
	{
		date_default_timezone_set('PRC');
		$sql = "SELECT data FROM {$GLOBALS['table']['member']['session']} WHERE sesskey='{$sesskey}' AND expiry>=".NOW_TIME." LIMIT 1";
		$rs = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		//print count($rs);
		return count($rs)==0 ? '' : $rs['0']['data'];
	}

	static function write($sesskey, $data,$ip,$dateTime)
	{
		date_default_timezone_set('PRC');
		$sql = "select * from {$GLOBALS['table']['member']['session']} where sesskey='".$sesskey."'";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql,$params);
		if($result==null)
		{
			$sql = "insert into {$GLOBALS['table']['member']['session']} (sesskey,expiry,data,guestIp) values (:sesskey,:expiry,:data,:guestIp)";
			$params = array(
			'sesskey' => $sesskey,
			'expiry'  => $dateTime,
			'data' => $data,
			'guestIp' => $ip
			);
			TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return false;
		}else {
			$sql = "update {$GLOBALS['table']['member']['session']} SET sesskey=:sesskey,expiry=:expiry,data=:data,guestIp=:guestIp where sesskey=:sesskey";
			$params = array(
			'sesskey' => $sesskey,
			'expiry'  => $dateTime,
			'data' => $data,
			'guestIp' => $ip
			);
			TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$params);
			return true;
		}
	}

	static function destroy($sesskey)
	{
		//$sql = "DELECT FROM {$GLOBALS['table']['member']['session']} WHERE sesskey='{$sesskey}'";
		$sql = "DELETE FROM {$GLOBALS['table']['member']['session']} WHERE sesskey='{$sesskey}'";
		TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
		return true;
	}

	static function gc($maxlifetime = 0) {
		$secend = strtotime(date("Y-m-d H:i:s"))-60;
		$date = date("Y-m-d H:i:s",$secend);
		$sql = "DELETE FROM {$GLOBALS['table']['member']['session']} WHERE expiry<" . (NOW_TIME-$maxlifetime);
		TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
		//由于经常性的对会话数据表做删除操作，容易产生碎片，
		//所以在垃圾回收中对该表进行优化操作。
		$sql = "OPTIMIZE TABLE {$GLOBALS['table']['member']['session']}";
		TStaticQuery::execute($GLOBALS['currentApp']['dbaccess'],$sql);
		return true;
	}
}
?>