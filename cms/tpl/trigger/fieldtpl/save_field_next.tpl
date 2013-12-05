<pp:if expr="$saveType=='0'"><!--添加-->
<pp:var name="result" value="@addFieldForTable($para.tableId,$addDataResult)"/>
<pp:elseif expr="$saveType=='1'"><!--修改-->
<pp:var name="result" value="@editFieldForTable($editDataResult,$IN.para.tableId,$IN.para)"/>
</pp:if>