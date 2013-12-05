

<span>共<?php echo $this->_tpl_vars["pageInfo"]["pageInfo"]["recordCount"];?>条记录　第<?php echo $this->_tpl_vars["pageInfo"]["pageInfo"]["currentPage"];?>/<?php echo $this->_tpl_vars["pageInfo"]["pageInfo"]["pageCount"];?>页<span>
    <?php if (!empty($this->_tpl_vars["pageInfo"]["url"]["prePage"])){?>
        <a href="/<?php echo $this->_tpl_vars["pageInfo"]["url"]["prePage"];?>" class="next">&lt; 上一页</a>
        <?php }else{ ?>
        <a href="#" class="next" title="已经是第一页了">&lt; 上一页</a>
        <?php } ?>
		<?php if(!empty($this->_tpl_vars["pageInfo"]["url"]["list"])){ 
 foreach ($this->_tpl_vars["pageInfo"]["url"]["list"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
			<?php if ($this->_tpl_vars["pageInfo"]["pageInfo"]["currentPage"] != $this->_tpl_vars["key"]){?>
            <a href="/<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["key"];?></a>
            <?php }else{ ?>
            <strong><?php echo $this->_tpl_vars["key"];?></strong>
            <?php } ?>
		<?php  }
} ?>
        <?php if (!empty($this->_tpl_vars["pageInfo"]["url"]["nextPage"])){?>
        <a href="/<?php echo $this->_tpl_vars["pageInfo"]["url"]["nextPage"];?>" class="next">下一页 &gt;</a>
        <?php }else{ ?>
        <a href="#" class="next" title="已经到最后一页了">下一页 &gt;</a>
        <?php } ?>