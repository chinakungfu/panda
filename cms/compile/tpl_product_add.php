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
			添加商品
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save_and_group_buy" href="#">保存并发布到团购</a></li>
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_list&type=products'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
	<form action="index.php" method="post" id="search_goods_url_form">
		<table class="admin_edit_table">
			<tr>
				<th>商品URL</th>
				<td >
					<input type="text" name="search_url" id="search_url" class="dark_border input_bar_long"/>
					<a id="send_search_request" class="cp">抓取</a>
				</td>
			</tr>
		</table>
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="goods_search_url_request" />
	</form>
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="product_save" />
		<input type="hidden" id="group_buy" name="group_buy" value="0"/>
			<table class="admin_edit_table">
				<tr>
					<th>商品名称</th>
					<td ><input type="text" name="title" id="title" class="dark_border input_bar_long required"/></td>
				</tr>
				<tr>
					<th>商品英文名称</th>
					<td ><input type="text" name="titleEN" id="titleEN" class="dark_border input_bar_long required"/></td>
				</tr>
				<tr>
					<th>店铺ID</th>
					<td ><input type="text" name="goodsShopId" id="goodsShopId" class="dark_border input_bar_long required"/></td>
				</tr>
				<tr>
					<th>店铺名称</th>
					<td ><input type="text" name="goodsShopName" id="goodsShopName" class="dark_border input_bar_long"/></td>
				</tr>
				<tr>
					<th>店铺链接</th>
					<td ><input type="text" name="goodsShopUrl" id="goodsShopUrl" class="dark_border input_bar_long"/></td>
				</tr>
				<tr>
					<th>商品原价(没有商品原价的话，请填0)</th>
					<td><input type="text" name="goodsOriginalPrice" id="goodsOriginalPrice" class="dark_border input_bar_md number" min=0 value="0"/></td>
				</tr>
				<tr>
					<th>商品价格</th>
					<td ><input type="text" name="price" id="price" class="dark_border input_bar_md number" min=0 value="0"/></td>
				</tr>
				<tr>
					<th>运费</th>
					<td ><input type="text" name="freight" id="freight" class="dark_border input_bar_md number" min=0 value="0"/></td>
				</tr>
				<tr>
					<th>显示原商品链接</th>
					<td>
						<input id="show_link" type="radio" value="1" name="show_link"/>
						<label for="show_link">是</label>
						&nbsp;&nbsp;
						<input id="show_link_no" type="radio" value="0" name="show_link"/>
						<label for="show_link_no">否</label>
					</td>
				</tr>
				<tr>
					<th>发布</th>
					<td>
						<input checked="checked" id="publish" type="radio" value="1" name="published"/>
						<label for="publish">发布</label>
						&nbsp;&nbsp;
						<input id="unpublish" type="radio" value="0" name="published"/>
						<label for="unpublish">不发布</label>
					</td>
				</tr>
				<tr>
					<th>推荐商品</th>
					<td>
						<input id="special" type="radio" value="1" name="special"/>
						<label for="publish">推荐</label>
						&nbsp;&nbsp;
						<input checked="checked" id="unspecial" type="radio" value="0" name="special"/>
						<label for="unpublish">不推荐</label>
						&nbsp;&nbsp;
						<input id="specialindex" type="radio" value="2" name="special"/>
						<label for="publishindex">首页推荐</label>
					</td>
				</tr>
				<tr>
					<th>商品图片</th>
					<td>
						<table>
							<tr>
								<td>图片1：</td>
								<td><input type="file" name="img[]"/></td>
							</tr>
							<tr>
								<td>图片2：</td>
								<td><input type="file" name="img[]"/></td>
							</tr>
							<tr>
								<td>图片3：</td>
								<td><input type="file" name="img[]" /></td>
							</tr>
							<tr>
								<td>图片4：</td>
								<td><input type="file" name="img[]" /></td>
							</tr>
							<tr>
								<td>图片5：</td>
								<td><input type="file" name="img[]" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th>商品简介图片</th>
					<td>
						<table>
							<tr>
								<td>图片1：</td>
								<td>
									<input type="file" name="other_image[]"/> 标题：<input type="text" class="dark_border input_bar_long" name="other_image_title_1" />
								</td>
							</tr>
							<tr>
								<td>图片2：</td>
								<td><input type="file" name="other_image[]"/> 标题：<input type="text" class="dark_border input_bar_long" name="other_image_title_2" /></td>
							</tr>
							<tr>
								<td>图片3：</td>
								<td><input type="file" name="other_image[]" /> 标题：<input type="text" class="dark_border input_bar_long" name="other_image_title_3" /></td>
							</tr>
							<tr>
								<td>图片4：</td>
								<td><input type="file" name="other_image[]" /> 标题：<input type="text" class="dark_border input_bar_long" name="other_image_title_4" /></td>
							</tr>
							<tr>
								<td>图片5：</td>
								<td><input type="file" name="other_image[]" /> 标题：<input type="text" class="dark_border input_bar_long" name="other_image_title_5" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th>商品简介</th>
					<td >
						<?php $CKEditor->editor("item_intro");?>
					</td>
				</tr>
				<tr>
					<th>商品描述</th>
					<td >
						<?php $CKEditor->editor("item_description");?>
					</td>
				</tr>
				<tr>
					<th>商品细节</th>
					<td >
						<?php $CKEditor->editor("item_detail");?>
					</td>
				</tr>
				<tr>
					<th>自定义描述</th>
					<td>
						<input type="text" class="dark_border input_bar_long ckeditor" id="item_others_title" name="item_others_title"/> <br /><br />
						<?php $CKEditor->editor("item_others");?>

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
						<option value="<?php echo $cat["id"]?>"><?php echo $cat["title"]?></option>
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
						<option value="<?php echo $brand["id"]?>"><?php echo $brand["title"]?></option>
						<?php endforeach;?>
					</select>
					</td>
				</tr>
				<tr>
					<th>标签</th>
					<td>
						<div class="tag_add_box oh">

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
					<th>规格</th>
					<td>
						<div class="add_input">
						名称：<input onblur="getCurrentProp(this)" id="1" class="prop_titles_input prop_titles_input_1 input_bar_md dark_border" type="text" name="prop_title[]" />
						属性：<input onblur="getCurrentProp(this)" id="1" class="prop_values_input prop_values_input_1 input_bar_long dark_border" type="text" name="prop_value[]"/>
						<a onClick="add_props(this)" class="add_props cp">增加规格</a>
						</div>
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