<?php

namespace fffaraz\Utils;

class Helper
{
    public static function get_ip()
    {
        $list = ['HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        foreach ($list as $key)
        {
            if (array_key_exists($key, $_SERVER) === true)
            {
                foreach (explode(',', $_SERVER[$key]) as $ip)
                {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                    {
                        return $ip;
                    }
                }
            }
        }
    }

    public static function trimDate($date, $trim = 0)
    {
        switch ($trim)
        {
            case 1:
                return date('Y-m-d H:00:00', strtotime(strval($date)));
            case 2:
                return date('Y-m-d 00:00:00', strtotime(strval($date)));
            default:
                return date('Y-m-d H:i:s', strtotime(strval($date)));
        }
    }

    public static function readFile($path)
    {
        $content = file_get_contents($path);
        $lines = preg_split('/\r\n|\r|\n/', $content, -1, PREG_SPLIT_NO_EMPTY);
        return $lines;
    }
}
