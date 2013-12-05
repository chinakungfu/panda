<?php
import('core.util.RunFunc');


runFunc("pollBlock",array($this->_tpl_vars["IN"]["id"]));

runFunc("memberMessageBlockMail",array("Poll",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=poll_show&id='.$this->_tpl_vars["IN"]["id"].'&type=share')));