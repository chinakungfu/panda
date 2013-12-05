<?php import('core.util.RunFunc');?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>

<?php if($this->_tpl_vars["method"]=="groupBuySingleMain" or $this->_tpl_vars["method"]=="groupBuyMain" or $this->_tpl_vars["method"]=="groupBuyShow"){?>
<div class="shopping_nav share_part">
	<a <?php echo "class='active'";?> ></a>
</div>
<?php }elseif($this->_tpl_vars["action"]=='share' and ($this->_tpl_vars["method"]=='listMain' or $this->_tpl_vars["method"]=="PollList"  or $this->_tpl_vars["method"]=="PollPage"  or $this->_tpl_vars["method"]=="add_poll"  or $this->_tpl_vars["method"]=="showList" or $this->_tpl_vars["method"]=="addList") ){ ?>

<div class="shopping_nav collection_part">
<a <?php if($this->_tpl_vars["method"]=="listMain"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=share&method=listMain'));?>">Style Lists</a>
|<a <?php if($this->_tpl_vars["method"]=="PollList" or $this->_tpl_vars["method"]=="PollPage"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=share&method=PollList'));?>">Polls</a>
</div>

<?php } elseif($this->_tpl_vars["action"]=='share' and ($this->_tpl_vars["method"]=='circlesMain' or $this->_tpl_vars["method"]=='circleCreate' or $this->_tpl_vars["method"]=='circlePage' or $this->_tpl_vars["method"]=='circlePostCreate' or $this->_tpl_vars["method"]=='eventCreate' or $this->_tpl_vars["method"]=='circlePostPage' or $this->_tpl_vars["method"]=='eventMain' or $this->_tpl_vars["method"]=='eventShow')) {?>
 
<div class="shopping_nav bazaar_part">
<a <?php if($this->_tpl_vars["method"]=="circlesMain" or $this->_tpl_vars["method"]=="circlePage"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=share&method=circlesMain'));?>">WOW Bazaar</a>
|<a <?php if($this->_tpl_vars["method"]=="eventMain" or $this->_tpl_vars["method"]=="eventShow"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=share&method=eventMain'));?>">Live Events</a>
<?php } ?>
</div>




