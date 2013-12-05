
<ul class="pageList fr">
	<li><input type="submit" value="VIEW ALL" class="viewAllBtn fr"/></li>
	<loop name="pageInfo.url.list" var="var" key="key">
		<if test="$pageInfo.pageInfo.currentPage != $key">
			<li><a href="/[$var]" id="pageListLink">[$key]</a></li>
		 <else>
			<li><span>[$key]</span></li>
		</if>
	</loop>
	
	

</ul>