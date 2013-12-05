<!-- $pageInfo -->

<span>共[$pageInfo.pageInfo.recordCount]条记录　第[$pageInfo.pageInfo.currentPage]/[$pageInfo.pageInfo.pageCount]页<span>
    <if test="!empty($pageInfo.url.prePage)">
        <a href="/[$pageInfo.url.prePage]" class="next">&lt; 上一页</a>
        <else>
        <a href="#" class="next" title="已经是第一页了">&lt; 上一页</a>
        </if>
		<loop name="pageInfo.url.list" var="var" key="key">
			<if test="$pageInfo.pageInfo.currentPage != $key">
            <a href="/[$var]">[$key]</a>
            <else>
            <strong>[$key]</strong>
            </if>
		</loop>
        <if test="!empty($pageInfo.url.nextPage)">
        <a href="/[$pageInfo.url.nextPage]" class="next">下一页 &gt;</a>
        <else>
        <a href="#" class="next" title="已经到最后一页了">下一页 &gt;</a>
        </if>