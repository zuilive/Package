<?php
	class file_dir
	{
		function check_exist($filename)		//检查目录或文件是否存在
		{
			if(file_exists($filename))
			{
				return true;
			}
			else	return false;
		}

		function create_dir($dirname,$mode=0777)	// 一次只能创建一级目录
		{
			if(is_null($dirname) || $dirname=="")	return false;
			if(!is_dir($dirname))
			{
				return mkdir($dirname,$mode);
			}
		}

		function createDir($aimUrl)		//可同时创建多级目录
		{
        	$aimUrl = str_replace('\\', '/', $aimUrl);
        	$aimDir = '';
        	$arr = explode('/', $aimUrl);
        	foreach ($arr as $str)
        	{
            	$aimDir .= $str . '/';
            	if (!file_exists($aimDir))
            	{
                	mkdir($aimDir);
            	}
        	}
    	}

		function delete_dir($dirname)		//删除目录
		{
			if($this->check_exist($dirname) and is_dir($dirname))
			{
				if(!$dirhandle=opendir($dirname)) return false;
				while(($file=readdir($dirhandle))!==false)
				{
					if($file=="." or $file=="..")	continue;
					$file=$dirname.DIRECTORY_SEPARATOR.$file;  //表示$file是$dir的子目录
					if(is_dir($file))
					{
						$this->delete_dir($file);
					}
					else
					{
						unlink($file);
					}
				}
				closedir($dirhandle);
				return rmdir($dirname);
			}
			else	return false;
		}

		function copy_dir($dirfrom,$dirto)		//复制目录
		{
			if(!is_dir($dirfrom))	return false;
			if(!is_dir($dirto))		mkdir($dirto);
			$dirhandle=opendir($dirfrom);
			if($dirhandle)
			{
				while(false!==($file=readdir($dirhandle)))
				{
					if($file=="." or $file=="..")	continue;
					$filefrom=$dirfrom.DIRECTORY_SEPARATOR.$file;  //表示$file是$dir的子目录
					$fileto=$dirto.DIRECTORY_SEPARATOR.$file;
					if(is_dir($filefrom))
					{
						$this->copy_dir($filefrom,$fileto);
					}
					else
					{	if(!file_exists($fileto))
						copy($filefrom,$fileto);
					}
				}
			}
			closedir($dirhandle);
		}

		function getdir_size($dirname)		//获取目录大小
		{
			if(!file_exists($dirname) or !is_dir($dirname))	 return false;
			if(!$handle=opendir($dirname)) 	return false;
			$size=0;
			while(false!==($file=readdir($handle)))
			{
				if($file=="." or $file=="..")	continue;
				$file=$dirname."/".$file;
				if(is_dir($file))
				{
					$size+=$this->getdir_size($file);
				}
				else
				{
					$size+=filesize($file);
				}

			}
			closedir($handle);
			return $size;
		}

		function getReal_size($size)	   // 单位自动转换函数
		{
			$kb=1024;
			$mb=$kb*1024;
			$gb=$mb*1024;
			$tb=$gb*1024;
			if($size<$kb)	return $size."B";
			if($size>=$kb and $size<$mb)	return round($size/$kb,2)."KB";
			if($size>=$mb and $size<$gb)	return round($size/$mb,2)."MB";
			if($size>=$gb and $size<$tb)	return round($size/$gb,2)."GB";
			if($size>=$tb)	return round($size/$tb,2)."TB";
		}

		function copy_file($srcfile,$dstfile)
		{
			if(is_file($srcfile))
			{
				if(!file_exists($dstfile))
				return copy($srcfile,$dstfile);
			}
			else	return false;
		}

   	 	function unlink_file($filename)		//删除文件
   	 	{
   	 		if($this->check_exist($filename) and is_file($filename))
   	 		{
   	 			return unlink($filename);
   	 		}
   	 		else	return false;
   	 	}

   	 	function getsuffix($filename)			//获取文件名后缀
   	 	{
   	 		if(file_exists($filename) and is_file($filename))
   	 		{
   	 			return end(explode(".",$filename));
   	 		}
   	 	}

   	 	function input_content($filename,$str)		//将字符串写入文件
   	 	{
   	 		if(function_exists(file_put_contents))
   	 		{
   	 			file_put_contents($filename,$str);
   	 		}
   	 		else
   	 		{
   	 			$fp=fopen($filename,"wb");
   	 			fwrite($fp,$str);
   	 			fclose($fp);
   	 		}
   	 	}

   	 	function output_content($filename)			//将整个文件内容读出到一个字符串中
   	 	{
   	 		if(function_exists(file_get_contents))
   	 		{
   	 			return file_get_contents($filename);
   	 		}
   	 		else
   	 		{
   	 			$fp=fopen($filename,"rb");
   	 			$str=fread($fp,filesize($filename));
   	 			fclose($fp);
   	 			return $str;
   	 		}
   	 	}

   	 	function output_to_array($filename)		//将文件内容读出到一个数组中
   	 	{
   	 		$file=file($filename);
   	 		$arr=array();
   	 		foreach($file as $value)
   	 		{
   	 			$arr[]=trim($value);
   	 		}
   	 		return $arr;
   	 	}


	}
	//$dir=new file_dir;
	//$size=$dir->getdir_size("F:/wamp/www/class/images");
	//echo $dir->getReal_size($size);


?>



