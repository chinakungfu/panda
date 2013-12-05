<?php import('core.util.RunFunc');
$signin = runFunc('readSession',array());

?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>

</head>
<script type="text/javascript">

	$(function(){

	$(".order_view").hover(function() {

		$(".order_view span").addClass("white");
		}, function() {
			$(".order_view span").removeClass("white");
		});

	$(".order_view").click(function(){
			$(".pageContentSubmit").toggle();

			});
		$("#edit_request").click(function(){
				$("#address_edit_request").submit();
			});
		$(".address_radio_button").click(function(){
				var ad_fullName =$(this).parent().children(".address_hidden").children("#ad_fullName").text();
				var ad_address1 =$(this).parent().children(".address_hidden").children("#ad_address1").text();
				var ad_address2 =$(this).parent().children(".address_hidden").children("#ad_address2").text();
				var ad_city =$(this).parent().children(".address_hidden").children("#ad_city").text();
				var ad_province =$(this).parent().children(".address_hidden").children("#ad_province").text();
				var ad_zipcode =$(this).parent().children(".address_hidden").children("#ad_zipcode").text();
				var ad_country =$(this).parent().children(".address_hidden").children("#ad_country").text();
				var ad_telephone =$(this).parent().children(".address_hidden").children("#ad_telephone").text();
				var ad_cellphone =$(this).parent().children(".address_hidden").children("#ad_cellphone").text();
				var ad_email =$(this).parent().children(".address_hidden").children("#ad_email").text();
				var ad_id =$(this).parent().children(".address_hidden").children("#ad_id").text();

				$("#using_fullName").val(ad_fullName);
				$("#using_address1").val(ad_address1);
				$("#using_address2").val(ad_address2);
				$("#using_city").val(ad_city);
				$("#using_province").val(ad_province);
				$("#using_zip").val(ad_zipcode);
				$("#using_country").val(ad_country);
				$("#using_telephone").val(ad_telephone);
				$("#using_cellphone").val(ad_cellphone);
				$("#using_email").val(ad_email);
				$("#addressId_current").val(ad_id);
				$("#orderAddressId").val(ad_id);

			});
				});
	function cancelRadioCheck(name)
	{
		$("input:radio").each(function()
		{
		  this.checked = false;
		});
	}
	</script>
<script type="text/javascript">

	function backDataItemQTY(response)
	{
		var responseArr = response.split("-");
		var subTotalPriceObj = document.getElementById("subTotalPrice");
		var subTotalPrice1Obj = document.getElementById("subTotalPrice1");
		var totalItemsObj = document.getElementById("totalItems");

		var wowDeliveryObj = document.getElementById("wowDelivery");
		var serviceFreeObj = document.getElementById("serviceFree");
		var totalPriceObj = document.getElementById("totalPrice");

		//totalItemsObj.innerHTML =responseArr[0];
		subTotalPriceObj.innerHTML = setCurrency(responseArr[1]);
		subTotalPrice1Obj.innerHTML = setCurrency(responseArr[1]);
		var serviceFree = parseInt(responseArr[1])*0.1;
		if(serviceFree<20)
		{
			serviceFree = 20;
		}
		serviceFreeObj.innerHTML = setCurrency(serviceFree);
		if(wowDeliveryObj==null)
		{
			totalPriceObj.innerHTML = setCurrency(parseFloat(responseArr[1])+parseFloat(serviceFree));
		}else
		{
			totalPriceObj.innerHTML = setCurrency(parseFloat(responseArr[1])+parseFloat(wowDeliveryObj.innerHTML)+parseFloat(serviceFree));
		}
	}
	//四舍五入保留两位小数
	function changeTwoDecimal(x)
	{
		var f_x = parseFloat(x);
		if (isNaN(f_x))
		{
			alert('function:changeTwoDecimal->parameter error');
			return false;
		}
		var f_x = Math.round(x*100)/100;
		return f_x;
	}
	function setCurrency(s){
		s = String(s);
		if(s.indexOf('-')==0){
			//计算负数
			s= s.substring(1,s.lenght);
			alert("ddddd"+s);
			if(/[^0-9\.\-]/.test(s)) return "invalid value";
			s=s.replace(/^(\d*)$/,"$1.");

			s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
			s=s.replace(".",",");
			var re=/(\d)(\d{3},)/;
			while(re.test(s))
			s=s.replace(re,"$1,$2");
			s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

			return '-'+s.replace(/^\./,"0.")
		}else{
			//计算正数
			if(/[^0-9\.\-]/.test(s)) return "invalid value";
			s=s.replace(/^(\d*)$/,"$1.");

			s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
			s=s.replace(".",",");
			var re=/(\d)(\d{3},)/;
			while(re.test(s))
			s=s.replace(re,"$1,$2");
			s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

			return s.replace(/^\./,"0.")
		}
	}
	</script>

<body>

<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
<?php
// $this->_tpl_vars["IN"]["orderID"];
$cartIdStr =  $this->_tpl_vars["IN"]["cartIdStr"];
/*if(!$cartIdStr){
	$link = "index.php".runFunc('encrypt_url',array('action=shop&method=myCart'));
	 header("Location: ".$link);
}*/
?>
<?php

import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
if($cartIdStr){
	$params = array (
		'action' => "sql",
		'return' => "headCartList",
		'query' => "SELECT count(*) as countRows FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.ItemStatus = 'New' and a.cartID in ({$cartIdStr}) Order By a.cartid DESC",
	);
}else{
	$params = array (
		'action' => "sql",
		'return' => "headCartList",
		'query' => "SELECT count(*) as countRows FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.ItemStatus = 'New' Order By a.cartid DESC",
	);
}

$this->_tpl_vars['headCartList'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;
	if($this->_tpl_vars["headCartList"]["data"]["0"]["countRows"] ==0){
		$link = "index.php".runFunc('encrypt_url',array('action=shop&method=myCart'));
		 header("Location: ".$link);
			?>
<?php	}


?>


<?php
//*******************User_id************************
$userid= $this->_tpl_vars["tmpUser"];
//***************************************************
?>
<div class="content_order_success">
	<div style="width: 600px; float: left;">
	<?php
	// ******************Address form**************************
	$inc_tpl_file=includeFunc(<<<LNMV
shop/addressform.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<?php
	// ******************order Review**************************
	$inc_tpl_file=includeFunc(<<<LNMV
shop/orderReview.tpl
LNMV
	);
	include($inc_tpl_file);

	?>
	</div>

	<?php
	// ******************order Review**************************

$inc_tpl_file=includeFunc(<<<LNMV
shop/paymentInfo.tpl
LNMV
		);
		include($inc_tpl_file);
	?>

</div>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	?>

</body>
<script type="text/javascript">

	</script>
</html>
