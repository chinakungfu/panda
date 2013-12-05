<?php import('core.util.RunFunc'); ?>
<?php 
if($this->_tpl_vars["IN"]["go"]=="add"){
$return = runFunc("addMemberLove",array($this->_tpl_vars["IN"]["love_id"],$this->_tpl_vars["IN"]["user_id"],$this->_tpl_vars["IN"]["type"]));
}
elseif($this->_tpl_vars["IN"]["go"]=="remove"){
	
	$return = runFunc("removeMemberLove",array($this->_tpl_vars["IN"]["love_id"],$this->_tpl_vars["IN"]["user_id"],$this->_tpl_vars["IN"]["type"]));
}
echo $return["count"];
?>
