<?php

import('core.util.RunFunc');

$id = $this->_tpl_vars["IN"]["id"];

$sql = "delete from cms_share_group_buy where id = '{$id}'";

$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

header("Location: ".runFunc('encrypt_url',array('action=cms&method=memeberGroupBuy&type=share')));