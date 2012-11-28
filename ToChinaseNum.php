<?php
/*
 * 将阿拉伯数字转换为中文数字
 * Created on 2012-11-28
 *
 * By zuihuanxiang@gmail.com
 * Last change 2012-11-28
 */

function ToChinaseNum($num)
{
    $char = array("零","一","二","三","四","五","六","七","八","九");
    $dw = array("","十","百","千","万","亿","兆");
    $retval = "";
    $proZero = false;
    for($i = 0;$i < strlen($num);$i++)
    {
        if($i > 0)    $temp = (int)(($num % pow (10,$i+1)) / pow (10,$i));
        else $temp = (int)($num % pow (10,1));

        if($proZero == true && $temp == 0) continue;

        if($temp == 0) $proZero = true;
        else $proZero = false;

        if($proZero)
        {
            if($retval == "") continue;
            $retval = $char[$temp].$retval;
        }
        else $retval = $char[$temp].$dw[$i].$retval;
    }
    if($retval == "一十") $retval = "十";
    return $retval;
}


echo ToChinaseNum("1254");

?>
