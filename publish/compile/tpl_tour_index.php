<?php import('core.util.RunFunc'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$inc_tpl_file=includeFunc(<<<LNMV
tour_title.tpl
LNMV
);
include($inc_tpl_file);
?>

<link rel="stylesheet" type="text/css" media="screen" href="/skin/css/style.css" />
</head>
<script language='JavaScript'>
function checkSubmitly()
{
	with(document.formly){
 		if(lyName.value=='') {
			alert("姓名不能为空");
			lyName.focus();
			return false;
		}
		if(telephoneNum.value=='') {
			alert("联系电话不能为空");
			telephoneNum.focus();
			return false;
		}
		if(content.value=='') {
			alert("留言内容不能为空");
			content.focus();
			return false;
		}
	}
}
</script>
<body>
<div id="mainboxindex">
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
tour_header.tpl
LNMV
);
include($inc_tpl_file);
?>


    <div id="contentbox" style="height:1064px;">
    	<div class="leftbox">
        	<div class="zqgl">
            	<div class="title"></div>
                <div class="content">
                	<div class="box1"><span>住区管理：</span>通过对古镇的民宅、街道、公共设施等管理，来实现古镇住区管理的规范化、科学化。</div>
                    <div class="box2"><span>规划建设管理：</span>通过对古镇的规划建设信息进行统一管理，让政府决策部门可以对古镇未来的决策提供夯实的基础。</div>
                    <div class="box3"><span>社会协同管理：</span>通过“报修服务”、“住户动态改造”、“公众调查”、“公告通知”等功能，来实现“社会协同、公众参与”的社会管理格局。</div>
                    <div class="loginbox"><a href="#"><img src="/skin/images/but_login.png" border="0" /></a></div>
                </div>
            </div>
            <div class="claer"></div>
            <div class="gzvideo">
            	<div class="title"></div>
                <div class="content">
<SCRIPT type=text/javascript>
    var swf_width=232
    var swf_height=159
    var texts='百年古镇——青岩'
    var files='/skin/qy_intro.flv'
    var config='0:自动播放|1:连续播放|100:默认音量|0:控制栏位置|3:控制栏显示|0x000033:主体颜色|60:主体透明度|0x66ff00:光晕颜色|0xffffff:图标颜色|0xffffff:文字颜色|:logo文字|:logo地址|:结束swf地址'
    document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'+ swf_width +'" height="'+ swf_height +'">');
    document.write('<param name="movie" value="/skin/flvPlayer.swf"><param name="quality" value="high">');
    document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
    document.write('<param name="FlashVars" value="vcastr_file='+files+'&vcastr_title='+texts+'&vcastr_config='+config+'">');
    document.write('<embed src="/skin/flvPlayer.swf" wmode="opaque" FlashVars="vcastr_file='+files+'&vcastr_title='+texts+'&vcastr_config='+config+'" menu="false" quality="high" width="'+ swf_width +'" height="'+ swf_height +'" align="left" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />'); document.write('</object>'); 
    </SCRIPT>
                </div>
            </div>
            <div class="claer"></div>
            <div class="tourmap">
            	<div class="title"></div>
                <div class="content"><img src="/skin/images/left_t_jdfbt_map.png" width="238" height="185" border="0" /></div>
            </div>
            <div class="claer"></div>
            <div class="lybbox">
            	<div class="title"></div>
                <div class="content">
						<table cellpadding="0" cellspacing="0" width="100%" align="center" class="lybboxonline_font">
                        <form name="formly" action="/publish/app.php?action=add&con=appApiTest&nodeId=LYGLQ6rM&referer=/" method="post" enctype="multipart/form-data" onsubmit="return checkSubmitly()">
                            <tr>
                              <td width="20%" height="25" align="right">姓名：</td>
                        	  <td width="80%" align="left"><input type="text" class="lybboxinput" name="lyName" id="lyName" /></td>
                        	</tr>
                            <tr>
                              <td width="20%" height="25" align="right">电话：</td>
                        	  <td width="80%" align="left"><input type="text" class="lybboxinput" name="telephoneNum" id="telephoneNum" /></td>
                        	</tr>
                            <tr>
                              <td width="20%" height="auto" align="right">内容：</td>
                        	  <td width="80%" align="left"><textarea class="lybboxtxtarea" name="content" id="content" rows="3" cols="15"></textarea></td>
                        	</tr>
                            <tr><td colspan="2" height="40" align="center">
                            <input type="submit" style="background:url(/skin/images/left_t_lyb_tj.png) no-repeat center; cursor:pointer; width:54px; height:23px; border:0px;" value="" />&nbsp;&nbsp;<input type="reset" style="background:url(/skin/images/left_t_lyb_cz.png) no-repeat center; cursor:pointer; width:54px; height:23px; border:0px;" value="" /></td></tr>
                        </form>    
                        </table>
                </div>
            </div>
        </div>
        <div class="rightbox">
        	<div class="gztour">
            	<div class="title"></div>
                <div class="content">
                	<div class="intro">
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "introC",
	'where' => "i.pink = '1'",
	'nodeid' => "GZJScohf",
	'num' => "1",
 ); 

$this->_tpl_vars['introC'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    <?php if(!empty($this->_tpl_vars["introC"]["data"])){ 
 foreach ($this->_tpl_vars["introC"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
    <?php $this->_tpl_vars["intro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,165); ?>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars["intro"];?><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">更多>></a>
	<?php  }
} ?>
                    </div>
                </div>
            </div>
            <div class="jdbox">
            	<div class="title">
                	<div class="leftT">景点介绍</div>
                    <div class="rightM"><a href="/publish/index.php?LCMSPID=ATAGbFQiUmgGb1E%2FW2FeIFAwBS5UdgcjVj9VPwEsBT4HOFU4CDdTagxuBmpQPgtyAHsEfAA%2BBWgKag5kDh4FMgFsBkNUD1JLBkRRA1tpXidQNg%3D%3D#"><img src="/skin/images/but_more.png" width="37" height="13" border="0" /></a></div>
                </div>
                <div class="content">
                	<ul>
                <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "jdList",
	'where' => "c.photo != ''",
	'nodeid' => "LYJDR5si",
	'num' => "5",
 ); 

$this->_tpl_vars['jdList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    				<?php if(!empty($this->_tpl_vars["jdList"]["data"])){ 
 foreach ($this->_tpl_vars["jdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    	
                        <li><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["photo"];?>" width="118" height="85" border="0" /></a><br /><a href="#"><?php echo $this->_tpl_vars["var"]["title"];?></a></li>
                    <?php  }
} ?>
                    </ul>
                </div>
            </div>
            <div class="tourlinehd">
       	  		<div class="tlhbox">
                    <div class="tlhtitle">
                        <div class="leftT1">旅游线路</div>
                        <div class="rightM1"><a href="/publish/index.php?LCMSPID=VmcCaFQiADoBaFQ6VW9cIgBgXnUGJAImVj9TOVxxUmlSbQBtBDsBPgdoAG4GZFsyD28HN1VxBWIAagF6D3ADPlZjAnxUJQAaAWNUaVVjXGQAKV5uBjkCZFY3UxVcYVI8Uk4AUAReAR4HNQBNBmlbMw%3D%3D"><img src="/skin/images/but_more.png" width="37" height="13" border="0" /></a></div>
                    </div>
                    <div class="content">
         		<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "lineList",
	'where' => "c.photo != ''",
	'nodeid' => "LYXL4Mhb",
	'num' => "1",
 ); 

$this->_tpl_vars['lineList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    				<?php if(!empty($this->_tpl_vars["lineList"]["data"])){ 
 foreach ($this->_tpl_vars["lineList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?> 
                        <div class="left">
                        	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr><td height="30" align="left"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>" title="<?php echo $this->_tpl_vars["var"]["title"];?>"><font style="font-size:12px; font-weight:bold; color:#333;"><?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 13));?></font></a></td></tr>
                                <tr><td align="left" style="line-height:18px; text-align:left;"><?php $this->_tpl_vars["lineIntro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,66); ?>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars["lineIntro"];?></td></tr>
                            </table>
                        </div>
                        <div class="right">
                        	<div class="top"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["photo"];?>" width="102" height="95" border="0" /></a></div>
                        </div>
                    <?php  }
} ?>    
                    </div>
                 </div>
                 <div class="tlhbox" style="margin-left:19px;">
                    <div class="tlhtitle">
                        <div class="leftT1">旅游活动</div>
                        <div class="rightM1"><a href="/publish/index.php?LCMSPID=UGEHbQdxVmwDagFvV21eIFAwX3RUdgYiA2pTOQonADsAP1Q5V2gGPQFjUHZaMw9qD2RQawYfDWsKMwJBAABVTlBEB0kHS1ZHAzI%3D"><img src="/skin/images/but_more.png" width="37" height="13" border="0" /></a></div>
                    </div>
                    <div class="content">
         				<div class="left">
                        	<ul>
                     <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "hdList",
	'nodeid' => "LYHDGNB7",
	'num' => "5",
 ); 

$this->_tpl_vars['hdList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
                            <?php if(!empty($this->_tpl_vars["hdList"]["data"])){ 
 foreach ($this->_tpl_vars["hdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    	
                                <li><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 12));?></a></li>
                            <?php  }
} ?>
                            </ul>
                        </div>
                        <div class="right">
                     <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "hdList",
	'where' => "c.photo != ''",
	'nodeid' => "LYHDGNB7",
	'num' => "1",
 ); 

$this->_tpl_vars['hdList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>     
                        <?php if(!empty($this->_tpl_vars["hdList"]["data"])){ 
 foreach ($this->_tpl_vars["hdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                        	<div class="top"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["photo"];?>" width="102" height="70" border="0" /></a></div>
                            <div class="bottom"><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 6));?></a></div>
                        <?php  }
} ?>    
                        </div>
                    </div>
                 </div>
            </div>
            <div class="tourstore">
            	<div class="title">
                	<div class="leftT">旅游商品</div>
                    <div class="rightM"><a href="/publish/index.php?LCMSPID=BDUBawJ0UGpVPAdpUWsPcVU1VX5UdgYiA2oGbF5zVm1Rblc6AD9XdwZ0UT5WIwFuUjRWZldjA2QDfwUsADcFOQQwAW0CSVBnVW4HS1EPD1ZVClVHVEgGbANE"><img src="/skin/images/but_more.png" width="37" height="13" border="0" /></a></div>
                </div>
                <div class="content">
                	<ul>
                <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "jdList",
	'where' => "c.photo != ''",
	'nodeid' => "all-LYSPLLhC",
	'num' => "5",
 ); 

$this->_tpl_vars['jdList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    				<?php if(!empty($this->_tpl_vars["jdList"]["data"])){ 
 foreach ($this->_tpl_vars["jdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    	
                        <li><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["photo"];?>" width="81" height="62" border="0" /></a><br /><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 6));?></a></li>
                    <?php  }
} ?>
                    </ul>
                </div>
            </div>
            <div class="cxcompany">
            	<div class="title">
                	<div class="leftT">诚信商家</div>
                    <div class="rightM"><a href="/publish/index.php?LCMSPID=VGUCaAdxV21QOVY4BD4IdlAwUnldfwElUTgBa1l0AzhbZFU4Um0FJQxgAW1RP1ojA3gFfVJsUTwDY1U%2FCBhQZ1Q5AkgHXVdXUBxWHARCCDNQbg%3D%3D"><img src="/skin/images/but_more.png" width="37" height="13" border="0" /></a></div>
                </div>
                <div class="content">
                	<ul>
            	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "jdList",
	'where' => "c.photo != ''",
	'nodeid' => "CXSJJA11",
	'num' => "5",
 ); 

$this->_tpl_vars['jdList'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    				<?php if(!empty($this->_tpl_vars["jdList"]["data"])){ 
 foreach ($this->_tpl_vars["jdList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>    	
                        <li><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["photo"];?>" width="93" height="65" border="0" /></a><br /><a href="<?php echo $this->_tpl_vars["var"]["url"];?>"><?php echo runFunc('CsubStr',array( $this->_tpl_vars["var"]["title"] , 0, 6));?></a></li>
                    <?php  }
} ?>
                    </ul>
                </div>
            </div>
            
            <div class="xzbox">
            	<div class="box1">
                	<div class="left"><img src="/skin/images/right_xz_lswh.png" width="79" height="75" border="0" /></div>
                    <div class="right">
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "xzIntro1",
	'where' => "i.pink = '2'",
	'nodeid' => "GZJScohf",
	'num' => "1",
 ); 

$this->_tpl_vars['xzIntro1'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    <?php if(!empty($this->_tpl_vars["xzIntro1"]["data"])){ 
 foreach ($this->_tpl_vars["xzIntro1"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
    <?php $this->_tpl_vars["intro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,40); ?>
<?php echo $this->_tpl_vars["intro"];?><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">【更多】</a>
	<?php  }
} ?>
                    </div>
                </div>
                <div class="box1" style="margin-left:18px;">
                	<div class="left"><img src="/skin/images/right_xz_gzjz.png" width="79" height="75" border="0" /></div>
                    <div class="right">
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "xzIntro2",
	'where' => "i.pink = '3'",
	'nodeid' => "GZJScohf",
	'num' => "1",
 ); 

$this->_tpl_vars['xzIntro2'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    <?php if(!empty($this->_tpl_vars["xzIntro2"]["data"])){ 
 foreach ($this->_tpl_vars["xzIntro2"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
    <?php $this->_tpl_vars["intro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,40); ?>
<?php echo $this->_tpl_vars["intro"];?><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">【更多】</a>
	<?php  }
} ?>
                    </div>
                </div>
                <div class="box1" style="border-bottom:none;">
                	<div class="left"><img src="/skin/images/right_xz_whgj.png" width="79" height="75" border="0" /></div>
                    <div class="right">
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "xzIntro3",
	'where' => "i.pink = '4'",
	'nodeid' => "GZJScohf",
	'num' => "1",
 ); 

$this->_tpl_vars['xzIntro3'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    <?php if(!empty($this->_tpl_vars["xzIntro3"]["data"])){ 
 foreach ($this->_tpl_vars["xzIntro3"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
    <?php $this->_tpl_vars["intro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,40); ?>
<?php echo $this->_tpl_vars["intro"];?><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">【更多】</a>
	<?php  }
} ?>
                    </div>
                </div>
                <div class="box1" style="margin-left:18px; border-bottom:none;">
                	<div class="left"><img src="/skin/images/right_xz_gzjt.png" width="79" height="75" border="0" /></div>
                    <div class="right">
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "xzIntro4",
	'where' => "i.pink = '5'",
	'nodeid' => "GZJScohf",
	'num' => "1",
 ); 

$this->_tpl_vars['xzIntro4'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
    <?php if(!empty($this->_tpl_vars["xzIntro4"]["data"])){ 
 foreach ($this->_tpl_vars["xzIntro4"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
    <?php $this->_tpl_vars["intro"]=Csubstr(strip_tags($this->_tpl_vars["var"]["content"]),0,40); ?>
<?php echo $this->_tpl_vars["intro"];?><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">【更多】</a>
	<?php  }
} ?>
                    </div>
                </div>
            </div>
            
            <div class="ksdh">
            	<div class="content">
                	<a href="#"><img src="/skin/images/index_icov_tq.png" width="194" height="44" border="0" /></a>&nbsp;&nbsp;&nbsp;
                    <a href="#"><img src="/skin/images/index_icov_jt.png" width="194" height="44" border="0" /></a>&nbsp;&nbsp;&nbsp;
                    <a href="#"><img src="/skin/images/index_icov_news.png" width="194" height="44" border="0" /></a>
                </div>
            </div>
        </div>
    </div>
    <?php
$inc_tpl_file=includeFunc(<<<LNMV
tour_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

    
</div>
</body>
</html>
