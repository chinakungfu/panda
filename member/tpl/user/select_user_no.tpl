<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoById($staffId)"/>"/>
<script >
window.top.opener.document.getElementById('inputMemberId').value = '[$staff.0.staffNo]';
window.top.close();
</script>