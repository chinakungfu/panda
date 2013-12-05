<style>
body {margin:0px;padding:0px;font-size:12px;color:#313131;font-family: "sim-sun", "Geneva", "Arial", "Helvetica", "sans-serif";}
input {border:1px solid #bbb;height:22px;vertical-align:middle;font-size:12px;}
</style>
<form name="upload_form" action="upload_slide.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="5000000" /> <!--限定文件大小为5M -->
<input name="upload_file" type="file" />
<input type="submit" value="上传图片" style="cursor:pointer" />
</form>