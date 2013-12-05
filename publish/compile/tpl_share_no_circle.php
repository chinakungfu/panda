<?php import('core.util.RunFunc');
$this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>
</head>
<body onload="window.location.hash = 'here'">
<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	
	$circle = runFunc("getCircleByUserId",array($this->_tpl_vars["name"]));
	$check = runFunc("checkJoin",array($circle[0]["user_id"],$this->_tpl_vars["name"]));
	
	$posts = runFunc("getCircleMyJoinPost",array($this->_tpl_vars["name"],1,5));
	
	$posts_count = runFunc("getCircleMyJoinPost",array($this->_tpl_vars["name"],1,5,true));
	$member_count = runFunc("getCircleMember",array($circle[0]["id"],10,true));
	
	$last_comment = runFunc("getCircleLastActivity",array($circle[0]["id"]));
	getCircleMyJoinPost
	?>
	
<div class="content">
<?php $inc_tpl_file=includeFunc("share/common/header.tpl");
	include($inc_tpl_file);
?>
<div class="circle_page_content">
	<div class="no_posts_word" style="text-align: center;"> The quick brown fox jumps over the lazy dog ^_^ </div>
</div>

</div>
<?php
	$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
	include($inc_tpl_file);
	?>
</body>
</html>