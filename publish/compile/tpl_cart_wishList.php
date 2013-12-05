<?php import('core.util.RunFunc'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Cart</title>
	<link rel="stylesheet" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/css/style.css"/>
	<script type="text/javascript" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/js/jquery.pngFix.js"></script>
	<script type="text/javascript">
		 $(document).ready(function(){ 
				$(document).pngFix(); 
			}); 
	</script>
</head>
<body>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/red_header.tpl
LNMV
);
include($inc_tpl_file);
?>

	<div class="wow-body">
		<div class="wow-body-contain">
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/top_guide.tpl
LNMV
);
include($inc_tpl_file);
?>

			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/wow_left.tpl
LNMV
);
include($inc_tpl_file);
?>

				
			<div class="line2-full left">				
				
				<h3 id="wl-title" class="wow-module-title sec-title">
					WISH LIST
				</h3>
				<table class="itable" cellpadding=0 cellspacing=0>
					<tr>
						<th width="50%" align="left">Item to buy</th>
						<th width="16%"></th>
						<th width="16%" align="center"></th>
						<th width="16%" align="center"></th>
					</tr>
					<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "cartList",
	'nodeid' => "{$this->_tpl_vars["nodeId"]}",
	'where' => "c.UserName ='{$this->_tpl_vars["name"]}' and c.ItemStatus='Wish'",
	'orderby' => "i.publishDate DESC",
	'num' => "3",
 ); 

$this->_tpl_vars['cartList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
					<?php if(!empty($this->_tpl_vars["cartList"]["data"])){ 
 foreach ($this->_tpl_vars["cartList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
					<tr>
						<td>
							<img class="left item-view-s" src="<?php echo $this->_tpl_vars["var"]["IMGURL"];?>" alt=""/>
							<span class="left item-name"><?php echo $this->_tpl_vars["var"]["ItemName"];?></span>
						</td>
						<td>
							<a class="ce" href="">delete</a> <a class="ce" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php<?php echo runFunc('encrypt_url',array('action=wow&method=WishToCart&nodeId=71&cartID=' .$this->_tpl_vars["var"]["cartID"]));?>" >move to cart</a>
						</td>
						<td align="center">RMB <?php echo $this->_tpl_vars["var"]["ItemUnitPrice"];?></td>
						<td align="center">
							
						</td>
					</tr>
					<?php  }
} ?>
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="inner-footer">
		<div class="inner-footer-menu-box">
			<ul id="inner-footer-menu" class="right">
				<li><a href="">About</a></li>
				<li>&bull; </li>
				<li><a href="">Data Use Policy</a></li>
				<li>&bull; </li>
				<li><a href="">Terms</a></li>
				<li>&bull; </li>
				<li><a href="">Help</a></li>
			</ul>
		</div>
		<div class="red-line"></div>
			<p class="inner-copy">WOWTAOBAO &copy; 2012 </p>
	</div>
</body>
</html>