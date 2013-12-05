<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
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
<body>
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);?>

    
	<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "cartTotal",
	'query' => "SELECT SUM(ItemQTY) as cartTotal,SUM(itemTotal) as sellerSubTotalPrice FROM cms_publish_cart WHERE UserName = '{$this->_tpl_vars["tmpUser"]}' and ItemStatus = 'Wish'",
	);

	$this->_tpl_vars['cartTotal'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	?>

	<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "shopList",
	'query' => "SELECT b.goodsShopId,b.goodsShopName,SUM(a.ItemQTY) as shopTotal,SUM(a.itemTotal) as sellerTotalPrice,b.goodsid,b.goodsShopUrl FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.ItemStatus = 'Wish' and cart_type = 1 Group By b.goodsShopId Order By a.cartID DESC",
	);

	$this->_tpl_vars['shopList'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	?>
    <?php $settings =  runFunc("getGlobalSetting");?>
    <?php $shopNum =  count($this->_tpl_vars["shopList"]["data"]);//商店数目 ?>
    <div id="result"></div>
	<div class="bagNav">
    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Home</a> > <a>Wish List</a>
    </div>
    <div class="bagTitle" style="border:none;">Wish List <span class="smallNum">(<b id="bagItemTatal"><?php if($this->_tpl_vars["cartTotal"]["data"][0]['cartTotal']){ echo $this->_tpl_vars["cartTotal"]["data"][0]['cartTotal'];}else{echo 0;}?></b>)</span></div>
	<?php if($this->_tpl_vars["cartTotal"]["data"][0]['cartTotal'] > 0){?>
        <div class="bagContent">
            <form id="submit_cart" action="/publish/index.php" method="post">
            <input type="hidden" name="action" value="shop">
            <input type="hidden" name="method" value="submitCart">
            <input type="hidden" name="goodsitem" value="">        
            <table width="975px">
                <tr>
                    <td width="60px"></td>
                    <td width="80px"></td>
                    <td width="440px"></td>
                    <td width="150px" align="center">  </td>
                    <td width="150px" align="center">  </td>
                    <td align="center">  </td>
                </tr>
                <?php $userid = $this->_tpl_vars["tmpUser"]; ?>
                <?php foreach ($this->_tpl_vars["shopList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){?>	
                <?php 
					$goodsShopId = $this->_tpl_vars['var']['goodsShopId'];
					$goodsshopName = $this->_tpl_vars['var']['goodsShopName'];
				?>                             
                <?php $sellerTotalPrice = number_format($this->_tpl_vars["var"]["sellerTotalPrice"], 2, '.', ','); //店铺总价钱?>
                <tr id="all_<?php echo $goodsShopId;?>"><td colspan="6">
                    <table width="975px">       	
                    <tr class="bagShopName">
                    	<td width="580px" colspan="3"><span>Store :</span> <a target="_blank" href="<?php echo $this->_tpl_vars["var"]["goodsShopUrl"];?>"><?php echo $goodsshopName;?></a></td>
                    	<td width="150px"></td>
                    	<td width="150px"></td>                        
                        <td></td>
                    </tr>
                    <tr style="margin-top:10px;" id="<?php echo $goodsShopId;?>">
                        <td colspan="6">
                           <?php $shopItemList = runFunc("getShopItemList",array($userid,$goodsShopId,'Wish'));?> 							                                                     
                            <?php foreach ($shopItemList as $this->_tpl_vars['itemkey'] => $this->_tpl_vars['itemvar']){?>
							<?php  
								//cartID
								$cartID = $this->_tpl_vars["itemvar"]["cartID"];
								//goodsid
								$goodsid = $this->_tpl_vars['itemvar']['goodsid'];
								//itemPrice
								$itemPrice = $this->_tpl_vars['itemvar']['itemPrice'];

							?>                       
                                    <table style="margin-top:10px;width:975px" id="<?php echo $cartID;?>">
                                        <tr>
                                            <td rowspan="4" width="60px" align="left" valign="top">
                                            <div class="itemGoodsIdStyle">ID:<?php echo $goodsid;?> </div>
                                            <input type="checkbox" class="selectCheckBox"  name="selectgoodsitem" checked="true" onClick="cancelItemQTY(this,'<?php echo $cartID;?>','<?php echo $userid;?>','Wish','');" value="<?php echo $cartID;?>" />
                                            </td>
                                            <td rowspan="4" width="80px"  align="center" valign="top">
                                                <div class="itemImg"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank"><img src="<?php echo $this->_tpl_vars['itemvar']['goodsImgURL'];?>_100x100.jpg" /></a></div>
                                            </td>
                                            <td width="440px" align="left" valign="top">
                                                <div class="itemTitle">
                                                    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleCN"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleCN"],58));?></a></div>
                                                <div class="itemTitle"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleEn"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleEn"],58));?></a></div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                                <div class="itemPrice">¥ <span id="item_price">
													<?php echo number_format($itemPrice, 2, '.', ',');?></span>
                                                </div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                            
                                            </td>
                                            <td align="right" valign="top">                                            
                                                <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$this->_tpl_vars["itemvar"]['goodsid']));?>" style="color:#5e97ed;font:bold 14px Arial, Helvetica, sans-serif; cursor:pointer;">BUY NOW</a> 
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>                                    
    
                                            </td>
                                            <td align="center">

                                            </td>
                                            <td colspan="2"></td>                                    
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                                     
                                            </td>
                                        </tr>
                                        <tr class="itemLineBg980"><td colspan="6" class="itemDelete">
                                        
                                        <span id="<?php echo $cartID;?>" class="add_to_my_list_button" style="font-weight:normal;">Add to Collection</span>

										<a style="color: #5E97ED;font:12px bold Arial, Helvetica, sans-serif;margin-left:10px;" onClick="javascript:return confirm('Confirm to delete this item from your wish list?')" href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=DeleteData&type=account_wish&cartID=' . $cartID));?>">Delete</a>                                  
                                        
                                        	</td>
                                        </tr>
                                        
                                            <div id="add_to_my_list_<?php echo $cartID;?>" class="add_to_my_list_box gray_line_box oh hide">
                                                <div class="add_to_my_list_box_tite">
                                                    Pick a Collction List
                                                </div>
                                                <div class="pick_img_message fl">
                                                <div class="pick_list_img"><img src="<?php echo $this->_tpl_vars['itemvar']['goodsImgURL'];?>_310x310.jpg" alt="" /></div>
                                                <div id="pick_message_<?php echo $cartID;?>" class="pick_message">
                                                    
                                                </div>
                                                </div>
                                                <div class="pick_list_detail fr">
                                                    <div id="pick_item_title_<?php echo $cartID;?>" class="pick_item_title"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleCN"],58));?></div>
                                                    <?php $my_lists = runFunc("getShareListByUserId",array($userid));?>
                                                    <select name="" class="my_list_select">
                                                        <option class="no_choose" value="">Select List from Collection</option>
                                                        <?php foreach($my_lists as $my_list):?>
                                                        <option value="<?php echo $my_list["id"]?>"><?php echo $my_list["title"];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                    <div class="pick_link_comment">
                                                        <a href="<?php echo runFunc('encrypt_url',array('action=share&method=addList&add_good_id='.$goodsid));?>"> Create New Collection List</a>
                                                        <textarea onkeyup="checkWordLen(this);" name="" class="pick_item_comment" cols="30" rows="10"></textarea>
                                                        <span class="pick_link_comment_limit">300 characters limit</span>
                                                    </div>
                                                    <div class="pick_list_item_ctrls">
                                                        <input item_id="<?php echo $cartID;?>"  goods_id="<?php echo $goodsid;?>" class="pick_list_submit blue_button_sm" type="submit" value="Submit" />
                                                        <a id="<?php echo $cartID;?>" class="pick_list_close">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>                                        
                                     </table>                         
                            <?php }?>                  
                    </td></tr>

                    <tr height="30px"><td colspan="6"></td></tr>
                 </table>
                 </td></tr>
                <?php }?>
                <tr height="50px" style="border-top:2px solid #ADAEAB;"><td colspan="6"></td></tr>
              
                
            </table>
            </form>
        </div>		

    
    <?php $tags = runFunc("getGoodsTagsById",array($this->_tpl_vars["shopList"]["data"][0]["goodsid"]));?>
         
   <div class="recommended">
   		<?php if(count($tags)>0):
   
				$tags_array = array();
				foreach ($tags as $tag){

					$tags_array[] = $tag["tag_id"];
				}
				$tags_str = implode(",", $tags_array);
				$tag_goods = runFunc("getTagGoods",array($tags_str));

			?>    
            <div class="recommendedCon">
                <div class="recomTitle"><i>Recommended for You</i></div>
                <?php foreach($tag_goods as $k => $v):?>
                	<?php if($v['goodsImgURL']):?>
                        <div class="recomItem<?php if(fmod($k+1,3)){echo ' recomItemStyle';}?>">
                            <div class="recomItemLeft"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$v['goodsid']));?>"><img src="<?php echo $v['goodsImgURL'];?>_600x600.jpg" width="150px" height="137px" /></a></div>
                            <div class="recomItemRight">
                                <div class="itemTitle">
                                    <?php $goodsTitle = $v['goodsTitleEn']?$v['goodsTitleEn']:$v['goodsTitleCN'];?>
                                    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$v['goodsid']));?>"><?php echo runFunc('g_substr',array($goodsTitle,60));?>
                                    </a>
                                </div>
                                
                                <div class="itemOriginalPrice" style="width:150px;height:17px;">
                                <?php if($v['goodsOriginalPrice'] && $v['goodsOriginalPrice'] > 0):?>
                                	<del>¥ <?php echo number_format($v['goodsOriginalPrice'], 2, '.', ',');?></del>
                                <?php endif;?>  
                                  
                                </div>
                                
                                <div class="itemPrice">¥ <?php echo number_format($v['goodsUnitPrice'], 2, '.', ',');?></div>
                            </div>
                        </div>
                        <?php if($k >= 5){break;}?>
                    <?php endif;?>
                <?php endforeach;?>
                <div class="clb"></div>
            </div>
        <?php else:?>
			<?php
            import('core.apprun.cmsware.CmswareNode');
            import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
            $params = array (
            'action' => "sql",
            'return' => "recommendedGoodsList",
            'query' => "SELECT * FROM cms_publish_goods WHERE special = '1' and goodsStatus = 'Open' and goodsType = 'inside' and published = '1' Order By created DESC limit 6",
            );
            $this->_tpl_vars['recommendedGoodsList'] = CMS::CMS_sql($params);
            $this->_tpl_vars['PageInfo'] = &$PageInfo;
            ?>
            <div class="recommendedCon">
                <div class="recomTitle"><i>Recommended for You</i></div>
                <?php foreach($this->_tpl_vars['recommendedGoodsList']['data'] as $k => $v):?>
                    <div class="recomItem<?php if(fmod($k+1,3)){echo ' recomItemStyle';}?>">
                        <div class="recomItemLeft"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$v['goodsid']));?>"><img src="<?php echo $v['goodsImgURL'];?>_600x600.jpg" width="150px" height="137px" /></a></div>
                        <div class="recomItemRight">
                            <div class="itemTitle">
                                <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$v['goodsid']));?>"><?php echo runFunc('g_substr',array($v['goodsTitleEn'],60));?>
                                </a>
                            </div>
                            
                            <div class="itemOriginalPrice" style="width:150px;height:17px;">
                            <?php if($v['goodsOriginalPrice'] && $v['goodsOriginalPrice'] > 0):?>
                            <del>¥ <?php echo number_format($v['goodsOriginalPrice'], 2, '.', ',');?></del>
                            <?php endif;?>
                             
                            </div>							
                            <div class="itemPrice">¥ <?php echo number_format($v['goodsUnitPrice'], 2, '.', ',');?></div>
                        </div>
                    
                    </div>
                
                <?php endforeach;?>
                <div class="clb"></div>
            </div>       
        
        <?php endif;?>     

    
    </div> 




		
	<?php }else{?>
    		<div class="cartEmpty">Your wish list is empty!</div>  
            <div class="itemRequest wishRequest">
                <div class="itemRequestTop wishRequestTop">
                <div class="questCont">
                    <h1>Questions</h1>
                    <h2>Can I use collections instead wish list?</h2>
                    <p><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain'));?>" class="nan">Collections</a> is a new function for you. Easier and more intuitive,with customized classification. You can create your own collection to share 
publicly with the community or privately with friends.  You can drag and drop items from all items inside our site，your wish list or ordered 
items. Also you can just grab an URL from TAOBAO and create.</p>
        
					<!--<p style="float:right;margin-top:20px;">Learn more about <span style="color:#5e97ed">Delivery</span></p>-->
                </div>
                </div>
            </div>             
    <?php }?>
    

    
    
    
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

	</div>
<script type="text/javascript">
	
	function checkWordLen(e){
		var limit = 300 - $(e).val().length;
		var limit_word = "("+ limit +" characters limit)";
	
		if($(e).val().length >=300){
			$(e).val($(e).val().substring(0, 300));
			limit_word = "(0 words max)";
		}
		$(e).siblings(".pick_link_comment_limit").text(limit_word);
	}
	
		$(function(){

			var submiting = 0;
			$(".pick_list_submit").click(function(){
					var item_id = $(this).attr("item_id");
					var goods_id = $(this).attr("goods_id");
					var list_id = $(this).parent().siblings(".my_list_select").val();
					var title = $("#pick_item_title_"+item_id).text();
					var comment = $(this).parent().siblings(".pick_link_comment").children(".pick_item_comment").val();

					if(submiting == 0){
						submiting = 1;

					}else{
							return false;
						}
					if(list_id==""){
							alert("Please select your list first!");
							submiting = 0;
							return false;
						}
					$("#pick_message_"+item_id).children().remove();
					$("#pick_message_"+item_id).text("");
					var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
					$("#pick_message_"+item_id).append(loading_icon);
					$.ajax({
						url : 'index.php',
						type : 'POST',
						dataType : "json",
						data:{
							action		: "share",
							method		: "addItemToList",
							list_id 	: list_id,
							title 		: title,
							comment 	: comment,
							goods_id 	: goods_id
						},
						success : function(data)
						{
							
						},complete: function(){
							$("#pick_message_"+item_id).children().remove();
							submiting = 0;
							$("#pick_message_"+item_id).text("Add successful!");
							$(".pick_list_submit").hide();
							$(".pick_list_close").addClass("pick_list_success_close");
							$(".pick_list_close").text("Close");
						}
					});
				});
			
			$( ".add_to_my_list_box" ).dialog({
				autoOpen: false,
				show: { effect: 'drop', direction: "up" },
				hide: { effect: 'drop', direction: "up" },
				width: 430,
				modal: true
			});

			$( ".add_to_my_list_button" ).click(function() {
				$(".pick_list_close").removeClass("pick_list_success_close");
				$(".pick_list_close").text("Cancel");
				$(".pick_list_submit").show();
				$(".my_list_select").children(".no_choose").attr("selected","selected");
				$(".pick_item_comment").val("");
				$(".pick_item_comment").siblings(".pick_link_comment_limit").text("300 characters limit");
				var id = $(this).attr("id");
				$("#add_to_my_list_"+id).dialog( "open" );
				return false;
			});

			$(".pick_list_close").click(function(){
					var id = $(this).attr("id");
					$("#add_to_my_list_"+id).dialog( "close" );
					return false;
				});
			

		});
	</script>
</body>
</html>
		<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
		);
		include($inc_tpl_file);
	?>

<?php } ?>