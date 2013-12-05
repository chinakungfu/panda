<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	$page = 1;
}
$rowsPerPage = 15;
$pageStrat = $page * $rowsPerPage - $rowsPerPage;


$querysql = "select a.*,b.staffNo,b.staffName from cms_publish_notice as a left join cms_member_staff as b on a.author = b.staffId WHERE a.id > 0";
$status = $this->_tpl_vars['IN']['status'];
if($status && $status != 0){
	$querysql .= " and a.published = ".$status;	
}	 	

 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun');
 global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;
 $params = array (
			'action' => "sql",
			'return' => "lists",
			'query' => $querysql." ORDER BY a.updated DESC limit {$pageStrat},{$rowsPerPage}",
 );
 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);

  $params2 = array (
			'action' => "sql",
			'return' => "lists2",
			'query' => $querysql,
 );
 $this->_tpl_vars['lists2'] = CMS::CMS_sql($params2);
$result_count = count($this->_tpl_vars['lists2']["data"]);	

?>
<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);
?>
</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			公告列表
		</div>
		<ul class="fr ctrl_link">
<!--			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="goods" >批量删除</a>
			</li>-->

		</ul>
</div>
		<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=notice_list&type=users&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=notice_list&type=users&status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">发布</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=notice_list&type=users&status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">不发布</a></li>
		</ul>
	</div>
<table class="order_list_title">
	<tbody>
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
            <th width="15%">更新时间</th>
			<th width="40%">公告名称</th>
            <th width="20%">发布人</th>
			<th width="10%">状态</th>
			<th width="10%">操作</th>
		</tr>
	</tbody>
</table>
<? if($this->_tpl_vars['lists']["data"]):?>
<?php
$i = 1;
foreach($this->_tpl_vars['lists']["data"] as $key=>$item):?>
<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
	<tbody>
		<tr>
			<td width="5%"><input value="<?php echo $item["id"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
            
            <td width="15%"><?php echo date("Y-m-d H:i:s",$item['created']);?></td>
            
            
			<td width="40%" style="padding:0 10px;" width="20%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=notice_edit&type=users&id='.$item["id"]));?>"><?php echo $item["title"];?></a></td>
            <td width="20%"><?php echo $item["staffName"]?$item["staffName"]:$item["staffNo"];?></td>
			<td width="10%"><?php echo $_GLOBAL['notice_published_'.$item["published"]];?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=notice_edit&type=users&id='.$item["id"].'&page='.$page));?>">编辑</a> 
            <a onClick="javascript: return confirm('是否确认删除这个此项？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=notice_del&id='.$item["id"].'&page='.$page));?>">删除</a> 
			</td>
		</tr>
	</tbody>
</table>
<?php endforeach;?>
<?php else:?>
<p style="padding:10px;text-align:center;margin-top:30px;">There no item in your notice list.</p>
<?php endif;?>
<?php echo runFunc("adminPageNavi",array($result_count,$rowsPerPage,"cms","notice_list",'users&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
