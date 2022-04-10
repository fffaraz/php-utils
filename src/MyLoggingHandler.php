<?php

namespace fffaraz\Utils;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class MyLoggingHandler extends AbstractProcessingHandler
{
    protected function write(array $record): void
    {
        // dd($record);
        $data = [
            'message'       => $record['message'],
            'context'       => json_encode($record['context']),
            'level'         => $record['level'],
            'level_name'    => $record['level_name'],
            'channel'       => $record['channel'],
            'record_datetime' => $record['datetime']->format('Y-m-d H:i:s'),
            'extra'         => json_encode($record['extra']),
            'formatted'     => $record['formatted'],
            'remote_addr'   => $_SERVER['REMOTE_ADDR'],
            'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
            'created_at'    => date("Y-m-d H:i:s"),
        ];
        \App\Models\Log::Create($data);
    }
}
// https://sergeyzhuk.me/2016/07/30/laravel-logging-to-db/
// https://github.com/markhilton/monolog-mysql
