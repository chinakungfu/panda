<!--<pp:if expr="$saveType=='0'">--><!--添加-->
<!--	<pp:var name="checkResult" value="@checkExistAppTables($para.appId,$para.tableName)"/>
	<pp:if expr="!empty($checkResult)">
		<script>
		alert("该数据表已存在，不能创建，请重新改名创建！");
		//window.location.href='index.php[@encrypt_url($tempUrl)]';
		//window.history.back(-1);
		</script>
	</pp:if>-->
<!--<pp:elseif expr="$saveType=='1'">--><!--修改-->
<!--<pp:var name="result" value="@editAppTable($editDataResult,$IN.para.appId,$IN.para.tableName)"/>-->
<!--</pp:if>-->

<pp:if expr="$saveType=='0'"><!--添加-->
<pp:var name="result" value="@createAppTable($IN.para)"/>
<!--<pp:if expr="$result">
<script>alert("ssss");window.location.href='index.php[@encrypt_url($tempUrl)]';</script>
</pp:if>-->
<pp:elseif expr="$saveType=='1'"><!--修改-->
<pp:var name="result" value="@editAppTable($editDataResult,$IN.para.appId,$IN.para.tableName)"/>
</pp:if>