<?php import('core.util.RunFunc'); 
require 'uploader.php';

$allowedExtensions = array();

$sizeLimit = 10 * 1024 * 1024;

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

$result = $uploader->handleUpload('../circles_img/');

echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);







?>