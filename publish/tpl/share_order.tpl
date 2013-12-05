<cms action="sql" return="shareOrderList" query="SELECT * FROM cms_publish_order where orderUser='{$userInfo.0.staffId}'" />
<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
	</head>
	<body>
	    <!--�����-->
		<div class="box">
		    <!--ͷ��-->	
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
             <div class="mySareList">
                 <h2 style="color:#5e97ed">YOUR RECENT ORDER</h2>
	<cms action="sql" return="shareSite" query="SELECT cartIDstr FROM `cms_publish_order` WHERE `orderUser`='{$name}' and `orderStatus`>='4'"/>   
       <pp:var name="shareNum" value="sizeof($shareSite.data)"/>
       <pp:if expr="$shareNum>0">

	       <loop name="shareSite.data" var="var" key="key"> 
			<pp:var name="cartIdString" value="$var.cartIDstr . ',' . $cartIdString"/>		
	       </loop>
       <pp:var name="cartIdString" value="substr($cartIdString,0,-1)"/>

       <cms action="sql" return="shareOrder" query="SELECT a.goodsImgURL,a.goodsid,a.goodsTitleCN,a.goodsTitleEN, a.goodsType FROM cms_publish_goods a, cms_publish_cart b WHERE b.cartId in ({$cartIdString}) and b.ItemGoodsID=a.goodsid"/>    
                 <table>
       
       <loop name="shareOrder.data" var="var" key="key">
		   <tr>
                     <td>
                      <dl>
                       <dt>
		       <pp:if expr="$var.goodsType=='inside'">
					    <img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="bagImg" />
					    <pp:elseif expr="$var.goodsType=='outside'">
					    <img src="[$var.goodsImgURL]" alt="bagImg" />
					    </pp:if>
					    </dt>
                       <dd class="mySareListF00"><strong>[$var.goodsTitleCN]<br />[$var.goodsTitleEN] </strong></dd>
                       <dd class="mySareListF01"><pp:if expr="$var.goodsType=='inside'"><dd class="wowService">WOW SURPRISE SERVICE</dd>
													</pp:if></dd>
                      </dl>
                    </td>
                    <td class="mySareListBtn"><a href="/publish/index.php[@encrypt_url('action=share&method=submitShare&goodsID=' . $var.goodsid )]">Share</a></td>
                   </tr>
          </loop>        
                 </table>
	<pp:else/>
		Sorry, you have not bought anything yet.
	</pp:if>
		 <!--
                  <ul class="imglistSharemainImgList fr">
                  	<li><a href="#">1</a></li>
                  	<li><a href="#">2</a></li>
                  	<li><a href="#">3</a></li>
                  	<li><a href="#">4</a></li>
                  	<li><a href="#">5</a></li>
                  	<li><a href="#">6</a></li>
                  	<li><a href="#">&lt;</a></li>
                  	<li><a href="#">&gt;</a></li>
                  </ul>
		  -->
             </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>