<?php import('core.util.RunFunc'); ?><div class="ov">
	<ul class="inner_menu ov">		
		<li><a href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>">HOME</a></li>		
		<li>|</li>		
		<li><a href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=shopindex'));?>" class="green_active">SHOPPING</a></li>		
		<li>|</li>		
		<li><a href="#">SHARETALK</a></li>		
		<li>|</li>		
		<li><a href="#">SURPRISE</a></li>	
	</ul>
</div>