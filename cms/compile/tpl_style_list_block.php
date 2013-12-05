<?php
import('core.util.RunFunc');


runFunc("styleListBlock",array($this->_tpl_vars["IN"]["id"]));

runFunc("memberMessageBlockMail",array("Style List",$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=style_list_show&id='.$this->_tpl_vars["IN"]["id"].'&type=share')));
