<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link rel="stylesheet" type="text/css" media="screen" href="/skin/css/adminstyle.css" />
<script type="text/javascript" src="/skin/js/jquery.js"></script>
<script type="text/javascript" src="/skin/jquery_search.js"></script>
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
            <form action="/publish/search.php" method="post" onSubmit="return searchData(this)">
			<input type="hidden" value="[$IN.nodeId]" name="nodeId"/>
			<input type="hidden" value="20" name="pageSize"/>
			<input type="hidden" name="tpl" value="manage/manage_planning"/>
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="searchtablelist">
            	<tr>
                  <th>规划名称</th>
                  <td><input type="text" name="planName" data-field="planName" data-action="like" value="" class="admininput"/></td>
                  <th>编制单位</th>
                  <td><input type="text" name="planUnit" data-field="planUnit" data-action="like" value="" class="admininput"/></td>
                  <th>编制时间</th>
                  <td><input type="text" name="startTime" data-field="startTime" value="" class="admininput"/></td>
                </tr>
                <tr>
                  <th>审批单位</th>
                  <td><input type="text" name="spUnit" data-field="spUnit" data-action="like" value="" class="admininput"/></td>
                  <th>审批时间</th>
                  <td><input type="text" name="spTime" data-field="spTime" data-action="like" value="" class="admininput"/></td>
                  <th>审批文号</th>
                  <td><input type="text" name="spFileNum" data-field="spFileNum" data-action="like" value="" class="admininput"/></td>
                </tr>
                <tr><td colspan="6" style="text-align:center; padding:10px 0px 0px 0px;"><input type="submit" value="检索" />&nbsp;&nbsp;<input type="reset" value="重置" /></td></tr>
            </table>
			</form>
            <table cellpadding="0" cellspacing="0" width="770" align="center">
            	<tr><td height="10"></td></tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th>规划名称</th>
                  <th>编制单位</th>
                  <th>编制时间</th>
                  <th>审批单位</th>
                  <th>审批时间</th>
                  <th>审批文号</th>
                  <th>操作</th>
                </tr>
     <loop name="data" var="var" key="key">
                <tr>
                  <td>[$var.planName]</td>
                  <td>[$var.planUnit]</td>
                  <td>[$var.startTime]</td>
                  <td>[$var.spUnit]</td>
                  <td>[$var.spTime]</td>
                  <td>[$var.spFileNum]</td>
                  <td><a href="[$var.url]">查看</a></td>
                </tr>
    </loop>
                <tr>
                  <td colspan="12">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td style="text-align:right; padding-right:10px;">
<include file="manage/manage_search_page.tpl" type="tpl" page="$page"/>
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
