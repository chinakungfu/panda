<?php import('core.util.RunFunc'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
admin_lang.tpl
LNMV
);
include($inc_tpl_file);
include_once '../ckeditor/ckeditor.php';
include_once '../ckfinder/ckfinder.php';
$CKEditor = new CKEditor();
$CKEditor->basePath = '../ckeditor/';
$ckfinder = new CKFinder();
$ckfinder->BasePath = '../ckfinder/'; // Note: the BasePath property in the CKFinder class starts with a capital letter.
$ckfinder->SetupCKEditorObject($CKEditor);

$settings = runFunc("getGlobalSetting");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WOWSHOPPING后台管理系统v1.0</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/admin.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/base.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/jquery.lightbox-0.5.css" />
<script type="text/javascript" src="skin/jsfiles/jquery-1.8.2.js"></script>
<script type="text/javascript" src="skin/jsfiles/admin.js"></script>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="skin/jsfiles/jquery-ui-1.9.1.custom.min.js"></script>
<script type="text/javascript" src="skin/jsfiles/jquery.validate.js"></script>
<script type="text/javascript" src="skin/jsfiles/jquery.flot.js"></script>
<script type="text/javascript" src="skin/jsfiles/jquery.lightbox-0.5.min.js"></script>


<script type="text/javascript">
$(function(){

	jQuery.extend(jQuery.validator.messages, {
	    required: "请勿留空！",
	    remote: "已被使用！",
	    email: "请填写正确的邮件地址！",
	    url: "Please enter a valid URL.",
	    date: "Please enter a valid date.",
	    dateISO: "Please enter a valid date (ISO).",
	    number: "必须是数字！",
	    digits: "Please enter only digits.",
	    creditcard: "Please enter a valid credit card number.",
	    equalTo: "两次输入的密码必须一致！",
	    accept: "Please enter a value with a valid extension.",
	    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
	    minlength: jQuery.validator.format("Please enter at least {0} characters."),
	    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
	    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
	    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
	    min: jQuery.validator.format("必须不小于 {0}！")
	});

	$(".admin_form").validate();

	$(".order_cart_pay_back_form").validate();

});
</script>
</head>

<body>
<?php ?>
<div class="top">
	<img class="logo fl" src="skin/images/logo.png" alt=""/>
		<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
		<?php $user_info = runFunc("getUser",array($this->_tpl_vars["name"]));?>
		<?php $permission = runFunc("getManagerPermissionById",array($user_info[0]["manager_permission"]))?>
	<div class="login_box fr">
		欢迎您，<?php echo $user_info[0]["staffName"];?> - 权限 ：<?php if($user_info[0]["groupName"]!="Site Manager"){echo "最高权限";}else{echo $permission[0]["name"];}?> -
	<a href="../member/index.php<?php echo runFunc('encrypt_url',array('action=member&method=logout'));?>">退出系统</a>
	| <a target="_blank" href="../publish">网站首页</a>
	</div>
</div>
<ul class="top-nav">
<?php if( $user_info[0]["groupName"]!="Site Manager"):?>
	<?php if($user_info[0]["staffNo"] == "superadministrator"):?>
		<li><a <?php if($this->_tpl_vars["IN"]["type"]=="system"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=main&type=system'));?>">系统设置</a></li>
		<li>|</li>
	<?php endif;?>
<li><a <?php if($this->_tpl_vars["IN"]["type"]=="main"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=main&type=main'));?>">全局管理</a></li>
<li>|</li>

<li><a <?php if($this->_tpl_vars["IN"]["type"]=="users"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users'));?>">会员管理</a></li>
<li>|</li>

<li><a <?php if($this->_tpl_vars["IN"]["type"]=="orders"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders&type=orders'));?>">订单管理</a></li>
<li>|</li>

<li><a <?php if($this->_tpl_vars["IN"]["type"]=="products"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_list&type=products'));?>">商品管理</a></li>
<li>|</li>

<li><a <?php if($this->_tpl_vars["IN"]["type"]=="share"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=style_list&type=share'));?>">分享管理</a></li>
<li>|</li>

<li><a <?php if($this->_tpl_vars["IN"]["type"]=="media"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=advertising_list&type=media'));?>">媒体管理</a></li>
<li>|</li>

<li><a <?php if($this->_tpl_vars["IN"]["type"]=="totals"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=order_total&type=totals'));?>">统计报表</a></li>
<?php else:?>

<?php

$permission_array = json_decode($permission[0]["permission"])
?>
<?php if(in_array("map", $permission_array)):?>
<li><a <?php if($this->_tpl_vars["IN"]["type"]=="main"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=main&type=main'));?>">全局管理</a></li>
<li>|</li>
<?php endif;?>
<?php if(in_array("up", $permission_array)):?>
<li><a <?php if($this->_tpl_vars["IN"]["type"]=="users"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users'));?>">会员管理</a></li>
<li>|</li>
<?php endif;?>
<?php if(in_array("op", $permission_array)):?>
<li><a <?php if($this->_tpl_vars["IN"]["type"]=="orders"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders&type=orders'));?>">订单管理</a></li>
<li>|</li>
<?php endif;?>
<?php if(in_array("ip", $permission_array)):?>
<li><a <?php if($this->_tpl_vars["IN"]["type"]=="products"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_list&type=products'));?>">商品管理</a></li>
<li>|</li>
<?php endif;?>
<?php if(in_array("sp", $permission_array)):?>
<li><a <?php if($this->_tpl_vars["IN"]["type"]=="share"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=style_list&type=share'));?>">分享管理</a></li>
<li>|</li>
<?php endif;?>
<?php if(in_array("mp", $permission_array)):?>
<li><a <?php if($this->_tpl_vars["IN"]["type"]=="media"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=advertising_list&type=media'));?>">媒体管理</a></li>
<li>|</li>
<?php endif;?>
<?php if(in_array("tp", $permission_array)):?>
<li><a <?php if($this->_tpl_vars["IN"]["type"]=="totals"){echo 'class="active"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=order_total&type=totals'));?>">统计报表</a></li>
<?php endif;?>
<?php endif;?>

</ul>
<div class="top_msg_box">
	<p>欢迎登陆 WOWSHOPPING 管理系统</p>
</div>
