<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>
<style type="text/css">

	.main_page_nav a{
		margin-left: 0;
		margin-right: 5px;
	}
</style>
<script type="text/javascript">

$(function(){
var moving = 0;
var active_img = 1;
var timer = 0;
$(".special_banner_ctrl img").click(function(){
	if(moving == 0){
		var clicked_num = $(this).attr("id");
		console.info(clicked_num);
		if(active_img != clicked_num){
			moving = 1;
			$(".special_banner_ctrl img").removeClass("active_special");
			$(this).addClass("active_special");
			var num = $(this).attr("id");
			active_img = $(this).attr("id");
			$(".special_event").fadeOut(900);
			$("#special_event_" + num).fadeIn(900,function(){
			moving = 0;
			settime();
			});
		}
	}
});
function slider_roll(){
	if(active_img == $(".special_event").length){
		active_img = 1;
	}else{
		active_img = Number(active_img) + 1;
	}
		moving = 1;
		$(".special_event").fadeOut(900);
		$("#special_event_" + active_img).fadeIn(900,function(){
		moving = 0;
	});
	$(".special_banner_ctrl img").removeClass("active_special");
	$(".special_banner_ctrl #" + active_img).addClass("active_special");
}
function settime(){
	clearInterval(timer);
	timer = setInterval(slider_roll,5000);
}
settime(); 
});
</script>
</head>
<body onload="window.location.hash = 'here'">
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	
	$events = runFunc("getEvents",array($this->_tpl_vars["IN"]["page"],8,1,0));
	
	$special_events = runFunc("getEvents",array(1,3,1,1));
	
	$count = runFunc("getEvents",array($this->_tpl_vars["IN"]["page"],8,1,0,true));
	?>
	<div class="content">
	<div class="content_top_bar oh">
    <div class="cattitle" style="margin-top:20px;">
    <span>Live Events</span>
    <a class="add_list_button_small" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventCreate'));?>">Create a event</a>
    </div>    

	<?php if(count($special_events)):?>
	<div class="special_event_box oh">
		<?php foreach ($special_events as $key=>$special_event):?>
		<a href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$special_event["id"]));?>" id="special_event_<?php echo $key+1;?>" class="special_event <?php if(($key+1)!=1){echo 'hide';}?>" style="background: url(../circle_event_img/<?php echo $special_event["user_id"]?>/<?php echo $special_event["large_img"]?>) no-repeat center center">
		<div class="special_event_desc">
		<?php echo $special_event["name"];?>
		</div>
		</a>
		<?php endforeach;?>
		<div class="special_banner_ctrl">
			<?php foreach ($special_events as $key=>$special_event):?>
			<img class="<?php if(($key+1)==1){echo 'active_special';}?>" id="<?php echo $key+1;?>" src="../circle_event_img/<?php echo $special_event["user_id"]?>/<?php echo $special_event["img"];?>" alt="" />
			<?php endforeach;?>
		</div>
	</div>
	<?php endif;?>
	<div class="event_box oh" >
	<?php foreach ($events as $key=>$event):?>
	<?php if($event["out_link"]!=""){
		$event_link = "target='_blank' href='".$event["out_link"]."'";
		
	}else{
		$event_link = 'href="'.runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"])).'"';
		
	}?>
		<a <?php echo $event_link;?> style="background: url(../circle_event_img/<?php echo $event["user_id"]?>/<?php echo $event["img"]?>) no-repeat center center" class="event_preview <?php if(($key+1)%2==0){echo "fr";}else{echo "fl";}?>">
			<div class="event_preview_detail">
				<div class="event_preview_title">
				<?php if(strlen($event["name"])> 60){	
					echo mb_substr($event["name"],0,60,'utf-8')."...";
					}else{
						echo $event["name"];
					}?>
				</div>
				<div class="event_start">
				<?php $event_time = runFunc("getEventTime",array($event["id"]));?>
					availability <?php //echo $event["event_time_type"];?>
					<?php switch ($event["event_time_type"]){
						
						case 1:
							
							echo date("Y.m.d",strtotime($event_time[0]["start_date"]));
							
							break;
							
						case 2:
							
							echo date("Y.m.d",strtotime($event_time[0]["start_date"]))." - ".date("Y.m.d",strtotime($event_time[0]["end_date"]));
							
							break;
							
						case 3:
							
							echo date("Y.m.d",strtotime($event_time[0]["start_date"]))." - ".date("Y.m.d",strtotime($event_time[0]["end_date"]));
							
							break;
							
						case 4:
							
							$kk = count($event_time)-1;
							
							echo date("Y.m.d",strtotime($event_time[0]["start_date"]))." - ".date("Y.m.d",strtotime($event_time[$kk]["start_date"]));
							
							break;
						
					}?>
				</div>
			</div>
		</a>
	<?php endforeach;?>
	<?php 
	if($this->_tpl_vars["IN"]["page"]==""){
					
		$page = 1;
	}else{
		
		$page = $this->_tpl_vars["IN"]["page"];
	}
	echo runFunc("pageNavi",array($count[0]["count"],8,"share","eventMain",$page));?>
	</div>
	</div>
	</div>
	</div>
<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
</body>