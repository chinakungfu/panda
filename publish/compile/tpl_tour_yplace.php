<div id="yplace">
            <div class="content"><strong>当前位置：</strong><a href="/">首页</a> > 
<?php if (!empty($this->_tpl_vars["node"]["nodeName"])){?>
<?php echo $this->_tpl_vars["node"]["nodeName"];?>
<?php } ?>
<?php if (!empty($this->_tpl_vars["listcontent"]["title"])){?>
 > <?php echo $this->_tpl_vars["listcontent"]["title"];?>
<?php } ?>
<?php if (!empty($this->_tpl_vars["title"])){?><?php echo $this->_tpl_vars["listcontent"]["title"];?><?php } ?>
            </div>
        </div>