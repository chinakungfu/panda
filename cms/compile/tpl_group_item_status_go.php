<?php
import('core.util.RunFunc');


runFunc("adminGroupItemUpdate",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["IN"]["status"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=groupBuyOrderItem&order_id='.$this->_tpl_vars["IN"]["order_id"])));
