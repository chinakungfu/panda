<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML>
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
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

               <div class="mainMyShare fl">
                   <div class="contentRLeft">
                        <dl class="userInfo">
                            <dt><img src="../skin/images/pic.jpg" width="50" height="50" align="logo"></dt>
                            <dd>Welcome Back</dd>
                            <dd>HAPPY FU</dd>
                            <dd id="userEmail">ivisionservice@gmail.com</dd>
                        </dl>
                        <div id="userInfoList">
                            <p>upload your photo here</p>
                        </div>
                        <ul class="newFriends">
                            <li><img src="../skin/images/EmailIcon.gif" alt="EmailIcon" /><a href="#">You have  <span>(3)</span>    new messege</a></li>
                        </ul>
                    </div>
                    <div class="friendInfo">
                        <h2>Friends (92)</h2>
                        <dl>
                            <dt><img src="../skin/images/myFrends01.jpg" alt="img01" /></dt>
                            <dd style="height:37px">Lily Ang Butron</dd>
                            <dd class="friendLink"><a href="#">+ Friend</a></dd>
                        </dl>
                        <dl>
                            <dt><img src="../skin/images/myFrends02.jpg" alt="img01" /></dt>
                            <dd>Lily Ang Butronp
                            	<p class="huise"></p>
                            </dd>
                            <dd class="huise">Suzhou Singapor....</dd>
                        </dl>
                        <dl>
                            <dt><img src="../skin/images/myFrends03.jpg" alt="img01" /></dt>
                            <dd style="height:37px">Lily Ang Butron</dd>
                            <dd class="friendLink"><a href="#">+ Friend</a></dd>
                        </dl>
                        <dl>
                            <dt><img src="../skin/images/myFrends04.jpg" alt="img01" /></dt>
                            <dd style="height:37px">Lily Ang Butron</dd>
                            <dd class="friendLink"><a href="#">+ Friend</a></dd>
                        </dl>
                        <dl>
                            <dt><img src="../skin/images/myFrends05.jpg" alt="img01" /></dt>
                            <dd style="height:37px">Lily Ang Butron</dd>
                            <dd class="friendLink"><a href="#">+ Friend</a></dd>
                        </dl>
                    </div>
               </div>
               
               <div class="imglistMyShare fr">
                <h2>
                    <a href="#" id="imglistMyShareLink"><img src="../skin/images/myshare.jpg" align="myshare" /></a>
                    <a href="#"><img src="../skin/images/myHeatrs.jpg" align="myHeatrs" /></a>
                    <a href="#"><img src="../skin/images/myWish.jpg" align="myWish" /></a>
                    <a href="#"><img src="../skin/images/myfriend.jpg" align="myfriend" /></a>
                </h2>
               	<div class="imglistSharemainList">
                   <dl>
                       <dt class="imglistSharemainImg"><img src="../skin/images/chooseImg01.jpg" alt="chooseImg01" /><span class="rmbShare">￥ 30.00</span></dt>
                       <dd><span class="loveIt">(15) Love it</span><span class="comments">Comments (20)</span></dd>
                       <dd class="imglistSharemainUser"><img src="../skin/images/iconM.jpg" alt="userPic"><span>Shared by </span>HAPPY FU <br />at 13:00 pm 20/03/12</dd>
                       <dd class="imglistSharemainInfo"><strong>Floating Tea Strainer</strong>
                            The Floating Tea Strainer is a strainer for 
                            one cup of tea. Simply put the strainer with 
                            tea leaves into ...
                       </dd>
                   </dl>
                   <dl>
                       <dt class="imglistSharemainImg"><img src="../skin/images/chooseImg02.jpg" alt="chooseImg01" /><span class="rmbShare">￥ 30.00</span></dt>
                       <dd><span class="loveIt">(15) Love it</span><span class="comments">Comments (20)</span></dd>
                       <dd class="imglistSharemainUser"><img src="../skin/images/iconM.jpg" alt="userPic"><span>Shared by </span>HAPPY FU <br />at 13:00 pm 20/03/12</dd>
                       <dd class="imglistSharemainInfo"><strong>Floating Tea Strainer</strong>
                            The Floating Tea Strainer is a strainer for 
                            one cup of tea. Simply put the strainer with 
                            tea leaves into ...
                       </dd>
                   </dl>
                </div>
                <div class="imglistSharemainList">
                   <dl>
                       <dt class="imglistSharemainImg"><img src="../skin/images/chooseImg03.jpg" alt="chooseImg01" /><span class="rmbShare">￥ 30.00</span></dt>
                       <dd><span class="loveIt">(15) Love it</span><span class="comments">Comments (20)</span></dd>
                       <dd class="imglistSharemainUser"><img src="../skin/images/iconM.jpg" alt="userPic"><span>Shared by </span>HAPPY FU <br />at 13:00 pm 20/03/12</dd>
                       <dd class="imglistSharemainInfo"><strong>Floating Tea Strainer</strong>
                            The Floating Tea Strainer is a strainer for 
                            one cup of tea. Simply put the strainer with 
                            tea leaves into ...
                       </dd>
                   </dl>
                   <dl>
                       <dt class="imglistSharemainImg"><img src="../skin/images/chooseImg04.jpg" alt="chooseImg01" /><span class="rmbShare">￥ 30.00</span></dt>
                       <dd><span class="loveIt">(15) Love it</span><span class="comments">Comments (20)</span></dd>
                       <dd class="imglistSharemainUser"><img src="../skin/images/iconM.jpg" alt="userPic"><span>Shared by </span>HAPPY FU <br />at 13:00 pm 20/03/12</dd>
                       <dd class="imglistSharemainInfo"><strong>Floating Tea Strainer</strong>
                            The Floating Tea Strainer is a strainer for 
                            one cup of tea. Simply put the strainer with 
                            tea leaves into ...
                       </dd>
                   </dl>
                  </div>
                  <div class="imglistSharemainList">
                  	<dl>
                       <dt class="imglistSharemainImg"><img src="../skin/images/chooseImg05.jpg" alt="chooseImg01" /><span class="rmbShare">￥ 30.00</span></dt>
                       <dd><span class="loveIt">(15) Love it</span><span class="comments">Comments (20)</span></dd>
                       <dd class="imglistSharemainUser"><img src="../skin/images/iconM.jpg" alt="userPic"><span>Shared by </span>HAPPY FU <br />at 13:00 pm 20/03/12</dd>
                       <dd class="imglistSharemainInfo"><strong>Floating Tea Strainer</strong>
                            The Floating Tea Strainer is a strainer for 
                            one cup of tea. Simply put the strainer with 
                            tea leaves into ...
                       </dd>
                   </dl>
                   <dl>
                       <dt class="imglistSharemainImg"><img src="../skin/images/chooseImg06.jpg" alt="chooseImg01" /><span class="rmbShare">￥ 30.00</span></dt>
                       <dd><span class="loveIt">(15) Love it</span><span class="comments">Comments (20)</span></dd>
                       <dd class="imglistSharemainUser"><img src="../skin/images/iconM.jpg" alt="userPic"><span>Shared by </span>HAPPY FU <br />at 13:00 pm 20/03/12</dd>
                       <dd class="imglistSharemainInfo"><strong>Floating Tea Strainer</strong>
                            The Floating Tea Strainer is a strainer for 
                            one cup of tea. Simply put the strainer with 
                            tea leaves into ...
                       </dd>
                   </dl>
                  </div>
                  <ul class="imglistSharemainImgList fr">
                  	<li><a href="#">1</a></li>
                  	<li><a href="#">2</a></li>
                  	<li><a href="#">3</a></li>
                  	<li><a href="#">4</a></li>
                  	<li><a href="#">5</a></li>
                  	<li><a href="#">6</a></li>
                  	<li><a href="#">&lt;</a></li>
                  	<li><a href="#">&gt;</a></li>
                  </ul>
               </div>
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