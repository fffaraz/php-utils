<?php

namespace fffaraz\Utils;

class ExceptionHandler
{
    public static function render($request, $exception)
    {
        if (class_exists('\Debugbar')) \Debugbar::disable();
        // if (\Illuminate\Support\Facades\Auth::id() != 1) \Debugbar::disable();

        if($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
        {
            $message = $request->fullUrl() . "\t";
            $message .= $request->ip() . "\t";
            $message .= $request->header('User-Agent') . "\n";
            file_put_contents('/app/storage/logs/log-notfound-' . date('Y-m-d') . '.txt', $message, FILE_APPEND | LOCK_EX);
        }
        else
        {
            $category = explode('\\', get_class($exception));
            \App\Models\Log::Create([
                // 'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'category' => 'ExceptionHandler:' . $category[array_key_last($category)],
                'message'  => $exception->__toString(),
                'ip'       => $request->ip(),
                'agent'    => $request->header('User-Agent'),
                'path'     => $request->fullUrl(),
            ]);
        }
    }
}
