<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
body{font-size:14px; margin:1em;}
.listTable{margin:1.4em 0;border-collapse:collapse;}
.listTable th{background:#f0f0f0; background:url(skin/images/bg_title.gif) repeat-x; white-space:nowrap;}
.listTable tr:hover{background:#f8f8f8;}
.listTable th, .listTable td{border:1px solid #e6e6e6;text-align:center;}
li{float:left; list-style:none; margin:0 5px;}
ul a{float:left; margin:0 5px;}
</style>
<script type="text/javascript">
var fieldName="[$IN.fieldName]";
function add(value,text){
	text=text||value;
	window.opener.addCustomLinks(fieldName,value,text);
}
</script>
<BODY>
<?php import("core.apprun.cmsware.CmswareNode"); ?>
<pp:var name="node" value="new Node()"/>
<pp:var name="currentNode" value="$node->getNodeInfo($IN.nodeId)"/>
<div>
  <table width="98%">
  	<tr>
    	<td>[<a href="javascript:self.close()">关闭</a>]</td>
        <td align="right">
        	<form action="index.php[@encrypt_url('action=cms&method=pickerContent')]" method="post">
				<input type="hidden" name="action" value="cms"/>
				<input type="hidden" name="method" value="pickerContent"/>
				<input type="hidden" name="fieldName" value="[$IN.fieldName]"/>
				<select id="oNodeId" name="nodeId" onchange="this.form.submit()">
					<option value="">--选择结点--</option>
					<pp:var name="nodeStr" value="getAllNodeForSelect()"/>
					[$nodeStr]
				</select>
			</form>
        </td>
    </tr>
  </table>
  <!--
  <table cellpadding="0" cellspacing="2" width="98%" height="19" border="0">
    <form action="" method="get">
      <tr>
        <td height="20" align="right" nowrap="nowrap" >按日期查询:</td>
        <td height="20" align="left" nowrap="nowrap"   ><INPUT TYPE="text" NAME="dTime" size=12 id="dTime"><INPUT name="Go" TYPE="button" value="Go"></td>
        <td height="20" align="right" nowrap="nowrap" >关键字查询: </td>
        <td   height="20" nowrap="nowrap" ><INPUT TYPE="text" NAME="SearchKeywords" id="SearchKeywords" size=18 value=""><INPUT name="Go" TYPE="button"  value="Go" onClick="doing('keyword_search')"></td>
      </tr>
    </form>
  </table>
</div>
-->
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" class="listTable">
  <form method="post" action="">
    <tr>
      <th width="11%">ID</th>
      <th width="68%">标题</th>
      <th width="21%">发布日期</th>
    </tr>
	<cms action="list" return="list" nodeid="{$currentNode.nodeGuid}" num="page-10" returnkey="title"/>
	<loop name="list.data" var="var" key="key">
    <tr>
      <td align="center" noWrap>[$var.publishId]</td>
      <td noWrap  style="cursor:hand"><a href="javascript:add([$var.publishId],'[$var.title]')">[$var.title]</a></td>
      <td align="center" noWrap >[@date('Y-m-d H:i:s',$var.publishDate)]</td>
    </tr>
	</loop>
	<tr>
		<td colspan="3" align="center">[@listPage($list.pageinfo,"index.php",'5',"action=cms&method={$IN.method}&nodeId={$IN.nodeId}&fieldName={$IN.fieldName}")]</td>
	</tr>
  </form>
</table>
</BODY>
</HTML>
