<?php import('core.util.RunFunc'); 

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
?>

<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

$page = 1;
if($this->_tpl_vars["IN"]["page"] != ""){
	$page = $this->_tpl_vars["IN"]["page"];
}
?>

<?php $items = runFunc("getCoupons",array($page,20,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["coupon_status"],$this->_tpl_vars["IN"]["search_word"]));
$items_count = runFunc("getCoupons",array(1,20,true,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["coupon_status"],$this->_tpl_vars["IN"]["search_word"]));

?>

<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);

$filters = runFunc("getItemList",array("cms_product_tag_category",1,10000));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			优惠券列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="coupons">批量删除</a>
			</li>
		</ul>
	</div>
	<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=coupons&type=users'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">密码或使用者搜索：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="coupons"/>
			<input type="hidden" name="type" value="users"/>
		</form>
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["coupon_status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=coupons&type=users&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["coupon_status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=coupons&type=users&coupon_status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">金额优惠 已使用</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["coupon_status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=coupons&type=users&coupon_status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">金额优惠 未使用</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["coupon_status"] == "3"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=coupons&type=users&coupon_status=3&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">打折优惠 已使用</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["coupon_status"] == "4"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=coupons&type=users&coupon_status=4&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">打折金额优惠 未使用</a></li>
		</ul>
	</div>
<table class="order_list_title">
	<tbody>
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="25%">优惠券密码</th>
			<th width="20%">优惠额度/折扣</th>
			<th width="10%">最低消费</th>
			<?php $end_time_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="end_time" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $end_time_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="end_time" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $end_time_sort = "desc";?>
			<?php endif;?>
			<th width="15%">到期时间  <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=coupons&type=users&reply_time='.$this->_tpl_vars["IN"]["reply_time"].'&sort='.$end_time_sort.'&key=end_time'.'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="end_time" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="end_time" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<th width="10%">使用者</th>
			<th width="15%">使用时间</th>
		</tr>
	</tbody>
</table>
<form action="index.php" method="post" id="admin_batch_form">
<?php 
$i = 1;
foreach($items as $key=>$item):?>
<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
	<tbody>
		<tr>
			<td width="5%"><input value="<?php echo $item["id"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td width="25%"><?php echo $item["code"];?></td>
			<td width="20%"><?php echo $_GLOBAL['coupon_type_'.$item["type"]]?><?php if($item["type"]==1){ echo $item["money"];}else{echo ($item["price_rate"]*10)."折";}?></td>
			<td width="10%" style="text-align:left;padding-left:10px">￥ <?php echo $item["order_limit"];?></td>
			<td width="15%"><?php echo $item["end_time"];?></td>
			<td width="10%"><?php echo $item["staffName"];?></td>
			<td width="15%"><?php echo $item["used_time"];?></td>
		</tr>
	</tbody>
</table>
<?php endforeach;?>
</form>
<?php echo runFunc("adminPageNavi",array($items_count[0]["count"],20,"cms","coupons",'users&coupon_status='.$this->_tpl_vars["IN"]["coupon_status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"],$page));?>
</div>

</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
