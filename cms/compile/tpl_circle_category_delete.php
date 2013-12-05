<?php
import('core.util.RunFunc');

runFunc("circleCategoryDelete",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_category&type=share')));