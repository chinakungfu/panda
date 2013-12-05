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
			<input type="hidden" name="tpl" value="manage/manage_mzgl"/>
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="searchtablelist">
            	<tr>
                  <th>门牌号</th>
                  <td><input type="text" name="mpNo" data-field="mpNo" data-action="like" value="" class="admininput"/></td>
                  <th>产权人</th>
                  <td><input type="text" name="humanRights" data-field="humanRights" data-action="like" value="" class="admininput"/></td>
                  <th>片区编号</th>
                  <td><input type="text" name="areaNo" data-field="areaNo" value="" class="admininput"/></td>
                </tr>
                <tr>
                  <th>建筑编号</th>
                  <td><input type="text" name="buildingNo" data-field="buildingNo" data-action="like" value="" class="admininput"/></td>
                  <th>联系电话</th>
                  <td><input type="text" name="telephone" data-field="telephone" data-action="like" value="" class="admininput"/></td>
                  <th>办证时间</th>
                  <td><input type="text" name="bzTime" data-field="bzTime" data-action="like" value="" class="admininput"/></td>
                </tr>
                <tr><td colspan="6" style="text-align:center; padding:10px 0px 0px 0px;"><input type="submit" value="检索" />&nbsp;&nbsp;<input type="reset" value="重置" /></td></tr>
            </table>
			</form>
            <table cellpadding="0" cellspacing="0" width="770" align="center">
            	<tr><td height="10"></td></tr>
            </table>
            
            <table cellpadding="0" cellspacing="0" width="770" align="center" class="tablelist">
                <tr>
                  <th>门牌号</th>
                  <th>产权人</th>
                  <th>占地面积</th>
                  <th>建筑面积</th>
                  <th>片区编号</th>
                  <th>建筑编号</th>
                  <th>联系电话</th>
                  <th>办证时间</th>
                  <th>操作</th>
                </tr>
     <?php if(!empty($this->_tpl_vars['data'])){ 
 foreach ($this->_tpl_vars['data'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                <tr>
                  <td><?php echo $this->_tpl_vars["var"]["mpNo"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["humanRights"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["area"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["constructionArea"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["areaNo"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["buildingNo"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["telephone"];?></td>
                  <td><?php echo $this->_tpl_vars["var"]["bzTime"];?></td>
                  <td><a href="<?php echo $this->_tpl_vars["var"]["url"];?>">查看</a></td>
                </tr>
    <?php  }
} ?>
                <tr>
                  <td colspan="12">
                	<table cellpadding="0" cellspacing="0" width="100%" align="center" class="tableno">
                    	<tr>
                          <td width="34%" style="text-align:left; padding-left:10px;"></td>
                    	  <td width="66%" style="text-align:right; padding-right:10px;">
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
