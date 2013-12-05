<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
include_once('./appfunc/taobao_interface.php');

function checkReport($about_id,$user_id,$type){

	$sql = "select count(*) as count from cms_sparm where about_id = '{$about_id}' and user_id = '{$user_id}' and type = '{$type}'";
	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $results;
}

function reportSpam($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_sparm (".$str_field.") values (".$str_value.")";
	$id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function removeUserOverTimeGroupCart($user_id){

	$sql ="select * from cms_publish_cart as c left join cms_share_group_buy as g on c.ItemGoodsID = g.id where c.UserName = '{$user_id}' and c.ItemStatus = 'New' and g.end_time < CURRENT_DATE and cart_type = 2";

	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	foreach($results as $result){

		deleteGroupCart($result["cartID"]);
	}
}

function deleteGroupCart($id){

	$sql = "delete from cms_publish_cart where cartID = '{$id}'";
	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function overTimeGroupBuyCart($cartId){

	$sql ="update cms_publish_cart set group_buy_off = 1 where cartID = '{$cartId}'";

	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function getGroupBuyByCart($cart_str){

	$sql ="select * from cms_publish_cart as c left join cms_share_group_buy as g on c.ItemGoodsID = g.id where c.cartID IN ({$cart_str})";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getNoPayGroupBuyOrders($user_id){

	$sql ="select * from cms_publish_order where group_buy = 1 and orderUser = '{$user_id}' and orderStatus = 4";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function checkItemGroupBuy($id){

	$sql = "select * from cms_share_group_buy where start_time is not null and end_time >= CURRENT_DATE and published = 1 and goods_id = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getMemberWishList($user_id,$page,$size,$count=false){

	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;

	if($count==true){

		$sql ="select count(*) as count from cms_publish_cart where ItemStatus = 'Wish' and UserName = '{$user_id}'";

	}else{

		$sql ="select g.* from cms_publish_cart as c left join cms_publish_goods as g on c.ItemGoodsID = g.goodsid where c.ItemStatus = 'Wish' and c.UserName = '{$user_id}' order by c.cartID DESC limit {$page},{$size}";

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function sendFriendNotice($from,$type,$about_id){

	$friends = getAllFriend($from);
	if(count($friends)>0){
		foreach($friends as $friend){
			if($friend["member_one"] == $user_id){

				$friend_id = $friend["member_two"];
			}else{

				$friend_id = $friend["member_one"];
			}



			runFunc("sendSiteMessage",array($friend_id,$from,$type,$about_id));
		}
	}

}

function removePollVote($item_id){


	$sql = "delete from cms_share_poll_item_vote where item_id = '{$id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getMemberVotedItem($user_id,$page,$size,$count=false){


	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;

	if($count==true){

		$sql ="select count(*) as count from cms_share_poll_item_vote as vote left join cms_share_poll_item as poll_item on vote.item_id = poll_item.id left join cms_publish_goods as goods on poll_item.goods_id = goods.goodsid where vote.user_id = '{$user_id}'";

	}else{

		$sql ="select *,(select count(*) from cms_share_poll_item_vote as v where v.item_id = poll_item.id) as vote_count from cms_share_poll_item_vote as vote left join cms_share_poll_item as poll_item on vote.item_id = poll_item.id left join cms_publish_goods as goods on poll_item.goods_id = goods.goodsid where vote.user_id = '{$user_id}' order by vote.id DESC limit {$page},{$size}";

	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;


}

function getMemberPolls($user_id,$page,$size,$count=false){

	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;


	if($count==true){

		$sql = "select count(*) as count from cms_share_polls  where user_id = '{$user_id}' and status >0 and block = 0";
	}else{

		$sql = "select * from cms_share_polls where  user_id = '{$user_id}' and status >0 and block = 0 order by end_time DESC limit {$page},{$size}";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;


}


function getNextPoll($id){


	$sql = "select * from cms_share_polls where id < {$id} and end_time >= CURRENT_DATE order by created desc limit 0,1";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getVoteHotItem(){

	$sql ="select *,(select count(*) from cms_share_poll_item_vote as v where v.item_id = p.id) as vote_count from cms_share_poll_item as p left join cms_publish_goods as g on p.goods_id = g.goodsid order by vote_count DESC limit 0 ,10";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getItemVoteComment($id){


	$sql = "select v.* from cms_share_poll_item_vote as v left join cms_member_staff as m on v.user_id = m.staffId left join cms_share_poll_item as i on v.item_id = i.id  where i.id = '{$id}' and v.comment is not null and v.block = 0 and m.block = 0";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function checkMemberVoted($poll_id,$user_id){

	$sql = "select count(*) as count from cms_share_poll_item_vote as v left join cms_share_poll_item as i on v.item_id = i.id left join cms_share_polls as p on i.poll_id = p.id where p.id = '{$poll_id}' and v.user_id = '{$user_id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function addCommentToVote($dataArray,$id){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_share_poll_item_vote set $sql where id = {$id}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function getPollItemsVoteCount($id){

	$sql ="select p.*,(select count(*) from cms_share_poll_item_vote as v where v.item_id = p.id) as vote_count,(select count(*) from cms_share_poll_item_vote as v where v.item_id = p.id and v.comment is not null) as comment_count from cms_share_poll_item as p where p.poll_id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getVotePollByVoteId($id){

	$sql ="select vote.*,(select count(*) from cms_share_poll_item_vote as v where v.item_id = p.id) as vote_count,(select count(*) from cms_share_poll_item_vote as v where v.item_id = p.id and v.comment is not null) as comment_count from cms_share_poll_item as p left join cms_share_poll_item_vote as vote on p.id = vote.item_id where vote.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;


}

function getPollItemVoteCount($id){

	$sql ="select p.*,(select count(*) from cms_share_poll_item_vote as v where v.item_id = p.id) as vote_count,(select count(*) from cms_share_poll_item_vote as v where v.item_id = p.id and v.comment is not null) as comment_count from cms_share_poll_item as p where p.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}


function votePollItem($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_poll_item_vote (".$str_field.") values (".$str_value.")";
	$id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $id;

}

function getPollItems($id){

	$sql = "select * from cms_share_poll_item as p left join cms_publish_goods as g on p.goods_id = g.goodsid where p.poll_id = '{$id}'";


	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getPoll($id){

	$sql = "select * from cms_share_polls as p left join cms_member_staff as m on p.user_id = m.staffId where id = '{$id}' and p.status = 1 and p.block = 0 and m.block = 0";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];

}

function getPolls($page,$size,$count=false){

	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;


	if($count==true){

		$sql = "select count(*) as count from cms_share_polls  where end_time >= CURRENT_DATE";
	}else{

		$sql = "select * from cms_share_polls where end_time >= CURRENT_DATE order by created DESC limit {$page},{$size}";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}


function removePollItems($id){

	$sql = "update cms_share_poll_item set poll_id = 0 where poll_id = '{$id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function deletePoll($id){
	$sql = "delete from cms_share_polls where id = '{$id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function updatePoll($dataArray,$id){

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_share_polls set $sql where id = {$id}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function saveMyPoll($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_polls (".$str_field.") values (".$str_value.")";
	$id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $id;
}

function savePollItem($dataArray){

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_poll_item (".$str_field.") values (".$str_value.")";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function getMyGroupBuyItemsByUserId($user_id,$page,$size,$count=false,$friend=false){

	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;

	if($count==true){
		if($friend==true){
			$sql= "select count(*) as count from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.start_time is not null and b.published = 1 and user_id = '{$user_id}'  order by id DESC ";

		}else{

			$sql= "select count(*) as count from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.start_time is not null and b.published = 1 and user_id = '{$user_id}' and b.only_friend_can_see =0 order by id DESC ";
		}
	}else{
		if($friend==true){

			$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as count,b.*,g.goodsid,g.goodsUnitPrice,g.goodsImgURL,g.goodsImgURL1,g.goodsImgURL2,g.goodsImgURL3,g.goodsImgURL4,g.goodsURL,g.goodsDesc,g.goodsOthers,g.goodsOthersTitle,g.props,g.click_url,g.goodsIntro,g.goodsDetail from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.start_time is not null and b.published = 1 and user_id = '{$user_id}' order by id DESC limit {$page},{$size}";
		}else{

			$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as count,b.*,g.goodsid,g.goodsUnitPrice,g.goodsImgURL,g.goodsImgURL1,g.goodsImgURL2,g.goodsImgURL3,g.goodsImgURL4,g.goodsURL,g.goodsDesc,g.goodsOthers,g.goodsOthersTitle,g.props,g.click_url,g.goodsIntro,g.goodsDetail from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.start_time is not null and b.published = 1 and user_id = '{$user_id}' and b.only_friend_can_see =0 order by id DESC limit {$page},{$size}";
		}

	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getGroupBuyJoinedList($user_id,$page,$size,$count=false){

	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and UserName = '{$user_id}'";
	}
	else{
		$sql = "select * from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and UserName = '{$user_id}' order by cartID DESC limit {$page},{$size}";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getGroupBuyJoined($user_id){

	$sql = "select * from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and UserName = '{$user_id}' order by cartID DESC limit 0,5";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getMyGroupBuyItem($user_id,$friend=false){

	if($friend == true){

		$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as count,b.*,g.goodsid,g.goodsUnitPrice,g.goodsImgURL,g.goodsImgURL1,g.goodsImgURL2,g.goodsImgURL3,g.goodsImgURL4,g.goodsURL,g.goodsDesc,g.goodsOthers,g.goodsOthersTitle,g.props,g.click_url,g.goodsIntro,g.goodsDetail from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.start_time is not null and b.published = 1 and user_id = '{$user_id}'  order by id DESC ";
	}else{

		$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as count,b.*,g.goodsid,g.goodsUnitPrice,g.goodsImgURL,g.goodsImgURL1,g.goodsImgURL2,g.goodsImgURL3,g.goodsImgURL4,g.goodsURL,g.goodsDesc,g.goodsOthers,g.goodsOthersTitle,g.props,g.click_url,g.goodsIntro,g.goodsDetail from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.start_time is not null and b.published = 1 and user_id = '{$user_id}' and b.only_friend_can_see = 0 order by id DESC ";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getGroupBuyHotDeals($id){

	$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as count,b.*,g.goodsUnitPrice,g.goodsImgURL,g.goodsid from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.start_time is not null and b.published = 1 and b.id != '{$id}' and b.only_friend_can_see=0 and b.end_time >= CURRENT_DATE order by b.special DESC,count DESC limit 0,5";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getGroupBuyFirstItem(){

	$sql = "select b.*,g.other_image_1,g.other_image_2,g.other_image_3,g.other_image_4,g.other_image_5,g.other_image_title_1,g.other_image_title_2,g.other_image_title_3,g.other_image_title_4,g.other_image_title_5,g.goodsUnitPrice,g.goodsImgURL,g.goodsImgURL1,g.goodsImgURL2,g.goodsImgURL3,g.goodsImgURL4,g.goodsURL,g.goodsDesc,g.goodsOthers,g.goodsOthersTitle,g.props,g.click_url,g.goodsIntro,g.goodsDetail from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.start_time is not null and b.published = 1 and b.end_time >= CURRENT_DATE and b.only_friend_can_see=0 order by b.special DESC,b.id DESC limit 0,1";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getGroupItemNavGroup($id){
	$sql = " select * from cms_share_group_buy where id < {$id} and start_time is not null and published = 1 order by id desc limit 0,1";
	$prev = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$sql = " select * from cms_share_group_buy where id > {$id} and start_time is not null  and published = 1 order by id asc limit 0,1";
	$next = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	$nav = array(
			"prev" => $prev[0]["id"],
			"next" => $next[0]["id"],
	);

	return $nav;
}

function getSiteGroupBuyItem($id){

	$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as count,b.*,g.other_image_1,g.other_image_2,g.other_image_3,g.other_image_4,g.other_image_5,g.other_image_title_1,g.other_image_title_2,g.other_image_title_3,g.other_image_title_4,g.other_image_title_5,g.goodsid,g.goodsUnitPrice,g.goodsImgURL,g.goodsImgURL1,g.goodsImgURL2,g.goodsImgURL3,g.goodsImgURL4,g.goodsURL,g.goodsDesc,g.goodsOthers,g.goodsOthersTitle,g.props,g.click_url,g.goodsIntro,g.goodsDetail from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid where b.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getSiteGroupBuy($page,$size,$count=false,$sort=null){

	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from cms_share_group_buy where start_time is not null and published = 1";
	}
	else{
		$sql = "select (select count(*) from cms_publish_cart where ItemStatus = 'Order' and order_item_status >0 and cart_type=2 and ItemGoodsID = b.id) as buyer_count,b.*,g.goodsUnitPrice,g.goodsImgURL from cms_share_group_buy as b left join cms_publish_goods as g on b.goods_id = g.goodsid ";
		$where_str = " where b.start_time is not null and b.published = 1 and b.only_friend_can_see=0";

		switch ($sort){

			case 1:
				$order = " order by b.start_time DESC,b.special DESC";
				break;

			case 2:
				$order = " order by buyer_count DESC,b.special DESC";
				break;

			case 3:
				$order = " order by b.end_time DESC,b.special DESC";
				break;

			default:
				$order = " order by b.start_time DESC,b.special DESC";

				break;
		}


		$limit = " limit {$page},{$size}";
		$sql .= $where_str.$order.$limit;
	}


	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;


}

function saveGroupBuy($array){

	$dataArray["goods_id"] = $array["goods_id"];
	$dataArray["item_name"] = $array["item_name"];
	$dataArray["user_id"] = $array["user_id"];
	$dataArray["send_mail"] = $array["send_mail"];
	$dataArray["description"] = $array["description"];
	$dataArray["created"] = date("Y-m-d H:i:s");

	if($array["only_friend_can_see"]==""){

		$dataArray["only_friend_can_see"] = 0;
	}else{

		$dataArray["only_friend_can_see"] = $array["only_friend_can_see"];
	}



	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_group_buy (".$str_field.") values (".$str_value.")";
	$event_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function getMyStyleList($user_id){

	$sql = "select * from cms_share_list where user_id = '{$user_id}' order by created DESC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function ignore_all_message($id){

	echo $sql = "update cms_member_message set readed = '1' where message_to = '{$id}'";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function countUnreadMessage($user_id){

	$sql = "select count(*) as count from cms_member_message where readed = 0 and message_to = '{$user_id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function deleteFriend($user_id,$friend_id){

	$sql = "delete from cms_member_friendship where (member_one = '{$user_id}' and member_two = '{$friend_id}') or (member_one = '{$friend_id}' and member_two = '{$user_id}')";

	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getAllFriend($user_id){


	$sql = "select * from cms_member_friendship where member_one = '{$user_id}' or member_two = '{$user_id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function checkFriend($member_one,$member_two){

	$sql = "select count(*) as count from cms_member_friendship where (member_one = '{$member_one}' and member_two = '{$member_two}') or (member_one = '{$member_two}' and member_two = '{$member_one}')";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0]["count"];

}

function confirmAddFriend($member_one,$member_two){

	$dataArray["member_one"] = $member_one;
	$dataArray["member_two"] = $member_two;
	$dataArray["created"] = date("Y-m-d H:i:s");
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_member_friendship (".$str_field.") values (".$str_value.")";
	$event_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function deleteEventTime($id){

	$sql = "delete from cms_share_event_time where event_id = '{$id}'";

	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getEventTime($id){

	$sql = "select * from cms_share_event_time where event_id = '{$id}' order by start_date ASC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function saveEventTime($event_id,$start_date,$end_date,$start_time,$end_time,$week_day){

	$dataArray["start_date"] = $start_date;
	$dataArray["end_date"] = $end_date;
	$dataArray["start_time"] = $start_time;
	$dataArray["end_time"] = $end_time;
	$dataArray["week_day"] = $week_day;
	$dataArray["event_id"] = $event_id;
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_event_time (".$str_field.") values (".$str_value.")";
	$event_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}

function getEventMyJoined($user_id,$page,$size,$count=false){


	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;

	if($count == true){

		$sql = "select count(*) as count from cms_share_event_member as m left join cms_share_event as e on e.id = m.event_id where m.user_id = '{$user_id}' and e.status>0 and e.block = 0";
	}else{

		$sql = "select *,(select count(*) from cms_share_event_member where cms_share_event_member.event_id = e.id) as member_count from cms_share_event_member as m left join cms_share_event as e on e.id = m.event_id where m.user_id = '{$user_id}' and e.status>0 and e.block = 0 order by e.created limit {$page},{$size}";

	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getEventByUserId($user_id,$page,$size,$count=false){

	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;

	if($count == true){

		$sql = "select count(*) as count from cms_share_event where user_id = '{$user_id}' and status >0 and block=0";
	}else{

		$sql = "select * from cms_share_event where user_id = '{$user_id}' and status >0 and block=0 order by created DESC limit {$page},{$size}";
	}

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getEventByCircleId($id,$page,$size,$count=false){

	if($page <=0){

		$page = 1;
	}

	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from cms_share_event where circle_id = '{$id}'";

	}else{

		$sql = "select *,(select count(*) from cms_share_event_member as m where m.event_id = e.id) as member_count from cms_share_event as e where e.status = 1 and e.block = 0 and circle_id = '{$id}' order by e.created limit {$page},{$size}";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}


function eventDelete($id){

	$sql = "delete from cms_share_event where id = {$id}";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	$sql = "delete from cms_share_event_member where event_id = {$id}";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	$sql = "delete from cms_member_love where love_id = {$id} and type = 'EVENT'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	deleteEventTime($id);

}

function eventOpen($id){

	$sql = "update cms_share_event set status = '1' where id = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function eventClose($id){

	$sql = "update cms_share_event set status = '2' where id = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function quitEvent($user_id,$circle_id){

	$sql = "delete from cms_share_event_member where event_id = '{$circle_id}' and user_id = '{$user_id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getEventMember($id,$count=false){

	if($count == true){

		$sql = "select count(*) as count from cms_share_event_member where event_id = '{$id}'";
	}else{
		$sql = "select * from cms_share_event_member as a left join cms_member_staff as b on a.user_id = b.staffId  where a.event_id = '{$id}'";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function bookingEvent($id,$user_id){

	$date = date("Y-m-d H:i:s");
	$sql = "insert into cms_share_event_member (user_id,event_id,book_date) values('{$user_id}','{$id}','{$date}')";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);

}
function userDeleteOrder($orderID){
	$deleteTime = time();
	$sql = "update {$GLOBALS['table']['publish']['order']} set orderStatus = '31',deleteTime = '{$deleteTime}' where orderID = '{$orderID}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}
function checkEventBooking($id,$user_id){

	$sql = "select * from cms_share_event_member where user_id = '{$user_id}' and event_id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getEvent($id){

	$sql = "select a.*,b.headImageUrl from cms_share_event as a left join cms_member_staff as b on a.user_id = b.staffId where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getEvents($page,$size,$status,$special,$count=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count==true){

		$sql = "select count(*) as count from cms_share_event where status = '{$status}' and special = '{$special}' and block = 0";
	}
	else{
		$sql = "select * from cms_share_event where status = '{$status}' and block = 0 and special = '{$special}' order by created DESC limit {$page},{$size}";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getMyWishListCount($id){

	$sql ="SELECT count(*) as count FROM cms_publish_cart where UserName='{$id}' and ItemStatus = 'Wish'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getMyOrdersCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderStatus NOT IN(22,23,31,32) and orderUser = {$id}";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersPendingCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$id}  and orderStatus = 4 and pending = 1";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersUnpaidCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$id} and orderStatus = 4";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersPaidCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$id} and orderStatus IN(5,6,7)";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersOnthewayCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$id} and orderStatus = 10";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersShippedCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$id} and orderStatus = 11";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersReturnedCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderStatus = 19 and orderUser = {$id} and (Returned > 0 or replacement >0)";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersRefoundedCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderStatus NOT IN(22,23,31,32) and orderStatus > 4 and orderUser = {$id} and order_return = 2";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersFinishedCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$id} and orderStatus = 19";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersClosedCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$id} and orderStatus = 21";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
function getMyOrdersCancelCount($id){

	$sql = "select count(*) as count from cms_publish_order where orderUser = {$id} and orderStatus = 30";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}
/*
 * 获取用户账号相关信息总数
 * hutu
 * 2013.01.28
 */
 function getMyInformationCount($id){

	$testOrderSql = "select orderUser from cms_publish_order WHERE orderUser = {$id} AND orderStatus in(5,6,7,8)";
	$testOrderResult = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$testOrderSql);
	$testRechargeSql = "select user_id from cms_publish_recharge_order WHERE user_id = {$id}";
	$testRechargeResult = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$testRechargeSql);
	if($testOrderResult && $testRechargeResult){

		$sql = "select sum(count) from (select orderUser,count(*) as count from cms_publish_order WHERE orderUser = {$id} AND orderStatus in(5,6,7,8) UNION ALL select user_id,count(*) as count from cms_publish_recharge_order WHERE user_id = {$id}) as total";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		$result = $result[0]["sum(count)"];

	}else if($testOrderResult && !$testRechargeResult){

		$sql = "select orderUser,count(*) as count from cms_publish_order WHERE orderUser = {$id} AND orderStatus in(5,6,7,8)";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		$result = $result[0]["count"];

	}else if(!$testOrderResult && $testRechargeResult){

		$sql = "select user_id,count(*) as count from cms_publish_recharge_order WHERE user_id = {$id}";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		$result = $result[0]["count"];
	}else{
		$result = 0;
	}
	return $result;
}
function readMessage($id){

	$sql = "update cms_member_message set readed = '1' where id = {$id}";
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getMemberMessageCount($id){

	$sql = "select count(*) as count from cms_member_message where message_to = '{$id}'";

	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $results;
}


function getMemberMessageByToId($id,$page,$size,$unread = false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$sql = "select * from cms_member_message as a left join cms_member_staff as b on a.message_from = b.staffId";

	$sql .=" where a.message_to = '{$id}'";

	if($unread==true){

		$sql .=" and a.readed = 0";
	}
	$sql .=" order by a.readed ASC,a.created DESC limit {$page},{$size}";

	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	$message_array = array();
	foreach($results as $result){
		$message = array();
		$message["from_name"] = "";
		$message["message_type"] = $result["message_type"];
		$message["message_content"] = $result["content"];
		$message["from"] = $result["message_from"];
		$message["id"] = $result["id"];
		$message["readed"] = $result["readed"];
		$message["from_avatar_ext"] = $result["headImageUrl"];
		$from_member = getShareMemberInfoAllInOne($result["message_from"]);
		if($from_member[0]["real_name"]==1 and ($from_member[0]["first_name"]!="" or $from_member[0]["last_name"] !="")):
		if($from_member[0]["first_name"]!=""){
			$message["from_name"] .= $from_member[0]["first_name"]."&nbsp;";
		} $message["from_name"] .= trim($from_member[0]["last_name"]);
		elseif($from_member[0]["show_nick"]==1):
		$message["from_name"] =  $from_member["0"]["staffName"];
		else:
		$message["from_name"] =  $from_member["0"]["staffNo"];
		endif;
		if($result["message_type"]=="LIST GOODS COMMENT"){
			$list = getListByListItemId($result["about_id"]);

		 if(strlen($list["title"])> 30){
				$title =  mb_substr($list["title"],0,20,'utf-8')."...";
			}else{
				$title = $list["title"];
			}
			$message["link"] = "action=surprise&method=item_show&id=".$result["about_id"]."&show_type=normal&from=style_list";
			$message["content"] = "commented your list:<span style='font-weight bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";
			$message["created"] = $result["created"];

			$message_array[] = $message;
		}

		if($result["message_type"]=="LIST GOODS COMMENT REPLY"){
			$list = getListByListItemId($result["about_id"]);
			if(strlen($list["title"])> 30){
				$title =  mb_substr($list["title"],0,20,'utf-8')."...";
			}else{
				$title = $list["title"];
			}
			$message["link"] = 'action=surprise&method=item_show&id='.$result["about_id"].'&show_type=normal&from=style_list';
			$message["content"] = "replied your comment in list:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="CIRCLE JOIN"){
			$circle = getCircleById($result["about_id"]);

			if(strlen($circle[0]["name"])> 30){
				$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $circle[0]["name"];
			}
			//$message["link"] = 'action=share&method=circlePage&id='.$circle[0]["id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "joined your circle:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="EVENT BOOKING"){
			$event = runFunc("getEvent",array($result["about_id"]));

			if(strlen($event[0]["name"])> 30){
				$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $event[0]["name"];
			}
			$message["link"] = 'action=share&method=eventShow&id='.$event[0]["id"];
			$message["content"] = "booked your event:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="EVENT QUIT"){
			$event = runFunc("getEvent",array($result["about_id"]));

			if(strlen($event[0]["name"])> 30){
				$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $event[0]["name"];
			}
			$message["link"] = 'action=share&method=eventShow&id='.$event[0]["id"];
			$message["content"] = "gived up your event:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="CIRCLE QUIT"){
			$circle = getCircleById($result["about_id"]);
			if(strlen($circle[0]["name"])> 30){
				$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $circle[0]["name"];
			}
			//$message["link"] = 'action=share&method=circlePage&id='.$circle[0]["id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "gived up your circle:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="CIRCLE POST CREATE"){

			$post = getCirclePost($result["about_id"]);
			$circle = getCircleById($post["circle_id"]);
			if(strlen($circle[0]["name"])> 30){
				$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $circle[0]["name"];
			}
			//$message["link"] = 'action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "create new post in your circle:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="CIRCLE POST UPDATE"){
			$post = getCirclePost($result["about_id"]);
			$circle = getCircleById($post["circle_id"]);
			if(strlen($circle[0]["name"])> 30){
				$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $circle[0]["name"];
			}
			//$message["link"] = 'action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "update post in your circle:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="MY CIRCLE POST COMMENT"){
			$post = getCirclePost($result["about_id"]);
			$circle = getCircleById($post["circle_id"]);
			if(strlen($circle[0]["name"])> 30){
				$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $circle[0]["name"];
			}
			//$message["link"] = 'action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "commented post in your circle:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="CIRCLE POST COMMENT"){
			$post = getCirclePost($result["about_id"]);
			$circle = getCircleById($post["circle_id"]);
			if(strlen($circle[0]["name"])> 30){
				$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $circle[0]["name"];
			}
			//$message["link"] = 'action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "commented your post in circle:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="MY EVENT COMMENT"){

			$event = runFunc("getEvent",array($result["about_id"]));

			if(strlen($event[0]["name"])> 30){
				$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $event[0]["name"];
			}
			$message["link"] = 'action=share&method=eventShow&id='.$result["about_id"];
			$message["content"] = "commented your event:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="CIRCLE POST COMMENT REPLY"){
			$post = getCirclePost($result["about_id"]);
			$circle = getCircleById($post["circle_id"]);
			if(strlen($circle[0]["name"])> 30){
				$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $circle[0]["name"];
			}
			//$message["link"] = 'action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "replied your post comment in circle:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="MY EVENT COMMENT REPLY"){

			$event = runFunc("getEvent",array($result["about_id"]));

			if(strlen($event[0]["name"])> 30){
				$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $event[0]["name"];
			}
			$message["link"] = 'action=share&method=eventShow&id='.$result["about_id"];
			$message["content"] = "replied your comment in event :<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}



		if($result["message_type"]=="FRIEND REQUEST"){

			$message["content"] = "want to be your friend";

			$message_array[] = $message;
		}

		if($result["message_type"]=="FRIEND ADDED"){

			$message["content"] = "is your friend now. <a class='read_message'>To your friend's home page »</a>";

			$message["link"] = 'action=share&method=homePage&user_id='.$result["message_from"];

			$message_array[] = $message;
		}

		if($result["message_type"]=="POLL VOTED"){

			$poll = runFunc("getPoll",array($result["about_id"]));

			if(strlen($poll["name"])> 30){
				$title =  mb_substr($poll["name"],0,20,'utf-8')."...";
			}else{
				$title = $poll["name"];
			}
			//$message["link"] = 'action=share&method=PollPage&id='.$result["about_id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "voted your poll:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="STYLE LIST CREATE"){

			$list = getShareListById($result["about_id"]);

			if(strlen($list[0]["title"])> 30){
				$title =  mb_substr($list[0]["title"],0,20,'utf-8')."...";
			}else{
				$title = $list[0]["title"];
			}


			$message["link"] = 'action=share&method=showList&id='.$result["about_id"].'&user_id='.$list[0]["user_id"];
			$message["content"] = "created a new style list:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="POLL CREATE"){


			$poll = runFunc("getPoll",array($result["about_id"]));

			if(strlen($poll["name"])> 30){
				$title =  mb_substr($poll["name"],0,20,'utf-8')."...";
			}else{
				$title = $poll["name"];
			}


			//$message["link"] = 'action=share&method=PollPage&id='.$result["about_id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "created a new poll:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="EVENT CREATE"){


			$event = runFunc("getEvent",array($result["about_id"]));

			if(strlen($event[0]["name"])> 30){
				$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $event[0]["name"];
			}


			$message["link"] = 'action=share&method=eventShow&id='.$result["about_id"];
			$message["content"] = "created a new event:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}

		if($result["message_type"]=="CIRCLE CREATE"){


			$circle = getCircleById($result["about_id"]);

			if(strlen($circle[0]["name"])> 30){
				$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
			}else{
				$title = $circle[0]["name"];
			}


			//$message["link"] = 'action=share&method=circlePage&id='.$result["about_id"];
			$message["link"] = 'action=website&method=index';
			$message["content"] = "created a new circle:<span style='font-weight: bold;color:black;'>".$title."</span> <a class='read_message'>See result »</a>";

			$message_array[] = $message;
		}
	}

	return $message_array;
}

function getListByListItemId($id){

	$sql = "select b.* from cms_share_list_item as a left join cms_share_list as b on a.list_id = b.id where a.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];
}

function getUserIdByListGoods($id){

	$sql = "select b.user_id from cms_share_list_item as a left join cms_share_list as b on a.list_id = b.id where good_id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function sendSiteMessage($to,$from,$type,$about_id,$content=null){
	if($to != $from){
		$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
		switch ($type){



			case "CIRCLE CREATE":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$circle = getCircleById($about_id);

				if(strlen($circle[0]["name"])> 30){
					$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $circle[0]["name"];
				}

				$mailArray["sub"] = " create a new circle:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle[0]["id"]));
				$mailArray["comment_content"] = "";
				runFunc('sendMail',array($mailArray,"comment_notice"));
				break;


			case "EVENT CREATE":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$event = runFunc("getEvent",array($about_id));

				if(strlen($event[0]["name"])> 30){
					$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $event[0]["name"];
				}

				$mailArray["sub"] = " create a new event:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event[0]["id"]));
				$mailArray["comment_content"] = "";
				runFunc('sendMail',array($mailArray,"comment_notice"));
				break;

			case "POLL CREATE":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));

				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$poll = runFunc("getPoll",array($about_id));

				if(strlen($poll["name"])> 30){
					$title =  mb_substr($poll["name"],0,20,'utf-8')."...";
				}else{
					$title = $poll["name"];
				}

				$mailArray["sub"] = " create a new poll: ".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=PollPage&id='.$poll["id"]));
				$mailArray["comment_content"] = "";
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;

			case "STYLE LIST CREATE":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$list = getShareListById($about_id);

				if(strlen($list[0]["title"])> 30){
					$title =  mb_substr($list[0]["title"],0,20,'utf-8')."...";
				}else{
					$title = $list[0]["title"];
				}

				$mailArray["from"] = $e_name;

				$mailArray["sub"] = " create a new style list:".$title;


				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=showList&id='.$about_id.'&user_id='.$list[0]["user_id"]));
				$mailArray["comment_content"] = '';
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;


			case "CIRCLE POST CREATE":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$post = getCirclePost($about_id);
				$circle = getCircleById($post["circle_id"]);

				if(strlen($circle[0]["name"])> 30){
					$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $circle[0]["name"];
				}

				$mailArray["from"] = $e_name;

				$mailArray["sub"] = " create new post in your circle:".$title;


				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$about_id.'&circle_id='.$circle[0]["id"]));
				$mailArray["comment_content"] = '"'.$content.'"';
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;


			case "MY CIRCLE POST COMMENT":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$post = getCirclePost($about_id);
				$circle = getCircleById($post["circle_id"]);

				if(strlen($circle[0]["name"])> 30){
					$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $circle[0]["name"];
				}

				$mailArray["from"] = $e_name;

				$mailArray["sub"] = " make comment on your post in circle:".$title;


				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"]));
				$mailArray["comment_content"] = '"'.$content.'"';
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;

			case "CIRCLE POST COMMENT":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$post = getCirclePost($about_id);
				$circle = getCircleById($post["circle_id"]);

				if(strlen($circle[0]["name"])> 30){
					$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $circle[0]["name"];
				}

				$mailArray["from"] = $e_name;

				$mailArray["sub"] = " make comment on your circle:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"]));
				$mailArray["comment_content"] = '"'.$content.'"';
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;

			case "CIRCLE POST COMMENT REPLY":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$post = getCirclePost($about_id);
				$circle = getCircleById($post["circle_id"]);

				if(strlen($circle[0]["name"])> 30){
					$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $circle[0]["name"];
				}

				$mailArray["from"] = $e_name;

				$mailArray["sub"] = " reply your comment in circle:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"]));
				$mailArray["comment_content"] = '"'.$content.'"';
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;


			case "MY EVENT COMMENT":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$event = runFunc("getEvent",array($about_id));

				if(strlen($event[0]["name"])> 30){
					$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $event[0]["name"];
				}

				$mailArray["sub"] = " post comment on your event:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event[0]["id"]));
				$mailArray["comment_content"] = '"'.$content.'"';
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;

			case "MY EVENT COMMENT REPLY":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$event = runFunc("getEvent",array($about_id));

				if(strlen($event[0]["name"])> 30){
					$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $event[0]["name"];
				}


				$mailArray["sub"] = " reply your comment in event:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event[0]["id"]));
				$mailArray["comment_content"] = '"'.$content.'"';
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;

			case "CIRCLE JOIN":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$circle = getCircleById($about_id);

				if(strlen($circle[0]["name"])> 30){
					$title =  mb_substr($circle[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $circle[0]["name"];
				}

				$mailArray["sub"] = " joined your circle:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle[0]["id"]));
				$mailArray["comment_content"] = "";
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;

			case "EVENT BOOKING":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$event = runFunc("getEvent",array($about_id));

				if(strlen($event[0]["name"])> 30){
					$title =  mb_substr($event[0]["name"],0,20,'utf-8')."...";
				}else{
					$title = $event[0]["name"];
				}

				$mailArray["sub"] = " booked your event:".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event[0]["id"]));
				$mailArray["comment_content"] = "";
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;

			case "POLL VOTED":

				$mailArray['userId'] = $to;

				$user_info = runFunc("getShareMemberInfoAllInOne",array($from));
				if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
				if($user_info[0]["first_name"]!=""){
					$e_name .= $user_info[0]["first_name"]." ";
				} $e_name .= trim($user_info[0]["last_name"]);
				elseif($user_info[0]["show_nick"]==1):
				$e_name .= $user_info["0"]["staffName"];
				else:
				$e_name .= $user_info["0"]["staffNo"];
				endif;

				$mailArray["from"] = $e_name;

				$poll = runFunc("getPoll",array($about_id));

				if(strlen($poll["name"])> 30){
					$title =  mb_substr($poll["name"],0,20,'utf-8')."...";
				}else{
					$title = $poll["name"];
				}

				$mailArray["sub"] = " voted your poll: ".$title;

				$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=PollPage&id='.$poll["id"]));
				$mailArray["comment_content"] = "";
				runFunc('sendMail',array($mailArray,"comment_notice"));

				break;


		}

		$dataArray["message_to"] = $to;
		$dataArray["message_from"] = $from;
		$dataArray["message_type"] = $type;
		$dataArray["about_id"] = $about_id;
		$dataArray["content"] = $content;
		$dataArray["created"] = date("Y-m-d H:i:s");
		foreach ($dataArray as $key => $val)
		{
			$str_field .= $key.",";
			$str_value .= ":".$key.",";
		}
		$str_field = substr($str_field,0,-1);
		$str_value = substr($str_value,0,-1);
		$sql = "insert into cms_member_message (".$str_field.") values (".$str_value.")";
		$message_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

		return $message_id;
	}
}

function deleteAllCircleTag($id){

	$sql = "delete from cms_share_circle_tag_xref where circle_id = '{$id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}


function getCircleTagByCircleId($id){

	$sql = "select * from cms_share_circle_tag_xref as a left join cms_share_circle_tag as b on a.tag_id = b.id where a.circle_id = '{$id}' order by a.id desc";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getCircleMyJoinPost($user_id,$page,$size,$count=FALSE){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count!=false){

		$sql = "select * from cms_share_circle_member as a left join cms_share_circle as b on a.circle_id = b.id join (select * from cms_share_circle_post order by created desc) as c on c.circle_id = b.id where a.user_id = '{$user_id}' and b.status>0 and b.block =0 and c.status>0 and c.block=0 group by b.id";
	}else{

		$sql = "select b.name,c.* from cms_share_circle_member as a left join cms_share_circle as b on a.circle_id = b.id join (select * from cms_share_circle_post order by created desc) as c on c.circle_id = b.id where a.user_id = '{$user_id}' and b.status>0 and b.block =0 and c.status>0 and c.block=0 group by b.id order by c.created DESC limit {$page},{$size}";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getCircleMyJoin($user_id){

	$sql = "select b.* from cms_share_circle_member as a left join cms_share_circle as b on a.circle_id = b.id where a.user_id = '{$user_id}' and b.status>0 and b.block = 0 order by a.join_date DESC";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function deleteCirclePostImg($post_id){

	$sql = "delete from cms_share_circle_post_img where post_id = '{$post_id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function deleteCirclePost($id,$user_id){

	$sql = "delete from cms_share_circle_post where id = '{$id}' and user_id = '{$user_id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function deleteCirclePostComment($id){

	$sql = "delete from cms_member_comment where about_id = '{$id}' and type = 'CIRCLE POST'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getCircleLastActivity($id){

	$sql = "select * from cms_member_comment as a left join cms_share_circle_post as b on a.about_id = b.id left join cms_share_circle as c on c.id = b.circle_id where c.id = '{$id}' and a.type = 'CIRCLE POST' order by a.created DESC limit 0,1";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function quitCircle($user_id,$circle_id){

	$sql = "delete from cms_share_circle_member where circle_id = '{$circle_id}' and user_id = '{$user_id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getCirclePostImg($id){

	$sql = "select * from cms_share_circle_post_img where post_id = '{$id}' order by id asc";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}


function getCirclePost($id){

	$sql = "select * from cms_share_circle_post as a left join cms_member_staff as b on a.user_id = b.staffId where a.id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];

}

function getCircleMember($id,$limit,$count=false){

	if($count == true){

		$sql = "select count(*) as count from cms_share_circle_member as a left join cms_member_staff as b on a.user_id = b.staffId where a.circle_id = '{$id}' and b.staffNo is not null";
	}else{
		$sql = "select * from cms_share_circle_member as a left join cms_member_staff as b on a.user_id = b.staffId  where a.circle_id = '{$id}' limit 0,{$limit}";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getPostImg($post_id,$limit){

	$sql = "select * from cms_share_circle_post_img where post_id = '{$post_id}' order by id ASC limit 0,{$limit}";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function getCirclePostByCircleId($id,$size,$page=1,$count=false){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	if($count!=false){

		$sql = "select count(*) as count from cms_share_circle_post where circle_id = '{$id}' and status>0 and block =0";
	}
	else{
		$sql = "select * from cms_share_circle_post as a left join cms_member_staff as b on a.user_id = b.staffId where a.circle_id = '{$id}' and b.block=0 and a.status=1 and a.block = 0 order by created DESC limit {$page},{$size}";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function checkJoin($circle_id,$user_id){

	$sql = "select * from cms_share_circle_member where user_id = '{$user_id}' and circle_id = '{$circle_id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function joinCircle($circle_id,$user_id){

	$date = date("Y-m-d H:i:s");
	$sql = "insert into cms_share_circle_member (user_id,circle_id,join_date) values('{$user_id}','{$circle_id}','{$date}')";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getCircleById($id){

	$sql = "select * from cms_share_circle where id = '{$id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getCircleByUserId($id){

	$sql = "select * from cms_share_circle where user_id = '{$id}' and status >0 and block = 0";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getCircles($page,$size,$about=null){

	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;

	$sql = "select * from cms_share_circle as c left join cms_member_staff as m on c.user_id = m.staffId where c.status = 1 and c.block = 0 and m.block = 0";

	if($about!=""){

		$sql .=" and about = '{$about}'";
	}

	$sql.=" order by c.official DESC,c.special DESC,c.id DESC limit {$page},{$size}";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;
}

function getCircleTags(){
	$sql = "select * from  cms_share_circle_tag  where published = 1";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function commentDelete($id,$user_id){

	$sql = "delete from cms_member_comment where id = '{$id}' and user_id = '{$user_id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getComment($about_id,$type,$count=false){
	if($count==true){

		$sql = "select count(*) as count from cms_member_comment where about_id = {$about_id} and type = '{$type}' and block=0 and status =1";
	}else{
		$sql = "select a.*,b.staffName,b.headImageUrl from cms_member_comment as a left join cms_member_staff as b on a.user_id = b.staffId where a.about_id = {$about_id} and a.type = '{$type}' and a.block=0 and a.status =1 and b.block = 0 order by created DESC";
	}

	$results = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	if($count==false){
		foreach($results as $key=>$result){

			$e_name = "";
			$user_info = runFunc("getShareMemberInfoAllInOne",array($result["user_id"]));
			if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
			if($user_info[0]["first_name"]!=""){
				$e_name .= $user_info[0]["first_name"]." ";
			} $e_name .= trim($user_info[0]["last_name"]);
			elseif($user_info[0]["show_nick"]==1):
			$e_name .= $user_info["0"]["staffName"];
			else:
			$e_name .= $user_info["0"]["staffNo"];
			endif;

			$results[$key]["staffName"] = $e_name;
		}
	}


	return $results;

}

function getCommentById($id,$type){


	$sql = "select d.real_name,d.first_name,d.last_name,d.show_nick,a.*,b.staffNo,b.staffName,b.headImageUrl from cms_member_comment as a left join cms_member_staff as b on a.user_id = b.staffId left join cms_profile as d on d.user_id = a.user_id where a.id = {$id} and type = '{$type}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function saveComment($user_id,$comment,$about_id,$reply,$type){


	$dataArray["user_id"] = $user_id;
	$dataArray["created"] = date("Y-m-d H:i:s");
	$dataArray["comment"] = $comment;
	$dataArray["about_id"] = $about_id;
	$dataArray["reply_to"] = $reply;
	$dataArray["type"] = $type;

	$str_field = "";
	$str_value = "";
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);

	$sql = "insert into cms_member_comment (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function getMemberListLove($user_id,$type,$page,$size,$count=false){
	if($page <=0){
		$page = 1;
	}
	$page = $page * $size - $size;


	if($count == true){
		$sql = "select count(*) as count from cms_member_love as l left join cms_share_list as p on p.id = l.love_id where l.user_id = '{$user_id}' and l.type = '{$type}' and p.block = 0 and p.status>0";

	}else{
		$sql = "select d.real_name,d.first_name,d.last_name,d.show_nick,c.staffNo,c.staffId as creater_id,c.staffName,b.* from cms_member_love as a left join cms_share_list as b on a.love_id = b.id left join cms_member_staff as c on b.user_id = c.staffId left join cms_profile as d on d.user_id = b.user_id where a.user_id = '{$user_id}' and a.type = '{$type}' and b.block = 0 and b.status >0 order by a.created limit {$page},{$size}";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getShareMemberInfoAllInOne($staffId){

	$sql = "select * from  cms_member_staff as a left join cms_profile as b on a.staffId =b.user_id where a.staffId = {$staffId}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function pageEventNavi($result_count,$rowsPerPage,$action,$method,$user_id,$page=1){


	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}


	if($page_count<2){
		return false;
	}
	$minpage = get_minpage($page,$page_count);
	$maxpage = get_maxpage($page,$page_count);
	$navi = "<div class='main_page_nav'>";
	if($page > 1)$navi.= "<a class='main_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&user_id=".$user_id."&page=".($page-1)))."'></a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&user_id=".$user_id."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='main_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&user_id=".$user_id."&page=".($page+1)))."'></a>";
	$navi .="<a class='page_counter'>".$page_count."</a>";
	$navi .="</div>";

	return $navi;
}


function pageNavi($result_count,$rowsPerPage,$action,$method,$page=1){


	if($result_count%$rowsPerPage!=0){
		$page_count = floor($result_count/$rowsPerPage)+1;
	}else{
		$page_count = $result_count/$rowsPerPage;
	}


	if($page_count<2){
		return false;
	}
	$minpage = get_minpage($page,$page_count);
	$maxpage = get_maxpage($page,$page_count);
	$navi = "<div class='main_page_nav'>";
	if($page > 1)$navi.= "<a class='main_page_nav_prev' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&page=".($page-1)))."'></a>";
	for($minpage;$minpage<=$maxpage;$minpage++):
	if($minpage<=0){
		continue;
	}
	$navi.= "<a";
	if($page == $minpage){
		$navi .= " class='active_page'";
	}
	$navi .=" href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&page=".($minpage)))."'>".$minpage."</a>";
	endfor;
	if($page < $page_count)$navi.= "<a class='main_page_nav_next' href='".runFunc("encrypt_url",array("action=".$action."&method=".$method."&page=".($page+1)))."'></a>";
	$navi .="<a class='page_counter'>".$page_count."</a>";
	$navi .="</div>";

	return $navi;
}

function get_minpage($page,$countpage)
{
	$minpage = $page-5;
	if($page+5 >= $countpage)
	{
		$minpage = $minpage-(5-($countpage-$page));
	}else{
		if($minpage <=1){
			$minpage = 1;
		}
	}
	return $minpage;
}
//取最大页
function get_maxpage($page,$countpage)
{
	$maxpage = $page+5;
	if($page-5 <= 1)
	{
		$maxpage = $maxpage-($page-6);
	}
	if($maxpage >= $countpage)
	{
		$maxpage = $countpage;
	}
	return $maxpage;
}


function getUrlSearch($url,$id){

	$goods = runFunc("checkItemUrl",array($url));
	if(count($goods)>0){

		$result = $goods[0];
		$result["goods_id"] = $goods[0]["goodsid"];
		$result["img"] = $goods[0]["goodsImgURL"];
		$result["title"] = $goods[0]["goodsTitleCN"];
		$result["goodsUnitPrice"] = $goods[0]["goodsUnitPrice"];
		$result["price"] = $goods[0]["goodsUnitPrice"];
	}else{
		$result = GetGoodsInfo($url);

		$img_array = array();
		foreach($result["img"] as $img){
			$img_array[] = $img["url"];

		}

		$nodeId=runFunc('getGlobalModelVar',array('outsideGoodsNode'));
		$node=runFunc('getNodeInfoById',array($nodeId));

		$contentModel=$node["0"]["appTableName"];

		$goods = array(
				"goodsDetail"=>$result["goodsDetail"],
				"goodsTitleCN"=>$result["title"],
				"goodsUnitPrice"=>$result["price"],
				"goodsImgURL"=>$img_array[0],
				"goodsImgURL1"=>$img_array[1],
				"goodsImgURL2"=>$img_array[2],
				"goodsImgURL3"=>$img_array[3],
				"goodsURL"=>$url,
				"click_url" =>$result["click_url"],
				"goodsAddUser"=>$id,
				"props"=>$result["props"],
				"goodsType" =>"outside",
				"goodsStatus"=>"open",
				"nodeId" =>$nodeId,
		);

		$result["goods_id"] =	runFunc('addData',array($nodeId,$contentModel,$goods));

		//$result["goods_id"] = insertSearchGood($result["title"],$result["price"],$img_array[0],$img_array[1],$img_array[2],$img_array[3],$url,$id);
		$result["img"] = $img_array[0];
	}

	return $result;
}

function insertSearchGood($goodsTitleCN,$goodsUnitPrice,$goodsImgURL,$goodsImgURL1,$goodsImgURL2,$goodsImgURL3,$goodsURL,$goodsAddUser){

	$sql = "insert into cms_publish_goods (nodeId,goodsTitleCN,goodsUnitPrice,goodsFreight,goodsImgURL,goodsImgURL1,goodsImgURL2,goodsImgURL3,goodsURL,goodsStatus,goodsType,goodsAddUser)";

	$sql .=" values('GoodsmanagementUkeM','{$goodsTitleCN}','{$goodsUnitPrice}','15','{$goodsImgURL}','{$goodsImgURL1}','{$goodsImgURL2}','{$goodsImgURL3}','{$goodsURL}','Open','outside','{$goodsAddUser}')";
	return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);

}

function getOrderList($id,$page,$size){
	$page = $page * $size - $size;
	$sql = "select * from  {$GLOBALS['table']['publish']['order']} where orderUser = {$id} limit {$page},{$size}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getOrderListGoods($cart_str){
	try
	{
		$sql = "select b.* from  {$GLOBALS['table']['publish']['cart']} as a left join {$GLOBALS['table']['publish']['goods']} as b on a.ItemGoodsID  = b.goodsid  where a.cartID in ({$cart_str})";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		return $result[0];
	} catch (Exception $e)
	{
		throw $e;
	}
}

function getShareList($id,$page,$size){
	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;
	$sql = "select b.* from  {$GLOBALS['table']['publish']['cart']} as a left join {$GLOBALS['table']['publish']['goods']} as b on a.ItemGoodsID  = b.goodsid where UserName = {$id} and ItemStatus = 'Wish' limit {$page},{$size}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function saveShareList($user_id,$categoryID,$title,$description,$privacy,$publish){
	$nodeId = runFunc('getGlobalModelVar',array('shareNode'));
	$dataArray["title"] = $title;
	$dataArray["categoryID"] = $categoryID;
	$dataArray["description"] = $description;
	$dataArray["privacy"] = $privacy;
	$dataArray["publish"] = $publish;
	$dataArray["user_id"] = $user_id;
	$dataArray["created"] = date("Y-m-d H:i:s");
	$dataArray["updateTime"] = time();
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_list (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function saveShareListItem($title,$description,$good_id,$list_id){

	$nodeId = runFunc('getGlobalModelVar',array('shareNode'));
	$dataArray["title"] = $title;
	$dataArray["description"] = $description;
	$dataArray["good_id"] = $good_id;
	$dataArray["list_id"] = $list_id;

	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_share_list_item (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	return $result;
}

function updateShareList($id,$user_id,$categoryID,$title,$description,$privacy,$publish){
	$nodeId = runFunc('getGlobalModelVar',array('shareNode'));
	$dataArray["title"] = $title;
	$dataArray["categoryID"] = $categoryID;
	$dataArray["description"] = $description;
	$dataArray["privacy"] = $privacy;
	$dataArray["publish"] = $publish;
	$dataArray["updateTime"] = time();

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	//print_r($dataArray);
	$sql = "update cms_share_list set $sql where id = {$id} and user_id = {$user_id}";
	//print_r($dataArray);
	//print $sql;exit;
	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}
function updateNewShareList($id,$user_id,$dataArray){


	$nodeId = runFunc('getGlobalModelVar',array('shareNode'));

	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_share_list set $sql where id = {$id} and user_id = {$user_id}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

}

function getMemberShareList($id,$page=1,$size,$count = false){
	if($page <=0){

		$page = 1;
	}
	$page = $page * $size - $size;
	if($count == false){
		$sql = "select * from cms_share_list where user_id = {$id} and status >0 and block = 0 order by created desc limit {$page},{$size}";
	}else{

		$sql = "select count(*) as count from cms_share_list where user_id = {$id} and status >0 and block = 0";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getMemberShareListItem($id,$limit=false){
	if($limit == false){
		$sql = "select a.id as list_item_id, a.title as list_item_title,a.description as list_item_desc ,b.* from cms_share_list_item as a left join {$GLOBALS['table']['publish']['goods']} as b on a.good_id  = b.goodsid where a.list_id = {$id} order by id asc";
	}else{

		$sql = "select a.id as list_item_id, a.title as list_item_title,a.description as list_item_desc ,b.* from cms_share_list_item as a left join {$GLOBALS['table']['publish']['goods']} as b on a.good_id  = b.goodsid where a.list_id = {$id} order by id asc limit 0,{$limit}";
	}
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;

}

function getMemberShareListItemById($id){

	$sql = "select a.id as list_item_id, a.title as list_item_title,a.description as list_item_desc ,b.* from cms_share_list_item as a left join {$GLOBALS['table']['publish']['goods']} as b on a.good_id  = b.goodsid where a.id = {$id}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function deleteMemberShareList($id,$user_id){

	$sql = "delete from cms_share_list where id = '{$id}' and user_id = '{$user_id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	deleteMemberShareListItem($id);
	deleteMemberShareListLove($id);
	if(file_exists("list_merge/80_".$id."_merge.png")){
		unlink("list_merge/80_".$id."_merge.png");
		unlink("list_merge/thumb_".$id."_merge.png");
	}

	return $result;
}

function deleteMemberShareListItem($list_id){

	$sql = "delete from cms_share_list_item where list_id = '{$list_id}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function deleteMemberShareListLove($id,$type){

	$sql = "delete from cms_member_love where love_id = '{$id}' and type = 'STYLE LIST'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

function getShareListByIdAndUser($id,$user_id){
	$sql = "select * from cms_share_list where id = {$id} and user_id = {$user_id} ";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getShareListById($id){
	$sql = "select * from cms_share_list where id = {$id}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function getShareListByUserId($user_id){
	$sql = "select * from cms_share_list where user_id = {$user_id}";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}


function addMemberLove($love_id,$user_id,$type){

	$created = date("Y-m-d H:i:s");

	$check = checkMemberLove($love_id,$user_id,$type);
	if($check["count"]==0){

		$sql = "insert into cms_member_love (love_id,type,user_id,created) values('{$love_id}','{$type}','{$user_id}','{$created}')";

		TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);

	}
	return getShareListLoveCount($love_id,$type);
}

function removeMemberLove($love_id,$user_id,$type){

	$sql = "delete from cms_member_love where love_id = '{$love_id}' and user_id = '{$user_id}' and type = '{$type}'";
	$result = TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);

	return getShareListLoveCount($love_id,$type);
}

function checkMemberLove($love_id,$user_id,$type){

	$sql = "select count(*) as count from cms_member_love where love_id = '{$love_id}' and user_id = '{$user_id}' and type = '{$type}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}

function getShareListLoveCount($love_id,$type){

	$sql = "select count(*) as count from cms_member_love where love_id = '{$love_id}' and type = '{$type}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];

}

function getGoodsById($id){

	$sql = "select * from cms_publish_goods where goodsid = '{$id}'";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result[0];
}

function addItemToList($list_id,$goods_id,$title,$comment){

	$sql = "insert into cms_share_list_item (title,description,good_id,list_id) values('{$title}','{$comment}','{$goods_id}','{$list_id}')";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);

	$items = getMemberShareListItem($list_id);
	foreach($items as $item){

		$img[] = $item["goodsImgURL"];

	}
	makeMergeListImage($list_id,$img);

	return $result;
}

function getStyleListAll($page=1,$size,$sort="id"){
	if($page <=0){
		$page = 1;
	}
	$page = $page * $size - $size;
	$sql = "select c.staffName,c.staffNo,d.real_name,d.first_name,d.last_name,d.show_nick,c.headImageUrl, a.*,(select count(*) from cms_share_list_item where list_id = a.id) as count_items,(select count(*) from cms_member_love where love_id = a.id) as count_love from cms_share_list as a left join cms_member_staff as c on a.user_id = c.staffId left join cms_profile as d on d.user_id = a.user_id where publish = 1 and  privacy = 0 and a.status=1 and a.block =0 and c.block = 0 order by {$sort} desc limit {$page},{$size} ";
	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}
function getStyleListCategory($categoryID='all'){
	if($categoryID='all'){
		$sql = "select * from cms_share_list_category order by id desc";
		$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);
		return $result;
	}
}
function makeMergeListImage($id,$imgs){
	define("COLUMNS", 3);
	define("CSPAN", 10);
	define("RSPAN", 10);
	define("WIDTH", 80);
	define("HEIGHT", 80);
	define("BT", 1);
	define("PAD", 5);

	$base = dirname(__FILE__);

	$images = array();
	$sizes = array();

	for($i=0;$i<9;$i++){


	}

	$i = 1;
	foreach($imgs as $img) {
		if($i>9){

			break;
		}

		$file_name = $img."_310x310.jpg";
		$images[] = $file_name;
		$sizes[$file_name] = getimagesize($file_name);
		$i++;
	}


	$rows = count($images) / COLUMNS;
	$rows = count($images) % COLUMNS == 0? $rows : $rows++;




	$height = 0;
	for($i = 0; $i < $rows; $i++) {
		if($i != 0) {
			$height += RSPAN;
		}
		$w = get_row_width($i, $images, $sizes);
		$width = !isset($width) || $w > $width? $w: $width;
		$height += get_row_height($i, $images, $sizes);
	}

	$picture = ImageCreateTrueColor($width, $height);
	$white = ImageColorAllocate($picture, 255, 255, 255);

	ImageFillToBorder($picture, 0, 0, $white, $white);
	imagecolortransparent($picture, $white);

	$y = 0;
	for($i = 0; $i < $rows; $i++) {
		$x = 0;
		if($i != 0) {
			$y += RSPAN;
		}
		for($j = $i * COLUMNS; $j < ($i+1) * COLUMNS; $j++){
			if(isset($images[$j])){
				if($j > $i * COLUMNS)
					$x += CSPAN;
				$file = $images[$j];
				$detec=getimagesize($file);
				switch($detec["mime"]){
					case "image/jpeg":
						$origin = imagecreatefromjpeg($file); //jpeg file
						break;
					case "image/gif":
						$origin = imagecreatefromgif($file); //gif file
						break;
					case "image/png":
						$origin = imagecreatefrompng($file); //png file
						break;
				}

				$paint = resize_image($origin, $sizes[$file], WIDTH - 2*BT - 2*PAD, HEIGHT -2*BT - 2*PAD);
				$border = draw_border($paint, 230, 230, 230);

				imagecopymerge($picture, $border, $x, $y, 0, 0, WIDTH, HEIGHT, 100);
				$x += WIDTH;
				imagedestroy($origin);
				imagedestroy($border);
				imagedestroy($paint);
			}
		}
		$y += get_row_height($i, $images, $sizes);
	}

	imagepng($picture,"list_merge/80_".$id."_merge.png");
	imagedestroy($picture);
	make_thumb("list_merge/80_".$id."_merge.png",$id);

}

function make_thumb($filename,$id){


	list($width, $height) = getimagesize($filename);
	$newwidth = 65;
	$newheight = $height * (65/$width);

	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$source = imagecreatefrompng($filename);

	// Resize
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	// Output
	imagepng($thumb,"list_merge/thumb_".$id."_merge.png");
	imagedestroy($thumb);
}

function draw_border($image, $r = 255, $g = 255, $b = 255, $br = 255, $bg = 255, $bb = 255) {
	$w = imagesx($image);
	$h = imagesy($image);
	$ret = ImageCreateTrueColor($w + 2*BT + 2*PAD, $h + 2*BT + 2*PAD);
	$color = ImageColorAllocate($ret, $r, $g, $b);
	$bc = ImageColorAllocate($ret, $br, $bg, $bb);
	ImageFillToBorder($ret, 0, 0, $color, $color);
	imagefilledrectangle($ret, BT, BT, $w + 2*PAD, $h + 2*PAD, $bc);
	imagecopymerge($ret, $image, BT + PAD, BT + PAD, 0, 0, $w, $h, 100);
	return $ret;
}

function get_row_height($i, $images, $sizes) {
	return HEIGHT;
}

function get_row_width($i, $images, $sizes) {
	return WIDTH * COLUMNS + (COLUMNS - 1) * CSPAN;
}


function resize_image($image, $size, $w, $h) {
	$ret = ImageCreateTrueColor($w, $h);

	// Make return image transparent
	$white = ImageColorAllocate($ret, 255, 255, 255);
	ImageFillToBorder($ret, 0, 0, $white, $white);
	imagecolortransparent($ret, $white);

	if($size[0] < $w) {
		if($size[1] < $h) { // Little than the scale, not scaling
			ImageCopyResampled($ret, $image, ($size[0] - $w)/2, ($size[1] - $h)/2, 0, 0, $size[0], $size[1], $size[0], $size[1]);
		}
		else { // Higher than return, scale height
			$scale = $h/$size[1];
			$sw = $size[0] * $scale;
			ImageCopyResampled($ret, $image, ($w - $sw)/2, 0, 0, 0, $sw, $h, $size[0], $size[1]);
		}
	}
	else {
		if($size[1] < $h) { // Wider than return, but not higher, scale width
			$scale = $w/$size[0];
			$sh = $size[1] * $scale;
			ImageCopyResampled($ret, $image, 0, ($h - $sh)/2, 0, 0, $w, $sh, $size[0], $size[1]);
		}
		else {
			$sx = $w/$size[0];
			$sh = $h/$size[1];
			if($sx > $sh) { // Tall
				$scale = $sh;
				$sw = $size[0] * $scale;
				ImageCopyResampled($ret, $image, ($w - $sw)/2, 0, 0, 0, $sw, $h, $size[0], $size[1]);
			}
			else { // Wide
				$scale = $sx;
				$sh = $size[1] * $scale;
				ImageCopyResampled($ret, $image, 0, ($h - $sh)/2, 0, 0, $w, $sh, $size[0], $size[1]);
			}
		}
	}
	return $ret;
}
?>
