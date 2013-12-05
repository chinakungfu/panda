<pp:memfunc funcname="delRoleBindOperation($roleNo)"/>
<pp:if expr="$operationId!=''">
<loop name="operationId"  var="var" key="key">
<pp:memfunc funcname="roleBindOperation($roleNo,$var)"/>
</loop>
<pp:include file="role/frame_list_role.tpl" type="tpl"/>
<pp:else/>
<pp:include file="role/frame_list_role.tpl" type="tpl"/>
</pp:if>