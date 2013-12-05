<?php

import('core.util.RunFunc');


runFunc("adminCommentBlock",array($this->_tpl_vars["IN"]["id"]));


header("Location:".runFunc('encrypt_url',array('action=cms&method=style_list_show&id='.$this->_tpl_vars["IN"]["list_id"].'&type=share&good_id='.$this->_tpl_vars["IN"]["good_id"])));
