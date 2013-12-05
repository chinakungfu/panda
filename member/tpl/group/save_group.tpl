<pp:if expr="$method=='saveInsert'">
	<pp:var name="result" value="@addGroup($IN.para)"/>
	<pp:if expr="$result">
		<script>parent.location.href="index.php[@encrypt_url('action=group&method=listGroup')]";</script>
	<pp:else/>
		<script>alert('用户组标识已存在，请更换后保存！');window.history.back();</script>
	</pp:if>
<pp:elseif expr="$method=='saveEdit'">
	<pp:memfunc funcname="editGroup($groupId,$IN.para)"/>
	<script>parent.location.href="index.php[@encrypt_url('action=group&method=listGroup')]";</script>
<pp:elseif expr="$method=='delData'">
	<pp:memfunc funcname="delGroup($selectConId)"/>
	<script>parent.location.href="index.php[@encrypt_url('action=group&method=listGroup')]";</script>
</pp:if>
