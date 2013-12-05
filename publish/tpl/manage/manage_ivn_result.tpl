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
   		  <div class="topt"><div class="fontbox">◎ 关于[$node.nodeName]内容详情</div></div>
          <div class="cbox">

            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <td style="text-align:left; line-height:35px; padding-left:10px; width:100%; font-size:16px; font-weight:bold;">
<cms action="sql" return="hits" query="select count(distinct r.action) hits from cms_publish_invResult r, cms_publish_invQuesAns a where a.id=r.ansId and a.invId={$IN.id}"/>
总投票数：[$hits.data.0.hits] 
                  </td>
                </tr>
                
<cms action="sql" return="list" query="select a.title, a.resultType, result0 ans0, result1 ans1, result2 ans2, result3 ans3, result4 ans4, result5 ans5, result6 ans6, result7 ans7, result8 ans8, result9 ans9, sum(r.resultValue & 1 != 0) result0, sum(r.resultValue & 2 != 0) result1, sum(r.resultValue & 4 != 0) result2, sum(r.resultValue & 8 != 0) result3, sum(r.resultValue & 16 != 0) result4, sum(r.resultValue & 32 != 0) result5, sum(r.resultValue & 64 != 0) result6, sum(r.resultValue & 128 != 0) result7, sum(r.resultValue & 256 != 0) result8, sum(r.resultValue & 512 != 0) result9 from cms_publish_invQuesAns a, cms_publish_invResult r where r.ansId=a.id and a.invId={$IN.id} group by a.id"/>

<pp:var name="ansfield" value="array('result0', 'result1', 'result2', 'result3', 'result4', 'result5', 'result6', 'result7', 'result8', 'result9')"/>
        <loop name="list.data" var="var" key="key">
                <tr>
                  <th style="text-align:left; padding-left:10px; width:100%;">
                  <pp:var name="KEY" value="$key+1"/>
                  [$KEY]、问题：[$var.title]
                  </th>
                </tr>
                <tr>
                  <td style="padding:10px 0px 10px 10px;">
					<if test="$var.resultType=='text'">
					总投票数：[$hits.data.0.hits] &nbsp; 占比：100%
					<else>
					<loop name="ansfield" var="field" key="k">
                        <pp:var name="ansf" value="'ans' .$k"/>
						<if test="empty($var.{$ansf})">
							<?php break; ?>
						</if>
						<pp:var name="f" value="$k+1"/>
                        <pp:var name="v" value="$var.{$field} / $hits.data.0.hits * 100"/>
                        答案[$f]占 [@CsubStr( $v,0,1,'')]%<br />
                    </loop>
					</if>
                  </td>
                </tr>
		</loop>
                <tr>
                  <td height="50"></td>
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
