<?php import('core.util.RunFunc'); ?>
<!--获取用户信息-->
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]!=''){
		$this->_tpl_vars["tmpUser"]=$this->_tpl_vars["name"];
		$user_info = runFunc("getShareMemberInfoAllInOne",array($this->_tpl_vars["tmpUser"]));
		$this->_tpl_vars["itemPara"]["userId"]=$user_info[0]['staffId'];
		$this->_tpl_vars["itemPara"]["userEmail"]=$user_info[0]['email'];
 	}
 ?>
<?php $this->_tpl_vars["itemPara"]["itemURL"] = $this->_tpl_vars["IN"]["itemURL"]; ?>
<?php $this->_tpl_vars["itemPara"]["itemPrice"] = (float)$this->_tpl_vars["IN"]['itemPrice']; ?>
<?php $this->_tpl_vars["itemPara"]["itemQuantity"]=(int)$this->_tpl_vars["IN"]['itemQuantity']; ?>
<?php $this->_tpl_vars["itemPara"]["itemSize"]=$this->_tpl_vars["IN"]['itemSize']; ?>
<?php $this->_tpl_vars["itemPara"]["itemColor"]=$this->_tpl_vars["IN"]['itemColor']; ?>
<?php $this->_tpl_vars["itemPara"]["itemOther"]=$this->_tpl_vars["IN"]['itemOther']; ?>
<?php $this->_tpl_vars["itemPara"]["request"]=$this->_tpl_vars["IN"]['request']; ?>
<?php $this->_tpl_vars["itemPara"]["addTime"]= time(); ?>

<!--添加用户提交数据-->
<?php $this->_tpl_vars["addItemError"] = runFunc('addItemErrorData',array($this->_tpl_vars["itemPara"])); ?>
<?php if($this->_tpl_vars["addItemError"]){
	//echo "添加数据成功!";
	header("Location: ".runFunc('encrypt_url',array('action=shop&method=addItemEroorSucceed')));
}else{?>
	<script>alert("add information failed!");location.href='index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_error'));?>'</script>
<?php
}
?>

