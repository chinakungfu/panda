<?php
import('core.util.RunFunc');


runFunc("circlePostBackToList",array($this->_tpl_vars["IN"]["id"]));



header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_post_recycle&type=share&circle_id='.$this->_tpl_vars["IN"]["circle_id"])));