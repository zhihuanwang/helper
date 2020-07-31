<?php
/**
 * Created by PhpStorm.
 * User: LXZ
 * Date: 2020/7/30
 * Time: 13:39
 */

namespace Test;


use Helper\File\File;
use Helper\Framework\Math;
use Helper\Framework\UuidHelper;

class FunctionTest
{
    /**
     * 阶乘计算测试
     */
    public function index()
    {
        foreach (range(1, 10) as $value) {
            echo Math::factorial($value) . '<br>';
        }
    }

    /**
     * zip解压测试
     * @throws \Exception
     */
    public function unzip()
    {
        $savePath = './' . UuidHelper::generate()->string;
        if (!is_dir($savePath)) {
            mkdir(iconv("UTF-8", "GBK", $savePath),0755,true);
        }
        $res = File::uploadZipFile('D:\phpStudy\PHPTutorial\WWW\VodUploadSDK-PHP_1.0.2.zip', $savePath);
        print_r($res);
    }
}
