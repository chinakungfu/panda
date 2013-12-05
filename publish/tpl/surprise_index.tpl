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

		<pp:include file="common/surprise_category.tpl" type="tpl"/>
		<div class="surpriseCent fl">
		<cms action="sql" return="surpriseBigImg" query="SELECT * FROM `cms_publish_goods` WHERE  goodsid='222' limit 1"/>
			<a href="/publish/index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $surpriseBigImg.data.0.goodsid )]"><img src="../web-inf/lib/coreconfig/[$surpriseBigImg.data.0.goodsImgURL]" alt="[$surpriseBigImg.data.0.goodsTitleCN]"/></a>
			<pp:var name="SinglePrice" value="number_format($surpriseBigImg.data.0.goodsUnitPrice, 2, '.', ',')"/>
			<span>
				<p id="surpriseCentP">
					<a href="/publish/index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $surpriseBigImg.data.0.goodsid )]">[$surpriseBigImg.data.0.goodsTitleEn]</a>
					<em>￥ &nbsp;[$SinglePrice]</em>
				</p>
			</span>
		</div>
		<cms action="sql" return="surpriseSmallImg" query="SELECT * FROM `cms_publish_goods` WHERE  goodsid in ('214','216','217','219')"/>
		<div class="surpriseRight fr">
			<h2 class="surpriseRightH2">THIS WEEK <span>SPECIAL</span></h2>
			<loop name="surpriseSmallImg.data" var="var" key="key">
			<dl>
				<dt><a href="/publish/index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $var.goodsid )]"><img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="[$var.goodsTitleCN]"/></a></dt>
				<pp:var name="SinglePrice" value="number_format($var.goodsUnitPrice, 2, '.', ',')"/>
				<dd> <a href="/publish/index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $var.goodsid )]">[$var.goodsTitleEn]</a></dd>
				<dd class="yuanWen">￥ &nbsp;[$SinglePrice]</dd>
			</dl>
			</loop>
		</div>
	</div>
	<!--foot-->
	<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>

</div>
</body>
</html>