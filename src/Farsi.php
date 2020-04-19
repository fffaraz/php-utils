<?php

namespace fffaraz\Utils;

class Farsi
{
    public static function number($text)
    {
        $numbers = [
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
            '0' => '۰',
        ];
        return str_replace(array_keys($numbers), array_values($numbers), $text);
    }

    public static function clean($text)
    {
        // https://mothereff.in/utf-8
        // https://github.com/mathiasbynens/mothereff.in/tree/master/utf-8
        $text = strtolower($text);
        // $text = str_replace('ي', 'ی', $text);
        // $text = str_replace('ك', 'ک', $text);
        $characters = [
            'ك' => 'ک',
            'دِ' => 'د',
            'بِ' => 'ب',
            'زِ' => 'ز',
            'ذِ' => 'ذ',
            'شِ' => 'ش',
            'سِ' => 'س',
            'ى' => 'ی',
            'ي' => 'ی',
            '١' => '۱',
            '٢' => '۲',
            '٣' => '۳',
            '٤' => '۴',
            '٥' => '۵',
            '٦' => '۶',
            '٧' => '۷',
            '٨' => '۸',
            '٩' => '۹',
            '٠' => '۰',
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
            '0' => '۰',
        ];
        $text = str_replace(array_keys($characters), array_values($characters), $text);
        $text = trim($text);
        $text = String::mb_trim($text, '،');
        $text = String::mb_trim($text, '؟');
        $text = trim($text);
        return $text;
    }
}
