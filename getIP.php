<?php
/*
 * 获取客户的ip地址，通过百度或123cha查询地址所在地点
 * Created on 2012-10-24
 *
 * By zuihuanxiang@gmail.com
 * Last change 2012-10-24
 *
 */
?>
<?php
//设置页面编码为utf-8
header('Content-type: text/html; charset=utf-8');

//获取客户端ip
function getClientIP()
{
    if ($_SERVER["HTTP_X_FORWARDED_FOR"])
    {
        if ($_SERVER["HTTP_CLIENT_IP"])
        {
                $proxy = $_SERVER["HTTP_CLIENT_IP"];
        }
        else
        {
            $proxy = $_SERVER["REMOTE_ADDR"];
        }
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    else
    {
        if ($_SERVER["HTTP_CLIENT_IP"])
        {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else
        {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
    }
    return $ip;
}

//从123查获取ip
function getIpfrom123cha($ip) {
    $url = 'http://www.123cha.com/ip/?q='.$ip;
        $content = file_get_contents($url);
        $preg = '/(?<=本站主数据:<\/li><li style=\"width:450px;\">)(.*)(?=<\/li>)/isU';
        preg_match_all($preg, $content, $mb);
        $str = strip_tags($mb[0][0]);
        //$str = str_replace(' ', '', $str);
        $address = $str;
        if($address == '') {
            $address = '未明';
        }
    return $address;
}

//从百度获取ip所在地
function getIpfromBaidu($ip) {
    $url = 'http://www.baidu.com/s?wd='.$ip;
    $content = file_get_contents($url);
    $preg = '/(?<=<p class=\"op_ip_detail\">)(.*)(?=<\/p>)/isU';
    preg_match_all($preg, $content, $mb);
    $str = strip_tags($mb[0][1]);
    $str = str_replace(' ', '', $str);
    $address = substr($str, 31);
    if($address == '') {
        $address = '未明';
    }
    return $address;
}

	$ip=getClientIP();
	echo $ip."<br>".getIpfromBaidu($ip)."<br>".getIpfrom123cha($ip);

?>