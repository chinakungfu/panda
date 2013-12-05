
                <ul>
                    
                    <?php if (!empty($this->_tpl_vars["listContentPage"]["url"]["prePage"])){?>
                    <li><a href="/<?php echo $this->_tpl_vars["listContentPage"]["pageInfo"]["prePage"];?>" class="next">&lt; 上一页</a></li>
                    <?php }else{ ?>
                    <li><a href="#" class="next" title="已经是第一页了">&lt; 上一页</a></li>
                    <?php } ?>
                    <?php if(!empty($this->_tpl_vars["listContentPage"]["url"]["list"])){ 
 foreach ($this->_tpl_vars["listContentPage"]["url"]["list"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
                        <?php if ($this->_tpl_vars["listContentPage"]["pageInfo"]["currentPage"] != $this->_tpl_vars["key"]){?>
                        <li><a href="/<?php echo $this->_tpl_vars["var"];?>"><?php echo $this->_tpl_vars["key"];?></a></li>
                        <?php }else{ ?>
                        <li><span><?php echo $this->_tpl_vars["key"];?></span></li>
                        <?php } ?>
                    <?php  }
} ?>
                    <?php if (!empty($this->_tpl_vars["listContentPage"]["pageInfo"]["nextPage"])){?>
                    <li><a href="/<?php echo $this->_tpl_vars["listContentPage"]["pageInfo"]["nextPage"];?>" class="next">下一页 &gt;</a></li>
                    <?php }else{ ?>
                    <li><a href="#" class="next" title="已经到最后一页了">下一页 &gt;</a></li>
                    <?php } ?>
                </ul>