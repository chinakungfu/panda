<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
$CKEditor->config['toolbar'] = "Full";
?>
<link rel="stylesheet" href="skin/cssfiles/jquery-ui-1.8.24.custom.css" />
<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);

$circles = runFunc("getAllCirclesAdmin");

$group_buys = runFunc("getAllAdminGroupBuy");
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			发布活动
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=eventList&type=share'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">

		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="event_save" />
			<table class="admin_edit_table">
				<tr>
					<th>关联团购</th>
					<td>
						<select name="group_id" id="group_id">
							<option value="">不关联任何团购</option>
							<?php foreach ($group_buys as $group_buy):?>
							<option value="<?php echo $group_buy["id"];?>">
							<?php echo $group_buy["item_name"];?>
							<?php if($group_buy["sell_way"]==1){echo "=>服务费（".($group_buy['price_rate']*10)."折）";}else{echo "=>商品单价（".($group_buy['price_rate']*10)."折）";}?>
							</option>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
				<tr>
					<th>活动圈子</th>
					<td>
						<select name="circle_id" id="circle_id" class="required">
							<option value="">选择圈子</option>
							<?php foreach ($circles as $circle):?>
							<option value="<?php echo $circle["id"]?>"><?php echo $circle["name"]?></option>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
				<tr>
					<th>活动名称</th>
					<td><input type="text" name="name" id="name" class="dark_border input_bar_long required"/></td>
				</tr>
				<tr>
					<th>活动组织者</th>
					<td>
						<input type="text" name="organizers" id="organizers" class="dark_border input_bar_long required"/>
					</td>
				</tr>
				<!--
				<tr>
					<th>外链</th>
					<td>
						<input type="text" name="out_link" id="out_link" class="dark_border input_bar_long" value="<?php echo $event[0]["out_link"];?>"/>
					</td>
				</tr>
				-->
				<tr>
					<th>推荐活动</th>
					<td>
						<input checked="checked" id="special_1" type="radio" value="0" name="special"/>
						<label for="special_1">不推荐</label>
						&nbsp;&nbsp;
						<input id="special_2" type="radio" value="1" name="special"/>
						<label for="special_2">推荐</label>
					</td>
				</tr>
				<tr>
					<th>活动发布者</th>
					<td>
						<select name="created" id="created">
							<option value="1">官方</option>
							<option value="2">圈子建立者</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>活动状态</th>
					<td>
						<select name="status" id="status">
							<option value="1">发布</option>
							<option value="2">关闭</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>活动费用</th>
					<td>
						<input type="text" name="event_pay" id="event_pay" class="dark_border input_bar_long number required" min=0 value="0.00"/>
					</td>
				</tr>
				<tr>
					<th>活动图片<br /></th>
					<td><input type="file" name="event_img_large" class="required"/>（大图800 x 245）</td>
				</tr>
				<tr>
					<th>活动图片<br /></th>
					<td><input type="file" name="event_img" class="required"/>（小图325 x 175）</td>
				</tr>
				<tr>
					<th>活动描述</th>
					<td>
						<?php $CKEditor->editor("introduction");?>
					</td>
				</tr>
				<tr>
					<th style="vertical-align: top; padding-top: 22px;">活动时间</th>
					<td>
						<select name="time_type" id="time_type">
					<option value="1">当天活动</option>
					<option value="2">多天活动</option>
					<option value="3">每周活动</option>
					<option value="4">自定义</option>
				</select>

				<div id="time_type_1_box" class="time_type_box ">

				<input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date_type_1" maxlength="50">
				&nbsp;&nbsp;<select name="start_time_type_1" id="start_time" class="required"><option value="">开始时间</option>
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

				<select name="end_time_type_1" id="end_time" class="required"><option value="">结束时间</option>
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
				<div id="time_type_2_box" class="time_type_box hide">
				<table>
					<tr>
						<td>日期: </td>
						<td>
							<input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date_type_2" maxlength="50">
							-- <input class="circle_editor_input small_input required  datePicker"  type="text" name="end_date_type_2" maxlength="50">

						</td>
					</tr>
					<tr>
						<td>时间: </td>
						<td><select name="start_time_type_2" id="start_time" class="required"><option value="">开始时间</option>
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

				<select name="end_time_type_2" id="end_time" class="required"><option value="">结束时间</option>
					<?php $time = time();
						$rounded_time = $time % 1800 > 900 ? $time += (1800 - $time % 1800):  $time -= $time % 1800;

						$start = strtotime('12:00am');
						$end = strtotime('11:59pm');
						for( $i = $start; $i <= $end; $i += 1800)
						{

						    echo '<option' . $selected . '>' . date('G:i', $i) . '</option>';
						}
					?>
				</select></td>
					</tr>
				</table>


				</div>

				<div id="time_type_3_box" class="time_type_box hide">
				<table>
					<tr>
						<td>周:</td>
						<td>
							<div class="week-label oh">
								<label for="week_sun">日<input type="checkbox" id="week_sun" value="Sun" name="week_days[]"></label>
		                        <label for="week_mon">一<input type="checkbox" id="week_mon" value="Mon" name="week_days[]"></label>
		                        <label for="week_tue">二<input type="checkbox" id="week_tue" value="Tue" name="week_days[]"></label>
		                        <label for="week_wed">三<input type="checkbox" id="week_wed" value="Wed" name="week_days[]"></label>
		                        <label for="week_thu">四<input type="checkbox" id="week_thu" value="Thu" name="week_days[]"></label>
		                        <label for="week_fri">五<input type="checkbox" id="week_fri" value="Fri" name="week_days[]"></label>
		                        <label for="week_sat">六<input type="checkbox" id="week_sat" value="Sat" name="week_days[]"></label>
		                    </div>
						</td>
					</tr>
					<tr>
						<td>日期:</td>
						<td><input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date_type_3" maxlength="50">
							-- <input class="circle_editor_input small_input required  datePicker"  type="text" name="end_date_type_3" maxlength="50">
						</td>
					</tr>
					<tr>
						<td>时间:</td>
						<td>
					<select name="start_time_type_3" id="start_time" class="required"><option value="">开始时间</option>

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

				<select name="end_time_type_3" id="end_time" class="required"><option value="">结束时间</option>
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
						</td>
					</tr>
				</table>
				</div>

				<div id="time_type_4_box" class="time_type_box hide">
				<div id="muti_main_box">
				<div class="time_muti_box">
					<input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date[]" maxlength="50">
				&nbsp;&nbsp;<select name="start_time[]" id="start_time" class="required"><option value="">开始时间</option>
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

				<select name="end_time[]" id="end_time" class="required"><option value="">结束时间</option>
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
				<div class="time_muti_box">
				<input class="circle_editor_input small_input required  datePicker"  type="text" name="start_date[]" maxlength="50">
				&nbsp;&nbsp;<select name="start_time[]" id="start_time" class="required"><option value="">开始时间</option>
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

				<select name="end_time[]" id="end_time" class="required"><option value="">结束时间</option>
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
				</div>
				<div class="add_button_box"><span id="add_button">添加</span></div>
				</div>
					</td>
				</tr>
				<tr>
					<th>活动地点</th>
					<td><select name="location" id="location">
							<option value="Suzhou">Suzhou</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>活动详细地址</th>
					<td>
						<input type="text" name="address" id="address" class="dark_border input_bar_long" />
					</td>
				</tr>
				<tr>
				<th></th>
				<td>
					<a id="map_link" href="javascript:void(0);">
					<img src="http://maps.google.cn/maps/api/staticmap?size=409x106&zoom=15&center=31.298886,120.58531600000003&sensor=false&language=en" width="409" height="106">
					<span>Mark the location on the map</span>
					</a>
					<input type="hidden" name="map_location_num" id="map_location_num" value=""/>
				</td>
			</tr>
				<tr>
					<th>联系电话</th>
					<td><input type="text" name="phone" id="phone" class="dark_border input_bar_long" /></td>
				</tr>
				<tr>
					<th>联系邮箱</th>
					<td><input type="text" name="email" id="email" class="dark_border input_bar_long" /></td>
				</tr>
			</table>


		</form>

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

<div class="time_muti_box hide get_ready_box">

	&nbsp;&nbsp;<select name="start_time[]" id="start_time" class="required"><option value="">开始时间</option>
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

	<select name="end_time[]" id="end_time" class="required"><option value="">结束时间</option>
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


	<script type="text/javascript">
			$(function(){

					$("#time_type").change(function(){

							var t_id = $(this).val();
							var show_type_id = "time_type_"+t_id+"_box";
							$(".time_type_box").hide();
							$("#"+show_type_id).slideDown();

					});

					$(".datePicker").datepicker({ dateFormat: "yy-mm-dd" });



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
<script type="text/javascript">
	$(function(){

			$(".datePicker").datepicker({ dateFormat: "yy-mm-dd" });



		});
</script>
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

		});
	</script>

<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
