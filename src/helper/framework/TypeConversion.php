<?php
/**
 * Created by PhpStorm.
 * User: LXZ
 * Date: 2020/6/23
 * Time: 10:42
 */

namespace Helper\Framework;


class TypeConversion
{
    /**
     * 递归方式对象转数组
     * @param object 对象
     * @return array 数组
     */
    public static function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)self::object_to_array($v);
            }
        }
        return $obj;
    }
    /**
     * 递归方式数组转对象
     * @param array 数组
     * @return object 对象
     */
    public static function array_to_object($arr) {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)self::array_to_object($v);
            }
        }
        return (object)$arr;
    }
}
