<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
//************************select country***************************************
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
	'action' => "sql",
	'return' => "country",
	'query' => "SELECT * FROM a0222211743.cms_country ",
);
$this->_tpl_vars['country'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;


?>
<?php if ($this->_tpl_vars["name"]){?>
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
<body>
	<div class="box">    
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc("account/common/header.tpl");
	include($inc_tpl_file);
	
	
	$profile = runFunc("getUserProfile",array($this->_tpl_vars["name"]));
	$member_account_info = runFunc("getShareMemberInfoAllInOne",array($this->_tpl_vars["name"]));
	?>

		<div class="content">
             <div class="address">
                <div class="addresstitle">
                    <h1>WELCOME TO WOWshopping</h1>
                    <h2>Edit Your Profile</h2>
                </div>
       		 </div>       
        
			<form action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="share" /> 
				<input type="hidden" name="method" value="saveProfile">
				<input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars["name"];?>" />

				<div class="edit_profile">

					<div class="profile_phtoto">
						<div class="photo_box1">
							<span>Your Photo</span>
						</div>
						<div class="photo_box2">
							<div class="profile_phtoto_img">
								<?php if(file_exists($avatar)){?>
							<img src="<?php echo $avatar."_40.".$this->_tpl_vars["userInfo"]["0"]["headImageUrl"];?>" alt="userInfo" id="userHeaderImg" />
								<?php }else{ ?>
							<a href=""></a>
							<img src="../skin/images/pic.jpg" alt="userInfo" id="userHeaderImg" />
							<?php } ?>
							</div>
							<span class="profile_blue fl up_new_photo"><a  href="<?php echo runFunc('encrypt_url',array('action=share&method=uploadAvatar'));?>" style="color: #979595;">Upload New Photo</a></span>
						</div>
					</div>
					<div class="base_info">
						<table>
							<tr>
								<td rowspan="9" width="35%" style="vertical-align: top;">
                                <span>Basic info</span></td>
								<td width="25%">First Name</td>
								<td width="50%"><input type="text" name="first_name" value="<?php echo $profile["first_name"];?>" /></td>
							</tr>
							<tr>
								<td>Last Name</td>
								<td><input type="text" name="last_name" value="<?php echo $profile["last_name"];?>" /></td>
							</tr>
							<tr>
								<td>Nick Name</td>
								<td><input type="text" name="nick_name" value="<?php echo $member_account_info[0]["staffName"];?>" /></td>
							</tr>
							<tr>
								<td>Birthday</td>
								<td><select name="DateOfBirth_Month">
										<option name="DateOfBirth_Month" value="">- Month -</option>
										<option name="DateOfBirth_Month" value="Jan"
										<?php if($profile["DateOfBirth_Month"]=="Jan"){echo 'selected';}?>>Jan</option>
										<option name="DateOfBirth_Month" value="Feb"
										<?php if($profile["DateOfBirth_Month"]=="Feb"){echo "selected";}?>>Feb</option>
										<option name="DateOfBirth_Month" value="Mar"
										<?php if($profile["DateOfBirth_Month"]=="Mar"){echo "selected";}?>>Mar</option>
										<option name="DateOfBirth_Month" value="Apr"
										<?php if($profile["DateOfBirth_Month"]=="Apr"){echo "selected";}?>>Apr</option>
										<option name="DateOfBirth_Month" value="May"
										<?php if($profile["DateOfBirth_Month"]=="May"){echo "selected";}?>>May</option>
										<option name="DateOfBirth_Month" value="Jun"
										<?php if($profile["DateOfBirth_Month"]=="Jun"){echo "selected";}?>>Jun</option>
										<option name="DateOfBirth_Month" value="July"
										<?php if($profile["DateOfBirth_Month"]=="Jul"){echo "selected";}?>>Jul</option>
										<option name="DateOfBirth_Month" value="Aug"
										<?php if($profile["DateOfBirth_Month"]=="Aug"){echo "selected";}?>>Aug</option>
										<option name="DateOfBirth_Month" value="Sep"
										<?php if($profile["DateOfBirth_Month"]=="Sep"){echo "selected";}?>>Sep</option>
										<option name="DateOfBirth_Month" value="Oct"
										<?php if($profile["DateOfBirth_Month"]=="Oct"){echo "selected";}?>>Oct</option>
										<option name="DateOfBirth_Month" value="Nov"
										<?php if($profile["DateOfBirth_Month"]=="Nov"){echo "selected";}?>>Nov</option>
										<option name="DateOfBirth_Month" value="Dec"
										<?php if($profile["DateOfBirth_Month"]=="Dec"){echo "selected";}?>>Dec</option>
								</select> <select name="DateOfBirth_Day">
										<option value="">- Day -</option>
										<option value="1"
										<?php if($profile["DateOfBirth_Day"]=="1"){echo 'selected';}?>>1</option>
										<option value="2"
										<?php if($profile["DateOfBirth_Day"]=="2"){echo 'selected';}?>>2</option>
										<option value="3"
										<?php if($profile["DateOfBirth_Day"]=="3"){echo 'selected';}?>>3</option>
										<option value="4"
										<?php if($profile["DateOfBirth_Day"]=="4"){echo 'selected';}?>>4</option>
										<option value="5"
										<?php if($profile["DateOfBirth_Day"]=="5"){echo 'selected';}?>>5</option>
										<option value="6"
										<?php if($profile["DateOfBirth_Day"]=="6"){echo 'selected';}?>>6</option>
										<option value="7"
										<?php if($profile["DateOfBirth_Day"]=="7"){echo 'selected';}?>>7</option>
										<option value="8"
										<?php if($profile["DateOfBirth_Day"]=="8"){echo 'selected';}?>>8</option>
										<option value="9"
										<?php if($profile["DateOfBirth_Day"]=="9"){echo 'selected';}?>>9</option>
										<option value="10"
										<?php if($profile["DateOfBirth_Day"]=="10"){echo 'selected';}?>>10</option>
										<option value="11"
										<?php if($profile["DateOfBirth_Day"]=="11"){echo 'selected';}?>>11</option>
										<option value="12"
										<?php if($profile["DateOfBirth_Day"]=="12"){echo 'selected';}?>>12</option>
										<option value="13"
										<?php if($profile["DateOfBirth_Day"]=="13"){echo 'selected';}?>>13</option>
										<option value="14"
										<?php if($profile["DateOfBirth_Day"]=="14"){echo 'selected';}?>>14</option>
										<option value="15"
										<?php if($profile["DateOfBirth_Day"]=="15"){echo 'selected';}?>>15</option>
										<option value="16"
										<?php if($profile["DateOfBirth_Day"]=="16"){echo 'selected';}?>>16</option>
										<option value="17"
										<?php if($profile["DateOfBirth_Day"]=="17"){echo 'selected';}?>>17</option>
										<option value="18"
										<?php if($profile["DateOfBirth_Day"]=="18"){echo 'selected';}?>>18</option>
										<option value="19"
										<?php if($profile["DateOfBirth_Day"]=="19"){echo 'selected';}?>>19</option>
										<option value="20"
										<?php if($profile["DateOfBirth_Day"]=="20"){echo 'selected';}?>>20</option>
										<option value="21"
										<?php if($profile["DateOfBirth_Day"]=="21"){echo 'selected';}?>>21</option>
										<option value="22"
										<?php if($profile["DateOfBirth_Day"]=="22"){echo 'selected';}?>>22</option>
										<option value="23"
										<?php if($profile["DateOfBirth_Day"]=="23"){echo 'selected';}?>>23</option>
										<option value="24"
										<?php if($profile["DateOfBirth_Day"]=="24"){echo 'selected';}?>>24</option>
										<option value="25"
										<?php if($profile["DateOfBirth_Day"]=="25"){echo 'selected';}?>>25</option>
										<option value="26"
										<?php if($profile["DateOfBirth_Day"]=="26"){echo 'selected';}?>>26</option>
										<option value="27"
										<?php if($profile["DateOfBirth_Day"]=="27"){echo 'selected';}?>>27</option>
										<option value="28"
										<?php if($profile["DateOfBirth_Day"]=="28"){echo 'selected';}?>>28</option>
										<option value="29"
										<?php if($profile["DateOfBirth_Day"]=="29"){echo 'selected';}?>>29</option>
										<option value="30"
										<?php if($profile["DateOfBirth_Day"]=="30"){echo 'selected';}?>>30</option>
										<option value="31"
										<?php if($profile["DateOfBirth_Day"]=="31"){echo 'selected';}?>>31</option>
								</select>
								</td>
							</tr>
							<tr>
								<td>Gender</td>
								<td>
								<input  type="radio" name="sex" value="male" <?php if($profile["sex"]=="male"){echo "checked";}?> /> 
								Male
								<input style="margin-left: 30px;" type="radio" name="sex" value="female" <?php if($profile["sex"]=="female"){echo "checked";}?> />
								Female</td>
							</tr>
							<tr>
								<td>Country</td>
								<td><select name="Country">

									<?php foreach ($this->_tpl_vars["country"]["data"] as $country):?>
										<option value="<?php echo $country["country"];?>"
										<?php if($profile["Country"]==$country["country"]){echo "selected='selected'";}?>>
											<?php echo $country["country"];?>
										</option>
										<?php endforeach;?>
								</select></td>
							</tr>
							<tr>
								<td>State/Region</td>
								<td><input type="text" name="State"
									value="<?php echo $profile["State"];?>" /></td>
							</tr>
							<tr>
								<td>City</td>
								<td><input type="text" name="City"
									value="<?php echo $profile["City"];?>" /></td>
							</tr>
							<tr>
								<td>Location now</td>
								<td><input type="text" name="Location"
									value="<?php echo $profile["Location"];?>" /></td>
							</tr>
						</table>
					</div>
<!--					<div class="base_info">
						<table>
							<tr>
								<td rowspan="8" width="25%" style="vertical-align: top;"><span>Privacy
										Control</span></td>
								<td width="7%"><input type="checkbox" name="real_name" value="1"
								<?php if($profile["real_name"]=="1"){echo "checked";}?> />
								</td>
								<td width="40%">Show my real name</td>
							</tr>

							<tr>
								<td><input type="checkbox" name="show_nick" value="1"
								<?php if($profile["show_nick"]=="1"){echo "checked";}?> />
								</td>
								<td>Show nick name</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="ofc_see" value="1"
								<?php if($profile["ofc_see"]=="1"){echo "checked";}?> /></td>
								<td>Only friend who follow me can see my profile</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="sb_see" value="1"
								<?php if($profile["sb_see"]=="1"){echo "checked";}?> /></td>
								<td>Show my birthday to my friends</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="smw_see" value="1"
								<?php if($profile["smw_see"]=="1"){echo "checked";}?> /></td>
								<td>Show my wishlist to my friends</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="Newsletter" value="1"
								<?php if($profile["Newsletter"]=="1"){echo "checked";}?> />
								</td>
								<td>Newsletter</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="Shopping_reminder"
								<?php if($profile["Shopping_reminder"]=="1"){echo "checked";}?>
									value="1" /></td>
								<td>Shopping reminder</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="Activity" value="1"
								<?php if($profile["Activity"]=="1"){echo "checked";}?> />
								</td>
								<td>Activity</td>
							</tr>
						</table>
					</div>-->
					<div class="base_info">
						<table>
							<tr>
								<td rowspan="2" width="25%" style="vertical-align: top;"><span>About Me</span> <span id="about_limit">(150 words max)</span></td>
								<td width="40%">
								<textarea id="about_me" onKeyUp="checkWordLen(this);" name="about_me" style="width: 320px; height: 147px; margin-top: 10px; margin-left: 18px;"><?php if(trim($profile["about_me"])!=""){echo $profile["about_me"];}?></textarea>
								</td>
								<script type="text/javascript">
									function checkWordLen(e){
										var limit = 150 - $(e).val().length;
										var limit_word = "("+ limit +" words max)";
									
										if($(e).val().length >=150){
											$(e).val($(e).val().substring(0, 150));
											limit_word = "(0 words max)";
										}
										$("#about_limit").text(limit_word);
									}
									
									$(function(){
										var limit = 150 - $("#about_me").val().length;
										var limit_word = "("+ limit +" words max)";
										$("#about_limit").text(limit_word);
									});
			
								</script>
							</tr>
						</table>
					</div>

					<div class="base_info" style="margin-bottom:20px;">
					
					
					<table class="social_info_table">
<!--							<tr>
								<td rowspan="10" width="25%" style="vertical-align: top;"><span>Your links</span></td>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/mail15.png) left center no-repeat; ">E-mail</div>
									<input type="text" name="mail" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['mail']);?>" />
								</td>
							</tr>-->
							<tr>
                            	<td rowspan="10" width="25%" style="vertical-align: top;"><span>Your links</span></td>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/facebook15.png) left center no-repeat; ">Facebook</div>
									<div class="social_example">http://www.facebook.com/profile?id= </div> 
									<input type="text" name="facebook" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['facebook']);?>" />
								</td>
							</tr>
							<tr>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/picassa15.png) left center no-repeat; ">Picasa</div>
									<div class="social_example"> http://picasaweb.google.com/</div> 
									<input type="text" name="Picasa" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['Picasa']);?>" />
								</td>
							</tr>
							<tr>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/flickr15.png) left center no-repeat; ">Filckr</div>
									<div class="social_example"> http://www.flickr.com/photos/</div> 
									<input type="text" name="Flickr" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['Flickr']);?>" />
								</td>
							</tr>
							<tr>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/youtube15.png) left center no-repeat; ">Youtube</div>
									<div class="social_example"> http://www.youtube.com/user/ </div> 
									<input type="text" name="Youtube" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['Youtube']);?>" />
								</td>
							</tr>

							<tr>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/twitter15.png) left center no-repeat; ">Twitter</div>
									<div class="social_example">http://twitter.com/</div> 
									<input type="text" name="Twitter" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['Twitter']);?>" />
								</td>
							</tr>
							<tr>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/pinterest15.png) left center no-repeat; ">Pinterest</div>
									<div class="social_example">http://pinterest.com/</div> 
									<input type="text" name="Pinterest" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['Pinterest']);?>" />
								</td>
							</tr>
							<tr>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/myspace15.png) left center no-repeat; ">Myspace</div>
									<div class="social_example">http://Myspace.com/</div> 
									<input type="text" name="Myspace" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['Myspace']);?>" />
								</td>
							</tr>
							<tr>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/linkedin15.png) left center no-repeat; ">Linkedin</div>
									<div class="social_example">http://Linkedin.com/</div> 
									<input type="text" name="Linkedin" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['Linkedin']);?>" />
								</td>
							</tr>
							<tr>
								<td width="40%" >
									<div class="social_title" style="background:url(../publish/skin/images/social/google15.png) left center no-repeat; ">Google+</div>
									<div class="social_example">http://plus.google.com/</div> 
									<input type="text" name="Google" style="width: 300px;" value="<?php echo str_replace("http://","",$profile['Google']);?>" />
								</td>
							</tr>
						</table>

					</div>
					<input type="submit" style="float: right; width: 110px; height: 30px; border: medium none; cursor: pointer;margin-right: 10px;font-size:12px;margin-bottom:50px; vertical-align:middle;" value="Save" class="ubotton">
					<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>" style="color:#5e97ed;font-weight:bold;float: right; width: 88px; height: 30px; border: medium none; cursor: pointer;margin-right: 10px;text-align:center;font-size:12px;line-height:30px;vertical-align:middle;">Cancel</a>

			</form>
		</div>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

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
