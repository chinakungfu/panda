<ul class="imglistSharemainImgList fr">
	<?php if(!empty($this->_tpl_vars["pageInfo"]["url"]["list"])){ 
 foreach ($this->_tpl_vars["pageInfo"]["url"]["list"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
		<?php if ($this->_tpl_vars["pageInfo"]["pageInfo"]["currentPage"] != $this->_tpl_vars["key"]){?>
			<li><a href="/<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["key"];?></a></li>
		<?php }else{ ?>
			<li><a href="/<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["key"];?></a></li>
		<?php } ?>
	<?php  }
} ?>
	<li><a href="#">&lt;</a></li>
	<li><a href="#">&gt;</a></li>
</ul>