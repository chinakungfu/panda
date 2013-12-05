<?php
import('core.util.RunFunc');

$sql = "select * from cms_product_brand_category where id in ({$this->_tpl_vars["IN"]["id"]})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  品牌分类 ".$item["name"],$user_id));
					
			}

runFunc("deleteBrandCategory",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products')));