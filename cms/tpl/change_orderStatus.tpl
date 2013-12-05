<pp:var name="result" value="@checkNodeFlag($nodeGuid)"/>
<pp:if expr="$result">
<pp:return data="该标识已存在！"/>
<pp:else/>
<pp:return data="该标识可以用！"/>
</pp:if>