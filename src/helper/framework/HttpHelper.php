<?php
/**
 * Created by PhpStorm.
 * User: LXZ
 * Date: 2020/6/28
 * Time: 11:21
 */

namespace Helper\Framework;

/**
 * 封装Http请求类
 * Class HttpHelper
 * @package Helper\Framework
 */
class HttpHelper
{
    static $sslOptions = [
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ];

    /**
     * @param $url
     * @param array $params
     * @param array $headers
     * @return bool|string
     */
    public static function httpGet($url, $params = [], $headers=null)
    {
        if (!empty($params)) {
            $query_string = http_build_query($params);
            $url = strpos($url, '?') ? $url . '&' . $query_string : $url . '?' . $query_string;

        }
        if(empty($headers)) {
            $headers[] = 'Content-type: application/x-www-form-urlencoded';
        }

        $opts = array(
            'http' => array(
                'ignore_errors' => true,
                'method' => 'GET',
                'header' => $headers,
                'content' => ''
            )
        );
        if(strpos(strtolower($url), 'https') !== false) {
            $opts['ssl'] = self::$sslOptions;
        }

        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return bool|string
     */
    public static function httpPost($url, $data, $headers=null)
    {
        if(empty($headers)) {
            $headers[] = 'Content-type: application/x-www-form-urlencoded';
        }
        if(self::isJsonRequest($headers)) {
            $post_data = json_encode($data);
        }
        else {
            $post_data = http_build_query($data);
        }
        $opts = array(
            'http' => array(
                'ignore_errors' => true,
                'method' => 'POST',
                'header' => $headers,
                'content' => $post_data
            )
        );
        if(strpos(strtolower($url), 'https') !== false) {
            $opts['ssl'] = self::$sslOptions;
        }
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    /**
     * json格式发送请求
     * @param $url
     * @param $data
     * @param null $headers
     * @return bool|string
     */
    public static function postJson($url, $data, $headers=null) {
        if(empty($headers) || !in_array('Content-type: application/json', $headers)) {
            $headers[] = 'Content-type: application/json';
        }

        return self::httpPost($url, $data, $headers);
    }

    /**
     * json格式发送请求
     * @param $url
     * @param $data
     * @param null $headers
     * @return bool|string
     */
    public static function getJson($url, $data, $headers=null) {
        if(empty($headers) || !in_array('Content-type: application/json', $headers)) {
            $headers[] = 'Content-type: application/json';
        }
        return self::httpGet($url, $data, $headers);
    }

    public static function isJsonRequest($headers) {
        foreach ($headers as $k => $header) {
            if(strpos(strtolower($header), 'application/json') !== false) {
                return true;
            }
        }
        return false;
    }
}
