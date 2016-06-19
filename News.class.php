<?php

header("Content-type:text/html;charset=utf-8");

/**
 * Created by PhpStorm.
 * User: zdc
 * Date: 6/19/16
 * Time: 11:45 AM
 */
class News
{
    private $_url = 'http://apis.baidu.com/txapi/social/social';
    private $_header = array('apikey: 01a24c0bb4aef2f6ec728501231ac4f5');

    public function getNews($data){
        $paramArray = array(
            'num'=>$data['num'],
            'page'=>$data['page']
        );

        $params = http_build_query($paramArray);

       // echo $params;
        $content = $this->curl_request($this->_url,$params);

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
              //  echo $url.'?'.$params;
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

$obj = new News();
$data = array(
    'num'=>3,
    'page'=>1
);
$res = $obj->getNews($data);
var_dump($res);