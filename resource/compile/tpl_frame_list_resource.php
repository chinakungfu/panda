<?php import('core.util.RunFunc'); ?><html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">

</style><head>
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<link href="skin/cssfiles/style_condition.css"  rel="stylesheet" type="text/css"/>
<script language="javascript" src="skin/jsfiles/conditioninput.js"></script>
<script language="javascript" src="skin/jsfiles/calendar.js"></script>
<title>资源管理页面</title>
<script language=JavaScript type="" >

</script>
</head>
<body>
  <form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="resourceId">
  <input type="hidden" name="isText" value="<?php echo $this->_tpl_vars["isText"];?>">
  <input type="hidden" name="isId" value="<?php echo $this->_tpl_vars["isId"];?>">
  <input type="hidden" id="type" name="resourcetype">
      <table width="100%" class="tableTitle"/>
      <tr>
        <td class="tdTitle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   资源管理</TD>
      </tr>
    </TABLE>
    <table width="100%" class="tabletoolbutton" id="editgroup">
      <tr>
        <td class="tdtoolbutton" width="70%">
          <input type="button" class="button1" value="新 增" name="btnadd" onClick="adddata();">
          <input type="button" class="button1" value="删 除" name="btndel" onClick="deldata();">
          <input type="button" class="button1" value="确定" onclick="selectSubmit()">
          <input type="button" id="select" value="查询" class="button1" onClick="parent.search();">
          
        </TD>
        
      </tr>
    </TABLE>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">选中</td>
         	<td class="listHeader">资源Id</td>
      		<td class="listHeader">资源名称</td>
      		<td class="listHeader">资源类型</td>
      		<td class="listHeader">资源服务器</td>
      		<td class="listHeader">上传时间</td>
      		<td class="listHeader">操作</td>
       </tr>
       <?php $this->_tpl_vars["result"]=runFunc('listResource',array({$this->_tpl_vars["sqlCon"]})); ?>
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="<?php echo $this->_tpl_vars["var"]["resourceId"];?>"></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["resourceId"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["resourceName"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["resourceType"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["serverName"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["resourceDate"];?></td>
          <?php if ($this->_tpl_vars["var"]["resourceType"]=='image'){?>
          <td class="tdListItem" onMouseOver="MM_showHideLayers('Layer<?php echo $this->_tpl_vars["key"];?>','','show')" onMouseOut="MM_showHideLayers('Layer<?php echo $this->_tpl_vars["key"];?>','','hide')">
          <a href='display.php?url=<?php echo runFunc('selectResource',array({$this->_tpl_vars["var"]["resourceId"]}));?>' target="_blank">预览</a>
          <div id=Layer<?php echo $this->_tpl_vars["key"];?> style="position:absolute; width:200px; height:200px; z-index:1; left: 100px; top: 100px; visibility: hidden">
          <img src='<?php echo runFunc('selectResource',array({$this->_tpl_vars["var"]["resourceId"]}));?>' width="100%" height="100%"></div>
          </td>
          <?php }else{ ?>
          <td class="tdListItem">无预览</td>
          <?php } ?>
       </tr>
       <?php  }
} ?>
       </table>
       <?php runFunc('listPage',array({$this->_tpl_vars["result"]["pageinfo"]},'index.php','2'))?>
  </form>
  </body>
</html>
