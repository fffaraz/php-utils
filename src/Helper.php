<?php

namespace fffaraz\Utils;

class Helper
{
    public static function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public static function get_ip()
    {
        $list = ['HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        foreach($list as $key)
        {
            if(array_key_exists($key, $_SERVER) === true)
            {
                foreach(explode(',', $_SERVER[$key]) as $ip)
                {
                    $ip = trim($ip); // just to be safe
                    if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                    {
                        return $ip;
                    }
                }
            }
        }
    }
}
