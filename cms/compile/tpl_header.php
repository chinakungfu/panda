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

<script type="text/javascript" src="/publish/skin/jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/json.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/ajaxControl.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/utf.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/base64.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/phpserializer.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/xxtea.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/bigint.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/phprpc_client.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/base.js"></script>
<script type="text/javascript" src="skin/jsfiles/jquery-1.7.1.min.js"></script>
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


	$(".hover_menu").hover(function(){
		$(this).children(".menu_list").stop(true,true).show();
	},function(){
		$(this).children(".menu_list").stop(true,true).hide();
	});

});
</script>
</head>

<body>

<div class="head_all">
<div class="head">
	<div class="logoLogin clr">
		<h1 class="logo fl">
			<a href="../cms/index.php"><img src="skin/images/logo.png" alt="ADMINISTRATOR SYSTEM" /> </a>
		</h1>
		<div id="header_right_box" class="fr">
			<table style="width:100%;">
				<tr height="23px"><td colspan="2"></td></tr>
                <tr height="23px">
					<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
					<?php $user_info = runFunc("getUser",array($this->_tpl_vars["name"]));?>
					<?php $permission = runFunc("getManagerPermissionById",array($user_info[0]["manager_permission"]))?>
	            	<?php if ($this->_tpl_vars["name"] != ''){?>
		            	<td class="welcome">
		                   Welcome ! &nbsp;<?php echo $user_info[0]["staffName"];?>
		            	</td>
		                <td class="logout" width="70px">
		                    <a href="../member/index.php<?php echo runFunc('encrypt_url',array('action=member&method=logout'));?>">Log out</a>
		                </td>
	                <? }?>
                </tr>
				<tr height="53px">
                	<td class="permission">
                    	<span>权限 ：<?php if($user_info[0]["groupName"]!="Site Manager"){echo "最高权限";}else{echo $permission[0]["name"];}?></span>
                    </td>
                    <td class="index">
                    	<a target="_blank" href="../publish">网站首页</a>
                    </td>
                </tr>
			</table>
		</div>
	</div><!--logoLogin END  -->
<!--MENU START-->
<div class="mainmenu">
	<div class="menu fl">
    	<div class="allmenu home_menu hover_menu">
        	<div class="menu_item">
        	<a <?php if($this->_tpl_vars["IN"]["type"]=="main"){echo 'class="select_menu"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=main&type=main'));?>">Global</a>
            </div>
            <!--隐藏菜单-->
            <div class="menu_list hide">
            	<div class="menu_list_jiantou"></div>
                <div class="menu_list_body">
                    <ul>

					<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=main'));?>">全局信息</a></li>
				 <?php if( $user_info[0]["groupName"]!="Site Manager"):?>

                    <li class="menu_title">全局设置</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=admin_user_settings&type=main'));?>">超级管理员</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=site_settings&type=main'));?>">站点设置</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=main_settings&type=main'));?>">服务设置</a></li>			
					<!--<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=main_admin&type=main'));?>">超级设置</a></li>-->                    
                    <li class="menu_title">管理员管理</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=managers&type=main'));?>">管理员列表</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=manager_add&type=main'));?>">新增管理员</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=manager_permission_list&type=main'));?>">管理员权限</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=add_manager_permission&type=main'));?>">新增权限</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=logs_view&type=main'));?>">操作日志</a></li>
                <?php endif;?>



                    </ul>
                </div>
            </div>


        </div>

       	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div>

        <div class="allmenu shopping_menu hover_menu">
        	<div class="menu_item">
        	<a <?php if($this->_tpl_vars["IN"]["type"]=="users"){echo 'class="select_menu"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users'));?>">Members</a>
            </div>
            <!--隐藏菜单-->
            <div class="menu_list hide">
            	<div class="menu_list_jiantou"></div>
                <div class="menu_list_body">
                    <ul>
                        <li class="menu_title">会员管理</li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users'));?>">会员列表</a></li>
                        <li class="menu_title">消息管理</li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=notice_list&type=users'));?>">公告列表</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=notice_add&type=users'));?>">发布公告</a></li>                                                
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users'));?>">咨询回复</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=admin_help_ignored_messages&type=users'));?>">已忽略回复</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=admin_help_mail_send&type=users'));?>">直接回复</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=admin_help_mail_list&type=users'));?>">直接回复记录</a></li>
                        <li class="menu_title">优惠券管理</li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=coupon_add&type=users'));?>">生成优惠券</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=coupons&type=users'));?>">优惠券列表</a></li>
                        <li class="menu_title">充值管理</li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=recharge_order&type=users'));?>">充值记录</a></li>
                    </ul>
                </div>
            </div>
        </div>

      	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div>

    	<div class="allmenu store_menu hover_menu">
        	<div class="menu_item">
        	<a <?php if($this->_tpl_vars["IN"]["type"]=="orders"){echo 'class="select_menu"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders&type=orders'));?>">Orders</a>
            </div>
            <!--隐藏菜单-->
            <div class="menu_list hide">
            	<div class="menu_list_jiantou"></div>
                <div class="menu_list_body">
                    <ul>
                    <li class="menu_title">订单管理</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders&type=orders'));?>" >全部订单列表</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&type=orders_wow'));?>" >wow订单列表</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_ivision&type=orders_ivision'));?>" >ivision订单列表</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_rechargePhoneList&type=orders'));?>" >电话充值订单列表</a></li> 
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders_bankTransfer&type=orders'));?>" >银行汇款列表</a></li> 
                    <li class="menu_title">团购商品</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyCart&type=orders'));?>" >订单列表</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=groupFailed&type=orders'));?>" >失败团购处理</a></li>
                    </ul>
                </div>
            </div>

        </div>

      	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div>

     	<div class="allmenu store_menu hover_menu">
        	<div class="menu_item">
        	<a <?php if($this->_tpl_vars["IN"]["type"]=="products"){echo 'class="select_menu"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_list&type=products'));?>">Products</a>
            </div>
            <!--隐藏菜单-->
            <div class="menu_list hide">
            	<div class="menu_list_jiantou"></div>
                <div class="menu_list_body">
                    <ul>
 	<li class="menu_title">商品管理</li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_list&type=products'));?>">商品列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_add&type=products'));?>">添加商品</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_category_list&type=products'));?>">分类列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_category_add&type=products'));?>">添加分类</a></li>
    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products'));?>">用户抓取商品列表</a></li>
	<li class="menu_title">产品标签管理</li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=tag_categories&type=products'));?>" >分类列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=tag_category_add&type=products'));?>">添加分类</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=tag_list&type=products'));?>" >标签列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=tag_add&type=products'));?>" >添加标签</a></li>
	<li class="menu_title">品牌管理</li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products'));?>">分类列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brand_category_add&type=products'));?>">添加分类</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brand_tag_list&type=products'));?>">标签列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brand_tag_add&type=products'));?>">添加标签</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products'));?>">品牌列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brand_add&type=products'));?>">添加品牌</a></li>
	<li class="menu_title">属性管理</li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=prop_list&type=products'));?>">属性列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=prop_add&type=products'));?>">添加属性</a></li>
	<li class="menu_title">热门品牌</li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=hot_brand_category_list&type=products'));?>">品牌分类</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=hot_brand_category_add&type=products'));?>">添加分类</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=hot_brand_list&type=products'));?>">品牌列表</a></li>
	<li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=hot_brand_add&type=products'));?>">添加品牌</a></li>
                    </ul>
                </div>
            </div>



        </div>

      	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div>

     	<div class="allmenu store_menu hover_menu">
        	<div class="menu_item">
        	<a <?php if($this->_tpl_vars["IN"]["type"]=="share"){echo 'class="select_menu"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=style_list&type=share'));?>">Sharing</a>
            </div>

            <!--隐藏菜单-->
            <div class="menu_list hide">
            	<div class="menu_list_jiantou"></div>
                <div class="menu_list_body">
                    <ul>
                    <li class="menu_title">Style List 管理</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=style_list&type=share'));?>">Style List 列表</a></li>
                    <li class="menu_title">商店管理</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_list&type=share'));?>">商店列表</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share'));?>">商店post</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_category&type=share'));?>">商店分类</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_category_add&type=share'));?>">添加分类</a></li>
                    <li class="menu_title">官方活动</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=eventList&type=share'));?>">活动列表</a></li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=eventAdd&type=share'));?>">发布活动</a></li>
                    <li class="menu_title">会员活动</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=member_event_list&type=share'));?>">活动列表</a></li>
                    <li class="menu_title">投票管理</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=poll_list&type=share'));?>">投票列表</a></li>
                    <li class="menu_title">会员团购</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=memeberGroupBuy&type=share'));?>">团购列表</a></li>
                    <li class="menu_title">官方团购</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=adminGroupBuy&type=share'));?>">团购列表</a></li>
                    <li class="menu_title">评论管理</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=comment_list&type=share'));?>">所有评论</a></li>
                    <li class="menu_title">垃圾信息管理</li>
                    <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share'));?>">被举报信息</a></li>
                 </ul>
                </div>
            </div>



        </div>

      	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div>

     	<div class="allmenu events_menu hover_menu">
        	<div class="menu_item">
        	<a <?php if($this->_tpl_vars["IN"]["type"]=="media"){echo 'class="select_menu"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=advertising_list&type=media'));?>">AD Media</a>
            </div>

            <!--隐藏菜单-->
            <div class="menu_list hide">
            	<div class="menu_list_jiantou"></div>
                <div class="menu_list_body">
                    <ul>
                        <li class="menu_title">广告管理</li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=advertising_list&type=media'));?>">广告列表</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=advertising_add&type=media'));?>">新建广告</a></li>
                        <li class="menu_title">活动页管理</li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media'));?>">活动页列表</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_add&type=media'));?>">新建活动页</a></li>
                        <li class="menu_title">newsletter管理</li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=newsletter_add&type=media'));?>">newsletter生成</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=newsletter_list&type=media'));?>">newsletter列表</a></li>
                     </ul>
                </div>
            </div>

        </div>

      	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div>

     	<div class="allmenu service_menu hover_menu">
        	<div class="menu_item">
        	<a <?php if($this->_tpl_vars["IN"]["type"]=="totals"){echo 'class="select_menu"';}?> href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=order_total&type=totals'));?>">Data Analysis</a>
            </div>
            <!--隐藏菜单-->
            <div class="menu_list hide">
            	<div class="menu_list_jiantou"></div>
                <div class="menu_list_body">
                    <ul>
                        <li class="menu_title">统计报表</li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=order_total&type=totals'));?>">订单收入</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=recharge_total&type=totals'));?>">充值收入</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=sells_total&type=totals'));?>">销量统计</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=user_total&type=totals'));?>">注册统计</a></li>
                        <li><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=social_total&type=totals'));?>">社交统计</a></li>
                     </ul>
                </div>
            </div>



        </div>


	</div>
    <div class="helpCenter"><a href="#">Edit Templates</a><img src="skin/images/trash.png" /></div>
</div><!--MENU END-->

	</div>

</div>
<!-- main_body start-->
<div class="main_body">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
order_statusNote.tpl
LNMV
);
include($inc_tpl_file);
?>