

<pp:appfunc app="yellowpages" file="../member/appfunc/common" return="result" funcname="userIsExists($StaffNo)"/>
<pp:if expr="$result">
<pp:return data="'该用帐户已存在，不可重复使用！'"/>
<pp:else/>
<pp:return data="'该帐户可以用！'"/>
</pp:if>

