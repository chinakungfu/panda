<?php import('core.util.RunFunc');
$signin = runFunc('readSession',array());

?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>

</head>
<body>

<div>ivision_order</div>
</body>
</html>
