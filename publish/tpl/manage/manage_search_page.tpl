<!-- $pageInfo -->
<span>共[$page.rowcount]条记录　第[$page.currentPage]/[$page.pagecount]页<span>
<if test="!empty($page.hasprior)">
<a href="[$page.url_prior]" class="next">&lt; 上一页</a>
<else>
<a href="#" class="next" title="已经是第一页了">&lt; 上一页</a>
</if>
<loop name="page.url" var="var" key="key">
	<if test="$page.currentPage != $key">
    <a href="[$var]">[$key]</a>
    <else>
    <strong>[$key]</strong>
    </if>
</loop>
<if test="!empty($page.url_next)">
<a href="[$page.url_next]" class="next">下一页 &gt;</a>
<else>
<a href="#" class="next" title="已经到最后一页了">下一页 &gt;</a>
</if>