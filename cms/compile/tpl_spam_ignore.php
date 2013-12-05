<?php
import('core.util.RunFunc');


runFunc("adminUpdateSpamStatus",array(2,$this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=spam_show&id='.$this->_tpl_vars["IN"]["id"].'&type=share')));