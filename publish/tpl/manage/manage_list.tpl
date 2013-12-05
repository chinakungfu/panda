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
   		  <div class="topt"><div class="fontbox">◎ [$node.nodeName]列表</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th width="auto" style="text-align:left; padding-left:10px;">标题名称</th>
                  <th width="100">发布日期</th>
                  <th width="98">操作</th>
                </tr>
<cms action="list" return="allList" nodeid="{$node.nodeGuid}" OrderBy="i.publishDate DESC" num="page-20"/>
     <loop name="allList.data" var="var" key="key">
                <tr>
                  <td style="text-align:left; padding-left:10px;">[$var.title]</td>
                  <td>[@date("Y-m-d", $var.publishDate)]</td>
                  <td><a href="[$var.url]">查看</a></td>
                </tr>
    </loop>
                <tr>
                  <td colspan="3">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td style="text-align:right; padding-right:10px;">
  <pp:var name="listPage" value="@listPageUrl($allList.pageinfo,'../publish/index.php',10,"nodeId={$IN.nodeId}")" />
  <include file="manage/manage_page.tpl" type="tpl" global="1" pageInfo="$listPage"/>
  						  </td>
                   	    </tr>
                    </table>
              </td></tr>
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
