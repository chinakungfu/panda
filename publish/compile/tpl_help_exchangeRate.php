<!DOCTYPE HTML>
<html>
	<head>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>

</head>
<body>
<div class="box">	
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
<div class="contentHelp clb">
    <div class="navHelp">
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a> > Other
    </div>    
    <div class="contentHelpContLeft fl">
        <h3>Exchange Rate</h3>
        <div class="conRate">
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th">No.</td>
                    <td class="th">Currency</td>
                    <td class="th">Chinese Yuan Renminbi(CNY)</td>
         		</tr>
            	<tr>
                	<td>1</td>
                    <td>US Dollar(USD)</td>
                    <td>6.05</td>
         		</tr>
            	<tr>
                	<td>2</td>
                    <td>Chinese Yuan Renminbi(CNY)</td>
                    <td>1</td>
         		</tr>
            	<tr>
                	<td>3</td>
                    <td>Singapore dollar(SGD)</td>
                    <td>4.69</td>
         		</tr>
            	<tr>
                	<td>4</td>
                    <td>Euro(EUR)</td>
                    <td>9.1947</td>
         		</tr>
            	<tr>
                	<td>5</td>
                    <td>Canadian Dollar(CAD)</td>
                    <td>6.4575318</td>
         		</tr>
            	<tr>
                	<td>6</td>
                    <td>Russian Ruble(RUS)</td>
                    <td>0.2201</td>
         		</tr>
            	<tr>
                	<td>7</td>
                    <td>Australian Dollar(AUD)</td>
                    <td>6.64088963</td>
         		</tr>
            	<tr>
                	<td>8</td>
                    <td>New Zealand Dollar(NZD)</td>
                    <td>5.2387</td>
         		</tr>  
            	<tr>
                	<td>9</td>
                    <td>British Pound(GBP)</td>
                    <td>10.5336</td>
         		</tr>
            	<tr>
                	<td>10</td>
                    <td>Swiss Franc(CHF)</td>
                    <td>8.1145</td>
         		</tr>
            	<tr>
                	<td>11</td>
                    <td>Japanese Yen(JPY)</td>
                    <td>0.0835</td>
         		</tr>
            	<tr>
                	<td>12</td>
                    <td>Indian Rupee(INR)</td>
                    <td>0.1400</td>
         		</tr>
            	<tr>
                	<td>13</td>
                    <td>Brazilian Real(BRL)</td>
                    <td>3.9969</td>
         		</tr>
            	<tr>
                	<td>14</td>
                    <td>South African Rand(R)</td>
                    <td>0.8863</td>
         		</tr>                                                                                                                                            
            </table>
        </div>
  		<div class="conListBottom"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a></div>
    </div>
    

			<?php
$inc_tpl_file=includeFunc(<<<LNMV
help/main/right.tpl
LNMV
);
//include($inc_tpl_file);
?>    
    
</div>
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

		</div>
	</body>
</html>