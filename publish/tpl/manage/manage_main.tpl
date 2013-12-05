<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link rel="stylesheet" type="text/css" media="screen" href="/skin/css/adminstyle.css" />
</head>

<body class="rightbody">
<div class="mainbox">
	<div class="yplace">
    	<div class="cfont">
<pp:include file="manage_yplace.tpl" type="tpl"/>
        </div>
    </div>
    
    <div class="block">
   	  <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 课题介绍</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center">
                <tr>
                  <td width="23%" height="auto" valign="middle"><img src="/skin/images/intro_pic.jpg" width="161" height="102" border="0" /></td>
                  <td width="77%" valign="middle" class="introfont">
<cms action="list" return="introC" where="i.pink = '1'" nodeid="KTJSC3GX" num="1"/>
    <loop name="introC.data" var="var" key="key">
    <pp:var name="intro" value="Csubstr(strip_tags($var.content),0,195)" />
&nbsp;&nbsp;&nbsp;&nbsp;[$intro]<a href="[$var.url]">【详细】</a>
	</loop>
                  </td>
                </tr>
            </table>
          </div>
      </div>
      <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 住区管理</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center">
                <tr>
                  <td class="piclistbox"><a href="/publish/search.php?nodeId=JMGLZT1m&pageSize=20&tpl=manage/manage_zqgl_jmgl"><img src="/skin/images/jmgl.jpg" width="104" height="75" border="0" /></a><br /><a href="/publish/search.php?nodeId=JMGLZT1m&pageSize=20&tpl=manage/manage_zqgl_jmgl">居民管理</a></td>
                  <td class="piclistbox"><a href="/publish/search.php?nodeId=MZGLPj5b&pageSize=20&tpl=manage/manage_mzgl"><img src="/skin/images/mzgl.jpg" width="104" height="75" border="0" /></a><br /><a href="/publish/search.php?nodeId=MZGLPj5b&pageSize=20&tpl=manage/manage_mzgl">民宅管理</a></td>
                  <td class="piclistbox"><a href="/publish/search.php?nodeId=JDGLSnOB&pageSize=20&tpl=manage/manage_street"><img src="/skin/images/jdgl.jpg" width="104" height="75" border="0" /></a><br /><a href="/publish/search.php?nodeId=JDGLSnOB&pageSize=20&tpl=manage/manage_street">行政管理</a></td>
                  <td class="piclistbox"><a href="/publish/search.php?nodeId=GGSSGLjzF1&pageSize=20&tpl=manage/manage_fenlei"><img src="/skin/images/ggssgl.jpg" width="104" height="75" border="0" /></a><br /><a href="/publish/search.php?nodeId=GGSSGLjzF1&pageSize=20&tpl=manage/manage_fenlei">公共设施管理</a></td>
                  <!--<td class="piclistbox"><a href="#"><img src="/skin/images/kdgl.jpg" width="104" height="75" border="0" /></a><br /><a href="#">空地管理</a></td>
                  <td class="piclistbox"><a href="#"><img src="/skin/images/wwdwgl.jpg" width="104" height="75" border="0" /></a><br /><a href="#">文物单位管理</a></td>
                  -->
                </tr>
            </table>
          </div>
      </div>
      <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 规划建设管理</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center">
                <tr>
                  <td valign="top">
                  	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                    	<tr>
                          <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">古镇资料库</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php[@encrypt_url('action=manage&method=gzzlc&nodeId=GZXZcqTB')]">更多>></a></td>
                            	</tr>
                            <cms action="list" return="zlkList" nodeid="GZXZcqTB" OrderBy="i.publishDate DESC" num="4"/>
     							<loop name="zlkList.data" var="var" key="key">    
                                <tr><td colspan="2" class="fk_listT"><a href="[$var.url]">· [@CsubStr( $var.title , 0, 27)]</a></td></tr>
                                </loop>
                            </table>
                          </td>
                          <td width="4%"></td>
                          <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">规划项目库</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php[@encrypt_url('action=manage&method=planning&nodeId=GHXMKAlsF')]">更多>></a></td>
                            	</tr>
                                <cms action="list" return="zlkList" nodeid="GHXMKAlsF" OrderBy="i.publishDate DESC" num="4"/>
     							<loop name="zlkList.data" var="var" key="key">    
                                <tr><td colspan="2" class="fk_listT"><a href="[$var.url]">· [@CsubStr( $var.planName , 0, 27)]</a></td></tr>
                                </loop>
                            </table>
                          </td>
                    	</tr>
                        <tr><td height="10"></td></tr>
                        <tr>
                    	  <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">建设项目库</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php[@encrypt_url('action=manage&method=jsxmc&nodeId=JSXMKP9Wq')]">更多>></a></td>
                            	</tr>
                            <cms action="list" return="zlkList" nodeid="JSXMKP9Wq" OrderBy="i.publishDate DESC" num="4"/>
     							<loop name="zlkList.data" var="var" key="key">    
                                <tr><td colspan="2" class="fk_listT"><a href="[$var.url]">· [@CsubStr( $var.proName , 0, 27)]</a></td></tr>
                                </loop>
                            </table>
                          </td>
                          <td width="4%"></td>
                    	  <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">规划建设动态</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php[@encrypt_url('action=manage&method=list&nodeId=GHJSDTmDgN')]">更多>></a></td>
                            	</tr>
                            <cms action="list" return="zlkList" nodeid="GHJSDTmDgN" OrderBy="i.publishDate DESC" num="4"/>
     							<loop name="zlkList.data" var="var" key="key">    
                                <tr><td colspan="2" class="fk_listT"><a href="[$var.url]">· [@CsubStr( $var.title , 0, 27)]</a></td></tr>
                                </loop>
                            </table>
                          </td>
                        </tr>
                    </table>
                  </td>
                </tr>
            </table>
          </div>
      </div>
      
      <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 社会协同管理</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center">
                <tr>
                  <td valign="top">
                  	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                    	<tr>
                          <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">公告通知</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php[@encrypt_url('action=manage&method=list&nodeId=GGTZWHLHGd')]">更多>></a></td>
                            	</tr>
                            <cms action="list" return="zlkList" nodeid="GGTZWHLHGd" OrderBy="i.publishDate DESC" num="4"/>
     							<loop name="zlkList.data" var="var" key="key">    
                                <tr><td colspan="2" class="fk_listT"><a href="[$var.url]">· [@CsubStr( $var.title , 0, 27)]</a></td></tr>
                                </loop>
                            </table>
                          </td>
                          <td width="4%"></td>
                    	  <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">公众调查</td>
                            	  <td width="24%" class="fk_boxM"><a href="#">更多>></a></td>
                            	</tr>
                            <cms action="list" return="zlkList" nodeid="GZDCCJOfXy" OrderBy="i.publishDate DESC" num="4"/>
     							<loop name="zlkList.data" var="var" key="key">    
                                <tr><td colspan="2" class="fk_listT"><a href="[$var.url]">· [@CsubStr( $var.title , 0, 27)]</a></td></tr>
                                </loop>
                            </table>
                          </td>
                    	</tr>
                    </table>
                  </td>
                </tr>
                <tr><td height="10"></td></tr>
                <tr>
                  <td valign="top">
                  	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                    	<tr>
                          <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">办事指南</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php[@encrypt_url('action=manage&method=bslist&nodeId=BSZNqUoC')]">更多>></a></td>
                            	</tr>
                            <cms action="list" return="zlkList" nodeid="BSZNqUoC" OrderBy="i.publishDate DESC" num="4"/>
     							<loop name="zlkList.data" var="var" key="key">    
                                <tr><td colspan="2" class="fk_listT"><a href="[$var.url]">· [@CsubStr( $var.title , 0, 27)]</a></td></tr>
                                </loop>
                            </table>
                          </td>
                          <td width="4%"></td>
                    	  <td width="48%" valign="top">
                          	<table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                  <td width="76%" class="fk_boxT">办事文档</td>
                            	  <td width="24%" class="fk_boxM"><a href="/publish/index.php[@encrypt_url('action=manage&method=bslist&nodeId=BSWDb6ps')]">更多>></a></td>
                            	</tr>
                            <cms action="list" return="zlkList" nodeid="BSWDb6ps" OrderBy="i.publishDate DESC" num="4"/>
     							<loop name="zlkList.data" var="var" key="key">    
                                <tr><td colspan="2" class="fk_listT"><a href="[$var.url]">· [@CsubStr( $var.title , 0, 27)]</a></td></tr>
                                </loop>
                            </table>
                          </td>
                    	</tr>
                    </table>
                  </td>
                </tr>
            </table>
          </div>
      </div>
      <div class="copyrightBox">
      	<div class="cboxc">
<include file="manage/manage_inc_copyright.tpl" type="tpl"/>
        </div>
      </div>
    </div>
    
</div>
</body>
</html>
