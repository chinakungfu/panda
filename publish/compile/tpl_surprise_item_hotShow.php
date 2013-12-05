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
<body>
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	if($this->_tpl_vars["IN"]["from"] == "search_url"){
		$good = runFunc("getGoodsById",array($this->_tpl_vars["IN"]["id"]));
$comments = runFunc("getComment",array($this->_tpl_vars["IN"]["id"],"GOODS"));
		$talk_type ="GOODS";
		$item = array();
		$item[0] = $good;
	}
	if($this->_tpl_vars["IN"]["from"] == "style_list"){
		$comments = runFunc("getComment",array($this->_tpl_vars["IN"]["id"],"LIST GOODS"));
		$item = runFunc("getItemDetail",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["IN"]["show_type"]));
		$talk_type = "LIST GOODS";
	}

	if($this->_tpl_vars["IN"]["from"] == "collections_page"){
		$comments = runFunc("getComment",array($this->_tpl_vars["IN"]["id"],"GOODS"));
		$item = runFunc("getItemDetail",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["IN"]["show_type"]));
		$talk_type ="GOODS";
	}
	$setting = runFunc("getGlobalSetting");
?>

<script type="text/javascript">
	$(function(){
		$("#showModify").toggle(
		  function () {
		    $(this).css({color:"#afc970",background:"none"});
		    $(this).html('Waiting Modify');
		    $("#isModify").val('1');
		  },
		  function () {
		  	$(this).css({color:"#fff",background:"#afc970"});
		    $(this).html('Request Price Modify');
		    $("#isModify").val('0');
		  }
		);
		$("#itemQty").blur(function(){
			var qit = $(this).val();
			if(isNaN(qit)){
				$(this).val(1);
			}else{
				if(!isNum(qit) || qit < 1){
					$(this).val(1);
				}
			}
		});
			var adding_wish = 0;
			$("#add_wish_button").click(function(){
				if(adding_wish == 0){
					adding_wish = 1;
				}
				else{return false;}
				var para = new Array();
				para = {};
				para["ItemQTY"] = 1;
				para["itemFreight"] = <?php echo $setting[0]["freight"];?>;
				para["goodsID"] = <?php echo $item[0]["goodsid"];?>;
				para["itemPrice"]=<?php echo $item[0]["goodsUnitPrice"];?>;
				para["goodsAddUser"]='<?php echo $this->_tpl_vars["name"];?>';

				var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
				$("#add_wish_button").text("");
				$("#add_wish_button").append(loading_icon);
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "json",
					data:{
						action	: "shop",
						method	: "addWish",
						para : para

					},
					success : function(json){
						if(json.re == 1){

								$("#add_wish_button").replaceWith('<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>" class="itemShowWishList fr">Add successfully</a>');
/*								$("#add_wish_button").attr("href","/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>");*/
								loading_icon.remove();
								//$("#add_wish_button").removeAttr("id");
						}else{

								$("#add_wish_button").replaceWith('<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>" class="itemShowWishList fr">Add successfully</a>');
							loading_icon.remove();
							//$("#add_wish_button").removeAttr("id");
						}
					}

				});

			});
			/**add wish end**/
	});
	function itemSubmit(){
		var qit = $("#itemQty").val();
		if(isNaN(qit)){
			$("#itemQty").val(1);
		}else{
			if(!isNum(qit) || qit < 1){
				$("#itemQty").val(1);
			}
		}
		$(".props").each(function(){
			if($(this).val()==''){
				$(".buy_error").html("Please select color,size or etc..");
				exit;
			}
		});
		$("#goodsInfo").submit();
	}
	function isNum(s){
		var r,reg;
		reg=/\d*/;
		r=s.match(reg);
		if(r==s)
		  return true;
		else
		  return false;
	};
	function addItemQTY(type,o){
		if(type == "jia"){
			var value = $("#itemQty").val();
			if(isNaN(value)){
				value =1;
				$("#itemQty").val(value);
			}else{
				if(!isNum(value) || value < 1){
					value=1;
					$("#itemQty").val(value);
				}else{
					value ++;
					$("#itemQty").val(value);
				}
			}
		}else if(type == "jian"){
			var value = $("#itemQty").val();
			if(isNaN(value)){
				value =1;
				$("#itemQty").val(value);
			}else{
				if(!isNum(value) || value < 2){
					value=1;
					$("#itemQty").val(value);
				}else{
					value --;
					$("#itemQty").val(value);
				}
			}
		}
	}
</script>
	<div class="content">
		<div class="publishItemShow">
	        <div class="itemShowImg">
	        	<img src="<?php echo $item[0]["goodsImgURL"];?>_310x310.jpg" alt="" />
	        </div>
	        <div class="itemShowRight">
	         <table width="603px" border="0" id="itemTab">
     			<form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
				<input type="hidden" name="cart_type" value="1" />
	            <tr>
	                <td colspan="2">
	                    <div class="itemShowTitle">
							<?php if($this->_tpl_vars["IN"]["from"] == "style_list"):?>
	                            <?php echo $item[0]["change_title"];?>
	                        <?php elseif($this->_tpl_vars["IN"]["from"] == "search_url" || $this->_tpl_vars["IN"]["from"] == "collections_page"):?>
								<?php $goodsTitle = $item[0]['goodsTitleEn']?$item[0]['goodsTitleEn']:$item[0]['goodsTitleCN'];?>
                                <?php echo $goodsTitle;?>
	                        <?php endif;?>
	                    </div>
	                </td>
	            </tr>
	            <tr height="30px;">
	                <td width="430px">
						<?php if($item[0]["goodsURL"]!="" and $item[0]["show_link"]==1):?>
							<?php if(trim($item[0]["click_url"])!=""){
                                $click_link = $item[0]["click_url"];
                            }else{
                                $click_link = $item[0]["goodsURL"];
                            }?>
						<div class="fl" style="height:30px;line-height:30px; vertical-align:bottom; padding-top:7px;"><img src="../../skin/images/global.png" alt="" /> </div>
                        <div class="itemShowOrignal fl" style="height:30px;line-height:30px; vertical-align:bottom; padding-top:5px;">
                        	<a target="_blank" href="<?php echo $click_link;?>">Orignal Link</a>
                        </div>
						<?php endif;?>
	                </td>
	                <td align="right" width="173px">
	                	<div class="publish_price_box">￥<?php echo number_format($item[0]["goodsUnitPrice"], 2, '.',',');?></div></td>
	            </tr>
	            <tr height="30px">
		            <td valign="bottom">
                    	<div class="fl" style="height:20px;line-height:20px; vertical-align:bottom;"><img style="margin-top:2px;" src="../../skin/images/little_house.png" alt="" /></div>
                        <div class="itemShowRank fl" style="height:20px;line-height:20px; vertical-align:bottom;"><a href="<?php echo $item[0]["goodsShopUrl"];?>"  target="_blank" style="margin:5px;">Store</a></div>
                        <?php if($item[0]["goodsShopRank"]):?>
                        <div class="fl" style="height:20px;line-height:20px; vertical-align:top;"><a target="_blank" href="<?php echo $item[0]["goodsShopUrl"];?>" target="_blank"><img src="<?php echo $item[0]["goodsShopRank"];?>" /></a></div>
                        <?php endif;?>
                    </td>
		            <td align="right">
						<div>

							<span class="small_blue_title"><?php if($item[0]["goodsURL"]!="" and $item[0]["show_link"]==1):?>&nbsp;&nbsp;&nbsp;<?php endif;?>Seller Freight</span>
							<span class="freight_price">
								￥<?php echo number_format($setting[0]["freight"], 2, '.', ',')?>
							</span>
						</div>
					</td>
	            </tr>
                <tr height="30px">
                	<td></td>
                    <td align="right"><div id="showModify" class="itemShowModify">Request Price Modify</div></td>
                </tr>
					<?php $item_props = json_decode($item[0]["props"],true);?>
					<?php foreach($item_props as $item_prop):?>
							<?php foreach($item_prop as $key=>$item_prop_values):?>
                            <tr height="40px"> <td>
								<div class="prop_new_name fl"><?php echo ucfirst($key);?>:</div>
								<div class="fl" style="width:328px;">
									<select class="props" name="props[<?php echo $key;?>]" prop_name="<?php echo $key;?>">
										<?php foreach($item_prop_values as $item_value):?>
	                                            <option value="<?php echo addslashes($item_value);?>"><?php echo addslashes($item_value);?></option>
									    <?php endforeach;?>
                                    </select>
							    </div>
                            </td> </tr>
							<?php endforeach;?>
                    <?php endforeach;?>
	            <tr height="50px">
                	<td>
						<div class="prop_new_name fl">Qty:</div>

                        	<input id="itemQty" class="item_props_box fl" type="text" maxlength="3" name="ItemQTY" value="1" />
                            <div style="position:relative;" class="fl">
                                <div class="itemJia jia" onClick="addItemQTY('jia',this);"></div>
                                <div class="itemJia jian" onClick="addItemQTY('jian',this);"></div>
                            </div>
						</div>
	            </td><td></td></tr>
                <tr height="10px"><td colspan="2"></td></tr>
	            <tr><td colspan="2">
	            <span style="vertical-align:top;">Request:&nbsp;&nbsp;</span>
                <textarea name="request" class="itemPostRequest"> </textarea>
	            </td></tr>

	            <tr height="30px"><td colspan="2" align="right">
                	<div class="fr buy_error">

					</div>
                 </td></tr>
				<?php
                    $this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
                    $this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
                    $this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
                    $this->_tpl_vars["paraArr"]["show_type"] = $this->_tpl_vars["IN"]["show_type"];
                    $this->_tpl_vars["paraArr"]["from"] = $this->_tpl_vars["IN"]["from"];
					$this->_tpl_vars["paraArr"]["loginType"] = "itemShow";
                ?>
                <?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>
	            <tr height="50px">
                	<td colspan="2" align="right">
						<a id="item_buy" onclick="itemSubmit();" class="light_blue_button fr">ADD TO BAG</a>
						<!--<a class="itemShowGroup fr" href="<?php echo runFunc('encrypt_url',array('action=share&method=add_group_buy&goodsid='.$item[0]["goodsid"]));?>">Create a group buy</a>-->
						<a class="itemShowWishList fr" <?php if($this->_tpl_vars["name"]==""){echo "href='".runFunc('encrypt_url',array('action=website&method=login&loginType=itemShow&paraStr=' . $this->_tpl_vars["paraStr"]))."'";}else{echo 'id="add_wish_button"';}?>>Add to wish list</a>
	            </td></tr>
				<input type="hidden" value="<?php echo $setting[0]["freight"];?>" name="itemFreight">
				<input type="hidden" value="shop" name="action">
				<input type="hidden" value="addNewCart" name="method">
				<input type="hidden" value="0" name="modifyPrice" id="isModify">
				<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" name="page_id" />
				<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["show_type"];?>" name="show_type" />
				<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["from"];?>" name="from" />
				<input type="hidden" value="<?php echo $item[0]["goodsid"];?>" name="goodsID">
				<input type="hidden" value="<?php echo $item[0]["goodsUnitPrice"];?>" name="itemPrice">
				<input id="goodsAddUser" type="hidden" value="<?php echo $this->_tpl_vars["name"];?>" name="goodsAddUser">
			</form>

	        </table>
        </div>
        <div style="clear:both;"></div>
    </div>

	<div class="itemRequest itemShowRequest">
		<div class="itemRequestTop itemShowRequestTop">
    	<div class="questCont">
        	<h1>Questions</h1>
            <h2>What I can do when the price looks different from TAOBAO?</h2>
        	<p>Please click the button and request a <span class="nan">Price Modify</span> before <span class="nan">ADD to BAG</span> and <span class="nan">SUBMIT</span> order. The order status will automatic change to pending.
Please wait less than 24hours. We will verify and send a fixed order for you to continue.You will receive an email to guide you to our
payment procedure.</p>
             <h2>How can I do when item specifics are not clear ?</h2>
        	<p>Please write your request in the request box and ADD to BAG.</p>
            <h2>How to buy different attributes of this item?</h2>
        	<p>
            Please choose item specifics and quantity again, or write another request when item specifics are not clear. <span class="nan">ADD to BAG</span> again.</p>
            <h2>What is seller freight?</h2>
        	<p>
            We charge you a low standard shipping fee of 15rmb per seller. Please note that delivery rates depend upon distance and package weight.
Delivery fees are determined by the seller and the delivery service they use, so the standard fee may be subject to an increase.</p>
			<p style="float:right;margin-top:10px;">Learn more about <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=faq'));?>" style="color:#5e97ed">How To Order</a> </p>
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

