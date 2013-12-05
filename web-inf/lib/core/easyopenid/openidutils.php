<?php
/**
 * 系统调用openid的入口函数包
 */

function begin_auth($openid_url,$required_fields,$options_fields,$process_url=null)
{
	try {
		$consumer=init_openid();
		session_start();
		$scheme = 'http';
		if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
			$scheme .= 's';
		}
		$openid=$openid_url;
		if (!isset($openid))
		{
			throw new Exception('not setting openid url exception',411);
		}
		else
		{
			if ($openid=="")
			{
				throw new Exception('setting openid url empty exception',412);
			}
		}
		if ($process_url==null)
		{
			$process_url = sprintf("$scheme://%s:%s%s/openidlogin.php",
			$_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'],
			dirname($_SERVER['PHP_SELF']));
			/*
			$process_url = sprintf("$scheme://%s%s/openidlogin.php",
			$_SERVER['SERVER_NAME'], 
			dirname($_SERVER['PHP_SELF']));
			*/
			
		}

		$trust_root = sprintf("$scheme://%s:%s%s",
		$_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'],
		dirname($_SERVER['PHP_SELF']));
		
		/*
		$trust_root = sprintf("$scheme://%s%s",
		$_SERVER['SERVER_NAME'], 
		dirname($_SERVER['PHP_SELF']));
		*/
		
		$auth_request = $consumer->begin($openid);

		// Handle failure status return values.
		if (!$auth_request) {
			throw new Exception('Authentication error',413);
		}
		//添加扩展参数,配置的时候以，分割
		$auth_request->addExtensionArg('sreg', 'required', $required_fields);
		$auth_request->addExtensionArg('sreg', 'optional', $options_fields);
		$redirect_url = $auth_request->redirectURL($trust_root,
		$process_url);
		header("Location: ".$redirect_url);
	}
	catch (Exception $e)
	{
		throw $e;
	}
}
/**
 * 结束提交的openid验证
 *
 */
function end_auth()
{
	try
	{
		$consumer=init_openid();
		session_start();
		$response = $consumer->complete($_GET);
		if ($response->status == Auth_OpenID_CANCEL) {
			throw new Exception('Verification cancelled',422);
		} else if ($response->status == Auth_OpenID_FAILURE) {
			$msg = "OpenID authentication failed: " . $response->message;
			throw new Exception($msg,422);
		} else if ($response->status == Auth_OpenID_SUCCESS) {
			// This means the authentication succeeded.
			$openid = $response->identity_url;
			$esc_identity = htmlspecialchars($openid, ENT_QUOTES);
			$success = sprintf('You have successfully verified ' .
			'<a href="%s">%s</a> as your identity.',
			$esc_identity,$openid);

			if ($response->endpoint->canonicalID) {
				$success .= '  (XRI CanonicalID: '.$response->endpoint->canonicalID.') ';
			}

			$sreg = $response->extensionResponse('sreg');
			return $sreg;

		}
	}
	catch (Exception $e)
	{
		throw $e;
	}


}
function init_openid($tmp_path=null)
{
	try
	{
		import('core.easyopenid.Auth.OpenID.Consumer');
		import('core.easyopenid.Auth.OpenID.FileStore');
		if ($tmp_path==null)
		{
			$store_path = $GLOBALS['currentApp']['openid_tmp_path'];
		}
		else
		{
			$store_path=$tmp_path;
		}
		$aa = new TplTemplate();
		if (!file_exists($store_path) &&
		!$aa->makeDir($store_path)) {
			$msg= "Could not create the FileStore directory '$store_path'. ".
			" Please check the effective permissions.";
			throw new Exception($msg,433);
		}
		$store = new Auth_OpenID_FileStore($store_path);
		$consumer = new Auth_OpenID_Consumer($store);
		return $consumer;
	}catch (Exception $e)
	{
		throw $e;
	}
}
?>