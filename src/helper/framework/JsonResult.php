<?php

namespace Helper\Framework;

class JsonResult
{
    /*
     * @purpose   自定义ajax返回函数 执行该数据输出函数之后，会终止代码（一般建议在调试时使用）
     * @author drzhong2015@gmail.com
     * @date  2019/4/29 14:22
     * @access  public
     * @param
     * @return
     */
    public static function ReturnAjax($code, $msg, &$array=null)
    {
        if(empty($code)) {
            $return_array= ['code' => 200,'data' => $array, 'msg' => '获取数据成功','time' => time()];
        }else{
            $return_array = ['code' => $code,'data' => $array,'msg' =>$msg,'time' => time()];
        }
        header('Content-type:text/json');
        header("Access-Control-Allow-Origin: *");
        echo json_encode($return_array,JSON_UNESCAPED_UNICODE);die;
    }

    /**
     * ajax 返回错误
     * @param $message
     * @param string $error_code
     * @param string $data
     * @return \think\response\Json
     */
    public static function jsonFailed($message, $error_code = '', $data = '')
    {
        return self::jsonResult(false, $data, $message, $error_code);
    }

    /**
     *  ajax 返回成功
     * @param null $data
     * @param string $message
     * @param string $redirect_url 跳转url
     * @return \think\response\Json
     */
    public static function jsonSuccess($data = null, $message = '', $redirect_url='')
    {
        return self::jsonResult(true, $data, $message, '', $redirect_url);
    }

    /**
     * 返回ajax结果 执行该输出函数不会终止代码，但需要依赖于ThinkPHP5.0版本及以上
     * @param $success
     * @param null $data
     * @param string $message
     * @param string $error_code
     * @param string $redirect_url
     * @return \think\response\Json
     */
    public static function jsonResult($success, $data = null, $message = '', $error_code = '', $redirect_url='')
    {
        $res = [
            'success' => $success,
            'message' => $message,
            'error_code' => $error_code
        ];
        $res['data'] = $data ?: new \stdClass();
        if($redirect_url) {
            $res['redirect_url'] = $redirect_url;
        }
        return json($res);
    }
}