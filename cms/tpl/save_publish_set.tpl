<pp:memfunc funcname="editPublish($contentId,$nodeId,$appTableName,$IN.para)"/>
<pp:var name="tempUrl" value="'action=' .$frameListAction .'&method=' .$frameListMethod .'&nodeId='.$nodeId"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>