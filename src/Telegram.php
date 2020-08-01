<?php

namespace fffaraz\Utils;

class Telegram
{
    public static function api($token = '')
    {
        if (strlen($token) > 0)
            return new \Telegram\Bot\Api($token);
        else
            return new \Telegram\Bot\Api();
    }

    public static function message($chat_id, $text)
    {
        return Telegram::api()->sendMessage([
            'chat_id' => $chat_id,
            'text'    => $text,
            'disable_web_page_preview' => true,
        ]);
    }

    public static function markdown($chat_id, $text)
    {
        return Telegram::api()->sendMessage([
            'chat_id' => $chat_id,
            'text'    => $text,
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
        ]);
    }

    public static function photo($chat_id, $text, $filename)
    {
        return Telegram::api()->sendPhoto([
            'chat_id' => $chat_id,
            'caption' => $text,
            'photo'   => \Telegram\Bot\FileUpload\InputFile::create($filename, 'photo.png'),
        ]);
    }
}
