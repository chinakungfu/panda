<?php
import('core.util.RunFunc');


runFunc("memberEventBlock",array($this->_tpl_vars["IN"]["id"]));

runFunc("memberMessageBlockMail",array("Event",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=member_event_show&id='.$this->_tpl_vars["IN"]["id"].'&type=share')));