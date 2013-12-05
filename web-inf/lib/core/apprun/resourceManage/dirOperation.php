<?php

class Html
{
    var $dir;        //文件存放目录，目录名(不带/)
    var $rootdir;    //html文件存放根目录，目录名(不带/)
    var $name;       //html文件存放路径
    var $dirname;    //指定的文件夹名称

    function createdir($dir='')
    {
        $this->dir=$dir?$dir:$this->dir;

        if (!is_dir($this->dir))
        {
            $temp = explode('/',$this->dir);
            $cur_dir = '';
            for($i=0;$i<count($temp);$i++)
            {
                $cur_dir .= $temp[$i].'/';
                //if (!is_dir($cur_dir))
                //{
                	@mkdir($cur_dir,0777);
                //}
            }
        }
    }


    function createhtml($url='',$content,$type='w')
    {
        $this->name = basename($url);
        $this->dir = dirname($url);

        $this->createdir();

        $fp=@fopen($url,$type) or die("Failed to open the file ".$url." !");
        if(@fwrite($fp,$content))
        return true;
        else
        return false;
        fclose($fp);
    }

    function deletehtml($url='')
    {
        $this->url=$url?$url:$this->url;

        if(@unlink($this->url))
        return true;
        else
        return false;
    }

    /**
     * function::deletedir()
     * 删除目录
     * @param $file 目录名(不带/)
     * @return
     */
     function deletedir($file)
     {
        if(file_exists($file))
        {
            if(is_dir($file))
            {
                $handle =opendir($file);
                while(false!==($filename=readdir($handle)))
                {
                    if($filename!="."&&$filename!="..")
                      $this->deletedir($file."/".$filename);
                }
                closedir($handle);
                rmdir($file);
                return true;
            }else{
                unlink($file);
            }
        }
    }

}
?>