<?php
header("Content-type:text/html;charset=utf-8");
/**
 * Created by PhpStorm.
 * User: zdc
 * Date: 16-6-18
 * Time: 下午11:57
 */
class Robot
{
    private $_url = 'http://apis.baidu.com/turing/turing/turing';
    private $_header = array('apikey: 01a24c0bb4aef2f6ec728501231ac4f5');
    private $_key = '2bfc042724b9c5dcd444797c7bb79363';

    public function contactRobotMsg($userMsg){
        $paramArray = array(
            'key'=>$this->_key,
            'info'=>$userMsg['info'],
            'userid'=>$userMsg['userid']
        );

        $params = http_build_query($paramArray);
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

$ipAddressObj = new Robot();
$userMsg = array(
    'info'=>'你爸爸是谁',
    'userid'=>'eb2edb736'
);
$res = $ipAddressObj->contactRobotMsg($userMsg);
var_dump($res);