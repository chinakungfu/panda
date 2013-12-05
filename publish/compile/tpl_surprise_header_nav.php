<?php import('core.util.RunFunc');?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<?php $surprise_custom_pages = runFunc("getCustomPageFromAdmin",array(2));?>
<div class="shopping_nav surprise_part">
<a <?php if($this->_tpl_vars["method"]=="listMain"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=share&method=listMain'));?>">Style Lists</a>
|<a <?php if($this->_tpl_vars["method"]=="PollList" or $this->_tpl_vars["method"]=="PollPage"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=share&method=PollList'));?>">Polls</a>
<?php foreach ($surprise_custom_pages as $surprise_custom_page):?>
|<a <?php if($this->_tpl_vars["method"]=="custom_page" and $this->_tpl_vars["IN"]["id"] == $surprise_custom_page["id"]){echo "class='active'";}?> href="index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=custom_page&id='.$surprise_custom_page["id"]));?>"><?php echo $surprise_custom_page["title"];?></a>
<?php endforeach;?>

<!-- |<a href="">Tags</a> -->     
</div>