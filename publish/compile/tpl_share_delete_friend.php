<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());
$friend_id = $this->_tpl_vars["IN"]["friend_id"];

runFunc("deleteFriend",array($this->_tpl_vars["name"],$friend_id));


header("Location: ".runFunc('encrypt_url',array('action=share&method=friends')));

