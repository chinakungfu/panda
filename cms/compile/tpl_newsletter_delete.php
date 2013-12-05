<?php
import('core.util.RunFunc');

runFunc("newsletterDelete",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=newsletter_list&type=media')));