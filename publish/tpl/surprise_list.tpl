<cms action="node" return="node" nodeid="{$IN.nodeId}"/>
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
			
			<!--content info-->
			<div class="surprise clb">

				<pp:include file="common/surprise_category.tpl" type="tpl"/>
				<div class="surpriseContent fl">
					<pp:var name="titleLeft" value="substr($node.nodeName, 0,9)" />
					<pp:var name="titleRight" value="substr($node.nodeName,10)" />
				    <h2>[$titleLeft] <span>[$titleRight]</span></h2>
				    
				    
				    <cms action="sql" return="surpriseSite" query="SELECT * FROM `cms_publish_goods` WHERE `nodeId`='{$IN.nodeId}' order by `goodsid` DESC"  num="page-8"/>
				    <pp:var name="listPage" value="@listPageUrl($surpriseSite.pageinfo,'../publish/index.php',10,"nodeId={$IN.nodeId}")" />
					 <include file="surpriseItem_page.tpl" type="tpl" global="1" pageInfo="$listPage"/>
				    <div class="surpriseContInfo clb">
				    
				    <loop name="surpriseSite.data" var="var" key="key">
				        <dl>
                            <dt><a href="/publish/index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $var.goodsid )]"><img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="[$var.goodsTitleCN]"/></a></dt>
			    <pp:var name="SinglePrice" value="number_format($var.goodsUnitPrice, 2, '.', ',')"/>
                            <dd> <a href="/publish/index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $var.goodsid )]">[$var.goodsTitleEn]</a></dd>
                            <dd class="yuanWen">￥ &nbsp;[$SinglePrice]</dd>
                        </dl>
			</loop> 
                        
				    </div>
				</div>
			</div>
			
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>