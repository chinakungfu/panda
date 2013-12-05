<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
$CKEditor->config['toolbar'] = "Full";
?>

  <script>
    (function( $ ) {
        $.widget( "ui.combobox", {
            _create: function() {
                var input,
                    that = this,
                    select = this.element.hide(),
                    selected = select.children( ":selected" ),
                    value = selected.val() ? selected.text() : "",
                    wrapper = this.wrapper = $( "<span>" )
                        .addClass( "ui-combobox" )
                        .insertAfter( select );

                function removeIfInvalid(element) {
                    var value = $( element ).val(),
                        matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
                        valid = false;
                    select.children( "option" ).each(function() {
                        if ( $( this ).text().match( matcher ) ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });
                    if ( !valid ) {
                        // remove invalid value, as it didn't match anything
                        $( element )
                            .val( "无品牌" )
                            .attr( "title", value + " 搜索结果为空！" )
                            .tooltip( "close" );
                        select.val( "" );
                        setTimeout(function() {
                            input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        input.data( "autocomplete" ).term = "";
                        return false;
                    }
                }

                input = $( "<input>" )
                    .appendTo( wrapper )
                    .val( value )
                    .attr( "title", "" )
                    .addClass( "ui-state-default ui-combobox-input" )
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: function( request, response ) {
                            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                            response( select.children( "option" ).map(function() {
                                var text = $( this ).text();
                                if ( this.value && ( !request.term || matcher.test(text) ) )
                                    return {
                                        label: text.replace(
                                            new RegExp(
                                                "(?![^&;]+;)(?!<[^<>]*)(" +
                                                $.ui.autocomplete.escapeRegex(request.term) +
                                                ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                            ), "<strong>$1</strong>" ),
                                        value: text,
                                        option: this
                                    };
                            }) );
                        },
                        select: function( event, ui ) {
                            ui.item.option.selected = true;
                            that._trigger( "selected", event, {
                                item: ui.item.option
                            });
                        },
                        change: function( event, ui ) {
                            if ( !ui.item )
                                return removeIfInvalid( this );
                        }
                    })
                    .addClass( "ui-widget ui-widget-content ui-corner-left" );

                input.data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + item.label + "</a>" )
                        .appendTo( ul );
                };

                $( "<a>" )
                    .attr( "tabIndex", -1 )
                    .attr( "title", "显示所有品牌" )
                    .tooltip()
                    .appendTo( wrapper )
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass( "ui-corner-all" )
                    .addClass( "ui-corner-right ui-combobox-toggle" )
                    .click(function() {
                        // close if already visible
                        if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
                            input.autocomplete( "close" );
                            removeIfInvalid( input );
                            return;
                        }

                        // work around a bug (likely same cause as #5265)
                        $( this ).blur();

                        // pass empty string as value to search for, displaying all results
                        input.autocomplete( "search", "" );
                        input.focus();
                    });

                    input
                        .tooltip({
                            position: {
                                of: this.button
                            },
                            tooltipClass: "ui-state-highlight"
                        });
            },

            destroy: function() {
                this.wrapper.remove();
                this.element.show();
                $.Widget.prototype.destroy.call( this );
            }
        });
    })( jQuery );

    $(function() {
        $( "#brand_id" ).combobox();

    });
    </script>
<style type="text/css">
	 .ui-combobox {
        position: relative;
        display: inline-block;
    }
    .ui-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        /* adjust styles for IE 6/7 */
        *height: 1.7em;
        *top: 0.1em;
    }
    .ui-combobox-input {
        margin: 0;
        padding: 0.3em;
        vertical-align: top;
    }

  	.ui-button {
  		height: 29px;
  	}

  	 /* this original for Autocomplete Combobox */
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; }
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
        /* *** Add this for visible Scrolling ;) */
        .ui-autocomplete {
		max-height: 350px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 100px;
	}

</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){

	$page = 1;
}
if($this->_tpl_vars["IN"]["status"]){
	$status = $this->_tpl_vars["IN"]["status"];
}

$item = runFunc("getAdminGoodsById",array($this->_tpl_vars["IN"]["id"]));

$cats = runFunc("getItemList",array("cms_product_category",1,10000));
$brands = runFunc("getBrandListForSelect");
$tag_cats = runFunc("getItemList",array("cms_product_tag_category",1,10000));
$tags = runFunc("getItemList",array("cms_product_tag",1,10000));
$props = runFunc("getItemList",array("cms_product_prop",1,10000));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑商品
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a target="_blank" href="../publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$this->_tpl_vars["IN"]["id"]."&show_type=collections&from=collections_page"));?>">前台产品链接</a></li>
			<li id="ctrl_3"><a class="save_and_group_buy" href="#">保存并发布到团购</a></li>
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_list&type=products&status='.$status.'&page='.$page));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">

		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="product_save" />
		<input type="hidden" name="id" value="<?php echo $item["goodsid"];?>"/>
		<input type="hidden" id="group_buy" name="group_buy" value="0"/>
		<input type="hidden" id="page" name="page" value="<?php echo $page;?>"/>
			<table class="admin_edit_table">
				<tr>
					<th>商品名称</th>
					<td ><input type="text" name="title" id="title" class="dark_border input_bar_long required" value="<?php echo $item["goodsTitleCN"]?>"/></td>
				</tr>
				<tr>
					<th>商品英文名称</th>
					<td ><input type="text" name="titleEN" id="titleEN" class="dark_border input_bar_long" value="<?php echo $item["goodsTitleEn"]?>"/></td>
				</tr>
				<tr>
					<th>店铺ID</th>
					<td ><input type="text" name="goodsShopId" id="goodsShopId" class="dark_border input_bar_long required" value="<?php echo $item["goodsShopId"]?>"/></td>
				</tr>
				<tr>
					<th>店铺名称</th>
					<td ><input type="text" name="goodsShopName" id="goodsShopName" class="dark_border input_bar_long" value="<?php echo $item["goodsShopName"]?>"/></td>
				</tr>
				<tr>
					<th>店铺链接</th>
					<td ><input type="text" name="goodsShopUrl" id="goodsShopUrl" class="dark_border input_bar_long" value="<?php echo $item["goodsShopUrl"]?>"/></td>
				</tr>
				<tr>
					<th>商品原价(没有商品原价的话，请填0)</th>
					<td><input type="text" name="goodsOriginalPrice" id="goodsOriginalPrice" class="dark_border input_bar_md number" min=0 value="<?php echo $item["goodsOriginalPrice"];?>"/></td>
				</tr>
				<tr>
					<th>商品价格</th>
					<td ><input type="text" name="price" id="price" class="dark_border input_bar_md number" min=0 value="<?php echo $item["goodsUnitPrice"];?>"/></td>
				</tr>
				<tr>
					<th>运费</th>
					<td ><input type="text" name="freight" id="freight" class="dark_border input_bar_md number" min=0 value="<?php echo $item["goodsFreight"]?>"/></td>
				</tr>
				<tr>
					<th>商品URL</th>
					<td >
						<?php
							if($item["goodsURL"]!=""):
						?>
						<?php
							if(trim($item["click_url"])!=""){
								$click_url = $item["click_url"];
							}else{
								$click_url = $item["goodsURL"];
								}
						?>
						<a target="_blank" href="<?php echo $click_url;?>">点击前往</a>
						<?php endif;?>
					</td>
				</tr>
				<tr>
					<th>显示原商品链接</th>
					<td>
						<input <?php if($item["show_link"] == 1){echo 'checked="checked"';}?> id="show_link" type="radio" value="1" name="show_link"/>
						<label for="show_link">是</label>
						&nbsp;&nbsp;
						<input <?php if($item["show_link"] == 0){echo 'checked="checked"';}?> id="show_link_no" type="radio" value="0" name="show_link"/>
						<label for="show_link_no">否</label>
					</td>
				</tr>
				<tr>
					<th>发布</th>
					<td>
						<input <?php if($item["published"] == 1){echo 'checked="checked"';}?> id="publish" type="radio" value="1" name="published"/>
						<label for="publish">发布</label>
						&nbsp;&nbsp;
						<input <?php if($item["published"] == 0){echo 'checked="checked"';}?> id="unpublish" type="radio" value="0" name="published"/>
						<label for="unpublish">不发布</label>
					</td>
				</tr>
				<tr>
					<th>推荐商品</th>
					<td>
						<input <?php if($item["special"] == 1){echo 'checked="checked"';}?> id="special" type="radio" value="1" name="special"/>
						<label for="publish">推荐</label>
						&nbsp;&nbsp;
						<input <?php if($item["special"] == 0){echo 'checked="checked"';}?> id="unspecial" type="radio" value="0" name="special"/>
						<label for="unpublish">不推荐</label>
						&nbsp;&nbsp;
						<input <?php if($item["special"] == 2){echo 'checked="checked"';}?> id="specialindex" type="radio" value="2" name="special"/>
						<label for="publishindex">首页推荐</label>
					</td>
				</tr>
				<tr>
					<th>商品图片</th>
					<td>
						<table>
							<tr>
								<td style="text-align:center;padding-right:20px;">

								<?php if($item["goodsImgURL"]!=""):?>
								<img width="100px" src="<?php echo $item["goodsImgURL"];?>_310x310.jpg" alt="" />
								<br />
								图片1
								<a onClick="javascript: return confirm('确认删除此图片？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=delete_product_img&id='.$item[goodsid].'&img_name=goodsImgURL&type=products'));?>">删除</a>
								<?php else:?>

								图片1
								<?php endif;?>
								</td>
								<td>
									<input type="file" name="img[]"/>
								</td>
							</tr>
							<tr>
								<td style="text-align:center;padding-right:20px;">

								<?php if($item["goodsImgURL1"]!=""):?>
								<img width="100px" src="<?php echo $item["goodsImgURL1"];?>_310x310.jpg" alt="" />
								 <br />
								图片2
								<a onClick="javascript: return confirm('确认删除此图片？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=delete_product_img&id='.$item[goodsid].'&img_name=goodsImgURL1&type=products'));?>">删除</a>
								<?php else:?>
								图片2
								<?php endif;?>
								</td>
								<td><input type="file" name="img[]"/></td>
							</tr>
							<tr>
								<td style="text-align:center;padding-right:20px;">

								<?php if($item["goodsImgURL2"]!=""):?>
								<img width="100px" src="<?php echo $item["goodsImgURL2"];?>_310x310.jpg" alt="" />
								<br />
								图片3
								<a onClick="javascript: return confirm('确认删除此图片？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=delete_product_img&id='.$item[goodsid].'&img_name=goodsImgURL2&type=products'));?>">删除</a>
								<?php else: ?>
								图片3
								<?php endif;?>
								</td>
								<td><input type="file" name="img[]" /></td>
							</tr>
							<tr>
								<td style="text-align:center;padding-right:20px;">

								<?php if($item["goodsImgURL3"]!=""):?>
								<img width="100px" src="<?php echo $item["goodsImgURL3"];?>_310x310.jpg" alt="" />
								<br />
								图片4

								<a onClick="javascript: return confirm('确认删除此图片？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=delete_product_img&id='.$item[goodsid].'&img_name=goodsImgURL3&type=products'));?>">删除</a>
								<?php else:?>
								图片4
								<?php endif;?>
								</td>
								<td><input type="file" name="img[]" /></td>
							</tr>
							<tr>
								<td style="text-align:center;padding-right:20px;">

								 <?php if($item["goodsImgURL4"]!=""):?>
								 <img width="100px" src="<?php echo $item["goodsImgURL4"];?>_310x310.jpg" alt="" />
								 <br />
								 图片5
								 <a onClick="javascript: return confirm('确认删除此图片？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=delete_product_img&id='.$item[goodsid].'&img_name=goodsImgURL4&type=products'));?>">删除</a>
								<?php else:?>
								  图片5
								 <?php endif;?>
								 </td>
								<td><input type="file" name="img[]" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th>商品简介图片</th>
					<td>
						<table>
						<?php for($p=1;$p<=5;$p++):?>
							<tr>
								<td style="text-align:center;padding-right:20px;">
									<?php if($item["other_image_".$p]!=""):?>
								<img width="100px" src="<?php echo $item["other_image_".$p];?>_70x70.jpg" alt="" />
								<br />
								图片<?php echo $p;?>

								<a onClick="javascript: return confirm('确认删除此图片？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=delete_other_img&id='.$item[goodsid].'&img_name=other_image_'.$p));?>">删除</a>
								<?php else:?>
								图片<?php echo $p;?>
								<?php endif;?>
								</td>
								<td>
									<input type="file" name="other_image[]"/> 标题：<input type="text" class="dark_border input_bar_long" name="other_image_title_<?php echo $p?>" value="<?php echo $item["other_image_title_".$p];?>"/>
								</td>
							</tr>
						<?php endfor;?>
						</table>
					</td>
				</tr>
				<tr>
					<th>商品简介</th>
					<td >
						<?php $CKEditor->editor("item_intro",$item["goodsIntro"]);?>
					</td>
				</tr>
				<tr>
					<th>商品描述</th>
					<td >
						<?php $CKEditor->editor("item_description",$item["goodsDesc"]);?>
					</td>
				</tr>
				<tr>
					<th>商品细节</th>
					<td >
						<?php $CKEditor->editor("item_detail",$item["goodsDetail"]);?>
					</td>
				</tr>
				<tr>
					<th>自定义描述</th>
					<td>
						<input type="text" class="dark_border input_bar_long ckeditor" id="item_others_title" name="item_others_title" value="<?php echo $item["goodsOthersTitle"];?>"/> <br /><br />
						<?php $CKEditor->editor("item_others",$item["goodsOthers"]);?>

					</td>
				</tr>
			</table>
			<div class="sep_title">
				品牌分类，规格    +
			</div>
			<table class="admin_edit_table">
				<tr>
					<th>所属分类</th>
					<td>
					<select name="cat_id" id="cat_id">
						<?php foreach ($cats as $cat):?>
						<option <?php if($cat["id"] == $item["cat_id"]){echo "selected=selected";}?> value="<?php echo $cat["id"]?>"><?php echo $cat["title"]?></option>
						<?php endforeach;?>
					</select>
					</td>
				</tr>
				<tr>
					<th>所属品牌</th>
					<td>
					<select name="brand_id" id="brand_id">
						<option value="0">无品牌</option>
						<?php foreach ($brands as $brand):?>
						<option <?php if($brand["id"] == $item["brand_id"]){echo "selected=selected";}?>  value="<?php echo $brand["id"]?>"><?php echo $brand["title"]?></option>
						<?php endforeach;?>
					</select>
					</td>
				</tr>
				<tr>
					<th>标签</th>
					<td>
						<div class="tag_add_box oh">
							<?php $goods_tags =  runFunc("getGoodsTags",array($item["goodsid"]));?>
							<?php foreach ($goods_tags as $goods_tag):?>
							<div id="<?php echo $goods_tag["id"]?>" class="ex_tag_item add_item_sm_box fl">
							<?php echo $goods_tag["title"];?>
							<input type="hidden" value="<?php echo $goods_tag["id"]?>" name="tags[]">
							</div>
							<?php endforeach;?>
						</div>
					</td>
				</tr>
				<tr>
					<th style="vertical-align: top;">选择标签</th>
					<td>
					<select id="tag_cats">
						<option value="0">全部</option>
						<?php foreach ($tag_cats as $tag_cat):?>
						<option value="<?php echo $tag_cat["id"]?>"><?php echo $tag_cat["title"]?></option>
						<?php endforeach;?>
					</select>
					<div class="tag_select_box">
						<?php foreach ($tags as $tag):?>
						<div id="<?php echo $tag["id"]?>" class="tag_item add_item_sm_box fl">
							<?php echo $tag["title"];?>
						</div>
						<?php endforeach;?>
					</div>
					</td>
				</tr>
				<tr>
					<th>自定义标签</th>
					<td><input id="new_tag_title" class="dark_border input_bar_long" style="width: 100px;" name="custom_tags" type="text"> <a class="cp" id="add_tag_ajax">添加</a></td>
				</tr>
				<tr>
					<th  style="padding-top: 7px;">规格</th>
					<td>

						<?php $ex_props = json_decode($item["props"]);//print_r($ex_props);?>
						<?php $tt= 0;
						if($ex_props!="" and count($ex_props)>0 ):
						foreach($ex_props as $ex_prop):
						$tt++;
						foreach($ex_prop as $key=>$prop_val):

						?>
						<div class="add_input">
						名称：<input onblur="getCurrentProp(this)" id="<?php echo $tt;?>" class="prop_titles_input prop_titles_input_<?php echo $tt;?> input_bar_md dark_border" type="text" name="prop_title[]" value="<?php echo $key;?>"/>
						属性：<input onblur="getCurrentProp(this)" id="<?php echo $tt;?>" class="prop_values_input prop_values_input_<?php echo $tt;?> input_bar_long dark_border" type="text" name="prop_value[]" value="<?php echo implode(";", $prop_val);?>"/>
						<a onClick="add_props(this)" class="add_props cp">增加规格</a> <a class="cp" onClick="del_attr(this)">删除</a>
						</div>
						<?php endforeach;?>
						<?php endforeach;
						endif;
						?>
						<div class="add_input">
						名称：<input onblur="getCurrentProp(this)" id="<?php echo $tt+1;?>" class="prop_titles_input prop_titles_input_<?php echo $tt+1;?> input_bar_md dark_border" type="text" name="prop_title[]" />
						属性：<input onblur="getCurrentProp(this)" id="<?php echo $tt+1;?>" class="prop_values_input prop_values_input_<?php echo $tt+1;?> input_bar_long dark_border" type="text" name="prop_value[]"/>
						<a onClick="add_props(this)" class="add_props cp">增加规格</a>
						</div>
						<script type="text/javascript">
							props_num = <?php echo $tt+1;?>
						</script>
					</td>
				</tr>
				<tr>
					<th>选择规格名称</th>
					<td>
						<?php foreach ($props as $prop):?>
								<div id="<?php echo $prop["id"]?>" class="prop_titles add_item_sm_box fl"><?php echo $prop["title"];?></div>
						<?php endforeach;?>
					</td>
				</tr>
				<tr>
					<th>选择规格属性</th>
					<td>
						<div class="props_value_box">


						</div>
					</td>
				</tr>
			</table>
		</form>
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
