<?php import('core.util.RunFunc'); ?>
<?php
	$upload_file=$_FILES["upload_file"]["name"];        //获取文件名
	$upload_tmp_file=$_FILES["upload_file"]["tmp_name"];      //获取临时文件名
	$upload_filetype=$_FILES["upload_file"]["type"];    //获取文件类型
	$upload_status=$_FILES["upload_file"]["error"];   //获取文件出错情况

	$num = $this->_tpl_vars["photoNum"];

	$upload_dir="upload/return/";
	switch($upload_status)
	    {
	        case 0:$result = 'error';//echo " ";break;
	        case 1:$result = 'error';//echo "上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。";break;
	        case 2:$result = 'error';//echo "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。";break;
	        case 3:$result = 'error';//echo "文件只有部分被上传。";break;
	        case 4:$result = 'error';//echo "没有文件被上传。";break;
	        case 6:$result = 'error';//echo "没有找到临时文件目录。";break;
	        case 7:$result = 'error';//echo "文件写入失败。";break;
	    }                   //分析文件出错情况并给出提示
	$errorchar=array ("-"," ","~","!","@","#","$","%","^","&","(",")","+",",","（","）","？","！","“","”","《","》","：","；","
	——");
	                                                  //定义非法字符集
	foreach($errorchar as $char)
	{
	    if(strpos($upload_file,$char))
		{
			$upload_file=str_replace($char,"_",$upload_file);
			$result = 'error';//echo "文件名中含有非法字符！已经替换为\"_\"<br>";
		}
	} //循环排除替换文件名中的非法字符


$date = date("YmdHis");
$upload_path=$upload_dir.$upload_files=$date.$upload_file;   //定义文件最终的存储路径和名称
//echo $upload_path."<br>";
if(is_uploaded_file($upload_tmp_file) )
{

   if(file_exists($upload_path)){
   	 	$result = 'error';//echo "同名文件已经存在，请修改你要上传的文件名！"; //检查是否有相同文件存在
   }else if(move_uploaded_file($upload_tmp_file,$upload_path)){
	 	$result = '<div class="returnimgshow"><img id="img'.$num.'" src="'.$upload_dir.$upload_files.'" width="70px" height="70px" /><span onclick="delimg(this,'.$num.');" class="returndelimg">Delete</span></div>';
   }else{
   		$result = 'error';//echo "文件上传失败。";
   }
}
	echo $result;
?>