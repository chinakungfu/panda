<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">
<script language="javascript" type="text/javascript">

top.location.href="[@getGlobalModelVar('Site_Domain')]index.php?LCMSPID=AzJQOlMlUGoGb1Y4WmABfARuVGgGJVc8UCAFbw1yAD5UYVcqB21TbwJgAD0Abg1pBG9TaAIq";";
</script>
<pp:else/>
<pp:session funcname="writeSession($name)"/>
</pp:if>