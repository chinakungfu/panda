<?php import('core.util.RunFunc'); ?>

<?php $shopping_custom_pages = runFunc("getCustomPageFromAdmin",array(1));?>
<!--
<div class="shopping_nav">

<a <?php if($this->_tpl_vars["method"]=="shopindex"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=shopindex'));?>">Quick Order</a>
|<a <?php if($this->_tpl_vars["method"]=="surpriseindex"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surpriseindex'));?>">Hot Items</a>
|<a <?php if($this->_tpl_vars["method"]=="brand_list" or $this->_tpl_vars["method"]=="surprise_brand_item_list"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=surprise&method=brand_list'));?>">Recommend Shops</a>
|<a <?php if($this->_tpl_vars["method"]=="tmall_brand"){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand')); ?>">Brand Street</a>

<?php foreach ($shopping_custom_pages as $shopping_custom_page):?>

|<a <?php if($this->_tpl_vars["method"]=="custom_page" and $this->_tpl_vars["IN"]["id"] == $shopping_custom_page["id"]){echo "class='active'";}?> href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=custom_page&id='.$shopping_custom_page["id"]));?>"><?php echo $shopping_custom_page["title"];?></a>
<?php endforeach;?>


</div>
-->