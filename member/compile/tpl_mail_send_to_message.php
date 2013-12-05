<?php import('core.util.RunFunc'); ?><html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head >
<link rel="stylesheet" type="text/css" href="skin/cssfiles/shared.css">
<link rel="stylesheet" type="text/css" href="skin/cssfiles/dtree.css">
<script type="text/javascript" src="skin/jsfiles/dtree.js"></script>
<script language="javascript">
      function turnit (dvn){
        if (dvn.style.display=="none") {
          dvn.style.display="";
        }else {
          if (dvn.style.display=="") {
            dvn.style.display="none";
          }
        }
      }
</script>
<title>Ok</title>
</head>
<body basetarget="mainFrame"  BGCOLOR="#DBEDF7" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<script>alert('验证信息已发送你的邮箱中，请查看邮箱，修改你的密码！');location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=login'));?>"</script>
</body>
</html>