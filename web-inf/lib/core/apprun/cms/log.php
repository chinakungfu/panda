<?

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.apprun.cms.spell_class');


function makeBatchDeleteLog($type,$id){

	$user_id = runFunc('readSession',array());
	switch ($type){

		case "brand":

			$sql = "select * from cms_product_brand where id = {$id}";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除品牌 ".$item["title"],$user_id));
					
			}
			break;
		case "brand_batch":

			$sql = "select * from cms_product_brand where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除品牌 ".$item["title"],$user_id));
					
			}
			break;
		case "tag_categoty":
			
			$sql = "select * from cms_product_tag_category where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除商品标签分类 ".$item["title"],$user_id));
					
			}
			
			break;

		case "tag":
			
			$sql = "select * from cms_product_tag where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除商品标签 ".$item["title"],$user_id));
					
			}
			break;

		case "prop":
			$sql = "select * from cms_product_prop where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除商品属性 ".$item["title"],$user_id));
					
			}
			break;

		case "product_category":
			$sql = "select * from cms_product_category where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除商品分类 ".$item["title"],$user_id));
					
			}
			break;

		case "goods":

			$sql = "select * from cms_publish_goods where goodsid in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $good){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除商品 ".$good["goodsTitleCN"],$user_id));
					
			}

			break;

		case "coupons":

			$sql = "select * from cms_member_coupons where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除优惠券 ".$item["code"],$user_id));
					
			}
			break;

		case "users":

			$sql = "select * from cms_member_staff where staffId in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除用户 ".$item["staffNo"],$user_id));
					
			}
			break;
		case "managers":

			$sql = "select * from cms_member_staff where staffId in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除管理员 ".$item["staffNo"],$user_id));
					
			}
			break;

		case "comments":

			$sql = "select * from cms_member_comment where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("加入回收站 评论 ".$item["comment"],$user_id));
					
			}
			break;

		case "comments_final":

			$sql = "select * from cms_member_comment where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除 评论 ".$item["comment"],$user_id));
					
			}
			break;

		case "comments_back_to_list":
			
			$sql = "select * from cms_member_comment where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("撤销删除 评论 ".$item["comment"],$user_id));
					
			}
			break;

		case "circles":
			
			$sql = "select * from cms_share_circle where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("加入回收站  圈子 ".$item["name"],$user_id));
					
			}
			break;

		case "circles_final":
			
			$sql = "select * from cms_share_circle where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  圈子 ".$item["name"],$user_id));
					
			}
			break;

		case "circles_back_to_list":
			$sql = "select * from cms_share_circle where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("撤销删除  圈子 ".$item["name"],$user_id));
					
			}
			break;

		case "circle_post":
			$sql = "select * from cms_share_circle_post where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("加入回收站  圈子Post ".$item["title"],$user_id));
					
			}
			break;

		case "circle_post_back_to_list":
			
			$sql = "select * from cms_share_circle_post where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("撤销删除  圈子Post ".$item["title"],$user_id));
					
			}
			break;

		case "circle_post_final":
			
			$sql = "select * from cms_share_circle_post where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  圈子Post ".$item["title"],$user_id));
					
			}
			break;

		case "circle_category":
			
			$sql = "select * from cms_share_circle_tag where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  圈子分类 ".$item["title"],$user_id));
					
			}
			break;

		case "style_list":
			
			$sql = "select * from cms_share_list where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("加入回收站  Style List ".$item["title"],$user_id));
					
			}
			break;

		case "style_list_back_to_list":
			$sql = "select * from cms_share_list where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("撤销删除  Style List ".$item["title"],$user_id));
					
			}
			break;

		case "style_list_final":
			
			$sql = "select * from cms_share_list where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  Style List ".$item["title"],$user_id));
					
			}
			break;

		case "poll":
			
			$sql = "select * from cms_share_polls where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("加入回收站  投票 ".$item["name"],$user_id));
					
			}
			break;

		case "poll_back_to_list":
			$sql = "select * from cms_share_polls where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("撤销删除  投票 ".$item["name"],$user_id));
					
			}
			break;

		case "poll_final":
			$sql = "select * from cms_share_polls where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  投票 ".$item["name"],$user_id));
					
			}
			break;

		case "member_event":
			$sql = "select * from cms_share_event where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("加入回收站  会员活动 ".$item["name"],$user_id));
					
			}
			break;

		case "member_event_back_to_list":
			
			$sql = "select * from cms_share_event where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("撤销删除 会员 活动 ".$item["name"],$user_id));
					
			}
			break;

		case "member_event_final":
			$sql = "select * from cms_share_event where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  会员活动 ".$item["name"],$user_id));
					
			}
			break;

		case "event":
			$sql = "select * from cms_share_event where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("加入回收站  官方活动 ".$item["name"],$user_id));
					
			}
			break;

		case "event_back_to_list":
			$sql = "select * from cms_share_event where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("撤销删除 官方 活动 ".$item["name"],$user_id));
					
			}
			break;

		case "event_final":
			$sql = "select * from cms_share_event where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  官方活动 ".$item["name"],$user_id));
					
			}
			break;

		case "advertising":
			
			$sql = "select * from cms_advertising where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  广告 ".$item["title"],$user_id));
					
			}
			break;

		case "custom_page":
			
			$sql = "select * from cms_custom_page where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  活动页 ".$item["title"],$user_id));
					
			}
			break;

		case "manager_permission":
			$sql = "select * from cms_manager_permission where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  管理员权限 ".$item["name"],$user_id));
					
			}
			break;
			
		case "brand_category":
			$sql = "select * from cms_product_brand_category where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  品牌分类 ".$item["name"],$user_id));
					
			}
			break;
			
			case "brand_tag":
			$sql = "select * from cms_product_brand_tag where id in ({$id})";
			$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

			foreach($result as $item){

					
				$uid=runFunc('readSession',array());
				runFunc("makeAdminLog",array("删除  品牌标签 ".$item["name"],$user_id));
					
			}
			break;
			

	}

}
