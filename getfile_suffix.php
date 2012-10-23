<?php
/*
*	获取文件后缀名的三种方法
*	zuihuanxiang@gmail.com
*/
?>

<?php
	//方法一	用strrpos()函数查找最后出现"."的位置，然后用substr()函数截取后半部分的文件格式
	function getfile_suffix_1($file_name){
		$retval="";
		$pt=strrpos($file_name,".");
		if($pt) $retval=substr($file_name,$pt+1,strlen($file_name)-$pt);
		return $retval;
	}
	
	//方法二	使用函数pathinfo()，将文件的信息以数组形式返回
	function getfile_suffix_2($file_name){
		$extend = pathinfo($file_name);
		$extend = strtolower($extend["extension"]);
		return $extend;
	}
	
	//方法三	用正则表达式以"."为分隔符进行截取，然后获取最后一个数组的值就是文件后缀名
	function getfile_suffix_3($file_name){
		$extend = explode(".",$file_name);
		$va=count($extend)-1;
		return $extend[$va];
	}
	
	$file_name="a.dgfrc.txt";
	echo getfile_suffix_3($file_name);
?>