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
   		  <div class="topt"><div class="fontbox">◎ 暂住流动人口管理列表</div></div>
          <div class="cbox">
			<form action="/publish/search.php" method="post" onSubmit="return searchData(this)">
			<input type="hidden" value="[$IN.nodeId]" name="nodeId"/>
			<input type="hidden" value="20" name="pageSize"/>
			<input type="hidden" name="tpl" value="manage/manage_zqgl_jmgl"/>
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="searchtablelist">
            	<tr>
                  <th>村名称</th>
                  <td><input type="text" name="villageName" data-field="villageName" data-action="like" value="" class="admininput"/></td>
                  <th>组名称</th>
                  <td><input type="text" name="groupName" data-field="groupName" data-action="like" value="" class="admininput"/></td>
                  <th>档案号</th>
                  <td><input type="text" name="docNum" data-field="docNum" value="" class="admininput"/></td>
                </tr>
                <tr>
                  <th>户主姓名</th>
                  <td><input type="text" name="householdName" data-field="householdName" data-action="like" value="" class="admininput"/></td>
                  <th>姓名</th>
                  <td><input type="text" name="peopleName" data-field="peopleName" data-action="like" value="" class="admininput"/></td>
                  <th>性别</th>
                  <td>
                  <select name="sex" data-field="sex">
                  	<option value="">不限</option>
                    <option value="男">男</option>
                    <option value="女">女</option>
                  </select>
                  </td>
                </tr>
                <tr>
                  <th>民族</th>
                  <td><input type="text" name="nation" data-field="nation" value="" data-action="like" class="admininput"/></td>
                  <th>出生日期</th>
                  <td><input type="text" name="birthDate" data-field="birthDate" value="" class="admininput"/></td>
                  <th>婚姻状况</th>
                  <td><input type="text" name="marry" data-field="marry" value="" class="admininput"/></td>
                </tr>
                <tr>
                  <th>婚姻状况发生日期</th>
                  <td><input type="text" name="marryDate" data-field="marryDate" value="" class="admininput"/></td>
                  <th>身份证号</th>
                  <td><input type="text" name="idNumber" data-field="idNumber" value="" class="admininput"/></td>
                  <th>联系手机</th>
                  <td><input type="text" name="mobileNum" data-field="mobileNum" value="" class="admininput"/></td>
                </tr>
                <tr><td colspan="6" style="text-align:center; padding:10px 0px 0px 0px;"><input type="submit" value="检索" />&nbsp;&nbsp;<input type="reset" value="重置" /></td></tr>
            </table>
			</form>
            <table cellpadding="0" cellspacing="0" width="770" align="center">
            	<tr><td height="10"></td></tr>
            </table>
            
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th>村名称</th>
                  <th>组名称</th>
                  <th>户主姓名</th>
                  <th>姓名</th>
                  <th>性别</th>
                  <th>民族</th>
                  <th>出生日期</th>
                  <th>婚姻状况</th>
                  <th>户口性质</th>
                  <th>操作</th>
                </tr>
<if test="!empty($data)">    
 	<loop name="data" var="var" key="key">
                <tr>
                  <td>[$var.villageName]</td>
                  <td>[$var.groupName]</td>
                  <td>[$var.householdName]</td>
                  <td>[$var.peopleName]</td>
                  <td>[$var.sex]</td>
                  <td>[$var.nation]</td>
                  <td>[$var.birthDate]</td>
                  <td>[$var.marry]</td>
                  <td>[$var.account]</td>
                  <td><a href="[$var.url]">浏览</a></td>
                </tr>
    </loop>
<else>
<cms action="list" return="allList" nodeid="{$node.nodeGuid}" where="c.householdCodes != '520111101'" OrderBy="i.publishDate DESC" num="page-20"/>
 <loop name="allList.data" var="var" key="key">
                <tr>
                  <td>[$var.villageName]</td>
                  <td>[$var.groupName]</td>
                  <td>[$var.householdName]</td>
                  <td>[$var.peopleName]</td>
                  <td>[$var.sex]</td>
                  <td>[$var.nation]</td>
                  <td>[$var.birthDate]</td>
                  <td>[$var.marry]</td>
                  <td>[$var.account]</td>
                  <td><a href="[$var.url]">浏览</a></td>
                </tr>
    </loop>
</if>         
                <tr>
                  <td colspan="12">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td width="34%" style="text-align:left; padding-left:10px;"></td>
                    	  <td width="66%" style="text-align:right; padding-right:10px;">
<if test="!empty($data)">    
<include file="manage/manage_search_page.tpl" type="tpl" page="$page"/>
<else>
<pp:var name="listPage" value="@listPageUrl($allList.pageinfo,'../publish/index.php',10,"nodeId={$IN.nodeId}")" />
  <include file="manage/manage_page.tpl" type="tpl" global="1" pageInfo="$listPage"/>
</if>
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
