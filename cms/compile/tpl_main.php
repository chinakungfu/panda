<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
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
<div style="margin: auto; overflow: hidden; width: 852px;margin-bottom:20px;">
<div class="message_table_box  fl">

	<table>
		<tr>
			<th width="50%">今日新注册会员</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&main_message_link=Register'));?>"><?php echo runFunc("getMainCount",array("Register Member"));?></a></td>
		</tr>
		<tr>
			<th>今日过生日会员</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&main_message_link=Birth'));?>"><?php echo runFunc("getMainCount",array("Birth Day Member"));?></a></td>
		</tr>
		<tr>
			<th>今日新充值账户</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=recharge_order&type=users'));?>"><?php echo runFunc("getMainCount",array("Recharge Today"));?></a></td>
		</tr>
		<tr>
			<th>未处理举报信息</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share&status=2'));?>"><?php echo runFunc("getMainCount",array("Spam"));?></a></td>
		</tr>
		<tr>
			<th>未回复咨询</th>
			<td><a id="request_link_main" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users&reply_time=1'));?>"><?php echo runFunc("getMainCount",array("Help Message"));?></a></td>
		</tr>
	</table>
</div>
<?php if(runFunc("getMainCount",array("Help Message"))>0):?>
<script type="text/javascript">
	$(function(){

	

		flicker_link();
		
		function flicker_link(){
		$("#request_link_main").animate({color:"white"},500,function(){
			$("#request_link_main").animate({color:"#ED5E83"},500,function(){
				 flicker_link()
				});
			});
		}

		
		})
</script>
<?php endif;?>
<div class="message_table_box fl">
	<table>
		<tr>
			<th width="50%">待付款普通订单</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=4'));?>"><?php echo runFunc("getMainCount",array("Order Type 1"));?></a></td>
		</tr>
		<tr>
			<th>待采购普通订单</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=5'));?>"><?php echo runFunc("getMainCount",array("Order Type 2"));?></a></td>
		</tr>
		<tr>
			<th width="50%">待发货普通订单</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=6'));?>"><?php echo runFunc("getMainCount",array("Order Type 3"));?></a></td>
		</tr>
		<tr>
			<th>待确认普通订单</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=7'));?>"><?php echo runFunc("getMainCount",array("Order Type 4"));?></a></td>
		</tr>
		<tr>
			<th>退款订单</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=99'));?>"><?php echo runFunc("getMainCount",array("Order Type 5"));?></a></td>
		</tr>
	</table>
</div>
<div class="message_table_box fl last">
	<table>
		<tr>
			<th width="70%">待审核团购申请</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=memeberGroupBuy&type=share&status=1'));?>"><?php echo runFunc("getMainCount",array("Group Buy Type 1"));?></a></td>
		</tr>
		<tr>
			<th>进行中团购</th>
			<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=memeberGroupBuy&type=share&status=2'));?>"><?php echo runFunc("getMainCount",array("Group Buy Type 2"));?></a></td>
		</tr>
		<tr>
			<th>今日Style List评论</th>
			<td><?php echo runFunc("getMainCount",array("Comment Type 1"));?></td>
		</tr>
		<tr>
			<th>今日活动评论</th>
			<td><?php echo runFunc("getMainCount",array("Comment Type 2"));?></td>
		</tr>
		<tr>
			<th>今日圈子评论</th>
			<td><?php echo runFunc("getMainCount",array("Comment Type 3"));?></td>
		</tr>
		<tr>
			<th>今日SURPRISE商品评论</th>
			<td><?php echo runFunc("getMainCount",array("Comment Type 4"));?></td>
		</tr>
	</table>
</div>
</div>
 <div id="placeholder" style="width:852px;height:300px;margin:0 auto;"></div>

</div>
</div>
<?php
$year =  date("Y",time());
$month = (int)date("m",time());
$plot_count = '';
?>
<?php $orders_count = array();?>
<?php for($i=1;$i<=$month;$i++){
	$orders_count[$i] = runFunc('getOrderYearCount',array($year,$i));
	if($plot_count == ''){
		$plot_count .= "[".$i.",".$orders_count[$i]."]";
	}else{
		$plot_count .= ",[".$i.",".$orders_count[$i]."]";
	}

}

?>


	<script type="text/javascript">
	$(function () {
		 //var d2 = [[1, <?php echo $orders_count[1]?>], [2, <?php echo $orders_count[2]?>], [3, <?php echo $orders_count[3]?>], [1, <?php echo $orders_count[1]?>],[4, <?php echo $orders_count[4]?>],[5, <?php echo $orders_count[5]?>],[6, <?php echo $orders_count[6]?>],[7, <?php echo $orders_count[7]?>],[8, <?php echo $orders_count[8]?>],[9, <?php echo $orders_count[9]?>],[10, <?php echo $orders_count[10]?>],[11, <?php echo $orders_count[11]?>],[12, <?php echo $orders_count[12]?>]];
		 var d2 = [<?php echo $plot_count;?>];


		    $.plot(
				    $("#placeholder"), [
		                   		    { label: "本年度成交订单",  data: d2}],

		                   		 {
                  		 		 series: {
		                   		            lines: { show: true },
		                   		            points: { show: true }
		                   		        },
		                   		     grid: { hoverable: true, clickable: true },
		                   		     xaxis: {
		                   	            ticks: [[1,"一月"],[2,"二月"],[3,"三月"],[4,"四月"],[5,"五月"],[6,"六月"],[7,"七月"],[8,"八月"],[9,"九月"],[10,"十月"],[11,"十一月"],[12,"十二月"]]
		                   	        },
		                   		 }
		                   		    );
	});
	</script>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>


<?php $this->_tpl_vars["method"];?>




