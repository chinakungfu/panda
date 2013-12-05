<?php import('core.util.RunFunc'); ?>
<?php  $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php 
$order_need_to_pay = runFunc("getMyOrderCountByStatus",array($this->_tpl_vars["name"],4));
$user = runFunc("getStaffInfoById",array($this->_tpl_vars["name"]));
$settings = runFunc("getGlobalSetting");
?>
<div class="accountHomeTitle">
<h1>Account Home</h1>
<h2>Modify an order, track a shipment, and update your account info.</h2>
<p>You have <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderList&searchType=fast&fastOrderStatus=4'));?>"><?php echo $order_need_to_pay[0]["count"];?></a> orders waiting for pay.</p>
</div>
<div class="accountHomeCon">
	<div class="accountHomeConMenu">
        <dl>
           <dt>Orders</dt>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>">Shopping Bag</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=order'));?>">View Order History</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>">Wish List</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$this->_tpl_vars["name"]));?>">Your Collections</a></dd> 
        </dl>
        <dl>
           <dt>Account Settings</dt>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=editProfile'));?>">Profile Setting</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=editAddress'));?>">Update Shipping Address</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=modify'));?>">Change Password</a></dd>

        </dl>    
        <dl>
           <dt>Payments</dt>
           <!--<dd>WOW Account Verify Code Reset</dd>-->
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_page'));?>">WOW Account (Info & Recharge Online)</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=bankTransfer'));?>">Recharge by Bank Transfer<img src="../../skin/images/bankTransfer2.png" /></a></dd>
           <dd>Recharge by West Union (Under Constraction)</dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_with_credits'));?>">Account Points (Exchange)</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=gift_card_buy'));?>">Refer A Friend Gift Certificates</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=information'));?>">Recharge and Refund History</a></dd>
           <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=phoneOrderHistroy'));?>">Mobile Phone Charge History</a></dd>                              
        </dl> 

        <dl style="background:none;">
        	<dt>Invite Friends</dt>
            <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=friendInvite'));?>">Invite Friends Get 50RMB</a></dd>
        </dl>
    </div>

	<div class="accountHomeConAD">
    	<div style="margin-bottom:10px;">
    	<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_with_phone'));?>"><img src="../../skin/images/charge mobliephone.jpg" /></a>
        </div>
        <div><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=friendInvite'));?>"><img src="../../skin/images/invite.jpg" /></a></div>
   	</div>
</div>

