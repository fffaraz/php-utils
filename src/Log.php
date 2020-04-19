<?php

namespace fffaraz\Utils;

class Log
{
    public static function message($message = '', $category = 'default', $ignoreAdmin = true)
    {
        $log = [
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'category' => $category,
            'message' => is_string($message) ? $message : json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            'ip' => \Request::ip(),
            'agent' => \Request::header('User-Agent'),
        ];
        \Illuminate\Support\Facades\Redis::publish('log', print_r($log, true));
        if ($ignoreAdmin && \Illuminate\Support\Facades\Auth::id() == 1) return;
        if (class_exists('\Debugbar')) \Debugbar::disable();
        \App\Models\Log::Create($log);
    }

    public static function exception(\Exception $e, $category = 'default')
    {
        echo 'Caught exception: ', $e->getMessage(), "\n";
        \App\Models\Log::Create([
            'category' => $category . ':exception',
            'message' => $e->__toString(),
        ]);
    }
}
