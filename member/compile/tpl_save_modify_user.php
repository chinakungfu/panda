<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php if ($this->_tpl_vars["method"]=='saveregister'){?>

<?php runFunc('addStaff',array($this->_tpl_vars["IN"]["para"]))?>

<?php $this->_tpl_vars["result"]=runFunc('checkLogin',array($this->_tpl_vars["IN"]["para"]["staffNo"],$this->_tpl_vars["IN"]["para"]["password"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php runFunc('writeSession',array($this->_tpl_vars["IN"]["para"]["staffNo}"]))?>
<?php runFunc('addMemberOfYollowPages',array($this->_tpl_vars["IN"]["para"]["staffNo"]))?>
<?php runFunc('addTempYellowPages',array($this->_tpl_vars["mode"],$this->_tpl_vars["IN"]["yp"]))?>
<?php $this->_tpl_vars["url"]=runFunc('encodeFrameRightURL',array('../yellowpages/index.php?action=yellowPages&method=companyInfo&appName=yellowPages')); ?>
<script>alert("注册成功，请记住注册资料！");location.href='index.php?action=member&method=main&frameRight=<?php echo $this->_tpl_vars["url"];?>&Y_code=<?php echo $GLOBALS["IN"]["yp"]["Y_code"];?>'</script>
<?php } ?>
<?php }else{ ?>
<?php runFunc('editStaff',array($this->_tpl_vars["staffId"],$this->_tpl_vars["IN"]["para"]))?>
<?php if ($this->_tpl_vars["IN"]["type"]=='1'){?>
<script>alert("修改成功，请记住新资料！");location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=login'));?>"</script>
<?php }else{ ?>
<script>alert("修改成功，请记住新资料！");location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=detailMember'));?>"</script>
<?php } ?>
<?php } ?>
