<?php
import('core.util.RunFunc');


runFunc("deleteCustomPage",array($this->_tpl_vars["IN"]["id"]));


header("Location:".runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media')));