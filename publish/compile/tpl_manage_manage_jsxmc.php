<?php
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
   		  <div class="topt"><div class="fontbox">◎ <?php echo $this->_tpl_vars["node"]["nodeName"];?>列表</div></div>
          <div class="cbox">
            <form action="/publish/search.php" method="post" onSubmit="return searchData(this)">
			<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["nodeId"];?>" name="nodeId"/>
			<input type="hidden" value="20" name="pageSize"/>
			<input type="hidden" name="tpl" value="manage/manage_jsxmc"/>
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="searchtablelist">
            	<tr>
                  <th>项目名称</th>
                  <td><input type="text" name="proName" data-field="proName" data-action="like" value="" class="admininput"/></td>
                  <th>项目规模</th>
                  <td><input type="text" name="proGm" data-field="proGm" data-action="like" value="" class="admininput"/></td>
                  <th>开工时间</th>
                  <td><input type="text" name="startDate" data-field="startDate" value="" class="admininput"/></td>
                </tr>
                <tr>
                  <th>竣工时间</th>
                  <td><input type="text" name="endDate" data-field="endDate" data-action="like" value="" class="admininput"/></td>
                  <th>概（预）算金额</th>
                  <td><input type="text" name="ysFare" data-field="ysFare" data-action="like" value="" class="admininput"/></td>
                  <th>决算金额</th>
                  <td><input type="text" name="endFare" data-field="endFare" data-action="like" value="" class="admininput"/></td>
                </tr>
                <tr><td colspan="6" style="text-align:center; padding:10px 0px 0px 0px;"><input type="submit" value="检索" />&nbsp;&nbsp;<input type="reset" value="重置" /></td></tr>
            </table>
			</form>
            <table cellpadding="0" cellspacing="0" width="770" align="center">
            	<tr><td height="10"></td></tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th>项目名称</th>
                  <th>项目规模</th>
                  <th>开工时间</th>
                  <th>竣工时间</th>
                  <th>概（预）算金额</th>
                  <th>决算金额</th>
                  <th>操作</th>
                </tr>
     <?php if(!empty($this->_tpl_vars['data'])){ 
 foreach ($this->_tpl_vars['data'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                <tr>
                  <td><?php echo $this->_tpl_vars["var"]["proName"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["proGm"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["startDate"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["endDate"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["ysFare"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["endFare"];?></td>
                  <td><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">查看</a></td>
                </tr>
    <?php  }
} ?>
                <tr>
                  <td colspan="12">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td style="text-align:right; padding-right:10px;">
<?php
$this->_tpl_vars["page"] = $this->_tpl_vars["page"];
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_search_page.tpl
LNMV
);
include($inc_tpl_file);
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
