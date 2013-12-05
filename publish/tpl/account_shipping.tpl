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
			    
			    <div class="orderlistPay">
			    <a name="here"></a>
                        <h2 style="color:#700000">YOUR SHIPPING HISTORY</h2>
                           <table>
                              <tr>
                                 <th width="140px">&nbsp;</th><th width="260px" align="center">Submit time</th><th width="180">Status</th><th>&nbsp;</th> 
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details</td>
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details<br /></td> 
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details</td> 
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details<br /></td> 
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details</td> 
                              </tr>
                           </table>
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