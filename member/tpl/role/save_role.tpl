<pp:if expr="$method=='saveInsert'">
	<pp:var name="result" value="@addRole($IN.para)"/>
	<pp:if expr="$result">
		<script>parent.location.href="index.php[@encrypt_url('action=role&method=listRoles')]";</script>
	<pp:else/>
		<script>alert('角色标识已存在，请更换后保存！');window.history.back();</script>
	</pp:if>
<pp:elseif expr="$method=='saveEdit'">
	<pp:memfunc funcname="editRole($roleId,$IN.para)"/>
	<script>parent.location.href="index.php[@encrypt_url('action=role&method=listRoles')]";</script>
<pp:elseif expr="$method=='delData'">
	<pp:memfunc funcname="delRole($selectConId)"/>
	<script>parent.location.href="index.php[@encrypt_url('action=role&method=listRoles')]";</script>
</pp:if>

