<?php import('core.util.RunFunc'); ?>
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

$CKEditor->config['toolbar'] = "Full";


?>
<?php if($this->_tpl_vars["IN"]["month"] == ""){$month = date("m");}else{$month = $this->_tpl_vars["IN"]["month"];}?>
<?php if($this->_tpl_vars["IN"]["year"] == ""){$year = date("Y");}else{$year = $this->_tpl_vars["IN"]["year"];}?>
<?php if($this->_tpl_vars["IN"]["total_type"] == ""){$total_type = 1;}else{$total_type = $this->_tpl_vars["IN"]["total_type"];}?>
</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			社交统计
		</div>

	</div>
	<div class="search_bar">
		<form action="index.php" method="post">
			<input class="fr button_link" type="submit" value="显示"/>
			
			<select id="month" class="select_filter fr" name="month">
				<option value="">选择月份</option>
				<?php for($i=1;$i<=12;$i++):?>
				<option <?php if($month == $i){echo "selected=selected";}?> value="<?php echo $i?>"><?php echo $i;?>月</option>
				<?php endfor;?>
			</select>
			<select id="year" class="select_filter fr" name="year">
				<option value="">选择年份</option>
				<?php for($y=2012;$y<=date("Y");$y++):?>
				<option <?php if($year == $y){echo "selected=selected";}?> value="<?php echo $y?>"><?php echo $y;?>年</option>
				<?php endfor;?>
			</select>
			<label for="search_word" class="fr">统计年月：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="social_total"/>
			<input type="hidden" name="type" value="totals"/>
		</form>
	</div>
	<div class="filter_bar">
	</div>
	<div class="gray_line_box">
		 <fieldset class="admin_fieldset">
		    <legend><?php echo $year;?>年<?php echo $month;?>月社交<?php if($total_type==1){echo "数量";}else{echo "金额";}?>统计</legend>
	<div id="place_legend1" class="flace_legend"></div>
			 <div id="placeholder" style="width:900px;height:300px;margin:5px;margin-top:20px;" class="fl"></div>
		 </fieldset>
		 <fieldset class="admin_fieldset">
		    <legend><?php echo $year;?>年度社交<?php if($total_type==1){echo "数量";}else{echo "金额";}?>统计</legend>
	<div id="place_legend2" class="flace_legend"></div>
			 <div id="placeholder-2" style="width:900px;height:300px;margin:5px;margin-top:20px;" class="fl"></div>
		 </fieldset>
		 <br />
		 <br />
	</div>
</div>
</div>



<?php $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);?>
<?php
$total_array = array(); 
$months_day_array = array();
$m_total_array = array();
$m_circle_total_array = array();
$year_month_array = array();
?>
<?php for ($d=1;$d<=$month_days;$d++){
	
	$count = runFunc("getSocialListTotal",array($year,$month,$d));
	$circle_count = runFunc("getSocialCircleTotal",array($year,$month,$d));
	$post_count = runFunc("getSocialCirclePostTotal",array($year,$month,$d));
	$event_count = runFunc("getSocialEventTotal",array($year,$month,$d));
	$poll_count = runFunc("getSocialPollTotal",array($year,$month,$d));
	
	
	if($count[0]['count'] == ""){
		
		$count = 0;
	}else{
		$count = $count[0]['count'];
	}
	if($circle_count[0]['count'] == ""){
		
		$circle_count = 0;
	}else{
		$circle_count = $circle_count[0]['count'];
	}
	if($post_count[0]['count'] == ""){
		
		$post_count = 0;
	}else{
		$post_count = $post_count[0]['count'];
	}
	
	if($event_count[0]['count'] == ""){
		
		$event_count = 0;
	}else{
		$event_count = $event_count[0]['count'];
	}
	if($poll_count[0]['count'] == ""){
		
		$poll_count = 0;
	}else{
		$poll_count = $poll_count[0]['count'];
	}	
	
	$total_array[$d] = "[".$d.", ".$count."]";
	$circle_total_array[$d] = "[".$d.", ".$circle_count."]";
	$post_total_array[$d] = "[".$d.", ".$post_count."]";
	$event_total_array[$d] = "[".$d.", ".$event_count."]";
	$poll_total_array[$d] = "[".$d.", ".$poll_count."]";
	
	
	$months_day_array[$d] = "[".$d.",".$d."]";
}?>


<?php for ($m=1;$m<=12;$m++){
	
	$m_count = runFunc("getUserTotal",array($year,$m));
	$m_circle_count = runFunc("getSocialCircleTotal",array($year,$m));
	$m_post_count = runFunc("getSocialCirclePostTotal",array($year,$m));
	$m_event_count = runFunc("getSocialEventTotal",array($year,$m));
	$m_poll_count = runFunc("getSocialPollTotal",array($year,$m));
	
	if($m_count[0]['count'] == ""){
		
		$count = 0;
	}else{
		$count = $m_count[0]['count'];
	}
	
	if($m_circle_count[0]['count'] == ""){
		
		$m_circle_count = 0;
	}else{
		$m_circle_count = $m_circle_count[0]['count'];
	}
	
	if($m_post_count[0]['count'] == ""){
		
		$m_post_count = 0;
	}else{
		$m_post_count = $m_post_count[0]['count'];
	}
	
	if($m_event_count[0]['count'] == ""){
		
		$m_event_count = 0;
	}else{
		$m_event_count = $m_event_count[0]['count'];
	}
	
	if($m_poll_count[0]['count'] == ""){
		
		$m_poll_count = 0;
	}else{
		$m_poll_count = $m_poll_count[0]['count'];
	}
	
	
	$m_total_array[$m] = "[".$m.", ".$count."]";
	$m_circle_total_array[$m] = "[".$m.", ".$m_circle_count."]";
	$m_post_total_array[$m] = "[".$m.", ".$m_post_count."]";
	$m_event_total_array[$m] = "[".$m.", ".$m_event_count."]";
	$m_poll_total_array[$m] = "[".$m.", ".$m_poll_count."]";
	
	
	$year_month_array[$m] = "[".$m.",".$m."]";
}?>

<script type="text/javascript">
	$(function(){

		 function showTooltip(x, y, contents) {
		        $('<div id="tooltip">' + contents + '</div>').css( {
		            position: 'absolute',
		            display: 'none',
		            top: y + 5,
		            left: x + 5,
		            border: '1px solid #fdd',
		            padding: '2px',
		            'background-color': '#fee',
		            opacity: 0.80
		        }).appendTo("body").fadeIn(200);
		    }
		
		 var list_m = [<?php echo implode(",", $total_array)?>];
		 var circle_m = [<?php echo implode(",", $circle_total_array)?>];
		 var post_m = [<?php echo implode(",", $post_total_array)?>];
		 var event_m = [<?php echo implode(",", $event_total_array)?>];
		 var poll_m = [<?php echo implode(",", $poll_total_array)?>];
		 
		 var list_y = [<?php echo implode(",", $m_circle_total_array)?>];
		 var circle_y = [<?php echo implode(",", $m_total_array)?>];
		 var post_y = [<?php echo implode(",", $m_post_total_array)?>];
		 var event_y = [<?php echo implode(",", $m_event_total_array)?>];
		 var poll_y = [<?php echo implode(",", $m_poll_total_array)?>];
		 

		   $.plot(
				    $("#placeholder"), [
		                   		    {label: "<?php echo $month;?>月份Style List<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: list_m},
		                   		 	{label: "<?php echo $month;?>月份圈子<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: circle_m},
		                   			{label: "<?php echo $month;?>月份POST<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: post_m},
		                   			{label: "<?php echo $month;?>月份活动<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: event_m},
		                   			{label: "<?php echo $month;?>月份投票<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: poll_m},
		                   			
		                   		    ],

		                   		 {
               		 		 series: {
		                   		            lines: { show: true },
		                   		            points: { show: true },
		                   		         	
		                   		        },
		                   		     grid: { hoverable: true, clickable: true },
		                   		     xaxis: {
		                   	            ticks: [<?php echo implode(",", $months_day_array)?>]
		                   	        },
			                   	     yaxis: {
			                   	    	tickDecimals: 0,
			                   	    	min: 0
			                         },
			                         legend:{
											
											container: $("#place_legend1")
				                   		 }
		                   		 }
		                   		    );


		   var previousPoint = null;
		   $("#placeholder").bind("plothover", function (event, pos, item) {
		        $("#x").text(pos.x.toFixed(2));
		        $("#y").text(pos.y.toFixed(2));

		            if (item) {
		                if (previousPoint != item.datapoint[1]) {
		                    previousPoint = item.datapoint[1];
		                    
		                    $("#tooltip").remove();
		                    var x = item.datapoint[0].toFixed(2),
		           
		                     y = item.datapoint[1];
		           
		                    
		                    showTooltip(item.pageX+5, item.pageY,"<?php echo $month;?>月"+ item.datapoint[0] + "日:"+y);
		                }
		            }
		            else {
		                $("#tooltip").remove();
		                previousPoint = null;            
		            }
		        
		    });

		    

		   
		    $.plot(
				    $("#placeholder-2"), [
		                   		   	{ label: "<?php echo $year;?>年度Style List<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: list_y},
		                   			{ label: "<?php echo $year;?>年度圈子<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: circle_y},
		                   			{ label: "<?php echo $year;?>年度POST<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: post_y},
		                   			{ label: "<?php echo $year;?>年度活动<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: event_y},
		                   			{ label: "<?php echo $year;?>年度投票<?php if($total_type==1){echo "数量";}else{echo "金额";}?>",  data: poll_y},
		                   		    ],

		                   		 {
               		 		 series: {
	                   		            lines: { show: true },
	                   		            points: { show: true }
	                   		        },
		                   		     grid: { hoverable: true, clickable: true },
		                   		     xaxis: {
		                   	            ticks: [<?php echo implode(",", $year_month_array)?>]
		                   	        },
		                   	     yaxis: {
			                   	    	tickDecimals: 0,
			                   	    	min: 0
			                         },
			                         legend:{
											
											container: $("#place_legend2")
				                   		 }
		                   			 }
		                   		    );

		    $("#placeholder-2").bind("plothover", function (event, pos, item) {
		        $("#x").text(pos.x.toFixed(2));
		        $("#y").text(pos.y.toFixed(2));

		            if (item) {
		                if (previousPoint != item.datapoint[1]) {
		                    previousPoint = item.datapoint[1];
		                    
		                    $("#tooltip").remove();
		                    var x = item.datapoint[0],
		                   	 y = item.datapoint[1];
		                    
		                    showTooltip(item.pageX+5, item.pageY,"<?php echo $year;?>年"+ x +"月:"+y);
		                }
		            }
		            else {
		                $("#tooltip").remove();
		                previousPoint = null;            
		            }
		        
		    });
   		    
		});
</script>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>