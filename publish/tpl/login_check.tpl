<pp:appfunc app="publish" file="../publish/appfunc/common" return="result" funcname="loginCheck($StaffNo,$password)"/>
<pp:if expr="$result">
	<pp:if expr="$result.0.groupName=='NoValidation'">
		<pp:return data="'2'"/>
	<pp:else/>
		<pp:return data="$result"/>	
		<pp:session funcname="writeSession($StaffNo)"/>		
	</pp:if>
<pp:else/>
<pp:return data="'0'"/>
</pp:if>