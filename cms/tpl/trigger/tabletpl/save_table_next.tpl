<pp:if expr="$saveType=='0'"><!--添加-->
<pp:var name="result" value="@createAppTable($addDataResult)"/>
<pp:elseif expr="$saveType=='1'"><!--修改-->
<pp:var name="result" value="@editAppTable($editDataResult,$IN.para.appId,$IN.para.tableName)"/>
</pp:if>