<pp:var name="paraArr.backAction" value="$IN.action"/>
<pp:var name="paraArr.backMethod" value="$IN.method"/>
<pp:var name="paraStr" value="serialize($paraArr)"/>
	

<script>location.href='index.php[@encrypt_url('action=website&method=login&loginType=normal&paraStr=' . $paraStr )]'</script>