<?php  
function get_file($url,$folder,$pic_name){
	set_time_limit (24 * 60 * 60);
	$destination_folder = $folder?$folder.'/':'';//文件下载保存目录
	$newfname = $destination_folder .$pic_name;
	$file = fopen ($url, "rb");
	if ($file) {
		$newf = fopen ($newfname, "wb");
		if ($newf)
		while(!feof($file)) {
			fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
		}
	}
	if ($file) {
		fclose($file);
	}
	if ($newf) {
		fclose($newf);
	}
}
//$md5fileName = md5(date("Ymd His").random2(4));
get_file("http://www.baidu.com/img/baidu_logo.gif","","sdfsfdsf.jpg");
?> 