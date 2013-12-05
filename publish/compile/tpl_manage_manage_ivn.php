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
   		  <div class="topt"><div class="fontbox">◎ <?php echo $this->_tpl_vars["node"]["nodeName"];?>内容详情</div></div>
          <div class="cbox">
<?php
global $IN;
?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "list",
	'return' => "ans",
	'nodeid' => "WTDAGLANR3",
	'where' => "c.invId={$this->_tpl_vars["IN"]["id"]}",
 ); 

$this->_tpl_vars['ans'] = CMS::CMS_list($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php $this->_tpl_vars["ansfield"]=array('result0', 'result1', 'result2', 'result3', 'result4', 'result5', 'result6', 'result7', 'result8', 'result9'); ?>
<form action="app.php?action=add&con=ivn&nodeId=DCJHyCjc&multi=1" method="post">
            <form action="app.php?action=add&con=ivn&nodeId=DCJHyCjc&multi=1" method="post">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablejmglc">
                <tr>
                  <td style="text-align:left; line-height:35px; padding-left:10px; width:100%; font-size:16px; font-weight:bold;"><?php echo $this->_tpl_vars["listcontent"]["title"];?></td>
                </tr>
                <?php if(!empty($this->_tpl_vars["ans"]["data"])){ 
 foreach ($this->_tpl_vars["ans"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                <?php $this->_tpl_vars["KEY"]=$this->_tpl_vars["key"]+1; ?>
                <tr>
                  <th style="text-align:left; padding-left:10px; width:100%;"><?php echo $this->_tpl_vars["KEY"];?>、<?php echo $this->_tpl_vars["var"]["title"];?></th>
                </tr>
                <tr>
                  <td style="padding:10px 0px 10px 10px;">
                  <?php if ($this->_tpl_vars["var"]["resultType"]=='radio'){?>
                    <input type="hidden" name="ansId[<?php echo $this->_tpl_vars["key"];?>]" value="<?php echo $this->_tpl_vars["var"]["id"];?>"/>
                    <input type="hidden" name="resultText[<?php echo $this->_tpl_vars["key"];?>]" value=""/>
                    <?php if(!empty($this->_tpl_vars['ansfield'])){ 
 foreach ($this->_tpl_vars['ansfield'] as $this->_tpl_vars['i']=>$this->_tpl_vars['field']){ ?>
                        <?php if (empty($this->_tpl_vars["var"]["{$this->_tpl_vars["field"]}"])){?><?php break; ?><?php } ?>
                        <?php $this->_tpl_vars["v"]=pow(2, $this->_tpl_vars["i"]); ?>
                        <label><input type="radio" name="resultValue[<?php echo $this->_tpl_vars["key"];?>]" value="<?php echo $this->_tpl_vars["v"];?>"/><?php echo $this->_tpl_vars["var"]["{$this->_tpl_vars["field"]}"];?></label>&nbsp;&nbsp;
                    <?php  }
} ?>
                  <?php } elseif ($this->_tpl_vars["var"]["resultType"]=='checkbox'){ ?>
                    <input type="hidden" name="ansId[]" value="<?php echo $this->_tpl_vars["var"]["id"];?>"/>
                    <input type="hidden" name="resultText[<?php echo $this->_tpl_vars["key"];?>]" value=""/>
                    <?php if(!empty($this->_tpl_vars['ansfield'])){ 
 foreach ($this->_tpl_vars['ansfield'] as $this->_tpl_vars['i']=>$this->_tpl_vars['field']){ ?>
                        <?php if (empty($this->_tpl_vars["var"]["{$this->_tpl_vars["field"]}"])){?><?php break; ?><?php } ?>
                        <?php $this->_tpl_vars["v"]=pow(2, $this->_tpl_vars["i"]); ?>
                        <label><input type="checkbox" name="resultValue[<?php echo $this->_tpl_vars["key"];?>][]" value="<?php echo $this->_tpl_vars["v"];?>"/><?php echo $this->_tpl_vars["var"]["{$this->_tpl_vars["field"]}"];?></label>&nbsp;&nbsp;
                    <?php  }
} ?>
                   <?php } elseif ($this->_tpl_vars["var"]["resultType"]=='text'){ ?> 
                   	<input type="hidden" name="ansId[<?php echo $this->_tpl_vars["key"];?>]" value="<?php echo $this->_tpl_vars["var"]["id"];?>"/>
                    <textarea name="resultText[<?php echo $this->_tpl_vars["key"];?>]" rows="3" cols="35"></textarea>
                    <input type="hidden" name="resultValue[<?php echo $this->_tpl_vars["key"];?>]" value="0"/>
                   <?php } ?> 
                  </td>
                </tr>
                <?php  }
} ?>
                <tr>
                  <td height="50"><input type="submit" value="提交"/>&nbsp;&nbsp; <a href="<?php echo runFunc('encrypt_url',array('action=manage&method=ivnResult&id='. $this->_tpl_vars["IN"]["id"]));?>">查看投票结果</a></td>
                </tr>
                
            </table>
            </form>
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
