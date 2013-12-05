<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='submit_link'){?>
	<?php $this->_tpl_vars["result"]=runFunc('GetGoodsInfo',array($this->_tpl_vars["IN"]["GoodsURL"])); ?>
	<?php $this->_tpl_vars["backUrl"]='action=website&method=shopindex&grapRst=0'; ?>

	<?php if ($this->_tpl_vars["result"]=='-1'){?>			
		
		<script>alert("Wrong Link");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
	<?php } elseif (!is_array($this->_tpl_vars["result"])){ ?>
		<script>alert("2222");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>		
	<?php }else{ ?>
		<?php if ($this->_tpl_vars["result"]["img"]<0){?>
			<script>alert("Can't get the image!!");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
		<?php }else{ ?>
			<?php $this->_tpl_vars["imgUrl"]=$this->_tpl_vars["result"]["img"]; ?>

			<?php if ($this->_tpl_vars["result"]["title"]<0){?>
				<?php $this->_tpl_vars["titleCN"]='0'; ?>
			<?php }else{ ?>
				<?php $this->_tpl_vars["titleCN"]=$this->_tpl_vars["result"]["title"]; ?>
			<?php } ?>
			<?php if ($this->_tpl_vars["result"]["price"]<0){?>
				<?php $this->_tpl_vars["price"]='0'; ?>
			<?php }else{ ?>
				<?php $this->_tpl_vars["price"]=$this->_tpl_vars["result"]["price"]; ?>
			<?php } ?>
			<?php if ($this->_tpl_vars["result"]["postage"]<0){?>
				<?php $this->_tpl_vars["postage"]='0'; ?>
			<?php }else{ ?>
				<?php $this->_tpl_vars["postage"]=$this->_tpl_vars["result"]["postage"]; ?>
			<?php } ?>	
			<?php $this->_tpl_vars["nodeId"]=runFunc('getGlobalModelVar',array('outsideGoodsNode')); ?>
			<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>

			<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
			<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["node"]["0"]["nodeGuid"]; ?>
			<?php $this->_tpl_vars["para"]["goodsImgURL"]=$this->_tpl_vars["imgUrl"]; ?>
			<?php $this->_tpl_vars["para"]["goodsStatus"]='Open'; ?>
			<?php $this->_tpl_vars["para"]["goodsType"]='outside'; ?>

			<?php $this->_tpl_vars["para"]["goodsUnitPrice"]=$this->_tpl_vars["price"]; ?>
			<?php $this->_tpl_vars["para"]["goodsFreight"]=$this->_tpl_vars["postage"]; ?>
			<?php $this->_tpl_vars["para"]["goodsTitleCn"]=$this->_tpl_vars["titleCN"]; ?>	
			<?php $this->_tpl_vars["para"]["goodsURL"]=$this->_tpl_vars["IN"]["GoodsURL"]; ?>				

			<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
			<?php if ($this->_tpl_vars["name"]){?>
				<?php $this->_tpl_vars["para"]["goodsAddUser"]=$this->_tpl_vars["name"]; ?>
				<?php $this->_tpl_vars["isLogin"]=1; ?>
			<?php }else{ ?>	
				<?php $this->_tpl_vars["isLogin"]=0; ?>
				<?php $this->_tpl_vars["para"]["goodsAddUser"]=runFunc('getSessionID',array()); ?>	
				
			<?php } ?>				
			
			<?php $this->_tpl_vars["addGoodsTable"]=runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["para"])); ?>	
			<?php if ($this->_tpl_vars["addGoodsTable"]){?>
				<?php $this->_tpl_vars["publishGoods"]=runFunc('publish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["addGoodsTable"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"])); ?>	
				<?php if (publishGoods){?>
					<script>
					alert("Succeed to grab the page you want to buy,please  please fill the form bellow!");			
					location.href='index.php<?php echo runFunc('encrypt_url',array('action=shop&method=goodsDetail&goodsID=' . $this->_tpl_vars["addGoodsTable"]));?>'
					</script>
				<?php }else{ ?>
					<script>alert("Failed tp grap the link!!");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
				<?php } ?>
			<?php }else{ ?>
				<script>alert("Failed tp grap the link!!");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
			<?php } ?>

			
			
			
			
			
		<?php } ?>
		
	<?php } ?>
<?php } ?>