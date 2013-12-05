<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name">
<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
	</head>
	<body onload="window.location.hash = 'here'">
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			<div class="content">
			    
			        <pp:include file="common/account_body.tpl" type="tpl"/>
			   
			    <div class="youraccountBottom">
                    <div class="viewContent fl">
		    <a name="here"></a>
                        <h2>Wish List of: [$userInfo.0.staffName]</h2>
                        <table>
                            <thead>
                                <tr>
                                 <td style="padding-left:6px">THESE ITEMS ARE SAVING IN YOUR WISH LIST</td><td width="75px" align="center">QTY</td><td width="75px"  style="text-align:center;">&nbsp;&nbsp;&nbsp;PRICE</td><td style="text-align:center" width="75px">FREIGHT</td><td width="100px">&nbsp;</td>
                                </tr>
                                <tr>
                                 <td colspan="5" id="noteBag">Note: Items and promotional pricing not reserved until checkout is completed</td>
                                </tr>
                            </thead>
			    
				<loop name="WishList.data" var="var" key="key">
                            <tbody>
                                <tr>
                                    <td class="bagItem">
                                        <dl>
                                            <dt>
					    <pp:if expr="$var.goodsType=='inside'">
					    <img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="bagImg" />
					    <pp:elseif expr="$var.goodsType=='outside'">
					    <img src="[$var.goodsImgURL]" alt="bagImg" />
					    </pp:if>

					    </dt>
                                            <pp:if expr="$var.goodsTitleCN">
											<dd><strong>[$var.goodsTitleCN]</strong></dd>
											</pp:if>
											<pp:if expr="$var.goodsTitleEn">
											<dd><strong>[$var.goodsTitleEn]</strong></dd>
											</pp:if>
											<!--
											<dd>Item: BGS12_T4CTF</dd>-->
											<dd><pp:if expr="$var.itemSize">Size: [$var.itemSize]</pp:if><pp:if expr="$var.itemColor"><span class="pageContentColor">Color:[$var.itemColor]</span></pp:if></dd>
													<pp:if expr="$var.goodsType=='inside'"><dd class="wowService">WOW SURPRISE SERVICE</dd>
													</pp:if>
                                        </dl>
                                    </td>
                                    <td><input type="text" value="[$var.ItemQTY]" class="numtextBag"></td>
				    <pp:var name="SinglePrice" value="number_format($var.goodsUnitPrice, 2, '.', ',')"/>
                                    <td align="center">￥ [$SinglePrice]</td>
                                    <td align="center"><pp:if expr="$var.goodsFreight<=0">NO<pp:else/><pp:var name="Freight" value="number_format($var.goodsFreight, 2, '.', ',')"/>[$Freight]</pp:if></td>
                                    <td class="bagEdit">
                                        <dl>
                                            <dd><a href="#" style="color:#fff; background-color:#6E4B67;">Share</a></dd>
                                            <dd><a href="index.php[@encrypt_url('action=shop&method=DeleteData&cartID=' . $var.cartID)]">Delete</a></dd>
                                            <dd><a href="index.php[@encrypt_url('action=shop&method=WishToCart&cartID=' . $var.cartID)]">Add to Bag</a></dd>
                                        </dl>
                                    </td>
                                </tr>
                                </loop>
                               
                                
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                   <td colspan="5"><h3><!--<a href="#">View all</a> / <a href="#">Close</a>-->&nbsp;</h3></td> 
                                </tr>
                            </tfoot>
                        </table>
                        <p style="color:#444">NOTE: When you share a Wish List, it can be viewed by anyone who knows your e-mail address.</p>
                    </div>
                    <!--
                    <div class="mayLike clb">
                        YOU MAY LIKE
                        <ul>
                            <li><img src="../skin/images/bagImg.png" alt="bagImg"></li>
                            <li><img src="../skin/images/bagImg.png" alt="bagImg"></li>
                            <li><img src="../skin/images/bagImg.png" alt="bagImg"></li>
                            <li><img src="../skin/images/bagImg.png" alt="bagImg"></li>
                            <li><img src="../skin/images/bagImg.png" alt="bagImg"></li>
                            <li><img src="../skin/images/bagImg.png" alt="bagImg"></li>
                            <li><img src="../skin/images/bagImg.png" alt="bagImg"></li>
                        </ul>
                    </div>
		    -->
                </div>
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>
<pp:else/>
	<pp:include file="common/account_passPara.tpl" type="tpl"/>
</pp:if>