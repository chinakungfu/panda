<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<pp:if expr="$method=='saveregister'">

<pp:memfunc funcname="addStaff($IN.para)"/>

<pp:var name="result" value="<pp:memfunc funcname="checkLogin($IN.para.staffNo,$IN.para.password)"/>"/>
<pp:if expr="$result">
<pp:session funcname="writeSession($IN.para.staffNo})"/>
<pp:memfunc funcname="addMemberOfYollowPages($IN.para.staffNo)"/>
<pp:memfunc funcname="addTempYellowPages($mode,$IN.yp)"/>
<pp:var name="url" value="<pp:memfunc funcname="encodeFrameRightURL('../yellowpages/index.php?action=yellowPages&method=companyInfo&appName=yellowPages')"/>"/>
<script>alert("注册成功，请记住注册资料！");location.href='index.php?action=member&method=main&frameRight=[$url]&Y_code=[*IN.yp.Y_code]'</script>
</pp:if>
<pp:else/>
<pp:memfunc funcname="editStaff($staffId,$IN.para)"/>
<pp:if expr="$IN.type=='1'">
<script>alert("修改成功，请记住新资料！");location.href="index.php[@encrypt_url('action=member&method=login')]"</script>
<pp:else/>
<script>alert("修改成功，请记住新资料！");location.href="index.php[@encrypt_url('action=member&method=detailMember')]"</script>
</pp:if>
</pp:if>
