<pp:var name="name" value="@StaffIsExists($staffNo)"/>
<pp:if expr="!empty($name)">
	<pp:return data="$staffNo"/>
<pp:else/>
	<pp:return data="''"/>
</pp:if>