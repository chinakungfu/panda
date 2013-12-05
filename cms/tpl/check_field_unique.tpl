<cms action="sql" return="list" query="select count(*) count from {$IN.table} where title='{$IN.title}'"/>
<if test="!empty($list.data.0.count) && $list.data.0.count>0">
	<pp:var name="ret.state" value="-1"/>
	<pp:var name="ret.message" value="'标题字段已经存在重复：' . $IN.title"/>
	<pp:var name="json_str" value="json_encode($ret)"/>
	[$json_str]
	<?php exit; ?>
</if>
{"state":1}