<?php import('core.util.RunFunc'); ?>
<?php $site_title = runFunc('getGlobalModelVar',array('Site_Name'));
$seo_settings = runFunc("getSeoSettings");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title><?php echo $site_title;?></title>
		<meta content="index, follow" name="robots">
		<meta content="<?php echo $seo_settings[0]["seoKeywords"];?>" name="keywords">
		<meta content="<?php echo $seo_settings[0]["seoDescription"];?>" name="description">
		<link href="/skin/style/reset.css" rel="stylesheet" type="text/css"/>
		<link href="/skin/style/shop.css" rel="stylesheet" type="text/css"/>
		<link href="/skin/style/base.css" rel="stylesheet" type="text/css"/>
		<link href="/skin/style/style.css" rel="stylesheet" type="text/css"/>
		<!--[if lt IE 9]><script src="/skin/js/ie6/warning.js"></script><script>window.onload=function(){e("/skin/js/ie6/")}</script><![endif]-->
	</head>

<body>
<div class="bj">


  <div class="m1"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=shopindex'));?>" title="shopping"><img src="/skin/images/mainnew1_01.png" width="205" height="50" alt="shopping"></a></div>
  </br>
  <div class="c"></div>

  <div class="m2"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=groupBuySingleMain'));?>" title="group buy">
  <img src="/skin/images/mainnew1_02.png"  width="205" height="50" alt="group buy"></a></div>

    <div class="mlogo"><a href="#"><img src="/skin/images/mainnew1_logo.png" ></a></div>
  <div class="c"></div>


  <div class="m3"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=listMain'));?>" title="collection">
  <img src="/skin/images/mainnew1_03.png"  width="205" height="50" alt="collection"></a></div>

  <div class="m4"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=circlesMain'));?>" title="WOW BAZAAR"><img src="/skin/images/mainnew1_04.png" width="205" height="50" alt="WOW BAZAAR"></a></div>

  <div class="c"></div>
  <div class="m5"><img src="/skin/images/yh.png" width="153" height="22"></div>
  <div class="m6"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=aboutUs'));?>">About</a> ·
	    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=datausepolicy'));?>">Data Use Policy</a>
	      ·
	     <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=terms'));?>">Terms</a> ·
	     <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help</a><br/>
    WOWSHOPPING &copy; 2012 <span><script src="http://s25.cnzz.com/stat.php?id=5062744&web_id=5062744&show=pic" language="JavaScript"></script></span></div>
</div>
</body>
</html>