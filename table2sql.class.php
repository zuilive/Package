<?php
/******   备份数据库结构 ******/
/****正好要研究如何备份数据库，分享一个php实现MYSQL备份的类库(转)********/
      /*
      函数名称：table2sql()
      函数功能：把表的结构转换成为SQL
      函数参数：$table: 要进行提取的表名
      返 回 值：返回提取后的结果，SQL集合
      函数作者：heiyeluren
      */
  
     function table2sql($table)
      {
          global $db;
         $tabledump = "DROP TABLE IF EXISTS $table;\n";
         $createtable = $db->query("SHOW CREATE TABLE $table");
         $create = $db->fetch_row($createtable);
         $tabledump .= $create[1].";\n\n";
          return $tabledump;
      }
  
  
     /****** 备份数据库结构和所有数据 ******/
      /*
      函数名称：data2sql()
      函数功能：把表的结构和数据转换成为SQL
      函数参数：$table: 要进行提取的表名
      返 回 值：返回提取后的结果，SQL集合
      函数作者：heiyeluren
      */
     function data2sql($table)
      {
          global $db;
         $tabledump = "DROP TABLE IF EXISTS $table;\n";
         $createtable = $db->query("SHOW CREATE TABLE $table");
         $create = $db->fetch_row($createtable);
         $tabledump .= $create[1].";\n\n";
  
         $rows = $db->query("SELECT * FROM $table");
         $numfields = $db->num_fields($rows);
         $numrows = $db->num_rows($rows);
          while ($row = $db->fetch_row($rows))
          {
             $comma = "";
             $tabledump .= "INSERT INTO $table VALUES(";
              for($i = 0; $i < $numfields; $i++)
              {
                 $tabledump .= $comma."'".mysql_escape_string($row[$i])."'";
                 $comma = ",";
              }
             $tabledump .= ");\n";
          }
         $tabledump .= "\n";
  
          return $tabledump;
      }
?>

