<?php
import('core.util.RunFunc');


runFunc("circleBlock",array($this->_tpl_vars["IN"]["id"]));

runFunc("memberMessageBlockMail",array("Circle",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_show&id='.$this->_tpl_vars["IN"]["id"].'&type=share')));