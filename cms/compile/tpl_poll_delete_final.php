<?php
import('core.util.RunFunc');


runFunc("pollDeleteFinal",array($this->_tpl_vars["IN"]["id"]));



header("Location:".runFunc('encrypt_url',array('action=cms&method=poll_recycle&type=share')));

