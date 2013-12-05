<?php
import('core.util.RunFunc');
$site_title = runFunc('getGlobalModelVar',array('Site_Name'));
$seo_settings = runFunc("getSeoSettings");
?>


<meta content="text/html; charset=utf-8" http-equiv="content-type">
<title><?php echo $site_title;?></title>
<meta content="index, follow" name="robots">
<meta content="<?php echo $seo_settings[0]["seoKeywords"];?>" name="keywords">
<meta content="<?php echo $seo_settings[0]["seoDescription"];?>" name="description">

<link href="/skin/style/reset.css" rel="stylesheet" type="text/css"/>
<link href="/skin/style/shop.css" rel="stylesheet" type="text/css"/>
<link href="/skin/style/share.css" rel="stylesheet" type="text/css"/>
<link href="/skin/style/base.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="/skin/style/jquery.lightbox-0.5.css" />
<link href="/skin/style/hutuadd.css" rel="stylesheet" type="text/css"/>

<!--[if lt IE 9]><script src="/skin/js/ie6/warning.js"></script><script>window.onload=function(){e("/skin/js/ie6/")}</script><![endif]-->
<script type="text/javascript" src="/publish/skin/jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/json.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/ajaxControl.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/utf.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/base64.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/phpserializer.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/xxtea.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/bigint.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/phprpc/phprpc_client.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jquery.validate.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jqzoom/js/jqzoom.min.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/do.js"></script>
<link href="/publish/skin/jsfiles/jqzoom/css/jqzoom.css" rel="stylesheet" type="text/css"/>

<script src="/publish/skin/jsfiles/popup_layer.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/base.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/waterfall.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/button.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jquery-ui-1.8.24.custom.min.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/love.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jquery.qtip-1.0.0-rc3.min.js"></script>
<script src="http://l.tbcdn.cn/apps/top/x/sdk.js?appkey=21552735"></script>
<link href="/publish/skin/imgcss/imgareaselect-default.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">

	$(function(){

			var spam_id = 0;
			var reporting = 0;
			var report_type = "COMMENT";

			$( ".report_spam_box" ).dialog({
				autoOpen: false,
				show: { effect: 'drop', direction: "up" },
				hide: { effect: 'drop', direction: "up" },
				width: 400,
				modal: true
			});



			$("#submit_spam_report").click(function(){
				if(reporting == 1){
						return false;
					}else{

						reporting = 1;
						}

				var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
				$(".spam_message").hide();
				$(".spam_reason_box").hide();
				$("#submit_spam_report").hide();
				$(".close_spam").hide();
				loading_icon.insertAfter($(".spam_title"));
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "json",
					data:{
						action	: "website",
						method	: "report_spam",
						about_id : spam_id,
						type : report_type,
						reason : $("#spam_reason").val()

						},success : function(json){
							if(json.exist=="1"){
								var report_success = $(document.createElement("div")).addClass("report_success").text("Your have reported it already.");
								}else{
									var report_success = $(document.createElement("div")).addClass("report_success").text("We have received your report,  Our Customer Service will deal with this spam information as soon as possible.");
									}

							loading_icon.replaceWith(report_success);
							$(".close_spam").show();
							reporting = 0;
						},complete : function(){

						}
					});
				});

			$(".poll_comment_report_spam").click(function(){


				reporting = 0
				report_type = "VOTE COMMENT";
				spam_id = $(this).attr("id");
				$(".report_success").remove();
				$(".loading_sm").remove();
				$(".spam_message").show();
				$(".spam_reason_box").show();
				$("#submit_spam_report").show();
				$(".close_spam").show();
				$("#spam_reason").val("");
				var spam_comment_message = $(this).parent().children(".poll_vote_comment_text").html();
				var spam_comment_creater = $(this).parent().children().children(".poll_voter_detail").children("a");
				var spam_comment_create_time = $(this).parent().children().children(".poll_voter_detail").children("div").html();
				$(".spam_message .comment_msg").text("");
				$(".spam_comment_content").text("");
				$(".spam_message .comment_msg").children().remove();
				$(".spam_comment_content").children().remove();
				$(".spam_message .comment_msg").append(spam_comment_creater);
				$(".spam_message .comment_msg").append(spam_comment_create_time);
				$(".spam_comment_content").append(spam_comment_message);
				$( ".report_spam_box" ).dialog("open");

				});

			$(".report_spam").click(function(){
				reporting = 0
				spam_id = $(this).attr("id");
				$(".report_success").remove();
				$(".loading_sm").remove();
				$(".spam_message").show();
				$(".spam_reason_box").show();
				$("#submit_spam_report").show();
				$(".close_spam").show();
				$("#spam_reason").val("");
				var spam_comment_message = $(this).parent().parent().children(".comment_detail_top").html();
				var spam_comment_creater = $(this).parent().parent().parent().siblings(".comment_msg").html();
				$(".spam_message .comment_msg").children().remove();
				$(".spam_message .comment_msg").text("");
				$(".spam_comment_content").children().remove();
				$(".spam_comment_content").text("");
				$(".spam_message .comment_msg").append(spam_comment_creater);
				$(".spam_comment_content").append(spam_comment_message);
				$( ".report_spam_box" ).dialog("open");
				});

			$(".close_spam").click(function(){
				$( ".report_spam_box" ).dialog("close");
				});
		});
</script>
