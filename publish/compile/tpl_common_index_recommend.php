<div class="index_recommended">
	<?php $items = runFunc("getIndexBrandByRecommended",array('all',6));?>
    <div class="recommendedCon">
        <div class="recomTitle">Recommended Sellers</div>
        <?php foreach($items as $k => $item):?>
        <?php $logo = "../cms/brand_logo/brand_".$item["id"].".".$item["file_type"];?>
            <div class="recomItem<?php if(fmod($k+1,3)){echo ' recomItemStyle';}?>">
 				<?php  $items_count = runFunc("getGoodsByBrand",array(1,5,true,$item["id"]));?>
					
				<?php if($items_count[0]["count"]>0){
						$link = "/publish/index.php".runFunc('encrypt_url',array('action=surprise&method=surprise_brand_item_list&brand_id='.$item["id"]));
					}else{
						$link = $item["link"];
					}
				?>           
               <div class="recomItemTop"><a target="_blank" href="<?php echo $link;?>"><img src="<?php echo $logo;?>" width="288px" height="116px" /></a>
                </div>
                <div class="recomItemBottom">
                    <div class="itemTitle">
	                    <div class="brandTitle"><?php echo $item['title'];?></div>
                        <div class="brandOwner"><?php echo $item['owner'];?></div>
                    </div>
                </div>
            </div>        
        <?php endforeach;?>
        <div class="clb"></div>
    </div>

</div>