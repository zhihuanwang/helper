<?php

namespace Helper\Framework;
use think\Db;
use think\Env;

class DatabaseTools
{
    /**
     * 导出数据库文档说明， 在public目录输出markdown文件
     */
    public static function dumpDatabaseDescription($databaseName = null)
    {
        if (null == $databaseName) {
            $databaseName = Env::get('database.database', 'live_freebd_cn');
        }
//        $sql = 'SHOW TABLES';
        $sql = "SELECT TABLE_NAME,
               table_comment
        FROM `information_schema`.tables
        WHERE table_schema='$databaseName'";
        $tableRes = Db::query($sql);
        if (0 == count($tableRes)) {
            echo '没有数据表';
        }
        $databaseString = "# $databaseName <font color=#DC143C size=4 >数据库说明</font>\n[TOC]\n";
        foreach ($tableRes as $value) {
//            $tableName = $value['Tables_in_live_freebd_cn'];
            $tableName = $value['TABLE_NAME'];
            $tableDesc = $value['table_comment'];
//            $tableComm = "### $tableName   $\color{#DC143C}{$tableDesc}$ \n";
            $tableComm = "### $tableName   <font color=#0099ff size=3 >$tableDesc</font> \n";
//            $tableComm = "### $tableName   $tableDesc \n";
            $tableHeader = "| 列名 | 数据类型 | 长度 | 是否为空 | 默认值 | 备注 |\n";
            $tableString = $tableComm .  $tableHeader . "| ---- | -------- | ---- | -------- | ------ | ---- |\n";

            $sub_sql = "SELECT
          COLUMN_NAME 列名,
          COLUMN_TYPE 数据类型,
        --         DATA_TYPE 字段类型,
          CHARACTER_MAXIMUM_LENGTH 长度,
          IS_NULLABLE 是否为空,
          COLUMN_DEFAULT 默认值,
          COLUMN_COMMENT 备注
        FROM
         INFORMATION_SCHEMA.COLUMNS
        where
        -- developerclub为数据库名称，到时候只需要修改成你要导出表结构的数据库即可
        table_schema ='$databaseName'
        AND
        -- article为表名，到时候换成你要导出的表的名称
        -- 如果不写的话，默认会查询出所有表中的数据，这样可能就分不清到底哪些字段是哪张表中的了，所以还是建议写上要导出的名名称
        table_name  = '$tableName'";
            $res = Db::query($sub_sql);
            if (count($res) == 0) {
                echo '没有字段';
            }
            foreach ($res as $value) {
                foreach ($value as $vvalue) {
                    $tableString .= "|  " . $vvalue;
                }
                $tableString = $tableString . "  |\n";
            }
            $databaseString .= $tableString ;
        }
        file_put_contents("{$databaseName} 数据库说明.md", $databaseString);
        echo "{$databaseName}数据库导出完成，请检查public目录下的文件";
    }
}