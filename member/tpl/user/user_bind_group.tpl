<pp:memfunc funcname="delStaffBindGroup($staffNo)"/>
<pp:if expr="$index!=''">
<loop name="index"  var="var" key="key">
<pp:memfunc funcname="staffBindGroup($staffNo,$var)"/>
</loop>
<pp:include file="frame_list_user.tpl" type="tpl"/>
<pp:else/>
<pp:include file="frame_list_user.tpl" type="tpl"/>
</pp:if>