<?php

function haowan_page($page_num,$current_page,$send_var)
{

	if($page_num == '' || $page_num==1)
	return false;
	$header = floor(($current_page - 1)/10);

	$start = $header*10 + 1;
	//$send_var = str_replace("{ChannelID}", $ChannelID,$send_var);

	for($i= $start;$i<=$start + 9;$i++)
	{
		$link = str_replace("{Page}", $i,$send_var);

		if($current_page == $i)
		{
			$page.= '<span class="current">'.$i.'</span>&nbsp;';
		}
		else
		{
			$page.= "<a href='".$link."'>".$i."</a>&nbsp;";
		}
		if($i==$page_num) break;
	}

	if ($current_page < $page_num)
	{
		$link1= str_replace("{Page}", $current_page+1 ,$send_var);
		$page = $page . "&nbsp;<b><a href='".$link1."' >下一页</a></b>";
	}

	if($current_page > 1) {
		if(($current_page-1) == 0)
		$link1 = str_replace("{Page}", 0,$send_var);
		else
		$link1= str_replace("{Page}" , $current_page-1 ,$send_var);
		$page= "<b><a href='".$link1."' >上一页</a></b>&nbsp;&nbsp;".$page;
	}



	if((($start + 10)) <= $page_num) {
		$i =  $start + 10;
		$link = str_replace("{Page}", $i,$send_var);
		$page= $page."&nbsp;&nbsp;<b><a href='".$link."' >下十页</a></b>";
	}

	if(($start - 1) > 0)
	{
		$i =  $start - 10;
		$link = str_replace("{Page}", $i,$send_var);
		$page= "<b><a href='".$link."' >上十页</a></b>&nbsp;&nbsp;".$page;
	}

	return $page;

}


?>