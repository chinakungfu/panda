
<pp:var name="nodeId" value="@getGlobalModelVar('goodsNodle')"/>
<pp:var name="node" value="@getNodeInfoById($nodeId)"/>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>shop-demo</title>
		<link href="/skin/style/reset.css" rel="stylesheet" type="text/css"/>
		<link href="/skin/style/shop.css" rel="stylesheet" type="text/css"/>
		<link href="/skin/style/base.css" rel="stylesheet" type="text/css"/>
		<link href="/publish/skin/jsfiles/jqzoom/css/jqzoom.css" rel="stylesheet" type="text/css"/>
		<script language=JavaScript type="" >		

		function addCart(value)
		{			
			if(value=='0')
			{
				document.goodsInfo.action.value="shop";
				document.goodsInfo.method.value="addCart";
				document.goodsInfo.submit();
			}else if(value=='1')
			{
				document.goodsInfo.action.value="shop";
				document.goodsInfo.method.value="addCart";
				document.goodsInfo.submit();
			}
		}
		function addWish(value)
		{
			if(value=='0')
			{				
				document.goodsInfo.submit();
			}else if(value=='1')
			{				
				document.goodsInfo.submit();
			}
		}
		</script> 
	</head>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			<div class="content clb">
				<h2>See Our <span>Lela Rose</span> Collection</h2>
				<!--shopLeft-->
				<div class="shopLeft fl">
				    
				    <!--imglist-->
				    <div class="imglist">
				        <div class="bigImg">
					<a href="/publish/skin/images/img1_b.jpg" class="jqzoom" rel='gal'>
				            <img src="[$imgUrl]" alt="[$titleCN]"  width="334" height="418" >
					    <!-- <img src="/publish/skin/images/img1_m.jpg" alt="大图">-->
					</a>
				            <span class="zoom1 fl">&nbsp;</span><span class="zoom2 fl">&nbsp;</span>
				        </div>
				        
				        <!--smailThum-->
					<!--<pp:if expr="$method!='submit_link'">-->
						 <ul class="smailThum clb">
				            <li>
                      <a class="zoomThumbActive" href='javascript:;' rel="{gallery: 'gal', smallimage: '/publish/skin/images/img1_m.jpg',largeimage: '/publish/skin/images/img1_b.jpg'}">
                      <img src="/publish/skin/images/img1_s.jpg"></a>
                    </li>
				            <li class="smailThumImg">
                    <a href='javascript:;' rel="{gallery: 'gal', smallimage: '/publish/skin/images/img2_m.jpg',largeimage: '/publish/skin/images/img2_b.jpg'}">
                      <img src="/publish/skin/images/img2_s.jpg"></a></li>
                    <li class="smailThumImg">
                    <a href='javascript:;' rel="{gallery: 'gal', smallimage: '/publish/skin/images/img3_m.jpg',largeimage: '/publish/skin/images/img3_b.jpg'}">
                      <img src="/publish/skin/images/img3_s.jpg"></a></li>
                     <li class="smailThumImg">
                    <a href='javascript:;' rel="{gallery: 'gal', smallimage: '/publish/skin/images/img4_m.jpg',largeimage: '/publish/skin/images/img4_b.jpg'}">
                      <img src="/publish/skin/images/img4_s.jpg"></a></li>
				            <li id="click">Click each picture to select.</li>
				        </ul>
					<!--</pp:if>-->
				    </div>
				</div>
				
				<!--shopRight-->
				<div class="shopRight fl">
				    
				    <!--smailNav-->
				    <ul class="smailNav">
                       <li class="first">requirement</li>
                       <li class="smailNavBj">2. service confirm</li>
                       <li class="smailNavBj">3. release order</li>
                       <li class="smailNavBj">4. customer confirm</li>
                       <li class="last">5. pay offer</li>
                    </ul>
                    
                    <!--clothesInfo-->
		    <form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
			<input type="hidden" name="action" value="shop">
			<input type="hidden" name="method" value="addWish">
			<input type="hidden" name="nodeId" value="[$node.0.nodeId]">
			<input type="hidden" name="para[nodeId]" value="[$node.0.nodeGuid]">
			<input type="hidden" name="contentModel" value="[$node.0.appTableName]">
			<input type="hidden" name="para[goodsImgURL]" value="[$result.img]">
			<input type="hidden" name="para[goodsStatus]" value="Open">
			<input type="hidden" name="para[goodsType]" value="outside">
			<input type="hidden" name="para[goodsURL]" value="[$IN.GoodsURL]">

			<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
			<pp:if expr="$name">
				<input type="hidden" name="para[goodsAddUser]" value="[$name]">	
				<input type="hidden" name="isLogin" value="1">	
			<pp:else/>	
				<input type="hidden" name="isLogin" value="0">
				<input type="hidden" name="para[goodsAddUser]" value="[@getSessionID()]">
			</pp:if>

                    <ul class="clothesInfo clb">
                       <li><label>The link you input</label>
                           <input type="text" class="text1" value="[$IN.GoodsURL]"/><span class="more">More details</span>
			   <pp:if expr="$grapRst>0">
				<span class="text1Span">Succeed to grab the page you want to buy,please  please fill the form bellow</span>
			   </pp:if>
                       </li>
                       <li><label> Name  &amp; Description</label>
                           <input name="para[goodsTitleEn]" type="text" class="text2" value="[$titleCN]"/><br />
                           <input name="para[goodsUnitPrice]" type="text" class="text4" value="Input the English name here if you can" onfocus="DOM.empty(this)"/>
                       </li>
                       <li><label>Price (single)</label><input name="para[goodsUnitPrice]" type="text" class="text3" value="[$price]"/><span class="rmb">RMB</span></li>
                       <li class="mb12"><label>Freight</label><input name="para[goodsFreight]" type="text" class="text3" value="[$postage]"/><span class="rmb">RMB</span></li>
                       <li><label>Infomation</label><textarea name="para[goodsNotes]" onfocus="DOM.empty(this)">Please input Color, Size here......</textarea></li>                       
		       
		       <li><label>SHARE</label>
                           <div class="attentionInfo">
                               <span class="email">app</span>
                               <span class="facebook">app</span>
                               <span class="sns">app</span>
                               <span class="google">app</span>
			       <a href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fhaigui.cw1.98er.com%2F&media=http%3A%2F%2Fimg03.taobaocdn.com%2Fbao%2Fuploaded%2Fi3%2FT1ed12Xe0mXXaLnWs4_052005.jpg_310x310.jpg&description=good" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
                            </div> 
                       </li>
                    </ul>
                    
                    <!--clothesform-->
		    
                    <table class="clothesInfoTable clb">
                        <tr>
                            <th class="title">Items Available</th><th class="num">Quantity</th><th class="select">Available Sizes/Colors</th>
                        </tr>
                        <tr>
                            <td style="color:#B6D97E; font-size:12px">Items Available</td><td><input name="ItemQTY" type="text" class="numtext" value="1"/></td>
                            <td>
                                <select name="select" size="1" id="select1" class="selectinput"> 
                                  <option value="1">First, Select Size</option>
                                </select>
                            </td>
                        </tr>
                         <tr>
                            <td class="price">
			    <strong>Floral-Print Faux-Wrap Dress</strong><br />
			    Price (total)
			    <span>￥1012.00</span><br />
			    <span style="color:#76746F; margin-left:0">BGS12_B1LLD</span></td>
			    <td>&nbsp;</td>
                            <td valign="top">
                                <select name="select" size="1" id="select2" class="selectinput">
                                  <option value="2">Then, Select Color</option>
                                </select>
                            </td>    
                        </tr>         
                    </table>
		
                    <!--addtowishlist-->
                    <ul>
                        <li class="addtowishlist fl"><a href="javascript:addCart(0);">1</a></li>
                        <li class="addtoshoppingbag fr"><a href="javascript:addWish(0);" >2</a></li>
                    </ul>
		    <ul>
                        <li><a href="javascript:addCart(0);">1</a></li>
                        <li><a href="javascript:addWish(0);" >2</a></li>
                    </ul>
                    </form>
                    <!--help-->
                    <div class="help">
                        <h2>Need Help?</h2>
                        <p>Call 400 823 823<br />E-mail Us<br />Online Chat<br />Shipping Information<br />Return Policy</p>
                    </div>
				</div>
				
			</div>
			
			<!--foot-->
			<div class="foot clb">
			    
			    <!--footNav-->
				<div class="footNav">
				    About · Data Use Policy · Terms · Help
				</div>
				
				<!--copyRight-->
				<div class="copyRight">
				    <span class="fr">WOWTAOBAO © 2012</span>
				    <ul>
				        <li><a href="#">HOME</a></li>
                        <li id="aHover"><a href="#">SHOPPING</a></li>
                        <li><a href="#">SHARETALK</a></li>
                        <li id="borderNone"><a href="#">SURPRISE</a></li>
				    </ul>
				</div>
			</div>
			
		</div>
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


 <script type="text/javascript" src="/publish/skin/jsfiles/jquery-1.7.1.min.js"></script>   
 <script type="text/javascript" src="/publish/skin/jsfiles/common.js"></script> 
    <script type="text/javascript" src="/publish/skin/jsfiles/jqzoom/js/jqzoom.min.js"></script>
    <script type="text/javascript" src="/publish/skin/jsfiles/do.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('.jqzoom').jqzoom({
                zoomType: 'innerzoom',
                lens:true,
                preloadImages: true,
                alwaysOn:false,
                title:false
            });
    });
    </script>	
	
	
	
	</body>
</html>