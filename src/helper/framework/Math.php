<?php
/**
 * Created by PhpStorm.
 * User: LXZ
 * Date: 2020/7/31
 * Time: 14:48
 */

namespace Helper\Framework;


/**
 * 数学计算工具类
 * Class Math
 * @package Helper\Framework
 */
class Math
{
    /**
     * 递归计算阶乘
     * @param integer $number
     */
    public static function factorial($number)
    {
        return ($number > 1) ? $number * self::factorial($number - 1) : $number;
    }
    /**
     * TODO 生成随机数的几种方法
     */
}
