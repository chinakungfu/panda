<pp:if expr="$method=='saveInsert'">
	<pp:var name="result" value="@addOperation($IN.para)"/>
	<pp:if expr="$result">
		<script>parent.location.href="index.php[@encrypt_url('action=operation&method=listOperation')]";</script>
	<pp:else/>
		<script>alert('操作标识已存在，请更换后保存！');window.history.back();</script>
	</pp:if>
<pp:elseif expr="$method=='saveEdit'">
	<pp:memfunc funcname="editOperation($operationId,$IN.para)"/>
	<script>parent.location.href="index.php[@encrypt_url('action=operation&method=listOperation')]";</script>
<pp:elseif expr="$method=='delData'">
	<pp:memfunc funcname="delOperation($selectConId)"/>
	<script>parent.location.href="index.php[@encrypt_url('action=operation&method=listOperation')]";</script>
</pp:if>