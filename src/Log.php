<?php

namespace fffaraz\Utils;

class Log
{
    public static function log($category = 'default', $message = '', $exception = null, $ignoreAdmin = true, $chatId = null)
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        if (!is_string($category)) $category = 'invalid';
        if (!is_string($message)) $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        else if (strlen($message) < 1) $message = null;
        if ($exception != null) {
            echo 'Caught exception: ', $exception->getMessage(), "\n";
            $exception = $exception->__toString();
        }
        $log = [
            'user_id' => $userId,
            'category' => $category,
            'ip' => \Request::ip(),
            'message' => $message,
            'path' => \Request::path(),
            'agent' => strval(\Request::header('User-Agent')),
            'referer' => strval(\Request::server('HTTP_REFERER')),
            'exception' => $exception,
        ];
        \Illuminate\Support\Facades\Redis::publish('log', print_r($log, true));
        if ($exception != null && $ignoreAdmin && $userId == 1) return $log;
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
