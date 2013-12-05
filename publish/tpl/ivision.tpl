<HTML lang="en">
	<HEAD>
		<link href="/skin/style/reset.css" rel="stylesheet" type="text/css"/>
		<link href="/skin/style/shop.css" rel="stylesheet" type="text/css"/>
		<link href="/skin/style/base.css" rel="stylesheet" type="text/css"/> 

		
		<SCRIPT type="text/javascript" src="/publish/skin/jsfiles/jquery-1.7.1.min.js"></SCRIPT>
		<SCRIPT type="text/javascript" src="/publish/skin/jsfiles/superfish.js"></SCRIPT>
		<script type="text/javascript">
				jQuery.noConflict();
				jQuery(function(){

					
					
					jQuery(".kcategories").click(function(){
					if(!jQuery(this).hasClass("active_catTitle")){
						jQuery(".kcategories").removeClass("active_catTitle");
						jQuery(this).addClass("active_catTitle");
						jQuery(".catTitle").css("top","40px");
						jQuery(".catTitle").css("border-bottom","0");
						jQuery(this).children(".catTitle").animate({top:"12px"},300,function(){
								jQuery(this).next(".catAuthors").show();
							});
						jQuery(this).children(".catTitle").css("border-bottom","2px solid #ccc");
						jQuery(".catAuthors").hide();
						}
					});

					jQuery(".kcategories").hover(function(){
							jQuery(this).addClass("hover_catTitle");
						},function(){
							jQuery(this).removeClass("hover_catTitle");
							});
					
					
				});
			</script>
		</HEAD>
<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			<div class="sharemain clb">
               <ul class="shareNav">
                 <li><a href="#">MY SHARE</a></li>
                 <li><a href="#">YOURFRIENDS</a></li>
                 <li><a href="#">FRESH WISHS</a></li>
                 <li><a href="#">LINKS ON TAOBAO</a></li>
                 <li><a href="#"  class="shareBtn">SHARE WHAT YOU BOUGHT</a></li>
               </ul>
            <div class="mySareListBao">
	     <div class="mySareListBao">
                 <h2>LINKS ON <span>TAOBAO</span></h2>
                 <div class="mySareListBaoBox">
			<DIV class="kcategories left">
				<A class="catTitle">Beauty</A>
				<DIV class="catAuthors">
					<A class="catAuthor" href="http://www.ivisionphoto.net/index.php/en/portfolio/happy-fu?view=show&amp;user_id=62">HAPPY FU</A> | <A lass="catAuthor" href="http://www.ivisionphoto.net/index.php/en/component/show/?view=show&amp;user_id=63">DAVID 大卫</A>
					</DIV>
				</DIV>		 
			</div>              
		
                     
		    
                 </div>

		 
		
             </div> 
             
         		
			
		<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</HTML>
