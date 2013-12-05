<?php
import('core.util.RunFunc');


runFunc("memberEventFinal",array($this->_tpl_vars["IN"]["id"]));



header("Location:".runFunc('encrypt_url',array('action=cms&method=member_event_recycle&type=share')));

