
<ul class="pageList fr">
	<li><input type="submit" value="VIEW ALL" class="viewAllBtn fr"/></li>
	<?php if(!empty($this->_tpl_vars["pageInfo"]["url"]["list"])){ 
 foreach ($this->_tpl_vars["pageInfo"]["url"]["list"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
		<?php if ($this->_tpl_vars["pageInfo"]["pageInfo"]["currentPage"] != $this->_tpl_vars["key"]){?>
			<li><a href="/<?php echo $this->_tpl_vars["var"];?>" id="pageListLink"><?php echo $this->_tpl_vars["key"];?></a></li>
		 <?php }else{ ?>
			<li><span><?php echo $this->_tpl_vars["key"];?></span></li>
		<?php } ?>
	<?php  }
} ?>
	
	

</ul>