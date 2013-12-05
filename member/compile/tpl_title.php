<?php import('core.util.RunFunc'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BigBooks.com.cn</title>

<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/style_cnyp_admin.css" />

</head>

<body>

<?php if ($this->_tpl_vars["IN"]["isCompany"]=='0'){?>
	<div class="top">
	
	<div class="top_left">
		<div class="user_action"><strong><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
		<a href="../member/index.php?action=member&method=detailMember" target="mainFrame"><?php echo $this->_tpl_vars["name"];?></a></strong> - <u><a href="index.php?action=member&method=destroy">退出</a></u></div>
	    <div style="clear:both"></div>    
		</div>
	
	</div>
<?php }else{ ?>
	<div id="header">
		<div class="logo"> <a href="../yellowpages" target="_blank"><img src="../yellowpages/skin/images/logo_admin.gif" border="0" /></a>
    </div>
        <div class="header_right">
        <?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
        <div class="register">[<a href="../member/index.php?action=member&method=detailMember" target="mainFrame"><?php echo $this->_tpl_vars["name"];?></a>|<a href="../member/index.php?action=member&method=destroy">退出</a>]</div>
            <div class="topguide">
                <ul>
                    <li><a href="http://www.96886.com" target="_blank">96886</a></li>
                    <li><a href="http://sh.bigbooks.com.cn" target="_blank">ENGLISH</a></li>
                    <li><a href="../yellowpages/index.php?action=yellowPages&method=cp_fw" target="_blank">产品与服务</a></li>
                    <li><a href="http://www.webmail.yellowpage.com.cn" target="_blank">黄页邮箱</a></li>
                    <li><a href="../shop/" target="_blank">网上书店</a></li>
                </ul>    
        	</div> 
        </div>
        
	</div>
<?php } ?>

<div class="menu">
<div class="menu_line"></div>
	<ul>
	<?php echo runFunc('topMenu',array());?>
	<?php if ($this->_tpl_vars["name"]!='admin'){?>
		<?php $this->_tpl_vars["Y_code"]=runFunc('getYellowPagesCode',array($this->_tpl_vars["name"])); ?>
			<?php if ($this->_tpl_vars["Y_code"]){?>
				<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "SQL",
	'return' => "yellowpageList",
	'query' => "select ContentID from yp_yellowpages_yellowpages where Y_code='{$this->_tpl_vars["Y_code"]}'",
 ); 

$this->_tpl_vars['yellowpageList'] = CMS::CMS_SQL($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
				<?php if ($this->_tpl_vars["yellowpageList"]["0"]["ContentID"]){?>
				<li class="active"><a href="../yellowpages/index.php?action=yellowPages&method=page&id=<?php echo $this->_tpl_vars["yellowpageList"]["0"]["ContentID"];?>" target="_blank">我的企业</a></li>
				<?php } ?>
			<?php }else{ ?>
				未绑定企业
			<?php } ?>
	<?php } ?>
  </ul>
</div>
</body>
</html>
