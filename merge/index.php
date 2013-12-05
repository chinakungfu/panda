<?php

$imgs = array(

		"0"=>"http://img03.taobaocdn.com/bao/uploaded/i3/T1jxYBXeRnXXX9MdMZ_031733.jpg",
		"1"=>"http://img03.taobaocdn.com/bao/uploaded/i3/T1enaHXh0zXXc_M6I__110107.jpg"
		
		);
makeMergeListImage($imgs);

function makeMergeListImage($imgs){
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
	$white = ImageColorAllocate($picture, 0, 0, 0);

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

	header('Content-Type: image/jpeg');
	imagepng($picture);

	imagedestroy($picture);
	
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
