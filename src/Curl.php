<?php

namespace fffaraz\Utils;

class Curl
{
    public static function get($url)
    {
        /*
        $ctx = stream_context_create(array('http'=>
            array(
                'timeout' => 10,
            )
        ));
        file_get_contents($url, false, $ctx)
        */

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);

        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    public static function post($url, $fields = [], $referer = '')
    {
        $curl = curl_init();
        if(count($fields) > 0) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if(strlen($referer) > 0) curl_setopt($curl, CURLOPT_REFERER, $referer);
        $result = curl_exec($curl);
        curl_close($curl);
        if(!$result) return false;
        return $result;
    }
}
