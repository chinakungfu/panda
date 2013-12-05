<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>    
	</head>
	<script>
	function checkRadio(name)
	{
		
		var serviceName = $(':radio[name="'+name+'"]:checked').val();
		if(typeof(serviceName) == "undefined")
		{
			alert("Please select a service and then try");
			return false;
		}
	}
	</script>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			<div class="content">
			    <div class="inputAdderss">
			        <h2>You are choosing <span>WOW Premium Service</span> WOW arranges transport</h2>
			        <p>
			            <span class="addressBook">Address Book</span><span class="addressSelect">Select a shipping address</span>
			            <span class="addressBelow">Is the address you'd like to use displayed below? </span>
			        </p>
			        <div class="inputAdderssDl">
    			        <dl>
                            <dt><input type="radio" name="1"/></dt>
                            <dd class="inputAdderssAdd">HAPPY<br />Xingming St <br />dushi huayuan <br />suzhou, jiangsu 215010 <br />China <br />Phone: 18962177512</dd>
                            <dd class="inputAdderssText"><a href="#">Edit</a><a href="#">Delete</a></dd>
                        </dl>
    			        <dl>
                            <dt><input type="radio" name="1"/></dt>
                            <dd class="inputAdderssAdd">HAPPY<br />Xingming St <br />dushi huayuan <br />suzhou, jiangsu 215010 <br />China <br />Phone: 18962177512</dd>
                            <dd class="inputAdderssText"><a href="#">Edit</a><a href="#">Delete</a></dd>
                        </dl>
                        <dl>
                            <dt><input type="radio" name="1"/></dt>
                            <dd class="inputAdderssAdd">HAPPY<br />Xingming St <br />dushi huayuan <br />suzhou, jiangsu 215010 <br />China <br />Phone: 18962177512</dd>
                            <dd class="inputAdderssText"><a href="#">Edit</a><a href="#">Delete</a></dd>
                        </dl>
                    </div>
			    </div>
                <table class="inputAdderssTable">
                    <thead>
                        <tr>
                            <th>Enter a new shipping address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><label>Full Name *</label><input type="text" class="nameText"/><span>*</span></td>
                        </tr>
                        <tr>
                            <td><label>Address Line 1 *</label><input type="text"  class="nameText"/><span>*</span><em>Street address, P.O. box, company name, c/o</em></td>
                        </tr>
                        <tr>
                            <td><label>Address Line 2</label><input type="text"  class="nameText"/><span>*</span><em>Apartment, suite, unit, building, floor, etc.</em></td>
                        </tr>
                        <tr>
                            <td><label>Country *</label><input type="text" class="nameTextC"/><span>*</span></td>
                        </tr>
                        <tr>
                            <td><label>State/Province/Region *  </label><input type="text" class="nameTextC"/><span>*</span></td>
                        </tr>
                        <tr>
                            <td><label>City *</label><input type="text" class="nameTextC"/><span>*</span></td>
                        </tr>
                        <tr>
                            <td><label>Zip *</label><input type="text" class="nameTextC"/><span>please check again</span></td>
                        </tr>
                        <tr>
                            <td><label>Phone 1  *</label><input type="text" class="nameTextC"/><span>*</span></td>
                        </tr>
                        <tr>
                            <td><label>Phone 2</label><input type="text" class="nameTextC"/><span>*</span></td>
                        </tr>
                        <tr>
                            <td><label>Email Address *</label><input type="text" class="nameTextE"/><span>*</span></td>
                        </tr>
                        <tr>
                            <td><p>Shipping your order to someone else?<br />By providing a shipping contact phone and email address, we may contact the<br /> recipient with any questions about delivery </p></td>
                        </tr>
                        <tr>
                            <td><p>Special note for gift givers<br />By including the recipient’s email address, you’re giving us permission to send<br />them a confirmation email.  If this is a gift, there’s a pretty good chance that email<br />will spoil the "surprise" of a cool new gift arriving at their door.</p></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="padding-left:221px"><a href="#" class="fl">Delivery &amp; Processing Rates</a><input type="button" value="BACK" class="contInueChose mr12 fl"/><input type="button" value="CONTINUE" class="contInueChose fl"/></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>