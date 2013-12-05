<div class="index_fee">
    <?php
    import('core.apprun.cmsware.CmswareNode');
    import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
    $params = array (
    'action' => "sql",
    'return' => "recommendedGoodsList",
    'query' => "SELECT * FROM cms_publish_goods WHERE special = '2' and goodsStatus = 'Open' and goodsType = 'inside' and published = '1' Order By created DESC limit 6",
    );

    $this->_tpl_vars['recommendedGoodsList'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
    //print_r($this->_tpl_vars['recommendedGoodsList']);
    
    ?>
    <div class="recommendedCon">
        <?php foreach($this->_tpl_vars['recommendedGoodsList']['data'] as $k => $v):?>
            <div class="recomItem<?php if(fmod($k+1,3)){echo ' recomItemStyle';}?>">
                <div class="recomItemTop"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$v['goodsid']));?>"><img src="<?php echo $v['goodsImgURL'];?>_310x310.jpg" style="max-width:310px;" height="310px" /></a></div>
                <div class="recomItemBottom indexItemHover">
                	<?php $goodsTitle = $v['goodsTitleEn']?$v['goodsTitleEn']:$v['goodsTitleCN'];?>
                    <div class="itemTitle">
                        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$v['goodsid']));?>"><?php echo runFunc('g_substr',array($goodsTitle,100));?>
                        </a>
                    </div>
                </div>
            
            </div>
        
        <?php endforeach;?>
        <div class="clb"></div>
    </div>

</div>
<script language="javascript">
$(function(){
	$(".index_fee .recomItem").hover(
		function(){
			$(this).children(".recomItemBottom").css("background-color","#c9dea2");
			$(this).children(".recomItemBottom").find("a").css("color","#000");
		},
		function(){
			$(this).children(".recomItemBottom").css("background-color","#181009");
			$(this).children(".recomItemBottom").find("a").css("color","#fff");
		}
	);
/*	$(".indexItemHover").hover(
		function(){
			$(this).css("background-color","#c9dea2");
			$(this).find("a").css("color","#000");
		},
		function(){
			$(this).css("background-color","#181009");
			$(this).find("a").css("color","#fff");
		}
	);*/
})
</script>