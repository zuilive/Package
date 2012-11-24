<?php
/*	计算两个文件的相对位置
 * Created on 2012-10-24
 *
 * By zuihuanxiang@gmail.com
 * Last change 2012-10-24
 */
?>
<?php
//计算c.php相对于e.php的相对路径应该是../../12/34

$a = '/a/b/c/d/e.php';
$b = '/a/b/12/34/c.php';
getpathinfo($a, $b);

	function getpathinfo( $a, $b ) {
		$a2array = explode('/', $a);
		$b2array = explode('/', $b);
		$pathinfo = '';
		for( $i = 1; $i <= count($b2array)-2; $i++ ) {
		$pathinfo.=$a2array[$i] == $b2array[$i] ? '../' : $b2array[$i].'/';
	}

print_r($pathinfo);

}

?>
