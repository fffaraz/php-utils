<?php

namespace fffaraz\Utils;

class Log
{
    public static function log($category = 'default', $message = '', $exception = null, $ignoreAdmin = true, $chatId = null)
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        if (!is_string($category)) $category = json_encode($category, JSON_UNESCAPED_UNICODE);
        if (!is_string($message)) $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        if ($exception != null) {
            echo 'Caught exception: ', $exception->getMessage(), "\n";
            $exception = $exception->__toString();
        }
        $ip = \Request::ip();
        $path = \Request::path();
        $agent = strval(\Request::header('User-Agent'));
        $referer = strval(\Request::server('HTTP_REFERER'));
        $log = [
            'user_id' => $userId,
            'category' => $category,
            'ip' => strlen($ip) > 0 ? $ip : null,
            'message' => strlen($message) > 0 ? $message : null,
            'path' => strlen($path) > 0 ? $path : null,
            'agent' => strlen($agent) > 0 ? $agent : null,
            'referer' => strlen($referer) > 0 ? $referer : null,
            'exception' => $exception,
        ];
        \Illuminate\Support\Facades\Redis::publish('log', print_r($log, true));
        if ($exception == null && $ignoreAdmin && $userId == 1) return $log;
        if (class_exists('\Debugbar')) \Debugbar::disable();
        \App\Models\Log::Create($log);
        if ($chatId != null) {
            $telegram = new \Telegram\Bot\Api();
            $response = $telegram->sendMessage([
                'chat_id' => $chatId,
                'text'    => json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'disable_web_page_preview' => true,
                // 'parse_mode' => 'html',
            ]);
        }
        return $log;
    }
}
