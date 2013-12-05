<?php
import('core.util.RunFunc');

runFunc("ignoreMemberHelpMessage",array($this->_tpl_vars["IN"]["id"]));

if($this->_tpl_vars["IN"]["ignored"]==1){

header("Location: ".runFunc('encrypt_url',array('action=cms&method=admin_help_ignored_messages&type=users')));
}else{

header("Location: ".runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users')));
}