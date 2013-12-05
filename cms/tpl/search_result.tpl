<pp:if expr="$type=='node'">
<pp:var name="result" value="<pp:memfunc funcname="listNodeByCon($con)"/>"/>
<pp:else/>
<pp:var name="result" value="<pp:memfunc funcname="listPublishNodeByCon($con)"/>"/>
</pp:if>
<pp:if expr="$result">
<pp:return data="$result"/>
<pp:else/>
<pp:return data="$result"/>
</pp:if>