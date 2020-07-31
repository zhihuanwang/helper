<?php
/**
 * Created by PhpStorm.
 * User: LXZ
 * Date: 2020/7/30
 * Time: 13:39
 */

namespace Test;


use Helper\Framework\Math;

class FunctionTest
{
    public function index()
    {
        foreach (range(1, 10) as $value) {
            echo Math::factorial($value) . '<br>';
        }
    }
}
