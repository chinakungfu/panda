<?php import('core.util.RunFunc');
import('core.addfunction.facebook.src.facebook');
$facebook = new Facebook(array(
  'appId'  => '278948165550978',
  'secret' => '7e4af236c3155bdf466474a60f3e55a5',
));
$loginUrl = $facebook->getLoginUrl(
	array('redirect_uri'=>runFunc('getGlobalModelVar',array('Site_Domain'))."/publish/index.php".runFunc('encrypt_url',array('action=website&method=facebook_login')))
);
$logoutUrl = $facebook->getLogoutUrl(array("next"=>runFunc('getGlobalModelVar',array('Site_Domain'))."/publish/index.php"));
include_once '../ckeditor/ckeditor.php';
$CKEditor = new CKEditor();
$CKEditor->basePath = '../ckeditor/';
$CKEditor->config['toolbar'] = "Basic";

$notice = runFunc("getNotice");
?>
<script type="text/javascript">
	$(function(){
		$(".shopping_menu").hover(function(){
			$(".menu_list").stop(true,true).show();
		},function(){
			$(".menu_list").stop(true,true).hide();
		});
		$(window).scroll(function () {
			if ($(this).scrollTop() > 200) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		$('#back-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
		$("#GoodsURL").focus(function(){
			var defaultVal = $(this).attr("defaultVal");
			var urlVal = $(this).val();
			if(urlVal == defaultVal){
				$(this).val("");
			}
			$(this).css("color","#333");
		});
		$("#GoodsURL").blur(function(){
			var defaultVal = $(this).attr("defaultVal");
			var urlVal = $(this).val();
			if(urlVal == ''){
				$(this).val(defaultVal);
				$(this).css("color","#a10000");
			}
		});
	});
	function addressadd()
	{
		var goodsUrl = $("#GoodsURL").val();
		if(goodsUrl != "" && goodsUrl != "Paste your link copied from Taobao or enter product keywords here"){

			$("#formAddress").submit();		
		}
	}
</script>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>
<?php if ($this->_tpl_vars["CookieUser"]){?>
<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["CookieUser"]; ?>
<?php }else{ ?>
<?php $this->_tpl_vars["tmpUser"]=runFunc('getSessionID',array()); ?>
<?php runFunc('writeCookie',array($this->_tpl_vars["tmpUser"]))?>
<?php } ?>
<?php }else{ ?>
<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["name"]; ?>
<?php } ?>
<?php
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
	'action' => "sql",
	'return' => "headCartList",
	'query' => "SELECT sum(ItemQTY) as countRows FROM cms_publish_cart WHERE UserName='{$this->_tpl_vars["tmpUser"]}' and ItemStatus = 'New' Order By cartID DESC",
);
$this->_tpl_vars['headCartList'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
<?php if($this->_tpl_vars["name"]!=""){
	runFunc("removeUserOverTimeGroupCart",array($this->_tpl_vars["name"]));
}?>
<div class="head_all">
<div class="head">
	<div class="logoLogin clb">
		<h1 class="logo fl">
			<a href="../index.php"><img src="/skin/images/logo.jpg" alt="WOW FIND ONLINESHOP IN CHINA" /> </a>
		</h1>
		<div id="header_right_box" class="fr">
			<table style="width: 100%;">
				<tr height="23px"><td colspan="2" class="phone"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_with_phone'));?>">CHARGE YOUR MOBILE PHONE ONLINE</a></td></tr>
                <tr height="23px">
                	<?php if ($this->_tpl_vars["name"] != ''){?>
                	<td class="welcome">
						<?php $this->_tpl_vars["userInfo"]=runFunc('getStaffInfoById',array($this->_tpl_vars["tmpUser"]));
                            $user_info = runFunc("getShareMemberInfoAllInOne",array($this->_tpl_vars["tmpUser"])); ?>
                       Welcome !
						<?php if($user_info["0"]["staffName"]):?>
							<?php echo $user_info["0"]["staffName"];?>
						<?php else:?>
							<?php echo $user_info["0"]["staffNo"];?>
						<?php endif;?>
                	</td>
                    <td class="logout">
                        <form name="logoutForm" action="/publish/index.php" method="post">
                            <input type="hidden" name="action" value="website">
                            <input type="hidden" name="method" value="logout">
                            <input type="hidden" name="current_action" value="<?php echo $this->_tpl_vars["action"];?>" />
                            <input id="log_out_button" type="submit" value="Log out" />
                        </form>
                     </td>
                    <? }?>
                </tr>
                <tr height="53px">
                    <td align="right">
                    	<?php if ($this->_tpl_vars["name"] == ''){?>
							<?php $this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"]; ?>
                            <?php $this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"]; ?>
                            <?php if($this->_tpl_vars["IN"]["id"]!=""){
                                        $this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
	                              }
	                              if($this->_tpl_vars["IN"]["user_id"]!=""){
	                                    $this->_tpl_vars["paraArr"]["backUserId"] = $this->_tpl_vars["IN"]["user_id"];
	                              }
                            ?>
                            <?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>
                        		<a class="reg" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerUser'));?>">Register</a><a class="sign" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=normal&paraStr=' . $this->_tpl_vars["paraStr"] ));?>">Sign in</a>
                        <?php }else{?>
							<?php $messages_count = runFunc("countUnreadMessage",array($this->_tpl_vars["name"])); ?>
                            <a href="<?php echo runFunc('encrypt_url',array('action=share&method=messageAll'));?>" class="msg">You have <font color="#ff9900"><?php echo $messages_count[0]["count"];?></font> messeges</a>
						<?php }?>
                    </td>
                    <td class="bag"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>" id="headApp">
                    <span>
						<?php if ($this->_tpl_vars["headCartList"]["data"]["0"]["countRows"]){?>
                               <?php echo $this->_tpl_vars["headCartList"]["data"]["0"]["countRows"];?>
                        <?php } else{ ?>
 								0
                        <?php } ?>
                  	</span></a>
                    </td>
                </tr>
			</table>
		</div>
	</div><!--logoLogin END  -->
<!--MENU START-->
<div class="mainmenu">
	<div class="menu fl">
    	<div class="allmenu home_menu">
        	<div class="menu_item">
            <a <?php if ($this->_tpl_vars["action"]=='website' && $this->_tpl_vars["method"]=='index'){?>class="select_menu"<?php }?> href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=index'));?>">Home</a>
            </div>
        </div>
        
       	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div>    
    	
        <div class="allmenu shopping_menu">
        	<div class="menu_item">
				<a <?php if ($this->_tpl_vars["action"]=='shop' or  ($this->_tpl_vars["action"]=='surprise' and $this->_tpl_vars["method"]=='surpriseindex') or  ($this->_tpl_vars["action"]=='surprise' and $this->_tpl_vars["method"]=='item_show') or  ($this->_tpl_vars["action"]=='surprise' and ($this->_tpl_vars["method"]=='brand_list' or $this->_tpl_vars["method"]=='surprise_brand_item_list'))){?>class="select_menu"<?php }?> href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=surpriseindex'));?>">Shopping</a>            
            
            </div>
            <!--隐藏菜单-->
            <div class="menu_list hide">
            	<div class="menu_list_jiantou"></div>
                <div class="menu_list_body">
                    <ul>
                        <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=surpriseindex'));?>">Hot Items</a></li>
                        <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=brand_list'));?>">Recommended Sellers</a></li>
                        
                        <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand'));?>">Hot Brands</a></li>
<!--                        <div style="padding:0 15px;"><p style="width: 100%;margin:20px auto 10px;" class="solid_line"></p></div>
                        <li><a href="#">Taobao Categories</a></li>
                        <li><a href="#">Tmall Categories</a></li>-->
                        <div style="padding:0 15px;"><p style="width: 100%;margin:20px auto 10px;" class="solid_line"></p></div>
                        <div style="padding:0 15px;"><span style="line-height:30px;color:#333;font:bold 16px Arial, Helvetica, sans-serif;">Tools</span></div>
<!--                        <li><a href="#">Parcel Track</a></li>   
                        <li><a href="#">Weight Estimation</a></li>
                        <li><a href="#">Cost Calculator</a></li>-->
                        <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=conversionCharts'));?>">Size Conversion</a></li>
                        <li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=exchangeRate'));?>">Exchange Rate</a></li>
      <!--                  <li><a href="#">Click Snap Order (plugin)</a></li>  -->                
                    </ul>
                </div>
            </div>
        </div>
        
      	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div> 
                
    	<div class="allmenu collections_menu">
        	<div class="menu_item">
				<a <?php if ($this->_tpl_vars["action"]=='share' and ($this->_tpl_vars["method"]=='listMain' or $this->_tpl_vars["method"]=="PollList"  or $this->_tpl_vars["method"]=="PollPage"  or $this->_tpl_vars["method"]=="add_poll"  or $this->_tpl_vars["method"]=="showList" or $this->_tpl_vars["method"]=="addList") ){?>class="select_menu"<?php }?> href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain'));?>">Collections</a>
            </div>
        </div>             

      	<div class="allmenu separate">
        	<div class="menu_item">
				<span>|</span>
            </div>
        </div> 
                
     	<div class="allmenu events_menu">
        	<div class="menu_item">
				<a <?php if ($this->_tpl_vars["action"]=='share' && ($this->_tpl_vars["method"]=='eventMain' or $this->_tpl_vars["method"]=="eventShow")){?>class="select_menu"<?php }?> href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=eventMain'));?>">Events</a>
            </div>
        </div> 
                  
	</div>
    <div class="yourAccount">
		<?php if ($this->_tpl_vars["name"] != ''){?>
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Home</a>
        <?php }?>
    </div>
    <div class="helpCenter"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a></div>
</div><!--MENU END-->
		<?php
		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
		$params = array (
	'action' => "sql",
	'return' => "cartInfo",
	'query' => "SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice+b.goodsFreight) as totalPrice  FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.ItemStatus = 'New' Order By a.cartid DESC",
		);

		$this->_tpl_vars['cartInfo'] = CMS::CMS_sql($params);
		$this->_tpl_vars['PageInfo'] = &$PageInfo;
		?>
		<?php
		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
		$params = array (
	'action' => "sql",
	'return' => "cartList",
	'query' => "SELECT * FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.ItemStatus = 'New' Order By a.cartid DESC",
		);
		$this->_tpl_vars['cartList'] = CMS::CMS_sql($params);
		$this->_tpl_vars['PageInfo'] = &$PageInfo;
		?>
		<?php $this->_tpl_vars["SubTotalPrice"]=0; ?>
		<?php $this->_tpl_vars["cartListNum"]=5; ?>
		<?php $this->_tpl_vars["SubTotalPrice"]=number_format($this->_tpl_vars["cartInfo"]["data"]["0"]["totalPrice"], 2, '.', ','); ?>

		<?php $this->_tpl_vars["cartIDstr_tmp"]=''; ?>
		<?php $this->_tpl_vars["cartNum"]=sizeof($this->_tpl_vars["cartList"]["data"]); ?>

		<?php if(!empty($this->_tpl_vars["cartList"]["data"])){
			foreach ($this->_tpl_vars["cartList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
			<?php if ($this->_tpl_vars["cartIDstr_tmp"]){?>
			<?php $this->_tpl_vars["cartIDstr_tmp"]=$this->_tpl_vars["cartIDstr_tmp"] . ',' . $this->_tpl_vars["var"]["cartID"]; ?>
			<?php }else{ ?>
			<?php $this->_tpl_vars["cartIDstr_tmp"]=$this->_tpl_vars["var"]["cartID"]; ?>
			<?php } ?>
			<?php  }
		} ?>
	</div>
	<div class="report_spam_box gray_line_box hide">
		<div class="spam_title">
			  Report Spam
		</div>
		<div class="spam_message">
			<div class="comment_msg">
			</div>
			<div class="spam_comment_content">
			</div>
		</div>
		<div class="spam_reason_box">
			<div>Reason:</div>
			<textarea id="spam_reason" cols="30" rows="10"></textarea>
		</div>
		<div class="pick_list_item_ctrls" style="text-align:center;margin-bottom: 10px;">
		<input  id="submit_spam_report" class="pick_list_submit blue_button_sm" type="submit" value="Submit">
		<a class="close_spam">Cancel</a>
		</div>
	</div>
</div>
<!-- main_body start-->
<div class="main_body">
	<!-- search start-->
    <div class="main_search <?php if ($this->_tpl_vars["action"]=='website' && $this->_tpl_vars["method"]=='index'){?>index_search<?php }?>">
    	<div class="search">
        	<div class="search_text fl">Quick Order or Search</div>
            <form name="formAddress" id="formAddress" action="/publish/index.php" method="post" target="_blank">
                <input type="hidden" name="action" value="shop">
                <input type="hidden" name="method" value="addNewGoods">
                <div class="search_taoradio fl">
                	<input type="radio" name="radio_type" value="1" checked="checked" /><span>TAOBAO</span>
                </div>
                <div class="search_ourradio fl">
                	<input type="radio" disabled="disabled" name="radio_type" value="2" /><span>Our Site</span>
                </div>
                <div class="search_textinput fl">
                	<input type="text" defaultVal = "Paste your link copied from Taobao or enter product keywords here" value="Paste your link copied from Taobao or enter product keywords here" name="GoodsURL" id="GoodsURL" />
                </div>
                <div class="search_go fl">
                    <a href="javascript:addressadd();" name="savesubmit" id="savesubmit">GO </a>
                </div>
            </form>
         </div>
    </div>
    <?php if($notice['content']):?>
    <div class="main_notice <?php if ($this->_tpl_vars["action"]=='website' && $this->_tpl_vars["method"]=='index'){?>index_notice<?php }?>">
    	<div class="notice_content">
        	<?php echo $notice['content'];?>
         </div>
    </div>   
    <?php endif;?>
    <div class="content_body">