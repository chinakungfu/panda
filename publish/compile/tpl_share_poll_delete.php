<?php
import('core.util.RunFunc');

runFunc("deletePoll",array($this->_tpl_vars["IN"]["poll_id"]));
runFunc("removePollItems",array($this->_tpl_vars["IN"]["poll_id"]));


header("Location: ".runFunc('encrypt_url',array('action=share&method=PollList')));