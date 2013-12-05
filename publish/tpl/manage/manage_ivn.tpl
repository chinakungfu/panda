<include file="manage/manage_check.php" type="tpl"/><cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<cms action="content" return="listcontent" nodeid="{$IN.nodeId}" contentid="{$IN.id}"/>
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
   		  <div class="topt"><div class="fontbox">◎ [$node.nodeName]内容详情</div></div>
          <div class="cbox">
<?php
global $IN;
?>
<cms action="list" return="ans" nodeid="WTDAGLANR3" where="c.invId={$IN.id}"/>
<pp:var name="ansfield" value="array('result0', 'result1', 'result2', 'result3', 'result4', 'result5', 'result6', 'result7', 'result8', 'result9')"/>
<form action="app.php?action=add&con=ivn&nodeId=DCJHyCjc&multi=1" method="post">
            <form action="app.php?action=add&con=ivn&nodeId=DCJHyCjc&multi=1" method="post">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <td style="text-align:left; line-height:35px; padding-left:10px; width:100%; font-size:16px; font-weight:bold;">[$listcontent.title]</td>
                </tr>
                <loop name="ans.data" var="var" key="key">
                <pp:var name="KEY" value="$key+1"/>
                <tr>
                  <th style="text-align:left; padding-left:10px; width:100%;">[$KEY]、[$var.title]</th>
                </tr>
                <tr>
                  <td style="padding:10px 0px 10px 10px;">
                  <if test="$var.resultType=='radio'">
                    <input type="hidden" name="ansId[[$key]]" value="[$var.id]"/>
                    <input type="hidden" name="resultText[[$key]]" value=""/>
                    <loop name="ansfield" var="field" key="i">
                        <if test="empty($var.{$field})"><?php break; ?></if>
                        <pp:var name="v" value="pow(2, $i)"/>
                        <label><input type="radio" name="resultValue[[$key]]" value="[$v]"/>[$var.{$field}]</label>&nbsp;&nbsp;
                    </loop>
                  <elseif test="$var.resultType=='checkbox'">
                    <input type="hidden" name="ansId[]" value="[$var.id]"/>
                    <input type="hidden" name="resultText[[$key]]" value=""/>
                    <loop name="ansfield" var="field" key="i">
                        <if test="empty($var.{$field})"><?php break; ?></if>
                        <pp:var name="v" value="pow(2, $i)"/>
                        <label><input type="checkbox" name="resultValue[[$key]][]" value="[$v]"/>[$var.{$field}]</label>&nbsp;&nbsp;
                    </loop>
                   <elseif test="$var.resultType=='text'"> 
                   	<input type="hidden" name="ansId[[$key]]" value="[$var.id]"/>
                    <textarea name="resultText[[$key]]" rows="3" cols="35"></textarea>
                    <input type="hidden" name="resultValue[[$key]]" value="0"/>
                   </if> 
                  </td>
                </tr>
                </loop>
                <tr>
                  <td height="50"><input type="submit" value="提交"/>&nbsp;&nbsp; <a href="[@encrypt_url('action=manage&method=ivnResult&id='. $IN.id)]">查看投票结果</a></td>
                </tr>
                
            </table>
            </form>
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
