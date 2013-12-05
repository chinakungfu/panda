<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用ＣＭＳ</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
</head>

<body>
<div class="main_content">
<form method="post" action="index.php">
<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="saveSortNode">
<input type="hidden" class="edit" name="nodeId" value="[$nodeId]" >
<div class="detailMember_nav">请在下面的输入框中输入排序权值</div> 
<pp:var name="node" value="<pp:memfunc funcname="getNodeInfoById($nodeId,'')"/>"/>      
<div class="detailMember_txt">权重：</div>
<div class="detailMember_info"><input type="text" id="order" name="order" value="[$node.0.isOrder]"></div>
<input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.close();">
</form>     
</div>
<br />
<div style="clear:both"></div>
<div class="copyright"></div>
</div>
</body>
</html>
