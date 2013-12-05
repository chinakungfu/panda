<?php
import('core.util.RunFunc');


runFunc("circlePostBlock",array($this->_tpl_vars["IN"]["id"]));

runFunc("memberMessageBlockMail",array("Circle Post",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_post_show&id='.$this->_tpl_vars["IN"]["id"].'&type=share')));