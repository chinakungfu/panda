<div class="mainMyShare fl">
   <div class="contentRLeft">
	<dl class="userInfo">
		<pp:if expr="$userInfo.0.headImageUrl!=''">
	    <dt><img src="../web-inf/lib/coreconfig/[$userInfo.0.headImageUrl]" width="50" height="50" align="logo" id="userHeaderImg"></dt>
	    <pp:else/>
	    <dt><img src="../skin/images/pic.jpg" width="50" height="50" align="logo" id="userHeaderImg"></dt>
	    </pp:if>
	    <dd>Welcome Back</dd>
	    <dd>[$userInfo.0.staffName]</dd>
	    <dd id="userEmail"><!--[$userInfo.0.staffNo]--></dd>
	</dl>
	<div id="userInfoList">
	    <!--<p><a href="javascript:void(0);" onclick="document.formen.style.display=''">upload your photo here</a></p>-->
	    <p><div id="upload" ><span>upload your photo here<span></div><span id="status" ></span></p>
	    <!--<FORM name="formen" ACTION="index.php" METHOD="POST" enctype="multipart/form-data">
	    <input type="hidden" name="action" value="account"/> 
	    <input type="hidden" name="method" value="uploadHeaderImage"/>
	    <input type="file" name="upheaderPath" id="upheaderPath">-->
	    <!--<input name="tmpUpheaderPath" id="tmpUpheaderPath" readonly><br><input type="button" value="Browse" onclick="$('#upheaderPath').click()">-->
	    <!--<input type="hidden" name="para[serverName]" value="member">
	    <input type="button" value="submit" id="button" name="button" onclick="adduserpic();"/>
	    </form>-->

	</div>
	<!--<ul class="newFriends">
	    <li><a href="#">You have  <span>(3)</span>    new messege</a></li>
	    <li><a href="#">You have  <span>(3)</span>   new friends</a></li>
	</ul>
	-->
    </div>
    <cms action="sql" return="friendInfo" query="SELECT b.staffName, b.headImageUrl from cms_publish_friend a, cms_member_staff b where a.userId='{$name}' and a.friendUserId=b.staffId" />
	<pp:var name="favoriteRow" value="count($friendInfo.data)"/>
    <div class="friendInfo">
    
	<h2>Friends ([$favoriteRow])</h2>
	<loop name="friendInfo.data" var="var" key="key"> 
	<dl>
	    <dt>
	    <pp:if expr="$var.headImageUrl">
			<img src="../web-inf/lib/coreconfig/[$var.headImageUrl]"/> 
		<pp:else/>
			<dt><img src="../skin/images/pic.jpg" alt="userInfo""/></dt>
		</pp:if>
	    </dt>
	    <dd>[$var.staffName]</dd>
	</dl>                        
	</loop>
    </div>
</div>
 <div class="imglistMyShare fr">
                <h2>
                    <a href="index.php[@encrypt_url('action=share&method=myShare')]" <pp:if expr="$IN.method=='myShare'"> id="imglistMyShareLink" </pp:if> ><img src="../skin/images/myshare.jpg" align="myshare" /></a>
                    <a href="index.php[@encrypt_url('action=share&method=myShareLove')]"><img src="../skin/images/myHeatrs.jpg" align="myHeatrs" /></a>
                    <a href="index.php[@encrypt_url('action=share&method=myWishList')]" <pp:if expr="$IN.method=='myWishList'"> id="imglistMyShareLink" </pp:if> ><img src="../skin/images/myWish.jpg" align="myWish" /></a>
                    <!--<a href="#"><img src="../skin/images/myfriend.jpg" align="myfriend" /></a>-->
                </h2>