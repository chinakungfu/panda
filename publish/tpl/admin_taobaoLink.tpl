<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>	
	</head>
	<body>
	    <!--最外框-->
		<div class="box">
			<!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			<pp:if expr="$userInfo.0.groupName!='administrator'">
				<script>location.href='index.php[@encrypt_url('action=website&method=login')]'</script>	
			</pp:if>
			
			<!--content info-->
			<div class="content">
			<a name="TOP"></a>
			<form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
					<input type="hidden" name="action" value="admin">
					<pp:if expr="$method=='taobaoLink'">
						<input type="hidden" name="method" value="addLink">
					<pp:elseif expr="$method=='editLink'">
						<input type="hidden" name="method" value="updateLink">
						<input type="hidden" name="linkId" value="[$IN.linkId]">					
					</pp:if>		
								
					<cms action="sql" return="linkInfo" query="SELECT * FROM `cms_publish_link` WHERE linkId='{$IN.linkId}' limit 1 "  />

					<ul class="clothesInfo clb">
						
						<li class="mb12">
							<label> linkId</label>
								
							<input  name="para[linkId]" type="text" class="text2" value="[$linkInfo.data.0.linkId]"/>	
						</li>
						<li class="mb12">
							<label>linkName</label>							
							<input  name="para[linkName]" type="text" class="text2" value="[$linkInfo.data.0.linkName]"/>
						</li>						
						
						
						<li class="mb12">
							<label>linkUrl</label>							
							<input  name="para[linkUrl]" type="text" class="text2" value="[$linkInfo.data.0.linkUrl]"/>	
						</li>
						<li class="mb12">
							<label>parentId</label>							
							<input  name="para[parentId]" type="text" class="text2" value="[$linkInfo.data.0.parentId]"/>
						</li>
						<li class="mb12">
							<label>linkSequence</label>							
							<input  name="para[linkSequence]" type="text" class="text2" value="[$linkInfo.data.0.linkSequence]"/>
						</li>
						<li  class="mb12"><input type="submit" value="SUBMIT"/></li>
						
					</ul>
					

					
					
				</form>
				<cms action="sql" return="linkList" query="SELECT * FROM cms_publish_link order by linkSequence, linkId desc " />
			<loop name="linkList.data" var="var" key="key">
			<ul class="clothesInfo clb">
			<pp:if expr="$var.parentId==-1">
			<li class="mb12">
			<p><a href="#[$var.linkId]"><font size="3" color="red">[$var.linkName]</font></a></p>
			</li>
			</pp:if>
			</ul>
			</loop> 

			
			<loop name="linkList.data" var="var" key="key">
				<pp:if expr="$var.parentId==-1">
					<div class="orderlistPay">		
						
						<table>
							<tr>
								<th width="140px">link Id</th>
								<th width="260px" align="center">link Name</th>
								<th width="180">parent Id</th>
								<th>linkSequence</th> 
								<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
							</tr>
							<tr>
								<a name="[$var.linkId]"></a>	
								<td  align="center" ><font size="3" color="red">[$var.linkId]</font></td>
								<td ><font size="3" color="red">[$var.linkName]</font><BR><a href="#">BACK TO TOP</a></td>
								<td align="center"><font size="3" color="red">[$var.parentId]</font></td>
								<td align="center"><font size="3" color="red">[$var.linkSequence]</font></td>
								<td align="center"> 
								<a href="index.php[@encrypt_url('action=admin&method=delLink&linkId=' . $var.linkId)]">Delete</a>
								</td>
								<td align="center">
								<a href="index.php[@encrypt_url('action=admin&method=editLink&linkId=' . $var.linkId)]">EDIT</a>
								</td>
								<td align="center">
								
								</td>
								
								
							</tr>
							
							<loop name="linkList.data" var="var1" key="key1">
							<pp:if expr="$var1.parentId==$var.linkId">
								<tr>									
									<td  align="center"><font size="2" color="blue">[$var1.linkId]</font></td>
									<td ><font size="2" color="blue">[$var1.linkName]</font><BR><a href="#">BACK TO TOP</a></td>
									<td align="center"><font size="2" color="blue">[$var1.parentId]</font></td>
									<td align="center"><font size="2" color="blue">[$var1.linkSequence]</font></td>
									<td align="center"> 
									<a href="index.php[@encrypt_url('action=admin&method=delLink&linkId=' . $var1.linkId)]">Delete</a>
									</td>
									<td align="center">
									<a href="index.php[@encrypt_url('action=admin&method=editLink&linkId=' . $var1.linkId)]">EDIT</a>
									</td>
									
									
								</tr>
								<loop name="linkList.data" var="var2" key="key2">
									<pp:if expr="$var2.parentId==$var1.linkId">

									<tr>									
									<td  align="center"><font face="verdana" color="green">[$var2.linkId]</font></td>
									<td ><font face="verdana" color="green">[$var2.linkName]</font><BR><a href="#">BACK TO TOP</a></td>
									<td align="center"><font face="verdana" color="green">[$var2.parentId]</font></td>
									<td align="center"><font face="verdana" color="green">[$var2.linkSequence]</font></td>
									<td align="center"> 
									<a href="index.php[@encrypt_url('action=admin&method=delLink&linkId=' . $var2.linkId)]">Delete</a>
									</td>
									<td align="center">
									<a href="index.php[@encrypt_url('action=admin&method=editLink&linkId=' . $var2.linkId)]">EDIT</a>
									</td>
									
									
								</tr>
									</if>
								</loop>

							</pp:if>
								
							</loop>
						</table>

					</div>
				</pp:if>
			</loop> 
		</div>
			<!--foot-->
			
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
		</div>
	</body>
</html>