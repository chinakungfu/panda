<?php import('core.util.RunFunc'); 
runFunc('destroySession',array());
runFunc('writeSession',array($this->_tpl_vars["IN"]["userId"]));

header("location:index.php".runFunc('encrypt_url',array('action=account&method=information')));

?>