<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>

<div class="cms_main_box">
	<div class="content">
    
    <div  style="min-height:400px;margin-bottom:50px;">
	<?php
		$cartID = $this->_tpl_vars['IN']['cartID'];
		$orderID = $this->_tpl_vars['IN']['orderID'];
		$orderInfo = runFunc('getOrder',array($orderID)); 
		$cartInfo = runFunc('getCartById',array($cartID));
	?>
    <table width="1080px" style="margin:0 auto;line-height:50px;table-layout:fixed;word-wrap:break-word;">
    	<tr>
        	<td align="right" width="30%">OrderNo:</td>
        	<td style="padding-left:20px;" width="50%">
        	
            <?php echo $orderInfo["OrderNo"];?>
            </td>
            <td></td>
        </tr> 
    	<tr>
        	<td align="right" width="30%">ItemNo:</td>
        	<td style="padding-left:20px;" width="50%">
            <?php echo $cartInfo[0]['cartID'];?>
            </td>
            <td></td>
        </tr>            
    	<tr>
        	<td align="right" width="30%">type:</td>
        	<td style="padding-left:20px;" width="50%">
        	<?php if($cartInfo[0]['order_item_status'] == 12 || $cartInfo[0]['order_item_status'] == 13):?>
        	Replacement
        	<?php elseif($cartInfo[0]['order_item_status'] == 14 || $cartInfo[0]['order_item_status'] == 15):?>
			Return
        	<?php endif;?>
            </td>
            <td></td>            
        </tr>
     	<tr>
        	<td align="right" width="30%" valign="top">Instructions:</td>
        	<td valign="top" style="padding-left:20px;" width="50%">
            	<?php echo $cartInfo[0]['returnInstructions'];?>
            </td>
            <td></td>
        </tr>
     	<tr>
        	<td align="right" width="30%">item’s Photo:</td>
        	<td style="padding-left:20px;" width="50%">
				<?php 
					$photos = explode('|',$cartInfo[0]['returnPhoto']);
					for($i=0;$i<count($photos);$i++){
						//echo $photos[$i]."<br>";
						echo '<a target="_blank" href="/publish/'.$photos[$i].'"><img src="/publish/'.$photos[$i].'" style="margin:0 10px 10px 0;	" width="150px" height="150px" /></a>';
					}			
				?>
            </td>
            <td></td>
        </tr>
     	<tr height="50px">
        	<td align="right" width="30%"></td>
        	<td style="padding-left:20px;" width="50%">
            	<?php 
					switch($cartInfo[0]['order_item_status']){
						case "12":
				?>
                		<a class="nan" href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderReturnChange&returnType=replacement&orderID='.$orderID.'&cartID='.$cartID));?>">处理换货<a/>
                <?php			
						break;
						case "14":
				?>
                		<a class="nan" href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderReturnChange&returnType=return&orderID='.$orderID.'&cartID='.$cartID));?>">处理退货<a/>                
                <?php		
						break;
						case "13":
				?>
                		<span>此换货已经处理过了</span>
                <?php		
						break;
						case "15":
				?>		
						<span>此退货已经处理过了</span>
                <?php		
						break;
						
					}
				?>
				&nbsp;&nbsp;
                <a class="nan" href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=order&orderID='.$orderID));?>">返回</a>
            </td>
            <td></td>
        </tr>

     </table>
        </div>
    </div>

</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>