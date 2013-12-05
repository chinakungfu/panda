<pp:if expr="$method=='beginInsert'">
<pp:var name="result" value="<pp:memfunc funcname="RoleIsExists($roleNo)"/>"/>
<pp:if expr="$result">
<pp:return data="'角色编号异常，该编号已经存在，请输入其他编号！'" />
<pp:else/>
<pp:return data="''"/>
</pp:if>
<pp:else/>
<pp:var name="result" value="<pp:memfunc funcname="RoleIsExists($roleNo)"/>"/>
<pp:if expr="$result">
<pp:return data="'角色编号异常，该编号已经存在，请输入其他编号！'" />
<pp:else/>
<pp:return data="''"/>
</pp:if>
</pp:if>
