<!--<pp:if expr="$saveType=='0'">--><!--添加-->
<!--	<pp:var name="checkResult" value="@checkAppTableFieldExist($para.appId,$para.tableName)"/>
	<pp:if expr="!empty($checkResult)">
		<pp:if expr="!empty($checkResult)">
		<script>
		alert("该表字段已存在，不能创建，请重新改名创建！");
		alert('[$tempUrl]');
		window.location.href='index.php[@encrypt_url($tempUrl)]';
		</script>
		</pp:if>
	</pp:if>-->
<!--<pp:elseif expr="$saveType=='1'">--><!--修改-->
<!--</pp:if>-->
<pp:if expr="$saveType=='0'"><!--添加-->
<pp:var name="result" value="@addFieldForTable($para.tableId,$para)"/>
<pp:elseif expr="$saveType=='1'"><!--修改-->
<pp:var name="result" value="@editFieldForTable($editDataResult,$IN.para.tableId,$IN.para)"/>
</pp:if>