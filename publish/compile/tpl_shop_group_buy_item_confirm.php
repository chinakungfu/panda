<?php
import('core.util.RunFunc'); 


runFunc("adminGroupItemUpdate",array($this->_tpl_vars["IN"]["cart_id"],4));

header("Location: ".runFunc('encrypt_url',array('action=account&method=group_buy_item&page='.$this->_tpl_vars["IN"]["page"])));