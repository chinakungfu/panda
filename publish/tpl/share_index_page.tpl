<ul class="imglistSharemainImgList fr">
	<loop name="pageInfo.url.list" var="var" key="key">
		<if test="$pageInfo.pageInfo.currentPage != $key">
			<li><a href="/[$var]">[$key]</a></li>
		<else>
			<li><a href="/[$var]">[$key]</a></li>
		</if>
	</loop>
	<li><a href="#">&lt;</a></li>
	<li><a href="#">&gt;</a></li>
</ul>