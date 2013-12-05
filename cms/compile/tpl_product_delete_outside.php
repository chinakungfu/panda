<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){

	$page = 1;
}
$id = $this->_tpl_vars["IN"]["id"];
$file = $this->_tpl_vars["IN"]["file"];
$delete_type = $this->_tpl_vars["IN"]["delete_type"];

runFunc("makeBatchDeleteLog",array($delete_type,$id));
switch ($delete_type){

	case "brand":
		runFunc("deleteBrand",array($id));

		if(file_exists("brand_logo/brand_".$id.".".$this->_tpl_vars["IN"]["file_type"]))unlink("brand_logo/brand_".$id.".".$this->_tpl_vars["IN"]["file_type"]);
		header("Location: ".runFunc('encrypt_url',array('action=cms&method=brands&type=products')));
		break;
	case "brand_batch":

		runFunc("deleteBrandBatch",array($id));
		$ids = explode(",", $id);
		$files = explode(",", $file);
		foreach($ids as $key=>$id){
			echo "brand_logo/brand_".$id.".".$files[$key];
			if(file_exists("brand_logo/brand_".$id.".".$files[$key]))unlink("brand_logo/brand_".$id.".".$files[$key]);
		}
		break;
	case "tag_categoty":
		runFunc("deleteItem",array("cms_product_tag_category",$id));

		header("Location: ".runFunc('encrypt_url',array('action=cms&method=tag_categories&type=products')));
		break;

	case "tag":
		runFunc("deleteItem",array("cms_product_tag",$id));
		header("Location: ".runFunc('encrypt_url',array('action=cms&method=tag_list&type=products')));
		break;

	case "prop":
		runFunc("deleteItem",array("cms_product_prop",$id));
		runFunc("deletePropValues",array($id));
		header("Location: ".runFunc('encrypt_url',array('action=cms&method=prop_list&type=products')));
		break;

	case "product_category":
		runFunc("deleteItem",array("cms_product_category",$id));
		header("Location: ".runFunc('encrypt_url',array('action=cms&method=product_category_list&type=products')));
		break;

	case "goods":

		runFunc("deleteGoods",array($id));
		header("Location: ".runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products&page='.$page)));
		break;

	case "coupons":

		runFunc("deleteCoupons",array($id));
		header("Location: ".runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products')));
		break;

	case "users":

		runFunc("adminDeleteUser",array($id));
		header("Location: ".runFunc('encrypt_url',array('action=cms&method=users&type=users')));
		break;
	case "managers":

		runFunc("adminDeleteUser",array($id));
		header("Location: ".runFunc('encrypt_url',array('action=cms&method=managers&type=main')));
		break;

	case "comments":

		runFunc("adminCommentDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=comment_list&type=share')));
		break;

	case "comments_final":

		runFunc("commentDeleteFinal",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=comment_recycle&type=share')));
		break;

	case "comments_back_to_list":
		runFunc("commentBackToList",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=comment_recycle&type=share')));
		break;

	case "circles":
		runFunc("adminCircleDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_list&type=share')));
		break;

	case "circles_final":
		runFunc("adminCircleDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_recycle&type=share')));
		break;

	case "circles_back_to_list":
		runFunc("circleBackToList",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_recycle&type=share')));
		break;

	case "circle_post":
		runFunc("adminCirclePostDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share')));
		break;

	case "circle_post_back_to_list":
		runFunc("circlePostBackToList",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_post_recycle&type=share')));
		break;

	case "circle_post_final":
		runFunc("circlePostDeleteFinal",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_post_recycle&type=share')));
		break;

	case "circle_category":
		runFunc("circleCategoryDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_category&type=share')));
		break;

	case "style_list":
		runFunc("adminstyleListDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=style_list&type=share')));
		break;

	case "style_list_back_to_list":
		runFunc("styleListBackToList",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=style_list_recycle&type=share')));
		break;

	case "style_list_final":
		runFunc("styleListDeleteFinal",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=style_list_recycle&type=share')));
		break;

	case "poll":
		runFunc("adminPollDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=poll_list&type=share')));
		break;

	case "poll_back_to_list":
		runFunc("pollBackToList",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=poll_recycle&type=share')));
		break;

	case "poll_final":
		runFunc("pollDeleteFinal",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=poll_recycle&type=share')));
		break;

	case "member_event":
		runFunc("memberEventDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=member_event_list&type=share')));
		break;

	case "member_event_back_to_list":
		runFunc("memberEventBackToList",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=member_event_recycle&type=share')));
		break;

	case "member_event_final":
		runFunc("memberEventFinal",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=member_event_recycle&type=share')));
		break;

	case "event":
		runFunc("memberEventDelete",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=eventList&type=share')));
		break;

	case "event_back_to_list":
		runFunc("memberEventBackToList",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=event_recycle&type=share')));
		break;

	case "event_final":
		runFunc("memberEventFinal",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=event_recycle&type=share')));
		break;

	case "advertising":
		runFunc("deleteAdvertising",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=advertising_list&type=media')));
		break;

	case "custom_page":
		runFunc("deleteCustomPage",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media')));
		break;

	case "manager_permission":
		runFunc("deleteManagerPermission",array($id));
		header("Location:".runFunc('encrypt_url',array('action=cms&method=manager_permission_list&type=main')));
		break;

	case "brand_category":
		runFunc("deleteBrandCategory",array($id));

		header("Location:".runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products')));
		break;

	case "brand_tag":

		runFunc("deleteBrandTag",array($id));

		header("Location:".runFunc('encrypt_url',array('action=cms&method=brand_tag_list&type=products')));
		break;

}