<?php

function show_message($url,$type = 'js')
{
	if($type == 'header')
	{
		header("location:" . $url);
		exit;
	}
	elseif($type == 'js')
	{
		echo "<script>document.location='" . $url . "'\n" . "</script>";
		exit;
	}

}


function DownloadFile($file,$filename) { // $file = include path
	if(file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	}

}

function makename( $length )
{
	$possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$str = "";
	while ( strlen( $str ) < $length )
	{
		$str .= substr( $possible, rand( ) % strlen( $possible ), 1 );
	}
	return $str;
}

?>