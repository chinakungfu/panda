<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); 
?>

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
</head>
<body onLoad="window.location.hash = 'here'">
<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	?>
	
	<?php
	if($this->_tpl_vars["IN"]["user_id"] && $this->_tpl_vars["IN"]["user_id"] == $this->_tpl_vars["name"]){
		$inc_tpl_file=includeFunc("account/common/header.tpl");
	}else{
		$inc_tpl_file=includeFunc("share/common/header.tpl");
	}
	include($inc_tpl_file);
	$events = runFunc("getEventByUserId",array($this->_tpl_vars["IN"]["user_id"],$this->_tpl_vars["IN"]["page"],8));
	$count = runFunc("getEventByUserId",array($this->_tpl_vars["IN"]["user_id"],1,8,true));
	
	?>
		<div class="content">
			<div class="full_width_box oh">
				
				<div class="member_event_box oh fl">
				<div style="width:675px;" class="my_home_page_top_bar oh">
					<h2 style="text-indent: 0;width:auto" class="my_home_page_title_left fl">My Events (<?php echo $count[0]["count"];?>)</h2>
					<?php if($user_id==$this->_tpl_vars["name"]):?>
					<a style="margin-top:27px;margin-left:5px;line-height: 10px;display:inline;" class="gray_link fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventCreate'));?>">Create a event</a>
					<?php endif;?>
				</div>
				<?php if($count[0]["count"]>0):?>
				<?php foreach ($events as $key=>$event):?>
					<a href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"]));?>" style="background: url(../circle_event_img/<?php echo $event["user_id"]?>/<?php echo $event["img"]?>) no-repeat center center;"  class="event_preview <?php if(($key+1)%2==0){echo "fr";}else{echo "fl";}?>">
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
					
					
					echo runFunc("pageEventNavi",array($count[0]["count"],8,"share","memberEvent",$this->_tpl_vars["IN"]["user_id"],$page));?>
					
				<?php else:?>
				<div class="no_posts_word" style="text-align:center;">
					The quick brown fox jumps over the lazy dog ^_^
					</div>	
				<?php endif;?>
				</div>
				<div class="member_event_joined fr">
				<?php $events = runFunc("getEventMyJoined",array($user_id,1,6));?>
				<?php $events_count = runFunc("getEventMyJoined",array($user_id,1,6,true));?>
				<div class="circle_page_content_bar oh" style="margin-bottom: 14px;font-size: 12px;margin-top: 25px;">
					<div style="margin-right:5px;display:inline;">Event Joined</div>
				</div>
					<?php foreach ($events as $event):?>
					<div class="circle_event_box">
						<a class="circle_event_box_title" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"]));?>">
							<?php if(strlen($event["name"])> 55){	
								echo mb_substr($event["name"],0,55,'utf-8')."...";
								}else{
									echo $event["name"];
								}?>
						</a>
						<div class="circle_event_box_detail oh">
							<div class="circle_event_img fl">
							<a href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"]));?>">
								<img width="148px" src="../circle_event_img/<?php echo $event["user_id"]?>/<?php echo $event["img"]?>"/>
							</a>
							</div>
							<div class="circle_event_msg fl">
							<?php $event_time = runFunc("getEventTime",array($event["id"]));?>
					 <?php //echo $event["event_time_type"];?>
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
							<br />
							<a href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"]));?>">Join(<?php echo $event["member_count"];?>)</a>
							</div>
						</div>
					</div>
				<?php endforeach;?>
				<?php if($events_count[0]["count"] > 6):?>
					<div class="list_nav cicle_event_list_nav" style="margin-bottom: 0;width: 100%;">
						<a class="prev fl">Prev</a>
						<a class="next fr">Next</a>
					</div>
				<?php endif;?>
				</div>
			</div>
			</div>	
		<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
</div>

<script type="text/javascript">
	$(function(){

		var searching = 0;
		var page = 1;
		$(".list_nav .next").click(function(){
			if(searching == 1){
				return false;
			}
			get_item_list("share","ajaxGetJoinedEvents",<?php echo $this->_tpl_vars["IN"]["user_id"];?>,"next");
		});

		$(".list_nav .prev").click(function(){
			if(searching == 1){
				return false;
			}
			get_item_list("share","ajaxGetJoinedEvents",<?php echo $this->_tpl_vars["IN"]["user_id"];?>,"prev");
		});


		function get_item_list(action,method,user_id,type){
			if(searching == 0){
				searching = 1;
				}else{
						return false;
					}
			if(type=="next"){
				page = page + 1;
			}else{
				page = page - 1;
				}
			if(page < 1){
					page = 1;
					searching = 0;
					return false;
				}
			$(".the_end_message").remove();
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm fl loading_list_now");
			loading_icon.insertBefore($(".next"));
			$.ajax({
				url : 'index.php',
				type : 'POST',
				dataType : "json",
				data:{
					action	: action,
					method	: method,
					user_id : user_id,
					page: page,
					size: 6
				},
				success : function(json)
				{
					if(json == null || json.length ==0){
						page = page -1;
						loading_icon.remove();
						var the_end = $(document.createElement("span")).text("The end!").addClass("the_end_message");
						the_end.insertBefore($(".next"));
						searching = 0;
						return false;
					}
					$(".circle_event_box").remove();
					var event = "";
					for(var i=0;i<json.length;i++)
					{
						event += '<div class="circle_event_box">';
						event += '<a class="circle_event_box_title" href="'+json[i].event_link+'">'+json[i].name+'</a>';
						event += '<div class="circle_event_box_detail oh">';
						event += '<div class="circle_event_img fl">';
						event += '<a href="'+json[i].event_link+'">';
						event += '<img width="148px" src="../circle_event_img/'+json[i].user_id+'/'+json[i].img+'">';
						event += '</a>';
						event += '</div>';
						event += '<div class="circle_event_msg fl">';
						event += json[i].start_to_end;
						event += '<br>';
						event += '<a href="'+json[i].event_link+'">Join('+json[i].member_count+')</a>';
						event += '</div></div></div>';
					}

					$(event).insertAfter(".member_event_joined .circle_page_content_bar");
					
				},complete: function(){
					loading_icon.remove();
					searching = 0;
					}
			});
			}
		
		});
</script>
<style type="text/css">
	.main_page_nav{
		margin-top: 10px;
	}
</style>
</body>
</html>