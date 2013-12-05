<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
 if ($this->_tpl_vars["name"]){?>
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
<link href="/publish/skin/jsfiles/jquery-ui-1.8.24.custom.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAYGKhMRRehPoF4WNV65-9NsSEHdj9O1i0&sensor=false&libraries=places"></script>
	<script type="text/javascript">
		$(function(){
			function initialize() {
				if(window.map_inited)
					return;
				var mapOptions = {
					center: new google.maps.LatLng(31.298886,120.58531600000003),
					zoom: 8,
					language: "EN",
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map($("#map_canvas").get(0),mapOptions);
				var input = $("#map_location").get(0);
				var autocomplete = new google.maps.places.Autocomplete(input);

				autocomplete.bindTo('bounds', map);
				var marker = new google.maps.Marker({
					map: map,
					draggable:true,
					animation: google.maps.Animation.DROP
				});

				google.maps.event.addListener(autocomplete, 'place_changed', function() {
					var place = autocomplete.getPlace();
					if (place.geometry.viewport) {
						map.fitBounds(place.geometry.viewport);
					} else {
						map.setCenter(place.geometry.location);
						map.setZoom(17);  // Why 17? Because it looks good.
					}
					
					marker.setPosition(place.geometry.location);
				});	
				window.map_inited = true;
				$("#confirm_mark").click(function(){
					var mark_position = marker.getPosition();
					$("#map_link img").attr("src","http://maps.google.cn/maps/api/staticmap?size=409x106&zoom=15&markers="+ mark_position.lat() +","+ mark_position.lng() +"&sensor=false&language=en");
					$("#map_link span").remove();
					$("#map_location_num").val(mark_position.lat() +","+ mark_position.lng());
					$("#location_picker").dialog("close");
				});

				$("#close_map").click(function(){
					$("#location_picker").dialog("close");
					});
			}	
			$("#location_picker").dialog({
				autoOpen: false,
				width: 600,
				resizable: false,
				dialogClass: "map_dialog"
			});
			$("#map_link").click(function(){
				$("body").css({"width":$("body").width()});
				$("#location_picker").dialog("open");
				initialize();
			});



			$("#introduction").keyup(function(){
					var limit = 2000 - $(this).val().length;
					var limit_word = "Maximum of "+ limit +" characters";
		
					if($(this).val().length >=2000){
						$(this).val($(this).val().substring(0, 2000));
						limit_word = "Maximum of 0 characters";
					}
					$(".introduction_limit").text(limit_word);
				});
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
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	
	$event = runFunc("getEvent",array($this->_tpl_vars["IN"]["id"]));

	
	$circles = runFunc("getCircleMyJoin",array($this->_tpl_vars["name"]));
	$event_time = runFunc("getEventTime",array($event[0]["id"]));
	?>
	<div class="content">
	<h2 class="cp_title">Create Event</h2>
	<h3 class="circle_create_box_title">Create a live event </h3>
	<div class="circle_create_main oh">
	<div class="circle_create_box fl gray_line_box">
		<form id="event_create_form" action="index.php" method="post">
			
			<table class="circle_create_detail_table">
			<tr>
				<th style="line-height: 25px;vertical-align: top;"><label class="fr" for="event_name">Circle: *</label></th>
				<td>
				<select name="circle_id" id="circle_id" class="required">
					<option value="">select circle</option>
				<?php foreach($circles as $circle):?>
					<option <?php if($circle["id"] == $event[0]["circle_id"])echo "selected=selected";?> value="<?php echo $circle["id"]?>"><?php echo $circle["name"]?></option>
				<?php endforeach;?>
				</select>
				</td>
			</tr>
			<tr>

				<th style="line-height: 25px;vertical-align: top;"><label class="fr" for="event_name">Event Name: *</label></th>
				<td>
				<input id="event_name" class="circle_editor_input big_input required" type="text" value="<?php echo $event[0]["name"];?>" name="event_name" maxlength="50">
				<br>
				<font style="font-style:italic">Maximum of 50 characters</font>	
				</td>
			</tr>
			<tr>
				<th style="line-height: 25px;vertical-align: top;"><label class="fr" for="event_organizers">Organizers: *</label></th>
				<td>
				<input id="event_organizers" class="circle_editor_input big_input required" type="text" value="<?php echo $event[0]["organizers"];?>" name="event_organizers" maxlength="50">
				<br>
				<font style="font-style:italic">Maximum of 50 characters</font>	
				</td>
			</tr>
			<tr>
				<th>Photo:*</th>
				<td>
					<div class="photo_box">
						<center><img src="../circle_event_img/<?php echo $event[0]["user_id"];?>/<?php echo $event[0]["img"];?>" alt="" /></center>
					</div>
					<div style="color:#fd8f8f;font-style:italic;font-size:11px;line-height:20px;">Note: the best poster size is 800X400 pixels , maximum 300K</div>
				</td>
			</tr>
			<tr>
				<th>
				Upload Image:
				</th>
				<td>
					<input type="hidden" id="x1" name="x1" value="0"/>
					<input type="hidden" id="x2" name="x2" value="160" />
					<input type="hidden" id="y1" name="y1" value="0" />
					<input type="hidden" id="y2" name="y2" value="90" />
					<input type="hidden" id="width" name="width" value="160"/>
					<input type="hidden" id="height" name="height" value="90"/>
					<input type="hidden" id="file_name" name="file_name" value=""  />
					<input type="hidden" id="ext" name="ext" value=""  />
					<input type="hidden" name="method" value="eventSave"/>
					<input type="hidden" name="action" value="share"/>
					<input type="hidden" name="id" value="<?php echo $event[0]["id"];?>"/>
					<div id="file-uploader">
					<noscript>
					    <p>Please enable JavaScript to use file uploader.</p>
					    <!-- or put a simple form for upload here -->
					</noscript>
					</div>
					<script type="text/javascript">
					var ias ="";
					var uploader = new qq.FileUploader({
					    // pass the dom node (ex. $(selector)[0] for jQuery users)
					    element: document.getElementById('file-uploader'),
					    // path to server-side upload script
					    action: '/event_img_upload.php',
					    debug: false,
					    params: {
								id : <?php echo $this->_tpl_vars["name"];?>
						    },
					    onComplete: function(id,fileName,json){
						    $("#photo_empty_msg").remove();
					    	$(".photo_box").removeClass("error_content_div");
					    	$(".upload_error").remove();
							$(".upload_success").remove();
						    var error = $(document.createElement("span")).addClass("upload_error").text(json.reason);
						    var success = $(document.createElement("span")).addClass("upload_success").text("Upload success!");
								if(json.success == false){
										$("#file-uploader").append(error);
										
									}else{
										var img =  $(document.createElement("img")).attr("src","../circle_event_img/<?php echo $this->_tpl_vars["name"];?>/"+json.file_name+"."+json.ext); 
										$("#file_name").val(json.file_name);
										$("#ext").val(json.ext);
										if(ias!=""){
										ias.remove();
										}
										$(".photo_box").children().remove();
										$(".photo_box").append(img);
											
										ias  =img.imgAreaSelect({
											aspectRatio: '16:9',
											handles: true,
											minHeight: 90,
											minWidth: 160,
											instance: true,
											x1: 0, y1: 0, x2: 160, y2: 90,
											persistent: true,
									//		onSelectChange: preview ,
											onSelectEnd: function (img, selection) {
												$("#x1").val(selection.x1);	 
												$("#x2").val(selection.x2);	 
												$("#y1").val(selection.y1);	 
												$("#y2").val(selection.y2);	 
												$("#width").val(selection.width);	 
												$("#height").val(selection.height);	
											}   		
										});
										} 
						    }
					});
										
					
					</script>
					
				</td>
			</tr>
			<tr>
				<th><label class="fr" for="introduction">Introduction: *</label></th>
				<td>
					<textarea class="circle_text required" name="introduction" id="introduction" style="height: 350px;" cols="30" rows="10"><?php echo str_replace("<br />", "", $event[0]["introduction"]);?></textarea>
					<font class="introduction_limit" style="font-style:italic">Maximum of 2000 characters</font>	
				</td>
			</tr>
			<tr>
				<th style="line-height: 25px;vertical-align: top;"><label class="fr" for="post_name">Time Period: *</label></th>
				<td style="padding-top:15px;">
				<select name="time_type" id="time_type">
					<option <?php if($event[0]["event_time_type"]==1)echo "selected=selected";?> value="1">One Day</option>
					<option <?php if($event[0]["event_time_type"]==2)echo "selected=selected";?> value="2">Serveral Days</option>
					<option <?php if($event[0]["event_time_type"]==3)echo "selected=selected";?> value="3">Every Week</option>
					<option <?php if($event[0]["event_time_type"]==4)echo "selected=selected";?> value="4">Custom</option>
				</select>
				
				<div id="time_type_1_box" class="time_type_box <?php if($event[0]["event_time_type"]!=1)echo "hide";?>">
					
				<input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date_type_1" maxlength="50" value="<?php if($event[0]["event_time_type"]==1)echo date("Y-m-d",strtotime($event_time[0]["start_date"])); ?>">
				&nbsp;&nbsp;<select name="start_time_type_1" id="start_time" class="required"><option value="">start time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						   if($event[0]["event_time_type"]==1)$selected = (date('G:i', $i) == $event_time[0]["start_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select> -- 
				
				<select name="end_time_type_1" id="end_time" class="required"><option value="">end time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						   if($event[0]["event_time_type"]==1)$selected = (date('G:i', $i) == $event_time[0]["end_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select>
				</div>
				<div id="time_type_2_box" class="time_type_box <?php if($event[0]["event_time_type"]!=2)echo "hide";?>">
				<table>
					<tr>
						<td>Date: </td>
						<td>
							<input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date_type_2" maxlength="50" value="<?php if($event[0]["event_time_type"]==2)echo date("Y-m-d",strtotime($event_time[0]["start_date"])); ?>">
							-- <input class="circle_editor_input small_input required  datePicker"  type="text" name="end_date_type_2" maxlength="50" value="<?php if($event[0]["event_time_type"]==2)echo date("Y-m-d",strtotime($event_time[0]["end_date"])); ?>">
						
						</td>
					</tr>
					<tr>
						<td>Time: </td>
						<td><select name="start_time_type_2" id="start_time" class="required"><option value="">start time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						    if($event[0]["event_time_type"]==2)$selected = (date('G:i', $i) == $event_time[0]["start_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select> -- 
				
				<select name="end_time_type_2" id="end_time" class="required"><option value="">end time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						    if($event[0]["event_time_type"]==2)$selected = (date('G:i', $i) == $event_time[0]["end_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select></td>
					</tr>
				</table>

				
				</div>
				
				<div id="time_type_3_box" class="time_type_box <?php if($event[0]["event_time_type"]!=3)echo "hide";?>">
				<table>
					<tr>
						<td>Week Days:</td>
						<td>
							<div class="week-label oh">
								<label for="week_sun">Su<input <?php if (strpos($event_time[0]["week_day"],'Sun') !== false) { echo 'checked=checked';}?> type="checkbox" id="week_sun" value="Sun" name="week_days[]"></label>
		                        <label for="week_mon">Mo<input <?php if (strpos($event_time[0]["week_day"],'Mon') !== false) { echo 'checked=checked';}?> type="checkbox" id="week_mon" value="Mon" name="week_days[]"></label>
		                        <label for="week_tue">Tu<input <?php if (strpos($event_time[0]["week_day"],'Tue') !== false) { echo 'checked=checked';}?> type="checkbox" id="week_tue" value="Tue" name="week_days[]"></label>
		                        <label for="week_wed">We<input <?php if (strpos($event_time[0]["week_day"],'Wed') !== false) { echo 'checked=checked';}?> type="checkbox" id="week_wed" value="Wed" name="week_days[]"></label>
		                        <label for="week_thu">Th<input <?php if (strpos($event_time[0]["week_day"],'Thu') !== false) { echo 'checked=checked';}?> type="checkbox" id="week_thu" value="Thu" name="week_days[]"></label>
		                        <label for="week_fri">Fr<input <?php if (strpos($event_time[0]["week_day"],'Fri') !== false) { echo 'checked=checked';}?> type="checkbox" id="week_fri" value="Fri" name="week_days[]"></label>
		                        <label for="week_sat">Sa<input <?php if (strpos($event_time[0]["week_day"],'Sat') !== false) { echo 'checked=checked';}?> type="checkbox" id="week_sat" value="Sat" name="week_days[]"></label>     
		                    </div>
						</td>
					</tr>
					<tr>
						<td>Date:</td>
						<td><input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date_type_3" maxlength="50"  value="<?php if($event[0]["event_time_type"]==3)echo date("Y-m-d",strtotime($event_time[0]["start_date"])); ?>">
							-- <input class="circle_editor_input small_input required  datePicker"  type="text" name="end_date_type_3" maxlength="50" value="<?php if($event[0]["event_time_type"]==3)echo date("Y-m-d",strtotime($event_time[0]["end_date"])); ?>">
						</td>
					</tr>
					<tr>
						<td>Time:</td>
						<td>
					<select name="start_time_type_3" id="start_time" class="required"><option value="">start time</option>
					
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						   if($event[0]["event_time_type"]==3)$selected = (date('G:i', $i) == $event_time[0]["start_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select> -- 
				
				<select name="end_time_type_3" id="end_time" class="required"><option value="">end time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						    if($event[0]["event_time_type"]==3)$selected = (date('G:i', $i) == $event_time[0]["end_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select>
						</td>
					</tr>
				</table>
				</div>
				
				<div id="time_type_4_box" class="time_type_box <?php if($event[0]["event_time_type"]!=4)echo "hide";?>">
				<div id="muti_main_box">
				<?php foreach ($event_time as $key=>$e_time){?>
				<?php if($event[0]["event_time_type"]!=4):?>
				<div class="time_muti_box">
					<input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date[]" maxlength="50" value="<?php if($event[0]["event_time_type"]==4)echo date("Y-m-d",strtotime($e_time["start_date"]));?>">
				&nbsp;&nbsp;<select name="start_time[]" id="start_time" class="required"><option value="">start time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						   if($event[0]["event_time_type"]==4)$selected = (date('G:i', $i) == $e_time["start_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select> -- 
				
				<select name="end_time[]" id="end_time" class="required"><option value="">end time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						   if($event[0]["event_time_type"]==4)$selected = (date('G:i', $i) == $e_time["end_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select>
				</div>
				<?php endif;?>
				<div class="time_muti_box">
					<input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date[]" maxlength="50" value="<?php if($event[0]["event_time_type"]==4)echo date("Y-m-d",strtotime($e_time["start_date"]));?>">
				&nbsp;&nbsp;<select name="start_time[]" id="start_time" class="required"><option value="">start time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						   if($event[0]["event_time_type"]==4)$selected = (date('G:i', $i) == $e_time["start_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select> -- 
				
				<select name="end_time[]" id="end_time" class="required"><option value="">end time</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
						
						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800) 
						{
						   if($event[0]["event_time_type"]==4)$selected = (date('G:i', $i) == $e_time["end_time"]) ? ' selected="selected"' : '';
						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select>
				<?php if($key>1):?>
				<span class="close_day_button">X</span>
				<?php endif;?>
				</div>
				<?php }?>
				
				</div>
				<div class="add_button_box"><span id="add_button">Add</span></div>
				</div>
				</td>
			</tr>
		
			<tr>
				<th><label for="phone">Event Cost: </label></th>
				<td>
					<input id="event_pay" class="circle_editor_input big_input" type="text" name="event_pay" maxlength="50" value="<?php echo $event[0]["event_pay"];?>">
				</td>
			</tr>
			<tr>
				<th><label for="location">Location: *</label></th>
				<td>
					<select name="location" id="location">
						<option value="Suzhou">Suzhou</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="address">Address: *</label></th>
				<td>
					<input id="address" class="circle_editor_input big_input required" type="text" name="address" value="<?php echo $event[0]["address"]?>" maxlength="50">
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<a id="map_link" href="javascript:void(0);">
					<?php if($event[0]["map"]!=""):?>
					<img src="http://maps.google.cn/maps/api/staticmap?size=409x106&zoom=15&markers=<?php echo $event[0]["map"];?>&sensor=false&language=en" width="409" height="106">
					<?php else:?>
					<img src="http://maps.google.cn/maps/api/staticmap?size=409x106&zoom=15&center=31.298886,120.58531600000003&sensor=false&language=en" width="409" height="106">
					<span>Mark the location on the map</span>
					<?php endif;?>
					</a>
					<input type="hidden" name="map_location_num" id="map_location_num" value="<?php echo $event[0]["map"];?>"/>
				</td>
			</tr>
			<tr>
				<th><label for="phone">Phone: </label></th>
				<td>

					<input id="phone" class="circle_editor_input big_input" type="text" value="<?php echo $event[0]["phone"];?>" name="phone" maxlength="50">
				</td>
			</tr>
			<tr>
				<th><label for="email">Email: *</label></th>
				<td>
					<input id="email" class="circle_editor_input big_input required email" type="text" name="email" value="<?php echo $event[0]["email"]?>" maxlength="50">
					<font class="introduction_limit" style="font-style:italic">This will allow us to be more motivated to communicate with you. 
					<br />We respect the personal privacy</font>	
				</td>
			</tr>
			<tr>
				<th><input id="agree_terms" type="checkbox" checked="checked" class=""/></th>
				<td><label for="agree_terms" style="font-style:italic">I have read and agree to the wowshopping.com.cn service agreement</label></td>
			</tr>
			<tr>
				<th></th>
				<td>
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$this->_tpl_vars["IN"]["id"]))?>" class="cancel_button fr" href="">Cancel</a>
				<input id="submit_share_list" class="blue_button_large fr" type="submit" value="Save">
				</td>
			</tr>
		</table>	
			
		</form>
	</div>
	<div class="circle_msg_box gray_line_box fr" style="height: 468px;">
		<p>Taking into account the requirements of Chinese laws and
 
regulations and related policies, we do not welcome 

pornography, radical topic of discussion of the ideological, 

and reserves the right to the dissolution of such topics circles.
</p>
	
	<p style="color:#5e97ed">
	<span style="font-size:12px;line-height:36px;">How to make your events more attractive?</span><br />

The title is simple and clear
Activities and Features detailed
Eye-catching posters 
More importantly, to invite friends to participate in</p>
	</div>
	</div>
	</div>
	</div>
	<div class="dialog" id="location_picker" style="width:600px;" title="Location Mark">
		<input id="map_location" type="text" placeholder="Location Search" />
		<div id="map_canvas">
		</div>
		<div class="map_ctrl">
		<a id="confirm_mark" class="blue_button_small fl">Save</a>
		<a id="close_map" class="fl">Cancle</a>
		</div>
	</div>	
	<script type="text/javascript">
			$(function(){

					$(".close_day_button").click(function(){$(this).parent().remove()});
				
					$("#time_type").change(function(){
		
							var t_id = $(this).val();
							var show_type_id = "time_type_"+t_id+"_box";
							$(".time_type_box").hide();
							$("#"+show_type_id).slideDown();
							
					});

					$(".datePicker").datepicker({ dateFormat: "yy-mm-dd" });

					$("#event_create_form").validate({
						errorPlacement: function(error, element) {
				         // console.info(element.parent().prev("th").append(error));
				        }
				});
				

					$("#add_button").click(function(){

							var box = $(".get_ready_box").clone().removeClass("get_ready_box");
							var close = $(document.createElement("span")).addClass("close_day_button").text("X").click(function(){$(this).parent().remove()});
							var date_hook = $(document.createElement("input")).attr({type:"text",name:"start_date[]"}).addClass("circle_editor_input small_input datePicker required").datepicker({ dateFormat: "yy-mm-dd" });
							//$(box).children(".datePicker").datepicker({ dateFormat: "yy-mm-dd" });
							$(box).append(close);
							$(box).prepend(date_hook);
							$(box).appendTo("#muti_main_box").slideDown();
						});
				});
	</script>
<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
		
		<div class="time_muti_box hide get_ready_box">
	
	&nbsp;&nbsp;<select name="start_time[]" id="start_time" class="required"><option value="">start time</option>
		<?php $time = time();
			$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
			
			$start = strtotime('12:00am');
			$end = strtotime('11:59pm');
			for( $i = $start; $i <= $end; $i += 1800) 
			{
			   
			    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
			}
		?>
	</select> -- 
	
	<select name="end_time[]" id="end_time" class="required"><option value="">end time</option>
		<?php $time = time();
			$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;
			
			$start = strtotime('12:00am');
			$end = strtotime('11:59pm');
			for( $i = $start; $i <= $end; $i += 1800) 
			{
			   
			    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
			}
		?>
	</select>
	</div>	
</body>
</html>

<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

<?php } ?>
