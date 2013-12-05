<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:if expr="$method=='saveAddNode'">
	<pp:var name="result" value="@addNode($IN.para,parentId)"/>
	<!--<pp:memfunc funcname="addNode($IN.para,parentId)"/>-->
	<pp:if expr="$result">
		<pp:var name="tempUrl" value="'action=cms&method=left&type=site'"/>
		<pp:var name="mainTemUrl" value="'action=cms&method=editNode&nodeId='. $result"/>
	<script>parent.frames["mainFrame"].location.href='index.php[@encrypt_url($mainTemUrl)]';
	        parent.frames["leftFrame"].location.href='index.php[@encrypt_url($tempUrl)]#tabs-2';</script>
	<pp:else/>
		<script>alert("该结点标识已存在，请更换才能保存！");window.history.back();</script>
	</pp:if>
<pp:elseif expr="$method=='saveEditNode'">
	<pp:memfunc funcname="editNode($nodeId,$IN.para)"/>
	<script>window.history.back();</script>
<pp:elseif expr="$method=='saveNodeBase'">
	<!--<pp:memfunc funcname="nodeBase($nodeId,$baseNodeId)"/>-->
	<!--<pp:var name="tempUrl" value="'action=cms&method=left&type=site'"/>
	<script>window.close();opener.frames["leftFrame"].location.href='index.php[@encrypt_url($tempUrl)]#tabs-2';</script>-->
	<pp:var name="tempUrl" value="'action=cms&method=addNode&nodeId=' .$nodeId .'&parentId=' .$baseNodeId"/>
	<script>window.close();window.opener.parent.document.getElementById('mainFrame').src='index.php[@encrypt_url($tempUrl)]';</script>
	
<pp:elseif expr="$method=='saveSortNode'">
	<pp:memfunc funcname="sortNode($nodeId,$order)"/>
	<pp:var name="tempUrl" value="'action=cms&method=left&type=site'"/>
	<!--<script>window.close();opener.frames["leftFrame"].location.href='index.php[@encrypt_url($tempUrl)]#tabs-2';</script>-->
	<script>window.close();window.opener.parent.document.getElementById('leftFrame').src='index.php[@encrypt_url($tempUrl)]#tabs-2';</script>
<pp:elseif expr="$method=='saveMoveNode'">
	<pp:memfunc funcname="moveNode($nodeId,$parentId)"/>
	<pp:var name="tempUrl" value="'action=cms&method=left&type=site'"/>
	<!--<script>window.close();window.opener.document.getElementById('leftFrame').src='index.php[@encrypt_url($tempUrl)]#tabs-2';</script>-->
	<script>window.close();window.opener.parent.document.getElementById('leftFrame').src='index.php[@encrypt_url($tempUrl)]#tabs-2';</script>
<pp:elseif expr="$method=='saveSetDefaultNode'">
	<pp:memfunc funcname="isDefaultNode($nodeId,$isDefault)"/>
	<pp:var name="tempUrl" value="'action=cms&method=left&type=site'"/>
	<!--<script>window.close();opener.frames["leftFrame"].location.href='index.php[@encrypt_url($tempUrl)]#tabs-1';</script>-->
	<script>window.close();window.opener.parent.document.getElementById('leftFrame').src='index.php[@encrypt_url($tempUrl)]#tabs-1';</script>
<pp:elseif expr="$method=='delNode'">
	<pp:memfunc funcname="delNode($nodeId)"/>
	<pp:var name="tempUrl" value="'action=cms&method=left'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>	
</pp:if>
