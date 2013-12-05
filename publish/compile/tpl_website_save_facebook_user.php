<?php import('core.util.RunFunc'); 
import('core.addfunction.facebook.src.facebook'); 
$this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); 
$facebook = new Facebook(array(
  'appId'  => '278948165550978',
  'secret' => '7e4af236c3155bdf466474a60f3e55a5',
));

$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}



$user_id = $user_profile["id"];
$first_name = $user_profile["first_name"];
$last_name = $user_profile["last_name"];
$link = $user_profile["link"];
$username = $user_profile["username"];
$location = $user_profile["location"]["name"];

$dataArray = array(
	"staffNo" => $this->_tpl_vars["IN"]["user_email"],
	"staffName" => $username,
	"groupName" => "Verified Member",
	"registerDate" => date("Y-m-d H:i:s"),
	"facebook_id" => $user_id,
	"email" => $this->_tpl_vars["IN"]["user_email"]
);

$user_login_id = runFunc("addFacebookStaff",array($dataArray));


$profileArray = array();
$profileArray["user_id"] = $user_login_id;
$profileArray["first_name"] = $first_name;
$profileArray["last_name"] = $last_name;
$profileArray["mail"] = $this->_tpl_vars["IN"]["mail"];
$profileArray["facebook"] = $link;
$profileArray["Location"] = $location;
runFunc("makeFacebookProfile",array($profileArray));

runFunc('writeSession',array($user_login_id));


 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateCart",
	'query' => "update cms_publish_cart SET UserName= '{$user_login_id}' WHERE `UserName`= '{$this->_tpl_vars["CookieUser"]}'",
 ); 

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  

 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "update cms_publish_order SET orderUser= '{$user_login_id}' WHERE orderUser= '{$this->_tpl_vars["CookieUser"]}'",
 ); 

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params); 

header("Location:".runFunc('encrypt_url',array('action=shop&method=shopindex')));
