<?php import('core.util.RunFunc'); ?>
<?php
	$pendingCount = runFunc('getOrderStatusCount',array('pending'));
	$paidCount = runFunc('getOrderStatusCount',array('paid'));
	$purchaseCount = runFunc('getOrderStatusCount',array('purchase'));
	$returnCount = runFunc('getOrderStatusCount',array('return'));
	$itemRequestCount = runFunc('getOrderStatusCount',array('itemRequest'));
	//echo $pendingCount;
?>
<div class="orderStatus">
    <div class="todayDate">TODAY  <span><?php echo date("H:i D,M d Y");?></span></div>
    <div class="orderStatusCount">
        <ul>
            <li>New Pending <span><?php echo $pendingCount;?></span></li>
            <li>New Paid <span><?php echo $paidCount;?></span></li>
            <li>Waiting Purchase <span><?php echo $purchaseCount;?></span></li>
            <li>New Return <span><?php echo $returnCount;?></span></li>
            <li>New Item Request <span><?php echo $itemRequestCount;?></span></li>
        </ul>
    </div>
</div>