<pp:if expr="$type=='group'">
<pp:memfunc funcname="delGroupBindRole($groupNo,'0')"/>
	<pp:if expr="$index!=''">
		<loop name="index"  var="var" key="key">
		<pp:memfunc funcname="staffGroupBindRole($groupNo,$var,'0')"/>
		</loop>
	</pp:if>
	<pp:include file="group/frame_list_group.tpl" type="tpl"/>
<pp:elseif expr="$type=='staff'">
<pp:memfunc funcname="delGroupBindRole($staffNo,'1')"/>
<pp:if expr="$index!=''">
		<loop name="index"  var="var" key="key">
		<pp:memfunc funcname="staffGroupBindRole($staffNo,$var,'1')"/>
		</loop>
	</pp:if>
	<pp:include file="user/frame_list_user.tpl" type="tpl"/>
</pp:if>