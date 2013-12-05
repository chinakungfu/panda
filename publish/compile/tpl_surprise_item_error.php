<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<!DOCTYPE HTML>
<html>
<head>
<?php

$inc_tpl_file=includeFunc("common/header/common_header.tpl");
include($inc_tpl_file);
?>

</head>
<body onload="window.location.hash = 'here'">
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>

	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);
	?>

<script type="text/javascript">
	$(function(){
		$("#itemApply").click(function(){
			var itemUrl = $(".itemUrl").val();
			if(itemUrl == ''){
				alert('请填写URL链接!');
			}else{
				$("#addGoodsInfo").submit();
			}
		});

	});
	function cancel(){
		$(".errorInput").each(function(){
			$(this).val('');
		});
		$(".itemUrl").val('');
		$(".errorRequest").val('');
	}
</script>

	<div class="content">
		<div class="errorItem">
	        <div class="photoShow">
	        	<div class="photoBox">Oops! Url fail to capture.</div>
	        </div>
	        <div class="errorItemRight">
	         <table width="600px" border="0" id="itemTab">
     			<form name="addGoodsInfo" id="addGoodsInfo" action="/publish/index.php" method="post">
	            <tr height="40px">
	                <td>
						<span class="errorName">URL:</span>
	                </td>
	                <td>
	                	<input class="itemUrl" id="itemURL" type="text" name="itemURL" value="" /><font color="red"> * </font>
	                </td>
	            </tr>
	            <tr height="40px">
	                <td>
						<span class="errorName">Item price:</span>
	                </td>
	                <td>
	                	<input class="errorInput" id="itemPrice" type="text" name="itemPrice" value="" />
	                </td>
	            </tr>
	            <tr height="40px">
	                <td>
						<span class="errorName">Quantity:</span>
	                </td>
	                <td>
	                	<input class="errorInput" id="itemQuantity" type="text" name="itemQuantity" value="" />
	                </td>
	            </tr>
	            <tr height="40px">
	                <td>
						<span class="errorName">Size:</span>
	                </td>
	                <td>
	                	<input class="errorInput" id="itemSize" type="text" name="itemSize" value="" />
	                </td>
	            </tr>

	            <tr height="40px">
	                <td>
						<span class="errorName">Color:</span>
	                </td>
	                <td>
	                	<input class="errorInput" id="itemColor" type="text" name="itemColor" value="" />
	                </td>
				</tr>

	            <tr height="40px">
   	                <td>
						<span class="errorName">Other:</span>
	                </td>
	                <td>
	                	<input class="errorInput" id="itemOther" type="text" name="itemOther" value="" />
	                </td>
                </tr>
	            <tr>
   	                <td>
						<span class="errorName" style="vertical-align:top;">Request:</span>
	                </td>
	                <td>
		                <textarea name="request" class="errorRequest">
			            </textarea>
	            	</td>
	            </tr>
	            <tr height="50px">
                	<td colspan="2" align="right">
                		<a id="cancelItem" href="javascript:cancel();">Cancel</a>
						<a id="itemApply" class="itemApply_button fr">submit</a>
	            	</td>
	            </tr>
				<input type="hidden" value="shop" name="action">
				<input type="hidden" value="addItemError" name="method">
			</form>

	        </table>
        </div>
    </div>
    <div style="clear:both;"></div>
	<div class="itemRequest itemErrorRequest">
		<div class="itemRequestTop itemErrorRequestTop">
	    	<div class="questCont">
	        	<h1>Questions</h1>
	            <h2>Why Url fail to capture?</h2>
	        	<p>Check your copyed Url first and try again. Due to TAOBAO api restrictions,somtimes will fail to capture.</p>
	            <h2>Can I buy the items, if I submit this form?</h2>
	        	<p>After we check your form, you will receive a mail from us with fixed items links for you to shopping.</p>
	        </div>
        </div>
    </div>
	<?php
	$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
	include($inc_tpl_file);
	?>
</div>
</body>
</html>

