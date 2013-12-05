<?php import('core.util.RunFunc'); ?><?php
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_check.php
LNMV
);
include($inc_tpl_file);
?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "node",
	'return' => "node",
	'nodeid' => "{$this->_tpl_vars["IN"]["nodeId"]}",
 ); 

$this->_tpl_vars['node'] = CMS::CMS_node($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "content",
	'return' => "listcontent",
	'nodeid' => "{$this->_tpl_vars["IN"]["nodeId"]}",
	'contentid' => "{$this->_tpl_vars["IN"]["id"]}",
 ); 

$this->_tpl_vars['listcontent'] = CMS::CMS_content($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
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
<?php
$inc_tpl_file=includeFunc(<<<LNMV
manage_yplace.tpl
LNMV
);
include($inc_tpl_file);
?>

        </div>
    </div>
    
    <div class="block">
   	  <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 关于<?php echo $this->_tpl_vars["node"]["nodeName"];?>内容详情</div></div>
          <div class="cbox">

            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <td style="text-align:left; line-height:35px; padding-left:10px; width:100%; font-size:16px; font-weight:bold;">
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "hits",
	'query' => "select count(distinct r.action) hits from cms_publish_invResult r, cms_publish_invQuesAns a where a.id=r.ansId and a.invId={$this->_tpl_vars["IN"]["id"]}",
 ); 

$this->_tpl_vars['hits'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
总投票数：<?php echo $this->_tpl_vars["hits"]["data"]["0"]["hits"];?> 
                  </td>
                </tr>
                
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "list",
	'query' => "select a.title, a.resultType, result0 ans0, result1 ans1, result2 ans2, result3 ans3, result4 ans4, result5 ans5, result6 ans6, result7 ans7, result8 ans8, result9 ans9, sum(r.resultValue & 1 != 0) result0, sum(r.resultValue & 2 != 0) result1, sum(r.resultValue & 4 != 0) result2, sum(r.resultValue & 8 != 0) result3, sum(r.resultValue & 16 != 0) result4, sum(r.resultValue & 32 != 0) result5, sum(r.resultValue & 64 != 0) result6, sum(r.resultValue & 128 != 0) result7, sum(r.resultValue & 256 != 0) result8, sum(r.resultValue & 512 != 0) result9 from cms_publish_invQuesAns a, cms_publish_invResult r where r.ansId=a.id and a.invId={$this->_tpl_vars["IN"]["id"]} group by a.id",
 ); 

$this->_tpl_vars['list'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>

<?php $this->_tpl_vars["ansfield"]=array('result0', 'result1', 'result2', 'result3', 'result4', 'result5', 'result6', 'result7', 'result8', 'result9'); ?>
        <?php if(!empty($this->_tpl_vars["list"]["data"])){ 
 foreach ($this->_tpl_vars["list"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                <tr>
                  <th style="text-align:left; padding-left:10px; width:100%;">
                  <?php $this->_tpl_vars["KEY"]=$this->_tpl_vars["key"]+1; ?>
                  <?php echo $this->_tpl_vars["KEY"];?>、问题：<?php echo $this->_tpl_vars["var"]["title"];?>
                  </th>
                </tr>
                <tr>
                  <td style="padding:10px 0px 10px 10px;">
					<?php if ($this->_tpl_vars["var"]["resultType"]=='text'){?>
					总投票数：<?php echo $this->_tpl_vars["hits"]["data"]["0"]["hits"];?> &nbsp; 占比：100%
					<?php }else{ ?>
					<?php if(!empty($this->_tpl_vars['ansfield'])){ 
 foreach ($this->_tpl_vars['ansfield'] as $this->_tpl_vars['k']=>$this->_tpl_vars['field']){ ?>
                        <?php $this->_tpl_vars["ansf"]='ans' .$this->_tpl_vars["k"]; ?>
						<?php if (empty($this->_tpl_vars["var"]["{$this->_tpl_vars["ansf"]}"])){?>
							<?php break; ?>
						<?php } ?>
						<?php $this->_tpl_vars["f"]=$this->_tpl_vars["k"]+1; ?>
                        <?php $this->_tpl_vars["v"]=$this->_tpl_vars["var"]["{$this->_tpl_vars["field"]}"] / $this->_tpl_vars["hits"]["data"]["0"]["hits"] * 100; ?>
                        答案<?php echo $this->_tpl_vars["f"];?>占 <?php echo runFunc('CsubStr',array( $this->_tpl_vars["v"],0,1,''));?>%<br />
                    <?php  }
} ?>
					<?php } ?>
                  </td>
                </tr>
		<?php  }
} ?>
                <tr>
                  <td height="50"></td>
                </tr>
                
            </table>

          </div>
      </div>
      
      
      
      <div class="copyrightBox">
      	<div class="cboxc">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_inc_copyright.tpl
LNMV
);
include($inc_tpl_file);
?>

        </div>
      </div>
    </div>
    
</div>
</body>
</html>
