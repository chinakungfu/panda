<pp:if expr="$method=='saveInsert'">
<pp:memfunc funcname="addStaff($IN.para)"/>
<pp:elseif expr="$method=='saveEdit'">
<pp:memfunc funcname="editStaff($staffId,$IN.para)"/>
<pp:elseif expr="$method=='delData'">
<pp:memfunc funcname="delStaff($selectConId)"/>
</pp:if>
<script>parent.location.href="index.php[@encrypt_url('action=staff&method=listUser')]";</script>
