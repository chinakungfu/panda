<?php import('core.util.RunFunc'); ?>
<?php if ($this->_tpl_vars["method"]=='submit_link'){?>
	<?php $this->_tpl_vars["result"]=runFunc('GetGoodsInfo',array($this->_tpl_vars["IN"]["GoodsURL"])); ?>

	<?php if ($this->_tpl_vars["result"]=='-1'){?>
		<?php $this->_tpl_vars["titleCN"]=''; ?>
		<?php $this->_tpl_vars["price"]=''; ?>
		<?php $this->_tpl_vars["postage"]=''; ?>
		<?php $this->_tpl_vars["imgUrl"]=''; ?>
		<?php $this->_tpl_vars["grapRst"]='-1'; ?>
	<?php } elseif (!is_array($this->_tpl_vars["result"])){ ?>
		<?php $this->_tpl_vars["titleCN"]=''; ?>
		<?php $this->_tpl_vars["price"]=''; ?>
		<?php $this->_tpl_vars["postage"]=''; ?>
		<?php $this->_tpl_vars["imgUrl"]=''; ?>
		<?php $this->_tpl_vars["grapRst"]='-1'; ?>
	<?php }else{ ?>
		<?php if ($this->_tpl_vars["result"]["title"]<0){?>
			<?php $this->_tpl_vars["titleCN"]='0'; ?>
		<?php }else{ ?>
			<?php $this->_tpl_vars["titleCN"]=$this->_tpl_vars["result"]["title"]; ?>
		<?php } ?>
		<?php if ($this->_tpl_vars["result"]["price"]<0){?>
			<?php $this->_tpl_vars["price"]='0'; ?>
		<?php }else{ ?>
			<?php $this->_tpl_vars["price"]=$this->_tpl_vars["result"]["price"]; ?>
		<?php } ?>
		<?php if ($this->_tpl_vars["result"]["postage"]<0){?>
			<?php $this->_tpl_vars["postage"]='0'; ?>
		<?php }else{ ?>
			<?php $this->_tpl_vars["postage"]=$this->_tpl_vars["result"]["postage"]; ?>
		<?php } ?>
		<?php if ($this->_tpl_vars["result"]["img"]<0){?>
			<?php $this->_tpl_vars["imgUrl"]='0'; ?>
		<?php }else{ ?>
			<?php $this->_tpl_vars["imgUrl"]=$this->_tpl_vars["result"]["img"]; ?>
		<?php } ?>
		<?php $this->_tpl_vars["grapRst"]='1'; ?>
	<?php } ?>
<?php } ?>
<?php $this->_tpl_vars["nodeId"]=runFunc('getGlobalModelVar',array('goodsNodle')); ?>
<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>
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
	    
		<div class="box">
		    
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

			
			
			<div class="content clb">
				<h2>See Our <span>Lela Rose</span> Collection</h2>
				
				<div class="shopLeft fl">
				    
				    
				    <div class="imglist">
				        <div class="bigImg">
					<a href="/publish/skin/images/img1_b.jpg" class="jqzoom" rel='gal'>
				            <img src="<?php echo $this->_tpl_vars["imgUrl"];?>" alt="<?php echo $this->_tpl_vars["titleCN"];?>"  width="334" height="418" >
					    
					</a>
				            <span class="zoom1 fl">&nbsp;</span><span class="zoom2 fl">&nbsp;</span>
				        </div>
				        
				        
					
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
					
				    </div>
				</div>
				
				
				<div class="shopRight fl">
				    
				    
				    <ul class="smailNav">
                       <li class="first">requirement</li>
                       <li class="smailNavBj">2. service confirm</li>
                       <li class="smailNavBj">3. release order</li>
                       <li class="smailNavBj">4. customer confirm</li>
                       <li class="last">5. pay offer</li>
                    </ul>
                    
                    
		    <form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
			<input type="hidden" name="action" value="shop">
			<input type="hidden" name="method" value="addWish">
			<input type="hidden" name="nodeId" value="<?php echo $this->_tpl_vars["node"]["0"]["nodeId"];?>">
			<input type="hidden" name="para[nodeId]" value="<?php echo $this->_tpl_vars["node"]["0"]["nodeGuid"];?>">
			<input type="hidden" name="contentModel" value="<?php echo $this->_tpl_vars["node"]["0"]["appTableName"];?>">
			<input type="hidden" name="para[goodsImgURL]" value="<?php echo $this->_tpl_vars["result"]["img"];?>">
			<input type="hidden" name="para[goodsStatus]" value="Open">
			<input type="hidden" name="para[goodsType]" value="outside">
			<input type="hidden" name="para[goodsURL]" value="<?php echo $this->_tpl_vars["IN"]["GoodsURL"];?>">

			<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
			<?php if ($this->_tpl_vars["name"]){?>
				<input type="hidden" name="para[goodsAddUser]" value="<?php echo $this->_tpl_vars["name"];?>">	
				<input type="hidden" name="isLogin" value="1">	
			<?php }else{ ?>	
				<input type="hidden" name="isLogin" value="0">
				<input type="hidden" name="para[goodsAddUser]" value="<?php echo runFunc('getSessionID',array());?>">
			<?php } ?>

                    <ul class="clothesInfo clb">
                       <li><label>The link you input</label>
                           <input type="text" class="text1" value="<?php echo $this->_tpl_vars["IN"]["GoodsURL"];?>"/><span class="more">More details</span>
			   <?php if ($this->_tpl_vars["grapRst"]>0){?>
				<span class="text1Span">Succeed to grab the page you want to buy,please  please fill the form bellow</span>
			   <?php } ?>
                       </li>
                       <li><label> Name  &amp; Description</label>
                           <input name="para[goodsTitleEn]" type="text" class="text2" value="<?php echo $this->_tpl_vars["titleCN"];?>"/><br />
                           <input name="para[goodsUnitPrice]" type="text" class="text4" value="Input the English name here if you can" onfocus="DOM.empty(this)"/>
                       </li>
                       <li><label>Price (single)</label><input name="para[goodsUnitPrice]" type="text" class="text3" value="<?php echo $this->_tpl_vars["price"];?>"/><span class="rmb">RMB</span></li>
                       <li class="mb12"><label>Freight</label><input name="para[goodsFreight]" type="text" class="text3" value="<?php echo $this->_tpl_vars["postage"];?>"/><span class="rmb">RMB</span></li>
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
		
                    
                    <ul>
                        <li class="addtowishlist fl"><a href="javascript:addCart(0);">1</a></li>
                        <li class="addtoshoppingbag fr"><a href="javascript:addWish(0);" >2</a></li>
                    </ul>
		    <ul>
                        <li><a href="javascript:addCart(0);">1</a></li>
                        <li><a href="javascript:addWish(0);" >2</a></li>
                    </ul>
                    </form>
                    
                    <div class="help">
                        <h2>Need Help?</h2>
                        <p>Call 400 823 823<br />E-mail Us<br />Online Chat<br />Shipping Information<br />Return Policy</p>
                    </div>
				</div>
				
			</div>
			
			
			<div class="foot clb">
			    
			    
				<div class="footNav">
				    About · Data Use Policy · Terms · Help
				</div>
				
				
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