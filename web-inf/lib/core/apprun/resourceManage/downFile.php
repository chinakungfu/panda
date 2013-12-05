<?
function downFile($fileDir,$fileName)
{
	//$fileDir = getResourceInfoById($resourceId);
	$fileNameData = pathinfo($fileDir);
	if (!file_exists($fileDir)) { //检查文件是否存在
		echo "文件找不到";
		exit;
	} else {
		$file = fopen($fileDir,"rb"); // 打开文件
		// 输入文件标签
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: ".filesize($fileDir));
		Header("Content-Disposition: attachment; filename=" . $fileName.'.'.$fileNameData['extension']);
		// 输出文件内容
		echo fread($file,filesize($fileDir));
		fclose($file);
		exit;
	}
}
?>