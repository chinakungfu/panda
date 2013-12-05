<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML>
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

			<?php if ($this->_tpl_vars["userInfo"]["0"]["groupName"]!='administrator'){?>
				<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login'));?>'</script>	
			<?php } ?>
			
			
			<div class="content">
			<a name="TOP"></a>
			<form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
					<input type="hidden" name="action" value="admin">
					<?php if ($this->_tpl_vars["method"]=='taobaoLink'){?>
						<input type="hidden" name="method" value="addLink">
					<?php } elseif ($this->_tpl_vars["method"]=='editLink'){ ?>
						<input type="hidden" name="method" value="updateLink">
						<input type="hidden" name="linkId" value="<?php echo $this->_tpl_vars["IN"]["linkId"];?>">					
					<?php } ?>		
								
					<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "linkInfo",
	'query' => "SELECT * FROM `cms_publish_link` WHERE linkId='{$this->_tpl_vars["IN"]["linkId"]}' limit 1 ",
 ); 

$this->_tpl_vars['linkInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>

					<ul class="clothesInfo clb">
						
						<li class="mb12">
							<label> linkId</label>
								
							<input  name="para[linkId]" type="text" class="text2" value="<?php echo $this->_tpl_vars["linkInfo"]["data"]["0"]["linkId"];?>"/>	
						</li>
						<li class="mb12">
							<label>linkName</label>							
							<input  name="para[linkName]" type="text" class="text2" value="<?php echo $this->_tpl_vars["linkInfo"]["data"]["0"]["linkName"];?>"/>
						</li>						
						
						
						<li class="mb12">
							<label>linkUrl</label>							
							<input  name="para[linkUrl]" type="text" class="text2" value="<?php echo $this->_tpl_vars["linkInfo"]["data"]["0"]["linkUrl"];?>"/>	
						</li>
						<li class="mb12">
							<label>parentId</label>							
							<input  name="para[parentId]" type="text" class="text2" value="<?php echo $this->_tpl_vars["linkInfo"]["data"]["0"]["parentId"];?>"/>
						</li>
						<li class="mb12">
							<label>linkSequence</label>							
							<input  name="para[linkSequence]" type="text" class="text2" value="<?php echo $this->_tpl_vars["linkInfo"]["data"]["0"]["linkSequence"];?>"/>
						</li>
						<li  class="mb12"><input type="submit" value="SUBMIT"/></li>
						
					</ul>
					

					
					
				</form>
				<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "linkList",
	'query' => "SELECT * FROM cms_publish_link order by linkSequence, linkId desc ",
 ); 

$this->_tpl_vars['linkList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
			<?php if(!empty($this->_tpl_vars["linkList"]["data"])){ 
 foreach ($this->_tpl_vars["linkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
			<ul class="clothesInfo clb">
			<?php if ($this->_tpl_vars["var"]["parentId"]==-1){?>
			<li class="mb12">
			<p><a href="#<?php echo $this->_tpl_vars["var"]["linkId"];?>"><font size="3" color="red"><?php echo $this->_tpl_vars["var"]["linkName"];?></font></a></p>
			</li>
			<?php } ?>
			</ul>
			<?php  }
} ?> 

			
			<?php if(!empty($this->_tpl_vars["linkList"]["data"])){ 
 foreach ($this->_tpl_vars["linkList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				<?php if ($this->_tpl_vars["var"]["parentId"]==-1){?>
					<div class="orderlistPay">		
						
						<table>
							<tr>
								<th width="140px">link Id</th>
								<th width="260px" align="center">link Name</th>
								<th width="180">parent Id</th>
								<th>linkSequence</th> 
								<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
							</tr>
							<tr>
								<a name="<?php echo $this->_tpl_vars["var"]["linkId"];?>"></a>	
								<td  align="center" ><font size="3" color="red"><?php echo $this->_tpl_vars["var"]["linkId"];?></font></td>
								<td ><font size="3" color="red"><?php echo $this->_tpl_vars["var"]["linkName"];?></font><BR><a href="#">BACK TO TOP</a></td>
								<td align="center"><font size="3" color="red"><?php echo $this->_tpl_vars["var"]["parentId"];?></font></td>
								<td align="center"><font size="3" color="red"><?php echo $this->_tpl_vars["var"]["linkSequence"];?></font></td>
								<td align="center"> 
								<a href="index.php<?php echo runFunc('encrypt_url',array('action=admin&method=delLink&linkId=' . $this->_tpl_vars["var"]["linkId"]));?>">Delete</a>
								</td>
								<td align="center">
								<a href="index.php<?php echo runFunc('encrypt_url',array('action=admin&method=editLink&linkId=' . $this->_tpl_vars["var"]["linkId"]));?>">EDIT</a>
								</td>
								<td align="center">
								
								</td>
								
								
							</tr>
							
							<?php if(!empty($this->_tpl_vars["linkList"]["data"])){ 
 foreach ($this->_tpl_vars["linkList"]["data"] as $this->_tpl_vars['key1']=>$this->_tpl_vars['var1']){ ?>
							<?php if ($this->_tpl_vars["var1"]["parentId"]==$this->_tpl_vars["var"]["linkId"]){?>
								<tr>									
									<td  align="center"><font size="2" color="blue"><?php echo $this->_tpl_vars["var1"]["linkId"];?></font></td>
									<td ><font size="2" color="blue"><?php echo $this->_tpl_vars["var1"]["linkName"];?></font><BR><a href="#">BACK TO TOP</a></td>
									<td align="center"><font size="2" color="blue"><?php echo $this->_tpl_vars["var1"]["parentId"];?></font></td>
									<td align="center"><font size="2" color="blue"><?php echo $this->_tpl_vars["var1"]["linkSequence"];?></font></td>
									<td align="center"> 
									<a href="index.php<?php echo runFunc('encrypt_url',array('action=admin&method=delLink&linkId=' . $this->_tpl_vars["var1"]["linkId"]));?>">Delete</a>
									</td>
									<td align="center">
									<a href="index.php<?php echo runFunc('encrypt_url',array('action=admin&method=editLink&linkId=' . $this->_tpl_vars["var1"]["linkId"]));?>">EDIT</a>
									</td>
									
									
								</tr>
								<?php if(!empty($this->_tpl_vars["linkList"]["data"])){ 
 foreach ($this->_tpl_vars["linkList"]["data"] as $this->_tpl_vars['key2']=>$this->_tpl_vars['var2']){ ?>
									<?php if ($this->_tpl_vars["var2"]["parentId"]==$this->_tpl_vars["var1"]["linkId"]){?>

									<tr>									
									<td  align="center"><font face="verdana" color="green"><?php echo $this->_tpl_vars["var2"]["linkId"];?></font></td>
									<td ><font face="verdana" color="green"><?php echo $this->_tpl_vars["var2"]["linkName"];?></font><BR><a href="#">BACK TO TOP</a></td>
									<td align="center"><font face="verdana" color="green"><?php echo $this->_tpl_vars["var2"]["parentId"];?></font></td>
									<td align="center"><font face="verdana" color="green"><?php echo $this->_tpl_vars["var2"]["linkSequence"];?></font></td>
									<td align="center"> 
									<a href="index.php<?php echo runFunc('encrypt_url',array('action=admin&method=delLink&linkId=' . $this->_tpl_vars["var2"]["linkId"]));?>">Delete</a>
									</td>
									<td align="center">
									<a href="index.php<?php echo runFunc('encrypt_url',array('action=admin&method=editLink&linkId=' . $this->_tpl_vars["var2"]["linkId"]));?>">EDIT</a>
									</td>
									
									
								</tr>
									<?php } ?>
								<?php  }
} ?>

							<?php } ?>
								
							<?php  }
} ?>
						</table>

					</div>
				<?php } ?>
			<?php  }
} ?> 
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