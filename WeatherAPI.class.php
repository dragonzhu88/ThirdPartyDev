<?php

/**
 * Created by PhpStorm.
 * User: zdc
 * Date: 16-6-17
 * Time: 下午5:00
 */

header("Content-type:text/html;charset=utf-8");

//$ch = curl_init();
//$url = 'http://apis.baidu.com/apistore/weatherservice/citylist?cityname=%E6%9C%9D%E9%98%B3';
//$header = array(
//    'apikey: 01a24c0bb4aef2f6ec728501231ac4f5',
//);
//// 添加apikey到header
//curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//// 执行HTTP请求
//curl_setopt($ch , CURLOPT_URL , $url);
//$res = curl_exec($ch);
//
//var_dump(json_decode($res));


class Weather
{
    private $_weatherUrl = 'http://apis.baidu.com/apistore/weatherservice/citylist';
    private $_header = array('apikey: 01a24c0bb4aef2f6ec728501231ac4f5');

    public function getWeather($cityName){
        $paramArray = array(
            'cityname'=>$cityName
        );

        $params = http_build_query($paramArray);
        $content = $this->curl_request($this->_weatherUrl,$params);

        return json_decode($content);
    }


    public function curl_request($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER  , $this->_header);
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
               
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
}

$weatherObj = new Weather();
$res = $weatherObj->getWeather('深圳');
var_dump($res);
