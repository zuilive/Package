<?php
/**
* 页面作用：常用表单验证类
* 作 者：欣然随风
* 建立时间：2006-3-6
* QQ：276624915
*/
class class_post
{
//验证是否为指定长度的字母/数字组合

function fun_text1($num1,$num2,$str)
{
     Return (preg_match("/^[a-zA-Z0-9]{".$num1.",".$num2."}$/",$str))?true:false;
}

//验证是否为指定长度数字

function fun_text2($num1,$num2,$str)
{
     return (preg_match("/^[0-9]{".$num1.",".$num2."}$/i",$str))?true:false;
}
//验证是否为指定长度汉字

function fun_font($num1,$num2,$str)
{
// preg_match("/^[\xa0-\xff]{1,4}$/", $string);

    return (preg_match("/^([\x81-\xfe][\x40-\xfe]){".$num1.",".$num2."}$/",$str))?true:false;
}
//验证身份证号码

function fun_status($str)
{
     return (preg_match('/(^([\d]{15}|[\d]{18}|[\d]{17}x)$)/',$str))?true:false;
}

//验证邮件地址

function fun_email($str){
     return (preg_match('/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/',$str))?true:false;
}
//验证电话号码

function fun_phone($str)
{
   return (preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/",$str))?true:false;
}
//验证邮编

function fun_zip($str)
{
   return (preg_match("/^[1-9]\d{5}$/",$str))?true:false;
}
//验证url地址

function fun_url($str)
{
   return (preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/",$str))?true:false;
}

// 数据入库 转义 特殊字符 传入值可为字符串 或 一维数组

function data_join(&$data)
{
   if(get_magic_quotes_gpc() == false)
   {
    if (is_array($data))
    {
     foreach ($data as $k => $v)
     {
     $data[$k] = addslashes($v);
     }
    }
    else
    {
    $data = addslashes($data);
    }
   }
   Return $data;
}

// 数据出库 还原 特殊字符 传入值可为字符串 或 一/二维数组

function data_revert(&$data)
{
   if (is_array($data))
   {
    foreach ($data as $k1 => $v1)
    {
     if (is_array($v1))
     {
      foreach ($v1 as $k2 => $v2)
      {
      $data[$k1][$k2] = stripslashes($v2);
      }
     }
     else
     {
     $data[$k1] = stripslashes($v1);
     }
    }
   }
   else
   {
   $data = stripslashes($data);
   }
   Return $data;
}

// 数据显示 还原 数据格式 主要用于内容输出 传入值可为字符串 或 一/二维数组

// 执行此方法前应先data_revert()，表单内容无须此还原

function data_show(&$data)
{
   if (is_array($data))
   {
    foreach ($data as $k1 => $v1)
    {
     if (is_array($v1))
     {
      foreach ($v1 as $k2 => $v2)
      {
      $data[$k1][$k2]=nl2br(htmlspecialchars($data[$k1][$k2]));
      $data[$k1][$k2]=str_replace(" "," ",$data[$k1][$k2]);
      $data[$k1][$k2]=str_replace("\n","<br>\n",$data[$k1][$k2]);
      }
     }
     else
     {
     $data[$k1]=nl2br(htmlspecialchars($data[$k1]));
     $data[$k1]=str_replace(" "," ",$data[$k1]);
     $data[$k1]=str_replace("\n","<br>\n",$data[$k1]);
     }
    }
   }
   else
   {
   $data=nl2br(htmlspecialchars($data));
   $data=str_replace(" "," ",$data);
   $data=str_replace("\n","<br>\n",$data);
   }
   Return $data;
}
}
?>


