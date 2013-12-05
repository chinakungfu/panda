<include file="manage/manage_check.php" type="tpl"/><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左边导航</title>
<LINK href="/skin/css/adminstyle.css" type="text/css" rel="stylesheet"/>
<LINK href="/skin/js/simpletree/jquery.simple.tree.css" type="text/css" rel="stylesheet"/>
<LINK href="/skin/css/leftmenu.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="/skin/js/jquery.js"></script>
<script type="text/javascript" src="/skin/js/simpletree/jquery.simple.tree.js"></script>
<script type="text/javascript">
$(function(){
	$('ul.simpleTree').simpleTree({
		drag		: false,			//禁止拖动结点
		animate		: true,
		afterClick	: function(node){	//添加结点单击事件
			//node为jQuery对象:  $('li')
			if(node.find('span:first').attr('href')) parent.frames['mainFrame'].location=node.find('span:first').attr('href');
		}
	});
});
</script>
</head>
<body>
<div class="leftbox">
  <div class="top"></div>
  <div class="middle">
    <ul class="simpleTree">
      <li class="root"><span style="padding-left:10px;"><a target="mainFrame" href="/publish/index.php?LCMSPID=ADEHbVUjVG4Ca1I8BjwKbVA%2BXm4BMFA1BmdTego%2BUGYDJwVkBWgBNgQ%2FAG1XMQBjDm8%3D"><font class="leftMenufont_home">系统首页</font></a></span>
        <ul>
          <li class="open"><span href="/publish/index.php?LCMSPID=BzZVPwJ0Bz0GbwZoUGoJbg9hX29VZFE0AGFVfF1pBzFXc1Q1AWxVYg02UjFTOwtvVywAO11jUiRScAFgW2cAJAckVRUCZAdpBjIGMlBxCW0Pb19lVWBRGgBgVWddTwcAV01UDgFAVTUNTFIK')]"><font class="leftMenufont_2">课题介绍</font></span></li>
          <li class="open"><span><font class="leftMenufont_2">住区管理</font></span>
          	<ul>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=jmglzzrklist')]">> 暂住流动人口管理</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=jmgllist&nodeId=JMGLZT1m')]">> 居民管理</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=mzgllist&nodeId=MZGLPj5b')]">> 民宅管理</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=street&nodeId=JDGLSnOB')]">> 街道管理</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=fenlei&nodeId=GGSSGLjzF1')]">> 公共设施管理</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=lyblist&nodeId=LYGLQ6rM')]">> 留言板</span></li>
            </ul>
          </li>
          <li class="open"><span><font class="leftMenufont_2">规划建设管理</font></span>
            <ul>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=list&nodeId=GHJSDTmDgN')]">> 规划建设动态</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=gzzlc&nodeId=GZXZcqTB')]">> 古镇资料库</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=planning&nodeId=GHXMKAlsF')]">> 规划项目库</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=jsxmc&nodeId=JSXMKP9Wq')]">> 建设项目库</span></li>
            </ul>
          </li>
          <li class="open"><span><font class="leftMenufont_2">社会协同管理</font></span>
            <ul>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=list&nodeId=GGTZWHLHGd')]">> 公告通知</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=list&nodeId=GZDCCJOfXy')]">> 公众调查</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=bslist&nodeId=BSZNqUoC')]">> 办事指南</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=bslist&nodeId=BSWDb6ps')]">> 办事文档</span></li>
            </ul>
          </li>
          <li class="open"><span><font class="leftMenufont_2">旅游资源管理</font></span>
          	<ul>
              <li><span href="">> 旅游动态</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=tour&method=jdlist&nodeId=LYJDR5si')]">> 旅游景点</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=tour&method=linecontent&nodeId=LYXL4Mhb')]">> 旅游线路</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=manage&method=fenlei&nodeId=WXDWGLCmFf')]">> 文物建筑</span></li>
              <li><span href="/publish/index.php[@encrypt_url('action=tour&method=storeindex&nodeId=LYSPLLhC')]">> 旅游商品</span></li>
			  <li><span href="/publish/index.php[@encrypt_url('action=tour&method=sjlist&nodeId=CXSJJA11')]">> 商家管理</span></li>
            </ul>
          </li>
          <li class="open"><span><font class="leftMenufont_2">系统设置</font></span></li>
          <li style="padding-top:20px; background:none;">系统开发：贵州惠智公司(0851-8150378)</li>
        </ul>
      </li>
    </ul>
  </div>
  <div class="bottom"></div>
</div>
</body>
</html>
