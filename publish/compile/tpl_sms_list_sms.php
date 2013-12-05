<?php import('core.util.RunFunc'); ?><?php
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_check.php
LNMV
);
include($inc_tpl_file);
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
			当前位置：<a href="/publish/index.php?LCMSPID=ADEHbVUjVG4Ca1I8BjwKbVA%2BXm4BMFA1BmdTego%2BUGYDJwVkBWgBNgQ%2FAG1XMQBjDm8%3D">首页</a> > 短信列表
        </div>
    </div>
    
    <div class="block">
   	  <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 短信列表</div></div>
          <div class="cbox">
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th width="60">手机号</th>
                  <th width="120">日期时间</th>
                  <th width="50">状态</th>
                  <th >内容</th>
                </tr>
<?php 
include_once('./appfunc/sms.php');
$appName ="publish";
$this->_tpl_vars["result"]=listSMS();
 ?>
     <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                <tr>
                  <td><?php echo $this->_tpl_vars["var"]["DestNumber"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["SendTime"];?></td>
                  <td>
                  <?php if ($this->_tpl_vars["var"]["SendFlag"]==0){?>
                  等待发送
                  <?php } elseif ($this->_tpl_vars["var"]["SendFlag"]==1){ ?>
                  正在发送
                  <?php } elseif ($this->_tpl_vars["var"]["SendFlag"]==2){ ?>
                  发送成功
                  <?php } ?>
                  </td>
                  <td><?php echo $this->_tpl_vars["var"]["Content"];?></td>
                </tr>
    <?php  }
} ?>
                <tr>
                  <td colspan="4">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td style="text-align:right; padding-right:10px;">
  <?php $this->_tpl_vars["listPage"]=runFunc('listPageUrl',array($this->_tpl_vars["result"]["pageinfo"],'../publish/index.php',10,"")); ?>
  <?php
$_tmp13240177491355=$this->_tpl_vars;
$this->_tpl_vars["pageInfo"] = $this->_tpl_vars["listPage"];
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_page.tpl
LNMV
);
include($inc_tpl_file);
$this->_tpl_vars=$_tmp13240177491355;
unset($_tmp13240177491355);
?>

  						  </td>
                   	    </tr>
                    </table>
              </td></tr>
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
